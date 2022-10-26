<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<?php foreach($errors as $error):?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error;?>
    </div>
<?php endforeach;?>
<p>Для публикации вашей компании в каталоге заполните следующие поля</p>

<form method="POST"  enctype="multipart/form-data">
    <b>Логотип</b><br>
    <small>Загрузите <b>квадратное</b> изображение в формате jpg</small> <br>

    <input type="file" name="image" accept=".jpg,.jpeg"><br>

    <b>Сайт</b><br>
    <input type="text" name="site" style="width: 200px"><br>
    <b>О компании</b><br>
    <textarea name="about" style="width:400px;height: 150px"></textarea><br>
    <input type="submit" class="btn btn-success" value="Сохранить">
</form>