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
        <td><b>Права</b></td>

        <td><b>Уволить</b></td>

    </tr>

<?php foreach($workers as $worker):?>
   
    <tr>
        <td><?php echo $worker->name . " " . $worker->surname;?>

        </b>
        </td>
        <td><?php echo $worker->email;?></td>
        <td>
            <?php if($worker->is_admin):?>
                Администратор
            <?php endif;?>
        </td>
        <td>
            <?php if($user->id != $worker->id AND $user->is_admin):?>
                <a href="/site/deleteworker?id=<?php echo $worker->id;?>">Уволить</a>
            <?php endif;?>
        </td>

    </tr>
    
<?php endforeach; ?>
    </table>

<?php if(!is_null($recruiter)):?>
Ваш менеджер/рукрутер
<table>
    <tr>
        <td>ФИО</td>
        <td>Телефон</td>
        <td>Уволить</td>
    </tr>
    <tr>
        <td><?php echo $recruiter->surname." " .$recruiter->name . " " . $recruiter->patronymic?></td>
        <td><?php $recruiter->phone;?> </td>
        <td>
            <?php if($recruiter->type == 4):?>
            <a  href="/company/recruiterdelete?id=<?php echo $recruiter->id?>">Уволить рекрутера</a>
            <?php endif;?>
        </td>
    </tr>
</table>
<?php endif;?>


<?php if($user->is_admin):?>
    
   <a href="/site/addworker" class="btn btn-success">Пригласить сотрудника</a>
<?php endif;?>

   