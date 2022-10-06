<script type="text/javascript">
    
        function firmChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val();
            
            
            $.get( "/resume/changefirm?id=" + id +"&val=" + val, function( data ) {
                
            });
        }
        
        function vacancyChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val();
            
            
            $.get( "/resume/changevacancy?id=" + id +"&val=" + val, function( data ) {
                
            });
        }
        
        function siteChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val();
            
            
            $.get( "/resume/changesite?id=" + id +"&val=" + val, function( data ) {
                
            });
        }
        
        function descriptionChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val().replace(/\n/g, "<br />");
            
            $.get( "/resume/changedescription?id=" + id +"&val=" + val, function( data ) {
                
            });
        }
        
        function monthStartChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val();

            $.get( "/resume/changemonthstart?id=" + id +"&month=" + val, function( data ) {
                
            });
        }
        
        function yearStartChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val();
            $.get( "/resume/changeyearstart?id=" + id +"&val=" + val, function( data ) {
                
            });
        }
        
        function yearEndChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val();
            $.get( "/resume/changeyearend?id=" + id +"&val=" + val, function( data ) {
                
            });
        }
        function monthEndChange(obj){
            var id = $(obj).attr( "resume_id" );
            var val = $( obj ).val();
            $.get( "/resume/changemonthend?id=" + id +"&month=" + val, function( data ) {
                
            });
        }

        function deleteExp(id){
            $.get( "/resume/expdelete?id=" + id, function( data ) {
                $("#exp-" + id).remove();
            });
            
        }
        function addExp(id){
            $.get( "/resume/expadd?id=" + id, function( data ) {

                var exp = '<div id="exp-' + data +'"> <span style="color:blue;float:right" onClick="deleteExp(' + "'" +data+"'" +')">x</span><br>Начало работы <select onChange="monthStartChange(this)" resume_id="'+ data + '" name="strart_month">' +
                        '<option value="Январь">Январь</option>' +
                        '<option value="Февраль">Февраль</option>' +
                        '<option value="Март">Март</option>' +
                        '<option value="Апрель">Апрель</option>' +
                        '<option value="Май">Май</option>' +
                        '<option value="Июнь">Июнь</option>' +
                        '<option value="Июль">Июль</option>' +
                        '<option value="Август">Август</option>' +
                        '<option value="Сентябрь">Сентябрь</option>' +
                        '<option value="Октябрь">Октябрь</option>' +
                        '<option value="Ноябрь">Ноябрь</option>' +
                        '<option value="Декабрь">Декабрь</option>' +
                    '</select>' +
                    '<input onblur="yearStartChange(this)" type="text" resume_id="'+ data + '"  name="start_year"><br>' +

                    'Окончание <select onChange="monthEndChange(this)" resume_id="'+ data + '" name="strart_month">'+
                        '<option value="Январь">Январь</option>' +
                        '<option value="Февраль">Февраль</option>' +
                        '<option value="Март">Март</option>' +
                        '<option value="Апрель">Апрель</option>' +
                        '<option value="Май">Май</option>' +
                        '<option value="Июнь">Июнь</option>' +
                        '<option value="Июль">Июль</option>' +
                        '<option value="Август">Август</option>' +
                        '<option value="Сентябрь">Сентябрь</option>' +
                        '<option value="Октябрь">Октябрь</option>' +
                        '<option value="Ноябрь">Ноябрь</option>' +
                        '<option value="Декабрь">Декабрь</option>' +
                   '</select>' +
                    '<input onblur="yearEndChange(this)" type="text" resume_id="'+ data + '"  name="start_year"><br>'+

                    'Организация <input onblur="firmChange(this)" type="text" name="firm" resume_id="'+ data + '"><br>'+
                    'Сайт  <input  onblur="siteChange(this)" type="text" name="site" resume_id="'+ data + '"><br>'+
                    'Должность  <input onblur="vacancyChange(this)" type="text" name="vacancy" resume_id="'+ data + '"><br>'+
                    'Обязанности  <textarea onblur="descriptionChange(this)" name="vacancy" resume_id="'+ data + '"></textarea></div>';


                    $("#exp").append(exp );
            });
        }

</script>
<h3>Опыт работы</h3>
<a href="#" onClick="addExp('<?php echo $resume->id?>')">Добавить</a>
<div id="exp">
    <?php
        $monthArr = [
            "1" => "Январь",
            "2" => "Февраль",
            "3" => "Март",
            "4" => "Апрель",
            "5" => "Май",
            "6" => "Июнь",
            "7" => "Июль",
            "8" => "Август",
            "9" => "Сентябрь",
            "10" => "Октябрь",
            "11" => "Ноябрь",
            "12" => "Декабрь",

        ];
    ?>
    <?php foreach($resumeExp as $exp):?>

                    <div id="exp-<?php echo $exp->id;?>"> <span style="color:blue;float:right" onClick="deleteExp('<?php echo $exp->id;?>')">x</span><br>Начало работы <select onChange="monthStartChange(this)" resume_id="<?php echo $exp->id;?>" name="strart_month">
                        <?php 
                            $date = explode("." ,$exp->start_date);
                            $month = $date[0];
                            if($month == " "){
                                $month = "1";
                            }
                            $year = $date[1];
                        ?>
                        <?php foreach($monthArr as $key => $value):?>
                            <option value="<?php echo $value;?>" <?php echo ($key == $month)?'selected':''?>><?php echo $value;?></option>
                        <?php endforeach;?> 
                    </select>
                    <input onblur="yearStartChange(this)" type="text" resume_id="<?php echo $exp->id;?>" value="<?php echo $year;?>"  name="start_year"><br>

                    Окончание <select onChange="monthEndChange(this)" resume_id="<?php echo $exp->id;?>" name="strart_month">
                        <?php 
                            $date = explode("." ,$exp->end_date);
                            $month = $date[0];
                            if($month == " "){
                                $month = "1";
                            }
                           
                            $year = $date[1];
                        ?> 
                        
                        <?php foreach($monthArr as $key => $value):?>
                            <option value="<?php echo $value;?>" <?php echo ($key == $month)?'selected':''?>><?php echo $value;?></option>
                        <?php endforeach;?> 
                   </select>
                    <input onblur="yearEndChange(this)" type="text" resume_id="<?php echo $exp->id;?>" value="<?php echo $year;?>" name="start_year"><br>
                    
                    Организация <input  onblur="firmChange(this)" value="<?php echo $exp->firm;?>" type="text" name="firm" resume_id="<?php echo $exp->id;?>"><br>
                    Сайт <input onblur="siteChange(this)" value="<?php echo $exp->site;?>" type="text" name="site" resume_id="<?php echo $exp->id;?>"><br>
                    Должность <input onblur="vacancyChange(this)" value="<?php echo $exp->vacancy;?>" type="text" name="vacancy" resume_id="<?php echo $exp->id;?>"><br>
                    Обязанности <textarea style="white-space: pre-wrap;" onblur="descriptionChange(this)" name="vacancy" resume_id="<?php echo $exp->id;?>"><?php echo preg_replace('/\<br(\s*)?\/?\>/i', "\n", $exp->description);?></textarea></div>
    <?php endforeach;?>
</div>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-success">Сохранить</a>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-primary">Отмена</a>
