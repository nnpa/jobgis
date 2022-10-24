<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\NetCity;
use app\models\Vacancy;
use app\models\Users;
use app\models\Firm;
use app\models\Partners;
use app\models\Support;

use yii\web\Controller;

class SupportController extends Controller
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
    
    public function actionSupport(){
        $user = Yii::$app->user->identity;

        if(isset($_POST["message"]) && !empty($_POST["message"])){
            $support = new Support();
            $support->from_id = $user->id;
            $support->to_id   = 0;
            $support->view    = 0;
            $support->message = $_POST["message"];
            $support->save(false);
        }
        $messages = Support::find()->where(["from_id" => $user->id])->orWhere(["to_id"=>$user->id])->all();

        return $this->render('support',["messages" => $messages]);
    }
    
}
