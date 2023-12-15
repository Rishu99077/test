<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_cabbage as $key => $value){ ?>

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

  <?php foreach ($Maturity_cabbage as $key => $value){ ?>

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

<div class="form-group <?php if($error['Uniformity']!=''){ echo 'has-error'; } ?>" id="InputUniformity">

  <label for="" class="required">Plant uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Uniformity_cabbage as $key => $value){ ?>

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

<div class="form-group <?php if($error['Headcolor']!=''){ echo 'has-error'; } ?>" id="InputHeadcolor">

  <label for="" class="required">Head color</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headcolor as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['Headcolor']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Headcolor<?php echo $key; ?>" name="Headcolor" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Headcolor<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Headcolor']!=''){ echo $error['Headcolor']; } ?></span>

</div>

<div class="form-group <?php if($error['Headshape']!=''){ echo 'has-error'; } ?>" id="InputHeadshape">

  <label for="" class="required">Head shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headshape_cabbage as $key => $value){ ?>

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

</div>

<div class="form-group <?php if($error['Headweight']!=''){ echo 'has-error'; } ?>" id="InputHeadweight">

  <label for="" class="required">Head weight (gr)</label>

  <input type="text" class="form-control" id="Headweight" name="Headweight" placeholder="Head weight (gr)" value="<?php echo $get_single_evaluation['Headweight']; ?>">

  <span class="help-block"><?php if($error['Headweight']!=''){ echo $error['Headweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Headlength']!=''){ echo 'has-error'; } ?>" id="InputHeadlength">

  <label for="" class="required">Head length (cm)</label>

  <input type="text" class="form-control" id="Headlength" name="Headlength" placeholder="Head length (cm)" value="<?php echo $get_single_evaluation['Headlength']; ?>">

  <span class="help-block"><?php if($error['Headlength']!=''){ echo $error['Headlength']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/cabbage/Head-length-cabbage.png" style="width: 100%;">



</div>

<div class="form-group <?php if($error['Headdiameter']!=''){ echo 'has-error'; } ?>" id="InputHeaddiameter">

  <label for="" class="required">Head diameter (cm)</label>

  <input type="text" class="form-control" id="Headdiameter" name="Headdiameter" placeholder="Head diameter (cm)" value="<?php echo $get_single_evaluation['Headdiameter']; ?>">

  <span class="help-block"><?php if($error['Headdiameter']!=''){ echo $error['Headdiameter']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/cabbage/Head-diameter-cabbage.png" style="width: 100%;" >

  



</div>

<div class="form-group <?php if($error['Headuniformity']!=''){ echo 'has-error'; } ?>" id="InputHeaduniformity">

  <label for="" class="required">Head uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headuniformity_cabbage as $key => $value){ ?>

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

<div class="form-group <?php if($error['Leafwaxiness']!=''){ echo 'has-error'; } ?>" id="InputLeafwaxiness">

  <label for="" class="required">Leaf waxiness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Leafwaxiness as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Leafwaxiness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Leafwaxiness<?php echo $key; ?>" name="Leafwaxiness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Leafwaxiness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Leafwaxiness']!=''){ echo $error['Leafwaxiness']; } ?></span>

</div>

<div class="form-group <?php if($error['anthocyanincolorationofcoverleaf']!=''){ echo 'has-error'; } ?>" id="Inputanthocyanincolorationofcoverleaf">

  <label for="" class="required">anthocyanin coloration of cover leaf</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($anthocyanincolorationofcoverleaf as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['anthocyanincolorationofcoverleaf']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="anthocyanincolorationofcoverleaf<?php echo $key; ?>" name="anthocyanincolorationofcoverleaf" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="anthocyanincolorationofcoverleaf<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['anthocyanincolorationofcoverleaf']!=''){ echo $error['anthocyanincolorationofcoverleaf']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/cabbage/cover-leaf-cabbage.png" style="width: 100%;">

  

</div>

<div class="form-group <?php if($error['Coresize']!=''){ echo 'has-error'; } ?>" id="InputCoresize">

  <label for="" class="required">Core size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Coresize as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Coresize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Coresize<?php echo $key; ?>" name="Coresize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Coresize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Coresize']!=''){ echo $error['Coresize']; } ?></span>

</div>

<div class="form-group <?php if($error['Headdensity']!=''){ echo 'has-error'; } ?>" id="InputHeaddensity">

  <label for="" class="required">Head density</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headdensity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Headdensity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Headdensity<?php echo $key; ?>" name="Headdensity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Headdensity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Headdensity']!=''){ echo $error['Headdensity']; } ?></span>

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

<div class="form-group <?php if($error['Yield']!=''){ echo 'has-error'; } ?>" id="InputYield">

  <label for="" class="required">Yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Yield_cabbage as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Yield']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Yield<?php echo $key; ?>" name="Yield" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Yield<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Yield']!=''){ echo $error['Yield']; } ?></span>

</div>

<div class="form-group <?php if($error['Rating']!=''){ echo 'has-error'; } ?>" id="InputRating">

  <label for="" class="required">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_cabbage as $key => $value){ ?>

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