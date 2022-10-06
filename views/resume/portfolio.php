<h3>Портфолио</h3>

<?php foreach($resumePortfolio as $portfolio):?>
<img src="/img/<?php echo $portfolio->photo;?>">
<a href="/resume/deleteportfolio?id=<?php echo $resume->id?>&portfolio_id=<?php echo $portfolio->id?>">Удалить</a>
    <br>
<?php endforeach;?>

<small>Загрузить фото в формате jpg</small>
<form method="POST"  enctype="multipart/form-data">
<input type="file" name="image" accept=".jpg,.jpeg"><br>

<input type="submit" value="Загрузить" class="btn btn-success" > 
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-primary">Отменить</a>

</form>
