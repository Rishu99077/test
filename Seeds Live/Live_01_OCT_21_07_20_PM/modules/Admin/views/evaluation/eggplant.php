<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Plant vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_eggplant as $key => $value){ ?>

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

  <?php foreach ($Maturity_eggplant as $key => $value){ ?>

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

<div class="form-group <?php if($error['Growthheight']!=''){ echo 'has-error'; } ?>" id="InputGrowthheight">

  <label for="" class="required">Plant:  growth  height</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Growthheight as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Growthheight']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Growthheight<?php echo $key; ?>" name="Growthheight" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Growthheight<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Growthheight']!=''){ echo $error['Growthheight']; } ?></span>

</div>

<div class="form-group <?php if($error['InternodesLength']!=''){ echo 'has-error'; } ?>" id="InputInternodesLength">

  <label for="" class="required">Plant: Internode length</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($InternodesLength as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['InternodesLength']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="InternodesLength<?php echo $key; ?>" name="InternodesLength" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="InternodesLength<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['InternodesLength']!=''){ echo $error['InternodesLength']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitshape']!=''){ echo 'has-error'; } ?>" id="InputFruitshape">

  <label for="" class="required">Fruit : shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitshape_eggplant as $key => $value){ ?>

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

  <img src="<?php echo base_url() ?>adminasset/images/Eggplant/fruit-shape.png" style="width: 100%;">





</div>

<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">

  <label for="" class="required">Fruit: size uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsizeuniformity_eggplant as $key => $value){ ?>

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

<div class="form-group <?php if($error['Fruitshapeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitshapeuniformity">

  <label for="" class="required">Fruit: shape uniformity</label>

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

<div class="form-group <?php if($error['DiameteratMidpoint']!=''){ echo 'has-error'; } ?>" id="InputDiameteratMidpoint">

  <label for="" class="required">Diameter at Midpoint(cm)</label>

  <input type="text" class="form-control" id="DiameteratMidpoint" name="DiameteratMidpoint" placeholder="Diameter at Midpoint(cm)" value="<?php echo $get_single_evaluation['DiameteratMidpoint']; ?>">

  <span class="help-block"><?php if($error['DiameteratMidpoint']!=''){ echo $error['DiameteratMidpoint']; } ?></span>

</div>

<div class="form-group <?php if($error['Friutlength']!=''){ echo 'has-error'; } ?>" id="InputFriutlength">

  <label for="" class="required">length (cm)</label>

  <input type="text" class="form-control" id="Friutlength" name="Friutlength" placeholder="length (cm)" value="<?php echo $get_single_evaluation['Friutlength']; ?>">

  <span class="help-block"><?php if($error['Friutlength']!=''){ echo $error['Friutlength']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitweight']!=''){ echo 'has-error'; } ?>" id="InputFruitweight">

  <label for="" class="required">weight (gr)

Measure at least 10 fruits which represent majority of fruits</label>

  <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="weight (gr) Measure at least 10 fruits which represent majority of fruits" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">

  <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitcolouratmaturity']!=''){ echo 'has-error'; } ?>" id="InputFruitcolouratmaturity">

  <label for="" class="required">Fruit: colour at maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitcolouratmaturity_eggplant as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitcolouratmaturity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitcolouratmaturity<?php echo $key; ?>" name="Fruitcolouratmaturity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitcolouratmaturity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitcolouratmaturity']!=''){ echo $error['Fruitcolouratmaturity']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitglossiness']!=''){ echo 'has-error'; } ?>" id="InputFruitglossiness">

  <label for="" class="required">Fruit:glossiness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitglossiness as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitglossiness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitglossiness<?php echo $key; ?>" name="Fruitglossiness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitglossiness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitglossiness']!=''){ echo $error['Fruitglossiness']; } ?></span>



  <br>

  <img src="<?php echo base_url() ?>adminasset/images/Eggplant/fruit-glossiness.png" style="width: 100%;">



</div>

<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="required">Fruit: Firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness_eggplant as $key => $value){ ?>

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

<div class="form-group <?php if($error['Fruittaste']!=''){ echo 'has-error'; } ?>" id="InputFruittaste">

  <label for="" class="required">Fruit: Taste</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruittaste_eggplant as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruittaste']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruittaste<?php echo $key; ?>" name="Fruittaste" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruittaste<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruittaste']!=''){ echo $error['Fruittaste']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsetting']!=''){ echo 'has-error'; } ?>" id="InputFruitsetting">

  <label for="" class="required">Fruit setting</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsettingunderlowtemperature as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitsetting']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitsetting<?php echo $key; ?>" name="Fruitsetting" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitsetting<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitsetting']!=''){ echo $error['Fruitsetting']; } ?></span>

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

<div class="form-group <?php if($error['Yieldcontinuity']!=''){ echo 'has-error'; } ?>" id="InputYieldcontinuity">

  <label for="" class="required">YIELD: continuity of yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Yieldcontinuity_eggplant as $key => $value){ ?>

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

  <?php foreach ($Rating as $key => $value){ ?>

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