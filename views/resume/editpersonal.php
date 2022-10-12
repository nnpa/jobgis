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

<form method="POST">
<input type="hidden" name="id" value="<?php echo $resume->id;?>">
<div class="row">
    <div class="col-1">
       <b>Фамилия</b>
    </div>
    <div class="col-9">
         <input type="text" name="surname" value="<?php echo $resume->surname;?>">
    </div>
</div>

<div class="row">
    <div class="col-1">
        <b>Имя</b> 
    </div>
    <div class="col-9">
        <input type="text" name="name" value="<?php echo $resume->name;?>"><br>
    </div>
</div>
<div class="row">
    <div class="col-1">
        <b>Отчество</b> 
    </div>
    <div class="col-9">
        <input type="text" name="patronymic" value="<?php echo $resume->patronymic;?>"><br>
    </div>
</div>
<b>Дата рождения</b> 

<?php 


    $date = explode(".",$resume->birth_date);
    
        
        $monthArray = [
            "1" => "Январь",
            "2" => "Февраль",
            "3" => "Март",
            "4" => "Апрель",
            "5" => "Май",
            "6" => "Июнь",
            "7" => "Июль",
            "8" => "Август",
            "9" => "Сентябрь",
            "10"=> "Октябрь",
            "11" => "Ноябрь",
            "12" => "Декабрь"
        ];
    
    if(count($date) < 3){
        $day = "1";
        $month = "январь";
        $year = "2022";
    } else{
        $day = $date[0];


        $month = $monthArray[$date[1]];
        
        $year = $date[2];
    }
    
    
    
?>
<input type="text" style="width:40px" name="day" value="<?php echo $day;?>">
<select name="month" >
    <?php foreach($monthArray as $key => $value):?>
        <option value="<?php echo $value;?>" <?php echo ($value==$month)?'selected':''?>><?php echo $value;?></option>
    <?php endforeach;?>
</select>
<input  type="text" name="year" style="width:60px" value="<?php echo $year;?>"><br>
<b>Пол: </b> <br>
<input type="radio" value="мужской" name="gender" <?php echo ("мужской" == $resume->gender)?"checked":"";?> > мужской<br>
<input type="radio" value="женский" name="gender" <?php echo ("женский" == $resume->gender)?"checked":"";?> > женский<br>
<b>Город</b> 

    <div class="frmSearch">
        <input  id="search-box" id="cityInput" value="<?php echo $resume->city;?>" type="text" name="city">
    </div>
    <div id="suggesstion-box"></div>
    <b>Переезд</b> <br>
<input type="radio" value="Невозможен" name="relocation" <?php echo ("Невозможен" == $resume->relocation)?"checked":"";?> > Невозможен<br>
<input type="radio" value="Возможен" name="relocation" <?php echo ("Возможен" == $resume->relocation)?"checked":"";?> > Возможен<br>
<input type="radio" value="Желателен" name="relocation" <?php echo ("Желателен" == $resume->relocation)?"checked":"";?> > Желателен<br>

<b>Готовность к командировкам</b><br>
<input type="radio" value="Никогда" name="business_trips" <?php echo ("Никогда" == $resume->business_trips)?"checked":"";?> > Никогда<br>
<input type="radio" value="Готов" name="business_trips" <?php echo ("Готов" == $resume->business_trips)?"checked":"";?> > Готов<br>
<input type="radio" value="Иногда" name="business_trips" <?php echo ("Иногда" == $resume->business_trips)?"checked":"";?> > Иногда<br>
<br>
<input type="submit" class="btn btn-success" value="Сохранить">
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-primary">Отменить</a>
</form>