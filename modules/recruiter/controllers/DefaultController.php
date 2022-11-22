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
    public function actions(){
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
        ];
    }
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
    

    
}
