<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $company
 * @property string $phone
 * @property string $city
 * @property string $email
 * @property string $password
 * @property int $type
 * @property string $recover_code
 * @property int $create_time
 * @property string $auth_key
 * @property string $access_token
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'company', 'phone', 'city', 'email', 'password', 'type', 'recover_code', 'create_time', 'auth_key', 'access_token'], 'required'],
            [['type', 'create_time'], 'integer'],
            [['name', 'surname', 'company', 'phone', 'city', 'email', 'password', 'recover_code', 'auth_key', 'access_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'company' => 'Company',
            'phone' => 'Phone',
            'city' => 'City',
            'email' => 'Email',
            'password' => 'Password',
            'type' => 'Type',
            'recover_code' => 'Recover Code',
            'create_time' => 'Create Time',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }
}
