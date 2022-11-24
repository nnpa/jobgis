<style>
    td{
        border:1px solid black;
        paddin:5px;
    }
</style>
<h5>Вакансии ваших компаний</h5>

<table>
    <tr>
        <td>Вакансия</td>
        <td>Фирма</td>
    </tr>
    <?php foreach($vacancies as $vacancy):?>
    <tr>
        <td><a target="_blank" href="/vacancy/show?id=<?php echo $vacancy->id?>"><?php echo $vacancy->name?></a></td>
        <td><?php echo $vacancy->user->firm->name?></td>
    </tr>
    <?php endforeach;?>
</table>