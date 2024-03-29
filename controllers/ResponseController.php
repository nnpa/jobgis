<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NetCity;
use app\models\Users;
use app\models\Response;
use app\models\Resume;
use app\models\Vacancy;
use app\controllers\AppController;

use yii\data\Pagination;
/**
 * Description of ResponceController
 *
 * @author ivan
 */
class ResponseController extends AppController{
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionEmployer(){
        $user = Yii::$app->user->identity;
        
        $users = Users::find()->where(["firm_id" => $user->firm_id ])->all();
        $ids = [];
        foreach($users as $user ){
            $ids[] = $user->id;
        }
        $vacancy = Vacancy::find()->where(["user_id" =>$ids ])->all();
        $ids = [];
        foreach($vacancy as $v){
            $ids[] = $v->id;
        }
        
        
        $query = Response::find()->where(["vacancy_id" => $ids])->orderBy(["id" => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(),'pageSize' => 5]);
        $response = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render("employer",["response" => $response,'pages'=>$pages]);
    }
    
    public function actionCandidate(){
        $user = Yii::$app->user->identity;

        
        
        $resume = Resume::find()->where(["user_id" =>$user->id ])->all();
        $ids = [];
        
        foreach($resume as $r){
            $ids[] = $r->id;
        }
        
        
        $query = Response::find()->where(["resume_id" => $ids])->orderBy(["id" => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(),'pageSize' => 5]);
        $response = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render("candidate",["response" => $response,'pages'=>$pages]);
    }
    
    public function actionResponse($resume_id,$vacancy_id){
        $response = new Response();
        $response->resume_id = $resume_id;
        $response->vacancy_id = $vacancy_id;
        $response->result = 0;
        $response->create_date = time();
        $response->save();
        
        Yii::$app->mailer->compose()
        ->setFrom('jobgis.ru@yandex.ru')
        ->setTo($response->vacancy->email)
        ->setSubject('На вашу вакансию на сайте jobgis.ru откликнулись')
        ->setTextBody("На вашу вакансию {$response->vacancy->name} откликнулись")
        ->setHtmlBody("<html>На вашу вакансию {$response->vacancy->name} откликнулись</html>")
        ->send();

        
        return "";

    }
    
    public function actionAccept($id){
        $response = Response::find()->where(["id" => $id])->one();
        
        if(is_null($response)){
            exit;
        }
        $response->result = 1;
        $response->save();
        
        $message = "Ваше резюме по вакансии {$response->vacancy->name} заинтересовало работодателя"; 
        $message .= " обратитесь в рабочее время по телефону {$response->vacancy->phone} {$response->vacancy->contactmane} " ;
        
        Yii::$app->mailer->compose()
        ->setFrom('jobgis.ru@yandex.ru')
        ->setTo($response->resume->user->email)
        ->setSubject('Резюме заинтересовало работодателя')
        ->setTextBody($message)
        ->setHtmlBody("<html>" . $message. "</html>")
        ->send();

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function actionRefuse($id){
        $response = Response::find()->where(["id" => $id])->one();
        
        if(is_null($response)){
            exit;
        }
        $response->result = 2;
        $response->save();
        
         $message = "Ваше резюме по вакансии {$response->vacancy->name} не заинтересовало работодателя"; 
            Yii::$app->mailer->compose()
        ->setFrom('jobgis.ru@yandex.ru')
        ->setTo($response->resume->user->email)
        ->setSubject('Резюме не заинтересовало работодателя')
        ->setTextBody($message)
        ->setHtmlBody("<html>" . $message . "</html>")
        ->send();

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function actionResume($id,$vacancy,$userId){
        $user = Users::find()->where(["id" => $userId])->one();
        
        $response = new Response();
        $response->resume_id = $id;
        $response->vacancy_id = $vacancy;
        $response->result = 1;
        $response->create_date = time();
        $response->save(false);
        
         $message = "Ваше резюме по вакансии {$response->vacancy->name} не заинтересовало работодателя"; 
            Yii::$app->mailer->compose()
        ->setFrom('jobgis.ru@yandex.ru')
        ->setTo($response->resume->user->email)
        ->setSubject('Резюме не заинтересовало работодателя')
        ->setTextBody($message)
        ->setHtmlBody("<html>" . $message . "</html>")
        ->send();
         
        return "";
    }
}
