<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int|null $brand_id
 * @property int|null $catalog_id
 * @property string|null $alias
 * @property string|null $name
 * @property string|null $price
 * @property int $markup
 * @property string|null $description
 * @property string|null $composition
 * @property string|null $mode_of_application
 * @property int|null $popular
 * @property int|null $status
 *
 * @property Collection[] $collections
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'catalog_id', 'markup', 'popular', 'status'], 'integer'],
            [['alias', 'description', 'composition', 'mode_of_application'], 'string'],
            [['name'], 'string', 'max' => 180],
            [['price'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'catalog_id' => 'Catalog ID',
            'alias' => 'Alias',
            'name' => 'Name',
            'price' => 'Price',
            'markup' => 'Markup',
            'description' => 'Description',
            'composition' => 'Composition',
            'mode_of_application' => 'Mode Of Application',
            'popular' => 'Popular',
            'status' => 'Status'
        ];
    }

    /**
     * Gets query for [[Collections]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCollections()
    {
        return $this->hasMany(Collection::className(), ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Catalog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
}
