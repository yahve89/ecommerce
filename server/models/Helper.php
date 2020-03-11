<?php 

namespace app\models;

use Yii;

/**
 * Класс ыспомогательных методов
 */
class Helper
{
    /**
     * Получить расширение изображения
     * @return string
     */
    public static function getExp($src)
    {
        $re = '/(?:.jpg|.jpeg|.png|.svg)/m';
        preg_match_all($re, $src, $matches, PREG_SET_ORDER, 0);
        return $matches[0][1] ?? $matches[0][0];
    }

    /**
     * Создает дирикторию
     * @return type
     */
    public static function mkDir($dirName = NULL)
    {
        if (!file_exists(Yii::getAlias('@upload')))
                mkdir(Yii::getAlias('@upload'), 0777, true);
            
        if (!file_exists(Yii::getAlias('@upload') .$dirName) and !empty($dirName))
            mkdir(Yii::getAlias('@upload') .$dirName, 0777, true);
    }
}