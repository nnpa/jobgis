<h3>Мои вакансии</h3>
<?php foreach($vacancies as $vacancy):?>
<div>
    <div style="float:left;width:30%">
        <a href="/vacancy/show?id=<?php echo $vacancy->id;?>" target="_blank"><?php echo $vacancy->name;?></a>
    </div>
    <div style="float:left;width:30%">
         Добавлена <?php echo date("d.m.Y",$vacancy->create_time);?>
    </div>
    <div style="float:left;width:30%">
        <a href="/vacancy/delete?id=<?php echo $vacancy->id;?>">Удалить</a>
    </div>
</div>
<?php endforeach; ?>
