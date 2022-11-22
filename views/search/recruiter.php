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
        window.location.href = "http://" + document.domain + "/search/recruiter/?city=" + val;
}   
</script>
<a href="/search/top?top=week">Топ за неделю</a>
<a href="/search/top?top=month">Топ за месяц</a>
<a href="/search/top?top=year">Топ за год</a>

<h3>Рекрутеры</h3>
    <b>Город</b>
<div class="frmSearch">
                    <input  id="search-box" id="cityInput" value="<?php echo $city;?>" type="text" name="city">
                    </div>
                    <div id="suggesstion-box"></div>
                    <hr>       
<div>
    <?php foreach($result as $row):?>
    <a target="_blank" href="/site/recruiterview?id=<?php echo $row["id"];?>" ><?php echo $row["name"];?> <?php echo $row["surname"];?></a><br>
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
                    
