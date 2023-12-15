<div class="form-group <?php if($error['Marketsegment']!=''){ echo 'has-error'; } ?>" id="InputMarketsegment">

  <label for="" class="required">Market segment</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Marketsegment_beetroot as $key => $value){ ?>

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

  <?php foreach ($Plantvigur_beetroot as $key => $value){ ?>

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

  <label for="" class="required">Harvesting (maturity) vs control </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Harvesting_beetroot as $key => $value){ ?>

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



<div class="form-group <?php if($error['Leafattachment']!=''){ echo 'has-error'; } ?>" id="InputLeafattachment">

  <label for="" class="required">Leaf attachment</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Leafattachment as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Leafattachment']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Leafattachment<?php echo $key; ?>" name="Leafattachment" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Leafattachment<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Leafattachment']!=''){ echo $error['Leafattachment']; } ?></span>

</div>



<div class="form-group <?php if($error['Leafcolour']!=''){ echo 'has-error'; } ?>" id="InputLeafcolour">

  <label for="" class="required">Leaf colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Leafcolour_beetroot as $key => $value){ ?>

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



<div class="form-group <?php if($error['Toplength']!=''){ echo 'has-error'; } ?>" id="InputToplength">

  <label for="" class="required">Top length (cm) </label>

  <input type="text" class="form-control" id="Toplength" name="Toplength" placeholder="Top length (cm)" value="<?php echo $get_single_evaluation['Toplength']; ?>">

  <span class="help-block"><?php if($error['Toplength']!=''){ echo $error['Toplength']; } ?></span>

</div>



<div class="form-group <?php if($error['Foliagelength']!=''){ echo 'has-error'; } ?>" id="InputFoliagelength" >

  <label for="" class="required">Foliage length</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Foliagelength as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Foliagelength']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Foliagelength<?php echo $key; ?>" name="Foliagelength" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Foliagelength<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Foliagelength']!=''){ echo $error['Foliagelength']; } ?></span>

</div>



<div class="form-group <?php if($error['Anthocyanin']!=''){ echo 'has-error'; } ?>" id="InputAnthocyanin">

  <label for="" class="required">Anthocyanin (leaf)</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Anthocyanin_beetroot as $key => $value){ ?>

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



<div class="form-group <?php if($error['Leafimplant']!=''){ echo 'has-error'; } ?>" id="InputLeafimplant">

  <label for="" class="required">Leaf implant</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Leafimplant as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Leafimplant']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Leafimplant<?php echo $key; ?>" name="Leafimplant" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Leafimplant<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Leafimplant']!=''){ echo $error['Leafimplant']; } ?></span>

</div>



<div class="form-group <?php if($error['Foliageatittude']!=''){ echo 'has-error'; } ?>" id="InputFoliageatittude" style="display: none;" >

  <label for="" class="required">Foliage atittude</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Foliageatittude as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Foliageatittude']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Foliageatittude<?php echo $key; ?>" name="Foliageatittude" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Foliageatittude<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Foliageatittude']!=''){ echo $error['Foliageatittude']; } ?></span>

</div>



<div class="form-group <?php if($error['Boltingresistance']!=''){ echo 'has-error'; } ?>" id="InputBoltingresistance">

  <label for="" class="required">Bolting resist./tol.</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Boltingresistance_beetroot as $key => $value){ ?>

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

  <?php foreach ($Rootshape_beetroot as $key => $value){ ?>

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

  <img src="<?php echo base_url(); ?>adminasset/images/rootshape.png" style="width: 100%;">

</div>



<div class="form-group <?php if($error['RootExternalcolor']!=''){ echo 'has-error'; } ?>" id="InputRootExternalcolor">

  <label for="" class="required">Root external colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($RootExternalcolor_beetroot as $key => $value){ ?>

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



<div class="form-group <?php if($error['Rootinternalcolor']!=''){ echo 'has-error'; } ?>" id="InputRootinternalcolor">

  <label for="" class="required">Root internal colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rootinternalcolor_beetroot as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Rootinternalcolor']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Rootinternalcolor<?php echo $key; ?>" name="Rootinternalcolor" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Rootinternalcolor<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Rootinternalcolor']!=''){ echo $error['Rootinternalcolor']; } ?></span>

</div>



<div class="form-group <?php if($error['Rootsize']!=''){ echo 'has-error'; } ?>" id="InputRootsize">

  <label for="" class="required">Root size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Rootsize_beetroot as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Rootsize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Rootsize<?php echo $key; ?>" name="Rootsize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Rootsize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Rootsize']!=''){ echo $error['Rootsize']; } ?></span>

</div>



<div class="form-group <?php if($error['Taprootsize']!=''){ echo 'has-error'; } ?>" id="InputTaprootsize">

  <label for="" class="required">Tap root size</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Taprootsize as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Taprootsize']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Taprootsize<?php echo $key; ?>" name="Taprootsize" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Taprootsize<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Taprootsize']!=''){ echo $error['Taprootsize']; } ?></span>

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



<div class="form-group <?php if($error['Skinsmoothness']!=''){ echo 'has-error'; } ?>" id="InputSkinsmoothness">

  <label for="" class="required">Skin smoothness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Skinsmoothness as $key => $value){ ?>

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



<div class="form-group <?php if($error['Zoning']!=''){ echo 'has-error'; } ?>" id="InputZoning">

  <label for="" class="required">Zoning</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Zoning as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Zoning']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Zoning<?php echo $key; ?>" name="Zoning" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Zoning<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Zoning']!=''){ echo $error['Zoning']; } ?></span>

</div>



<div class="form-group <?php if($error['Rootweight']!=''){ echo 'has-error'; } ?>" id="InputRootweight">

  <label for="" class="required"> Root weight (average 10 roots) </label>

  <input type="text" class="form-control" id="Rootweight" name="Rootweight" placeholder="Root weight (average 10 roots)" value="<?php echo $get_single_evaluation['Rootweight']; ?>">

  <span class="help-block"><?php if($error['Rootweight']!=''){ echo $error['Rootweight']; } ?></span>

</div>



<div class="form-group <?php if($error['Whiterings']!=''){ echo 'has-error'; } ?>" id="InputWhiterings">

  <label for="" class="required">White rings</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Whiterings_beetroot as $key => $value){ ?>

    <?php 

     if($get_single_evaluation['Whiterings']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Whiterings<?php echo $key; ?>" name="Whiterings" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Whiterings<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Whiterings']!=''){ echo $error['Whiterings']; } ?></span>

</div>



<div class="form-group <?php if($error['Sugarcontent']!=''){ echo 'has-error'; } ?>" id="InputSugarcontent">

  <label for="" class="required">Sugar content</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Sugarcontent as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Sugarcontent']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Sugarcontent<?php echo $key; ?>" name="Sugarcontent" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Sugarcontent<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Sugarcontent']!=''){ echo $error['Sugarcontent']; } ?></span>

</div>



<div class="form-group <?php if($error['Flavour']!=''){ echo 'has-error'; } ?>" id="InputFlavour">

  <label for="" class="required">Flavour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Flavour as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Flavour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Flavour<?php echo $key; ?>" name="Flavour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Flavour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Flavour']!=''){ echo $error['Flavour']; } ?></span>

</div>





<div class="form-group <?php if($error['Shelflife']!=''){ echo 'has-error'; } ?>" id="InputShelflife">

  <label for="" class="">Shelf life </label>

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