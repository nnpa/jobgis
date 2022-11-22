<h5>Рекрутер <?php echo $user->surname;?> <?php echo $user->name;?></h5>
Город: <?php echo $user->city;?><br>
<?php echo $user->recruiter_info;?><br>
Телефон: 
<?php if(Yii::$app->user->isGuest):?>
   доступен после регистрации
<?php else:?>
  <?php echo $user->phone;?>
<?php endif; ?>
