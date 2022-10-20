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
<h5>Настройки</h5>
<form method="POST">
    <b>Имя</b> <input type="text" name="name" value="<?php echo $user->name;?>"><br>
     <b>Фамилия</b> <input type="text" name="surname" value="<?php echo $user->surname;?>"><br>
     <b>Отчество</b> <input type="text" name="patronymic" value="<?php echo $user->patronymic;?>"><br>
     <b>Телефон</b> <input id="phone" type="text" id="phone" name="phone" value="<?php echo $user->phone;?>"><br>
     <b>Город </b>
                    <div class="frmSearch">
                    <input  id="search-box" value="<?php echo $user->city;?>" id="cityInput" type="text" name="city">
                    </div>
                    <div id="suggesstion-box"></div>
    <input type="submit" value="Сохранить" class="btn btn-success">
</form>

<?php if($firm->id != 0):?>
<h5>Информация о компании</h5>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<p>Для публикации вашей компании в каталоге заполните следующие поля</p>
<form method="POST"  enctype="multipart/form-data">
    <?php echo $firm->name?><br>
    <b>ИНН</b> <?php echo $firm->inn?><br>
    <b>Отрасль</b>  <?php echo $firm->category?><br>
    <b>Логотип</b><br>
    <?php if($firm->logo != ""):?>
        <img width="80px" height="80px" src="/img/<?php echo $firm->logo;?>"><br>
    <?php endif?>
    <small>Загрузите изображение в формате jpg</small> <br>
    <input type="file" name="image" accept=".jpg,.jpeg"><br>

    <b>Сайт</b><br>
    <input type="text" name="site" value="<?php echo $firm->site;?>" style="width: 200px"><br>
    <b>О компании</b><br>
    <textarea name="about"  style="width:400px;height: 150px"><?php echo $firm->about;?></textarea><br>
    <input type="submit" class="btn btn-success" value="Сохранить">
</form>
<?php endif;?>