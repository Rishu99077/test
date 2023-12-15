<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Plant vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_cucumber as $key => $value){ ?>

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

<div class="form-group <?php if($error['Plantstructure']!=''){ echo 'has-error'; } ?>" id="InputPlantstructure">

  <label for="" class="required">Plant structure</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantstructure_cucumber as $key => $value){ ?>

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

<div class="form-group <?php if($error['Plantsideshootbehaviour']!=''){ echo 'has-error'; } ?>" id="InputPlantsideshootbehaviour" style="display: none;">

  <label for="" class="required">Plant side shoot behaviour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantsideshootbehaviour as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Plantsideshootbehaviour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Plantsideshootbehaviour<?php echo $key; ?>" name="Plantsideshootbehaviour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Plantsideshootbehaviour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Plantsideshootbehaviour']!=''){ echo $error['Plantsideshootbehaviour']; } ?></span>

</div>

<div class="form-group <?php if($error['Plantfrtsnode']!=''){ echo 'has-error'; } ?>" id="InputPlantfrtsnode">

  <label for="" class="required">Plant frts/node</label>

  <input type="text" class="form-control" id="Plantfrtsnode" name="Plantfrtsnode" placeholder="Average wieght" value="<?php echo $get_single_evaluation['Plantfrtsnode']; ?>">

  <span class="help-block"><?php if($error['Plantfrtsnode']!=''){ echo $error['Plantfrtsnode']; } ?></span>

</div>

<div class="form-group <?php if($error['PowderyMildewSf']!=''){ echo 'has-error'; } ?>" id="InputPowderyMildewSf">

  <label for="" class="required">Powdery Mildew (Sf)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($PowderyMildewSf as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['PowderyMildewSf']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="PowderyMildewSf<?php echo $key; ?>" name="PowderyMildewSf" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="PowderyMildewSf<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['PowderyMildewSf']!=''){ echo $error['PowderyMildewSf']; } ?></span>

</div>

 <div class="form-group <?php if($error['SkinCucumber']!=''){ echo 'has-error'; } ?>" id="SkinCucumber">

  <label for="" class="required">Skin</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($SkinCucumber as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['SkinCucumber']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="SkinCucumber<?php echo $key; ?>" name="SkinCucumber" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="SkinCucumber<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['SkinCucumber']!=''){ echo $error['SkinCucumber']; } ?></span>

</div> 


<div class="form-group <?php if($error['DownyMildewPcu']!=''){ echo 'has-error'; } ?>" id="InputDownyMildewPcu">

  <label for="" class="required">Downy Mildew (Pcu)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($DownyMildewPcu as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['DownyMildewPcu']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="DownyMildewPcu<?php echo $key; ?>" name="DownyMildewPcu" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="DownyMildewPcu<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['DownyMildewPcu']!=''){ echo $error['DownyMildewPcu']; } ?></span>

</div>

<div class="form-group <?php if($error['Friutlength']!=''){ echo 'has-error'; } ?>" id="InputFriutlength">

  <label for="" class="required">FRUIT length (cm):</label>

  <br>

  <input type="text" class="form-control" id="Friutlength" name="Friutlength" placeholder="FRUIT length (cm):" value="<?php echo $get_single_evaluation['Friutlength']; ?>">

  <span class="help-block"><?php if($error['Friutlength']!=''){ echo $error['Friutlength']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitcolour_cucumber']!=''){ echo 'has-error'; } ?>" id="InputFruitcolour_cucumber">

  <label for="" class="required">Fruit colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitcolour_cucumber as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitcolour_cucumber']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitcolour_cucumber<?php echo $key; ?>" name="Fruitcolour_cucumber" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitcolour_cucumber<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitcolour_cucumber']!=''){ echo $error['Fruitcolour_cucumber']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitoverallquality']!=''){ echo 'has-error'; } ?>" id="InputFruitoverallquality">

  <label for="" class="required">Fruit overall quality</label>

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

<div class="form-group <?php if($error['Yieldcontinuity']!=''){ echo 'has-error'; } ?>" id="InputYieldcontinuity">

  <label for="" class="required">Yield continuity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Yieldcontinuity_Cucumber as $key => $value){ ?>

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

  <label for="" class="required">Visual Yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($VisualYield as $key => $value){ ?>

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

  <label for="" class="required">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_cucumber as $key => $value){ ?>

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

  <textarea  type="text" class="form-control" <?php if ($segment2 == 'evaluationview') { ?> readonly <?php } ?> id="Remarks" name="Remarks" placeholder="Remarks" ><?php echo $get_single_evaluation['Remarks']; ?></textarea>

  <span class="help-block"><?php if($error['Remarks']!=''){ echo $error['Remarks']; } ?></span>

</div>