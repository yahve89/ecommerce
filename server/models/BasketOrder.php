<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "basket_order".
 *
 * @property int $id
 * @property int $basket_id
 * @property int $product_id
 * @property int $amount
 *
 * @property Basket $basket
 */
class BasketOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'basket_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['basket_id', 'product_id', 'amount'], 'required'],
            [['basket_id', 'product_id', 'amount'], 'integer'],
            [['basket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Basket::className(), 'targetAttribute' => ['basket_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'basket_id' => 'Basket ID',
            'product_id' => 'Product ID',
            'amount' => 'Amount',
        ];
    }

    /**
     * Gets query for [[Basket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBasket()
    {
        return $this->hasOne(Basket::className(), ['id' => 'basket_id']);
    }
}
