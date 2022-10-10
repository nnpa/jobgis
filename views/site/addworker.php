<h3>Пригласите сотрудника</h3>
<?php foreach($errors as $error):?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error;?>
    </div>
<?php endforeach;?>
<form method="POST">
    Email <input type="text" name="email"><br>
    <input type="submit" class="btn btn-success" value="Выслать приглашение">
</form>