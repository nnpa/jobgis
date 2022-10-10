<?php

namespace app\modules\admin;
use Yii;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!array_key_exists("admin", $roleArr)){
            exit;
        }
        $this->layout = 'admin';

        parent::init();
        
        // custom initialization code goes here
    }
}
