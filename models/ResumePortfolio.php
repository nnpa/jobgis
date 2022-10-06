<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume_portfolio".
 *
 * @property int $id
 * @property int $resume_id
 * @property int $photo
 */
class ResumePortfolio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_portfolio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resume_id', 'photo'], 'required'],
            [['resume_id', 'photo'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resume_id' => 'Resume ID',
            'photo' => 'Photo',
        ];
    }
}
