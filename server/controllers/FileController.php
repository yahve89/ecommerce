<?php

namespace app\controllers;

use Yii;
use WideImage\WideImage;
use app\models\Helper;
use app\models\Collection;

class FileController extends \yii\web\Controller
{
    /**
     * Метод возвращает изображение.
     */
    public function actionImage($cid, $wh = false)
    {
        switch ($wh) {
            case '150_150':
                $width = 150; 
                $height = 150;
                break;

            case '390_390':
                $width = 390; 
                $height = 390;
                break;    

            case '280_280':
                $width = 280; 
                $height = 280;
                break;    
                
            case '60_60':
                $width = 60; 
                $height = 60;
                break;   
            
            default:
                $width = 650; 
                $height = 650;
                break;
        }

        $collection = Collection::find()
            ->where(['id' => $cid])
            ->andWhere(['type' => ['preview-image', 'image']])
            ->one();

        if (is_null($collection))
            exit();

        $image = new WideImage;
        $image = $image->load(Yii::getAlias('@upload') .$collection->value);
        
        if ($image->getWidth() > $image->getHeight()) {
            $image = $image->resize($width, $height);
        } else {
            $image = $image->resize(null, $height);
        }

        $base = new WideImage;
        $base = $base->createTrueColorImage($width, $height);
        $base->fill(0, 0, $base->allocateColor(255, 255, 255));
        $base->merge($image, 'center', 'center', 100)->output('png');
        exit();
    }
}
