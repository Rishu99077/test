<div class="form-group <?php if($error['Varietytype']!=''){ echo 'has-error'; } ?>" id="InputVarietytype">

  <label for="" class="required">Variety type</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Varietytype_kohlrabi as $key => $value){ ?>

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

  <?php foreach ($Plantvigur_kohlrabi as $key => $value){ ?>

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

  <?php foreach ($Harvesting_kohlrabi as $key => $value){ ?>

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



<div class="form-group <?php if($error['Planthabit']!=''){ echo 'has-error'; } ?>" id="InputPlanthabit">

  <label for="" class="required">Plant habit</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Planthabit_kohlrabi as $key => $value){ ?>

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



<div class="form-group <?php if($error['Toplength']!=''){ echo 'has-error'; } ?>" id="InputToplength">

  <label for="" class="required">Top length (cm) </label>

  <input type="text" class="form-control" id="Toplength" name="Toplength" placeholder="Top length (cm)" value="<?php echo $get_single_evaluation['Toplength']; ?>">

  <span class="help-block"><?php if($error['Toplength']!=''){ echo $error['Toplength']; } ?></span>

</div>



<div class="form-group <?php if($error['Leafcolour']!=''){ echo 'has-error'; } ?>" id="InputLeafcolour">

  <label for="" class="required">Leaf colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Leafcolour_kohlrabi as $key => $value){ ?>

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



<div class="form-group <?php if($error['Boltingresistance']!=''){ echo 'has-error'; } ?>" id="InputBoltingresistance">

  <label for="" class="">Bolting resist./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Boltingresistance_kohlrabi as $key => $value){ ?>

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



<div class="form-group <?php if($error['Rootshape']!=''){ echo 'has-error'; } ?>" id="InputRootshape">

  <label for="" class="required">Root shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rootshape_kohlrabi as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Rootshape']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Rootshape<?php echo $key; ?>" name="Rootshape" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Rootshape<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Rootshape']!=''){ echo $error['Rootshape']; } ?></span>

  <br>

  <img src="<?php echo base_url() ?>adminasset/images/Kohlrabi.png" style="width: 100%;">

</div>



<div class="form-group <?php if($error['RootExternalcolor']!=''){ echo 'has-error'; } ?>" id="InputRootExternalcolor">

  <label for="" class="required">Root external colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($RootExternalcolor_kohlrabi as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['RootExternalcolor']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="RootExternalcolor<?php echo $key; ?>" name="RootExternalcolor" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="RootExternalcolor<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['RootExternalcolor']!=''){ echo $error['RootExternalcolor']; } ?></span>

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



<div class="form-group <?php if($error['RootSmoothness']!=''){ echo 'has-error'; } ?>" id="InputRootSmoothness">

  <label for="" class="required">Skin smoothness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($RootSmoothness_kohlrabi as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['RootSmoothness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="RootSmoothness<?php echo $key; ?>" name="RootSmoothness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="RootSmoothness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['RootSmoothness']!=''){ echo $error['RootSmoothness']; } ?></span>

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



<div class="form-group <?php if($error['Heatresittol']!=''){ echo 'has-error'; } ?>" id="InputHeatresittol">

  <label for="" class="">Heat / Cold resist./tol.</label>

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