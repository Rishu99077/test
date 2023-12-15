<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">PLANT: vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_pepper as $key => $value){ ?>

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

  <label for="" class="required">PLANT: Maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Maturity_pepper as $key => $value){ ?>

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

<div class="form-group <?php if($error['Plantheight']!=''){ echo 'has-error'; } ?>" id="InputPlantheight">

  <label for="" class="required">Plant: growth height</label>

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

<div class="form-group <?php if($error['PlantCover']!=''){ echo 'has-error'; } ?>" id="InputPlantCover">

  <label for="" class="required">Plant: Cover</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($PlantCover as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['PlantCover']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="PlantCover<?php echo $key; ?>" name="PlantCover" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="PlantCover<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['PlantCover']!=''){ echo $error['PlantCover']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitshape']!=''){ echo 'has-error'; } ?>" id="InputFruitshape">

  <label for="" class="required">Fruit: shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitshape_pepper as $key => $value){ ?>

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

</div>

<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">

  <label for="" class="required">Fruit: size uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsizeuniformity_pepper as $key => $value){ ?>

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

<div class="form-group <?php if($error['Friutwidth']!=''){ echo 'has-error'; } ?>" id="InputFriutwidth">

  <label for="" class="required">Fruit:width(cm)</label>

  <input type="text" class="form-control" id="Friutwidth" name="Friutwidth" placeholder="Fruit:width(cm)" value="<?php echo $get_single_evaluation['Friutwidth']; ?>">

  <span class="help-block"><?php if($error['Friutwidth']!=''){ echo $error['Friutwidth']; } ?></span>

</div>

<div class="form-group <?php if($error['Friutlength']!=''){ echo 'has-error'; } ?>" id="InputFriutlength">

  <label for="" class="required">Fruit: length (cm)</label>

  <input type="text" class="form-control" id="Friutlength" name="Friutlength" placeholder="Fruit: length (cm)" value="<?php echo $get_single_evaluation['Friutlength']; ?>">

  <span class="help-block"><?php if($error['Friutlength']!=''){ echo $error['Friutlength']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitweight']!=''){ echo 'has-error'; } ?>" id="InputFruitweight">

  <label for="" class="required">Fruit: weight (gr)</label>

  <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="Fruit weight" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">

  <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitwallthickness']!=''){ echo 'has-error'; } ?>" id="InputFruitwallthickness">

  <label for="" class="required">Fruit: wall thickness in mm</label>

  <input type="text" class="form-control" id="Fruitwallthickness" name="Fruitwallthickness" placeholder="Fruit: wall thickness in mm" value="<?php echo $get_single_evaluation['Fruitwallthickness']; ?>">

  <span class="help-block"><?php if($error['Fruitwallthickness']!=''){ echo $error['Fruitwallthickness']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitintensityofcolourbeforematurity']!=''){ echo 'has-error'; } ?>" id="InputFruitintensityofcolourbeforematurity">

  <label for="" class="required">Fruit: intensity of colour before maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitintensityofcolourbeforematurity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitintensityofcolourbeforematurity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitintensityofcolourbeforematurity<?php echo $key; ?>" name="Fruitintensityofcolourbeforematurity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitintensityofcolourbeforematurity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitintensityofcolourbeforematurity']!=''){ echo $error['Fruitintensityofcolourbeforematurity']; } ?></span>



   <br>

   <img style="width: 100%;" src="<?php echo base_url() ?>adminasset/images/Fruitintensityofcolourbeforematurity.jpg">

</div>

<div class="form-group <?php if($error['Fruitcolouratmaturity']!=''){ echo 'has-error'; } ?>" id="InputFruitcolouratmaturity">

  <label for="" class="required">Fruit:colour at maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitcolouratmaturity as $key => $value){ ?>

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

<div class="form-group <?php if($error['Fruitintensityofcolouratmaturity']!=''){ echo 'has-error'; } ?>" id="InputFruitintensityofcolouratmaturity">

  <label for="" class="required">Fruit:  intensity of colour at maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitintensityofcolouratmaturity_pepper as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitintensityofcolouratmaturity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitintensityofcolouratmaturity<?php echo $key; ?>" name="Fruitintensityofcolouratmaturity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitintensityofcolouratmaturity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitintensityofcolouratmaturity']!=''){ echo $error['Fruitintensityofcolouratmaturity']; } ?></span>

</div>



<div class="form-group <?php if($error['Fruitglossiness']!=''){ echo 'has-error'; } ?>" id="InputFruitglossiness">

  <label for="" class="required">Fruit:Glossiness</label>

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

</div>

<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="required">Fruit: Firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness_pepper as $key => $value){ ?>

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

<div class="form-group <?php if($error['Yieldmarketablefrtsplnt']!=''){ echo 'has-error'; } ?>" id="InputYieldmarketablefrtsplnt">

  <label for="" class="required">YIELD: marketable frts/plnt.</label>

  <input type="text" class="form-control" id="Yieldmarketablefrtsplnt" name="Yieldmarketablefrtsplnt" placeholder="YIELD: marketable frts/plnt." value="<?php echo $get_single_evaluation['Yieldmarketablefrtsplnt']; ?>">

  <span class="help-block"><?php if($error['Yieldmarketablefrtsplnt']!=''){ echo $error['Yieldmarketablefrtsplnt']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitcracking']!=''){ echo 'has-error'; } ?>" id="InputFruitcracking">

  <label for="" class="required">FRUIT: cracking (all sorts)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitcracking_pepper as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fruitcracking']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fruitcracking<?php echo $key; ?>" name="Fruitcracking" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fruitcracking<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fruitcracking']!=''){ echo $error['Fruitcracking']; } ?></span>

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

  <?php foreach ($Yieldcontinuity_pepper as $key => $value){ ?>

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

  <?php foreach ($Yield_pepper as $key => $value){ ?>

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