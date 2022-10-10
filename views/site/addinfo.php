<h3>Заполните данные</h3>
<form method="POST">
    Имя <input type="text" name="name" value="<?php echo $user->name;?>"><br>
    Фамилия <input type="text" name="surname" value="<?php echo $user->surname;?>"><br>
    Отчество <input type="text" name="patronymic" value="<?php echo $user->patronymic;?>"><br>
    Телефон <input type="text" name="phone" value="<?php echo $user->phone;?>"><br>
    <input type="submit" value="Сохранить" class="btn btn-success">
</form>