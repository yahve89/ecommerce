<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $user_id
 * @property string|null $last_name
 * @property string|null $first_name
 * @property string|null $patronymic
 * @property string|null $gender
 * @property string|null $phone
 * @property string|null $company
 * @property string|null $position
 * @property string|null $postaddress
 * @property string|null $region
 * @property string|null $location
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['last_name', 'first_name', 'patronymic', 'phone', 'company', 'position', 'postaddress', 'region', 'location'], 'string', 'max' => 255],
            [['gender'], 'string', 'max' => 64],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'patronymic' => 'Patronymic',
            'gender' => 'Gender',
            'phone' => 'Phone',
            'company' => 'Company',
            'position' => 'Position',
            'postaddress' => 'Postaddress',
            'region' => 'Region',
            'location' => 'Location',
        ];
    }
}
