<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\models\AuthAssignment;
use app\models\Firm;

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
        return $this->render('index');
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
    

}
