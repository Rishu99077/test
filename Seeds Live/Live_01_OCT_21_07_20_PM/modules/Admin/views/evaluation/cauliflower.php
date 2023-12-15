<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_cauliflower as $key => $value){ ?>

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

<div class="form-group <?php if($error['Maturityvscontrol']!=''){ echo 'has-error'; } ?>" id="InputMaturityvscontrol">

  <label for="" class="required">Maturity (vs control)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Maturityvscontrol as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Maturityvscontrol']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Maturityvscontrol<?php echo $key; ?>" name="Maturityvscontrol" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Maturityvscontrol<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Maturityvscontrol']!=''){ echo $error['Maturityvscontrol']; } ?></span>

</div>

<div class="form-group <?php if($error['Plantheight']!=''){ echo 'has-error'; } ?>" id="InputPlantheight">

  <label for="" class="required">Plant height</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantheight as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Plantheight']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Plantheight<?php echo $key; ?>" name="Plantheight" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Plantheight<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Plantheight']!=''){ echo $error['Plantheight']; } ?></span>

</div>

<div class="form-group <?php if($error['Uniformity']!=''){ echo 'has-error'; } ?>" id="InputUniformity">

  <label for="" class="required">Plant uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Uniformity_cauliflower as $key => $value){ ?>

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





<div class="form-group <?php if($error['Curdweight']!=''){ echo 'has-error'; } ?>" id="InputCurdweight">

  <label for="" class="required">Curd weight (gr)</label>

  <input type="text" class="form-control" id="Curdweight" name="Curdweight" placeholder="Curd weight (gr)" value="<?php echo $get_single_evaluation['Curdweight']; ?>">

  <span class="help-block"><?php if($error['Curdweight']!=''){ echo $error['Curdweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Curdcolor']!=''){ echo 'has-error'; } ?>" id="InputCurdcolor">

  <label for="" class="required">Curd colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Curdcolor_cauliflower as $key => $value){ ?>

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

<div class="form-group <?php if($error['Curdcover']!=''){ echo 'has-error'; } ?>" id="InputCurdcover">

  <label for="" class="required">Curd cover</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Curdcover as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Curdcover']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Curdcover<?php echo $key; ?>" name="Curdcover" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Curdcover<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Curdcover']!=''){ echo $error['Curdcover']; } ?></span>

</div>

<div class="form-group <?php if($error['CurdUniformity']!=''){ echo 'has-error'; } ?>" id="InputCurdUniformity">

  <label for="" class="required">Curd Uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($CurdUniformity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['CurdUniformity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="CurdUniformity<?php echo $key; ?>" name="CurdUniformity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="CurdUniformity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['CurdUniformity']!=''){ echo $error['CurdUniformity']; } ?></span>

</div>

<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="required">Firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness_cauliflower as $key => $value){ ?>

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

<div class="form-group <?php if($error['Fieldholdability']!=''){ echo 'has-error'; } ?>" id="InputFieldholdability">

  <label for="" class="">Field hold ability</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fieldholdability as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fieldholdability']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fieldholdability<?php echo $key; ?>" name="Fieldholdability" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fieldholdability<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fieldholdability']!=''){ echo $error['Fieldholdability']; } ?></span>

</div>

<div class="form-group <?php if($error['Shelflife']!=''){ echo 'has-error'; } ?>" id="InputShelflife">

  <label for="" class="">Shelf life</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Shelflife as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Shelflife']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Shelflife<?php echo $key; ?>" name="Shelflife" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Shelflife<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Shelflife']!=''){ echo $error['Shelflife']; } ?></span>

</div>

<div class="form-group <?php if($error['Curdanthocyanin']!=''){ echo 'has-error'; } ?>" id="InputCurdanthocyanin">

  <label for="" class="required">curd: anthocyanin coloration after harvest maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Curdanthocyanin as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Curdanthocyanin']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Curdanthocyanin<?php echo $key; ?>" name="Curdanthocyanin" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Curdanthocyanin<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Curdanthocyanin']!=''){ echo $error['Curdanthocyanin']; } ?></span>

  <br>

  <img src="<?php echo base_url() ?>adminasset/images/cauliflower/cauliflower.png" style="width: 100%;">

</div>

<div class="form-group <?php if($error['Heatresittol']!=''){ echo 'has-error'; } ?>" id="InputHeatresittol">

  <label for="" class="">Heat resit./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Heatresittol_cauliflower as $key => $value){ ?>

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

  <?php foreach ($Coldresisttol_cauliflower as $key => $value){ ?>

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

  <?php foreach ($Rating_cauliflower as $key => $value){ ?>

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