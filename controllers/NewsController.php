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
use app\models\News;
use yii\data\Pagination;

use app\controllers\AppController;

class NewsController extends AppController
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
    
    public function actionAll(){
        $query = News::find()->orderBy(["id" => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(),'pageSize' => 10]);
        $news = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('all',["news" => $news,"pages" => $pages]);
    }
    
    public function actionView($id){
        $new = News::find()->where(["id" => $id])->one();
        if(is_null($new)){
            exit;
        }
        
        $this->view->registerMetaTag(
            ['name' => 'keywords', 'content' => $new->keywords]
        );
        $this->view->registerMetaTag(
            ['name' => 'description', 'content' => mb_substr($new->description, 0, 300, "UTF-8")]
        );
        
        
        return $this->render("view",["new" => $new]);
    }
}
