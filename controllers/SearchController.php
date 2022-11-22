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
use app\controllers\AppController;

class SearchController extends AppController
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
        $this->view->title = "Jobgis.ru вакансии";
        $this->view->registerMetaTag(
            ['name' => 'keywords', 'content' => 'работа, вакансии, работа, поиск вакансий, резюме, работы, работу, работ, ищу работу, поиск']
        );
        $this->view->registerMetaTag(
            ['name' => 'description', 'content' => 'jobgis.ru — сервис, который помогает найти работу и подобрать персонал ! Создавайте резюме и откликайтесь на вакансии. Набирайте сотрудников и публикуйте вакансии.']
        );
        
        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        

        
        
        
        $sql = "SELECT vacancy.*,firm.name as firm_name,firm.logo,firm.id as firm_id FROM `vacancy` "
                . " INNER JOIN Users ON vacancy.user_id = Users.id"
                . " INNER JOIN firm ON Users.firm_id = firm.id"
                . " WHERE 1=1 AND vacancy.name != 'Заполните должность'";
        $url = "http://jobgis.ru/search/vacancy?test=1";
        $sqlCount = "SELECT COUNT(*) FROM `vacancy` WHERE 1=1 AND name != 'Заполните должность'";
        
        if(isset($_GET["name"]) && !empty($_GET['name'])){
            $name = $_GET["name"];
            $sql .= " AND vacancy.`name` LIKE '". mysqli_real_escape_string($conn,$name)."%'";
            $sqlCount .= " AND `name` LIKE '". mysqli_real_escape_string($conn,$name)."%'";
            $url .= "&name=" . $name; 
        }else {
            $name = "";
        }
        
        
        if(isset($_GET["city"]) && !empty($_GET['city'])){
            $city = $_GET['city'];
            $sql .= " AND vacancy.`city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city; 
        }else {
            $city = "";
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
        
        if(isset($_GET["workschedule"]) && !empty($_GET['workschedule'])){
            $workschedule = $_GET["workschedule"];
            
            $sql .= " AND `workschedule` = '". mysqli_real_escape_string($conn,$workschedule)."'";
            $sqlCount .=  " AND `workschedule` = '". mysqli_real_escape_string($conn,$workschedule)."'";
            
            $url .= "&workschedule=" . $workschedule; 

        }else {
            $workschedule = "Полный день";
        }
        
        $sql .=  " ORDER BY `rsort` DESC, create_time DESC";
        
        if($page == 1){
            $limit = " limit 0,".$perPage;
        }else{
            $limit = " limit " . (($page - 1) * $perPage). ",". $perPage;
        }
        
        $sql .= $limit ;
        
        $connection = Yii::$app->getDb();
        
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        
        $command = $connection->createCommand($sqlCount);
        $count = $command->queryAll();
        $count = (int)$count[0]["COUNT(*)"];
        
        $pages = ceil($count/$perPage);
        
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
            "url" => $url,
            "workschedule" => $workschedule
        ]);
    }
    
    public function actionResume(){
        $this->view->title = "Jobgis.ru резюме";
        $this->view->registerMetaTag(
            ['name' => 'keywords', 'content' => 'работа, вакансии, работа, поиск вакансий, резюме, работы, работу, работ, ищу работу, поиск']
        );
        $this->view->registerMetaTag(
            ['name' => 'description', 'content' => 'jobgis.ru — сервис, который помогает найти работу и подобрать персонал ! Создавайте резюме и откликайтесь на вакансии. Набирайте сотрудников и публикуйте вакансии.']
        );
        
        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        

        $sql = "SELECT * FROM `resume` WHERE 1=1  AND `vacancy` != 'Заполните должность' AND `verify` = 1";
        $url = "http://jobgis.ru/search/resume?test=1";
        $sqlCount = "SELECT COUNT(*) FROM `resume` WHERE 1=1 != 'Заполните должность' AND `verify` = 1";
        
        if(isset($_GET["name"]) && !empty($_GET['name'])){
            $name = $_GET["name"];
            $sql .= " AND `vacancy` LIKE '". mysqli_real_escape_string($conn,$name)."%'";
            $sqlCount .= " AND `vacancy` LIKE '". mysqli_real_escape_string($conn,$name)."%'";
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
            $city= "";
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
            $limit = " limit " . (($page - 1) * $perPage). ",". $perPage;
        }
        
        $sql .= $limit ;
        
        $connection = Yii::$app->getDb();
        
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        
        $command = $connection->createCommand($sqlCount);
        $count = $command->queryAll();
        $count = (int)$count[0]["COUNT(*)"];
        
        $pages = ceil($count/$perPage);
        
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
    
    
    public function actionRecruiter(){
        $this->view->title = "Jobgis.ru каталог компаний";
        $this->view->registerMetaTag(
            ['name' => 'keywords', 'content' => 'работа, вакансии, работа, поиск вакансий, резюме, работы, работу, работ, ищу работу, поиск']
        );
        $this->view->registerMetaTag(
            ['name' => 'description', 'content' => 'jobgis.ru — сервис, который помогает найти работу и подобрать персонал ! Создавайте резюме и откликайтесь на вакансии. Набирайте сотрудников и публикуйте вакансии.']
        );
        
        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        
        
        $url = "/search/reacruiter?a=test";
        $sql  = "SELECT * from `Users` where 1=1 AND surname != '' AND recruiter_info IS NOT NULL AND type = 4 ";
        $sqlCount = "SELECT COUNT(*) FROM `Users` WHERE 1=1 AND surname != '' AND recruiter_info IS NOT NULL AND type = 4";


        
        if(isset($_GET["city"]) && !empty($_GET["city"])){
            $city = $_GET["city"];
            $sql .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city; 
        }else {
            $city= "";
        }
        
        if($page == 1){
            $limit = " limit 0,".$perPage;
        }else{
            $limit = " limit " . (($page - 1) * $perPage). ",". $perPage;
        }
        
        $sql .= $limit ;
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        
        $command = $connection->createCommand($sqlCount);
        $count = $command->queryAll();
        $count = (int)$count[0]["COUNT(*)"];
        
        $pages = ceil($count/$perPage);
        
        return $this->render("recruiter",[
            "city" => $city,
            "result" => $result,
            'page' => $page,
            'pages' => $pages,
            "url" => $url
        ]);
    }
    
    public function actionCompany(){
        $this->view->title = "Jobgis.ru каталог компаний";
        $this->view->registerMetaTag(
            ['name' => 'keywords', 'content' => 'работа, вакансии, работа, поиск вакансий, резюме, работы, работу, работ, ищу работу, поиск']
        );
        $this->view->registerMetaTag(
            ['name' => 'description', 'content' => 'jobgis.ru — сервис, который помогает найти работу и подобрать персонал ! Создавайте резюме и откликайтесь на вакансии. Набирайте сотрудников и публикуйте вакансии.']
        );
        
        if(isset($_GET["page"]) && !empty($_GET["page"])){
            $page = $_GET["page"];
        }else {
            $page = 1;
        }
        
        $perPage = 20;
        
        $conn = mysqli_connect("localhost","root","g02091988","jobgis");
        
        
        $url = "/search/company?a=test";
        $sql  = "SELECT * from `firm` where 1=1 AND `firm`.id != 29 AND verify = 1 ";
        $sqlCount = "SELECT COUNT(*) FROM `firm` WHERE 1=1 AND `firm`.id != 29 AND verify = 1";


        
        if(isset($_GET["city"]) && !empty($_GET["city"])){
            $city = $_GET["city"];
            $sql .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $sqlCount .= " AND `city` = '". mysqli_real_escape_string($conn,$city)."'";
            $url .= "&city=" . $city; 
        }else {
            $city= "";
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
            $limit = " limit " . (($page - 1) * $perPage). ",". $perPage;
        }
        
        $sql .= $limit ;
        $connection = Yii::$app->getDb();
        
        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        
        $command = $connection->createCommand($sqlCount);
        $count = $command->queryAll();
        $count = (int)$count[0]["COUNT(*)"];
        
        $pages = ceil($count/$perPage);
        
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
    
    public function actionTop($top){
        if($top=='week'){
            $time = time() - (60 * 60 *24 *7 );
            $top = " неделю";
        }
        if($top=='month'){
            $time = time() - (60 * 60 *24 *30 );
            $top = " месяц";

        }
        if($top=='year'){
            $time = time() - (60 * 60 *24 *365 );
            $top = " год";

        }
        $sql = "select city,name,surname, id, (select COUNT(*) from firm where manage_id = Users.id AND firm.create_time > $time) as cnt from Users where type = 4 AND recruiter_info is not null order by cnt limit 100;";
        
        $connection = Yii::$app->getDb();

        $command = $connection->createCommand($sql);
        $result = $command->queryAll();
        return $this->render('top',["result" => $result,"top"=>$top]);
    }
}
