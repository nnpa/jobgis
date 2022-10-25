
<?php if($resume->photo != ""):?>
<img width="80px" height="80px" src="/img/<?php echo $resume->photo;?>"><br>
<?php endif?>
<h5> 
    <?php if(!Yii::$app->user->isGuest):?>
        <?php if(Yii::$app->user->identity->firm->verify != 0):?>
            <?php echo $resume->surname . " " . $resume->name. " " . $resume->patronymic?>
            
        <?php else:?>
            ФИО видно только после верификации
        <?php endif;?>
    <?php else:?>
        ФИО скрыто зарегистрируйтесь 
    <?php endif;?>
</h5>


пол: <?php echo $resume->gender;?> <br>
дата рождения:
<?php
    if($resume->birth_date == ""){
        echo "не указана";
    }else{
        echo $resume->birth_date;
    }
?>
<br>
<h5><?php echo $resume->vacancy;?></h5>
<?php echo $resume->cost;?> <?php echo $resume->cash_type;?><br>
Специализация: <?php echo $resume->specsub;?> <br>
Занятость: 
<?php 

if($resume->employment_full){
    echo "Полная занятость";
}

if($resume->employment_partial){
    echo "Частичная занятость";
}

if($resume->employment_project){
    echo "Проектная работа";
}

if($resume->employment_volunteering){
    echo "Волонтерство";
}

if($resume->employment_internship){
    echo "Стажировка";
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
<h5>Опыт работы <?php echo $years;?> <?php echo $months;?></h5>
    
    <?php
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
    ?>
    
<?php foreach($resumeExp as $exp):?>
    <?php 
        $dateStart = explode(".", $exp->start_date);
        $monthStart = $monthArr[$dateStart[0]];
        $yearStart  = $dateStart[1];
          
        $dateEnd = explode(".", $exp->end_date);
        $monthEnd = $monthArr[$dateEnd[0]];
        $yearEnd  = $dateEnd[1];
        
        if($yearStart != "" && $yearStart != " " && $yearEnd != "" && $yearEnd != " " ){
            $startDateTime = DateTime::createFromFormat('m.Y', $exp->start_date);
            $endDateTime  = DateTime::createFromFormat('m.Y', $exp->end_date);
            
            $period = $endDateTime->getTimestamp() - $startDateTime->getTimestamp();
            
            $months = floor($period / (60 * 60 * 24 * 30)) + 1;
            $years  = floor($months/12);
            $months  = $months - ($years * 12); 
            
            

        }

    ?>
    
<?php echo $monthStart . " " . $yearStart;?> —  <?php echo $monthEnd . " " . $yearEnd;?>
<br>
<?php 
    if($years > 0 && $resume->exp != 0){
        echo $years . " года";
    }
    if($months > 0 && $resume->exp != 0){
        echo $months . " месяцев";
    }
?>
<br>
<b><?php echo $exp->firm;?></b><br>
<?php echo $exp->site;?><br>
<b><?php echo $exp->vacancy;?></b><br>
<?php echo $str=str_replace('\r\n','<br>',$exp->description);?><br>

<?php endforeach;?>
<h5>Ключевые навыки</h5>
<div>
    <?php 
        $skillsArr = explode(",",$resume->skills);
    ?>
    <?php foreach($skillsArr as $skill):?>
        <?php if($skill != ""):?>
            <div  style='margin:4px;border-radius:5px;background-color:edeff0;padding:4px;border:1px solid gray;min-width:10px;float:left;'>
                <?php echo $skill?>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div>
<h5>Обо мне</h5>
<div><?php echo $resume->description;?></div>
<h5>Опыт вождения</h5>

<?php echo $resume->car;?>

<?php if(!empty($resumePortfolio)):?>
    <h5>Портфолио</h5>
    <div>
    <?php foreach($resumePortfolio as $portfolio):?>
        <img style="float:left" src="/img/<?php echo $portfolio->photo;?>" >
    <?php endforeach; ?><br>
    </div>
    <div>
        &nbsp;
    </div>
    <hr><br><br><br><br><br>
<?php endif;?>
<div>
    <h5>Высшее образование</h5>
</div>

<?php foreach($resumeEdu as $edu):?>
    <b><?php echo $edu->univercity;?></b> <?php echo $edu->year;?><br>
    <?php echo $edu->fack;?>

<?php endforeach;?>
    <h5>Повышение квалификации, курсы</h5>

<?php foreach($resumeAddEdu as $edu):?>
    <b><?php echo $edu->university;?></b> <?php echo $edu->year;?><br>
    <?php echo $edu->spec;?>

<?php endforeach;?>
<br>
    Телефон: 
    <?php if(!Yii::$app->user->isGuest):?>
        <?php if(Yii::$app->user->identity->firm->verify != 0):?>
            <?php echo $resume->user->phone;?>
            
        <?php else:?>
           Телефон станет виден после верификации работодателя
        <?php endif;?>
    <?php else:?>
           Телефон станет виден после регистрации
    <?php endif;?>
