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

class VacancyController extends Controller
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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

        $vacancies = Vacancy::find()->where(["user_id" => $user->id])->all();
        return $this->render("all",["vacancies" => $vacancies]);
    }
    
    public function actionDelete($id){
        $user = Yii::$app->user->identity;
        $vacancies = Vacancy::find()->where(["user_id" => $user->id,"id" => $id])->one();
        $vacancies->delete();
        return $this->redirect("/vacancy/list");
    }
    
    public function actionShow($id){
        $vacancy = Vacancy::find()->where(["id" =>$id])->one();
        if(!is_null($vacancy)){
            return $this->render("show",["vacancy" => $vacancy]);
        }
    }
    
    public function actionAdd(){
       $user = Yii::$app->user->identity;
       if(isset($_POST) && !empty($_POST)){
           $vacancy = new Vacancy();
            $vacancy->user_id = $user->id;
            $vacancy->name = $_POST["name"];
            $vacancy->spec  = $_POST["spec"];
            $vacancy->specsub  = $_POST["specsub"];
            $vacancy->city  = $_POST["city"];
            $vacancy->costfrom  = $_POST["costfrom"];
            $vacancy->costto  = $_POST["costto"];
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
            return $this->render("message",["message" => "Вы успешно создали вакансию"]);
       }
       
       return $this->render("add",["user" => $user]);
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
