<?php

namespace app\models;

use Yii;
use app\models\Firm;
use app\models\Vacancy;
use app\models\Resume;


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
    
    
    public function getFirm()
    {
        return $this->hasOne(Firm::class, ['id' => 'firm_id']);
    }
    
    public function beforeDelete(){
        $vacancies = Vacancy::find()->where(["user_id" => $this->id])->all();
        
        foreach($vacancies as $vacancy){
            $vacancy->delete();
        }
        
        $resumes = Resume::find()->where(["user_id" => $this->id])->all();
        foreach($resumes as $resume){
            $resume->delete();
        }
        return parent::beforeDelete();
    }
}
