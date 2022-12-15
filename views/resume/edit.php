<a href="/resume/delete?id=<?php echo $resume->id;?>" onClick="confirm('Удалить?')">Удалить резюме</a>
<br>
<?php if($resume->photo != ""):?>
<img src="/img/<?php echo $resume->photo;?>"><br>
<?php endif?>
<small><a href="/resume/photo?id=<?php echo $resume->id;?>">Загрузить фото</a></small>
<h5><?php echo $resume->surname . " " . $resume->name. " " . $resume->patronymic?></h5>
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
<small><a href="/resume/editpersonal?id=<?php echo $resume->id?>">редактировать</a></small>
<h5 style="color:<?php echo ($resume->vacancy == "Заполните должность")?'red':'';?>"><?php echo $resume->vacancy;?></h5>
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
<small><a href="/resume/editposition?id=<?php echo $resume->id?>">редактировать</a></small>

<?php 

    $sklon = [
        1 => "год",
        2 => "года",
        3 => "года",
        4 => "года",
        5 => "лет",
        6 => "лет",
        7 => "лет",
        8 => "лет",
        9 => "лет",
        10 => "лет",
        11 => "лет",
        12 => "лет",
        13 => "лет",
        14 => "лет",
        15 => "лет",
        16 => "лет",
        17 => "лет",
        18 => "лет",
        19 => "лет",
        20 => "лет",
        21 => "год",
        22 => "года",
        23 => "года",
        24 => "года",
        25 => "лет",
        26 => "лет",
        27 => "лет",
        28 => "лет",
        29 => "лет",
        30 => "лет",
        31 => "год"
        ];
        $sklonm = [
        1 => "месяц",
        2 => "месяца",
        3 => "месяца",
        4 => "месяца",
        5 => "месяца",
        6 => "месяцев",
        7 => "месяцев",
        8 => "месяцев",
        9 => "месяцев",
        10 => "месяцев",
        11 => "месяцев",
        12 => "месяцев",

        ];
        
if($resume->exp != 0){
    $years = floor($resume->exp / 12);
    $months = $resume->exp - ($years * 12);
    if($years > 0){
        $years = $years;
        if(in_array($years, $sklon)){
            $years .= " " . $sklon[$years];
        }else{
            $years .= " года ";
        }
    }else{
        $years = "";
    }    
    
    if($months > 0 ){
        $months = $months . " " . $sklonm[$months];
    } else{
        $months = "";
    }
}else {
    $years ="";
    $months = "";
}

?>
<h5>Опыт работы <?php echo $years;?> <?php echo $months;?></h5>
<small><a href="/resume/editexp?id=<?php echo $resume->id?>">редактировать</a></small><br>
    
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
        echo $years;
        if(in_array($years, $sklon)){
            echo $sklon[$years];
        }else{
            echo " года ";
        }
    }
    if($months > 0 && $resume->exp != 0){
        echo $months . " " . $sklonm[$months];
    }
?>
<br>
<b><?php echo $exp->firm;?></b><br>
<?php echo $exp->site;?><br>
<b><?php echo $exp->vacancy;?></b><br>
<?php echo $str=str_replace('\r\n','<br>',$exp->description);?><br>

<?php endforeach;?>

<h5>Обо мне</h5>
<small><a href="/resume/editabout?id=<?php echo $resume->id?>">редактировать</a></small><br>
<div><?php echo $resume->description;?></div>
<h5>Опыт вождения</h5>

<?php echo $resume->car;?><br>
<small><a href="/resume/editcar?id=<?php echo $resume->id?>">редактировать</a></small><br>
<h5>Портфолио</h5>
<small><a href="/resume/editportfolio?id=<?php echo $resume->id?>">редактировать</a></small><br>
<div>
<?php foreach($resumePortfolio as $portfolio):?>
    <img style="float:left" src="/img/<?php echo $portfolio->photo;?>" >
<?php endforeach; ?><br>
</div>
<div>
    &nbsp;
</div>
<hr><br><br><br><br><br>
<div>
    <h5>Высшее образование</h5>
    <small><a href="/resume/editedu?id=<?php echo $resume->id?>">редактировать</a></small><br>
</div>

<?php foreach($resumeEdu as $edu):?>
    <b><?php echo $edu->univercity;?></b> <?php echo $edu->year;?><br>
    <?php echo $edu->fack;?>

<?php endforeach;?>
    <h5>Повышение квалификации, курсы</h5>
    <small><a href="/resume/editaddedu?id=<?php echo $resume->id?>">редактировать</a></small><br>

<?php foreach($resumeAddEdu as $edu):?>
    <b><?php echo $edu->university;?></b> <?php echo $edu->year;?><br>
    <?php echo $edu->spec;?>

<?php endforeach;?>