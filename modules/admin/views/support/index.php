<?php
use app\models\Support;

?>
<h5>Диалоги</h5>

<?php foreach($messages as $message):?>
<div style="border:1px solid gray;border-radius: 5px">
    <?php $cnt = Support::find()->where(["from_id" => $message->from_id,"view" => 0])->count();?>
    
    <a href="/admin/support/messages?id=<?php echo $message->from_id;?>">
        Диалог <?php echo $message->user->name;?>
               <?php echo $message->user->surname;?>
               (<?php echo $cnt;?>)
        
    </a>
    
</div>
<?php endforeach; ?>
