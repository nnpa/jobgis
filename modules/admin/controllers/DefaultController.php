<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\models\AuthAssignment;
use app\models\Firm;
use app\models\Vacancy;
use app\models\Users;

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
        $vacancys = Vacancy::find()->where('name != :name', ['name'=>"Заполните вакансию"])->orderBy(["create_time" => SORT_DESC])->limit(10)->all();

        return $this->render('index',["vacancys" => $vacancys]);
    }
    
        public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionManager(){
        $managers = AuthAssignment::find()->where(["item_name" => "manager"])->all();
        
        return $this->render('managers',["managers" => $managers]);
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
}
