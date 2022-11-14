<?php

namespace app\modules\recruiter\controllers;
use Yii;

use app\models\Users;
use app\models\UsersSearch;
use app\models\Firm;
use app\models\Recruiter;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
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
     * Lists all Users models.
     *
     * @return string
     */
    public function actionEm()
    {
        $manager  = Yii::$app->user->identity;
        $id  = $manager->id;
        
        $firms = Firm::find()->where(["manage_id" => $id])->all();
        
        $ids= [1];
        foreach($firms as $firm){
            $ids[] = $firm->id;
        }
        
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams,$ids,true);
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
    
    public function actionCan()
    {
        $manager  = Yii::$app->user->identity;
        $id  = $manager->id;
        
        $cities = [];
        $names = [];
        
        $rectruiters = Recruiter::find()->where(["user_id" => $id])->all();
        
        foreach($rectruiters as $recruiter){
            $names[] = $recruiter->name;
            $cities[] = $recruiter->city;
        }
        
        
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->recruiter($this->request->queryParams,$names,$cities);
        
        $dataProvider->sort = [
            'defaultOrder' => [
                'id' => SORT_DESC,
            ]
        ];
        return $this->render('index_1', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Users();

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
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost ){
            $model->name = $_POST["Users"]["name"];
            $model->surname = $_POST["Users"]["surname"];
            $model->company = $_POST["Users"]["company"];
            $model->phone = $_POST["Users"]["phone"];
            $model->city = $_POST["Users"]["city"];
            $model->email = $_POST["Users"]["email"];
            $model->password = $_POST["Users"]["password"];
            $model->firm_id = $_POST["Users"]["firm_id"];

            $model->save(false);
            
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Users model.
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionOn(){
        $manager  = Yii::$app->user->identity;
        $id  = $manager->id;
        
        $firms = Firm::find()->where(["manage_id" => $id])->all();
        
        $ids= [];
        foreach($firms as $firm){
            $ids[] = $firm->id;
        }
        
        $userArr = [];
        
        $users = Users::find()->where(['>', 'online', time()])->all();
        foreach ($users as $user){
            if(in_array($user->firm_id,$ids)){
                $userArr[] = $user;
            }
        }
        
        return $this->render('online',["users" => $userArr]);
        
    }
    
    public function actionAddmanager($id){
            $role = "";
            $roleArr = \Yii::$app->authManager->getRolesByUser($id);
            if(!empty($roleArr)){

                foreach($roleArr as $roleObj){
                    if($roleObj->name == "manager"){
                        $role = "manager";
                    }
                }

            }
            
          if($role != "manager"){
            $role = Yii::$app->authManager->getRole('manager');
        
            Yii::$app->authManager->assign($role,$id);
          }

          $this->redirect("/admin/users/index");
    }
    
    public function actionInfo(){
        $user = Yii::$app->user->identity;
        $user  = Users::find()->where(["id" => $user->id])->one();
        $errors = [];
        
        if(isset($_POST) && !empty($_POST)){
            if(strlen($_POST["phone"]) < 18){
               $errors[] = "Не верный формат нормера";
            }
            
            if(empty($errors)){
                $user->name = $_POST["name"];
                $user->surname = $_POST["surname"];
                $user->patronymic = $_POST["patronymic"];
                $user->phone = $_POST["phone"];

                $user->save(false);
                return $this->redirect("/recruiter/default/addinfo");
            }

        }
        
        return $this->render("addinfo",["errors" => $errors,"user" => $user]);
    }
    

}
