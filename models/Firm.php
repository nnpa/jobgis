<?php

namespace app\models;

use Yii;
use app\models\Users;
/**
 * This is the model class for table "firm".
 *
 * @property int $id
 * @property string $name
 * @property int $verify
 */
class Firm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'firm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['verify'], 'integer'],
            [['inn','name','verify'],'safe'],
            [['name'], 'string', 'max' => 255],
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
            'verify' => 'Verify',
            'inn' => 'ИНН',
            "city" => "Город"
        ];
    }
    
    public function getPhone(){
        $user = Users::find()->where(["firm_id" => $this->id])->one();
        return $user->phone;
    }
    
      public function getManager(){
        return $this->hasOne(Users::class, ['id' => 'manage_id']);
    }
    
    public function managerName(){
        if(is_object($this->manager)){
            return $this->manager->name . " " .$this->manager->surname;
        }else {
            return "";
        }
    }
    
    public function beforeDelete(){
        $users = Users::find()->where(["firm_id" => $this->id])->all();
        foreach($users as $user){
            $user->delete();
        }
        return parent::beforeDelete();
    }
    
    public function beforeSave($insert) {
        if($this->id != null){
            $users = Users::find()->where(["firm_id" => $this->id])->all();
            foreach ($users as $user){
                $user->company = $this->name;
                $user->save(false);
            }
        }
        
        return parent::beforeSave($insert);
    }
}
