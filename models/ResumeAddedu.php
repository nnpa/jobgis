<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume_addedu".
 *
 * @property int $id
 * @property int $resume_id
 * @property string $university
 * @property string $firm
 * @property string $spec
 * @property string $year
 */
class ResumeAddedu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_addedu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resume_id', 'university', 'firm', 'spec', 'year'], 'required'],
            [['resume_id'], 'integer'],
            [['university', 'firm', 'spec', 'year'], 'string', 'max' => 255],
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
            'university' => 'University',
            'firm' => 'Firm',
            'spec' => 'Spec',
            'year' => 'Year',
        ];
    }
}
