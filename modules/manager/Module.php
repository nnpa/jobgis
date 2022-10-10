<?php

namespace app\modules\manager;
use Yii;

/**
 * manager module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\manager\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!array_key_exists("manager", $roleArr)){
            exit;
        }
        $this->layout = 'manager';
        parent::init();

        // custom initialization code goes here
    }
}
