<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "basket".
 *
 * @property int $id
 * @property int $user_id
 * @property string $status
 * @property string $date_create
 *
 * @property User $user
 * @property BasketOrder[] $basketOrders
 */
class Basket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'basket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'date_create'], 'required'],
            [['user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['status'], 'string', 'max' => 180],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[BasketOrders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBasketOrders()
    {
        return $this->hasMany(BasketOrder::className(), ['basket_id' => 'id']);
    }
}
