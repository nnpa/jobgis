<?php 
    use app\models\Resume;
    use app\models\Response;

?>
<script type="text/javascript">
 function getContacts(id){
    $.ajax({
        type: "GET",
        url: "/vacancy/contacts",
        data: 'id=' + id,
        success: function(data) {
            $("#contacts").html(data);
        }
    });
 }
</script>
<script>
    $( document ).ready(function() {

document.getElementById('vk_share_button').innerHTML = VK.Share.button({
      url: '<?php echo 'https://jobgis.ru/vacancy/show?id=' . $vacancy->id; ?>',
      title: '<?php echo $vacancy->name;?>',
      noparse: true
    }, {type: 'custom', text: '<img src="http://vk.com/images/vk32.png" />'});

});

function changeSort(obj,id){
    $.get( "/vacancy/changesort?id=" + id +"&sort=" + obj.value, function( data ) {
            
    });
}
</script>
<?php
    $roleArr = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
    if(!empty($roleArr)){
        
        foreach($roleArr as $roleObj){
            if($roleObj->name == "admin"){
                echo "Сортировка <input type='text' value='".$vacancy->rsort."' onblur='changeSort(this,".$vacancy->id.")' id='rsort'>";
            }
        }
    }
?>
<div>
    <div style="width:50px;float:left">
        <span id="vk_share_button"> </span>
        
    </div>
    <div style="float:left;padding-left: 50px">
        <h3><?php echo $vacancy->name;?></h3>
        <span class="vacancy_compensation">
            <?php if((bool)$vacancy->costfrom):?>
                от <?php echo $vacancy->costfrom;?> 
           <?php endif;?>

           <?php if((bool)$vacancy->costto):?>
                до <?php echo $vacancy->costto;?>
           <?php endif;?>

         <?php if($vacancy->costto != 0 OR $vacancy->costfrom != 0):?>
            <?php echo $vacancy->cash;?> <?php echo $vacancy->cashtype;?> <br>
         <?php endif;?>
        </span>
        Требуемый опыт работы: <?php echo $vacancy->exp;?><br>
        <?php echo $vacancy->employment;?><br>
        <?php if(is_object($vacancy->user)):?>
            <?php echo $vacancy->user->company;?><br>
        <?php endif;?>
        <?php echo $vacancy->city;?><br>

        <div>
            <?php echo $vacancy->description;?><br>

        </div>


        <?php if(!Yii::$app->user->isGuest):?>
            <div id="contacts" >
                <a class="btn btn-primary" href="#" onClick="getContacts('<?php echo $vacancy->id;?>')">Контакты</a>
            </div>
        <?php else:?>
            <a href="/site/registercandidate">Зарегириструйтесь</a> для просмотра контактов
        <?php endif; ?>


        <script type="text/javascript">
            function response(id){
                resume_id = $("#resume_id").val();
                $.get( "/response/response?resume_id=" + resume_id + "&vacancy_id=" +id, function( data ) {
                    $("#responce").html("Вы откликнулись");
                });

            }
        </script>

        <?php if(!Yii::$app->user->isGuest):?>
            <?php
                $resume = Resume::find()->where(["user_id" => Yii::$app->user->id])->all();
            ?>

            <?php
                $resumes =[];
                foreach($resume as $r){
                    $resumes[] = $r->id;
                }


                $response = Response::find()->where(["resume_id" => $resumes, "vacancy_id" => $vacancy->id])->all();
            ?>


            <?php if(empty($response)):?>
                <?php if(!is_null($resume) && is_object($vacancy->user)):?>
                    <?php if(Yii::$app->user->identity->firm_id == 0):?>
                    <div id="responce">
                        <?php if(!empty($resume)):?>
                        <select id="resume_id" class="form-select" style="width:250px">
                            <?php foreach($resume as $r):?>
                                <option value="<?php echo $r->id?>"><?php echo $r->vacancy?></option>
                            <?php endforeach;?>
                        </select><br>
                        <a hre="#" class="btn btn-success" onClick="response('<?php echo $vacancy->id;?>')">Откликнуться</a>
                        <?php else:?>
                            Что бы откликнуться создайте резюме
                        <?php endif;?>
                    </div>
                    <?php endif;?>
                <?php endif;?>
            <?php else:?>
                Вы уже откликнулись
            <?php endif;?>
        <?php else:?>

        <?php endif; ?>
    </div>
</div>