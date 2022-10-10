<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Users;

class AppController extends Controller{

    public function beforeAction($action){
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $user = Users::find()->where(["id" => $user->id])->one();
            $actions = [
                "actionAddinfo",
                "actionLogin",
                "actionAddinn",
                "actionVerify",
                "actionCity"
            ];
            
            if(($user->name == "") OR ($user->surname == "") OR ($user->phone == "") OR ($user->city)){
                var_dump($user->name == "" OR $user->surname == "");exit;
                echo $user->name . " " .$user->surname . " " . $user->phone . " " .$user->city;exit;
                if(!in_array($action->actionMethod, $actions)){
                    return $this->redirect("/site/addinfo"); 
                }
            }
            
            if($user->firm_id != 0){
                if($user->firm->inn == 0 OR $user->firm->category == "" OR $user->firm->city == ""){
                    if(!in_array($action->actionMethod, $actions)){
                        return $this->redirect("/site/addinn"); 
                    }
                }
            }
            if($user->firm_id != 0){
                if($user->firm->verify == 0){
                    if(!in_array($action->actionMethod, $actions)){
                        
                        return $this->redirect("/site/verify"); 
                    }
                }
            }
        }
        
        

        return parent::beforeAction($action);
    }
}