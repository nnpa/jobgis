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

    </tr>
<?php foreach($managers as $manager):?>
    <tr>
    <?php if(is_object($manager->user)):?>
        <td><?php echo $manager->user->surname?></td>
        <td><?php echo $manager->user->name?></td>
        <td><?php echo $manager->user->patronymic?></td>
        <td><?php echo $manager->user->email?></td>

    <?php endif;?>
    </tr>
<?php endforeach; ?>
</table>