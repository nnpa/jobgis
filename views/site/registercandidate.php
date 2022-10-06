<style>
body {
    width: 610px;
}

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
<?php foreach($errors as $error):?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error;?>
    </div>
<?php endforeach;?>

<form method="POST">
    Фамилия <input type="text" name="surname"><br>

    Имя <input type="text" name="name"><br>
    Отчество <input type="text" name="patronymic"><br>

    Телефон <input id="phone" type="text" name="phone"><br>
    Город 
    <div class="frmSearch">
        <input  id="search-box" id="cityInput" value="<?php echo $city;?>" type="text" name="city">
    </div>
    <div id="suggesstion-box"></div>
    <br>
    email <input type="text" name="email"><br>
    <input type="submit" value="Заререгистрироваться">
</form>