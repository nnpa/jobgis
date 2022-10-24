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
        <?php echo $message->message;?>
    </div>
</div>
<?php endforeach;?>
<form method="POST">
    <b>Введите сообщение</b><br>
    <textarea name="message" style="width:450px;height:100px"></textarea><br>
    <input type="submit" value="Отправить" class="btn btn-success">
</form>