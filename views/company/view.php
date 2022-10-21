<h5><?php echo $firm->name;?></h5>
<?php if($firm->logo != ""):?>
    <img width="80px" height="80px" src="/img/<?php echo $firm->logo;?>"><br>
<?php endif?>
Отрасль : <?php echo $firm->category;?><br>
Город : <?php echo $firm->city;?><br>

Сайт: <a href="<?php echo $firm->site;?>"><?php echo $firm->site;?></a>
<h5>О компании</h5>
<?php echo $firm->about;?>
<h5>Вакансии компании</h5>

<?php foreach($vacancys as $vacancy):?>
    <a target="_blank" href="/vacancy/show?id=<?php echo $vacancy->id?>"><?php echo $vacancy->name;?></a><br>
<?php endforeach; ?>

<?php if(!Yii::$app->user->isGuest):?>
    <form method="POST">
        <b>Оставить отзыв</b><br>
        <textarea name="description" style="width:250px;height: 60px"></textarea><br>
        <input type="submit" class="btn btn-success" value="Сохранить">
    </form>
<?php endif; ?>

<h5>Отзывы</h5>

<?php foreach($re as $r):?>
    <?php echo $r->description;?>
<hr>
<?php endforeach; ?>

