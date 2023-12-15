<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">PLANT: vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_onion as $key => $value){ ?>

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

<div class="form-group <?php if($error['Plantsize']!=''){ echo 'has-error'; } ?>" id="InputPlantsize">

  <label for="" class="required">Plant size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantsize as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['Plantsize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Plantsize<?php echo $key; ?>" name="Plantsize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Plantsize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Plantsize']!=''){ echo $error['Plantsize']; } ?></span>

</div>

<div class="form-group <?php if($error['Maturityvscontrol']!=''){ echo 'has-error'; } ?>" id="InputMaturityvscontrol">

  <label for="" class="required">Bulb: Maturity (vs control)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Maturityvscontrol_onion as $key => $value){ ?>

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

<div class="form-group <?php if($error['Bulbshape']!=''){ echo 'has-error'; } ?>" id="InputBulbshape">

  <label for="" class="required">Bulb: Shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Bulbshape_onion as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Bulbshape']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Bulbshape<?php echo $key; ?>" name="Bulbshape" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Bulbshape<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Bulbshape']!=''){ echo $error['Bulbshape']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/onion/bulb-shape.png" style="width: 100%;">



</div>

<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">

  <label for="" class="required">Bulb: : size uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsizeuniformity_onion as $key => $value){ ?>

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

<div class="form-group <?php if($error['Bulbshapeuniformit']!=''){ echo 'has-error'; } ?>" id="InputBulbshapeuniformit">

  <label for="" class="required">Bulb: shape uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Bulbshapeuniformit as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Bulbshapeuniformit']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Bulbshapeuniformit<?php echo $key; ?>" name="Bulbshapeuniformit" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Bulbshapeuniformit<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Bulbshapeuniformit']!=''){ echo $error['Bulbshapeuniformit']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitweight']!=''){ echo 'has-error'; } ?>" id="InputFruitweight">

  <label for="" class="required">Bulb: fruit weight (gr)</label>

  <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="Bulb: fruit weight (gr)" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">

  <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Dryskinafterharvest']!=''){ echo 'has-error'; } ?>" id="InputDryskinafterharvest">

  <label for="" class="required">Bulb: adherence of dry skin after harvest</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Dryskinafterharvest as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Dryskinafterharvest']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Dryskinafterharvest<?php echo $key; ?>" name="Dryskinafterharvest" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Dryskinafterharvest<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Dryskinafterharvest']!=''){ echo $error['Dryskinafterharvest']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/onion/bulb-dry-skin.png" style="width: 100%;">



</div>

<div class="form-group <?php if($error['Necksize']!=''){ echo 'has-error'; } ?>" id="InputNecksize">

  <label for="" class="required">Neck size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Necksize as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Necksize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Necksize<?php echo $key; ?>" name="Necksize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Necksize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Necksize']!=''){ echo $error['Necksize']; } ?></span>

</div>

<div class="form-group <?php if($error['Thicknessofdryskin']!=''){ echo 'has-error'; } ?>" id="InputThicknessofdryskin">

  <label for="" class="required">Bulb: thickness of dry skin</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Thicknessofdryskin as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Thicknessofdryskin']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Thicknessofdryskin<?php echo $key; ?>" name="Thicknessofdryskin" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Thicknessofdryskin<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Thicknessofdryskin']!=''){ echo $error['Thicknessofdryskin']; } ?></span>

</div>

<div class="form-group <?php if($error['Basecolourdryskin']!=''){ echo 'has-error'; } ?>" id="InputBasecolourdryskin">

  <label for="" class="required">Bulb: base colour of dry skin</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Basecolourdryskin as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Basecolourdryskin']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Basecolourdryskin<?php echo $key; ?>" name="Basecolourdryskin" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Basecolourdryskin<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Basecolourdryskin']!=''){ echo $error['Basecolourdryskin']; } ?></span>

</div>





<div class="form-group <?php if($error['Noofdoublecenter']!=''){ echo 'has-error'; } ?>" id="InputNoofdoublecenter">

  <label for="" class="required">Bulb: No of double center out of 10</label>

  <input type="text" class="form-control" id="Noofdoublecenter" name="Noofdoublecenter" placeholder="Bulb: No of double center out of 10" value="<?php echo $get_single_evaluation['Noofdoublecenter']; ?>">

  <span class="help-block"><?php if($error['Noofdoublecenter']!=''){ echo $error['Noofdoublecenter']; } ?></span>

</div>





<div class="form-group <?php if($error['Boltingresistance']!=''){ echo 'has-error'; } ?>" id="InputBoltingresistance">

  <label for="" class="">Bolting resist./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Boltingresistance_onion as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Boltingresistance']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Boltingresistance<?php echo $key; ?>" name="Boltingresistance" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Boltingresistance<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Boltingresistance']!=''){ echo $error['Boltingresistance']; } ?></span>

</div>

<div class="form-group <?php if($error['Storability']!=''){ echo 'has-error'; } ?>" id="InputStorability">

  <label for="" class="">Bulb: Storability</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Storability as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Storability']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Storability<?php echo $key; ?>" name="Storability" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Storability<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Storability']!=''){ echo $error['Storability']; } ?></span>

</div>

<div class="form-group <?php if($error['Yieldestimated']!=''){ echo 'has-error'; } ?>" id="InputYieldestimated">

  <label for="" class="required">YIELD: estimated</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Yieldestimated as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Yieldestimated']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Yieldestimated<?php echo $key; ?>" name="Yieldestimated" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Yieldestimated<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Yieldestimated']!=''){ echo $error['Yieldestimated']; } ?></span>

</div>

<div class="form-group <?php if($error['Yieldmarketable']!=''){ echo 'has-error'; } ?>" id="InputYieldmarketable">

  <label for="" class="">Yield: Total marketable kg/m bed</label>

  <input type="text" class="form-control" id="Yieldmarketable" name="Yieldmarketable" placeholder="Yield: Total marketable kg/m bed" value="<?php echo $get_single_evaluation['Yieldmarketable']; ?>">

  <span class="help-block"><?php if($error['Yieldmarketable']!=''){ echo $error['Yieldmarketable']; } ?></span>

</div>

<div class="form-group <?php if($error['Yieldnonmarketable']!=''){ echo 'has-error'; } ?>" id="InputYieldnonmarketable">

  <label for="" class="">Yield: Non marketable kg/m bed</label>

  <input type="text" class="form-control" id="Yieldnonmarketable" name="Yieldnonmarketable" placeholder="Yield: Non marketable kg/m bed" value="<?php echo $get_single_evaluation['Yieldnonmarketable']; ?>">

  <span class="help-block"><?php if($error['Yieldnonmarketable']!=''){ echo $error['Yieldnonmarketable']; } ?></span>

</div>

<div class="form-group <?php if($error['Diseasespest']!=''){ echo 'has-error'; } ?>" id="InputDiseasespest">

  <label for="" class="required">Pests & Disease (Remark which)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Diseasespest as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Diseasespest']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Diseasespest<?php echo $key; ?>" name="Diseasespest" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Diseasespest<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Diseasespest']!=''){ echo $error['Diseasespest']; } ?></span>

</div>



<div class="form-group <?php if($error['Rating']!=''){ echo 'has-error'; } ?>" id="InputRating">

  <label for="" class="required">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_onion as $key => $value){ ?>

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