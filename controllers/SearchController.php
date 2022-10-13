<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NetCity;
use app\models\Users;

class SearchController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionVacancy(){
        
        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $city = $user->city;
        }else{
            $city = "";
        }
        
        
        
        $sql = "SELECT * FROM `vacancy` WHERE 1=1 AND name != 'Заполните должность'";
        $url = "http://jobgis.ru/search/vacancy?test=1";
        $sqlCount = "SELECT COUNT(*) FROM `vacancy` WHERE 1=1 AND name != 'Заполните должность'";
        
        if(isset($_GET["name"]) && !empty($_GET['name'])){
            $name = $_GET["name"];
            $sql .= " AND `name` = '". mysqli_real_escape_string($conn,$name)."'";
            $sqlCount .= " AND `name` = '". mysqli_real_escape_string($conn,$name)."'";
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
            $city = $city;
            $sql .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city;
        }
        
        if(isset($_GET["cost"]) && !empty($_GET['cost'])){
            $cost = (int)$_GET["cost"];
            $sql .= " AND `costfrom` > ". mysqli_real_escape_string($conn,$cost);
            $sqlCount .= " AND `costfrom` > ". mysqli_real_escape_string($conn,$cost);
            $url .= "&cost=" . $cost; 
        }else {
            $cost = "";
        }
        
        if(isset($_GET["spec"]) && !empty($_GET['spec'])){
            $spec = $_GET["spec"];
            $sql  .= " AND `spec` = '". mysqli_real_escape_string($conn,$spec)."'";
            $sqlCount .= " AND `spec` = '". mysqli_real_escape_string($conn,$spec)."'";
            $url .= "&spec=" . $spec; 
        }else {
            $spec = "";
        }
        
        if(isset($_GET["exp"]) && !empty($_GET['exp'])){
            $exp = $_GET["exp"];

            if($exp != "no"){
                $sql .= " AND `exp` = '". mysqli_real_escape_string($conn,$exp)."'";
                $sqlCount .= " AND `exp` = '". mysqli_real_escape_string($conn,$exp)."'";
                $url .= "&exp=" . $exp; 
            }


        }else {
            $exp = "no";
        }
        
        if(isset($_GET["employment"]) && !empty($_GET['employment'])){
            $employment = $_GET["employment"];
            
            $sql .= " AND `employment` = '". mysqli_real_escape_string($conn,$employment)."'";
            $sqlCount .=  " AND `employment` = '". mysqli_real_escape_string($conn,$employment)."'";
            
            $url .= "&employment=" . $employment; 

        }else {
            $employment = "Полная занятость";
        }
        
        $sql .=  " ORDER BY `create_time`";
        
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
        
        return $this->render("vacancy",[
            "city" => $city,
            "spec" => $spec,
            "exp" => $exp,
            "cost" => $cost,
            "employment" => $employment,
            "name" => $name,
            "result" => $result,
            'page' => $page,
            'pages' => $pages,
            "url" => $url
        ]);
    }
    
    public function actionResume(){
        
        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $city = $user->city;
        }else{
            $city = "";
        }
        $sql = "SELECT * FROM `resume` WHERE 1=1  AND `vacancy` != 'Заполните должность' AND `verify` = 1";
        $url = "http://jobgis.ru/search/resume?test=1";
        $sqlCount = "SELECT COUNT(*) FROM `resume` WHERE 1=1 != 'Заполните должность' AND `verify` = 1";
        
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
                $sql .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city;
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
        
        $sql .=  " ORDER BY `update_time`";
        
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
    
    public function actionCompany(){
        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        
        
        $url = "/search/company?a=test";
        $sql  = "SELECT * from `firm` where 1=1 ";
        $sqlCount = "SELECT COUNT(*) FROM `firm` WHERE 1=1";

        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $city = $user->city;
        }else{
            
            $city = $this->getCity();
            if($city == ""){
                $city = "Москва";
            }
        }
        
        if(isset($_GET["city"]) && !empty($_GET["city"])){
            $city = $_GET["city"];
            $sql .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city; 
        }
        
        $category = "";
        if(isset($_GET["category"]) && !empty($_GET["category"])){
            $category = $_GET["category"];
            $sql .= " AND `category` = '". mysqli_real_escape_string($conn,$category)."'";
            $sqlCount .= " AND `category` = '". mysqli_real_escape_string($conn,$category)."'";
            $url .= "&category=" . $category; 
        }
        
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
       
        
        return $this->render("company",[
            "city" => $city,
            "category" => $category,
            "result" => $result,
            'page' => $page,
            'pages' => $pages,
            "url" => $url
        ]);
    }
    
    public function getCity(){
        $city = "";
        $arr = geoip_record_by_name($_SERVER['REMOTE_ADDR']);
        //$arr = geoip_record_by_name('83.174.241.173');
        
        if($arr != false){
            $city = $arr['city'];
        }
        
        $netCity = NetCity::find()->where(["name_en" => $city])->one();
        if(!is_null($netCity)){
            $city = $netCity->name_ru;
        }
        return $city;
    }
}
