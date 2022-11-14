

<script type="text/javascript">
$(document).ready(function() {
        $("#phone").mask("+7 (999) 999 99 99");


});
//To select a country name
function selectCountry(val) {
	$("#search-box").val(val);
	$("#suggesstion-box").hide();
}
</script>
<?php foreach($errors as $error):?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error;?>
    </div>
<?php endforeach;?>
<h3>Заполните данные</h3>
<form action="/recruiter/default/info" method="POST">
    Имя* <input type="text" name="name" value="<?php echo $user->name;?>"><br>
    Фамилия* <input type="text" name="surname" value="<?php echo $user->surname;?>"><br>
    Отчество* <input type="text" name="patronymic" value="<?php echo $user->patronymic;?>"><br>
    Телефон* <input type="text" id="phone" name="phone" value="<?php echo $user->phone;?>"><br>
    <input type="submit" value="Сохранить" class="btn btn-success"><br>
    Поля помеченные * обязательны к заполнению
</form>