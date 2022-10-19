<h5><?php echo $firm->name;?></h5>

Отасль : <?php echo $firm->category;?><br>
Сайт: <?php $firm->site;?>
<h5>О компании</h5>
<?php echo $firm->about;?>
<h5>Вакансии компании</h5>

<?php foreach($vacancys as $vacancy):?>
    <a target="_blank" href="/vacancy/show?id=<?php echo $vacancy->id?>"><?php echo $vacancy->name;?></a><br>
<?php endforeach; ?>

