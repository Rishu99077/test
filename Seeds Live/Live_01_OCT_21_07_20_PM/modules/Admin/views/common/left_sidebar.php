 <?php
    $leftMenu =array();
    /*======= Dashboard ==========*/
    $leftMenu['dashboard']['title'] = 'Dashboard';
    $leftMenu['dashboard']['url'] = base_url('admin');
    $leftMenu['dashboard']['icon'] = 'fa fa-dashboard';

    if($userrole=='1' || $userrole=='4'){
        $leftMenu['entry']['title'] = 'Entry';
        $leftMenu['entry']['url'] = '#';
        $leftMenu['entry']['icon'] = 'fa fa-circle-o'; 
    }  

    $leftEntrysubMenu =array();
    /*============ Crops =============*/    
    if($userrole=='1' || $userrole=='4'){
        $leftEntrysubMenu['crops']['title'] = 'Crops';
        $leftEntrysubMenu['crops']['url'] = base_url('admin/crops');
        $leftEntrysubMenu['crops']['icon'] = 'fa fa-circle-o';

        $leftEntrysubMenu['cropedit']['title'] = 'Add New Crop';
        $leftEntrysubMenu['cropedit']['url'] = base_url('admin/cropedit');
        $leftEntrysubMenu['cropedit']['icon'] = 'fa fa-circle-o';
    }
    /*============ Control variety =============*/    
    /*if($userrole=='1' || $userrole=='4'){
        $leftEntrysubMenu['controlvariety']['title'] = 'Control variety';
        $leftEntrysubMenu['controlvariety']['url'] = base_url('admin/controlvariety');
        $leftEntrysubMenu['controlvariety']['icon'] = 'fa fa-circle-o';

        $leftEntrysubMenu['controlvarietyedit']['title'] = 'Add New Control variety';
        $leftEntrysubMenu['controlvarietyedit']['url'] = base_url('admin/controlvarietyedit');
        $leftEntrysubMenu['controlvarietyedit']['icon'] = 'fa fa-circle-o';
    }*/
    /*============ Suppliers =============*/    
    if($userrole=='1' || $userrole=='4'){
        $leftEntrysubMenu['suppliers']['title'] = 'Suppliers';
        $leftEntrysubMenu['suppliers']['url'] = base_url('admin/suppliers');
        $leftEntrysubMenu['suppliers']['icon'] = 'fa fa-circle-o';

        $leftEntrysubMenu['supplieredit']['title'] = 'Add New Supplier';
        $leftEntrysubMenu['supplieredit']['url'] = base_url('admin/supplieredit');
        $leftEntrysubMenu['supplieredit']['icon'] = 'fa fa-circle-o';

    }
    
    /*============ Receivers =============*/  
    if($userrole=='1' || $userrole=='4'){  
        
        $leftEntrysubMenu['receivers']['title'] = 'Receivers';
        $leftEntrysubMenu['receivers']['url'] = base_url('admin/receivers');
        $leftEntrysubMenu['receivers']['icon'] = 'fa fa-circle-o';

        $leftEntrysubMenu['receiveredit']['title'] = 'Add New Receiver';
        $leftEntrysubMenu['receiveredit']['url'] = base_url('admin/receiveredit');
        $leftEntrysubMenu['receiveredit']['icon'] = 'fa fa-circle-o';
    }
    /*============ Techncial team =============*/    
    if($userrole=='1' || $userrole=='4'){
        $leftEntrysubMenu['techncialteam']['title'] = 'Techncial team';
        $leftEntrysubMenu['techncialteam']['url'] = base_url('admin/techncialteam');
        $leftEntrysubMenu['techncialteam']['icon'] = 'fa fa-circle-o';

        $leftEntrysubMenu['techncialteamedit']['title'] = 'Add New Techncial team';
        $leftEntrysubMenu['techncialteamedit']['url'] = base_url('admin/techncialteamedit');
        $leftEntrysubMenu['techncialteamedit']['icon'] = 'fa fa-circle-o';
    }
    if($userrole=='1' || $userrole=='4'){
        $leftMenu['entry']['subemnu'] = $leftEntrysubMenu;
    }
    /*============ Seeds =============*/    
    if($userrole=='1' || $userrole=='4'|| in_array("seeds", $userpermission)){
        $leftMenu['seeds']['title'] = 'Seeds';
        $leftMenu['seeds']['url'] = '#';
        $leftMenu['seeds']['icon'] = 'fa fa-circle-o';

        $leftSeedssubMenu =array();

        $leftSeedssubMenu['seeds']['title'] = 'Seeds';
        $leftSeedssubMenu['seeds']['url'] = base_url('admin/seeds');
        $leftSeedssubMenu['seeds']['icon'] = 'fa fa-circle-o';
        if($userrole=='1' || $userrole=='4' || $userrole=='2'){
            $leftSeedssubMenu['seededit']['title'] = 'Add New';
            $leftSeedssubMenu['seededit']['url'] = base_url('admin/seededit');
            $leftSeedssubMenu['seededit']['icon'] = 'fa fa-circle-o';
        }
        $leftSeedssubMenu['stocks']['title'] = 'Stock management';
        $leftSeedssubMenu['stocks']['url'] = base_url('admin/stocks');
        $leftSeedssubMenu['stocks']['icon'] = 'fa fa-circle-o';
        $leftMenu['seeds']['subemnu'] = $leftSeedssubMenu;
    }
    /*============ Sampling =============*/    
    if($userrole=='1' || $userrole=='4' || in_array("sampling", $userpermission)){
        $leftMenu['sampling']['title'] = 'Sampling';
        $leftMenu['sampling']['url'] = '#';
        $leftMenu['sampling']['icon'] = 'fa fa-circle-o';

        $leftSamplingsubMenu =array();

        $leftSamplingsubMenu['sampling']['title'] = 'Sampling';
        $leftSamplingsubMenu['sampling']['url'] = base_url('admin/sampling');
        $leftSamplingsubMenu['sampling']['icon'] = 'fa fa-circle-o';
        if($userrole=='1' || $userrole=='4' || $userrole=='2'){
            $leftSamplingsubMenu['samplingedit']['title'] = 'Add New';
            $leftSamplingsubMenu['samplingedit']['url'] = base_url('admin/samplingedit');
            $leftSamplingsubMenu['samplingedit']['icon'] = 'fa fa-circle-o';
        }
        $leftMenu['sampling']['subemnu'] = $leftSamplingsubMenu;
    }    
    /*============ Trial =============*/    
    if($userrole=='1' || $userrole=='4' || $userrole=='7' || in_array("trial", $userpermission)){
        $leftMenu['trial']['title'] = 'Trial';
        $leftMenu['trial']['url'] = '#';
        $leftMenu['trial']['icon'] = 'fa fa-circle-o';

        $leftTrialsubMenu =array();

        if($userrole=='1' || $userrole=='4' || $userrole=='5' || $userrole=='2' || !$userrole=='6' || $userrole=='3' || $userrole=='7'){
            $leftTrialsubMenu['trial']['title'] = 'Trial';
            $leftTrialsubMenu['trial']['url'] = base_url('admin/trial');
            $leftTrialsubMenu['trial']['icon'] = 'fa fa-circle-o';
        }
        if($userrole=='1' || $userrole=='4' || $userrole=='5' || $userrole=='6' || $userrole=='2' || $userrole=='7'){
            $leftTrialsubMenu['trialedit']['title'] = 'Add New';
            $leftTrialsubMenu['trialedit']['url'] = base_url('admin/trialedit');
            $leftTrialsubMenu['trialedit']['icon'] = 'fa fa-circle-o';
        }
        $leftMenu['trial']['subemnu'] = $leftTrialsubMenu;
    }    

    /*============ Evaluation =============*/    
    if($userrole=='1' || $userrole=='4' || $userrole=='7' || in_array("evaluation", $userpermission)){
        $leftMenu['evaluation']['title'] = 'Evaluation';
        $leftMenu['evaluation']['url'] = '#';
        $leftMenu['evaluation']['icon'] = 'fa fa-circle-o';

        $leftEvaluationsubMenu =array();

        if($userrole=='1' || $userrole=='4' || $userrole=='5' || $userrole=='7' || $userrole=='2' || $userrole=='3' || !$userrole=='6'){
            $leftEvaluationsubMenu['evaluation']['title'] = 'Evaluation';
            $leftEvaluationsubMenu['evaluation']['url'] = base_url('admin/evaluation');
            $leftEvaluationsubMenu['evaluation']['icon'] = 'fa fa-circle-o';
        }
        if($userrole=='1' || $userrole=='4' || $userrole=='5' || $userrole=='6' || $userrole=='7' || $userrole=='2'){
            $leftEvaluationsubMenu['evaluationedit']['title'] = 'Add New';
            $leftEvaluationsubMenu['evaluationedit']['url'] = base_url('admin/evaluationedit');
            $leftEvaluationsubMenu['evaluationedit']['icon'] = 'fa fa-circle-o';
        }
        if($userrole=='1' || $userrole=='4'){
            $leftEvaluationsubMenu['evaluationclose']['title'] = 'Close';
            $leftEvaluationsubMenu['evaluationclose']['url'] = base_url('admin/evaluationclose');
            $leftEvaluationsubMenu['evaluationclose']['icon'] = 'fa fa-circle-o';
        }
        $leftMenu['evaluation']['subemnu'] = $leftEvaluationsubMenu;
    }    

    /*============ Recheck =============*/    
    if($userrole=='1' || $userrole=='4'){
        $leftMenu['recheck']['title'] = 'Re-check';
        $leftMenu['recheck']['url'] = '#';
        $leftMenu['recheck']['icon'] = 'fa fa-circle-o';

        $leftRechecksubMenu =array();

        $leftRechecksubMenu['recheck']['title'] = 'Re-check';
        $leftRechecksubMenu['recheck']['url'] = base_url('admin/recheck');
        $leftRechecksubMenu['recheck']['icon'] = 'fa fa-circle-o';

        $leftRechecksubMenu['recheckedit']['title'] = 'Add New';
        $leftRechecksubMenu['recheckedit']['url'] = base_url('admin/recheckedit');
        $leftRechecksubMenu['recheckedit']['icon'] = 'fa fa-circle-o';

        $leftMenu['recheck']['subemnu'] = $leftRechecksubMenu;
    }
    /*============ Precommercial =============*/    
    if($userrole=='1' || $userrole=='4'){
        $leftMenu['precommercial']['title'] = 'Pre-commercial';
        $leftMenu['precommercial']['url'] = '#';
        $leftMenu['precommercial']['icon'] = 'fa fa-circle-o';

        $leftPrecommercialsubMenu =array();

        $leftPrecommercialsubMenu['precommercial']['title'] = 'Pre-commercial';
        $leftPrecommercialsubMenu['precommercial']['url'] = base_url('admin/precommercial');
        $leftPrecommercialsubMenu['precommercial']['icon'] = 'fa fa-circle-o';

        $leftPrecommercialsubMenu['precommercialedit']['title'] = 'Add New';
        $leftPrecommercialsubMenu['precommercialedit']['url'] = base_url('admin/precommercialedit');
        $leftPrecommercialsubMenu['precommercialedit']['icon'] = 'fa fa-circle-o';

        $leftMenu['precommercial']['subemnu'] = $leftPrecommercialsubMenu;
    }
    /*============ Users =============*/    
    if($userrole=='1'){
        $leftMenu['users']['title'] = 'Users';
        $leftMenu['users']['url'] = '#';
        $leftMenu['users']['icon'] = 'fa fa-user';

        $leftUserSubMenu =array();

        $leftUserSubMenu['users']['title'] = 'Users';
        $leftUserSubMenu['users']['url'] = base_url('admin/users');
        $leftUserSubMenu['users']['icon'] = 'fa fa-circle-o';

        $leftUserSubMenu['adduser']['title'] = 'Add User';
        $leftUserSubMenu['adduser']['url'] = base_url('admin/adduser');
        $leftUserSubMenu['adduser']['icon'] = 'fa fa-circle-o';

        $leftMenu['users']['subemnu'] = $leftUserSubMenu;
    }
    /*============ Extra =============*/    
    if($userrole=='1'){
        $leftMenu['extra']['title'] = 'Extra';
        $leftMenu['extra']['url'] = '#';
        $leftMenu['extra']['icon'] = 'fa fa-circle-o';

        $leftExtraSubMenu =array();

        $leftExtraSubMenu['logs']['title'] = 'Logs';
        $leftExtraSubMenu['logs']['url'] = base_url('admin/logs');
        $leftExtraSubMenu['logs']['icon'] = 'fa fa-circle-o';

        $leftExtraSubMenu['restores']['title'] = 'Restore Section';
        $leftExtraSubMenu['restores']['url'] = base_url('admin/restores');
        $leftExtraSubMenu['restores']['icon'] = 'fa fa-circle-o';

        $leftMenu['extra']['subemnu'] = $leftExtraSubMenu;
    }
    /*============ Phonebook =============*/    
    if($userrole=='1' || $userrole=='4'){
        $leftMenu['phonebook']['title'] = 'Phonebook';
        $leftMenu['phonebook']['url'] = '#';
        $leftMenu['phonebook']['icon'] = 'fa fa-circle-o';

        $leftPrecommercialsubMenu =array();

        $leftPrecommercialsubMenu['phonebook']['title'] = 'Phonebook';
        $leftPrecommercialsubMenu['phonebook']['url'] = base_url('admin/phonebook');
        $leftPrecommercialsubMenu['phonebook']['icon'] = 'fa fa-circle-o';

        $leftPrecommercialsubMenu['phonebookadd']['title'] = 'Add Phonebook';
        $leftPrecommercialsubMenu['phonebookadd']['url'] = base_url('admin/phonebookadd');
        $leftPrecommercialsubMenu['phonebookadd']['icon'] = 'fa fa-circle-o';

        $leftMenu['phonebook']['subemnu'] = $leftPrecommercialsubMenu;
    }
 ?>
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <?php foreach ($leftMenu as $key => $value) { ?>
          <?php if($key==$active){$activeClass = 'active ';}else{ $activeClass = ' '; } ?> 
          <?php if (array_key_exists("subemnu",$value)) { $activeClass .= 'treeview '; } ?>

          <li class="<?php echo $activeClass; ?>">
            <a href="<?php echo $value['url']; ?>">
              <?php if (array_key_exists("icon",$value)) { ?>
              <i class="<?php echo $value['icon']; ?>"></i> 
              <?php } ?>
              <span><?php echo $value['title']; ?></span>
            </a>
            <?php if (array_key_exists("subemnu",$value)) { ?>
                <ul class="treeview-menu">
                  <?php foreach ($value['subemnu'] as $subemnukey => $subemnuvalue) { ?>   
                      <?php if($subemnukey==$submenuactive){$activeClassSub = 'active ';}else{ $activeClassSub = ' '; } ?> 
                      <li class="<?php echo $activeClassSub; ?>">
                        <a href="<?php echo $subemnuvalue['url']; ?>">
                          <?php if (array_key_exists("icon",$subemnuvalue)) { ?>
                          <i class="<?php echo $subemnuvalue['icon']; ?>"></i> 
                          <?php } ?>
                          <span><?php echo $subemnuvalue['title']; ?></span>
                        </a>
                      </li>           
                  <?php } ?>
                </ul>  
            <?php } ?>
          </li>
        <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>