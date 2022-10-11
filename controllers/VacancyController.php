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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionList(){
        $user = Yii::$app->user->identity;
        
        
        $users = Users::find()->where(["firm_id" => $user->firm_id ])->all();
        $ids = [];
        foreach($users as $user ){
            $ids[] = $user->id;
        }
        
        $vacancies = Vacancy::find()->where(["user_id" => $user->id]);
        
        foreach($ids as $id){
            $vacancies = $vacancies->andWhere(["user_id" => $id]);
        }
        $vacancies->all();
        
        return $this->render("all",["vacancies" => $vacancies]);
    }
    
    public function actionDelete($id){
        $user = Yii::$app->user->identity;
        $vacancies = Vacancy::find()->where(["id" => $id])->one();
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
            $vacancy->create_time  = time();
            $vacancy->save(false);
            return $this->render("message",["message" => "Вы успешно отредактировали вакансию"]);
       }
       
       return $this->render("add",["user" => $user,"vacancy" => $vacancy]); 
    }
    
    public function actionAdd(){
        
            $user = Yii::$app->user->identity;
            $vacancy = new Vacancy();
            $vacancy->user_id = $user->id;
            $vacancy->name = "Заполните вакансию";
            $vacancy->spec  = "";
            $vacancy->specsub  = "";
            $vacancy->city  = "";
            $vacancy->costfrom  = (int) 10000;
            $vacancy->costto  = (int) 20000;
            $vacancy->cash  = "";
            $vacancy->cashtype  = "До вычета налогов";
            $vacancy->address  = "";
            $vacancy->exp  = "Нет опыта";
            $vacancy->description  = "";
            $vacancy->skills  = "";
            $vacancy->employment  = "Полная занятость";
            $vacancy->contactmane  = "";
            $vacancy->email  = "";
            $vacancy->phone  = "";
            $vacancy->create_time  = time();
            $vacancy->save(false);
            
            return $this->redirect("/vacancy/edit?id=" . $vacancy->id);
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
}
