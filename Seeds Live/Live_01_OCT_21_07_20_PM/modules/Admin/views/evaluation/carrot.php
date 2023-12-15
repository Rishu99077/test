<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_carrot as $key => $value){ ?>

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

  <?php foreach ($Maturity_carrot as $key => $value){ ?>

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

  <label for="" class="required">PLANT:Top  growth  height</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Growthheight_carrot as $key => $value){ ?>

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





<div class="form-group <?php if($error['DiameteratMidpoint']!=''){ echo 'has-error'; } ?>" id="InputDiameteratMidpoint">

  <label for="" class="required">Diameter at Midpoint (mm) </label>

  <input type="text" class="form-control" id="DiameteratMidpoint" name="DiameteratMidpoint" placeholder="Diameter at Midpoint (mm)" value="<?php echo $get_single_evaluation['DiameteratMidpoint']; ?>">

  <span class="help-block"><?php if($error['DiameteratMidpoint']!=''){ echo $error['DiameteratMidpoint']; } ?></span>

</div>

<div class="form-group <?php if($error['Carrotlength']!=''){ echo 'has-error'; } ?>" id="InputCarrotlength">

  <label for="" class="required"> length (cm)</label>

  <input type="text" class="form-control" id="Carrotlength" name="Carrotlength" placeholder=" length (cm)" value="<?php echo $get_single_evaluation['Carrotlength']; ?>">

  <span class="help-block"><?php if($error['Carrotlength']!=''){ echo $error['Carrotlength']; } ?></span>

</div>

<div class="form-group <?php if($error['Carrotweight']!=''){ echo 'has-error'; } ?>" id="InputCarrotweight">

  <label for="" class="required"> weight (gr) Measure at least 10 fruits which represent majority of fruits</label>

  <input type="text" class="form-control" id="Carrotweight" name="Carrotweight" placeholder="weight (gr)" value="<?php echo $get_single_evaluation['Carrotweight']; ?>">

  <span class="help-block"><?php if($error['Carrotweight']!=''){ echo $error['Carrotweight']; } ?></span>

</div>

<div class="form-group <?php if($error['Rootshape']!=''){ echo 'has-error'; } ?>" id="InputRootshape">

  <label for="" class="required">Root shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rootshape_carrot as $key => $value){ ?>

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

</div>

<div class="form-group <?php if($error['RootSmoothness']!=''){ echo 'has-error'; } ?>" id="InputRootSmoothness">

  <label for="" class="required">Root Smoothness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($RootSmoothness as $key => $value){ ?>

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

<div class="form-group <?php if($error['Shouldershape']!=''){ echo 'has-error'; } ?>" id="InputShouldershape">

  <label for="" class="required">Shoulder shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Shouldershape_carrot as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Shouldershape']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Shouldershape<?php echo $key; ?>" name="Shouldershape" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Shouldershape<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Shouldershape']!=''){ echo $error['Shouldershape']; } ?></span>

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



<div class="form-group <?php if($error['RootExternalcolor']!=''){ echo 'has-error'; } ?>" id="InputRootExternalcolor">

  <label for="" class="required">Root: External color</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($RootExternalcolor as $key => $value){ ?>

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

<div class="form-group <?php if($error['Coresize']!=''){ echo 'has-error'; } ?>" id="InputCoresize">

  <label for="" class="required">Root Core size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Coresize_carrot as $key => $value){ ?>

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

<div class="form-group <?php if($error['Shoulderspurplinggreen']!=''){ echo 'has-error'; } ?>" id="InputShoulderspurplinggreen">

  <label for="" class="required">Shoulders (purpling/green)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Shoulderspurplinggreen as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Shoulderspurplinggreen']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Shoulderspurplinggreen<?php echo $key; ?>" name="Shoulderspurplinggreen" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Shoulderspurplinggreen<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Shoulderspurplinggreen']!=''){ echo $error['Shoulderspurplinggreen']; } ?></span>

</div>

<div class="form-group <?php if($error['SplittingBreakagetolerance']!=''){ echo 'has-error'; } ?>" id="InputSplittingBreakagetolerance" style="display: none;" >

  <label for="" class="required">Splitting & Breakage tolerance</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($SplittingBreakagetolerance as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['SplittingBreakagetolerance']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="SplittingBreakagetolerance<?php echo $key; ?>" name="SplittingBreakagetolerance" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="SplittingBreakagetolerance<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['SplittingBreakagetolerance']!=''){ echo $error['SplittingBreakagetolerance']; } ?></span>

</div>

<div class="form-group <?php if($error['Boltingresistance']!=''){ echo 'has-error'; } ?>" id="InputBoltingresistance">

  <label for="" class="">Bolting resistance</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Boltingresistance_carrot as $key => $value){ ?>

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

<div class="form-group <?php if($error['Alternariapminfection']!=''){ echo 'has-error'; } ?>" id="InputAlternariapminfection">

  <label for="" class="required">Alternaria/PM Infection</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Alternariapminfection as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Alternariapminfection']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Alternariapminfection<?php echo $key; ?>" name="Alternariapminfection" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Alternariapminfection<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Alternariapminfection']!=''){ echo $error['Alternariapminfection']; } ?></span>

</div>



<div class="form-group <?php if($error['Crackingroot']!=''){ echo 'has-error'; } ?>" id="InputCrackingroot">

  <label for="" class="required">Cracking root</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Crackingroot as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Crackingroot']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Crackingroot<?php echo $key; ?>" name="Crackingroot" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Crackingroot<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Crackingroot']!=''){ echo $error['Crackingroot']; } ?></span>

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

  <?php foreach ($Rating_carrot as $key => $value){ ?>

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