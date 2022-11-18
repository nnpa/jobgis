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
        window.location.href = "http://" + document.domain + "/search/company/?city=" + val;
}   
</script>

<h3>Поиск компаний <?php echo $city;?></h3>
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
    <b>Город</b>
<div class="frmSearch">
                    <input  id="search-box" id="cityInput" value="<?php echo $city;?>" type="text" name="city">
                    </div>
                    <div id="suggesstion-box"></div>
<div>
    <?php foreach($category as $cat):?>
         <a style="float:left;" href="/search/company?city=<?php echo $city;?>&category=<?php echo $cat;?>"><?php echo $cat;?></a><br>
    <?php    endforeach;?>
</div>
                    <hr>       
<div>
    <?php foreach($result as $row):?>
    <a target="_blank" href="/company/view?id=<?php echo $row["id"];?>" ><?php echo $row["name"];?></a><br>
    <?php    endforeach;?>
</div>
<div>
    <nav aria-label="...">
        <ul class="pagination">

            <?php for($i=1;$i <= $pages;$i++):?>
            <li class="page-item <?php echo ($i == $page)?'active':'';?>">

            <a class="page-link"  href="<?php echo $url."&page=".$i;?>"><?php echo $i;?></a> 
            </li>
            <?php endfor;?>
        </ul>

    </nav>
</div>
                    
