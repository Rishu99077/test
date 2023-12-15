<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Plant: Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_watermelon as $key => $value){ ?>

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

<div class="form-group <?php if($error['PlantCover']!=''){ echo 'has-error'; } ?>" id="InputPlantCover">

  <label for="" class="required">Plant: Cover</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($PlantCover_watermelon as $key => $value){ ?>

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

<div class="form-group <?php if($error['Maturityvscontrol']!=''){ echo 'has-error'; } ?>" id="InputYield">

  <label for="" class="required">Fruit: Maturity (vs control)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Maturityvscontrol_watermelon as $key => $value){ ?>

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

<div class="form-group <?php if($error['Maturity']!=''){ echo 'has-error'; } ?>" id="InputMaturity">

  <label for="" class="required">Fruit: Maturity Number of Days from sowing/transplanting day to the day most of the fruits are harvestable</label>

  <input type="text" class="form-control" id="Maturity" name="Maturity" placeholder="Fruit: Maturity" value="<?php echo $get_single_evaluation['Maturity']; ?>">

  <span class="help-block"><?php if($error['Maturity']!=''){ echo $error['Maturity']; } ?></span>

</div>

<div class="form-group <?php if($error['FruitRindPattern']!=''){ echo 'has-error'; } ?>" id="InputFruitRindPattern">

  <label for="" class="required">Fruit : Rind Pattern</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($FruitRindPattern as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['FruitRindPattern']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="FruitRindPattern<?php echo $key; ?>" name="FruitRindPattern" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="FruitRindPattern<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['FruitRindPattern']!=''){ echo $error['FruitRindPattern']; } ?></span>

</div>

<div class="form-group <?php if($error['RindAttractivness']!=''){ echo 'has-error'; } ?>" id="InputRindAttractivness">

  <label for="" class="required">Rind Attractivness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($RindAttractivness as $key => $value){ ?>

    <?php 

      if($cnt=='1' && $get_single_evaluation['RindAttractivness']==''){

        $checked = 'checked="checked"';

      }elseif($get_single_evaluation['RindAttractivness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="RindAttractivness<?php echo $key; ?>" name="RindAttractivness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="RindAttractivness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['RindAttractivness']!=''){ echo $error['RindAttractivness']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitshape']!=''){ echo 'has-error'; } ?>" id="InputFruitshape">

  <label for="" class="required">Fruit: Shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruitshape_watermelon as $key => $value){ ?>

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

  <?php foreach ($Fruitsizeuniformity_watermelon as $key => $value){ ?>

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

  <label for="" class="required">Fruit : shape uniformity</label>

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

<div class="form-group <?php if($error['Fruitweight']!=''){ echo 'has-error'; } ?>" id="InputFruitweight">

  <label for="" class="required">Fruit: Average fruit weight (kg)</label>

  <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="Fruit: Average fruit weight (kg)" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">

  <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>

</div>

<div class="form-group <?php if($error['FruitSize']!=''){ echo 'has-error'; } ?>" id="InputFruitSize">

  <label for="" class="required">Fruit: Size (LxD cm)</label>

  <input type="text" class="form-control" id="FruitSize" name="FruitSize" placeholder="Fruit: Size (LxD cm)" value="<?php echo $get_single_evaluation['FruitSize']; ?>">

  <span class="help-block"><?php if($error['FruitSize']!=''){ echo $error['FruitSize']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitrindthickness']!=''){ echo 'has-error'; } ?>" id="InputFruitrindthickness">

  <label for="" class="required">Fruit: rind thickness (mm) Meausre rind thickness of 3 -5 fruits by cm and calculate average</label>

  <input type="text" class="form-control" id="Fruitrindthickness" name="Fruitrindthickness" placeholder="Fruit: rind thickness (mm) Meausre rind thickness of 3 -5 fruits by cm and calculate average" value="<?php echo $get_single_evaluation['Fruitrindthickness']; ?>">

  <span class="help-block"><?php if($error['Fruitrindthickness']!=''){ echo $error['Fruitrindthickness']; } ?></span>

</div>

<div class="form-group <?php if($error['Brix']!=''){ echo 'has-error'; } ?>" id="InputBrix">

  <label for="" class="">Brix%: Measure by refractometer middle section of at least 3-5 full ripen fruits and calculate the average</label>

  <input type="text" class="form-control" id="Brix" name="Brix" placeholder="Brix%: Measure by refractometer middle section of at least 3-5 full ripen fruits and calculate the average" value="<?php echo $get_single_evaluation['Brix']; ?>">

  <span class="help-block"><?php if($error['Brix']!=''){ echo $error['Brix']; } ?></span>

</div>

<div class="form-group <?php if($error['Fleshcolor']!=''){ echo 'has-error'; } ?>" id="InputFleshcolor">

  <label for="" class="required">Fruit: Flesh color</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fleshcolor_watermelon as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fleshcolor']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fleshcolor<?php echo $key; ?>" name="Fleshcolor" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fleshcolor<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fleshcolor']!=''){ echo $error['Fleshcolor']; } ?></span>

</div>

<div class="form-group <?php if($error['Fleshfirmness']!=''){ echo 'has-error'; } ?>" id="InputFleshfirmness">

  <label for="" class="required">Flesh Firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fleshfirmness_watermelon as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Fleshfirmness']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Fleshfirmness<?php echo $key; ?>" name="Fleshfirmness" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Fleshfirmness<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Fleshfirmness']!=''){ echo $error['Fleshfirmness']; } ?></span>

</div>

<div class="form-group <?php if($error['HollowHeartSeverity']!=''){ echo 'has-error'; } ?>" id="InputHollowHeartSeverity">

  <label for="" class="required">Hollow Heart Severity</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($HollowHeartSeverity as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['HollowHeartSeverity']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="HollowHeartSeverity<?php echo $key; ?>" name="HollowHeartSeverity" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="HollowHeartSeverity<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['HollowHeartSeverity']!=''){ echo $error['HollowHeartSeverity']; } ?></span>

</div>

<div class="form-group <?php if($error['SeedsSize']!=''){ echo 'has-error'; } ?>" id="InputSeedsSize">

  <label for="" class="required">Seeds Size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($SeedsSize as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['SeedsSize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="SeedsSize<?php echo $key; ?>" name="SeedsSize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="SeedsSize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['SeedsSize']!=''){ echo $error['SeedsSize']; } ?></span>

</div>

<div class="form-group <?php if($error['SeedsContent']!=''){ echo 'has-error'; } ?>" id="InputSeedsContent">

  <label for="" class="required">Seeds Content</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($SeedsContent as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['SeedsContent']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="SeedsContent<?php echo $key; ?>" name="SeedsContent" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="SeedsContent<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['SeedsContent']!=''){ echo $error['SeedsContent']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruittaste']!=''){ echo 'has-error'; } ?>" id="InputFruittaste">

  <label for="" class="required">Taste</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Fruittaste_watermelon as $key => $value){ ?>

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

<div class="form-group <?php if($error['Fruitsplant']!=''){ echo 'has-error'; } ?>" id="InputFruitsplant">

  <label for="" class="required">Fruits/Plant:Calculate automatically and indicate plant setting/Yeild</label>

  <input type="text" class="form-control" id="Fruitsplant" name="Fruitsplant" placeholder="Fruits/Plant: Calculate automatically and indicate plant setting/Yeild" value="<?php echo $get_single_evaluation['Fruitsplant']; ?>">

  <span class="help-block"><?php if($error['Fruitsplant']!=''){ echo $error['Fruitsplant']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsmarketable']!=''){ echo 'has-error'; } ?>" id="InputFruitsmarketable">

  <label for="" class="required">Number of Marketable fruits per 10 m2</label>

  <input type="text" class="form-control" id="Fruitsmarketable" name="Fruitsmarketable" placeholder="Number of Marketable fruits per 10 m2" value="<?php echo $get_single_evaluation['Fruitsmarketable']; ?>">

  <span class="help-block"><?php if($error['Fruitsmarketable']!=''){ echo $error['Fruitsmarketable']; } ?></span>

</div>

<div class="form-group <?php if($error['Fruitsmarketableplot']!=''){ echo 'has-error'; } ?>" id="InputFruitsmarketableplot">

  <label for="" class="">Number of Marketable Fruits in each plot</label>

  <input type="text" class="form-control" id="Fruitsmarketableplot" name="Fruitsmarketableplot" placeholder="Number of Marketable Fruits  in each plot" value="<?php echo $get_single_evaluation['Fruitsmarketableplot']; ?>">

  <span class="help-block"><?php if($error['Fruitsmarketableplot']!=''){ echo $error['Fruitsmarketableplot']; } ?></span>

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

<div class="form-group <?php if($error['Shelflife']!=''){ echo 'has-error'; } ?>" id="InputShelflife">

  <label for="" class="required">Shelf life</label>

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

<div class="form-group <?php if($error['Diseasespest']!=''){ echo 'has-error'; } ?>" id="InputDiseasespest">

  <label for="" class="required">Pests & Disease (Remark which)</label>

  <input type="text" class="form-control" id="Diseasespest" name="Diseasespest" placeholder="Pests & Disease (Remark which)" value="<?php echo $get_single_evaluation['Diseasespest']; ?>">

  <span class="help-block"><?php if($error['Diseasespest']!=''){ echo $error['Diseasespest']; } ?></span>

</div>

<div class="form-group <?php if($error['Rating']!=''){ echo 'has-error'; } ?>" id="InputRating">

  <label for="" class="required">Rating</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rating_watermelon as $key => $value){ ?>

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

<!-- <div class="form-group <?php if($error['Comment']!=''){ echo 'has-error'; } ?>" id="InputComment">

  <label for="" class="">Comment</label>

  <textarea  type="text" class="form-control" id="Comment" name="Comment" placeholder="Comment" ><?php echo $get_single_evaluation['Comment']; ?></textarea>

  <span class="help-block"><?php if($error['Comment']!=''){ echo $error['Comment']; } ?></span>

</div> -->