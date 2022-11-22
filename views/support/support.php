<script>
   $(document).ready(function() {
 
	$('textarea').jqte();
	
	// settings of status

   });
</script>
<h3>Напишите обращение в тех поддержку</h3>

<?php foreach($messages as $message):?>
<div>
    <div style="margin:5px;border:1px solid gray;width:450px;border-radius: 5px;padding:5px;">
        <small>
            <?php if($message->from_id == 0):?>
                <b>admin</b>
            <?php else:?>
                <b>Вы</b>
            <?php endif;?>
        </small>
        <hr>
        <?php echo $message->message;?><br>
        <?php if($message->screen != ''):?>
            <img src="/img/<?php echo $message->screen;?>">
        <?php endif;?>
    </div>
</div>
<?php endforeach;?>
<form method="POST" enctype="multipart/form-data">
    <b>Введите сообщение</b><br>
    <textarea name="message" style="width:450px;height:100px"></textarea><br>
    <b>Прикрепить файл</b>
    <input type="file" name="image" accept=".jpg,.jpeg"><br>
    <br>
    <input type="submit" value="Отправить" class="btn btn-success">
</form>