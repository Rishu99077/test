<div class="form-group <?php if($error['Varietytype']!=''){ echo 'has-error'; } ?>" id="InputVarietytype">

  <label for="" class="">Variety type</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Varietytype_beans as $key => $value){ ?>

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



<div class="form-group <?php if($error['Marketsegment']!=''){ echo 'has-error'; } ?>" id="InputMarketsegment">

  <label for="" class="required">Market segment </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Marketsegment_beans as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Marketsegment']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Marketsegment<?php echo $key; ?>" name="Marketsegment" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Marketsegment<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Marketsegment']!=''){ echo $error['Marketsegment']; } ?></span>

</div>



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

  <label for="" class="required">Vigor </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_beans as $key => $value){ ?>

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

  <?php foreach ($Harvesting_beans as $key => $value){ ?>

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



<div class="form-group <?php if($error['Growthtype']!=''){ echo 'has-error'; } ?>" id="InputGrowthtype">

  <label for="" class="required"> Plant growth type  </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Growthtype_beans as $key => $value){ ?>

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







<div class="form-group <?php if($error['Flowercolour']!=''){ echo 'has-error'; } ?>" id="InputFlowercolour">

  <label for="" class="required"> Flower colour </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Flowercolour as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Flowercolour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Flowercolour<?php echo $key; ?>" name="Flowercolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Flowercolour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Flowercolour']!=''){ echo $error['Flowercolour']; } ?></span>

</div>



<div class="form-group <?php if($error['Podcrosssection']!=''){ echo 'has-error'; } ?>" id="InputPodcrosssection">

  <label for="" class="required"> Pod cross section </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Podcrosssection as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Podcrosssection']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Podcrosssection<?php echo $key; ?>" name="Podcrosssection" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Podcrosssection<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Podcrosssection']!=''){ echo $error['Podcrosssection']; } ?></span>

</div>



<div class="form-group <?php if($error['Podlength']!=''){ echo 'has-error'; } ?>" id="InputPodlength">

  <label for="" class="required">Pod length (cm) </label>

  <input type="text" class="form-control" id="Podlength" name="Podlength" placeholder="Pod length (cm)" value="<?php echo $get_single_evaluation['Podlength']; ?>">

  <span class="help-block"><?php if($error['Podlength']!=''){ echo $error['Podlength']; } ?></span>

</div>



<div class="form-group <?php if($error['Poddiameter']!=''){ echo 'has-error'; } ?>" id="InputPoddiameter">

  <label for="" class="required">Pod diameter (mm) </label>

  <input type="text" class="form-control" id="Poddiameter" name="Poddiameter" placeholder="Pod diameter (mm)" value="<?php echo $get_single_evaluation['Poddiameter']; ?>">

  <span class="help-block"><?php if($error['Poddiameter']!=''){ echo $error['Poddiameter']; } ?></span>

</div>



<div class="form-group <?php if($error['Stringless']!=''){ echo 'has-error'; } ?>" id="InputStringless">

  <label for="" class="required"> Stringless </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Stringless as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Stringless']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Stringless<?php echo $key; ?>" name="Stringless" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Stringless<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Stringless']!=''){ echo $error['Stringless']; } ?></span>

</div>





<div class="form-group <?php if($error['Primarypodcolour']!=''){ echo 'has-error'; } ?>" id="InputPrimarypodcolour">

  <label for="" class="required"> Primary pod colour </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Primarypodcolour as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['Primarypodcolour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Primarypodcolour<?php echo $key; ?>" name="Primarypodcolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Primarypodcolour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Primarypodcolour']!=''){ echo $error['Primarypodcolour']; } ?></span>

</div>





<div class="form-group <?php if($error['Seedcolour']!=''){ echo 'has-error'; } ?>" id="InputSeedcolour">

  <label for="" class="required"> Seed colour </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Seedcolour_beans as $key => $value){ ?>

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



<div class="form-group <?php if($error['Cookingvalue']!=''){ echo 'has-error'; } ?>" id="InputCookingvalue">

  <label for="" class=""> Cooking value </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Cookingvalue as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Cookingvalue']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Cookingvalue<?php echo $key; ?>" name="Cookingvalue" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Cookingvalue<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Cookingvalue']!=''){ echo $error['Cookingvalue']; } ?></span>

</div>



<div class="form-group <?php if($error['Shelflife']!=''){ echo 'has-error'; } ?>" id="InputShelflife">

  <label for="" class=""> Shelf life </label>

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

  <label for="Rating<?php echo $value; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>



  <span class="help-block"><?php if($error['Rating']!=''){ echo $error['Rating']; } ?></span>

</div>



<div class="form-group <?php if($error['Advantages']!=''){ echo 'has-error'; } ?>" id="InputAdvantages">

  <label for="" class="">Advantages</label>

  <textarea  type="text" class="form-control"  <?php if ($segment2 == 'evaluationview') { ?> readonly <?php } ?> id="Advantages" name="Advantages" placeholder="Advantages" ><?php echo $get_single_evaluation['Advantages']; ?></textarea>

  <span class="help-block"><?php if($error['Advantages']!=''){ echo $error['Advantages']; } ?></span>

</div>



<div class="form-group <?php if($error['Disadvantages']!=''){ echo 'has-error'; } ?>" id="InputDisadvantages">

  <label for="" class="">Disadvantages</label>

  <textarea  type="text" class="form-control"  <?php if ($segment2 == 'evaluationview') { ?> readonly <?php } ?> id="Disadvantages" name="Disadvantages" placeholder="Disadvantages" ><?php echo $get_single_evaluation['Disadvantages']; ?></textarea>

  <span class="help-block"><?php if($error['Disadvantages']!=''){ echo $error['Disadvantages']; } ?></span>

</div>



<div class="form-group <?php if($error['Remarks']!=''){ echo 'has-error'; } ?>" id="InputRemarks">

  <label for="" class="">Remarks - Text (120 char)</label>

  <textarea  type="text" class="form-control" <?php if ($segment2 == 'evaluationview') { ?> readonly <?php } ?> id="Remarks" name="Remarks" placeholder="Remarks - Text (120 char)" ><?php echo $get_single_evaluation['Remarks']; ?></textarea>

  <span class="help-block"><?php if($error['Remarks']!=''){ echo $error['Remarks']; } ?></span>

</div>