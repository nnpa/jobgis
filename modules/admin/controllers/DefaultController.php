<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\models\AuthAssignment;
use app\models\Firm;
use app\models\Vacancy;
use app\models\Users;
use app\models\Recruiter;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        

        
        
        $sql = "SELECT vacancy.*,firm.name as firm_name,firm.logo,firm.id as firm_id FROM `vacancy` "
                . " INNER JOIN Users ON vacancy.user_id = Users.id"
                . " INNER JOIN firm ON Users.firm_id = firm.id"
                . " WHERE 1=1 AND vacancy.name != 'Заполните должность'";
        $url = "http://jobgis.ru/search/vacancy?test=1";
        $sqlCount = "SELECT COUNT(*) FROM `vacancy` WHERE 1=1 AND name != 'Заполните должность'";
        
        if(isset($_GET["name"]) && !empty($_GET['name'])){
            $name = $_GET["name"];
            $sql .= " AND vacancy.`name` = '". mysqli_real_escape_string($conn,$name)."'";
            $sqlCount .= " AND `name` = '". mysqli_real_escape_string($conn,$name)."'";
            $url .= "&name=" . $name; 
        }else {
            $name = "";
        }
        
        
        if(isset($_GET["city"]) && !empty($_GET['city'])){
            $city = $_GET['city'];
            $sql .= " AND vacancy.`city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city; 
        }else {
            $city = "";
        }
        
        if(isset($_GET["cost"]) && !empty($_GET['cost'])){
            $cost = (int)$_GET["cost"];
            $sql .= " AND `costfrom` > ". mysqli_real_escape_string($conn,$cost);
            $sqlCount .= " AND `costfrom` > ". mysqli_real_escape_string($conn,$cost);
            $url .= "&cost=" . $cost; 
        }else {
            $cost = "";
        }
        
        if(isset($_GET["spec"]) && !empty($_GET['spec'])){
            $spec = $_GET["spec"];
            $sql  .= " AND `spec` = '". mysqli_real_escape_string($conn,$spec)."'";
            $sqlCount .= " AND `spec` = '". mysqli_real_escape_string($conn,$spec)."'";
            $url .= "&spec=" . $spec; 
        }else {
            $spec = "";
        }
        
        if(isset($_GET["exp"]) && !empty($_GET['exp'])){
            $exp = $_GET["exp"];

            if($exp != "no"){
                $sql .= " AND `exp` = '". mysqli_real_escape_string($conn,$exp)."'";
                $sqlCount .= " AND `exp` = '". mysqli_real_escape_string($conn,$exp)."'";
                $url .= "&exp=" . $exp; 
            }


        }else {
            $exp = "no";
        }
        
        if(isset($_GET["employment"]) && !empty($_GET['employment'])){
            $employment = $_GET["employment"];
            
            $sql .= " AND `employment` = '". mysqli_real_escape_string($conn,$employment)."'";
            $sqlCount .=  " AND `employment` = '". mysqli_real_escape_string($conn,$employment)."'";
            
            $url .= "&employment=" . $employment; 

        }else {
            $employment = "Полная занятость";
        }
        
        $sql .=  " ORDER BY `rsort`,`create_time`";
        
        if($page == 1){
            $limit = " limit 0,".$perPage;
        }else{
            $limit = " limit " . ($page * $perPage). ",". $perPage;
        }
        
        $sql .= $limit ;
        
        $connection = Yii::$app->getDb();
        
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        
        $command = $connection->createCommand($sqlCount);
        $count = $command->queryAll();
        $count = (int)$count[0]["COUNT(*)"];
        
        $pages = $count/$perPage;
        
        return $this->render("vacancy",[
            "city" => $city,
            "spec" => $spec,
            "exp" => $exp,
            "cost" => $cost,
            "employment" => $employment,
            "name" => $name,
            "result" => $result,
            'page' => $page,
            'pages' => $pages,
            "url" => $url
        ]);
    }
    
        public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionManager(){
        $managers = AuthAssignment::find()->where(["item_name" => "manager"])->all();
        $recruiters = AuthAssignment::find()->where(["item_name" => "recruiter"])->all();

        return $this->render('managers',["recruiters"=> $recruiters,"managers" => $managers]);
    }
    
    public function actionManagerdelete($id){
        $manager = AuthAssignment::find()->where(["user_id" => $id,"item_name" =>"manager"])->one();

        if(isset($_POST["manager"])){
            $firms = Firm::find()->where(["manage_id" => $id])->all();
            foreach($firms as $firm){
                $firm->manage_id = $_POST["manager"];
                $firm->save(false);
            }
            
            $manager->delete();
            return $this->redirect("/admin/default/manager");

        }

        $manager = AuthAssignment::find()->where(["user_id" => $id,"item_name" =>"manager"])->one();

        return $this->render("deletemanager",["manager"=>$manager]);
    }
    
    public function actionRecruiterdelete($id){
        $manager = AuthAssignment::find()->where(["user_id" => $id,"item_name" =>"recruiter"])->one();

        if(isset($_POST["manager"])){
            $firms = Firm::find()->where(["manage_id" => $id])->all();
            foreach($firms as $firm){
                $firm->manage_id = $_POST["manager"];
                $firm->save(false);
            }
            
            $manager->delete();
            return $this->redirect("/admin/default/manager");

        }

        $manager = AuthAssignment::find()->where(["user_id" => $id,"item_name" =>"manager"])->one();

        return $this->render("deletemanager",["manager"=>$manager]);
    }
    
public function actionAdd(){
        
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
                
                
                $user = new Users();
                $user->name = "";
                $user->surname = "";
                $user->phone = "";
                $user->company = "JOBGIS";
                $user->email = $email;
                $user->city = "";
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = "";
                $user->firm_id = 29;
                $user->type = 2;
                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('manager');
        
                Yii::$app->authManager->assign($role,$id);
                
                 Yii::$app->mailer->compose()
                ->setFrom('robot@jobgis.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody(" Проект JOBGIS предлагает вам вступить в команду менеджеров! по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690" . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html>Проект JOBGIS предлагает вам вступить в команду менеджеров! <br> по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690 Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                
                return $this->render("message",["message"=>"На  email выслан пароль"]);
            }
        }
        return $this->render("add");
    }
    public function getPassword(){
        $password = substr(md5(time()),0,6);
        return $password;
    }
    
    public function actionRecruiter($id){
        if(isset($_POST) && !empty($_POST)){
            $recruiter = new Recruiter();
            $recruiter->user_id= $id;

            $recruiter->name= $_POST["name"];
            $recruiter->city= $_POST["city"];
            $recruiter->save(false);
        }
        
        $firms = Firm::find()->where(["manage_id" => $id])->all();
        $user = Users::find()->where(["id" => $id])->one();
        
        $recruiters = Recruiter::find()->where(["user_id" =>$id])->all();
        

        return $this->render("recruiter",["firms" => $firms,"user" => $user,"recruiters" => $recruiters]);
    }
    

    
    public function actionRd($id,$recruiter){
        $spec = Recruiter::find()->where(["id" => $id])->one();
        $spec->delete();
        return $this->redirect("/admin/default/recruiter?id=" . $recruiter);
    }
    
    public function actionUpvacancy($id){
        $vacancy = Vacancy::find()->where(["id" => $id])->one();
        $vacancy->rsort = $vacancy->rsort + 1;
        $vacancy->save(false);
        return $this->redirect("/admin/default/index");
    }
}
