<style>
    jqte_toolbar{
        padding: 10px;
        margin:10px;
        heigh:20px;
    }
</style>
<script>
   $(document).ready(function() {
 
	$('.jqte-test').jqte();
	
	// settings of status

   });
</script>
<style>
.popup-fade {
	display: none;
}
.popup-fade:before {
	content: '';
	background: #000;
	position: fixed; 
	left: 0;
	top: 0;
	width: 100%; 
	height: 100%;
	opacity: 0.7;
	z-index: 9999;
}
.spec-div{
    overflow-y: scroll; /* прокрутка по вертикали */
    height: 600px;
    
}
.popup {
	position: fixed;
	top: 20%;
	left: 20%;
	padding: 20px;
	width: 600px;
	margin-left: -200px;	
	background: #fff;
	border: 1px solid orange;
	border-radius: 4px; 
	z-index: 99999;
	opacity: 1;	

}
.popup-close {
	position: absolute;
	top: 10px;
	right: 10px;
}
</style>


<script>
$(document).ready(function($) {
	$('.popup-open').click(function() {
		$('.popup-fade').fadeIn();
		return false;
	});	
	
	$('.popup-close').click(function() {
		$(this).parents('.popup-fade').fadeOut();
		return false;
	});		
 
	$(document).keydown(function(e) {
		if (e.keyCode === 27) {
			e.stopPropagation();
			$('.popup-fade').fadeOut();
		}
	});
	
	$('.popup-fade').click(function(e) {
		if ($(e.target).closest('.popup').length == 0) {
			$(this).fadeOut();					
		}
	});
});


</script>


<style type="text/css">
    * { margin: 0; padding: 0; }
