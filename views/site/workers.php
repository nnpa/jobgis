<style>
    td {
        border:1px solid black;
        padding:5px;
    }
</style>
<h5>Сотрудники</h5>
<table>
    <tr>
        <td><b>Имя</b></td>
        <td><b>Email</b></td>
    </tr>

<?php foreach($workers as $worker):?>
   
    <tr>
        <td><?php echo $worker->name . " " . $worker->surname;?></b></td>
        <td><?php echo $worker->email;?></td>
    </tr>
    
<?php endforeach; ?>
    </table>

   <a href="/site/addworker" class="btn btn-success">Пригласить сотрудника</a>
