<?php

namespace app\modules\recruiter\controllers;

use yii\web\Controller;
use Yii;
use app\models\Users;

/**
 * Default controller for the `recruiter` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
            public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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

                $user->save(false);
                return $this->redirect("/recruiter/default/addinfo");
            }

        }
        
        return $this->render("addinfo",["errors" => $errors,"user" => $user]);
    }
}
