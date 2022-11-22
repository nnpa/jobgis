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
        <td><b>Уволить</b></td>

    </tr>

<?php foreach($workers as $worker):?>
   
    <tr>
        <td><?php echo $worker->name . " " . $worker->surname;?></b></td>
        <td><?php echo $worker->email;?></td>
        <td>
            <?php if($user->id != $worker->id AND $user->is_admin):?>
                <a href="/site/deleteworker?id=<?php echo $worker->id;?>">Уволить</a>
            <?php endif;?>
        </td>

    </tr>
    
<?php endforeach; ?>
    </table>
<?php if($user->is_admin):?>
    
   <a href="/site/addworker" class="btn btn-success">Пригласить сотрудника</a>
<?php endif;?>