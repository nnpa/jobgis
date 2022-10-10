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
        ];
    }
    
    public function getPhone(){
        $user = Users::find()->where(["firm_id" => $this->id])->one();
        return $user->phone;
    }
}