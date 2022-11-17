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
       $("#rss").html('<a target="_blank" href="'+ "https://jobgis.ru/site/rsscity?city=" + val +'">'  + "https://jobgis.ru/site/rsscity?city=" + val + '</a>');
}
</script>
<h5>RSS</h5>
<b>Город</b><br>
    <div class="frmSearch">
        <input  id="search-box"  id="cityInput" type="text"  name="city">
    </div>
    <div id="suggesstion-box"></div><br>
    <span id="rss"></span>
    <a target="_blank" href="https://jpbgis.ru/site/rss">https://jobgis.ru/site/rss</a>