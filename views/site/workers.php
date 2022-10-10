<?php foreach($workers as $worker):?>
   <?php echo $worker->name . " " . $worker->surname;?><br>
   
<?php endforeach; ?>
   <a href="/site/addworker" class="btn btn-success">Пригласить сотрудника</a>