body { background: #f0f0f0; font-family: Arial, Helvetica, sans-serif; }

.box {
width: 250px;
margin: 10px auto;
background: #fff;
border: 1px solid #d1d1d1;
padding: 4px;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
-moz-box-shadow: 0px 0px 10px #ddd;
-webkit-box-shadow: 0px 0px 10px #ddd;
}
.box h3 {

font-size: 13px;
font-weight: normal;
text-shadow: 1px 1px 0px #fff;
}

.box ul { padding: 5px; overflow: hidden; }
.box ul li {   list-style-type: none;
font-size: 13px;  list-style-position: inside; padding: 5px; }
</style>

<script type="text/javascript">
$(document).ready(function(){
$("ul.spec").hide();
$("ul.spec li:odd").css("background-color", "#efefef");
$("h3 span").click(function(){
$(this).parent().next().slideToggle();
});
});
</script>

<script type="text/javascript">
function addSpec(spec,obj){
    
    var sub_spec = $(obj).val();
    $("#spec").val(spec);
    $("#specsub").val(sub_spec);
    $("#spectext").html(sub_spec);

}
</script>

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
<script type="text/javascript">
function showHideAddress(type){
    if(type=="show"){
        $("#address").show();
    }else{
        $("#address").hide();
    }
    
}
</script>






<script type="text/javascript">
$(document).ready(function() {

	$("#search-box-skills").keyup(function() {
		$.ajax({
			type: "GET",
			url: "/vacancy/skills",
			data: 'keyword=' + $(this).val(),
			success: function(data) {
				$("#suggesstion-box-skills").show();
				$("#suggesstion-box-skills").html(data);
				$("#search-box-skills").css("background", "#FFF");
			}
		});
	});
});
//To select a country name
function selectSkill(val) {
	//$("#search-box-skills").val(val);
        $("#skills").html(
            $("#skills").html() + "<div onClick='deleteSkill(this)' style='margin:4px;border-radius:5px;background-color:edeff0;padding:4px;border:1px solid gray;min-width:10px;float:left;'>" + val + " <span style='color:blue;cursor: pointer'>x</span></div>"
        );
	$("#search-box-skills").val("");
        
        var value = $("#skills-input").val();
        var valueArray = value.split(",");
        
        valueArray.push(val);
        
        var valString = valueArray.join(",");
        
        $("#skills-input").val(valString);
         
	$("#suggesstion-box-skills").hide();
}

function deleteSkill(obj){
    
    var value = $("#skills-input").val();
    var valueArray = value.split(",");
    console.log(valueArray);
    var element = $(obj).html();
    element = element.replace(" <span style=\"color:blue;cursor: pointer\">x</span>","");
        var newArr = [];
    for (var i = 0; i < valueArray.length; i++) {
        if(valueArray[i] != element){
            newArr[i] = valueArray[i];
        }
    }
    var valString = newArr.join(",");
    $("#skills-input").val(valString);
    
    $(obj).remove();
}
</script>

<h5>Создание вакансии</h5>
<form method="POST" id="formid">
<b>Название вакансии</b><br>
<input type="name" name="name" style="width:40%" value="<?php echo $vacancy->name;?>">
<input type="hidden" id="spec" name="spec" value="<?php echo $vacancy->spec;?>"><br>
<b>Укажите специализацию</b><br>
<input type="text" class="popup-open" id="specsub" name="specsub" value="<?php echo $vacancy->specsub;?>"><br>


<b>Город</b><br>
    <div class="frmSearch">
        <input  id="search-box"  id="cityInput" type="text" value="<?php echo $vacancy->city;?>" name="city">
    </div>
    <div id="suggesstion-box"></div><br>
    
    <b>Предполагаемый уровень дохода в месяц</b><br>
<input type="text" name="costfrom" style="width:100px;" value="<?php echo $vacancy->costfrom;?>" placeholder="от"> 
<input type="text" name="costto"  style="width:100px;" value="<?php echo $vacancy->costto;?>" placeholder="до"> 
<?php $cash = ["руб.","EUR","USD"];?>
<select name="cash" style="width:100px;">
    <?php foreach($cash as $c):?>
       <option value="<?php echo $c;?>" <?php echo ($c == $vacancy->cash)?'selected':''?>><?php echo $c;?></option>
    <?php endforeach;?>

</select><br>
<input type="radio" name="cashtype" <?php echo ("До вычета налогов" == $vacancy->cashtype)?'checked':''?>  value="До вычета налогов"> До вычета налогов<br>
<input type="radio" name="cashtype"  <?php echo ("На руки" == $vacancy->cashtype)?'checked':''?> value="На руки"> На руки<br><br>

<b>Где будет работать сотрудник</b> <br>
<input type="radio" name="addresstype" 	checked onClick="showHideAddress('hide')"> Не указывать адрес<br>
<input type="radio" name="addresstype" onClick="showHideAddress('show')"> Указать адрес <br>
<div id="address" style="display: none">
    <small>Город, улица, дом</small><br>
    <input type="text"  value="<?php echo $vacancy->address;?>" name="address" >
</div><br>
<b>Опыт работы</b><br>
<input type="radio" name="exp" <?php echo ("Нет опыта" == $vacancy->exp)?'checked':''?> value="Нет опыта"> Нет опыта <br>
<input type="radio" name="exp" <?php echo ("От 1 года до 3 лет" == $vacancy->exp)?'checked':''?> value="От 1 года до 3 лет"> От 1 года до 3 лет<br>
<input type="radio" name="exp" <?php echo ("От 3 до 6 лет" == $vacancy->exp)?'checked':''?> value="От 3 до 6 лет"> От 3 до 6 лет<br>
<input type="radio" name="exp" <?php echo ("Более 6 лет" == $vacancy->exp)?'checked':''?> value="Более 6 лет"> Более 6 лет<br><br>
<b>Расскажите про вакансию</b><br>

<textarea class="jqte-test"  name="description" >
        <?php if($vacancy->description == ""):?>
        <b>Обязанности: </b><br>
        -<br>
        -<br>
        -<br>
        <b>Требования:</b><br>
        -<br>
        -<br>
        -<br>
        <b>Условия:</b><br>
        -<br>
        -<br>
        -<br>
        <?php else:?>
        <?php echo $vacancy->description;?>
        <?php endif;?>
        </textarea>

<input type="hidden" name="skills" id="skills-input" value="<?php echo $vacancy->skills;?>">
<div>  &nbsp;</div>

    <b> Занятость</b><br>
    <input type="radio" name="employment" <?php echo ("Полная занятость" == $vacancy->employment)?'checked':''?> value="Полная занятость"> Полная занятость<br>
    <input type="radio" name="employment" <?php echo ("Частичная занятость" == $vacancy->employment)?'checked':''?> value="Частичная занятость"> Частичная занятость<br>
    <input type="radio" name="employment" <?php echo ("Проектная работа или разовое задание" == $vacancy->employment)?'checked':''?> value="Проектная работа или разовое задание"> Проектная работа или разовое задание<br>
    <input type="radio" name="employment" <?php echo ("Волонтерство" == $vacancy->employment)?'checked':''?> value="Волонтерство"> Волонтерство<br>
    <input type="radio" name="employment" <?php echo ("Стажировка" == $vacancy->employment)?'checked':''?> value="Стажировка"> Стажировка<br>
    <br>
    
    <b> График работы</b><br>
    <input type="radio" name="workschedule" <?php echo ("Полный день" == $vacancy->workschedule)?'checked':''?> value="Полный день"> Полный день<br>
    <input type="radio" name="workschedule" <?php echo ("Сменный график" == $vacancy->workschedule)?'checked':''?> value="Сменный график"> Сменный график<br>
    <input type="radio" name="workschedule" <?php echo ("Гибкий график" == $vacancy->workschedule)?'checked':''?> value="Гибкий график"> Гибкий график<br>
    <input type="radio" name="workschedule" <?php echo ("Удаленная работа" == $vacancy->workschedule)?'checked':''?> value="Удаленная работа"> Удаленная работа<br>
    <input type="radio" name="workschedule" <?php echo ("Вахтовый метод" == $vacancy->workschedule)?'checked':''?> value="Вахтовый метод"> Вахтовый метод<br>
    <br>
    
    <h5>Контакты</h5>
    <b>Контактное лицо</b><br>
    <input type="text" name="contactmane" value="<?php echo $vacancy->contactmane ?>"><br>
    <b>Email</b><br>
    <input type="text" name="email"  value="<?php echo $vacancy->email?>"><br>
    <b>Телефон</b><br>
    <input type="text" id="phone" name="phone" value="<?php echo $vacancy->phone?>"><br>
    <div style="padding-top:10px">
    
        <input type="submit" class="btn btn-success" value="Сохранить">
    </div>
</form>


<div class="popup-fade">
	<div class="popup">
            <a class="popup-close" href="#">Закрыть</a>
            <div class="spec-div">
                <div class="box">
                    <h3><span class="expand">Автомобильный бизнес</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Автомобильный бизнес',this)" type="radio" name="specr" value="Автомойщик"> Автомойщик</li>
                        <li><input onClick="addSpec('Автомобильный бизнес',this)" type="radio" name="specr" value="Автослесарь, автомеханик"> Автослесарь, автомеханик</li>
                        <li><input onClick="addSpec('Автомобильный бизнес',this)" type="radio" name="specr" value="Мастер-приемщик"> Мастер-приемщик</li>
                        <li><input onClick="addSpec('Автомобильный бизнес',this)" type="radio" name="specr" value="Менеджер по продажам, менеджер по работе с клиентами"> Менеджер по продажам, менеджер по работе с клиентами</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Административный персонал</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Административный персонал',this)"  type="radio" name="specr" value="Администратор"> Администратор</li>
                        <li><input onClick="addSpec('Административный персонал',this)"  type="radio" name="specr" value="Делопроизводитель, архивариус"> Делопроизводитель, архивариус</li>
                        <li><input onClick="addSpec('Административный персонал',this)"  type="radio" name="specr" value="Курьер"> Курьер</li>
                        <li><input onClick="addSpec('Административный персонал',this)"  type="radio" name="specr" value="Менеджер/руководитель АХО"> Менеджер/руководитель АХО</li>
                        <li><input onClick="addSpec('Административный персонал',this)"  type="radio" name="specr" value="Оператор ПК, оператор базы данных"> Оператор ПК, оператор базы данных</li>
                        <li><input onClick="addSpec('Административный персонал',this)"  type="radio" name="specr" value="Офис-менеджер"> Офис-менеджер</li>
                        <li><input onClick="addSpec('Административный персонал',this)" type="radio" name="specr" value="Переводчик"> Переводчик</li>
                        <li><input onClick="addSpec('Административный персонал',this)" type="radio" name="specr" value="Секретарь, помощник руководителя, ассистент"> Секретарь, помощник руководителя, ассистент</li>
                    </ul>
                </div>
                 <div class="box">
                    <h3><span class="expand">Безопасность</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Безопасность',this)"  type="radio" name="specr" value="Военнослужащий"> Военнослужащий</li>
                        <li><input onClick="addSpec('Безопасность',this)"  type="radio" name="specr" value="Охранник"> 	Охранник</li>
                        <li><input onClick="addSpec('Безопасность',this)"  type="radio" name="specr" value="Полицейский"> Полицейский</li>
                        <li><input onClick="addSpec('Безопасность',this)"  type="radio" name="specr" value="Специалист по информационной безопасности"> Специалист по информационной безопасности</li>
                        <li><input onClick="addSpec('Безопасность',this)"  type="radio" name="specr" value="Специалист службы безопасности"> Специалист службы безопасности</li>
                    </ul>
                </div>
                
                 <div class="box">
                    <h3><span class="expand">Высший менеджмент</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Высший менеджмент',this)"   type="radio" name="specr" value="Генеральный директор, исполнительный директор (CEO)"> Генеральный директор, исполнительный директор (CEO)</li>
                        <li><input onClick="addSpec('Высший менеджмент',this)"   type="radio" name="specr" value="Директор по информационным технологиям (CIO)"> Директор по информационным технологиям (CIO)</li>
                        <li><input onClick="addSpec('Высший менеджмент',this)"   type="radio" name="specr" value="Директор по маркетингу и PR (CMO)"> Директор по маркетингу и PR (CMO)</li>
                        <li><input  onClick="addSpec('Высший менеджмент',this)"  type="radio" name="specr" value="Директор по персоналу (HRD)"> Директор по персоналу (HRD)</li>
                        <li><input  onClick="addSpec('Высший менеджмент',this)"  type="radio" name="specr" value="Коммерческий директор (CCO)"> Коммерческий директор (CCO)</li>
                        <li><input onClick="addSpec('Высший менеджмент',this)"   type="radio" name="specr" value="Начальник производства"> Начальник производства</li>
                        <li><input onClick="addSpec('Высший менеджмент',this)"   type="radio" name="specr" value="Операционный директор (COO)"> Операционный директор (COO)</li>
                        <li><input  onClick="addSpec('Высший менеджмент',this)"  type="radio" name="specr" value="Финансовый директор (CFO)"> Финансовый директор (CFO)</li>
                    </ul>
                </div>
                 <div class="box">
                    <h3><span class="expand">Добыча сырья</span></h3>
                    <ul class="spec">
                        <li><input  onClick="addSpec('Добыча сырья',this)"  type="radio" name="specr" value="Геодезист"> Геодезист</li>
                        <li><input onClick="addSpec('Добыча сырья',this)" type="radio" name="specr" value="Геолог"> Геолог</li>
                        <li><input onClick="addSpec('Добыча сырья',this)" type="radio" name="specr" value="Инженер-технолог"> Инженер-технолог</li>
                        <li><input onClick="addSpec('Добыча сырья',this)" type="radio" name="specr" value="Машинист"> Машинист</li>
                        <li><input onClick="addSpec('Добыча сырья',this)" type="radio" name="specr" value="Научный специалист, исследователь, лаборант"> Научный специалист, исследователь, лаборант</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Домашний, обслуживающий персонал</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Домашний, обслуживающий персонал',this)" type="radio" name="specr" value="Администратор"> Администратор</li>
                        <li><input onClick="addSpec('Домашний, обслуживающий персонал',this)" type="radio" name="specr" value="Водитель"> 	Водитель</li>
                        <li><input onClick="addSpec('Домашний, обслуживающий персонал',this)" type="radio" name="specr" value="Дворник"> 	Дворник</li>
                        <li><input  onClick="addSpec('Домашний, обслуживающий персонал',this)" type="radio" name="specr" value="Курьер"> 	Курьер</li>
                        <li><input  onClick="addSpec('Домашний, обслуживающий персонал',this)" type="radio" name="specr" value="Официант, бармен, бариста"> Официант, бармен, бариста</li>
                        <li><input  onClick="addSpec('Домашний, обслуживающий персонал',this)" type="radio" name="specr" value="Охранник"> Охранник</li>
                        <li><input  onClick="addSpec('Домашний, обслуживающий персонал',this)" type="radio" name="specr" value="Уборщица, уборщик"> Уборщица, уборщик</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Закупки</span></h3>
                    <ul class="spec">
                        <li><input   onClick="addSpec('Закупки',this)"  type="radio" name="specr" value="Менеджер по закупкам"> Менеджер по закупкам</li>
                        <li><input onClick="addSpec('Закупки',this)"  type="radio" name="specr" value="Специалист по тендерам"> Специалист по тендерам</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Информационные технологии</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Информационные технологии',this)" type="radio" name="specr" value="Аналитик"> Аналитик</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Арт-директор, креативный директор"> Арт-директор, креативный директор</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Гейм-дизайнер"> Гейм-дизайнер</li>
                        <li><input onClick="addSpec('Информационные технологии',this)" type="radio" name="specr" value="Дизайнер, художник"> Дизайнер, художник</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Директор по информационным технологиям (CIO)"> Директор по информационным технологиям (CIO)</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Менеджер продукта"> Менеджер продукта</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Программист, разработчик"> Программист, разработчик</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Руководитель группы разработки"> Руководитель группы разработки</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Руководитель проектов"> Руководитель проектов</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Сетевой инженер"> Сетевой инженер</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Системный администратор"> Системный администратор</li>
                        <li><input onClick="addSpec('Информационные технологии',this)" type="radio" name="specr" value="Системный инженер"> Системный инженер</li>
                        <li><input onClick="addSpec('Информационные технологии',this)" type="radio" name="specr" value="Специалист по информационной безопасности"> Специалист по информационной безопасности</li>
                        <li><input onClick="addSpec('Информационные технологии',this)" type="radio" name="specr" value="Специалист технической поддержки"> Специалист технической поддержки</li>
                        <li><input onClick="addSpec('Информационные технологии',this)"  type="radio" name="specr" value="Тестировщик"> Тестировщик</li>
                        <li><input onClick="addSpec('Информационные технологии',this)" type="radio" name="specr" value="Технический директор (CTO)"> Технический директор (CTO)</li>
                        <li><input onClick="addSpec('Информационные технологии',this)" type="radio" name="specr" value="Технический писатель"> Технический писатель</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Искусство, развлечения, масс-медиа</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Арт-директор, креативный директор"> Арт-директор, креативный директор</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Артист, актер, аниматор"> Артист, актер, аниматор</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Видеооператор, видеомонтажер"> Видеооператор, видеомонтажер</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Гейм-дизайнер"> Гейм-дизайнер</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Дизайнер, художник"> Дизайнер, художник</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Журналист, корреспондент"> 	Журналист, корреспондент</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Копирайтер, редактор, корректор"> 	Копирайтер, редактор, корректор</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Продюсер"> 	Продюсер</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Режиссер, сценарист"> Режиссер, сценарист</li>
                        <li><input onClick="addSpec('Искусство, развлечения, масс-медиа',this)"  type="radio" name="specr" value="Фотограф, ретушер"> Фотограф, ретушер</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Маркетинг, реклама, PR</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"   type="radio" name="specr" value="Event-менеджер"> Event-менеджер/li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="PR-менеджер"> PR-менеджер</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="SMM-менеджер, контент-менеджер"> SMM-менеджер, контент-менеджер</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Аналитик"> 	Аналитик</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Арт-директор, креативный директор"> Арт-директор, креативный директор</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Дизайнер, художник"> Дизайнер, художник</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Директор по маркетингу и PR (CMO)">Директор по маркетингу и PR (CMO)</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Копирайтер, редактор, корректор">Копирайтер, редактор, корректор</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Менеджер по маркетингу и рекламе">Менеджер по маркетингу и рекламе</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Менеджер по продажам, менеджер по работе с клиентами">Менеджер по продажам, менеджер по работе с клиентами</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Менеджер по работе с партнерами">Менеджер по работе с партнерами</li>
                        <li><input onClick="addSpec('Маркетинг, реклама, PR',this)"  type="radio" name="specr" value="Промоутер">	Промоутер</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Медицина, фармацевтика</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"   type="radio" name="specr" value="Администратор"> Администратор</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Ассистент врача"> Ассистент врача</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Ветеринарный врач"> Ветеринарный врач</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Врач"> Врач</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Главный врач, заведующий отделением"> Главный врач, заведующий отделением</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Заведующий аптекой"> Заведующий аптекой</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Медицинская сестра"> Медицинская сестра</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Медицинский представитель"> Медицинский представитель</li>
                        <li><input onClick="addSpec('Медицина, фармацевтика',this)"  type="radio" name="specr" value="Фармацевт-провизор"> Фармацевт-провизор</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Наука, образование</span></h3>
                    <ul class="spec">
                        <li><input  onClick="addSpec('Наука, образование',this)" type="radio" name="specr" value="Бизнес-тренер"> Бизнес-тренер</li>
                        <li><input  onClick="addSpec('Наука, образование',this)" type="radio" name="specr" value="Воспитатель, няня"> Воспитатель, няня</li>
                        <li><input  onClick="addSpec('Наука, образование',this)" type="radio" name="specr" value="Научный специалист, исследователь, лаборант"> Научный специалист, исследователь, лаборант</li>
                        <li><input  onClick="addSpec('Наука, образование',this)" type="radio" name="specr" value="Психолог"> Психолог</li>
                        <li><input  onClick="addSpec('Наука, образование',this)" type="radio" name="specr" value="Учитель, преподаватель, педагог"> Учитель, преподаватель, педагог</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Продажи, обслуживание клиентов</span></h3>
                    <ul class="spec">
                        <li><input  onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Агент по недвижимости">Агент по недвижимости</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Аналитик">Аналитик</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Кассир-операционист">Кассир-операционист</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Коммерческий директор (CCO)">Коммерческий директор (CCO)</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Координатор отдела продаж">	Координатор отдела продаж</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Кредитный специалист">Кредитный специалист</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Менеджер по продажам, менеджер по работе с клиентами">Менеджер по продажам, менеджер по работе с клиентами</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Менеджер по работе с партнерами">Менеджер по работе с партнерами</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Оператор call-центра, специалист контактного центра">Оператор call-центра, специалист контактного центра</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Продавец-консультант, продавец-кассир">Продавец-консультант, продавец-кассир</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Руководитель отдела клиентского обслуживания">Руководитель отдела клиентского обслуживания</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Руководитель отдела продаж">Руководитель отдела продаж</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Специалист технической поддержки">Специалист технической поддержки</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Страховой агент">Страховой агент</li>
                        <li><input onClick="addSpec('Продажи, обслуживание клиентов',this)" type="radio" name="specr" value="Торговый представитель">Торговый представитель</li>

                    </ul>
                </div>
            
                <div class="box">
                    <h3><span class="expand">Производство, сервисное обслуживание</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)"  type="radio" name="specr" value="Инженер по качеству">Инженер по качеству</li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Инженер по охране труда и технике безопасности">Инженер по охране труда и технике безопасности</li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Инженер по эксплуатации">Инженер по эксплуатации</li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Инженер-конструктор, инженер-проектировщик">Инженер-конструктор, инженер-проектировщик</li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Инженер-технолог">Инженер-технолог</li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Машинист">Машинист </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Научный специалист, исследователь, лаборант">Научный специалист, исследователь, лаборант </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Начальник производства">Начальник производства </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Начальник смены, мастер участка">	Начальник смены, мастер участка </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Оператор производственной линии">	Оператор производственной линии </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Оператор станков с ЧПУ">Оператор станков с ЧПУ </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Сварщик">Сварщик </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Сервисный инженер, механик">Сервисный инженер, механик </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Слесарь">Слесарь </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Токарь, фрезеровщик, шлифовщик">Токарь, фрезеровщик, шлифовщик </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Швея, портной, закройщик">	Швея, портной, закройщик </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Электромонтажник">	Электромонтажник </li>
                        <li><input onClick="addSpec('Производство, сервисное обслуживание',this)" type="radio" name="specr" value="Энергетик">	Энергетик </li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Рабочий персонал</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Автослесарь, автомеханик">Автослесарь, автомеханик</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)"  type="radio" name="specr" value="Водитель">Водитель</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Грузчик">Грузчик</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Кладовщик">	Кладовщик</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Маляр, штукатур">	Маляр, штукатур</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Машинист">	Машинист</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Монтажник">	Монтажник</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Оператор производственной линии">	Оператор производственной линии</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Оператор станков с ЧПУ">Оператор станков с ЧПУ</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Разнорабочий">Разнорабочий</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Сварщик">Сварщик</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Сервисный инженер, механик">Сервисный инженер, механик</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Слесарь">Слесарь</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Токарь, фрезеровщик, шлифовщик">Токарь, фрезеровщик, шлифовщик</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Упаковщик, комплектовщик">Упаковщик, комплектовщик</li>
                        <li><input  onClick="addSpec('Рабочий персонал',this)" type="radio" name="specr" value="Электромонтажник">Электромонтажник</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Розничная торговля</span></h3>
                    <ul class="spec">
                        <li><input  onClick="addSpec('Розничная торговля',this)" type="radio" name="specr" value="Администратор магазина, администратор торгового зала">Администратор магазина, администратор торгового зала</li>
                        <li><input onClick="addSpec('Розничная торговля',this)"  type="radio" name="specr" value="Директор магазина, директор сети магазинов">Директор магазина, директор сети магазинов</li>
                        <li><input onClick="addSpec('Розничная торговля',this)"  type="radio" name="specr" value="Мерчандайзер">Мерчандайзер</li>
                        <li><input onClick="addSpec('Розничная торговля',this)" type="radio" name="specr" value="Продавец-консультант, продавец-кассир">Продавец-консультант, продавец-кассир</li>
                        <li><input onClick="addSpec('Розничная торговля',this)" type="radio" name="specr" value="Промоутер">Промоутер</li>
                        <li><input onClick="addSpec('Розничная торговля',this)" type="radio" name="specr" value="Супервайзер">Супервайзер</li>
                        <li><input onClick="addSpec('Розничная торговля',this)" type="radio" name="specr" value="Товаровед">	Товаровед</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Сельское хозяйство</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Сельское хозяйство',this)" type="radio" name="specr" value="Агроном">Агроном</li>
                        <li><input  onClick="addSpec('Сельское хозяйство',this)" type="radio" name="specr" value="Ветеринарный врач">	Ветеринарный врач</li>
                        <li><input  onClick="addSpec('Сельское хозяйство',this)" type="radio" name="specr" value="Зоотехник">	Зоотехник</li>
                        <li><input  onClick="addSpec('Сельское хозяйство',this)" type="radio" name="specr" value="Инженер-технолог">	Инженер-технолог</li>
                        <li><input  onClick="addSpec('Сельское хозяйство',this)" type="radio" name="specr" value="Машинист">	Машинист</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Спортивные клубы, фитнес, салоны красоты</span></h3>
                    <ul class="spec">
                        <li><input  onClick="addSpec('Спортивные клубы, фитнес, салоны красоты',this)" type="radio" name="specr" value="Администратор">Администратор</li>
                        <li><input  onClick="addSpec('Спортивные клубы, фитнес, салоны красоты',this)" type="radio" name="specr" value="Косметолог">Косметолог</li>
                        <li><input  onClick="addSpec('Спортивные клубы, фитнес, салоны красоты',this)" type="radio" name="specr" value="Массажист">Массажист</li>
                        <li><input  onClick="addSpec('Спортивные клубы, фитнес, салоны красоты',this)" type="radio" name="specr" value="Мастер ногтевого сервиса">Мастер ногтевого сервиса</li>
                        <li><input  onClick="addSpec('Спортивные клубы, фитнес, салоны красоты',this)" type="radio" name="specr" value="Менеджер по продажам, менеджер по работе с клиентами">Менеджер по продажам, менеджер по работе с клиентами</li>
                        <li><input  onClick="addSpec('Спортивные клубы, фитнес, салоны красоты',this)" type="radio" name="specr" value="Парикмахер">Парикмахер</li>
                        <li><input  onClick="addSpec('Спортивные клубы, фитнес, салоны красоты',this)" type="radio" name="specr" value="Фитнес-тренер, инструктор тренажерного зала">Фитнес-тренер, инструктор тренажерного зала</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Стратегия, инвестиции, консалтинг</span></h3>
                    <ul class="spec">
                        <li><input  onClick="addSpec('Стратегия, инвестиции, консалтинг',this)"  type="radio" name="specr" value="Аналитик">Аналитик</li>
                        <li><input onClick="addSpec('Стратегия, инвестиции, консалтинг',this)" type="radio" name="specr" value="Менеджер/консультант по стратегии">	Менеджер/консультант по стратегии</li>
                        <li><input onClick="addSpec('Стратегия, инвестиции, консалтинг',this)"type="radio" name="specr" value="Руководитель проектов">Руководитель проектов</li>
                        <li><input onClick="addSpec('Стратегия, инвестиции, консалтинг',this)"type="radio" name="specr" value="Финансовый аналитик, инвестиционный аналитик">Финансовый аналитик, инвестиционный аналитик</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Страхование</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Страхование',this)" type="radio" name="specr" value="Андеррайтер">Андеррайтер</li>
                        <li><input onClick="addSpec('Страхование',this)" type="radio" name="specr" value="Оценщик">Оценщик</li>
                        <li><input onClick="addSpec('Страхование',this)" type="radio" name="specr" value="Страховой агент">Страховой агент</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Строительство, недвижимость</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Строительство, недвижимость',this)"  type="radio" name="specr" value="Агент по недвижимости">Агент по недвижимости</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Архитектор">Архитектор</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Геодезист">Геодезист</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Главный инженер проекта">Главный инженер проекта</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Дизайнер, художник">Дизайнер, художник</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Инженер ПТО, инженер-сметчик">Инженер ПТО, инженер-сметчик</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Инженер по эксплуатации">Инженер по эксплуатации</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Маляр, штукатур">Маляр, штукатур</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Машинист">Машинист</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Монтажник">Монтажник</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Прораб, мастер СМР">Прораб, мастер СМР</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Разнорабочий">Разнорабочий</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Руководитель строительного проекта">Руководитель строительного проекта</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Сварщик">Сварщик</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Слесарь">Слесарь</li>
                        <li><input onClick="addSpec('Строительство, недвижимость',this)" type="radio" name="specr" value="Электромонтажник">	Электромонтажник</li>

                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Транспорт, логистика, перевозки</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Транспорт, логистика, перевозки',this)"  type="radio" name="specr" value="Водитель">Водитель</li>
                        <li><input  onClick="addSpec('Транспорт, логистика, перевозки',this)" type="radio" name="specr" value="Грузчик">Грузчик</li>
                        <li><input  onClick="addSpec('Транспорт, логистика, перевозки',this)" type="radio" name="specr" value="Диспетчер">	Диспетчер</li>
                        <li><input  onClick="addSpec('Транспорт, логистика, перевозки',this)" type="radio" name="specr" value="Кладовщик">	Кладовщик</li>
                        <li><input  onClick="addSpec('Транспорт, логистика, перевозки',this)" type="radio" name="specr" value="Курьер">Курьер</li>
                        <li><input  onClick="addSpec('Транспорт, логистика, перевозки',this)" type="radio" name="specr" value="Менеджер по логистике, менеджер по ВЭД">Менеджер по логистике, менеджер по ВЭД</li>
                        <li><input  onClick="addSpec('Транспорт, логистика, перевозки',this)" type="radio" name="specr" value="Начальник склада">Начальник склада</li>
                        <li><input  onClick="addSpec('Транспорт, логистика, перевозки',this)" type="radio" name="specr" value="Упаковщик, комплектовщик">Упаковщик, комплектовщик</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Туризм, гостиницы, рестораны</span></h3>
                    <ul class="spec">
                        <li><input  onClick="addSpec('Туризм, гостиницы, рестораны',this)" type="radio" name="specr" value="Администратор">Администратор</li>
                        <li><input onClick="addSpec('Туризм, гостиницы, рестораны',this)" type="radio" name="specr" value="Менеджер по туризму">Менеджер по туризму</li>
                        <li><input onClick="addSpec('Туризм, гостиницы, рестораны',this)" type="radio" name="specr" value="Менеджер ресторана">Менеджер ресторана</li>
                        <li><input onClick="addSpec('Туризм, гостиницы, рестораны',this)" type="radio" name="specr" value="Официант, бармен, бариста">Официант, бармен, бариста</li>
                        <li><input onClick="addSpec('Туризм, гостиницы, рестораны',this)" type="radio" name="specr" value="Повар, пекарь, кондитер">Повар, пекарь, кондитер</li>
                        <li><input onClick="addSpec('Туризм, гостиницы, рестораны',this)" type="radio" name="specr" value="Уборщица, уборщик">	Уборщица, уборщик</li>
                        <li><input onClick="addSpec('Туризм, гостиницы, рестораны',this)" type="radio" name="specr" value="Хостес">Хостес</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Управление персоналом, тренинги</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Управление персоналом, тренинги',this)" type="radio" name="specr" value="Бизнес-тренер">Бизнес-тренер</li>
                        <li><input onClick="addSpec('Управление персоналом, тренинги',this)" type="radio" name="specr" value="Директор по персоналу (HRD)">Директор по персоналу (HRD)</li>
                        <li><input onClick="addSpec('Управление персоналом, тренинги',this)" type="radio" name="specr" value="Менеджер по персоналу">Менеджер по персоналу</li>
                        <li><input onClick="addSpec('Управление персоналом, тренинги',this)" type="radio" name="specr" value="Специалист по кадрам">Специалист по кадрам</li>
                        <li><input onClick="addSpec('Управление персоналом, тренинги',this)" type="radio" name="specr" value="Специалист по подбору персонала">	Специалист по подбору персонала</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Финансы, бухгалтерия</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Аудитор">Аудитор</li>
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Бухгалтер">Бухгалтер</li>
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Казначей">Казначей</li>
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Финансовый аналитик, инвестиционный аналитик">Финансовый аналитик, инвестиционный аналитик</li>
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Финансовый директор (CFO)">Финансовый директор (CFO)</li>
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Финансовый контролер">Финансовый контролер</li>
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Финансовый менеджер">Финансовый менеджер</li>
                        <li><input onClick="addSpec('Финансы, бухгалтерия',this)" type="radio" name="specr" value="Экономист">Экономист</li>
                    </ul>
                </div>
            
                <div class="box">
                    <h3><span class="expand">Юристы</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Юристы',this)"  type="radio" name="specr" value="Юрисконсульт">Юрисконсульт</li>
                        <li><input onClick="addSpec('Юристы',this)" type="radio" name="specr" value="Юрист">Юрист</li>
                    </ul>
                </div>
                <div class="box">
                    <h3><span class="expand">Другое</span></h3>
                    <ul class="spec">
                        <li><input onClick="addSpec('Другое',this)"  type="radio" name="specr" value="Другое">Другое</li>
                    </ul>
                </div>
            </div>
            <div>
                <span style="position:relative;float:right" class="popup-close btn btn-success">Выбрать</span>
            </div>
	</div>

</div>
