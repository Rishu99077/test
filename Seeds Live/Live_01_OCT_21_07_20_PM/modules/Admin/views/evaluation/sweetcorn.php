<div class="form-group <?php if($error['Varietytype']!=''){ echo 'has-error'; } ?>" id="InputVarietytype">

  <label for="" class="required">Variety type</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Varietytype_sweetcorn as $key => $value){ ?>

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

  <label for="" class="required">Plant: vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_sweetcorn as $key => $value){ ?>

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

  <label for="" class="required">Maturity (vs control)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Maturityvscontrol_sweetcorn as $key => $value){ ?>

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

<div class="form-group <?php if($error['Plantheight']!=''){ echo 'has-error'; } ?>" id="InputPlantheight">

  <label for="" class="required">Plant height (cm)</label>

  <input type="text" class="form-control" id="Plantheight" name="Plantheight" placeholder="Plant height (cm)" value="<?php echo $get_single_evaluation['Plantheight']; ?>">

  <span class="help-block"><?php if($error['Plantheight']!=''){ echo $error['Plantheight']; } ?></span>

</div>

<div class="form-group <?php if($error['Anthocyanin']!=''){ echo 'has-error'; } ?>" id="InputAnthocyanin">

  <label for="" class="required">Anthocyanin (leaf/stem)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Anthocyanin as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Anthocyanin']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Anthocyanin<?php echo $key; ?>" name="Anthocyanin" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Anthocyanin<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Anthocyanin']!=''){ echo $error['Anthocyanin']; } ?></span>

</div>

<div class="form-group <?php if($error['Firstearheight']!=''){ echo 'has-error'; } ?>" id="InputFirstearheight">

  <label for="" class="required">First ear height (cm)</label>

  <input type="text" class="form-control" id="Firstearheight" name="Firstearheight" placeholder="First ear height (cm)" value="<?php echo $get_single_evaluation['Firstearheight']; ?>">

  <span class="help-block"><?php if($error['Firstearheight']!=''){ echo $error['Firstearheight']; } ?></span>

</div>

<div class="form-group <?php if($error['Earhuskleafcolor']!=''){ echo 'has-error'; } ?>" id="InputEarhuskleafcolor">

  <label for="" class="required">Ear husk leaf color</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Earhuskleafcolor as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Earhuskleafcolor']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Earhuskleafcolor<?php echo $key; ?>" name="Earhuskleafcolor" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Earhuskleafcolor<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Earhuskleafcolor']!=''){ echo $error['Earhuskleafcolor']; } ?></span>

</div>

<div class="form-group <?php if($error['Flagleavesappearanceonear']!=''){ echo 'has-error'; } ?>" id="InputFlagleavesappearanceonear">

  <label for="" class="required">Flag leaves appearance on ear</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Flagleavesappearanceonear as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Flagleavesappearanceonear']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Flagleavesappearanceonear<?php echo $key; ?>" name="Flagleavesappearanceonear" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Flagleavesappearanceonear<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Flagleavesappearanceonear']!=''){ echo $error['Flagleavesappearanceonear']; } ?></span>

</div>

<div class="form-group <?php if($error['Earlength']!=''){ echo 'has-error'; } ?>" id="InputEarlength">

  <label for="" class="required">Ear length (cm)</label>

  <input type="text" class="form-control" id="Earlength" name="Earlength" placeholder="Ear length (cm)" value="<?php echo $get_single_evaluation['Earlength']; ?>">

  <span class="help-block"><?php if($error['Earlength']!=''){ echo $error['Earlength']; } ?></span>

</div>

<div class="form-group <?php if($error['Eardiameter']!=''){ echo 'has-error'; } ?>" id="InputEardiameter">

  <label for="" class="required">Ear diameter -in middle (cm)</label>

  <input type="text" class="form-control" id="Eardiameter" name="Eardiameter" placeholder="Ear diameter -in middle (cm)" value="<?php echo $get_single_evaluation['Eardiameter']; ?>">

  <span class="help-block"><?php if($error['Eardiameter']!=''){ echo $error['Eardiameter']; } ?></span>

</div>

<div class="form-group <?php if($error['Corncoblength']!=''){ echo 'has-error'; } ?>" id="InputCorncoblength">

  <label for="" class="required">Corn cob length(cm)</label>

  <input type="text" class="form-control" id="Corncoblength" name="Corncoblength" placeholder="Corn cob length(cm)" value="<?php echo $get_single_evaluation['Corncoblength']; ?>">

  <span class="help-block"><?php if($error['Corncoblength']!=''){ echo $error['Corncoblength']; } ?></span>

</div>

<div class="form-group <?php if($error['Numberofears']!=''){ echo 'has-error'; } ?>" id="InputNumberofears">

  <label for="" class="required">Number of ears Per plant</label>

  <input type="text" class="form-control" id="Numberofears" name="Numberofears" placeholder="Number of ears per plan" value="<?php echo $get_single_evaluation['Numberofears']; ?>">

  <span class="help-block"><?php if($error['Numberofears']!=''){ echo $error['Numberofears']; } ?></span>

</div>

<div class="form-group <?php if($error['EarProtection']!=''){ echo 'has-error'; } ?>" id="InputEarProtection">

  <label for="" class="required">Ear Protection</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($EarProtection as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['EarProtection']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="EarProtection<?php echo $key; ?>" name="EarProtection" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="EarProtection<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['EarProtection']!=''){ echo $error['EarProtection']; } ?></span>

</div>

<div class="form-group <?php if($error['Averagenumberofrows']!=''){ echo 'has-error'; } ?>" id="InputAveragenumberofrows">

  <label for="" class="required">Average number of rows/ear</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Averagenumberofrows as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Averagenumberofrows']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Averagenumberofrows<?php echo $key; ?>" name="Averagenumberofrows" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Averagenumberofrows<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Averagenumberofrows']!=''){ echo $error['Averagenumberofrows']; } ?></span>

</div>

<div class="form-group <?php if($error['Seedcolour']!=''){ echo 'has-error'; } ?>" id="InputSeedcolour">

  <label for="" class="required">Seed colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Seedcolour as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Seedcolour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Seedcolour<?php echo $key; ?>" name="Seedcolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Seedcolour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Seedcolour']!=''){ echo $error['Seedcolour']; } ?></span>

</div>

<div class="form-group <?php if($error['Tipfilling']!=''){ echo 'has-error'; } ?>" id="InputTipfilling">

  <label for="" class="required">Tip filling

Tip fill is the percentage of 5 ears with full tips</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Tipfilling as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Tipfilling']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Tipfilling<?php echo $key; ?>" name="Tipfilling" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Tipfilling<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Tipfilling']!=''){ echo $error['Tipfilling']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruittaste']!=''){ echo 'has-error'; } ?>" id="InputFruittaste">

  <label for="" class="required">Taste</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruittaste as $key => $value){ ?>

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

<div class="form-group <?php if($error['Harvesting']!=''){ echo 'has-error'; } ?>" id="InputHarvesting">

  <label for="" class="required">Harvesting</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Harvesting as $key => $value){ ?>

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

<div class="form-group <?php if($error['Kerneltenderness']!=''){ echo 'has-error'; } ?>" id="InputKerneltenderness">

  <label for="" class="required">Kernel tenderness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Kerneltenderness as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Kerneltenderness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Kerneltenderness<?php echo $key; ?>" name="Kerneltenderness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Kerneltenderness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Kerneltenderness']!=''){ echo $error['Kerneltenderness']; } ?></span>

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

  <?php foreach ($Rating_sweetcorn as $key => $value){ ?>

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