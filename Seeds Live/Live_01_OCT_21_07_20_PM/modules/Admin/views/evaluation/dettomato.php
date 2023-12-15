<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">
   <label for="" class="required">Plant:Vigor</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Plantvigur_dettomato as $key => $value){ ?>
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
   <?php foreach ($PlantCover_dettomato as $key => $value){ ?>
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
<div class="form-group <?php if($error['Maturity']!=''){ echo 'has-error'; } ?>" id="InputMaturity">
   <label for="" class="required">Fruit: Maturity</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Maturity_dettomato as $key => $value){ ?>
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
<div style="display: none;" class="form-group <?php if($error['InternodesLength']!=''){ echo 'has-error'; } ?>" id="InputInternodesLength">
   <label for="" class="required">Internodes Length</label>
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
<div style="display: none;" class="form-group <?php if($error['LeafCurlingRolling']!=''){ echo 'has-error'; } ?>" id="InputLeafCurlingRolling">
   <label for="" class="required">Leaf Curling / Rolling</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($LeafCurlingRolling_dettomato as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['LeafCurlingRolling']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="LeafCurlingRolling<?php echo $key; ?>" name="LeafCurlingRolling" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="LeafCurlingRolling<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['LeafCurlingRolling']!=''){ echo $error['LeafCurlingRolling']; } ?></span>
</div>
<div style="display: none;" class="form-group <?php if($error['ParthenocarpicFruits']!=''){ echo 'has-error'; } ?>" id="InputParthenocarpicFruits">
   <label for="" class="required">Parthenocarpic Fruits (Ball fruits without seeds)</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($ParthenocarpicFruits as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['ParthenocarpicFruits']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="ParthenocarpicFruits<?php echo $key; ?>" name="ParthenocarpicFruits" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="ParthenocarpicFruits<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['ParthenocarpicFruits']!=''){ echo $error['ParthenocarpicFruits']; } ?></span>
</div>
<div style="display: none;" class="form-group <?php if($error['PlantBalance']!=''){ echo 'has-error'; } ?>" id="InputPlantBalance">
   <label for="" class="">Plant Balance</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($PlantBalance as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['PlantBalance']==$value){
      
         $checked = 'checked="checked"';
      
       }else{
      
         $checked = '';
      
       }
      
      ?>
   <input type="radio" class="formcontrol" id="PlantBalance<?php echo $key; ?>" name="PlantBalance" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="PlantBalance<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['PlantBalance']!=''){ echo $error['PlantBalance']; } ?></span>
</div>
<div class="form-group <?php if($error['Fruitsetting']!=''){ echo 'has-error'; } ?>" id="InputFruitsetting">
   <label for="" class="required">Fruit setting</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitsetting_dettomato as $key => $value){ ?>
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
<div style="display: none;"  class="form-group <?php if($error['Growthheight']!=''){ echo 'has-error'; } ?>" id="InputGrowthheight">
   <label for="" class="required">Plant: growth height</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Growthheight_dettomato as $key => $value){ ?>
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
<div class="form-group <?php if($error['Fruitshape']!=''){ echo 'has-error'; } ?>" id="InputFruitshape">
   <label for="" class="">Fruit : shape</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitshape_dettomato as $key => $value){ ?>
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
   <img style="width: 100%;" src="<?php echo base_url(); ?>adminasset/images/Det-tomato/de_tomato_shape.jpeg">
</div>
<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">
   <label for="" class="required">Fruit: size uniformity</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitsizeuniformity as $key => $value){ ?>
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

<div class="form-group <?php if($error['FruitRibbness']!=''){ echo 'has-error'; } ?>" id="InputFruitRibbness">
   <label for="" class="required">Fruit: Ribbness</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($FruitRibbness as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['FruitRibbness']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="FruitRibbness<?php echo $key; ?>" name="FruitRibbness" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="FruitRibbness<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['FruitRibbness']!=''){ echo $error['FruitRibbness']; } ?></span>
</div>
<div class="form-group <?php if($error['CalyxApperarance']!=''){ echo 'has-error'; } ?>" id="InputCalyxApperarance">
   <label for="" class="required">Fruit: Calyx Apperarance</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($CalyxApperarance_dettomato as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['CalyxApperarance']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="CalyxApperarance<?php echo $key; ?>" name="CalyxApperarance" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="CalyxApperarance<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['CalyxApperarance']!=''){ echo $error['CalyxApperarance']; } ?></span>
</div>
<div style="display: none;" class="form-group <?php if($error['Fruitcolourbeforematurity']!=''){ echo 'has-error'; } ?>" id="InputFruitcolourbeforematurity">
   <label for="" class="required">Fruit: intensity of colour before maturity</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitcolourmaturity_dettomato as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['Fruitcolourbeforematurity']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="Fruitcolourbeforematurity<?php echo $key; ?>" name="Fruitcolourbeforematurity" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="Fruitcolourbeforematurity<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['Fruitcolourbeforematurity']!=''){ echo $error['Fruitcolourbeforematurity']; } ?></span>
</div>
<div style="display: none;" class="form-group <?php if($error['Fruitcolouratmaturity']!=''){ echo 'has-error'; } ?>" id="InputFruitcolouratmaturity">
   <label for="" class="required">Fruit: colour at maturity</label>
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
   <label for="" class="required">Fruit: intensity of colour at maturity</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitintensityofcolouratmaturity_dettomato as $key => $value){ ?>
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
<div class="form-group <?php if($error['FruitGreenShoulders']!=''){ echo 'has-error'; } ?>" id="InputFruitGreenShoulders">
   <label for="" class="required">Fruit:  Green Shoulders</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($FruitGreenShoulders as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['FruitGreenShoulders']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="FruitGreenShoulders<?php echo $key; ?>" name="FruitGreenShoulders" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="FruitGreenShoulders<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['FruitGreenShoulders']!=''){ echo $error['FruitGreenShoulders']; } ?></span>
</div>
<div class="form-group <?php if($error['Fruitcracking']!=''){ echo 'has-error'; } ?>" id="InputFruitcracking">
   <label for="" class="required">Fruit:  Cracking (all sorts)</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitcracking_dettomato as $key => $value){ ?>
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
<!-- <div class="form-group <?php if($error['Fruitglossiness']!=''){ echo 'has-error'; } ?>" id="InputFruitglossiness">
   <label for="" class="required">Fruit: Glossiness</label>
   
   <br>
   
   <?php $cnt = 1; ?>
   
   <?php foreach ($Fruitglossiness as $key => $value){ ?>
   
     <?php 
      if($cnt=='1' && $get_single_evaluation['Fruitglossiness']==''){
      
        $checked = 'checked="checked"';
      
      }elseif($get_single_evaluation['Fruitglossiness']==$value){
      
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
   
   </div> -->
<div class="form-group <?php if($error['FruitFirmnessatfinalcolour']!=''){ echo 'has-error'; } ?>" id="InputFruitFirmnessatfinalcolour">
   <label for="" class="required">Fruit: Firmness at final colour</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($FruitFirmnessatfinalcolour as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['FruitFirmnessatfinalcolour']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="FruitFirmnessatfinalcolour<?php echo $key; ?>" name="FruitFirmnessatfinalcolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="FruitFirmnessatfinalcolour<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['FruitFirmnessatfinalcolour']!=''){ echo $error['FruitFirmnessatfinalcolour']; } ?></span>
</div>
<div style="display: none;" class="form-group <?php if($error['Fruitdiameter']!=''){ echo 'has-error'; } ?>" id="InputFruitdiameter">
   <label for="" class="">Fruit: diameter (mm)</label>
   <input type="text" class="form-control" id="Fruitdiameter" name="Fruitdiameter" placeholder="Fruit: diameter (mm)" value="<?php echo $get_single_evaluation['Fruitdiameter']; ?>">
   <span class="help-block"><?php if($error['Fruitdiameter']!=''){ echo $error['Fruitdiameter']; } ?></span>
</div>

<div class="form-group <?php if($error['Fruitweight']!=''){ echo 'has-error'; } ?>" id="InputFruitweight">
   <label for="" class="required">Fruit: weight (gr)</label>
   <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="Fruit: weight (gr)" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">
   <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>
</div>

<div class="form-group <?php if($error['Brix']!=''){ echo 'has-error'; } ?>" id="InputBrix">
   <label for="" class="">Fruit:  Brix %</label>
   <input type="text" class="form-control" id="Brix" name="Brix" placeholder="Fruit:  Brix %" value="<?php echo $get_single_evaluation['Brix']; ?>">
   <span class="help-block"><?php if($error['Brix']!=''){ echo $error['Brix']; } ?></span>
</div>
<div class="form-group <?php if($error['Fruittaste']!=''){ echo 'has-error'; } ?>" id="InputFruittaste">
   <label for="" class="required">Fruit:  taste</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruittaste_dettomato as $key => $value){ ?>
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
<div style="display: none;" class="form-group <?php if($error['Yieldmarketablefrtsplnt']!=''){ echo 'has-error'; } ?>" id="InputYieldmarketablefrtsplnt">
   <label for="" class="">Yiled: marketable frts/plant (number)    </label>
   <input type="text" class="form-control" id="Yieldmarketablefrtsplnt" name="Yieldmarketablefrtsplnt" placeholder="Plants per m2" value="<?php echo $get_single_evaluation['Yieldmarketablefrtsplnt']; ?>">
   <span class="help-block"><?php if($error['Yieldmarketablefrtsplnt']!=''){ echo $error['Yieldmarketablefrtsplnt']; } ?></span>
</div>
<div style="display: none;" class="form-group <?php if($error['Yieldmarketablefrtsweight']!=''){ echo 'has-error'; } ?>" id="InputYieldmarketablefrtsweight">
   <label for="" class="">Yiled: marketable frts/plant (weight; gr) </label>
   <input type="text" class="form-control" id="Yieldmarketablefrtsweight" name="Yieldmarketablefrtsweight" placeholder="Plants per m2" value="<?php echo $get_single_evaluation['Yieldmarketablefrtsweight']; ?>">
   <span class="help-block"><?php if($error['Yieldmarketablefrtsweight']!=''){ echo $error['Yieldmarketablefrtsweight']; } ?></span>
</div>
<div style="display: none;" class="form-group <?php if($error['Yieldcontinuity']!=''){ echo 'has-error'; } ?>" id="InputYieldcontinuity">
   <label for="" class="required">Yiled: continuity of yield </label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Yieldcontinuity_dettomato as $key => $value){ ?>
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
   <?php foreach ($Yield_dettomato as $key => $value){ ?>
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
<div style="display: none;" class="form-group <?php if($error['Plantsperm2']!=''){ echo 'has-error'; } ?>" id="InputPlantsperm2">
   <label for="" class="required">Plants per m2</label>
   <input type="text" class="form-control" id="Plantsperm2" name="Plantsperm2" placeholder="Plants per m2" value="<?php echo $get_single_evaluation['Plantsperm2']; ?>">
   <span class="help-block"><?php if($error['Plantsperm2']!=''){ echo $error['Plantsperm2']; } ?></span>
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