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
            
            if($user->name == "" OR $user->surname == "" OR $user->phone == "" OR $user->city == ""){
                if($action->actionMethod != "actionAddinfo" AND $action->actionMethod != "actionLogin" ){
                    return $this->redirect("/site/addinfo"); 
                }
            }
            
            if($user->firm_id != 0){
                if($user->firm->inn == 0 OR $user->firm->category == "" AND $user->firm->city == ""){
                    if($action->actionMethod != "actionAddinn" AND $action->actionMethod != "city" AND $action->actionMethod != "actionLogin"){
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