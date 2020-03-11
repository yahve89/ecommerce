<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use Sunra\PhpSimple\HtmlDomParser;
use WideImage\WideImage;
use app\models\Parser;
use app\models\Brand;
use app\models\Catalog;
use app\models\Product;
use app\models\Collection;
use app\models\Helper;

class ParserController extends Controller
{
    /* Количество скопированного */
    private $amountCopys = 0;
    /* Количество созданого */
    private $amountCreate = 0;
    
    /**
     * Клонирование товаров
     * @param $copyPrevImg Обновлять превью фото (по умолчанию выключено)
     */
    public function actionProduct($copyPrevImg = false)
    { 
        $parser = Parser::init();
       
        foreach (Brand::find()->all() as $brand) {
            $lastPage = $this->countPages('/brands/', $brand->alias);
            $lastPage++;

            for ($i = 1; $i < $lastPage; $i++) {
                $data = $parser->setBaseUri('https://cosmopark24.ru')
                    ->setMethod('GET')
                    ->setPath('/brands/' .$brand->alias .'/?PAGEN_1=' .$i)
                    ->execute();
                

                $content = $data->client->getBody()->getContents();
                $dom = HtmlDomParser::str_get_html($content);

                if (count($dom->find('.errortext', 0)) <> 0)
                    continue;

                if($dom->innertext != '' and count($text = $dom->find('.products-list', 0))) {

                    foreach ($text->find('.products-item') as $key => $item) {
                        $a = $item->find('a', 0);
                        $img = $a->find('img', 0);
                        $btn = $item->find('a.product-cart-btn', 0);                                        
                        $product = Product::find()->where([
                            'alias' => str_replace('/', '', $a->href)
                        ])->one();

                        if (empty($product)) {
                            $this->amountCreate++;
                            $product = new Product;
                        }

                        $product->brand_id = $brand->id;
                        $product->alias = str_replace('/', '', $a->href);
                        $product->name = $btn->attr['data-name'];

                        if ($product->save()) {
                            $this->amountCopys++;                    
                            
                            if ($copyPrevImg == true)
                                $this->copyImage($product->id, 'product', 'preview-image', $img->src);
                        }
                    }
                }   
            }
        }

        echo "Создано новых: {$this->amountCreate} \n";
        echo "Обновлено: {$this->amountCopys} \n"; 
    }

    /**
     * получить количество страниц
     * @return type
     */
    private function countPages($dir, $alias)
    {
        $parser = Parser::init();
        $data = $parser->setBaseUri('https://cosmopark24.ru')
            ->setMethod('GET')
            ->setPath($dir .$alias .'/?PAGEN_1=1')
            ->execute();
        $content = $data->client->getBody()->getContents();
        $dom = HtmlDomParser::str_get_html($content);

        if($dom->innertext != '' and count($text = $dom->find('.bx-pagination-container ul', 0))) {
            $temp = [];

            foreach ($text->find('li a') as $a) {
                $temp[] = explode('=', $a->href)[1];
            }
            
            asort($temp);
            return (int) array_pop($temp);
        }

        return 1;
    }

    /**
     * Обновить все товары
     */
    public function actionUpdateProduct($id = 1)
    {
        $page404 = 0;
        $parser = Parser::init();
        $products = Product::find()->where('id >= :id', [':id' => $id])->all();

        foreach ($products as $product) {
            $data = $parser->setBaseUri('https://cosmopark24.ru')
                ->setMethod('GET')
                ->setPath('/' .$product->alias .'/')
                ->execute();

            $content = $data->client->getBody()->getContents();

            $dom = HtmlDomParser::str_get_html($content);

            if (($status = $data->client->getStatusCode()) == 404) {
                $product->status = $status;
                
                if ($product->save())
                    $page404++;
                
                continue;
            }

            if($dom->innertext != '' and count($text = $dom->find('.bx-catalog-element', 0))) {
                if (!empty($price = $text->find('div.product-item-detail-price-current', 0)))
                    $product->price = preg_replace('/[^0-9]/', '', $price->plaintext);

                $category = $text->find('.product__category-link', 0);

                 if (!empty($category->href))
                    if (!empty($catalog_id = $this->findCatalog(str_replace('/', '', $category->href))))
                        $product->catalog_id = $catalog_id;
                
                $description = '';

                foreach ($text->find('#nav-description p') as $p) {
                    $description .= $p->plaintext;
                    $description .= '</br>';
                }

                $product->status = $status;
                $product->description = $description;
                $composition = $text->find('#nav-composition',0);
                $product->composition = str_replace(';', ';<br>', trim($composition->plaintext));
                $mode_of_application = $text->find('#nav-use', 0);
                $product->mode_of_application = $mode_of_application->plaintext;

                if ($product->save())
                    $this->amountCopys++;
            }
        }

        echo "Обновлено: {$this->amountCopys} \n"; 
    }

    /**
     * Клонирование всех колекций, фото товаров
     */
    public function actionCollection($id = 1)
    {
        $parser = Parser::init();
        $products = Product::find()->where('id >= :id', [':id' => $id])->all();
       
        foreach ($products as $product) {
            $data = $parser->setBaseUri('https://cosmopark24.ru')
                ->setMethod('GET')
                ->setPath('/' .$product->alias .'/')
                ->execute();

            $content = $data->client->getBody()->getContents();
            $dom = HtmlDomParser::str_get_html($content);

            if ($btn = $dom->find('a.product-item-detail-buy-button_to-cart', 0))
                $this->udpateCollection($product->id, 'link-to-cart', NULL, $btn->attr['data-link']);

            if($dom->innertext != '' and count($items = $dom->find('.product-item-detail-slider-image'))) {
                foreach ($items as $item) {
                    $img = $item->find('img', 0);
                    $this->copyImage($product->id, 'product', 'image', $img->src);
                }
            }
        }

        echo "Обновлено: {$this->amountCopys} \n"; 
    }

