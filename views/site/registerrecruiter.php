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
        $("#phone").mask("+9 (999) 999 99 99");

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

<div>

<div style="float:left;width:30%">&nbsp;</div>
<div style="float:left;width:30%;min-width: 350px;border:1px solid black;padding: 10px;border-radius: 5px;">
        <center> <h5>CRM для HR и рекрутинга</h5></center>

    <form method="POST">
        
        <div class="row">
            <div class="col-3">
                <b>Email*</b> 
            </div>
            <div class="col-4">
                <input type="text" value="<?php echo $email;?>" name="email">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <center>
                    <input class="btn btn-success" type="submit" value="Зарегистрироваться"><br>
                    Нажимая «Зарегистрироваться», вы принимаете  пользовательское соглашение и <a target="_blank" href="/privacy/">политику конфиденциальности</a> и использование файлов cookie.

                </center>
            </div>
        </div>
    </form>

        Поля помеченные * обязательны к заполнению<br><br>
        Уже зарегистрированы?<br>
        <center> <a href="/site/login">Вход</a></center>

</div>
<div style="float:left;width:30%">&nbsp;</div>
</div>