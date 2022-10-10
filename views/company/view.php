<h3>Компания <?php echo $firm->name;?></h3>

<h4>Вакансии компании</h4>

<?php foreach($vacancys as $vacancy):?>
    <a target="_blank" href="/vacancy/show?id=<?php echo $vacancy->id?>"><?php echo $vacancy->name;?></a><br>
<?php endforeach; ?>

