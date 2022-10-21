<?php

namespace app\modules\manager\controllers;

use app\models\Firm;
use app\models\FirmSearch;
use app\models\Users;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * FirmController implements the CRUD actions for Firm model.
 */
class FirmController extends Controller
{
        public $enableCsrfValidation = false;

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Firm models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FirmSearch();
        $user = Yii::$app->user->identity;

        $dataProvider = $searchModel->search($this->request->queryParams,$user->id);
        $dataProvider->sort = [
            'defaultOrder' => [
                'id' => SORT_DESC,
            ]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Firm model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Firm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Firm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Firm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Firm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Firm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Firm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Firm::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionSetmanager($id){
        if(isset($_POST["manager"]) && !empty($_POST["manager"])){
           $firm = Firm::find()->where(["id" => $id])->one();
           $firm->manage_id = $_POST["manager"];
           $firm->save(false);
           return $this->redirect("/admin/firm/index");
        }
    }
    
    public function actionAdd(){
        
        $errors = [];
        if(isset($_POST["email"]) && !empty($_POST["email"])){
            $email = $_POST['email'];
            
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Не верный формат email";
            }
            
            $user = Users::find()->where(["email" => $_POST["email"]])->one();
            if(!is_null($user)){
                $errors[] = "Такой email уже зарегистрирован";
            }
            
            if(empty($errors)){
                $firm = new Firm();
                $firm->name =  $_POST["company"];
                $firm->verify = 0 ;
                $firm->manage_id = 0 ;
                $firm->inn = 0;
                $firm->city = "";
                $firm->save(false);
                
                
                $user = new Users();
                $user->name = "";
                $user->surname = "";
                $user->phone = "";
                $user->company = "";
                $user->email = $email;
                $user->city = "";
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = "";
                $user->firm_id = $firm->id;
                
                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('employer');
        
                Yii::$app->authManager->assign($role,$id);
                
                 Yii::$app->mailer->compose()
                ->setFrom('robot@jobgis.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Добрый день! Проект JOBGIS предлагает вам совершенно бесплатно воспользоваться нашим сервисом поиска соискателей и размещать свои вакансии. по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690 Ваш email: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html><br>Добрый день!<br> Проект JOBGIS предлагает вам совершенно бесплатно воспользоваться нашим сервисом поиска соискателей и размещать свои вакансии. <br> по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690 <br> Ваш email: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                
                return $this->render("message",["message"=>"На  email выслан пароль"]);
            }
        }
        return $this->render("add");
    }
    
    public function getPassword(){
        $password = substr(md5(time()),0,6);
        return $password;
    }
}
