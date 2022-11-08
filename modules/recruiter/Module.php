<?php

namespace app\modules\recruiter;
use Yii;

/**
 * recruiter module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\recruiter\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        
        $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!array_key_exists("recruiter", $roleArr)){
            exit;
        }
        $this->layout = 'recruiter';

        parent::init();

        // custom initialization code goes here
    }
}
