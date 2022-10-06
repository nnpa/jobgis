<script type="text/javascript">
   function addEdu(id){
        $.get( "/resume/addaddedu?id=" + id, function( data ) {
            var edu = 'Учебное заведение' +
                      '<input type="text" onblur="chageUniversity(this)" edu_id="' + data +'"><br>' +
                      'Проводившая организация' +
                      '<input type="text" onblur="chageFirm(this)" edu_id="' + data +'"><br>' +
                      'Специализация' +
                      '<input type="text" onblur="chageSpec(this)" edu_id="' + data +'"><br>' +
                      'Год окончания' +
                      '<input type="text" onblur="chageYear(this)" edu_id="' + data +'"><br>';

            $("#edu").append(edu);
        });
   }
   
    function chageUniversity(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/addeduchangeuniversity?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
    
    function chageFirm(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/addeduchangefirm?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
   
    function chageSpec(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/addeduchangespec?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
    
    function chageYear(obj){
        var id = $(obj).attr( "edu_id" );
        var val = $( obj ).val();
        $.get( "/resume/addeduchangeyear?id=" + id +"&val=" + val, function( data ) {
            
        });
    }
</script>

<a onClick="addEdu('<?php echo $resume->id;?>')" href="#" >Добавить</a>
<div id="edu">
    <?php foreach($resumeEdu as $edu):?>
        Учебное заведение
        <input value="<?php echo $edu->university;?>" type="text" onblur="chageUniversity(this)" edu_id="<?php echo $edu->id;?>"><br>
        Проводившая организация
        <input value="<?php echo $edu->firm;?>" type="text" onblur="chageFirm(this)" edu_id="<?php echo $edu->id;?>"><br>
        Специализация
        <input value="<?php echo $edu->spec;?>" type="text" onblur="chageSpec(this)" edu_id="<?php echo $edu->id;?>"><br>
        Год окончания
        <input value="<?php echo $edu->spec;?>" type="text" onblur="chageYear(this)" edu_id="<?php echo $edu->id;?>"><br>

    <?php endforeach;?>
</div>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-success">Сохранить</a>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-primary">Отмена</a>
