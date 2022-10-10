<style>

#country-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 0;
    width: 190px;
    position: absolute;
    z-index: 1;

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
        $("#phone").mask("+9 (999) 999-99-99");

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
<h3>Настройки</h3>
<form method="POST">
    <b>Имя</b> <input type="text" name="name" value="<?php echo $user->name;?>"><br>
     <b>Фамилия</b> <input type="text" name="surname" value="<?php echo $user->surname;?>"><br>
     <b>Отчество</b> <input type="text" name="patronymic" value="<?php echo $user->patronymic;?>"><br>
     <b>Телефон</b> <input id="phone" type="text" name="phone" value="<?php echo $user->phone;?>"><br>
     <b>Город </b>
                    <div class="frmSearch">
                    <input  id="search-box" value="<?php echo $user->city;?>" id="cityInput" type="text" name="city">
                    </div>
                    <div id="suggesstion-box"></div>
    <input type="submit" value="Сохранить" class="btn btn-success">
</form>