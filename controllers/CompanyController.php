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
use app\models\Firm;
use app\models\Vacancy;
use app\models\Reviews;

use app\controllers\AppController;

class CompanyController extends AppController
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
                'only' => ['logout','workers','addworker'],
                'rules' => [
                    [
                        'actions' => ['logout','workers','addworker'],
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
    
    public function actionView($id){
        $firm = Firm::find()->where(["id" => $id])->one();
        
        if(is_null($firm)){
            exit;
        }
        
        if($firm->id == 29){
            exit;
        }
        
        $this->view->title = $firm->name;
        $this->view->registerMetaTag(
            ['name' => 'keywords', 'content' => $firm->name]
        );
        $this->view->registerMetaTag(
            ['name' => 'description', 'content' => $firm->name]
        );
        
        $users = Users::find()->where(["firm_id" => $id])->all();
        $ids = [];
        
        foreach($users as $user){
            $ids[] = $user->id;
        }
        
        $vacancys = Vacancy::find()->where(["user_id" => $ids])->all();
        
        if(isset($_POST) && !empty($_POST)){
            $user = Yii::$app->user->identity;

            $re = new Reviews();
            $re->user_id = $user->id;
            $re->firm_id = $id;
            $re->description = $_POST["description"];
            $re->save(false);
        }
        
        $re = Reviews::find()->where(["firm_id" => $id])->all();
        

        return $this->render("view",[
            "firm" => $firm,
            "vacancys" => $vacancys,
            "re" => $re
        ]);
    }
    
    public function actionRecruiter($id){
        $recruiter  = Users::find()->where(["id" =>$id])->one();
        
        
        
        $user = Yii::$app->user->identity;
        
        $firm = Firm::find()->where(["id" => $user->firm_id])->one();
        $firm->manage_id = $id;
        $firm->save(false);
        
        Yii::$app->mailer->compose()
       ->setFrom('jobgis.ru@yandex.ru')
       ->setTo($recruiter->email)
       ->setSubject('???????????? ?????????????????? jobgis.ru')
       ->setTextBody("???????????? ???????? {$user->name} {$firm->name} ???????????? ?????????????????????????????? ???????????? ???????????????? ?? ???????????? ?????????????? ???????????????? ?? ????????????.")
       ->setHtmlBody("<html>???????????? ???????? {$user->name} <a href='https://jobgis.ru/company/view?id=" . $firm->id . "'>{$firm->name} </a>???????????? ?????????????????????????????? ???????????? ???????????????? ?? ???????????? ?????????????? ???????????????? ?? ????????????.</html>")
       ->send();
        
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
     public function actionRecruiterdelete($id){
        $recruiter  = Users::find()->where(["id" =>$id])->one();
        
        
        
        $user = Yii::$app->user->identity;
        
        $firm = Firm::find()->where(["id" => $user->firm_id])->one();
        $firm->manage_id = 0;
        $firm->save(false);
        
        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    
}
