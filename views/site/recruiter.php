<h5>Рекрутер <?php echo $recruiter->surname;?> <?php echo $recruiter->name;?></h5>
Город: <?php echo $recruiter->city;?><br>
<?php echo $recruiter->recruiter_info;?><br>
Телефон: 
<?php if(Yii::$app->user->isGuest):?>
   доступен после регистрации
<?php else:?>
  <?php echo $recruiter->phone;?>
<?php endif; ?>
<br>
    <?php if(!Yii::$app->user->isGuest):?>
        <?php $user = Yii::$app->user->identity;?>

        <?php if($user->firm_id != 0):?>
            <?php if($user->firm->manage_id != $recruiter->id):?>
                <a class="btn btn-success" href="/company/recruiter?id=<?php echo $recruiter->id?>">Нанять рекрутера</a>
                
            <?php else:?>
                Рекрутер нанят
            <?php endif;?>
        <?php endif;?>
    <?php endif;?>