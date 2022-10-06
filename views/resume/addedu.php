<script type="text/javascript">
   function addEdu(id){
        $.get( "/resume/addaddedu?id=" + id, function( data ) {
            var edu = '<div style="margin:10px;border:1px solid black;padding:10px;border-radius: 5px;width: 600px;" id="edu-' + data +'"> <span style="cursor:pointer;color:blue;float:right" onClick="deleteEdu(' + "'" +data+"'" +')">x</span><br>'
                      'Учебное заведение' +
                      '<input type="text" onblur="chageUniversity(this)" edu_id="' + data +'"><br>' +
                      'Проводившая организация' +
                      '<input type="text" onblur="chageFirm(this)" edu_id="' + data +'"><br>' +
                      'Специализация' +
                      '<input type="text" onblur="chageSpec(this)" edu_id="' + data +'"><br>' +
                      'Год окончания' +
                      '<input type="text" onblur="chageYear(this)" edu_id="' + data +'"></div>';


            $("#edu").append(edu);
        });
   }
   
    function deleteEdu(id){
        $.get( "/resume/eduadddelete?id=" + id, function( data ) {
            $("#edu-" + id).remove();
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
<div id="edu" >
    <?php foreach($resumeEdu as $edu):?>
    <div style="margin:10px;border:1px solid black;padding:10px;border-radius: 5px;width: 600px;" id="edu-<?php echo $edu->id?>"> <span style="cursor:pointer;color:blue;float:right" onClick="deleteEdu('<?php echo $edu->id?>')">x</span><br>
        <b>Учебное заведение</b>
        <input value="<?php echo $edu->university;?>" type="text" onblur="chageUniversity(this)" edu_id="<?php echo $edu->id;?>"><br>
        <b>Проводившая организация</b>
        <input value="<?php echo $edu->firm;?>" type="text" onblur="chageFirm(this)" edu_id="<?php echo $edu->id;?>"><br>
        <b>Специализация</b>
        <input value="<?php echo $edu->spec;?>" type="text" onblur="chageSpec(this)" edu_id="<?php echo $edu->id;?>"><br>
        <b>Год окончания</b>
        <input value="<?php echo $edu->spec;?>" type="text" onblur="chageYear(this)" edu_id="<?php echo $edu->id;?>"><br>
    </div>
    <?php endforeach;?>
</div>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-success">Сохранить</a>
<a href="/resume/edit?id=<?php echo $resume->id?>" class="btn btn-primary">Отмена</a>
