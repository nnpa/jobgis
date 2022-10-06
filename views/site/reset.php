<?php foreach($errors as $error):?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error;?>
    </div>
<?php endforeach;?>

<form method="POST">
    Email <input type="text" name="email"><br>
    <input type="submit" value="Выслать пароль">
</form>