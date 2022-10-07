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

use yii\data\Pagination;
/**
 * Description of ResponceController
 *
 * @author ivan
 */
class ResponseController extends Controller{
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
    
    public function actionEmployer(){
        $user = Yii::$app->user->identity;

        $vacancy = Vacancy::find()->where(["user_id" =>$user->id ])->all();
        $ids = [];
        foreach($vacancy as $v){
            $ids[] = $v->id;
        }
        
        
        $query = Response::find()->where(["vacancy_id" => $ids]);
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
        
        
        $query = Response::find()->where(["resume_id" => $ids]);
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
        
        $message = "Ваше резюме по вакансии {$response->vacancy->name} откликнулись"; 
        $to  = $response->vacancy->email;      
        $subject = '=?utf-8?b?'. base64_encode("Резюме заинтересовало работодателя" ) .'?=';
        $fromMail = 'admin@jobgis';
        $fromName = 'jobgis';
        $date = date(DATE_RFC2822);
        $messageId='<'.time().'-'.md5($fromMail.$to).'@'.$_SERVER['SERVER_NAME'].'>';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8". "\r\n";
        $headers .= "From: ". $fromName ." <". $fromMail ."> \r\n";
        $headers .= "Date: ". $date ." \r\n";
        $headers .= "Message-ID: ". $messageId ." \r\n";

        mail($to, $subject, $message, $headers); 
        
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
        $to  = $response->resume->user->email;      
        $subject = '=?utf-8?b?'. base64_encode("Резюме заинтересовало работодателя" ) .'?=';
        $fromMail = 'admin@jobgis';
        $fromName = 'jobgis';
        $date = date(DATE_RFC2822);
        $messageId='<'.time().'-'.md5($fromMail.$to).'@'.$_SERVER['SERVER_NAME'].'>';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8". "\r\n";
        $headers .= "From: ". $fromName ." <". $fromMail ."> \r\n";
        $headers .= "Date: ". $date ." \r\n";
        $headers .= "Message-ID: ". $messageId ." \r\n";

        mail($to, $subject, $message, $headers); 

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
        $to  = $response->resume->user->email;      
        $subject = '=?utf-8?b?'. base64_encode("Резюме заинтересовало работодателя" ) .'?=';
        $fromMail = 'admin@jobgis';
        $fromName = 'jobgis';
        $date = date(DATE_RFC2822);
        $messageId='<'.time().'-'.md5($fromMail.$to).'@'.$_SERVER['SERVER_NAME'].'>';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8". "\r\n";
        $headers .= "From: ". $fromName ." <". $fromMail ."> \r\n";
        $headers .= "Date: ". $date ." \r\n";
        $headers .= "Message-ID: ". $messageId ." \r\n";

        mail($to, $subject, $message, $headers); 

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }
}
