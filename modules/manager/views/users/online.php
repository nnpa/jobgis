<style>
    td{
        border: 1px solid black;
    }
</style>
<table>
    
    <tr>
        <td><b>Имя</b></td>
        <td><b>Фамилия</b></td>
        <td><b>Email</b></td>
        <td><b>Компания</b></td>
    </tr>
<?php foreach($users as $user):?>
    <tr>
        <td><?php echo $user->name;?></td>
        <td><?php echo $user->surname;?></td>
        <td><?php echo $user->email;?></td>
        <td><?php echo $user->company;?></td>
    </tr>
<?php endforeach; ?>
</table>