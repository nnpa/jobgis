<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Users;

class AppController extends Controller{

    public function beforeAction($action){
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;

            if($user->name == "" OR $user->surname == "" OR $user->phone == "" OR $user->city == ""){
                if($action->actionMethod != "actionAddinfo"){
                    return $this->redirect("/site/addinfo"); 
                }
            }
            
            if($user->firm_id != 0){
                if($user->firm->inn == 0 OR $user->firm->category == "" AND $user->firm->city == ""){
                    if($action->actionMethod != "actionAddinn" OR $action->actionMethod != "city"){
                        return $this->redirect("/site/addinn"); 
                    }
                }
            }
            if($user->firm_id != 0){
                if($user->firm->verify == 0){
                    if($action->actionMethod != "actionVerify"){
                        return $this->redirect("/site/verify"); 
                    }
                }
            }
        }
        
        

        return parent::beforeAction($action);
    }
}