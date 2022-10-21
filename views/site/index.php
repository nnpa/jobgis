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
<h5>Поиск вакансий</h5>
<form action="/search/vacancy">
    <input type="text" name="name" style="width:40%">
    <input type="submit" class="btn btn-success" value="Искать">
</form>
<?php endif;?>

<?php if($role == "employer"):?>
<h5>Поиск резюме</h5>
<form action="/search/resume">
    <input type="text" name="name" style="width:40%">
    <input type="submit" class="btn btn-success" value="Искать">
</form>
<?php endif;?>



<h5>Последние вакансии<h5>
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
        <div>&nbsp;</div>
                <div>&nbsp;</div>

<h5>Информационные партнеры</h5>

<?php foreach($partners as $partner):?> 

    <?php if($partner->firm->logo != ""):?>
        <a targer="_blank" href="/company/view?id=<?php echo $partner->firm->id;?>"><img width="80px" height="80px" src="/img/<?php echo $partner->firm->logo?>"></a>
    <?php endif;?>
<?php endforeach;?>