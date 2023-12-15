<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="">Plant: Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_common as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['Plantvigur']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Plantvigur<?php echo $key; ?>" name="Plantvigur" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Plantvigur<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Plantvigur']!=''){ echo $error['Plantvigur']; } ?></span>

</div>

<div class="form-group <?php if($error['Uniformity']!=''){ echo 'has-error'; } ?>" id="InputUniformity">

  <label for="" class="">Plant: Uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Uniformity_common as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Uniformity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Uniformity<?php echo $key; ?>" name="Uniformity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Uniformity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Uniformity']!=''){ echo $error['Uniformity']; } ?></span>

</div>



<div class="form-group <?php if($error['Plantstructure']!=''){ echo 'has-error'; } ?>" id="InputPlantstructure">

  <label for="" class="">Plant: Structure</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantstructure_common as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Plantstructure']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Plantstructure<?php echo $key; ?>" name="Plantstructure" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Plantstructure<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Plantstructure']!=''){ echo $error['Plantstructure']; } ?></span>

</div>



<div class="form-group <?php if($error['Fruitshapeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitshapeuniformity">

  <label for="" class="">Fruit shape uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitshapeuniformity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitshapeuniformity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitshapeuniformity<?php echo $key; ?>" name="Fruitshapeuniformity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitshapeuniformity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitshapeuniformity']!=''){ echo $error['Fruitshapeuniformity']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">

  <label for="" class="">Fruit size uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsizeuniformity_common as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitsizeuniformity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitsizeuniformity<?php echo $key; ?>" name="Fruitsizeuniformity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitsizeuniformity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitsizeuniformity']!=''){ echo $error['Fruitsizeuniformity']; } ?></span>

</div>

<div class="form-group <?php if($error['Averagewieght']!=''){ echo 'has-error'; } ?>" id="InputAveragewieght">

  <label for="" class="">Average wieght In gram</label>

  <input type="text" class="form-control" id="Averagewieght" name="Averagewieght" placeholder="Average wieght In gram" value="<?php echo $get_single_evaluation['Averagewieght']; ?>">

  <span class="help-block"><?php if($error['Averagewieght']!=''){ echo $error['Averagewieght']; } ?></span>

</div>

<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="">Firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Firmness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Firmness<?php echo $key; ?>" name="Firmness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Firmness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Firmness']!=''){ echo $error['Firmness']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitquality']!=''){ echo 'has-error'; } ?>" id="InputFruitquality">

  <label for="" class="">Fruit quality</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitquality as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitquality']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitquality<?php echo $key; ?>" name="Fruitquality" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitquality<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitquality']!=''){ echo $error['Fruitquality']; } ?></span>

</div>

<div class="form-group <?php if($error['Friutlength']!=''){ echo 'has-error'; } ?>" id="InputFriutlength">

  <label for="" class="">Fruit: length (cm)</label>

  <input type="text" class="form-control" id="Friutlength" name="Friutlength" placeholder="Friut width" value="<?php echo $get_single_evaluation['Friutlength']; ?>">

  <span class="help-block"><?php if($error['Friutlength']!=''){ echo $error['Friutlength']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitdiameter']!=''){ echo 'has-error'; } ?>" id="InputFruitdiameter">

  <label for="" class="">Fruit: Diameter (cm)</label>

  <input type="text" class="form-control" id="Fruitdiameter" name="Fruitdiameter" placeholder="Friut width" value="<?php echo $get_single_evaluation['Fruitdiameter']; ?>">

  <span class="help-block"><?php if($error['Fruitdiameter']!=''){ echo $error['Fruitdiameter']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitcolour']!=''){ echo 'has-error'; } ?>" id="InputFruitcolour">

  <label for="" class="">Fruit colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitcolour as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['Fruitcolour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitcolour<?php echo $key; ?>" name="Fruitcolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitcolour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitcolour']!=''){ echo $error['Fruitcolour']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitoverallquality']!=''){ echo 'has-error'; } ?>" id="InputFruitoverallquality">

  <label for="" class="">Fruit: overall quality</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitoverallquality as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitoverallquality']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitoverallquality<?php echo $key; ?>" name="Fruitoverallquality" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitoverallquality<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitoverallquality']!=''){ echo $error['Fruitoverallquality']; } ?></span>

</div>

