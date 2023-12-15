<div class="form-group <?php if($error['Varietytype']!=''){ echo 'has-error'; } ?>" id="InputVarietytype">

  <label for="" class="required">Variety type</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Varietytype as $key => $value){ ?>

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

  <label for="" class="required">Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_lettuce as $key => $value){ ?>

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

  <label for="" class="required">Maturity vs control</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Maturityvscontrol_lettuce as $key => $value){ ?>

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

<div class="form-group <?php if($error['Headformation']!=''){ echo 'has-error'; } ?>" id="InputHeadformation">

  <label for="" class="required">Head formation</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headformation_lettuce as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Headformation']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Headformation<?php echo $key; ?>" name="Headformation" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Headformation<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Headformation']!=''){ echo $error['Headformation']; } ?></span>

</div>

<div class="form-group <?php if($error['Leafcolour']!=''){ echo 'has-error'; } ?>" id="InputLeafcolour">

  <label for="" class="required">Leaf colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Leafcolour as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Leafcolour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Leafcolour<?php echo $key; ?>" name="Leafcolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Leafcolour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Leafcolour']!=''){ echo $error['Leafcolour']; } ?></span>

</div>

<div class="form-group <?php if($error['Headsize']!=''){ echo 'has-error'; } ?>" id="InputHeadsize">

  <label for="" class="required">Head size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headsize as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Headsize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Headsize<?php echo $key; ?>" name="Headsize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Headsize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Headsize']!=''){ echo $error['Headsize']; } ?></span>

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

<div class="form-group <?php if($error['Headuniformity']!=''){ echo 'has-error'; } ?>" id="InputHeaduniformity">

  <label for="" class="required">Head uniformity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Headuniformity_lettuce as $key => $value){ ?>

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

<div class="form-group <?php if($error['Fruitweight']!=''){ echo 'has-error'; } ?>" id="InputFruitweight">

  <label for="" class="required">weight(gr)</label>

  <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="weight(gr)" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">

  <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>

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

<div class="form-group <?php if($error['Leaftexture']!=''){ echo 'has-error'; } ?>" id="InputLeaftexture">

  <label for="" class="required">Leaf texture</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Leaftexture as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Leaftexture']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Leaftexture<?php echo $key; ?>" name="Leaftexture" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Leaftexture<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Leaftexture']!=''){ echo $error['Leaftexture']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruittaste']!=''){ echo 'has-error'; } ?>" id="InputFruittaste">

  <label for="" class="required">Taste</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruittaste_lettuce as $key => $value){ ?>

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

<div class="form-group <?php if($error['Fieldstandingability']!=''){ echo 'has-error'; } ?>" id="InputFieldstandingability">

  <label for="" class="required">Field standing ability</label>

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



<div class="form-group <?php if($error['HeatColdresisttol']!=''){ echo 'has-error'; } ?>" id="InputHeatColdresisttol">

  <label for="" class="required">Heat / Cold resist./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Heatresittol as $key => $value){ ?>

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







<div class="form-group <?php if($error['Boltingresistance']!=''){ echo 'has-error'; } ?>" id="InputBoltingresistance">

  <label for="" class="required">Bolting resist./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Boltingresistance_lettuce as $key => $value){ ?>

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

<div class="form-group <?php if($error['VisualYield']!=''){ echo 'has-error'; } ?>" id="InputVisualYield">

  <label for="" class="required">Yield (Visual)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($VisualYield as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['VisualYield']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="VisualYield<?php echo $key; ?>" name="VisualYield" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="VisualYield<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['VisualYield']!=''){ echo $error['VisualYield']; } ?></span>

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