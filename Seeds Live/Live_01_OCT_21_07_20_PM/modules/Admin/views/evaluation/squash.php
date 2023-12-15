<div class="form-group <?php if($error['Varietytype']!=''){ echo 'has-error'; } ?>" id="InputVarietytype">

  <label for="" class="required">Variety type</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Varietytype_squash as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Varietytype']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Varietytype<?php echo $key; ?>" name="Varietytype" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Varietytype<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Varietytype']!=''){ echo $error['Varietytype']; } ?></span>

</div>

<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Plant:Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_squash as $key => $value){ ?>

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

  <?php foreach ($Maturity_squash as $key => $value){ ?>

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

<div class="form-group <?php if($error['Growthtype']!=''){ echo 'has-error'; } ?>" id="InputGrowthtype">

  <label for="" class="required">Plant: growth type</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Growthtype as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Growthtype']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Growthtype<?php echo $key; ?>" name="Growthtype" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Growthtype<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Growthtype']!=''){ echo $error['Growthtype']; } ?></span>

</div>

<div class="form-group <?php if($error['Planthabit']!=''){ echo 'has-error'; } ?>" id="InputPlanthabit">

  <label for="" class="required">Plant habit</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Planthabit as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Planthabit']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Planthabit<?php echo $key; ?>" name="Planthabit" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Planthabit<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Planthabit']!=''){ echo $error['Planthabit']; } ?></span>

</div>

<div class="form-group <?php if($error['Silvering']!=''){ echo 'has-error'; } ?>" id="InputSilvering">

  <label for="" class="required">Silvering</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Silvering as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Silvering']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Silvering<?php echo $key; ?>" name="Silvering" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Silvering<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Silvering']!=''){ echo $error['Silvering']; } ?></span>

</div>

<div class="form-group <?php if($error['Branching']!=''){ echo 'has-error'; } ?>" id="InputBranching">

  <label for="" class="required">Branching</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Branching as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Branching']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Branching<?php echo $key; ?>" name="Branching" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Branching<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Branching']!=''){ echo $error['Branching']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitshape']!=''){ echo 'has-error'; } ?>" id="InputFruitshape">

  <label for="" class="required">Fruit : shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitshape_squash as $key => $value){ ?>

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

  <img src="<?php echo base_url(); ?>adminasset/images/Fruitshape.png" style="width: 100%;">



</div>

<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">

  <label for="" class="required">Fruit: size uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsizeuniformity_squash as $key => $value){ ?>

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

<div class="form-group <?php if($error['Friutlength']!=''){ echo 'has-error'; } ?>" id="InputFriutlength">

  <label for="" class="required">length (cm)</label>

  <input type="text" class="form-control" id="Friutlength" name="Friutlength" placeholder="length (cm)" value="<?php echo $get_single_evaluation['Friutlength']; ?>">

  <span class="help-block"><?php if($error['Friutlength']!=''){ echo $error['Friutlength']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitdiameter']!=''){ echo 'has-error'; } ?>" id="InputFruitdiameter">

  <label for="" class="required">diameter(cm)</label>

  <input type="text" class="form-control" id="Fruitdiameter" name="Fruitdiameter" placeholder="diameter(cm)" value="<?php echo $get_single_evaluation['Fruitdiameter']; ?>">

  <span class="help-block"><?php if($error['Fruitdiameter']!=''){ echo $error['Fruitdiameter']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitweight']!=''){ echo 'has-error'; } ?>" id="InputFruitweight">

  <label for="" class="required">Weight (gr)- Measure at least 5 fruits</label>

  <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="Weight (gr)- Measure at least 5 fruits" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">

  <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitcolouratmaturity']!=''){ echo 'has-error'; } ?>" id="InputFruitcolouratmaturity">

  <label for="" class="required">Fruit: colour at maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitcolouratmaturity_squash as $key => $value){ ?>

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

<div class="form-group <?php if($error['YongfruitRatio']!=''){ echo 'has-error'; } ?>" id="InputYongfruitRatio">

  <label for="" class="required">Yong fruit: Ratio length/maximum diameter</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($YongfruitRatio as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['YongfruitRatio']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="YongfruitRatio<?php echo $key; ?>" name="YongfruitRatio" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="YongfruitRatio<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['YongfruitRatio']!=''){ echo $error['YongfruitRatio']; } ?></span>



  <br>

  <img src="<?php echo base_url(); ?>adminasset/images/YongfruitRatio.png" style="width: 100%;">

</div>

<div class="form-group <?php if($error['Stripesripefruit']!=''){ echo 'has-error'; } ?>" id="InputStripesripefruit">

  <label for="" class="required">Stripes ripe fruit</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Stripesripefruit as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Stripesripefruit']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Stripesripefruit<?php echo $key; ?>" name="Stripesripefruit" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Stripesripefruit<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Stripesripefruit']!=''){ echo $error['Stripesripefruit']; } ?></span>

</div>

<div class="form-group <?php if($error['Blossomscar']!=''){ echo 'has-error'; } ?>" id="InputBlossomscar">

  <label for="" class="required">Blossom scar</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Blossomscar as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Blossomscar']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Blossomscar<?php echo $key; ?>" name="Blossomscar" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Blossomscar<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Blossomscar']!=''){ echo $error['Blossomscar']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitglossiness']!=''){ echo 'has-error'; } ?>" id="InputFruitglossiness">

  <label for="" class="required">Fruit:glossiness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitglossiness_squash as $key => $value){ ?>

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

</div>

<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="required">Fruit: Firmness</label>

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

<div class="form-group <?php if($error['Easypicking']!=''){ echo 'has-error'; } ?>" id="InputEasypicking">

  <label for="" class="required">Easy Picking</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Easypicking as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Easypicking']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Easypicking<?php echo $key; ?>" name="Easypicking" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Easypicking<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Easypicking']!=''){ echo $error['Easypicking']; } ?></span>

