<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\models\AuthAssignment;

/**
 * Default controller for the `admin` module
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
    
    public function actionManagers(){
        $managers = AuthAssignment::find()->where(["item_name" => "manager"])->all();
        
        return $this->render('managers',["managers" => $managers]);
    }
}
