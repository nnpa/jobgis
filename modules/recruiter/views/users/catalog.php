
<script>
   $(document).ready(function() {
 
	$('.jqte-test').jqte();
	
	// settings of status

   });
</script>

<h5>Информация для каталога</h5>
Для публикации в каталоге заполните информацию о рекрутере
<form method="POST">
    <textarea  class="jqte-test" style="width:500px;height:100px" name="info"><?php echo  $user->recruiter_info;?></textarea>
    <input type="submit" value="Сохранить" class="btn btn-success">
</form>