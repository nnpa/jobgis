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
<style>
    td {border:1px solid black}
</style>
<h5>Рекрутер <?php echo $user->email;?></h5>

<h5>Фирмы</h5>
<table>
    <tr>
        <td>Название</td>
        <td>Город</td>
        <td>Отрасль</td>
    </tr>
    <?php foreach($firms as $firm):?>
    <tr>
        <td>
            <?php echo $firm->name;?>
            
        </td>
        <td>
            <?php echo $firm->city;?>
            
        </td>
        <td>
            <?php echo $firm->category;?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

<h5>Доступ</h5>
<table>
    <tr>
        <td>Вакансия</td>
        <td>Город</td>
    </tr>
    <?php foreach($recruiters as $recruiter):?>
    <tr>
        <td>
            <?php echo $recruiter->name;?>
        </td>
        <td>
            <?php echo $recruiter->city;?>
        </td>
    </tr>
    <?php endforeach;?>

</table>

<form method="POST">
<h5>Открыть доступ</h5>
<b>Вакансия</b> <br><input type="text" name="name"><br>
<b>Город</b> 
<div class="frmSearch">
    <input  id="search-box"  id="cityInput" type="text"  name="city">
</div>
<div id="suggesstion-box"></div><br>
<input type="submit" value="Добавить" class="btn btn-success">
</form>