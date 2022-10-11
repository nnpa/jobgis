<?php

namespace app\modules\manager\controllers;
use Yii;

use yii\web\Controller;

/**
 * Default controller for the `manager` module
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
    
    public function actionLogout(){
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    
}
