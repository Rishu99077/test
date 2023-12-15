

<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Vigor </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_chinesecabbage as $key => $value){ ?>

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

  <?php foreach ($Maturityindays_chinesecabbage as $key => $value){ ?>

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

  <label for="" class="required">Plant Uniformity </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Uniformity_chinesecabbage as $key => $value){ ?>

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



<div class="form-group <?php if($error['Plantheight']!=''){ echo 'has-error'; } ?>" id="InputPlantheight">

  <label for="" class="required"> Head: height  </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantheight_chinesecabbage as $key => $value){ ?>

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

  <br>

  <img src="<?php echo base_url() ?>adminasset/images/chinesecabbage/head-height.png" style="width: 100%;">

</div>



<div class="form-group <?php if($error['Friutwidth']!=''){ echo 'has-error'; } ?>" id="InputFriutwidth">

  <label for="" class="required"> Head: maximum width  </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Friutwidth_chinesecabbage as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Friutwidth']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Friutwidth<?php echo $key; ?>" name="Friutwidth" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Friutwidth<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Friutwidth']!=''){ echo $error['Friutwidth']; } ?></span>

  <br>

  <img src="<?php echo base_url() ?>adminasset/images/chinesecabbage/head-max-width.png" style="width: 100%;" >

</div>



<div class="form-group <?php if($error['Fruitshape']!=''){ echo 'has-error'; } ?>" id="InputFruitshape">

  <label for="" class="required"> Head: shape </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitshape_chinesecabbage as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitshape']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitshape<?php echo $key; ?>" name="Fruitshape" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitshape<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitshape']!=''){ echo $error['Fruitshape']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/chinesecabbage/head-shape.png" style="width: 100%;">

</div>



<div class="form-group <?php if($error['Headtype']!=''){ echo 'has-error'; } ?>" id="InputHeadtype">

  <label for="" class="required"> Headtype </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headtype_chinesecabbage as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Headtype']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Headtype<?php echo $key; ?>" name="Headtype" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Headtype<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Headtype']!=''){ echo $error['Headtype']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/chinesecabbage/head-type.png" style="width: 100%;">

</div>



<div class="form-group <?php if($error['Headweight']!=''){ echo 'has-error'; } ?>" id="InputHeadweight">

  <label for="" class="required">Head weight (Kg) </label>

  <input type="text" class="form-control" id="Headweight" name="Headweight" placeholder="Head weight (Kg)" value="<?php echo $get_single_evaluation['Headweight']; ?>">

  <span class="help-block"><?php if($error['Headweight']!=''){ echo $error['Headweight']; } ?></span>

</div>



<div class="form-group <?php if($error['Headcolor']!=''){ echo 'has-error'; } ?>" id="InputHeadcolor">

  <label for="" class="required"> Head:internal color </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headcolor_chinesecabbage as $key => $value){ ?>

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



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/chinesecabbage/head-internal-color.png" style="width: 100%;">



</div>





<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="required"> Head:Firmness </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness_chinesecabbage as $key => $value){ ?>

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

  <br>

  <img src="<?php echo base_url() ?>adminasset/images/chinesecabbage/head-firm.png" style="width: 100%;">

</div>



<div class="form-group <?php if($error['Headuniformity']!=''){ echo 'has-error'; } ?>" id="InputHeaduniformity">

  <label for="" class="required"> Head uniformity </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headuniformity_chinesecabbage as $key => $value){ ?>

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



<div class="form-group <?php if($error['HeatColdresisttol']!=''){ echo 'has-error'; } ?>" id="InputHeatColdresisttol">

  <label for="" class="required"> Heat/ Cold resist./tol. </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($HeatColdresisttol_chinesecabbage as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['HeatColdresisttol']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="HeatColdresisttol<?php echo $key; ?>" name="HeatColdresisttol" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="HeatColdresisttol<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['HeatColdresisttol']!=''){ echo $error['HeatColdresisttol']; } ?></span>

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



<div class="form-group <?php if($error['Rating']!=''){ echo 'has-error'; } ?>" id="InputRating">

  <label for="" class="required">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_chinesecabbage as $key => $value){ ?>

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