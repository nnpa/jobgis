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
            
            $user->online = time() + 60*5;
            $user->save(false);
            $actions = [
                "actionAddinfo",
                "actionLogin",
                "actionAddinn",
                "actionVerify",
                "actionCity",
                "actionCompany"

            ];
            
            if(($user->name == "") OR ($user->surname == "") OR ($user->phone == "") OR ($user->city == "")){
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
            if($user->firm_id != 0){
                 if(is_null($user->firm->about)){
                    if(!in_array($action->actionMethod, $actions)){

                        return $this->redirect("/site/company"); 
                    }
                 }
            }

        }
        
        

        return parent::beforeAction($action);
    }
}