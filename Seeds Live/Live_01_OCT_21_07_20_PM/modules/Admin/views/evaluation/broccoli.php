<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_broccoli as $key => $value){ ?>

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

<div class="form-group <?php if($error['Maturity']!=''){ echo 'has-error'; } ?>" id="InputMaturity">

  <label for="" class="required">Maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Maturity_broccoli as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Maturity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Maturity<?php echo $key; ?>" name="Maturity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Maturity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Maturity']!=''){ echo $error['Maturity']; } ?></span>

</div>

<div class="form-group <?php if($error['Plantframesize']!=''){ echo 'has-error'; } ?>" id="InputPlantframesize">

  <label for="" class="required">Plant frame size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantframesize as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Plantframesize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Plantframesize<?php echo $key; ?>" name="Plantframesize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Plantframesize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Plantframesize']!=''){ echo $error['Plantframesize']; } ?></span>

</div>

<div class="form-group <?php if($error['Stemthickness']!=''){ echo 'has-error'; } ?>" id="InputStemthickness">

  <label for="" class="required">Stem thickness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Stemthickness as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Stemthickness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Stemthickness<?php echo $key; ?>" name="Stemthickness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Stemthickness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Stemthickness']!=''){ echo $error['Stemthickness']; } ?></span>

</div> 

<div class="form-group <?php if($error['Headweight']!=''){ echo 'has-error'; } ?>" id="InputHeadweight">

  <label for="" class="required">Head weight (gr)</label>

  <input type="text" class="form-control" id="Headweight" name="Headweight" placeholder="Head weight (gr)" value="<?php echo $get_single_evaluation['Headweight']; ?>">

  <span class="help-block"><?php if($error['Headweight']!=''){ echo $error['Headweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Curdcolor']!=''){ echo 'has-error'; } ?>" id="InputCurdcolor">

  <label for="" class="required">Curd color</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Curdcolor_brocoli as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Curdcolor']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Curdcolor<?php echo $key; ?>" name="Curdcolor" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Curdcolor<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Curdcolor']!=''){ echo $error['Curdcolor']; } ?></span>

</div>

<div class="form-group <?php if($error['Headshape']!=''){ echo 'has-error'; } ?>" id="InputHeadshape">

  <label for="" class="required">Head shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headshape_brocoli as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Headshape']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Headshape<?php echo $key; ?>" name="Headshape" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Headshape<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Headshape']!=''){ echo $error['Headshape']; } ?></span>

  <br>

  <img src="<?php echo base_url() ?>adminasset/images/broccoli-head-shape.png" style="width: 100%;">

</div>



<div class="form-group <?php if($error['Beadsize']!=''){ echo 'has-error'; } ?>" id="InputBeadsize">

  <label for="" class="required">Bead size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Beadsize as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Beadsize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Beadsize<?php echo $key; ?>" name="Beadsize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Beadsize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Beadsize']!=''){ echo $error['Beadsize']; } ?></span>

</div>

<div class="form-group <?php if($error['Headuniformity']!=''){ echo 'has-error'; } ?>" id="InputHeaduniformity">

  <label for="" class="required">Head uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headuniformity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Headuniformity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Headuniformity<?php echo $key; ?>" name="Headuniformity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Headuniformity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Headuniformity']!=''){ echo $error['Headuniformity']; } ?></span>

</div>

<div class="form-group <?php if($error['Firmness_broccoli']!=''){ echo 'has-error'; } ?>" id="InputFirmness_broccoli">

  <label for="" class="required">Firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness_broccoli as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Firmness_broccoli']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Firmness_broccoli<?php echo $key; ?>" name="Firmness_broccoli" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Firmness_broccoli<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Firmness_broccoli']!=''){ echo $error['Firmness_broccoli']; } ?></span>

</div>

<div class="form-group <?php if($error['Sideshoots']!=''){ echo 'has-error'; } ?>" id="InputSideshoots">

  <label for="" class="required">Side shoots</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Sideshoots as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Sideshoots']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Sideshoots<?php echo $key; ?>" name="Sideshoots" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Sideshoots<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Sideshoots']!=''){ echo $error['Sideshoots']; } ?></span>

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

<div class="form-group <?php if($error['Heatresittol']!=''){ echo 'has-error'; } ?>" id="InputHeatresittol">

  <label for="" class="">Heat resit./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Heatresittol as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Heatresittol']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Heatresittol<?php echo $key; ?>" name="Heatresittol" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Heatresittol<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Heatresittol']!=''){ echo $error['Heatresittol']; } ?></span>

</div>

<div class="form-group <?php if($error['Coldresisttol']!=''){ echo 'has-error'; } ?>" id="InputColdresisttol">

  <label for="" class="">Cold resist./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Coldresisttol as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Coldresisttol']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Coldresisttol<?php echo $key; ?>" name="Coldresisttol" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Coldresisttol<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Coldresisttol']!=''){ echo $error['Coldresisttol']; } ?></span>

</div>

<div class="form-group <?php if($error['Rating']!=''){ echo 'has-error'; } ?>" id="InputRating">

  <label for="" class="required">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_broccoli as $key => $value){ ?>

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