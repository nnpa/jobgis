<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vacancy".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $spec
 * @property string $specsub
 * @property string $city
 * @property int $costfrom
 * @property int $costto
 * @property string $cash
 * @property string $cashtype
 * @property string $address
 * @property string $exp
 * @property string $description
 * @property string $skills
 * @property string $employment
 * @property string $contactmane
 * @property string $email
 * @property string $phone
 * @property int $create_time
 */
class Vacancy extends \yii\db\ActiveRecord
{
  public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vacancy';
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'spec' => 'Spec',
            'specsub' => 'Specsub',
            'city' => 'City',
            'costfrom' => 'Costfrom',
            'costto' => 'Costto',
            'cash' => 'Cash',
            'cashtype' => 'Cashtype',
            'address' => 'Address',
            'exp' => 'Exp',
            'description' => 'Description',
            'skills' => 'Skills',
            'employment' => 'Employment',
            'contactmane' => 'Contactmane',
            'email' => 'Email',
            'phone' => 'Phone',
            'create_time' => 'Create Time',
        ];
    }
    

}
