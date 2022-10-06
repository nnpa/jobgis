<?php

namespace app\models;

use Yii;
use app\models\Resume;
use app\models\Vacancy;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property int $vacancy_id
 * @property int $resume_id
 * @property int $result
 * @property int $create_date
 */
class Response extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vacancy_id', 'resume_id', 'result', 'create_date'], 'required'],
            [['vacancy_id', 'resume_id', 'result', 'create_date'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vacancy_id' => 'Vacancy ID',
            'resume_id' => 'Resume ID',
            'result' => 'Result',
            'create_date' => 'Create Date',
        ];
    }
    
    public function getResume()
    {
        return $this->hasOne(Resume::class, ['id' => 'resume_id']);
    }
    
    public function getVacancy()
    {
        return $this->hasOne(Vacancy::class, ['id' => 'vacancy_id']);
    }
}
