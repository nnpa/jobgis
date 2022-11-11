<style>
    td {
        border:1px solid black;
        padding:5px;
    }
</style>
<h3>Мои вакансии</h3>
<a href="/vacancy/add" class="btn btn-success">Разместить вакансию</a>
<table>
<tr>
            <td>
                <b>Наименование</b>
            </td>
            
            <td>
               <b>Город</b>
            </td>
            <td>
                 <b>Зарплата</b>
            </td>
            <td>
                 <b>Дата</b>
            </td>
            <td>
               <b>Действия</b>
            </td>
        </tr>
    
    <?php foreach($vacancies as $vacancy):?>
        <tr>
            <td>
                <a href="/vacancy/edit?id=<?php echo $vacancy->id;?>"><?php echo $vacancy->name;?> </a>
            </td>
            
            <td>
                <?php echo $vacancy->city;?> 
            </td>
            <td>
                 <?php echo $vacancy->costfrom;?>
            </td>
            <td>
                 Добавлена <?php echo date("d.m.Y",$vacancy->create_time);?>
            </td>
            <td>
                <a href="/vacancy/delete?id=<?php echo $vacancy->id;?>">Удалить</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
