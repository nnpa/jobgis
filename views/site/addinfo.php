<style>


#country-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 190px;
    position: absolute;
}

#country-list li {
    padding: 10px;
    background: #f0f0f0;
    border-bottom: #bbb9b9 1px solid;
}

#country-list li:hover {
    background: #ece3d2;
    cursor: pointer;
}


</style>

<script type="text/javascript">
$(document).ready(function() {
        $("#phone").mask("+7 (999) 999 99 99");

	$("#search-box").keyup(function() {
		$.ajax({
			type: "GET",
			url: "/site/city",
			data: 'keyword=' + $(this).val(),
			success: function(data) {
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#search-box").css("background", "#FFF");
			}
		});
	});
});
//To select a country name
function selectCountry(val) {
	$("#search-box").val(val);
	$("#suggesstion-box").hide();
}
</script>
<h3>Заполните данные</h3>
<form method="POST">
    Имя* <input type="text" name="name" value="<?php echo $user->name;?>"><br>
    Фамилия* <input type="text" name="surname" value="<?php echo $user->surname;?>"><br>
    Отчество* <input type="text" name="patronymic" value="<?php echo $user->patronymic;?>"><br>
    Телефон* <input type="text" id="phone" name="phone" value="<?php echo $user->phone;?>"><br>
    Город *
   <div class="frmSearch">
        <input  id="search-box"  id="cityInput" type="text" value="<?php echo $user->city;?>" name="city">
    </div>
    <div id="suggesstion-box"></div><br>
    <input type="submit" value="Сохранить" class="btn btn-success">
    Поля помеченные * обязательны к заполнению
</form>