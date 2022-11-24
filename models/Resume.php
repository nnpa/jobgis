<?php

namespace app\models;

use Yii;
use app\models\Users;
use app\models\ResumeEdu;
use app\models\ResumeExp;
use app\models\ResumeAddedu;
use app\models\ResumePortfolio;

/**
 * This is the model class for table "resume".
 *
 * @property int $id
 * @property string $photo
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $birth_date
 * @property string $gender
 * @property string $city
 * @property string $relocation
 * @property string $business_trips
 * @property string $vacancy
 * @property string $spec
 * @property string $specsub
 * @property int $cost
 * @property string $cash_type
 * @property int $employment_full
 * @property int $employment_partial
 * @property int $employment_project
 * @property int $employment_volunteering
 * @property int $employment_internship
 * @property int $schedule_full
 * @property int $schedule_removable
 * @property int $schedule_flexible
 * @property int $schedule_tomote
 * @property int $schedule_tour
 * @property string $skills
 * @property string $description
 * @property string $language
 * @property string $language_add
 * @property string $car
 * @property int $apdate_time
 */
class Resume extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resume';
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
            'photo' => 'Photo',
            'surname' => 'Surname',
            'name' => 'Name',
            'patronymic' => 'Patronymic',
            'birth_date' => 'Birth Date',
            'gender' => 'Gender',
            'city' => 'City',
            'relocation' => 'Relocation',
            'business_trips' => 'Business Trips',
            'vacancy' => 'Vacancy',
            'spec' => 'Spec',
            'specsub' => 'Specsub',
            'cost' => 'Cost',
            'cash_type' => 'Cash Type',
            'employment_full' => 'Employment Full',
            'employment_partial' => 'Employment Partial',
            'employment_project' => 'Employment Project',
            'employment_volunteering' => 'Employment Volunteering',
            'employment_internship' => 'Employment Internship',
            'schedule_full' => 'Schedule Full',
            'schedule_removable' => 'Schedule Removable',
            'schedule_flexible' => 'Schedule Flexible',
            'schedule_tomote' => 'Schedule Tomote',
            'schedule_tour' => 'Schedule Tour',
            'skills' => 'Skills',
            'description' => 'Description',
            'language' => 'Language',
            'language_add' => 'Language Add',
            'car' => 'Car',
            'apdate_time' => 'Apdate Time',
        ];
    }
        public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
       }
    public function beforeDelete(){
        
       $dirPath="/var/www/basic/web/img/";

       $resumeEdu = ResumeEdu::find()->where(["resume_id" => $this->id])->all();
       $resumeExp = ResumeExp::find()->where(["resume_id" => $this->id])->all();
       $resumePortfolio = ResumePortfolio::find()->where(["resume_id" => $this->id])->all();
       $resumeAddEdu = ResumeAddedu::find()->where(["resume_id" => $this->id])->all();
       
       foreach($resumeEdu as $edu){
           $edu->delete();
       }
       
       foreach($resumeExp as $exp){
           $exp->delete();
       }
       
       foreach($resumePortfolio as $portfolio){
           unlink($dirPath.$portfolio->photo); 

           $portfolio->delete();
       }
       
       foreach($resumeAddEdu as $edu){
           $edu->delete();
       }
        return parent::beforeDelete();
    }
    
    public function age(){
        if($this->birth_date == ""){
            return "";
            
        }
        $arr = explode(".",$this->birth_date);
        if(count($arr) <3){
            return "";
        }
        $newDate = $arr[2]."-".$arr[1]."-".$arr[0];
        
        $birthday_timestamp = strtotime($newDate);
        $age = date('Y') - date('Y', $birthday_timestamp);
        if (date('md', $birthday_timestamp) > date('md')) {
            $age--;
        }
        if($age > 100){
            return "";
        }
        //return $this->getSklo($age);
        return $age, ' ', $this->declension($age, array('год', 'года', 'лет'));

    }
    
function declension($number, array $data)
{
    $rest = array($number % 10, $number % 100);

    if($rest[1] > 10 && $rest[1] < 20) {
    return $data[2];
    } elseif ($rest[0] > 1 && $rest[0] < 5) {
    return $data[1];
    } else if ($rest[0] == 1) {
    return $data[0];
    }

    return $data[2];
}
}
