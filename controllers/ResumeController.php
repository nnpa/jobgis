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
use app\models\Resume;
use app\models\ResumeExp;
use app\models\ResumePortfolio;
use app\models\ResumeEdu;
use app\models\ResumeAddedu;
class ResumeController extends AppController
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
                'only' => ['logout',"add","new","edit","list","show"],
                'rules' => [
                    [
                        'actions' => ['logout',"add","new","edit","list","show"],
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

   public function actionNew(){
       $user = Yii::$app->user->identity;

       $resume = new Resume();
       $resume->photo = "";
       $resume->surname = $user->surname;
       $resume->name = $user->name;
       $resume->patronymic = $user->patronymic;
       $resume->birth_date = "";
       $resume->gender = "мужской";
       $resume->city = $user->city;
       $resume->relocation = "Невозможен";
       $resume->business_trips = "Никогда";


       $resume->vacancy = "Заполните должность";
       $resume->spec = "";
       $resume->specsub = "";
       $resume->cost = 10000;
       $resume->cash_type = "руб.";

       $resume->employment_full = 1;
       $resume->employment_partial = 0;
       $resume->employment_project = 0;
       $resume->employment_volunteering = 0;
       $resume->employment_internship = 0;
       


       $resume->schedule_full = 1;
       $resume->schedule_removable = 0;
       $resume->schedule_flexible = 0;
       $resume->schedule_tomote=0;
       $resume->schedule_tour = 0;
        
       $resume->skills = "";
       $resume->description = "";
       $resume->language = "Русский";
       $resume->language_add = "";
       $resume->car = "";
       $resume->update_time = 0;
       $resume->user_id = $user->id;
        $resume->exp = 0;

       $resume->save(false);
       $this->redirect("/resume/edit?id=" . $resume->id);
   }
   
   public function actionEdit($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       $resumeEdu = ResumeEdu::find()->where(["resume_id" => $id])->all();
       $resumeExp = ResumeExp::find()->where(["resume_id" => $id])->all();
       $resumePortfolio = ResumePortfolio::find()->where(["resume_id" => $id])->all();
       $resumeAddEdu = ResumeAddedu::find()->where(["resume_id" => $id])->all();
       return $this->render("edit",[
           "resume" => $resume,
           "resumeExp" =>$resumeExp,
           "resumePortfolio" => $resumePortfolio,
           "resumeEdu" => $resumeEdu,
           "resumeAddEdu" => $resumeAddEdu
       ]);
   }
   
   public function actionDelete($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       
       $resume->delete();
       return $this->redirect("/resume/list");
   }
   
   public function actionList(){
        $user = Yii::$app->user->identity;

       $resumes = Resume::find()->where(["user_id" => $user->id])->all();

       return $this->render("list",["resumes" => $resumes]);
   }
   
   public function actionEditaddedu($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       
       $resumeEdu = ResumeAddedu::find()->where(["resume_id" => $id])->all();
       return $this->render("addedu",["resume" => $resume,'resumeEdu' => $resumeEdu]);

   }
   
   public function actionAddeduchangeuniversity($id,$val){
       $edu = ResumeAddedu::find()->where(["id" => $id])->one();
       $edu->university = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionAddeduchangefirm($id,$val){
       $edu = ResumeAddedu::find()->where(["id" => $id])->one();
       $edu->firm = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionAddeduchangespec($id,$val){
       $edu = ResumeAddedu::find()->where(["id" => $id])->one();
       $edu->spec = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionAddeduchangeyear($id,$val){
       $edu = ResumeAddedu::find()->where(["id" => $id])->one();
       $edu->year = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionAddaddedu($id){
       $resumEdu = new ResumeAddedu();
       $resumEdu->resume_id = $id;
       $resumEdu->firm = "";
       $resumEdu->university = "";
       $resumEdu->year = "";
       $resumEdu->spec = "";
       $resumEdu->save(false);
       return $resumEdu->id;
   }
   
   public function actionShow($id){
       
       $resume = Resume::find()->where(["id" => $id])->one();
       
       if(is_null($resume)){
           exit;
       }
       
        $role = "guest";
        $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(!empty($roleArr)){
            $roleObj = array_shift($roleArr);
            $role = $roleObj->name;
        }
           $user = Yii::$app->user->identity;

       if($role != "employer" AND $role != "manager" AND $role != "admin"  AND $resume->user_id != $user->id){
           exit;
       }
       
       $resumeEdu = ResumeEdu::find()->where(["resume_id" => $id])->all();
       $resumeExp = ResumeExp::find()->where(["resume_id" => $id])->all();
       $resumePortfolio = ResumePortfolio::find()->where(["resume_id" => $id])->all();
       $resumeAddEdu = ResumeAddedu::find()->where(["resume_id" => $id])->all();
       return $this->render("show",[
           "resume" => $resume,
           "resumeExp" =>$resumeExp,
           "resumePortfolio" => $resumePortfolio,
           "resumeEdu" => $resumeEdu,
           "resumeAddEdu" => $resumeAddEdu
       ]);
   }
   
   public function actionEditedu($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       $resumeEdu = ResumeEdu::find()->where(["resume_id" => $id])->all();
       return $this->render("edu",["resume" => $resume,"resumeEdu" => $resumeEdu]);

   }
   
   public function actionEduchangetype($id,$val){
       $edu = ResumeEdu::find()->where(["id" => $id])->one();
       $edu->edu_type = $val;
       $edu->save(false);
       return "";
   }
   
    public function actionEduchangeuniversity($id,$val){
       $edu = ResumeEdu::find()->where(["id" => $id])->one();
       $edu->univercity = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionEduchangefack($id,$val){
       $edu = ResumeEdu::find()->where(["id" => $id])->one();
       $edu->fack = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionEdudelete($id){
       $edu = ResumeEdu::find()->where(["id" => $id])->one();
       $edu->delete();
       return "";
   }
   
   public function actionEduadddelete($id){
       $edu = ResumeAddedu::find()->where(["id" => $id])->one();
       $edu->delete();
       return "";
   }
   
   
    public function actionEduchangespec($id,$val){
       $edu = ResumeEdu::find()->where(["id" => $id])->one();
       $edu->spec = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionEduchangeyear($id,$val){
       $edu = ResumeEdu::find()->where(["id" => $id])->one();
       $edu->year = $val;
       $edu->save(false);
       return "";
   }
   
   public function actionAddedu($id){
       $resumeEdu = new ResumeEdu();
       $resumeEdu->resume_id = $id;
       $resumeEdu->edu_type= "";
       $resumeEdu->univercity= "";
       $resumeEdu->fack= "";
       $resumeEdu->spec= "";
       $resumeEdu->year= "";
       $resumeEdu->save(false);
       return $resumeEdu->id;
   }
   
   public function actionEditpersonal($id){
       
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       
       if(isset($_POST) && !empty($_POST)){
          $resume->name= $_POST['name'];
          $resume->surname= $_POST['surname'];
          $resume->patronymic= $_POST['patronymic'];
          $month = "";
          
          $monthArray = [
             "Январь" => "1",
            "Февраль" => "2",
            "Март" => "3",
            "Апрель" => "4",
            "Май" => "5",
            "Июнь" => "6",
            "Инюль" => "7",
            "Август" => "8",
            "Сентябрь" => "9",
            "Октябрь" => "10",
            "Ноябрь" => "11",
            "Декабрь" => "12"
          ];
          $resume->birth_date = $_POST['day']. "." . $monthArray[$_POST["month"]].".".$_POST["year"];
          $resume->gender = $_POST["gender"];
          $resume->city = $_POST["city"];
          $resume->relocation = $_POST["relocation"];
          $resume->business_trips = $_POST["business_trips"];
          $resume->save(false);
          return $this->redirect("/resume/edit?id=".$resume->id);
       }
        return $this->render("editpersonal",["resume" => $resume]);
   }
   
   public function actionPhoto($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       if(isset($_FILES) && !empty($_FILES)){
            $dirPath="/var/www/basic/web/img/";
            
            if($resume->photo != ""){
                unlink($dirPath.$resume->photo); 
            }
           
           
           //print_r($_FILES);exit;
            $uploadedFile=$_FILES['image']['tmp_name']; 
            $sourceProperties=getimagesize($uploadedFile);
            $newFileName=time();
            
            $ext=pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            
            $imageSrc= imagecreatefromjpeg($uploadedFile); 
 
            $tmp= $this->imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
            imagejpeg($tmp,$dirPath.$newFileName."_thump.".$ext);
            
            $resume->photo = $newFileName."_thump.".$ext;
            $resume->save(false);
            return $this->redirect("/resume/edit?id=".$resume->id);

            //move_uploaded_file($uploadedFile, $dirPath.$newFileName.".".$ext);

            
       }
       return $this->render("photo",["id"=>$id]);
   }
   
   function imageResize($imageSrc,$imageWidth,$imageHeight) {

       $newImageWidth=200;
       $newImageHeight=200;

       $newImageLayer=imagecreatetruecolor($newImageWidth,$newImageHeight);
       imagecopyresampled($newImageLayer,$imageSrc,0,0,0,0,$newImageWidth,$newImageHeight,$imageWidth,$imageHeight);

       return $newImageLayer;
    }
    
    public function actionEditposition($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       
       if(isset($_POST) && !empty($_POST) ){

           $resume->vacancy = $_POST["vacancy"];
            $resume->spec = $_POST["spec"];
            $resume->specsub = $_POST["specsub"];
            $resume->cash_type = $_POST["cash_type"];
            $resume->cost = (int)$_POST["cost"];
            if(isset($_POST["employment_full"])){
                $resume->employment_full = 1;
            } else{
                 $resume->employment_full = 0;
            }
            if(isset($_POST["employment_partial"])){
                $resume->employment_partial = 1;
            }else{
                $resume->employment_partial = 0;
            }
            
            if(isset($_POST["employment_project"])){
                $resume->employment_project = 1;
            } else{
                $resume->employment_project = 0;
            }
            if(isset($_POST["employment_volunteering"])){
                $resume->employment_volunteering = 1;
            } else{
                $resume->employment_volunteering = 0;
            }
            if(isset($_POST["employment_internship"])){
                $resume->employment_internship = 1;
            }else{
                $resume->employment_internship = 0;

            }
            
            
            
            if(isset($_POST["schedule_full"])){
                $resume->schedule_full = 1;
            }else{
                $resume->schedule_full = 0;
            }
            
            if(isset($_POST["schedule_removable"])){
                $resume->schedule_removable = 1;
            }else{
                $resume->schedule_removable = 0;
            }
            if(isset($_POST["schedule_flexible"])){
                $resume->schedule_flexible = 1;
            }else{
                $resume->schedule_flexible = 0;

            }
            if(isset($_POST["schedule_tomote"])){
                $resume->schedule_tomote = 1;
            }else{
                $resume->schedule_tomote = 0;
            }
            if(isset($_POST["schedule_tour"])){
                $resume->schedule_tour = 1;
            }else{
                $resume->schedule_tour = 0;
            }
            $resume->save(false);
            return $this->redirect("/resume/edit?id=".$resume->id);
            
       }
       return $this->render("position",["resume"=>$resume]);
    }
    
    public function actionEditexp($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       $resumeExp = ResumeExp::find()->where(["resume_id" => $id])->all();
       return $this->render("exp",["resume"=>$resume,"resumeExp"=>$resumeExp]);

    }
    
    public function actionEditskills($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       
       if(isset($_POST) && !empty($_POST)){
           $resume->skills = $_POST["skills"];
           $resume->save(false);
           $this->redirect("/resume/edit?id=" . $id);
       }
       return $this->render("skills",["resume"=>$resume]);
    }
    
    public function actionEditcar($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       if(isset($_POST) && !empty($_POST)){
           $resume->car = $_POST["car"];
           $resume->save(false);
           $this->redirect("/resume/edit?id=" . $id);

       }
       
       return $this->render("car",["resume"=>$resume]);

    }
    
    public function actionEditportfolio($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       
       $resumePortfolios = ResumePortfolio::find()->where(["resume_id" => $id])->all();
       
       if(isset($_FILES) && !empty($_FILES)){
            $dirPath="/var/www/basic/web/img/";
                       
           
           //print_r($_FILES);exit;
            $uploadedFile=$_FILES['image']['tmp_name']; 
            $sourceProperties=getimagesize($uploadedFile);
            $newFileName=time();
            
            $ext=pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            
            $imageSrc= imagecreatefromjpeg($uploadedFile); 
 
            $tmp= $this->imageResize($imageSrc,$sourceProperties[0],$sourceProperties[1]);
            imagejpeg($tmp,$dirPath.$newFileName."_port_thump.".$ext);
            

            $resumePortfolio = new ResumePortfolio();
            $resumePortfolio->resume_id = $id;
            $resumePortfolio->photo = $newFileName."_port_thump.".$ext;
            $resumePortfolio->save(false);
            return $this->redirect("/resume/editportfolio?id=".$resume->id);

            //move_uploaded_file($uploadedFile, $dirPath.$newFileName.".".$ext);

            
       }
        return $this->render("portfolio",["resume"=>$resume,"resumePortfolio" => $resumePortfolios]);

    }
    
    public function actionDeleteportfolio($id,$portfolio_id){
        $dirPath="/var/www/basic/web/img/";

        $portfolio  = ResumePortfolio::find()->where(["id" => $portfolio_id])->one();
        unlink($dirPath . $portfolio->photo);
        $portfolio->delete();
        $this->redirect("/resume/editportfolio?id=" . $id);
    }
    
    public function actionEditabout($id){
       $user = Yii::$app->user->identity;

       $resume = Resume::find()->where(["user_id" => $user->id, "id" => $id])->one();
       if(is_null($resume)){
         exit;
       }
       
        if(isset($_POST) && !empty($_POST)){
            $about = strip_tags($_POST["about"]);
            $about = nl2br($about);
            $resume->description = $about ;
            $resume->save(false);
            $this->redirect("/resume/edit?id=" . $id);
        }

       return $this->render("about",["resume"=>$resume]);

    }
    
   public function actionExpadd($id){
       $resumeExp = new ResumeExp();
       $resumeExp->resume_id = $id;
       $resumeExp->start_date = "1. ";
       $resumeExp->end_date = "1. ";
       $resumeExp->firm	 = "";
       $resumeExp->site	 = "";
       $resumeExp->vacancy	 = "";
       $resumeExp->description	 = "";

       $resumeExp->save(false);
       return $resumeExp->id;
   }
   
   public function actionExpdelete($id){
       $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
       $resumeExp->delete();
   }
   
    public function actionChangemonthstart($id,$month){
       $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
       $date = explode(".",$resumeExp->start_date);
       $monthArr = [
            "1" => "Январь",
            "2" => "Февраль",
            "3" => "Март",
            "4" => "Апрель",
            "5" => "Май",
            "6" => "Июнь",
            "7" => "Июль",
            "8" => "Август",
            "9" => "Сентябрь",
            "10" => "Октябрь",
            "11" => "Ноябрь",
            "12" => "Декабрь",

        ];
        $monthArr = array_flip($monthArr);
        $month = $monthArr[$month];
        $date = $month . "." . $date[1];
        $resumeExp->start_date = $date;
        $resumeExp->save(false);
        return "";
   }
   
    public function actionChangemonthend($id,$month){
       $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
       $date = explode(".",$resumeExp->end_date);
       $monthArr = [
            "1" => "Январь",
            "2" => "Февраль",
            "3" => "Март",
            "4" => "Апрель",
            "5" => "Май",
            "6" => "Июнь",
            "7" => "Июль",
            "8" => "Август",
            "9" => "Сентябрь",
            "10" => "Октябрь",
            "11" => "Ноябрь",
            "12" => "Декабрь",

        ];
        $monthArr = array_flip($monthArr);
        $month = $monthArr[$month];
        $date = $month . "." . $date[1];
        $resumeExp->end_date = $date;
        $resumeExp->save(false);
        return "";
   }
   
   public function actionChangeyearstart($id,$val){
       $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
       $date = explode(".",$resumeExp->start_date);
       $month = $date[0];
       $year = (int)$val;
       
       $date = $date[0]. "." . $year;
       $resumeExp->start_date = $date;

       $resumeExp->save(false);
       return "";
       
   }
   
   public function actionChangeyearend($id,$val){
       $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
       $date = explode(".",$resumeExp->end_date);
       $month = $date[0];
       $year = (int)$val;
       
       $date = $date[0]. "." . $year;
       $resumeExp->end_date = $date;

       $resumeExp->save(false);
       $this->setupExp($resumeExp->resume_id);
       return "";
       
   }
   
   public function actionChangefirm($id,$val){
        $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
        $resumeExp->firm = $val;
       $resumeExp->save(false);
       return "";

   }
   
   public function actionChangesite($id,$val){
        $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
        $resumeExp->site = $val;
       $resumeExp->save(false);
       return "";

   }
   
   public function actionChangevacancy($id,$val){
        $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       
       if(is_null($resumeExp)){
           exit;
       }
        $resumeExp->vacancy = $val;
       $resumeExp->save(false);
       return "";

   }
   
    public function actionChangedescription($id,$val){
        $resumeExp = ResumeExp::find()->where(["id" =>$id])->one();
       if(is_null($resumeExp)){
           exit;
       }
        $resumeExp->description = $val;
       $resumeExp->save(false);
       return "";

   }
   
   public function setupExp($resume_id){
       $resumeExp = ResumeExp::find()->where(["resume_id"=> $resume_id])->all();
       $monthsAll = 0;
       
       foreach ($resumeExp as $exp) {
           $dateStart = explode(".", $exp->start_date);
           $yearStart  = $dateStart[1];

           $dateEnd = explode(".", $exp->end_date);
           $yearEnd  = $dateEnd[1];
           
            if($yearStart != "" && $yearStart != " " && $yearEnd != "" && $yearEnd != " " ){
                $startDateTime = \DateTime::createFromFormat('m.Y', $exp->start_date);
                $endDateTime  = \DateTime::createFromFormat('m.Y', $exp->end_date);
                
                $period = $endDateTime->getTimestamp() - $startDateTime->getTimestamp();

                $months = floor($period / (60 * 60 * 24 * 30)) + 1;
                if($months > 0){
                    $monthsAll += $months;
                }
                }
       }
       $resume = Resume::find()->where(["id" => $resume_id])->one();
       $resume->exp = $monthsAll;
       $resume->save(false);
   }
   
   
}
