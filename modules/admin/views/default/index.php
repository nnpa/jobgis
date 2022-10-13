<h3>Добро прожаловать в панель администратора</h3>
<h5>Последние вакансии<h5>
<?php foreach($vacancys as $vacancy):?>
    <a target="_blank" href="/vacancy/show?id=<?php echo $vacancy->id?>"><?php echo $vacancy->name;?></a><br>
<?php endforeach; ?>