</div>

<div class="form-group <?php if($error['Harvestlongevity']!=''){ echo 'has-error'; } ?>" id="InputHarvestlongevity">

  <label for="" class="required">Harvest Longevity (days)</label>

  <input type="text" class="form-control" id="Harvestlongevity" name="Harvestlongevity" placeholder="Harvest Longevity (days)" value="<?php echo $get_single_evaluation['Harvestlongevity']; ?>">

  <span class="help-block"><?php if($error['Harvestlongevity']!=''){ echo $error['Harvestlongevity']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsettingunderlowtemperature']!=''){ echo 'has-error'; } ?>" id="InputFruitsettingunderlowtemperature">

  <label for="" class="">Fruit setting under low temp.</label>

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

  <label for="" class="">Fruit setting under high temp.</label>

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

<div class="form-group <?php if($error['DiseaseTolerance']!=''){ echo 'has-error'; } ?>" id="InputDiseaseTolerance">

  <label for="" class="required">Disease Tolerance</label>

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

<div class="form-group <?php if($error['PostHarvestQuality']!=''){ echo 'has-error'; } ?>" id="InputPostHarvestQuality">

  <label for="" class="required">Post Harvest Quality</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($PostHarvestQuality as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['PostHarvestQuality']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="PostHarvestQuality<?php echo $key; ?>" name="PostHarvestQuality" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="PostHarvestQuality<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['PostHarvestQuality']!=''){ echo $error['PostHarvestQuality']; } ?></span>

</div>

<div class="form-group <?php if($error['Yieldcontinuity']!=''){ echo 'has-error'; } ?>" id="InputYieldcontinuity">

  <label for="" class="required">YIELD: continuity of yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Yieldcontinuity_squash as $key => $value){ ?>

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

<div class="form-group <?php if($error['EarlyYield']!=''){ echo 'has-error'; } ?>" id="InputEarlyYield">

  <label for="" class="required">Early Yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($EarlyYield as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['EarlyYield']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="EarlyYield<?php echo $key; ?>" name="EarlyYield" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="EarlyYield<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['EarlyYield']!=''){ echo $error['EarlyYield']; } ?></span>

</div>

<div class="form-group <?php if($error['TotalYield']!=''){ echo 'has-error'; } ?>" id="InputTotalYield">

  <label for="" class="required">Total Yield</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($TotalYield as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['TotalYield']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="TotalYield<?php echo $key; ?>" name="TotalYield" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="TotalYield<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['TotalYield']!=''){ echo $error['TotalYield']; } ?></span>

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