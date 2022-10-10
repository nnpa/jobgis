<h3>Мои вакансии</h3>
<table>
<?php foreach($vacancies as $vacancy):?>
    <tr>
        <td>
            <a href="/vacancy/edit?id=<?php echo $vacancy->id;?>"><?php echo $vacancy->name;?></a>
        <td>
        <td>    
            Добавлена <?php echo date("d.m.Y",$vacancy->create_time);?>
        </td>
        <td>
            <a href="/vacancy/delete?id=<?php echo $vacancy->id;?>">Удалить</a>
        </td>
<?php endforeach; ?>
<table>
