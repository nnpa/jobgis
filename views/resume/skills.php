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
        if(valueArray[i].trim() != element.trim()){
            newArr[i] = valueArray[i];
        }
    }
    var valString = newArr.join(",");
    $("#skills-input").val(valString);
    
    $(obj).remove();
}
</script>
<form method="POST" >
    <h3>Ключевые навыки</h3>
    <div id="skills" style="float:left">
    <?php 
        $skillsArr = explode(",",$resume->skills);
    ?>
    <?php foreach($skillsArr as $skill):?>
        <?php if($skill != ""):?>
            <div onClick='deleteSkill(this)' style='margin:4px;border-radius:5px;background-color:edeff0;padding:4px;border:1px solid gray;min-width:10px;float:left;'><?php echo $skill?> <span style='color:blue;cursor: pointer'>x</span>
            </div>
        <?php endif;?>
    <?php endforeach;?>
    </div> 
    <input type="hidden" value="<?php echo $resume->skills;?>"name="skills" id="skills-input">
    <div>  &nbsp;</div>
    <br>

    <div class="frmSearch" style="float:left">
        <input  id="search-box-skills"  type="text">
    </div>
    <div id="suggesstion-box-skills"></div><br>
    <div>  &nbsp;</div>
    <input type="submit" value="Сохранить" class="btn btn-success">
</form>