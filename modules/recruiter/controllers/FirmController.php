<?php

namespace app\modules\recruiter\controllers;

use app\models\Firm;
use app\models\FirmSearch;
use app\models\Users;
use app\models\Vacancy;
use app\models\Response;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\data\Pagination;

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
        
    public function actionAdd(){
        $id = Yii::$app->user->id;
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
                $firm->manage_id = $id ;
                $firm->inn = 0;
                $firm->city = "";
                $firm->save(false);
                
                
                $user = new Users();
                $user->name = "";
                $user->surname = "";
                $user->phone = "";
                $user->company = $_POST["company"];
                $user->email = $email;
                $user->city = "";
                $user->recover_code = "";
                $user->auth_key = "";
                $user->access_token = "";
                $user->password = $this->getPassword();
                $user->create_time = time();
                $user->patronymic = "";
                $user->firm_id = $firm->id;
                $user->type = 2;

                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('employer');
        
                Yii::$app->authManager->assign($role,$id);
                
                 Yii::$app->mailer->compose()
                ->setFrom('jobgis.ru@yandex.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Добрый день! Проект JOBGIS предлагает вам совершенно бесплатно воспользоваться нашим сервисом поиска соискателей и размещать свои вакансии. по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690 Ваш логин: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html><br>Добрый день!<br> Проект JOBGIS предлагает вам совершенно бесплатно воспользоваться нашим сервисом поиска соискателей и размещать свои вакансии. <br> по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690 <br> Ваш логин: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                
                return $this->render("message",["message"=>"На  email выслан пароль"]);
            }
        }
        return $this->render("add",["id" => $id,"errors" =>$errors]);
    }
    
    public function actionAddcan(){
        $id = Yii::$app->user->id;
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
                $user->type = 1;

                
                $user->save(false);
                
                $id = $user->id;
                
                $role = Yii::$app->authManager->getRole('candidate');
        
                Yii::$app->authManager->assign($role,$id);
                
                 Yii::$app->mailer->compose()
                ->setFrom('jobgis.ru@yandex.ru')
                ->setTo($user->email)
                ->setSubject('Регистрация на сайте jobgis.ru')
                ->setTextBody("Добрый день! Проект JOBGIS предлагает вам совершенно бесплатно воспользоваться нашим сервисом поиска соискателей и размещать свои вакансии. по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690 Ваш логин: " . $user->email . "  Ваш пароль: " . $user->password)
                ->setHtmlBody("<html><br>Добрый день!<br> Проект JOBGIS предлагает вам совершенно бесплатно воспользоваться нашим сервисом поиска соискателей и размещать свои вакансии. <br> по всем вопросам работы сервиса вы можете обратиться к нам по телефону: +79174626690 <br> Ваш логин: " . $user->email . " <br> Ваш пароль: " . $user->password . "<br> <a href='http://".Yii::$app->params['url'] ."/site/login'>Войти</a></html>")
                ->send();
                
                return $this->render("message",["message"=>"На  email выслан пароль"]);
            }
        }
        return $this->render("add",["id" => $id,"errors" =>$errors]);
    }
    
    public function getPassword(){
        $password = substr(md5(time()),0,6);
        return $password;
    }
    
    public function actionVacancy(){
        $user = Yii::$app->user->identity;
        
        $firms = Firm::find()->where(["manage_id" => $user->id])->all();
        
        $firmIds = [];
        
        foreach($firms as $firm){
            $firmIds[] = $firm->id;
        }
        
        $userIds = [];
        
        $users = Users::find()->where(["firm_id" => $firmIds])->all();
        
        foreach($users as $user){
            $userIds[] = $user->id;
        }
        
        $vacancies = Vacancy::find()->where(["user_id" =>$userIds])->all();
        
        return $this->render("vacancy",["vacancies" => $vacancies]);
    }
    
    public function actionResponse(){
        $user = Yii::$app->user->identity;
        
        $firms = Firm::find()->where(["manage_id" => $user->id])->all();
        
        $firmIds = [];
        
        foreach($firms as $firm){
            $firmIds[] = $firm->id;
        }
        
        $userIds = [];
        
        $users = Users::find()->where(["firm_id" => $firmIds])->all();
        
        foreach($users as $user){
            $userIds[] = $user->id;
        }
        
        $vacancy = Vacancy::find()->where(["user_id" =>$userIds ])->all();
        $ids = [];
        foreach($vacancy as $v){
            $ids[] = $v->id;
        }
        
        
        $query = Response::find()->where(["vacancy_id" => $ids])->orderBy(["id" => SORT_DESC]);
        $pages = new Pagination(['totalCount' => $query->count(),'pageSize' => 5]);
        $response = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render("employer",["response" => $response,'pages'=>$pages]);
    }
}
