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
use app\controllers\AppController;
use app\models\Partners;
use app\models\Resume;
use app\models\News;

class SiteController extends AppController
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->view->title = "Jobgis.ru";
        $this->view->registerMetaTag(
            ['name' => 'keywords', 'content' => 'работа, вакансии, работа, поиск вакансий, резюме, работы, работу, работ, ищу работу, поиск']
        );
        $this->view->registerMetaTag(
            ['name' => 'description', 'content' => 'jobgis.ru — сервис, который помогает найти работу и подобрать персонал ! Создавайте резюме и откликайтесь на вакансии. Набирайте сотрудников и публикуйте вакансии.']
        );

        $news = News::find()->orderBy(["create_time" => SORT_DESC])->limit(10)->all();

        
        $partners = Partners::find()->all();
        $vacancys = Vacancy::find()->where('name != :name', ['name'=>"Заполните вакансию"])->orderBy(["create_time" => SORT_DESC])->limit(20)->all();
        
        $tops = Vacancy::find()->where('name != :name', ['name'=>"Заполните вакансию"])->orderBy(["rsort" => SORT_DESC])->limit(5)->all();

        
        $resumes = Resume::find()->where('name != :name', ['name'=>"Заполните должность"])->andWhere(["verify" => 1])->orderBy(["id" => SORT_DESC])->limit(20)->all();

        return $this->render('index',["tops" => $tops,"resumes" => $resumes,"vacancys" => $vacancys,"partners"=>$partners,"news"=>$news]);
    }
    


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
 

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




    
    public function actionRegisteremployer(){
        $company = "";
        $email = "";
        
        $errors =  [];
        if(
           isset($_POST["company"])  &&
           isset($_POST["email"])
        ){



            
            if(strlen($_POST["company"]) < 3){
                $errors[] = "Компания меньше 3 символов";
            }

            
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";

            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(!is_null($user)){
                $errors[] = "Такой email уже зарегистрирован";

            }
            
            $company = $_POST["company"];
            $email = $_POST["email"];

            if(empty($errors)){
                $firm = new Firm();
                $firm->name =  $_POST["company"];
                $firm->verify = 0 ;
                $firm->manage_id = 0 ;
                $firm->city = "";
                $firm->save(false);
                
                $user = new Users();
                $user->name = "";
                $user->surname = "";
                $user->phone = "";
                $user->company = $_POST["company"];
                $user->firm_id = $firm->id;
                $user->email = $_POST["email"];
                $user->city = "";
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = "";
                $user->type = 2;

                if(isset($_POST["subscribe"])){
                    $user->subscribe = 1;
                }else{
                    $user->subscribe = 0;
                }
                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('employer');
        
                Yii::$app->authManager->assign($role,$id);
                
                 Yii::$app->mailer->compose()
                ->setFrom('robot@jobgis.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Поздравляем вы удачно зарегистрировались на сайте jobgis.ru. Ваш email: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html>Поздравляем вы удачно зарегистрировались на сайте jobgis.ru<br>Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                 
                $this->adminNotify("Работодатель",$user->email . " " . $firm->name);
                
                $model = new LoginForm();
                $model->username = $user->email;
                $model->password = $user->password;
                $model->login();
                return $this->goBack();
                
                //return $this->render("message",["message"=>"На ваш email выслан пароль"]);
            }
            
        }
        
        return $this->render('registeremployer',[
            "errors" => $errors,
            "company" => $company,
            "email" => $email,
        ]);
    }
    
    public function actionHr(){
        $company = "";
        $email = "";
        
        $errors =  [];
        if(
           isset($_POST["email"])
        ){



            


            
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";

            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(!is_null($user)){
                $errors[] = "Такой email уже зарегистрирован";

            }
            
            $email = $_POST["email"];

            if(empty($errors)){

                
                $user = new Users();
                $user->name = "";
                $user->surname = "";
                $user->phone = "";
                $user->company = "Менеджеры";
                $user->firm_id = 100;
                $user->email = $_POST["email"];
                $user->city = "";
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = "";
                $user->type = 4;

                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('recruiter');
        
                Yii::$app->authManager->assign($role,$id);
                
                 Yii::$app->mailer->compose()
                ->setFrom('robot@jobgis.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Поздравляем вы удачно зарегистрировались на сайте jobgis.ru. Ваш email: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html>Поздравляем вы удачно зарегистрировались на сайте jobgis.ru<br>Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                 
                $this->adminNotify("Рекрутер",$user->email);
                
                $model = new LoginForm();
                $model->username = $user->email;
                $model->password = $user->password;
                $model->login();
                return $this->goBack();
                
                //return $this->render("message",["message"=>"На ваш email выслан пароль"]);
            }
            
        }
        
        return $this->render('registerrecruiter',[
            "errors" => $errors,
            "email" => $email,
        ]);
    }
    
    public function adminNotify($type,$text){
        Yii::$app->mailer->compose()
        ->setFrom('robot@jobgis.ru')
        ->setTo("admin@jobgis.ru")
        ->setSubject('Новая регистрация на сайте jobgis.ru ' . $type)
        ->setTextBody("Новая регистрация на сайте jobgis.ru")
        ->setHtmlBody("<html>Новая регистрация на сайте jobgis.ru {$text} </html>")
        ->send();
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
                
                Yii::$app->mailer->compose()
                ->setFrom('robot@jobgis.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Поздравляем вы удачно зарегистрировались на сайте jobgis.ru. Ваш email: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html>Поздравляем вы удачно зарегистрировались на сайте jobgis.ru<br>Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                                
                
                return $this->render("message",["message"=>"На ваш email выслан пароль"]);
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
        $errors =  [];
        $email = "";
        if(
           isset($_POST["email"])
        ){
       
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";
            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(!is_null($user)){
                $errors[] = "Такой email уже зарегистрирован";

            }
            $email = $_POST["email"];
            
            if(empty($errors)){
                $user = new Users();
                $user->name = "";
                $user->surname = "";
                $user->phone = "";
                $user->company = "";
                $user->email = $_POST["email"];
                $user->city = "";
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = "";
                $user->type = 1;

                
                if(isset($_POST["subscribe"])){
                    $user->subscribe = 1;
                }else{
                    $user->subscribe = 0;
                }
                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('candidate');
        
                Yii::$app->authManager->assign($role,$id);
                
                Yii::$app->mailer->compose()
                ->setFrom('robot@jobgis.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Поздравляем вы удачно зарегистрировались на сайте jobgis.ru. Ваш email: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html>Поздравляем вы удачно зарегистрировались на сайте jobgis.ru<br>Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                
                $this->adminNotify("Соискатель",$user->email);
                $model = new LoginForm();
                $model->username = $user->email;
                $model->password = $user->password;
                $model->login();
                return $this->goBack();
                
                //return $this->render("message",["message"=>"На ваш email выслан пароль"]);
            }
            
        }
        
        return $this->render('registercandidate',["errors" => $errors,"email" => $email]);
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
        //var_dump(Yii::$app->mailer);exit;
        
        
        Yii::$app->mailer->compose()
        ->setFrom('robot@jobgis.ru')
        ->setTo('test-l3zp2c7r3@srv1.mail-tester.com')
        ->setSubject('Регистрация на сайте jobgis.ru')
        ->setTextBody('Поздравляем вы удачно зарегистрировались на сайте jobgis.ru')
        ->setHtmlBody('<html><b>Поздравляем вы удачно зарегистрировались на сайте jobgis.ru</b></html>')
        ->send();
        
    }
    
    public function actionWorkers(){
        $user = Yii::$app->user->identity;
        $workers = Users::find()->where(["firm_id" => $user->firm_id])->all();
        return $this->render("workers",["workers" => $workers]);
    }
    
    public function actionAddworker(){
        
        $errors = [];
        if(isset($_POST["email"]) && !empty($_POST["email"])){
            $email = $_POST['email'];

            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";
            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(!is_null($user)){
                $errors[] = "Такой email уже зарегистрирован";
            }
            
            if(empty($errors)){
                $user = Yii::$app->user->identity;
                $company = $user->company;
                $firm_id = $user->firm_id;
                
                $user = new Users();
                $user->name = "";
                $user->surname = "";
                $user->phone = "";
                $user->company = $company;
                $user->email = $email;
                $user->city = "";
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = "";
                $user->firm_id = $firm_id;
                $user->type = 2;

                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('employer');
        
                Yii::$app->authManager->assign($role,$id);
                
                 Yii::$app->mailer->compose()
                ->setFrom('robot@jobgis.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Поздравляем вы удачно зарегистрировались на сайте jobgis.ru. Ваш email: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html>Поздравляем вы удачно зарегистрировались на сайте jobgis.ru<br>Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                
                return $this->render("message",["message"=>"На  email выслан пароль"]);
            }
        }
        return $this->render('addworker',['errors' => $errors]);
    }
    
    public function actionAddinfo(){
        $user = Yii::$app->user->identity;
        $user  = Users::find()->where(["id" => $user->id])->one();
        $errors = [];
        
        if(isset($_POST) && !empty($_POST)){
            if(strlen($_POST["phone"]) < 18){
               $errors[] = "Не верный формат нормера";
            }
            
            if(empty($errors)){
                $user->name = $_POST["name"];
                $user->surname = $_POST["surname"];
                $user->patronymic = $_POST["patronymic"];
                $user->phone = $_POST["phone"];
                $user->city = $_POST["city"];

                $user->save(false);
                return $this->redirect("/");
            }

        }
        
        return $this->render("addinfo",["errors" => $errors,"user" => $user]);
    }
    
    public function actionAddinn(){
        if(isset($_POST["inn"]) && !empty($_POST["inn"])){
            $user = Yii::$app->user->identity;
            $firm = Firm::find()->where(["id" => $user->firm_id])->one();
            $firm->inn = (int)mb_substr($_POST["inn"],0,10);
            $firm->category = $_POST["category"];
            $firm->city = $_POST["city"];

            $firm->save(false);
            
                            
            Yii::$app->mailer->compose()
            ->setFrom('robot@jobgis.ru')
            ->setTo("admin@jobgis.ru")
            ->setSubject('Работодатель ожидает верификации на сайте jobgis.ru')
            ->setTextBody("Работодатель ожидает верификации". $firm->name)
            ->setHtmlBody("<html>Работодатель ожидает верификации". $firm->name. "</html>")
            ->send();
            
            
            return $this->redirect("/");
        }
        return $this->render("addinn");
    }
    
    public function actionVerify(){
        return $this->render("/site/verify");
    }
    
    public function actionUseredit(){
        $user = Yii::$app->user->identity;
        $errors = [];
        
        $firm = Firm::find()->where(["id" => $user->firm_id])->one();  

        $role = "guest";
        $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!empty($roleArr)){
            $roleObj = array_shift($roleArr);
            $role = $roleObj->name;
        }
        
        if(isset($_POST["name"]) && !empty($_POST["name"])){
            $user = Users::find()->where(["id" => $user->id])->one();
            
            $user->name = $_POST["name"];
            $user->surname = $_POST["surname"];
            $user->patronymic = $_POST["patronymic"];
            $user->phone = $_POST["phone"];
            $user->city = $_POST["city"];
            $user->save(false);
            return $this->render("message",["message" => "Настройки сохранены"]);
        }
        
        if(isset($_POST["about"])&& !empty($_POST["about"])){

            $firm->site = $_POST['site'];
            $firm->about = $_POST['about'];
            $firm->save(false);
        }
        
        $firm = Firm::find()->where(["id" => $user->firm_id])->one();  
        
        if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
            $path = $_FILES['image']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if($ext == "jpg" OR $ext == "jpeg"){
            
                $dirPath="/var/www/basic/web/img/";

                if($firm->logo != ""){
                    if(file_exists($dirPath.$firm->logo)){
                        unlink($dirPath.$firm->logo); 

                    }
                }


               //print_r($_FILES);exit;
                $uploadedFile=$_FILES['image']['tmp_name']; 
                $sourceProperties=getimagesize($uploadedFile);
                $newFileName=time();

                if($sourceProperties[0] == $sourceProperties[1]){

                    $ext=pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    $imageSrc= imagecreatefromjpeg($uploadedFile); 

                    $tmp= $this->imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
                    imagejpeg($tmp,$dirPath.$newFileName."_thump.".$ext);

                    $firm->logo = $newFileName."_thump.".$ext;
                    $firm->save(false);
                } else {
                    $errors[] = "Загрузите квадратное изображение";

                }
            }else{
                $errors[] = "Загрузите изображение в формате jpg";
            }
            //move_uploaded_file($uploadedFile, $dirPath.$newFileName.".".$ext);

            
       }
       
        return $this->render("useredit",["errors" => $errors,"user" => $user,"role" => $role,"firm" => $firm]);
    }
    
    public function actionCompany(){
        $user = Yii::$app->user->identity;
        $firm = Firm::find()->where(["id" => $user->firm_id])->one();  
        $errors = [];
        if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
            $path = $_FILES['image']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            
            if($ext == "jpg" OR $ext == "jpeg"){
                $dirPath="/var/www/basic/web/img/";
            
                if($firm->logo != ""){
                    unlink($dirPath.$firm->logo); 
                }


               //print_r($_FILES);exit;
                $uploadedFile=$_FILES['image']['tmp_name']; 
                $sourceProperties=getimagesize($uploadedFile);
                $newFileName=time();
                
                if($sourceProperties[0] == $sourceProperties[1]){

                    $ext=pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    $imageSrc= imagecreatefromjpeg($uploadedFile); 

                    $tmp= $this->imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
                    imagejpeg($tmp,$dirPath.$newFileName."_thump.".$ext);

                    $firm->logo = $newFileName."_thump.".$ext;


                    $firm->save(false);
                }else{
                    $errors[]= "Загрузите квадратное изображение";

                }
            }else{
                $errors[]= "Загрузите картинку в формате jpg";
            }
            
            
            //move_uploaded_file($uploadedFile, $dirPath.$newFileName.".".$ext);

            
       }
        
        if(isset($_POST)&& !empty($_POST)){

            $firm->site = $_POST['site'];
            $firm->about = $_POST['about'];
            $firm->save();
            return $this->redirect("/");
        }
        return $this->render("company",["errors" => $errors]);
    }
    
       function imageResize($imageSrc,$imageWidth,$imageHeight) {

        $newImageHeight=80;
       if($newImageHeight >= $imageHeight){
           $newImageHeight = $imageHeight;
           $newImageWidth=$imageWidth;
           
       }else{
            $newImageHeight=80;
            $percent = $imageHeight / 100;
            $resizePercent = $newImageHeight/$percent;
            
            $widthPerncet = $imageWidth/100;
            $newImageWidth = $resizePercent * $widthPerncet;
            
       }

       $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
       imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

       return $newImageLayer;
    }
    
    public function actionRss(){
       $vacancys = Vacancy::find()->where('name != :name', ['name'=>"Заполните вакансию"])->orderBy(["create_time" => SORT_DESC])->limit(20)->all();
       $items = "";

        $response = Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
    $response->getHeaders()->set('Content-Type', 'application/xml; charset=utf-8');

       foreach($vacancys as $vacancy){
           $items .= "<item>";
           $items .= "<title>{$vacancy->name}</title>";
           $items .= "<link>https://jobgis.ru/vacancy/show?id={$vacancy->id}</link>";
           $items .= "<description>";
            $items .= "$vacancy->name ";

           if((bool)$vacancy->costfrom):
                 $items .= " от {$vacancy->costfrom}";
           endif;
           
           if((bool)$vacancy->costto):
                $items .= " до  {$vacancy->costto}";
            endif;
            
            $items .= " " . $vacancy->user->firm->name;
            $items .= " " . $vacancy->city;

            $items .= " Требуемый опыт работы: " . $vacancy->employment;
            $items .= " " . $vacancy->user->firm->name;
            $items .= " " . str_replace("&nbsp;","",strip_tags($vacancy->description));

           $items .= "</description>";
           $items .= "<pubDate>" . date('r', $vacancy->create_time). "</pubDate>";
           $items .= "<guid>https://jobgis.ru/vacancy/show?id={$vacancy->id}</guid>";
           
           $items .= "</item>";

       }
       
        $news = News::find()->orderBy(["create_time" => SORT_DESC])->limit(10)->all();
        foreach($news as $new){
           $items .= "<item>";
           $items .= "<title>{$new->title}</title>";
           $items .= "<link>https://jobgis.ru/news/view?id={$new->id}</link>";
           $items .= "<description>";
           $items .= " " . str_replace("&nbsp;","",strip_tags($new->description));

           $items .= "</description>";
           $items .= "<pubDate>" . date('r', $new->create_time). "</pubDate>";
           $items .= "<guid>https://jobgis.ru/news/view?id={$new->id}</guid>";
           
           $items .= "</item>";
        }
       
       $text = '<?xml version="1.0"  encoding="UTF-8" ?> 
                <rss xmlns:g="http://base.google.com/ns/1.0" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
                    <channel>
                    <atom:link href="https://jobgis.ru/site/rss" rel="self" type="application/rss+xml" />

                       <title>Jobgis</title> 
                       <link>https://jobgis.ru/</link> 
                       <description>Сервис для работодателей и соискателей</description> 
                        ' .$items. '
                    </channel>
                </rss>';
       return $text;
    }
    
}
