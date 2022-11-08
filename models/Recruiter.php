<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recruiter".
 *
 * @property int $id
 * @property int $user_id
 * @property string $city
 * @property string $name
 */
class Recruiter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recruiter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'city', 'name'], 'required'],
            [['user_id'], 'integer'],
            [['city', 'name'], 'string', 'max' => 255],
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
            'city' => 'City',
            'name' => 'Name',
        ];
    }
}
