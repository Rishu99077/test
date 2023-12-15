<div class="form-group <?php if($error['Typeofcultivation']!=''){ echo 'has-error'; } ?>" id="InputTypeofcultivation">

  <label for="" class="required">Type of cultivation </label>

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

  <label for="" class="required">Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_okra as $key => $value){ ?>

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

  <label for="" class="required">Harvesting (maturity) vs control</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Harvesting_okra as $key => $value){ ?>

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



<div class="form-group <?php if($error['Growthtype']!=''){ echo 'has-error'; } ?>" id="InputGrowthtype">

  <label for="" class="required"> Plant growth type  </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Growthtype_okra as $key => $value){ ?>

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



<div class="form-group <?php if($error['Growthheight']!=''){ echo 'has-error'; } ?>" id="InputGrowthheight" style="display: none;">

  <label for="" class="required">PLANT: growth height</label>

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

  <label for="" class="required">PLANT: Internode length </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($InternodesLength_okra as $key => $value){ ?>

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

  <label for="" class="required">Pod : Fruit shape </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitshape_okra as $key => $value){ ?>

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



<div class="form-group <?php if($error['Friutlength']!=''){ echo 'has-error'; } ?>" id="InputFriutlength">

  <label for="" class="required">Pod: Fruit length (cm)  </label>

  <input type="text" class="form-control" id="Friutlength" name="Friutlength" placeholder="Pod: Fruit length (cm) " value="<?php echo $get_single_evaluation['Friutlength']; ?>">

  <span class="help-block"><?php if($error['Friutlength']!=''){ echo $error['Friutlength']; } ?></span>

</div>



<div class="form-group <?php if($error['Fruitcolouratmaturity']!=''){ echo 'has-error'; } ?>" id="InputFruitcolouratmaturity">

  <label for="" class="required">Pod: Fruit colour at maturity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitcolouratmaturity_okra as $key => $value){ ?>

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



<div class="form-group <?php if($error['Skinsmoothness']!=''){ echo 'has-error'; } ?>" id="InputSkinsmoothness">

  <label for="" class="required">Skin smoothness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Skinsmoothness_okra as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Skinsmoothness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Skinsmoothness<?php echo $key; ?>" name="Skinsmoothness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Skinsmoothness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Skinsmoothness']!=''){ echo $error['Skinsmoothness']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">

  <label for="" class="required">Pod:Fruit size uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitsizeuniformity_okra as $key => $value){ ?>

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



<div class="form-group <?php if($error['Spinedevelopment']!=''){ echo 'has-error'; } ?>" id="InputSpinedevelopment">

  <label for="" class="required">Pod: Spine development </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Spinedevelopment as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Spinedevelopment']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Spinedevelopment<?php echo $key; ?>" name="Spinedevelopment" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Spinedevelopment<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Spinedevelopment']!=''){ echo $error['Spinedevelopment']; } ?></span>

</div>



<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="required">Pod: Firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness_okra as $key => $value){ ?>

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

  <?php foreach ($Yieldcontinuity_okra as $key => $value){ ?>

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