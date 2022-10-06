Загрузите изображение в формате jpg <br>
<form method="POST"  enctype="multipart/form-data">
<input type="file" name="image" accept=".jpg,.jpeg"><br>
<input type="hidden" name="id" value="<?php echo $id;?>"><br>

<input type="submit" value="Загрузить" class="btn btn-success" > 
<a href="/resume/edit?id=<?php echo $id?>" class="btn btn-primary">Отменить</a>

</form>