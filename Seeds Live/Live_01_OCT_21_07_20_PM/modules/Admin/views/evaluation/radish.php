<div class="form-group <?php if($error['Marketsegment']!=''){ echo 'has-error'; } ?>" id="InputMarketsegment">

  <label for="" class="required">Market segment</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Marketsegment_radish as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Marketsegment']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Marketsegment<?php echo $key; ?>" name="Marketsegment" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Marketsegment<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Marketsegment']!=''){ echo $error['Marketsegment']; } ?></span>

</div>



<div class="form-group <?php if($error['Typeofcultivation']!=''){ echo 'has-error'; } ?>" id="InputTypeofcultivation">

  <label for="" class="required">Type of cultivation</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Typeofcultivation as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Typeofcultivation']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Typeofcultivation<?php echo $key; ?>" name="Typeofcultivation" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Typeofcultivation<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Typeofcultivation']!=''){ echo $error['Typeofcultivation']; } ?></span>

</div>



<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Plant vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_radish as $key => $value){ ?>

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





<div class="form-group <?php if($error['Harvesting']!=''){ echo 'has-error'; } ?>" id="InputHarvesting">

  <label for="" class="required"> Harvesting (maturity) vs control  </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Harvesting_radish as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Harvesting']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Harvesting<?php echo $key; ?>" name="Harvesting" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Harvesting<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Harvesting']!=''){ echo $error['Harvesting']; } ?></span>

</div>







<div class="form-group <?php if($error['Standingleaves']!=''){ echo 'has-error'; } ?>" id="InputStandingleaves">

  <label for="" class="required">Standing leaves</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Standingleaves as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Standingleaves']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Standingleaves<?php echo $key; ?>" name="Standingleaves" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Standingleaves<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Standingleaves']!=''){ echo $error['Standingleaves']; } ?></span>

</div>



<div class="form-group <?php if($error['Plantstructure']!=''){ echo 'has-error'; } ?>" id="InputPlantstructure">

  <label for="" class="required">Plant structure</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantstructure_radish as $key => $value){ ?>

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





<div class="form-group <?php if($error['Radishshape']!=''){ echo 'has-error'; } ?>" id="InputRadishshape">

  <label for="" class="required">Radish shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Radishshape as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Radishshape']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Radishshape<?php echo $key; ?>" name="Radishshape" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Radishshape<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Radishshape']!=''){ echo $error['Radishshape']; } ?></span>

</div>



<div class="form-group <?php if($error['Radishdevelopment']!=''){ echo 'has-error'; } ?>" id="InputRadishdevelopment">

  <label for="" class="required">Radish development</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Radishdevelopment as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Radishdevelopment']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Radishdevelopment<?php echo $key; ?>" name="Radishdevelopment" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Radishdevelopment<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Radishdevelopment']!=''){ echo $error['Radishdevelopment']; } ?></span>

</div>





<div class="form-group <?php if($error['Rootuniformity']!=''){ echo 'has-error'; } ?>" id="InputRootuniformity">

  <label for="" class="required">Root uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rootuniformity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Rootuniformity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Rootuniformity<?php echo $key; ?>" name="Rootuniformity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Rootuniformity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Rootuniformity']!=''){ echo $error['Rootuniformity']; } ?></span>

</div>



<div class="form-group <?php if($error['Radishcolour']!=''){ echo 'has-error'; } ?>" id="InputRadishcolour">

  <label for="" class="required">Radish colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Radishcolour as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Radishcolour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Radishcolour<?php echo $key; ?>" name="Radishcolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Radishcolour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Radishcolour']!=''){ echo $error['Radishcolour']; } ?></span>

</div>





<div class="form-group <?php if($error['Shelflife']!=''){ echo 'has-error'; } ?>" id="InputShelflife">

  <label for="" class="">Shelf life</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Shelflife_radish as $key => $value){ ?>

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



<div class="form-group <?php if($error['Heatresittol']!=''){ echo 'has-error'; } ?>" id="InputHeatresittol">

  <label for="" class="">Heat/Cold resit./tol.</label>

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





<div class="form-group <?php if($error['Yield']!=''){ echo 'has-error'; } ?>" id="InputYield">

  <label for="" class="required">Yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Yield as $key => $value){ ?>

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







<div class="form-group <?php if($error['Spongeness']!=''){ echo 'has-error'; } ?>" id="InputSpongeness">

  <label for="" class="required">Spongeness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Spongeness as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Spongeness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Spongeness<?php echo $key; ?>" name="Spongeness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Spongeness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Spongeness']!=''){ echo $error['Spongeness']; } ?></span>

</div>



<div class="form-group <?php if($error['Rootsize']!=''){ echo 'has-error'; } ?>" id="InputRootsize">

  <label for="" class="required">Root size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rootsize_radish as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Rootsize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Rootsize<?php echo $key; ?>" name="Rootsize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Rootsize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Rootsize']!=''){ echo $error['Rootsize']; } ?></span>

</div>



<div class="form-group <?php if($error['Rating']!=''){ echo 'has-error'; } ?>" id="InputRating">

  <label for="" class="required">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_radish as $key => $value){ ?>

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