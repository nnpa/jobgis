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
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
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
        
        $users = Users::find()->where(["firm_id" => $id])->all();
        $ids = [];
        
        foreach($users as $user){
            $ids[] = $user->id;
        }
        
        $vacancys = Vacancy::find()->where(["user_id" => $ids])->all();
        
        return $this->render("view",[
            "firm" => $firm,
            "vacancys" => $vacancys
        ]);
    }
}