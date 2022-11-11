<h5>Сотрудники</h5>
<table>
    <tr>
        <td><b>Имя</b></td>
        <td><b>Email</b></td>
    </tr>
</table>

<?php foreach($workers as $worker):?>
   
    <tr>
        <td><b><?php echo $worker->name . " " . $worker->surname;?></b></td>
        <td><b><?php echo $worker->email;?></b></td>
    </tr>
<?php endforeach; ?>
   <a href="/site/addworker" class="btn btn-success">Пригласить сотрудника</a>
