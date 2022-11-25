<h3>Добро пожаловать на jobgis</h3>

    <?php
    $role = "guest";
    $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
    if(!empty($roleArr)){
        
        foreach($roleArr as $roleObj){
            if($roleObj->name == "employer"){
                $role = "employer";
            }
            if($roleObj->name == "candidate"){
                $role = "candidate";
            }
        }
    }
    ?>
    
<?php if($role == "candidate"):?>

<?php endif;?>

<?php if($role == "employer"):?>
<h5>Поиск резюме</h5>
<form action="/search/resume">
    <input type="text" name="name" style="width:40%">
    <input type="submit" class="btn btn-success" value="Искать">
</form>
<?php endif;?>


<?php if($role == "candidate" OR $role == "guest"):?>
    <h5>Топ вакансий<h5>
    <?php foreach($tops as $vacancy):?>
    <div style="padding-top:10px;width:50%;float:left">
        <a target="_blank" href="/vacancy/show?id=<?php echo $vacancy->id?>"><?php echo $vacancy->name;?></a><br>
        <?php if((bool)$vacancy->costfrom):?>
            от <?php echo $vacancy->costfrom;?> 
       <?php endif;?>

       <?php if((bool)$vacancy->costto):?>
            до <?php echo $vacancy->costto;?>
       <?php endif;?><br>
            <small>
                <span style="color:#959799"><?php echo $vacancy->user->firm->name;?>, <?php echo $vacancy->city;?></span>
            </small><br>
    </div>
    <?php endforeach; ?>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
<hr>
    <h5>Последние вакансии<h5>
<form action="/search/vacancy">
    <input type="text" name="name" style="width:40%">
    <input type="submit" class="btn btn-success" value="Искать">
</form>
    <?php foreach($vacancys as $vacancy):?>
    <div style="padding-top:10px;width:50%;float:left">
        <a target="_blank" href="/vacancy/show?id=<?php echo $vacancy->id?>"><?php echo $vacancy->name;?></a><br>
        <?php if((bool)$vacancy->costfrom):?>
            от <?php echo $vacancy->costfrom;?> 
       <?php endif;?>

       <?php if((bool)$vacancy->costto):?>
            до <?php echo $vacancy->costto;?>
       <?php endif;?><br>
            <small>
                <span style="color:#959799"><?php echo $vacancy->user->firm->name;?>, <?php echo $vacancy->city;?></span>
            </small><br>
    </div>
    <?php endforeach; ?>
<?php endif;?>

<?php if($role == "employer"):?>
    <h5>Последние резюме</h5>
    <?php foreach($resumes as $resume):?>
            <div style="padding-top:10px;width:50%;float:left">
                <a target="_blank" href="/resume/show?id=<?php echo $resume->id?>"><?php echo $resume->vacancy;?></a>  <?php echo $resume->age($resume->birth_date);?> <?php echo $resume->city;?> <br>
                Желаемая з/п: <?php echo $resume->cost?> <?php echo $resume->cash_type?>  <br>
                Занятость: 
                <?php 

                if($resume->employment_full){
                    echo "Полная занятость ";
                }

                if($resume->employment_partial){
                    echo "Частичная занятость ";
                }

                if($resume->employment_project){
                    echo "Проектная работа ";
                }

                if($resume->employment_volunteering){
                    echo "Волонтерство ";
                }

                if($resume->employment_internship){
                    echo "Стажировка ";
                }
                ?>
                <br>
                График работы:

                <?php
                if($resume->schedule_full){
                  echo " Полный день ";
                }
                if($resume->schedule_removable){
                  echo " Сменный график ";
                }

                if($resume->schedule_flexible){
                  echo " Гибкий график ";
                }

                if($resume->schedule_tomote){
                  echo "  Удаленная работа ";
                }

                if($resume->schedule_tour){
                  echo " Вахтовый метод ";
                }
                ?>
                <br>
                <?php 
if($resume->exp != 0){
    $years = floor($resume->exp / 12);
    $months = $resume->exp - ($years * 12);
    if($years > 0){
        $years = $years . " лет ";
    }else{
        $years = "";
    }    
    
    if($months > 0 ){
        $months = $months . " месяцев";
    } else{
        $months = "";
    }
}else {
    $years ="";
    $months = "";
}

?>
Опыт работы <?php echo $years;?> <?php echo $months;?>
            </div>
   
    <?php endforeach; ?>

<?php endif;?>
     
        
        <div>&nbsp;</div>
                <div>&nbsp;</div>

        <div>&nbsp;</div>
<br>
<div style="flex: 0 1 auto;">

<?php if(!empty($news)):?>
    <hr>

<h5>Новости</h5>
    <?php foreach($news as $new):?>
        <div style="padding-top:10px;width:50%;float:left;padding-left:10px;">
            <a href="/news/view?id=<?php echo $new->id;?>" target="_blank"><?php echo $new->title;?></a>
        </div>
    <?php endforeach;?><br><br>
    <a href="/news/all">Все новости</a>
<?php endif;?>
<hr>

<h5 style="padding-top: 10px;">Информационные партнеры</h5>

<?php foreach($partners as $partner):?> 

    <?php if($partner->firm->logo != ""):?>
        <a targer="_blank" href="/company/view?id=<?php echo $partner->firm->id;?>">
            <img  height="120px" src="/img/<?php echo $partner->firm->logo?>"></a>
    <?php endif;?>
<?php endforeach;?>

</div>