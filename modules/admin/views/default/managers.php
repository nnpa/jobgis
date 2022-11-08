<a class="btn btn-success" href="/admin/default/add">Пригласить менеджера</a>
<style>
    td {
        border:1px solid black;
        padding:5px;
    }
</style>
<h3>Менеджеры</h3>
<table>
    <tr>
        <td>Фамилия</td>
        <td>Имя</td>
        <td>Отчество</td>
        <td>email</td>
        <td>Пароль</td>

        <td>Действие</td>

    </tr>
<?php foreach($managers as $manager):?>
    <tr>
    <?php if(is_object($manager->user)):?>
        <td><?php echo $manager->user->surname?></td>
        <td><?php echo $manager->user->name?></td>
        <td><?php echo $manager->user->patronymic?></td>
        <td><?php echo $manager->user->email?></td>
        <td><?php echo $manager->user->password?></td>

        <td><a href="/admin/default/managerdelete?id=<?php echo $manager->user->id?>">Уволить менеджера</a></td>
    <?php endif;?>
    </tr>
<?php endforeach; ?>
</table>


<h3>Рекрутеры</h3>
<table>
    <tr>
        <td>Фамилия</td>
        <td>Имя</td>
        <td>Отчество</td>
        <td>email</td>
        <td>Пароль</td>

        <td>Действие</td>

    </tr>
<?php foreach($recruiters as $recruiter):?>
    <tr>
    <?php if(is_object($recruiter->user)):?>
        <td><?php echo $recruiter->user->surname?></td>
        <td><?php echo $recruiter->user->name?></td>
        <td><?php echo $recruiter->user->patronymic?></td>
        <td><?php echo $recruiter->user->email?></td>
        <td><?php echo $recruiter->user->password?></td>

        <td>
            <a href="/admin/default/recruiter?id=<?php echo $recruiter->user->id?>">Просмотр</a>
            <a href="/admin/default/recruiterdelete?id=<?php echo $recruiter->user->id?>">Уволить менеджера</a>

        </td>
    <?php endif;?>
    </tr>
<?php endforeach; ?>
</table>