    /**
     * Метод копирования изображений
     * @param int $pid ptoduct id
     * @param string $dir dir root
     * @param string $prefix name prefix 
     * @param string $src relative path source
     */
    private function copyImage($pid, $dir, $prefix, $src)
    {
        Helper::mkDir('/' .$dir .'/' .$pid);
        $exp = Helper::getExp($src);
        $pathImg = '/' .$dir .'/' .$pid .'/' .$prefix .'-' .md5($src) .$exp;
        $source =  'https://cosmopark24.ru' .$src;
        $dest = Yii::getAlias('@upload') .'/' .ltrim($pathImg, '/');

        $data = Parser::init()->setBaseUri('https://cosmopark24.ru')
            ->setMethod('GET')
            ->setPath($src)
            ->execute();

        if ($data->client->getStatusCode() == 404) {
            $product = Product::find()->where('id >= :id', [':id' => $pid])->one();
            $product->status = 404;
            $product->save();
        } else {
            if (copy($source, $dest))
                $this->udpateCollection($pid, $prefix, $pathImg);
        }       
    }

    /**
     * добовляет или обновляет запись в колекции
     */
    private function udpateCollection($pid, $type, $value, $prop = NULL)
    {
        $collection = Collection::find()->where([
            'product_id' => $pid,
            'type' => $type,
            'value' => $value,
            'prop' => $prop
        ])->one();
        
        if (empty($collection))
            $collection = new Collection;

        $collection->product_id = $pid;
        $collection->type = $type;
        $collection->value = $value;

        if ($prop !== NULL)
            $collection->prop = $prop;

        $collection->save();
    }

    /**
     * Клонирование каталога
     */
    public function actionCatalog()
    {    
        $parser = Parser::init();
        $data = $parser->setBaseUri('https://cosmopark24.ru')
            ->setMethod('GET')
            ->execute();

        $content = $data->client->getBody()->getContents();
        $dom = HtmlDomParser::str_get_html($content);

        if($dom->innertext != '' and count($text = $dom->find('.catalog-menu', 0))) {
            foreach ($text->find('.catalog-menu__main') as $key => $item) {
                if ($name = $item->find('.catalog-menu__title', 0)) {
                    $parent = Catalog::find()->where([
                        'name' => $name->plaintext,
                        'parent_id' => NULL,
                        'alias' => NULL
                    ])->one();

                    if (empty($parent)) {
                        $this->amountCreate++;
                        $parent = new Catalog;
                    }

                    $parent->name = $name->plaintext;

                    if ($parent->save())
                        $this->amountCopys++;
                }

                foreach ($item->find('a') as $a) {
                    $model = Catalog::find()->where([
                        'name' => $a->plaintext,
                        'parent_id' => $parent->id,
                        'alias' => str_replace('/', '', str_replace('_', '-', $a->href))
                    ])->one();

                    if (empty($model)) {
                        $this->amountCreate++;
                        $model = new Catalog;
                    }

                    $model->parent_id = $parent->id;
                    $model->name = $a->plaintext;
                    $model->alias = str_replace('/', '', str_replace('_', '-', $a->href));

                    if ($model->save())
                        $this->amountCopys++;
                }
            }
        }

        echo "Создано новых: {$this->amountCreate} \n";
        echo "Обновлено: {$this->amountCopys} \n";
   }

    /**
     * Клонирование брендов
     * @param int $page Пагинация
     */
    public function actionBrand($page = 1)
    {
        Helper::mkDir('brand/');
        $parser = Parser::init();
        $data = $parser->setBaseUri('https://cosmopark24.ru')
            ->setMethod('GET')
            ->setPath('/brands/?PAGEN_1='.$page)
            ->execute();

        $content = $data->client->getBody()->getContents();
        $dom = HtmlDomParser::str_get_html($content);

        if($dom->innertext != '' and count($text = $dom->find('.brands-list', 0))) {
            foreach ($text->find('.brand-item') as $key => $item) {
                $img = $item->find('img', 0);
                $exp = Helper::getExp($img->src);
                $pathImg = '/brand/' .str_replace(' ', '_', $img->alt) .$exp;
                $source = $parser->baseUri .$img->src;
                $dest = Yii::getAlias('@upload') .'/' .ltrim($pathImg, '/');

                if (copy($source, $dest)) {
                    $model = Brand::find()->where([
                        'name' => $img->alt,
                        'img' => $pathImg
                    ])->one();

                    if (empty($model)) {
                        $this->amountCreate++;
                        $model = new Brand;
                    }

                    $model->name = $img->alt;
                    $model->img = $pathImg;
                    $model->alias = str_replace('.', '', str_replace(' ', '-', 
                        rtrim(mb_strtolower($img->alt), '+')));

                    if ($model->save())
                        $this->amountCopys++;
                }
            }
        }

        echo "Создано новых: {$this->amountCreate} \n";
        echo "Обновлено: {$this->amountCopys} \n";
    }

    /**
     * Получить расширение изображения
     * @return catalog_id
     */
    private function findCatalog($alias)
    {
        $catalog = Catalog::find()->where(['alias' => str_replace('_', '-', $alias)])->one();
        
        if (!empty($catalog))
            return $catalog->id;

        return NULL;
    }
}
