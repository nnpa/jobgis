<script type="text/javascript">
    function addEdu(id){
         $.get( "/resume/addedu?id=" + id, function( data ) {
             var edu = '<div id="edu-' + data +'"> <span style="color:blue;float:right" onClick="deleteEdu(' + "'" +data+"'" +')">x</span><br>'+
             'Уровень ' +
             '<select onChange="typeEduChange(this)" edu_id="'+ data + '" >' +
                '<option value="Среднее специальное">Среднее специальное</option>' +     
                '<option value="Неоконченное высшее">Неоконченное высшее</option>' +        
                '<option value="Высшее">Высшее</option>' +        
                '<option value="Бакалавр">Бакалавр</option>' +        
                '<option value="Магистр">Магистр</option>' +        
                '<option value="Кандидат наук">Кандидат наук</option>' +        
                '<option value="Доктор наук">Доктор наук</option>' +        
             '</select><br>'+
             'Учебное заведение '+
             '<input type="text" onblur="changeUniversity(this)"  edu_id="'+ data + '"><br>'+
             'Факультет '+
             '<input type="text" onblur="changeFack(this)"  edu_id="'+ data + '"><br>'+
             'Специализация ' +
             '<input type="text" onblur="changeSpec(this)"  edu_id="'+ data + '"><br>'+
             'Год окончания ' +
             '<input type="text" onblur="changeYear(this)"  edu_id="'+ data + '"></div>';
            $("#edu").append(edu);
        });
    }
    
    function deleteEdu(id){
        $.get( "/resume/edudelete?id=" + id, function( data ) {
            $("#edu-" + id).remove();
        });
            
    }
    
    function typeEduChange(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/educhangetype?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
    
    function changeUniversity(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/educhangeuniversity?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
    
    function changeFack(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/educhangefack?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
    
    function changeSpec(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/educhangespec?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
    
    function changeYear(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/educhangeyear?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
</script>

<a href="#" onClick="addEdu('<?php echo $resume->id;?>')">Добавить место</a>
<div id="edu" >
    <?php 
        $types = [
            "Среднее специальное",
            "Неоконченное высшее",
            "Высшее",
            "Бакалавр",
            "Магистр",
            "Кандидат наук",
            "Доктор наук"
        ];
        
    ?>
    <?php foreach($resumeEdu as $edu):?>
        <div id="edu-<?php echo $edu->id;?>"> <span style="color:blue;float:right" onClick="deleteEdu('<?php echo $edu->id;?>')">x</span>
            Уровень 
            <select onChange="typeEduChange(this)" edu_id="<?php echo $edu->id;?>" >
                <?php foreach($types as $type):?>
                    <option value="<?php echo $type;?>" <?php echo ($type == $edu->edu_type)?'selected':'';?>><?php echo $type;?></option>
                <?php endforeach;?>
            </select><br>
            Учебное заведение 
            <input value="<?php echo $edu->univercity;?>" type="text" onblur="changeUniversity(this)"  edu_id="<?php echo $edu->id;?>"><br>
            Факультет 
            <input value="<?php echo $edu->fack;?>" type="text" onblur="changeFack(this)"   edu_id="<?php echo $edu->id;?>"><br>
            Специализация 
            <input value="<?php echo $edu->spec;?>" type="text" onblur="changeSpec(this)"   edu_id="<?php echo $edu->id;?>"><br>
            Год окончания
            <input value="<?php echo $edu->year ;?>"  type="text" onblur="changeYear(this)"  edu_id="<?php echo $edu->id;?>"><br>
        </div>
    <?php endforeach;?>
</div>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-success">Сохранить</a>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-primary">Отмена</a>