<div class="form-group <?php if($error['DiseaseTolerance']!=''){ echo 'has-error'; } ?>" id="InputDiseaseTolerance">

  <label for="" class="">Disease Tolerance</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($DiseaseTolerance as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['DiseaseTolerance']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="DiseaseTolerance<?php echo $key; ?>" name="DiseaseTolerance" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="DiseaseTolerance<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['DiseaseTolerance']!=''){ echo $error['DiseaseTolerance']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsettingunderlowtemperature']!=''){ echo 'has-error'; } ?>" id="InputFruitsettingunderlowtemperature">

  <label for="" class="">Fruit setting under low temperature</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsettingunderlowtemperature as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitsettingunderlowtemperature']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitsettingunderlowtemperature<?php echo $key; ?>" name="Fruitsettingunderlowtemperature" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitsettingunderlowtemperature<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitsettingunderlowtemperature']!=''){ echo $error['Fruitsettingunderlowtemperature']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsettingunderhightemperature']!=''){ echo 'has-error'; } ?>" id="InputFruitsettingunderhightemperature">

  <label for="" class="">Fruit setting under high temperature</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsettingunderhightemperature as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitsettingunderhightemperature']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitsettingunderhightemperature<?php echo $key; ?>" name="Fruitsettingunderhightemperature" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitsettingunderhightemperature<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitsettingunderhightemperature']!=''){ echo $error['Fruitsettingunderhightemperature']; } ?></span>

</div>

<div class="form-group <?php if($error['Fieldstandingability']!=''){ echo 'has-error'; } ?>" id="InputFieldstandingability">

  <label for="" class="">Field standing ability</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fieldstandingability as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fieldstandingability']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fieldstandingability<?php echo $key; ?>" name="Fieldstandingability" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fieldstandingability<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fieldstandingability']!=''){ echo $error['Fieldstandingability']; } ?></span>

</div>

<div class="form-group <?php if($error['Yieldcontinuity']!=''){ echo 'has-error'; } ?>" id="InputYieldcontinuity">

  <label for="" class="">Yield: yield continuity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Yieldcontinuity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Yieldcontinuity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Yieldcontinuity<?php echo $key; ?>" name="Yieldcontinuity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Yieldcontinuity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Yieldcontinuity']!=''){ echo $error['Yieldcontinuity']; } ?></span>

</div>

<div class="form-group <?php if($error['VisualYield']!=''){ echo 'has-error'; } ?>" id="InputVisualYield">

  <label for="" class="">Yield: visual yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($VisualYield_common as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['VisualYield']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="VisualYield<?php echo $key; ?>" name="VisualYield" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="VisualYield<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['VisualYield']!=''){ echo $error['VisualYield']; } ?></span>

</div> 

<div class="form-group <?php if($error['Rating']!=''){ echo 'has-error'; } ?>" id="InputRating">

  <label for="" class="">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_turnip as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['Rating']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Rating<?php echo $key; ?>" name="Rating" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Rating<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Rating']!=''){ echo $error['Rating']; } ?></span>

</div>



<div class="form-group <?php if($error['Advantages']!=''){ echo 'has-error'; } ?>" id="InputAdvantages">

  <label for="" class="">Advantages</label>

  <textarea  type="text" class="form-control" <?php if ($segment2 == 'evaluationview') { ?> readonly <?php } ?> id="Advantages" name="Advantages" placeholder="Advantages" ><?php echo $get_single_evaluation['Advantages']; ?></textarea>

  <span class="help-block"><?php if($error['Advantages']!=''){ echo $error['Advantages']; } ?></span>

</div>

<div class="form-group <?php if($error['Disadvantages']!=''){ echo 'has-error'; } ?>" id="InputDisadvantages">

  <label for="" class="">Disadvantages</label>

  <textarea  type="text" class="form-control" <?php if ($segment2 == 'evaluationview') { ?> readonly <?php } ?> id="Disadvantages" name="Disadvantages" placeholder="Disadvantages" ><?php echo $get_single_evaluation['Disadvantages']; ?></textarea>

  <span class="help-block"><?php if($error['Disadvantages']!=''){ echo $error['Disadvantages']; } ?></span>

</div>

<div class="form-group <?php if($error['Remarks']!=''){ echo 'has-error'; } ?>" id="InputRemarks">

  <label for="" class="">Remarks - Text (120 char)</label>

  <textarea  type="text" class="form-control" <?php if ($segment2 == 'evaluationview') { ?> readonly <?php } ?> id="Remarks" name="Remarks" placeholder="Remarks - Text (120 char)" ><?php echo $get_single_evaluation['Remarks']; ?></textarea>

  <span class="help-block"><?php if($error['Remarks']!=''){ echo $error['Remarks']; } ?></span>

</div>