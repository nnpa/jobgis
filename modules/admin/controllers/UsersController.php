<?php

namespace app\modules\admin\controllers;
use Yii;

use app\models\Users;
use app\models\UsersSearch;
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
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams,false,true);
        $dataProvider->sort = [
            'defaultOrder' => [
                'id' => SORT_ASC,
                'params' => \Yii::$app->getRequest()->post(),
                'attributes' => []

            ]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

        public function actionCan()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams,false,false);
        $dataProvider->sort = [
            'defaultOrder' => [
                'id' => SORT_ASC,
                'params' => \Yii::$app->getRequest()->post(),
                'attributes' => []

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
        $this->findModel($id)->delete();
        
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
        $users = Users::find()->where(['>', 'online', time()])->all();
        return $this->render('online',["users" => $users]);
        
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
}
