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
            
                    
            if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
                $dirPath="/var/www/basic/web/img/";

                

                $uploadedFile=$_FILES['image']['tmp_name']; 
                $sourceProperties=getimagesize($uploadedFile);
                $newFileName=time();

                $ext=pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                $imageSrc= imagecreatefromjpeg($uploadedFile); 

                $tmp= $this->imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
                imagejpeg($tmp,$dirPath.$newFileName."_thump.".$ext);
                
                $support->screen = $newFileName."_thump.".$ext;
                //move_uploaded_file($uploadedFile, $dirPath.$newFileName.".".$ext);
                

           }
            
            
            $support->save(false);
        }
        

        
        $messages = Support::find()->where(["from_id" => $user->id])->orWhere(["to_id"=>$user->id])->all();

        return $this->render('support',["messages" => $messages]);
    }
    
    function imageResize($imageSrc,$imageWidth,$imageHeight) {

        $newImageHeight=700;
       if($newImageHeight >= $imageHeight){
           $newImageHeight = $imageHeight;
           $newImageWidth=$imageWidth;
           
       }else{
            $newImageHeight=700;
            $percent = $imageHeight / 100;
            $resizePercent = $newImageHeight/$percent;
            
            $widthPerncet = $imageWidth/100;
            $newImageWidth = $resizePercent * $widthPerncet;
            
       }

       $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
       imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

       return $newImageLayer;
    }
}
