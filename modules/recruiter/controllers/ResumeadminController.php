<?php

namespace app\modules\recruiter\controllers;

use app\models\Resume;
use app\models\ResumeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use app\models\ResumeExp;
use app\models\ResumePortfolio;
use app\models\ResumeEdu;
use app\models\ResumeAddedu;
use app\models\Recruiter;

/**
 * ResumeadminController implements the CRUD actions for Resume model.
 */
class ResumeadminController extends Controller
{
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
     * Lists all Resume models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $manager  = Yii::$app->user->identity;
        $id  = $manager->id;
        
        $cities = [1];
        $names = [1];
        
        $rectruiters = Recruiter::find()->where(["user_id" => $id])->all();
        
        foreach($rectruiters as $recruiter){
            $names[] = "'" . $recruiter->name . "'";
            $cities[] = "'" . $recruiter->city . "'";
        }
        
        $names = implode(",",$names);
        $cities = implode(",",$cities);
        
        
  if(isset($_GET["page"]) && !empty($_GET["page"])){

        $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");

        $sql = "SELECT * FROM `resume` WHERE 1=1  AND `vacancy` != 'Заполните должность' AND `verify` = 1 ";
        
        
        
        $url = "/admin/resumeadmin/index?test=1";
        $sqlCount = "SELECT COUNT(*) FROM `resume` WHERE 1=1 != 'Заполните должность' AND `verify` = 1";
        
        if(count($names)>1){
           $sql .= " AND specsub IN (" .$names. ") AND city IN (".$cities.")";
           $sqlCount .= " AND specsub IN (" .$names. ") AND city IN (".$cities.")";
        }
        
        if(isset($_GET["name"]) && !empty($_GET['name'])){
            $name = $_GET["name"];
            $sql .= " AND `vacancy` = '". mysqli_real_escape_string($conn,$name)."'";
            $sqlCount .= " AND `vacancy` = '". mysqli_real_escape_string($conn,$name)."'";
            $url .= "&name=" . $name; 
        }else {
            $name = "";
        }
        
        if(isset($_GET["city"]) && !empty($_GET['city'])){
            $city = $_GET['city'];
            $sql .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city; 
        }else {
              $city = "";
        }
        
        if(isset($_GET["relocation"]) && !empty($_GET["relocation"])){
            $relocation = $_GET['relocation'];
            $sql .= " AND `relocation` = '". mysqli_real_escape_string($conn,$relocation)."'";
            $sqlCount .= " AND `relocation` = '". mysqli_real_escape_string($conn,$relocation)."'";
            $url .= "&relocation=" . $relocation; 
        }else{
            $relocation = "Невозможен";
        }
        
        if(isset($_GET["costfrom"]) && !empty($_GET["costfrom"])){
            $costfrom = $_GET['costfrom'];
            $sql .= " AND `cost` > '". mysqli_real_escape_string($conn,(int)$costfrom)."'";
            $sqlCount .= " AND `cost` > '". mysqli_real_escape_string($conn,(int)$costfrom)."'";
            $url .= "&costfrom=" . $costfrom; 
        }else{
            $costfrom = "";
        }
        
        if(isset($_GET["costto"]) && !empty($_GET["costto"])){
            $costto = $_GET['costto'];
            $sql .= " AND `cost` < '". mysqli_real_escape_string($conn,(int)$costto)."'";
            $sqlCount .= " AND `cost` < '". mysqli_real_escape_string($conn,(int)$costto)."'";
            $url .= "&costfrom=" . $costfrom; 
        }else{
            $costto = "";
        }
        
        if(isset($_GET['employment']) && !empty($_GET['employment'])){
            $employment = $_GET['employment'];
            $sql .= " AND `".mysqli_real_escape_string($conn,$employment)."` = 1 ";
            $sqlCount .= " AND `".mysqli_real_escape_string($conn,$employment)."` = 1 ";
            $url .= "&empoyment=" . $employment; 
        }else{
            $employment = "employment_full";
        }

        if(isset($_GET['schedule']) && !empty($_GET['schedule'])){
            $schedule = $_GET['schedule'];
            $sql .= " AND `".mysqli_real_escape_string($conn,$schedule)."` = 1 ";
            $sqlCount .= " AND `".mysqli_real_escape_string($conn,$schedule)."` = 1 ";
            $url .= "&schedule=" . $schedule; 
        }else{
            $schedule = "schedule_full";
        }
        
        if(isset($_GET["spec"]) && !empty($_GET['spec'])){
            $spec = $_GET["spec"];
            $sql  .= " AND `spec` = '". mysqli_real_escape_string($conn,$spec)."'";
            $sqlCount .= " AND `spec` = '". mysqli_real_escape_string($conn,$spec)."'";
            $url .= "&spec=" . $spec; 
        }else {
            $spec = "";
        }
        
        $sql .=  " ORDER BY `verify` ASC ";
        
        if($page == 1){
            $limit = " limit 0,".$perPage;
        }else{
            $limit = " limit " . ($page * $perPage). ",". $perPage;
        }
        
        $sql .= $limit ;
        
        $connection = Yii::$app->getDb();
        
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        
        $command = $connection->createCommand($sqlCount);
        $count = $command->queryAll();
        $count = (int)$count[0]["COUNT(*)"];
        
        $pages = $count/$perPage;
        
        return $this->render("resume",[
            "name" => $name,
            "city" => $city,
            'spec' => $spec,
            'costfrom' => $costfrom,
            "costto" => $costto,
            "employment" => $employment,
            "schedule" => $schedule,
            "relocation" => $relocation,
            "result" => $result,
            'page' => $page,
            'pages' => $pages,
            "url" => $url
        ]);
    }

    /**
     * Displays a single Resume model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
    $resume = Resume::find()->where(["id" => $id])->one();

       $resumeEdu = ResumeEdu::find()->where(["resume_id" => $id])->all();
       $resumeExp = ResumeExp::find()->where(["resume_id" => $id])->all();
       $resumePortfolio = ResumePortfolio::find()->where(["resume_id" => $id])->all();
       $resumeAddEdu = ResumeAddedu::find()->where(["resume_id" => $id])->all();
       return $this->render("view",[
           "resume" => $resume,
           "resumeExp" =>$resumeExp,
           "resumePortfolio" => $resumePortfolio,
           "resumeEdu" => $resumeEdu,
           "resumeAddEdu" => $resumeAddEdu
       ]);
    }

    /**
     * Creates a new Resume model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Resume();

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
     * Updates an existing Resume model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->verify = $_POST["Resume"]["verify"];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Resume model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       // $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Resume model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Resume the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resume::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
