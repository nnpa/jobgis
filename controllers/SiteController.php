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

class SiteController extends Controller
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionRegisteremployer(){
        $city = $this->getCity();

        $errors =  [];
        if(
           isset($_POST["name"]) &&
           isset($_POST["surname"])  &&
           isset($_POST["phone"]) &&
           isset($_POST["company"])  &&
           isset($_POST["city"])&&
           isset($_POST["email"])
        ){
            if(strlen($_POST["name"]) < 3){
                $errors[] = "Имя меньше 3 символов";
            }
            if(strlen($_POST["surname"]) < 3){
                $errors[] = "Фамилия меньше 3 символов";
            }
            if(strlen($_POST["surname"]) < 3){
                $errors[] = "Фамилия меньше 3 символов";
            }
            
            if(strlen($_POST["company"]) < 3){
                $errors[] = "Компания меньше 3 символов";
            }
            
            if($this->checkPhoneNumber($_POST["phone"]) == false) {
                $errors[] = "Не верный формат телефона";
            }
            
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";

            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(!is_null($user)){
                $errors[] = "Такой email уже зарегистрирован";

            }
            
            if(empty($errors)){
                $user = new Users();
                $user->name = $_POST["name"];
                $user->surname = $_POST["surname"];
                $user->phone = $_POST["phone"];
                $user->company = $_POST["company"];
                $user->email = $_POST["email"];
                $user->city = $_POST["city"];
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = $_POST['patronymic'];
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('employer');
        
                Yii::$app->authManager->assign($role,$id);
                
                $message = "Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a>" ;
                $to  = $user->email;      
                $subject = '=?utf-8?b?'. base64_encode("Регистрация на сайте jobgis" ) .'?=';
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
                
                return $this->render("message",["message"=>"На ваш email высла пароль"]);
            }
            
        }
        
        return $this->render('registeremployer',["errors" => $errors,"city" =>$city]);
    }
    
    public function actionReset(){
        $errors = [];
        if(isset($_POST["email"])){
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";
            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(is_null($user)){
                $errors[] = "Такой email не зарегистрирован";
            }
            
            if(empty($errors)){
                
                $user->password = $this->getPassword();
                $user->save(false);
                
                $message = "Ваш email: " . $_POST['email'] . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a>" ;
                $to  = $user->email;      
                $subject = '=?utf-8?b?'. base64_encode("Регистрация на сайте jobgis" ) .'?=';
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
                
                return $this->render("message",["message"=>"На ваш email высла пароль"]);
            }
        }
        return $this->render('reset',["errors" => $errors]);

    }
    
    public function getCity(){
        $city = "";
        $arr = geoip_record_by_name($_SERVER['REMOTE_ADDR']);
        //$arr = geoip_record_by_name('83.174.241.173');
        
        if($arr != false){
            $city = $arr['city'];
        }
        
        $netCity = NetCity::find()->where(["name_en" => $city])->one();
        if(!is_null($netCity)){
            $city = $netCity->name_ru;
        }
        return $city;
    }
    
    public function actionRegistercandidate(){
        $city = $this->getCity();
        $errors =  [];
        if(
           isset($_POST["name"]) &&
           isset($_POST["surname"])  &&
           isset($_POST["phone"]) &&
           isset($_POST["company"])  &&
           isset($_POST["city"])&&
           isset($_POST["email"])
        ){
            if(strlen($_POST["name"]) < 3){
                $errors[] = "Имя меньше 3 символов";
            }
            if(strlen($_POST["surname"]) < 3){
                $errors[] = "Фамилия меньше 3 символов";
            }
            if(strlen($_POST["surname"]) < 3){
                $errors[] = "Фамилия меньше 3 символов";
            }
            
            
            if($this->checkPhoneNumber($_POST["phone"]) == false) {
                $errors[] = "Не верный формат телефона";
            }
            
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";

            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(!is_null($user)){
                $errors[] = "Такой email уже зарегистрирован";

            }
            
            if(empty($errors)){
                $user = new Users();
                $user->name = $_POST["name"];
                $user->surname = $_POST["surname"];
                $user->phone = $_POST["phone"];
                $user->company = "";
                $user->email = $_POST["email"];
                $user->city = $_POST["city"];
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = $_POST['patronymic'];

                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('employer');
        
                Yii::$app->authManager->assign($role,$id);
                
                $message = "Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a>" ;
                $to  = $user->email;      
                $subject = '=?utf-8?b?'. base64_encode("Регистрация на сайте jobgis" ) .'?=';
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
                
                return $this->render("message",["message"=>"На ваш email высла пароль"]);
            }
            
        }
        
        return $this->render('registercandidate',["errors" => $errors,"city" =>$city]);
    }
    
    
    public function getPassword(){
        $password = substr(md5(time()),0,6);
        return $password;
    }
    
    public function actionCandidate(){
        return $this->render("candidate");
    }
    
    function checkPhoneNumber($phoneNumber){
	
	$phoneNumber = preg_replace('/\s|\+|-|\(|\)/','', $phoneNumber); // удалим пробелы, и прочие не нужные знаки
	
	if(is_numeric($phoneNumber))
	{
		if(strlen($phoneNumber) < 5) // если длина номера слишком короткая, вернем false 
		{
			return FALSE;
		}
		else
		{
			return $phoneNumber;			
		}
	}
	else
	{
		return FALSE;
	}
    }
    

    
    public function actionRegister(){
        return $this->render('register');
    }
            
    public function actionRole(){
        /**
        $admin = Yii::$app->authManager->createRole('admin');
        $admin->description = "Администратор";
        Yii::$app->authManager->add($admin);
        
        $candidate = Yii::$app->authManager->createRole('candidate');
        $candidate->description = "Соискатель";
        Yii::$app->authManager->add($candidate);
        
        $employer = Yii::$app->authManager->createRole('employer');
        $employer->description = "Работодатель";
        Yii::$app->authManager->add($employer);
        
        $manager = Yii::$app->authManager->createRole('manager');
        $manager->description = "Менеджер";
        Yii::$app->authManager->add($manager);
        
        $ban = Yii::$app->authManager->createRole('banned');
        $ban->description = "Заблокированный";
        Yii::$app->authManager->add($ban);
        
         * * 
         
        $role = Yii::$app->authManager->getRole('admin');
        
        Yii::$app->authManager->assign($role,1);



                  */
         
        return 123;
        
    }
    
    public function actionIp(){
        $ip = '83.174.241.173';
        var_dump(geoip_record_by_name($ip));
    }
    
    public function actionCity(){
        if (! empty($_GET["keyword"])) {
            $cities = NetCity::find()->select("name_ru")->distinct()->where(['like', 'name_ru', $_GET["keyword"] . '%', false])->all();
                        
            $result = '<ul id="country-list">';
            
            foreach ($cities as $city) {
                
                $result .= '<li onClick="selectCountry(\'' . $city->name_ru .'\')">' . $city->name_ru .'</li>';
            }
            $result .= '</ul>';
            return $result;
        }
        return;
    }
    
    public function actionEmployer(){
        return $this->render("employer");
    }
    
    public function actionSpam(){
                $message = "test" ;
                $to  = "test-59l2jyt0q@srv1.mail-tester.com";      
                $subject = '=?utf-8?b?'. base64_encode("test" ) .'?=';
                $fromMail = 'admin@jobgis.ru';
                $fromName = 'jobgis';
                $date = date(DATE_RFC2822);
                $messageId='<'.time().'-'.md5($fromMail.$to).'@'.$_SERVER['SERVER_NAME'].'>';
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= "Content-type: text/html; charset=utf-8". "\r\n";
                $headers .= "From: ". $fromName ." <". $fromMail ."> \r\n";
                $headers .= "Date: ". $date ." \r\n";
                $headers .= "Message-ID: ". $messageId ." \r\n";

                mail($to, $subject, $message, $headers); 
    }
}
