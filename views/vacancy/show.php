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
<div style="padding-left: 50px;">
<h3><?php echo $vacancy->name;?></h3>
<span class="vacancy_compensation">
от <?php echo $vacancy->costfrom;?> до <?php echo $vacancy->costto;?> <?php echo $vacancy->cash;?> <?php echo $vacancy->cashtype;?> <br>
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
<h5>Ключевые навыки</h5>
<div>
    <?php 
        $skillsArr = explode(",",$vacancy->skills);
    ?>
    <?php foreach($skillsArr as $skill):?>
        <?php if($skill != ""):?>
            <div style='margin:4px;border-radius:5px;background-color:edeff0;padding:4px;border:1px solid gray;min-width:10px;float:left;'>
                <?php echo $skill?>
            </div>
        <?php endif;?>
    <?php endforeach;?>
</div><br>
<div>  &nbsp;</div>

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
                <?php if($vacancy->user->firm_id == 0):?>
                <div id="responce">
                    <select id="resume_id" class="form-select" style="width:250px">
                        <?php foreach($resume as $r):?>
                            <option value="<?php echo $r->id?>"><?php echo $r->vacancy?></option>
                        <?php endforeach;?>
                    </select><br>
                    <a hre="#" class="btn btn-success" onClick="response('<?php echo $vacancy->id;?>')">Откликнуться</a>
                </div>
                <?php endif;?>
            <?php endif;?>
    <?php else:?>
        Вы уже откликнулись
    <?php endif;?>
<?php else:?>

<?php endif; ?>
</div>