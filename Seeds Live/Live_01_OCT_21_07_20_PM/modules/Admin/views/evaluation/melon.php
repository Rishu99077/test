<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">
   <label for="" class="required">PLANT: vigor</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Plantvigur_melon as $key => $value){ ?>
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
<div class="form-group <?php if($error['PowderyMildewSf']!=''){ echo 'has-error'; } ?>" id="InputPowderyMildewSf">
   <label for="" class="required">Powdery Mildew (Sf)</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($PowderyMildewSf as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['PowderyMildewSf']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="PowderyMildewSf<?php echo $key; ?>" name="PowderyMildewSf" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="PowderyMildewSf<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['PowderyMildewSf']!=''){ echo $error['PowderyMildewSf']; } ?></span>
</div>
<div class="form-group <?php if($error['DownyMildewPcu']!=''){ echo 'has-error'; } ?>" id="InputDownyMildewPcu">
   <label for="" class="required">Downy Mildew (Pcu)</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($DownyMildewPcu as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['DownyMildewPcu']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="DownyMildewPcu<?php echo $key; ?>" name="DownyMildewPcu" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="DownyMildewPcu<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['DownyMildewPcu']!=''){ echo $error['DownyMildewPcu']; } ?></span>
</div>
<div class="form-group <?php if($error['Fruitsperplant']!=''){ echo 'has-error'; } ?>" id="InputFruitsperplant">
   <label for="" class="required">Marketable fruits per plant</label>
   <input type="text" class="form-control" id="Fruitsperplant" name="Fruitsperplant" placeholder="Fruits per plant" value="<?php echo $get_single_evaluation['Fruitsperplant']; ?>">
   <span class="help-block"><?php if($error['Fruitsperplant']!=''){ echo $error['Fruitsperplant']; } ?></span>
</div>
<div class="form-group <?php if($error['Maturityvscontrol']!=''){ echo 'has-error'; } ?>" id="InputMaturityvscontrol">
   <label for="" class="required">Maturity (vs control)</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Maturityvscontrol_melon as $key => $value){ ?>
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
<div class="form-group <?php if($error['Fruitshape']!=''){ echo 'has-error'; } ?>" id="InputFruitshape">
   <label for="" class="required">Fruit shape</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitshape_melon as $key => $value){ ?>
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
<div class="form-group <?php if($error['Fruitnetting']!=''){ echo 'has-error'; } ?>" id="InputFruitnetting">
   <label for="" class="required">Fruit netting</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitnetting as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['Fruitnetting']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="Fruitnetting<?php echo $key; ?>" name="Fruitnetting" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="Fruitnetting<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['Fruitnetting']!=''){ echo $error['Fruitnetting']; } ?></span>
</div>
<div class="form-group <?php if($error['Fruitribbing']!=''){ echo 'has-error'; } ?>" id="InputFruitribbing">
   <label for="" class="required">FRUIT: ribbing</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitribbing as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['Fruitribbing']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="Fruitribbing<?php echo $key; ?>" name="Fruitribbing" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="Fruitribbing<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['Fruitribbing']!=''){ echo $error['Fruitribbing']; } ?></span>
</div>
<div class="form-group <?php if($error['Fruitsizeuniformity']!=''){ echo 'has-error'; } ?>" id="InputFruitsizeuniformity">
   <label for="" class="required">FRUIT: size uniformity</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fruitsizeuniformity_melon as $key => $value){ ?>
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
   <label for="" class="required">FRUIT: shape uniformity </label>
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
   <label for="" class="required">FRUIT: fruit weight (grams)</label>
   <input type="text" class="form-control" id="Fruitweight" name="Fruitweight" placeholder="FRUIT: fruit weight (grams)" value="<?php echo $get_single_evaluation['Fruitweight']; ?>">
   <span class="help-block"><?php if($error['Fruitweight']!=''){ echo $error['Fruitweight']; } ?></span>
</div>
<div class="form-group <?php if($error['Seedcavity']!=''){ echo 'has-error'; } ?>" id="InputSeedcavity">
   <label for="" class="required">Seed cavity</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Seedcavity_melon as $key => $value){ ?>
   <?php 
      if($get_single_evaluation['Seedcavity']==$value){
      
        $checked = 'checked="checked"';
      
      }else{
      
        $checked = '';
      
      }
      
      ?>
   <input type="radio" class="formcontrol" id="Seedcavity<?php echo $key; ?>" name="Seedcavity" value="<?php echo $value; ?>" <?php echo $checked; ?>>
   <label for="Seedcavity<?php echo $key; ?>"><?php echo $value; ?></label>
   <?php $cnt++; ?>
   <?php } ?>
   <span class="help-block"><?php if($error['Seedcavity']!=''){ echo $error['Seedcavity']; } ?></span>
</div>
<div class="form-group <?php if($error['Fleshcolor']!=''){ echo 'has-error'; } ?>" id="InputFleshcolor">
   <label for="" class="required">FRUIT: flesh color</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fleshcolor as $key => $value){ ?>
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
<div class="form-group <?php if($error['Fruittaste']!=''){ echo 'has-error'; } ?>" id="InputFruittaste">
   <label for="" class="required">FRUIT: taste</label>
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
<div class="form-group <?php if($error['Brix']!=''){ echo 'has-error'; } ?>" id="InputBrix">
   <label for="" class="">Brix</label>
   <input type="text" class="form-control" id="Brix" name="Brix" placeholder="Brix" value="<?php echo $get_single_evaluation['Brix']; ?>">
   <span class="help-block"><?php if($error['Brix']!=''){ echo $error['Brix']; } ?></span>
</div>
<div class="form-group <?php if($error['Fleshfirmness']!=''){ echo 'has-error'; } ?>" id="InputFleshfirmness">
   <label for="" class="required">Flesh firmness</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Fleshfirmness as $key => $value){ ?>
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
<div class="form-group <?php if($error['Shelflife']!=''){ echo 'has-error'; } ?>" id="InputShelflife">
   <label for="" class="required">Shelflife</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($Shelflife_Melon as $key => $value){ ?>
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
<div class="form-group <?php if($error['VisualYield']!=''){ echo 'has-error'; } ?>" id="InputVisualYield">
   <label for="" class="required">YIELD: visual yield</label>
   <br>
   <?php $cnt = 1; ?>
   <?php foreach ($VisualYield_melon as $key => $value){ ?>
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
   <?php foreach ($Rating_melon as $key => $value){ ?>
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
<div class="form-group " id="InputDropmessage"  >
   <label for="" class="">Drop message</label>
   <textarea  type="text" class="form-control" id="Dropmessage" name="Dropmessage" placeholder="Dropmessage" ></textarea>
   <span class="help-block"></span>
</div>
<div class="form-group " id="InputByWhen" style="display: none;">
   <label for="" class="required">By When</label>
   <input type="text" class="form-control" id="ByWhen" name="ByWhen" placeholder="By When" value="">
   <span class="help-block"></span>
</div>
<div class="form-group " id="InputNumberofseeds" style="display: none;">
   <label for="" class="required">Number of seeds (in Seeds)</label>
   <input type="text" class="form-control" id="Numberofseeds" name="Numberofseeds" placeholder="Number of seeds" value="">
   <span class="help-block"></span>
</div>