<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\models\Support;

/**
 * Default controller for the `admin` module
 */
class SupportController extends Controller
{
    public $enableCsrfValidation = false;
    
    public function actionIndex(){
        $messages = Support::find()->where(["to_id" => 0])->groupBy(['from_id'])->all();
        
        return $this->render('index',["messages"=>$messages]);
    }
    
    public function actionMessages($id){
        if(isset($_POST["message"]) && !empty($_POST["message"])){
            $support = new Support();
            $support->from_id = 0;
            $support->to_id   = $id;
            $support->view    = 0;
            $support->message = $_POST["message"];
            $support->save(false);
        }
        $messages = Support::find()->where(["from_id" => $id])->orWhere(["to_id"=>$id])->all();

        return $this->render("messages",["messages"=>$messages]);
    }
}
