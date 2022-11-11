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
                <b>Должность</b>
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
                Добавил
            </td>
            <td>
               <b>Удалить</b>
            </td>
            <td>
               <b>Редактировать</b>
            </td>
        </tr>
    
    <?php foreach($vacancies as $vacancy):?>
        <tr>
            <td>
                <?php echo $vacancy->name;?> 
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
                <?php echo $vacancy->user->name;?>
            </td>
            <td>
                <?php if($user->id == $vacancy->user_id):?>
                    <a href="/vacancy/delete?id=<?php echo $vacancy->id;?>">Удалить</a>
                <?php endif;?>
            </td>
            <td>
                <?php if($user->id == $vacancy->user_id):?>
                    <a href="/vacancy/edit?id=<?php echo $vacancy->id;?>">Редактировать </a>
                <?php endif;?>    
            </td>
        </tr>
    <?php endforeach; ?>
</table>
