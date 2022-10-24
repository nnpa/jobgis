<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "support".
 *
 * @property int $id
 * @property int $from_id
 * @property int $to_id
 * @property string $message
 */
class Support extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'support';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id', 'message'], 'required'],
            [['from_id', 'to_id'], 'integer'],
            [['message'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_id' => 'From ID',
            'to_id' => 'To ID',
            'message' => 'Message',
        ];
    }
    
    public function getUser() {
        return $this->hasOne(Users::class, ['id' => 'from_id']);
    }
}
