<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "collection".
 *
 * @property int $id
 * @property int $product_id
 * @property string $type
 * @property string|null $value
 * @property string|null $prop
 *
 * @property Product $product
 */
class Collection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'collection';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'type'], 'required'],
            [['product_id'], 'integer'],
            [['type'], 'string', 'max' => 180],
            [['prop', 'value'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'type' => 'Type',
            'value' => 'Value',
            'prop' => 'Prop',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
