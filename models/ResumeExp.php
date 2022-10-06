<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resume_exp".
 *
 * @property int $id
 * @property int $resume_id
 * @property string $start_date
 * @property string $end_date
 * @property string $firm
 * @property string $site
 * @property string $vacancy
 * @property string $description
 */
class ResumeExp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume_exp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resume_id', 'start_date', 'end_date', 'firm', 'site', 'vacancy', 'description'], 'required'],
            [['resume_id'], 'integer'],
            [['description'], 'string'],
            [['start_date', 'end_date', 'firm', 'site', 'vacancy'], 'string', 'max' => 255],
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
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'firm' => 'Firm',
            'site' => 'Site',
            'vacancy' => 'Vacancy',
            'description' => 'Description',
        ];
    }
}
