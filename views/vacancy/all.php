<h3>Мои вакансии</h3>

<?php foreach($vacancies as $vacancy):?>
<div>
    <div style="width: 30%;float:left">
        <a href="/vacancy/edit?id=<?php echo $vacancy->id;?>"><?php echo $vacancy->name;?></a>
    </div>    
    <div style="width: 30%;float:left">

        Добавлена <?php echo date("d.m.Y",$vacancy->create_time);?>
    </div> 
    <div style="width: 30%;float:left">

        <a href="/vacancy/delete?id=<?php echo $vacancy->id;?>">Удалить</a>
    </div>
</div>
<?php endforeach; ?>
