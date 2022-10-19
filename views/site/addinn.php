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
        $("#inn").mask("999999999999");

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

<?php
    $category = [
'Автомобильный бизнес',
'Гостиницы, рестораны, общепит, кейтеринг',
'Государственные организации',
'Добывающая отрасль',
'ЖКХ',
'Информационные технологии, системная интеграция, интернет',
'Искусство, культура',
'Лесная промышленность, деревообработка',
'Медицина, фармацевтика, аптеки',
'Металлургия, металлообработка',
'Нефть и газ',
'Образовательные учреждения',
'Общественная деятельность, партии, благотворительность, НКО',
'Перевозки, логистика, склад, ВЭД',
'Продукты питания',
'Промышленное оборудование, техника, станки и комплектующие',
'Розничная торговля',
'СМИ, маркетинг, реклама, BTL, PR, дизайн, продюсирование',
'Сельское хозяйство',
'Строительство, недвижимость, эксплуатация, проектирование',
'Телекоммуникации, связь',
'Товары народного потребления (непищевые)',
'Тяжелое машиностроение',
'Управление многопрофильными активами',
'Услуги для бизнеса',
'Услуги для населения',
'Финансовый сектор',
'Химическое производство, удобрения',
'Электроника, приборостроение, бытовая техника, компьютеры и оргтехника',
'Энергетика'
    ];
?>

<h3>Заполните ИНН компании</h3>
<form method="POST">
    <b>ИНН *</b> <input id="inn" type="text" name="inn" ><br>
    <b>Индустрия *</b> 
    <select name="category">
        <?php foreach($category as $c):?>
        <option value="<?php echo $c;?>"><?php echo $c;?></option>
        <?php endforeach;?>
    </select><br>
    <b>Город *</b>
<div class="frmSearch">
                    <input  id="search-box" id="cityInput" type="text" name="city">
                    </div>
                    <div id="suggesstion-box"></div>
    <input class=" btn btn-success" type="submit" value="Сохранить">
        Поля помеченные * обязательны к заполнению

</form>

