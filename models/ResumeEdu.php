<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume_edu".
 *
 * @property int $id
 * @property int $resume_id
 * @property string $edu_type
 * @property string $univercity
 * @property string $fack
 * @property string $spec
 * @property string $year
 */
class ResumeEdu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_edu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resume_id', 'edu_type', 'univercity', 'fack', 'spec', 'year'], 'required'],
            [['resume_id'], 'integer'],
            [['edu_type', 'univercity', 'fack', 'spec', 'year'], 'string', 'max' => 255],
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
            'edu_type' => 'Edu Type',
            'univercity' => 'Univercity',
            'fack' => 'Fack',
            'spec' => 'Spec',
            'year' => 'Year',
        ];
    }
}
