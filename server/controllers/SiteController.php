<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use app\models\Product;
use app\models\Catalog;
use app\models\Brand;
use app\models\CatalogSearch;
use app\models\ProductSearch;
use Yii\helpers\ArrayHelper;
use app\controllers\bases\CorsController;

class SiteController extends CorsController
{
    public function actionHome()
    {
        $popular = [];
        $products = Product::find()->where(['popular' => 1])->All();

        foreach ($products as $key => $product) {
            $popular[$key]['product'] = $product;
            $popular[$key]['brand'] = $product->brand;
            $popular[$key]['preview'] = $product->getCollections()->where(['type' => 'preview-image'])->one();
        }

        return [
            'popular' => $popular,
            'brands' => Brand::find()->where(['status' => 1])->all()
        ];
    }

    public function actionCategories()
    {
        $categories = [];

        foreach (Catalog::find()->where(['parent_id' => NULL])->All() as $key => $item) {
            $categories[$key]['parent'] = $item;
            $categories[$key]['childs'] = $item->getChilds()->where(['status' => 1])->all();
        }

        return [
            'categories' => $categories
        ];
    }

    public function actionFilter()
    {
        return [
            'brands' => ArrayHelper::toArray(Brand::find()->where(['status' => 1])->All(), [
                'app\models\Brand' => [
                   'value' => 'id',
                   'text' => 'name'                    
                ]
            ]),
            'minPrice' => 10,
            'maxPrice' => 10000,
        ];
    }

    public function actionCatalog()
    {
        $products = [];
        $catalogParams = [];
        $productParams = [];
        $catalogParams['CatalogSearch']['alias'] = Yii::$app->request->get('alias');
        $productParams['ProductSearch']['brands'] = Yii::$app->request->get('brands');
        $productParams['ProductSearch']['minPrice'] = Yii::$app->request->get('minPrice');
        $productParams['ProductSearch']['maxPrice'] = Yii::$app->request->get('maxPrice');        

        if (!empty($catalogParams['CatalogSearch']['alias']))  {
            $query = (new CatalogSearch)->search($catalogParams)->one(); 
            $productParams['ProductSearch']['catalog_id'] = $query->id;
        } 

        $dataProvider = (new ProductSearch)->search($productParams);
        $dataProvider->pagination->pageSize = 21;
        
        foreach ($dataProvider->getModels() as $key => $model) {
            $products[$key]['product'] = $model;
            $products[$key]['preview'] = $model->getCollections()
                ->where(['type' => 'preview-image'])->one();
        }
       
        $pagination = new Pagination([
            'totalCount' => $dataProvider->query->count(),
            'defaultPageSize' => $dataProvider->pagination->pageSize
        ]);
        
        return [
            'pagination' => $pagination,
            'products' => $products
        ];
    }

    public function actionProduct($alias)
    {
        $product = Product::find()->where(['alias' => $alias])->one();
        return [
            'product' => $product,
            'brand' => $product->brand,
            'catalog' => $product->catalog,
            'collections' => $product->getCollections()
                ->where(['type' => 'image'])->all(),
            'preview' => $product->getCollections()->select('id')
                ->where(['type' => 'preview-image'])->one()
        ];
    }

    public function actionProducts()
    {
        $basket = json_decode(Yii::$app->request->getBodyParam('basket'), true);

        if (!empty($basket)) {
            $ids = [];

            foreach ($basket as $item) {
                $ids = $item['pid'];
            }
        }
        
        $products = Product::find()
            ->select('id,price, name')
            ->where(['id' => $ids])
            ->all();
        
        foreach ($products as $key => $product) {
            $popular[$key]['product'] = $product;
            $popular[$key]['brand'] = $product->brand;
            $popular[$key]['preview'] = $product->getCollections()->where(['type' => 'preview-image'])->one();
        }

        return [
            'products' => $products
        ];
    }
}
