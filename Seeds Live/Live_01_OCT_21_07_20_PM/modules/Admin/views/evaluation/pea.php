<div class="form-group <?php if($error['Plantvigur']!=''){ echo 'has-error'; } ?>" id="InputPlantvigur">

  <label for="" class="required">Vigor</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Plantvigur_pea as $key => $value){ ?>

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

  <?php foreach ($Harvesting_pea as $key => $value){ ?>

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







<div class="form-group <?php if($error['Podshape']!=''){ echo 'has-error'; } ?>" id="InputPodshape">

  <label for="" class="required">Pod shape</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Podshape as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Podshape']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Podshape<?php echo $key; ?>" name="Podshape" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Podshape<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Podshape']!=''){ echo $error['Podshape']; } ?></span>

</div>



<div class="form-group <?php if($error['Podcolour']!=''){ echo 'has-error'; } ?>" id="InputPodcolour">

  <label for="" class="required">Pod colour</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Podcolour as $key => $value){ ?>

    <?php 

      if($get_single_evaluation['Podcolour']==$value){

        $checked = 'checked="checked"';

      }else{

        $checked = '';

      }

    ?>

  <input type="radio" class="formcontrol" id="Podcolour<?php echo $key; ?>" name="Podcolour" value="<?php echo $value; ?>" <?php echo $checked; ?>>

  <label for="Podcolour<?php echo $key; ?>"><?php echo $value; ?></label>

  <?php $cnt++; ?>

  <?php } ?>

  <span class="help-block"><?php if($error['Podcolour']!=''){ echo $error['Podcolour']; } ?></span>

</div>



<div class="form-group <?php if($error['Kernelsperpod']!=''){ echo 'has-error'; } ?>" id="InputKernelsperpod">

  <label for="" class="required">Kernels per pod</label>

  <input type="text" class="form-control" id="Kernelsperpod" name="Kernelsperpod" placeholder="Kernels per pod" value="<?php echo $get_single_evaluation['Kernelsperpod']; ?>">

  <span class="help-block"><?php if($error['Kernelsperpod']!=''){ echo $error['Kernelsperpod']; } ?></span>

</div>



<div class="form-group <?php if($error['Podspernode']!=''){ echo 'has-error'; } ?>" id="InputPodspernode">

  <label for="" class="required">Pods per node</label>

  <input type="text" class="form-control" id="Podspernode" name="Podspernode" placeholder="Pods per node" value="<?php echo $get_single_evaluation['Podspernode']; ?>">

  <span class="help-block"><?php if($error['Podspernode']!=''){ echo $error['Podspernode']; } ?></span>

</div>



<div class="form-group <?php if($error['Flowercolour']!=''){ echo 'has-error'; } ?>" id="InputFlowercolour">

  <label for="" class="required"> Flower colour </label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Flowercolour_pea as $key => $value){ ?>

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



<div class="form-group <?php if($error['Firmness']!=''){ echo 'has-error'; } ?>" id="InputFirmness">

  <label for="" class="required">Pod firmness</label>

  <br>

  <?php $cnt = 1; ?>

  <?php foreach ($Firmness as $key => $value){ ?>

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





<div class="form-group <?php if($error['Shelflife']!=''){ echo 'has-error'; } ?>" id="InputShelflife">

  <label for="" class="">Shelf life</label>

  <input type="text" class="form-control" id="Shelflife" name="Shelflife" placeholder="Shelf life" value="<?php echo $get_single_evaluation['Shelflife']; ?>">

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