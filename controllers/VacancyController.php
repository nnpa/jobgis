<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NetCity;
use app\models\Users;
use app\models\Skills;
use app\models\Vacancy;
use app\models\Firm;
use app\controllers\AppController;

class VacancyController extends AppController
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout',"list","add"],
                'rules' => [
                    [
                        'actions' => ['logout',"list","add"],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionList(){
        $userid = Yii::$app->user->identity;
        $users = Users::find()->where(["firm_id" => $userid->firm_id ])->all();
        $ids = [];
        foreach($users as $user ){
            $ids[] = $user->id;
        }
        
        $vacancies = Vacancy::find()->where(["user_id" => $ids])->all();
        return $this->render("all",["vacancies" => $vacancies,"user"=>$userid]);
    }
    
    public function actionDelete($id){
        $user = Yii::$app->user->identity;
        
        $users = Users::find()->where(["firm_id" => $user->firm_id ])->all();
        $ids = [];
        foreach($users as $user ){
            $ids[] = $user->id;
        }
        
        $vacancies = Vacancy::find()->where(["id" => $id,"user_id" =>$ids])->one();
        if(!is_null($vacancies)){
            $vacancies->delete();
        }
        return $this->redirect("/vacancy/list");
    }
    
    public function actionShow($id){
        $vacancy = Vacancy::find()->where(["id" =>$id])->one();
        
        
        if(!is_null($vacancy)){
            $this->view->registerMetaTag(
                ['name' => 'keywords', 'content' => "jobgis.ru вакансия " . $vacancy->name ." " . $vacancy->city]
            );
            $this->view->registerMetaTag(
                ['name' => 'description', 'content' => "jobgis.ru вакансия " . $vacancy->name ." " . $vacancy->city]
            );
            
            $this->view->title = "jobgis.ru вакансия " . $vacancy->name ." " . $vacancy->city;
            return $this->render("show",["vacancy" => $vacancy]);
        }
    }
    
    public function actionEdit($id){
       $user = Yii::$app->user->identity;
       $vacancy = Vacancy::find()->where(["id" =>$id])->one();
       if(isset($_POST) && !empty($_POST)){
            $vacancy->user_id = $user->id;
            $vacancy->name = $_POST["name"];
            $vacancy->spec  = $_POST["spec"];
            $vacancy->specsub  = $_POST["specsub"];
            $vacancy->city  = $_POST["city"];
            $vacancy->costfrom  = (int) $_POST["costfrom"];
            $vacancy->costto  = (int) $_POST["costto"];
            $vacancy->cash  = $_POST["cash"];
            $vacancy->cashtype  = $_POST["cashtype"];
            $vacancy->address  = $_POST["address"];
            $vacancy->exp  = $_POST["exp"];
            $vacancy->description  = $_POST["description"];
            $vacancy->skills  = $_POST["skills"];
            $vacancy->employment  = $_POST["employment"];
            $vacancy->contactmane  = $_POST["contactmane"];
            $vacancy->email  = $_POST["email"];
            $vacancy->phone  = $_POST["phone"];
            $vacancy->workschedule  = $_POST["workschedule"];

            $vacancy->create_time  = time();
            $vacancy->save(false);
            return $this->render("message",["message" => "Вы успешно отредактировали вакансию"]);
       }
       
       return $this->render("add",["user" => $user,"vacancy" => $vacancy]); 
    }
    
    public function actionAdd(){
        
       $user = Yii::$app->user->identity;
       $vacancy = new Vacancy();
       $vacancy->name = "Заполните должность";
       $vacancy->cashtype = "До вычета налогов";
       $vacancy->exp = "Нет опыта";
       $vacancy->employment = "Полная занятость";
       $vacancy->workschedule  = "Полный день";

       
       if(isset($_POST) && !empty($_POST)){
            $vacancy->user_id = $user->id;
            $vacancy->name = $_POST["name"];
            $vacancy->spec  = $_POST["spec"];
            $vacancy->specsub  = $_POST["specsub"];
            $vacancy->city  = $_POST["city"];
            $vacancy->costfrom  = (int) $_POST["costfrom"];
            
            
            $vacancy->costto  = (int) $_POST["costto"];
            $vacancy->cash  = $_POST["cash"];
            $vacancy->cashtype  = $_POST["cashtype"];
            $vacancy->address  = $_POST["address"];
            $vacancy->exp  = $_POST["exp"];
            $vacancy->description  = $_POST["description"];
            $vacancy->skills  = $_POST["skills"];
            $vacancy->employment  = $_POST["employment"];
            $vacancy->contactmane  = $_POST["contactmane"];
            $vacancy->email  = $_POST["email"];
            $vacancy->phone  = $_POST["phone"];
            $vacancy->create_time  = time();
            $vacancy->workschedule  = $_POST["workschedule"];

            
            $vacancy->save(false);
            return $this->render("message",["message" => "Вы успешно отредактировали вакансию"]);
       }
            
        return $this->render("add",["user" => $user,"vacancy" => $vacancy]); 

    }    
    
    public function actionSkills(){
       if (! empty($_GET["keyword"])) {
            $cities = Skills::find()->select("name")->distinct()->where(['like', 'name', $_GET["keyword"] . '%', false])->all();
                        
            $result = '<ul id="country-list">';
            
            foreach ($cities as $city) {
                $result .= '<li onClick="selectSkill(\'' . $city->name .'\')">' . $city->name .'</li>';
            }
            $result .= '</ul>';
            return $result;
        }
        return; 
    }
    
    public function actionContacts($id){
        $vacancy = Vacancy::find()->where(["id" => $id])->one();
        if(!is_null($vacancy)){
            return $vacancy->contactmane . "<br> тел: " . $vacancy->phone ."<br> email: ". $vacancy->email;
        }
        return "";
    }
    
    public function actionChangesort($id,$sort){
        $vacancy = Vacancy::find()->where(["id" => $id])->one();
        $vacancy->rsort = $sort;
        $vacancy->save(false);
    }
}
