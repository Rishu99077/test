<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Evaluation extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Evaluationadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');			
    } 

	public function index(){
		$validateLogin = $this->validateLogin('evaluation','list');
		$get_user_detail=$this->Evaluationadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		if($userrole=='6'){
			redirect('admin/evaluationedit');
			exit();
		} 
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		// echo "<pre>";
		// print_r($data['userrole']);
		// echo "</pre>";
		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');
		$Variety = $this->input->get('Variety');
		$Location = $this->input->get('Location');
		$Techncialteam  = $this->input->get('Techncialteam');
		$FromDate  = $this->input->get('FromDate');
		$ToDate  = $this->input->get('ToDate');

		$SowingFromDate = $this->input->get('SowingFromDate');
   		$SowingToDate = $this->input->get('SowingToDate');

   		$HarvestFromDate  = $this->input->get('HarvestFromDate');
        $HarvestToDate  = $this->input->get('HarvestToDate');

        $TransplantFromDate  = $this->input->get('TransplantFromDate');
        $TransplantToDate  = $this->input->get('TransplantToDate');

		$Internalsamplingcode  = $this->input->get('Internalsamplingcode');

		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $Internalsamplingcode){
   			$total_rows = $this->Evaluationadmin->filter_get_evaluation_count($data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode);
   		}else{
   			$total_rows = $this->Evaluationadmin->get_evaluation_count($data['userrole']);
   		}


		$config = array();
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $Internalsamplingcode) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['base_url'] =base_url('admin/evaluation');
		$config['use_page_numbers'] = false;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$config['num_links'] = 4;
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        if($this->uri->segment(3) > 0){
		    $start = $this->uri->segment(3)+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) + $config['per_page'];
		}else{
		    $start= (int)$this->uri->segment(3) * $config['per_page']+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
		}
		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $Internalsamplingcode){
   			$get_evaluation = $this->Evaluationadmin->filter_get_evaluation($config["per_page"], $page,$data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$Internalsamplingcode);
   		}else{
			$get_evaluation = $this->Evaluationadmin->get_evaluation($config["per_page"], $page,$data['userrole']);

		}
		
		$evaluations = array();
		foreach ($get_evaluation as $evaluation_value) {
			$evaluation = array();
			$UserID = $evaluation_value['UserID'];
			$evaluation['EvaluationID'] = $evaluation_value['EvaluationID'];
			$evaluation['Internalsamplecode'] = $evaluation_value['Internalsamplecode'];
			$evaluation['Dateofvisit'] = $evaluation_value['Dateofvisit'];
			$evaluation['is_deleted'] = $evaluation_value['is_deleted'];

			$evaluation['added_location'] = $evaluation_value['added_location'];
			$evaluation['latitude'] = $evaluation_value['latitude'];
			$evaluation['longitude'] = $evaluation_value['longitude'];

			$evaluation['Varity'] = '';
			$evaluation['Crop'] = '';
			$evaluation['Location'] = '';
			$evaluation['Receiver'] = '';
			$evaluation['Fullname']= '';
			$evaluation['AddedDate']= $evaluation_value['AddedDate'];
			@$evaluation['evaluation_AddedDate'] = $evaluation_value['evaluation_AddedDate'];

			$get_users = $this->Evaluationadmin->get_users($UserID);
			if($get_users){
				$evaluation['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];
			}

			$get_sampling = $this->Evaluationadmin->get_sampling($evaluation_value['Internalsamplecode']);
			// echo "<pre>";
			// print_r($get_sampling);
			// echo "</pre>";
			if($get_sampling){
				$get_crop = $this->Evaluationadmin->get_crop($get_sampling['Crop']);
				if($get_crop){
					$evaluation['Crop'] = $get_crop['Title'];
				}
				$evaluation['Location'] = $get_sampling['Location'];
				$evaluation['Dateofsowing'] = $get_sampling['Dateofsowing'];
				$evaluation['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
				$evaluation['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];

				$get_receiver = $this->Evaluationadmin->get_receiver($get_sampling['Receiver']);
				if($get_receiver){
					$evaluation['Receiver'] = $get_receiver['Name'];
				}

				

				$get_seed = $this->Evaluationadmin->get_seed($get_sampling['Seed']);
				if($get_seed){
					$evaluation['Varity'] = $get_seed['Variety'];
				}
				$get_supplier = $this->Evaluationadmin->get_supplier($get_sampling['SupplierID']);
				if($get_seed){
					$evaluation['SupplierName'] = $get_supplier['Name'];
				}

			}

			$evaluations[] = $evaluation;
		}

		$get_crops = $this->Evaluationadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Evaluationadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

		$get_seeds = $this->Evaluationadmin->get_seeds();
	    $seeds = array();
	    foreach($get_seeds as $get_seed){
	        $seeds[$get_seed['SeedID']]= $get_seed['Variety'];
	    }
	    asort($seeds);
	    
	    $get_techncialteams = $this->Evaluationadmin->get_techncialteams();
	    $techncialteams = array();
	    foreach($get_techncialteams as $get_techncialteam){
	        $techncialteams[$get_techncialteam['TechncialteamID']]= $get_techncialteam['Name'];
	    }
	    //asort($techncialteams);

		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;
		$data["seeds"] = $seeds;
		$data["techncialteams"] = $techncialteams;

		$get_sampling_all = $this->Evaluationadmin->get_sampling_all_location();
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

        $data['heading_title']='Evaluation';
		$data['active']='evaluation';
		$data['submenuactive']='evaluation';

		$data["evaluation"] = $evaluations;
        $data["links"] = $this->pagination->create_links();
		$this->load->view('evaluation',$data);
	}

	public function evaluationedit(){
		
		$segment2 = $this->uri->segment(2);
		$EvaluationID = @$_GET['EvaluationID'];

		$validateLogin = $this->validateLogin('evaluation','evaluationedit');
		
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		/*======= Default Error START ===========*/
			$error = array();
			$error['Internalsamplecode'] = '';
			$error['Internalsamplecodecontrolvariety'] = '';
			$error['Picture'] = '';
			$error['Dateofvisit'] = '';
			$error['Plantvigur'] = '';
			$error['Plantsize'] = '';
			$error['Bulbshape'] = '';
			$error['Bulbshapeuniformit'] = '';
			$error['Varietytype'] = '';
			$error['Headformation'] = '';
			$error['Leafcolour'] = '';
			$error['Headsize'] = '';
			$error['Leaftexture'] = '';
			$error['Fruitshape'] = '';
			$error['Fruitnetting'] = '';
			$error['Fruitribbing'] = '';
			$error['Yield'] = '';
			$error['Spongeness'] = '';
			$error['Fruitnumbercluster'] = '';
			$error['FruitGreenShoulders'] = '';
			$error['Fruitcracking'] = '';
			$error['FruitFirmnessatfinalcolour'] = '';
			$error['Fruitintensityofcolouratmaturity'] = '';
			$error['Fruitintensityofcolourbeforematurity'] = '';
			$error['Maturity'] = '';
			$error['Firmness'] = '';
			$error['Fruitglossiness'] = '';
			$error['Uniformity'] = '';
			$error['Fruitsettingunderlowtemperature'] = '';
			$error['Fruitsettingunderhightemperature'] = '';
			$error['Fieldstandingability'] = '';
			$error['Resistance'] = '';
			$error['Averagewieght'] = '';
			$error['AveragewieghtIn'] = '';
			$error['Friutwidth'] = '';
			$error['Harvestlongevity'] = '';
			$error['FriutwidthIn'] = '';
			$error['Friutlength'] = '';
			$error['Numberofseeds'] = '';
			$error['ByWhen'] = '';
			$error['Fruitdiameter'] = '';
			$error['FriutlengthIn'] = '';
			$error['Fruitcolor'] = '';
			$error['Overallrating'] = '';
			$error['Comment'] = '';
			$error['Status'] = '';
			$error['Dropmessage'] = '';

			$error['Plantframesize'] = '';
			$error['Stemthickness'] = '';
			$error['Headweight'] = '';
			$error['Headlength'] = '';
			$error['Headdiameter'] = '';
			$error['Curdcolor'] = '';
			$error['Curdcover'] = '';
			$error['CurdUniformity'] = '';
			$error['Fieldholdability'] = '';
			$error['Headshape'] = '';
			$error['Headknobbling'] = '';
			$error['Beadsize'] = '';
			$error['Headuniformity'] = '';
			$error['Firmness_broccoli'] = '';
			$error['Sideshoots'] = '';
			$error['Fieldstandingability'] = '';
			$error['Heatresittol'] = '';
			$error['Coldresisttol'] = '';
			$error['Rating'] = '';
			$error['Dryskinafterharvest'] = '';
			$error['Necksize'] = '';
			$error['Thicknessofdryskin'] = '';
			$error['Basecolourdryskin'] = '';
			$error['Widthofneck'] = '';
			$error['Storability'] = '';
			$error['Noofdoublecenter'] = '';
			$error['Yieldmarketable'] = '';
			$error['Yieldnonmarketable'] = '';
			$error['YieldD57'] = '';
			$error['YieldD79'] = '';
			$error['YieldD9'] = '';
			$error['Conclusion'] = '';
			$error['Advantages'] = '';
			$error['Disadvantages'] = '';
			$error['Remarks'] = '';
			$error['Headcolor'] = '';
			$error['Leafwaxiness'] = '';
			$error['anthocyanincolorationofcoverleaf'] = '';
			$error['Coresize'] = '';
			$error['Headdensity'] = '';
			$error['Marketsegment'] = '';
			$error['Growthtype'] = '';
			$error['Planthabit'] = '';
			$error['Silvering'] = '';
			$error['Branching'] = '';
			$error['YongfruitRatio'] = '';
			$error['Stripesripefruit'] = '';
			$error['Blossomscar'] = '';
			$error['Easypicking'] = '';
			$error['PostHarvestQuality'] = '';
			$error['EarlyYield'] = '';
			$error['TotalYield'] = '';
			$error['Anthocyanin'] = '';
			$error['Firstearheight'] = '';
			$error['Earlength'] = '';
			$error['Eardiameter'] = '';
			$error['Numberofears'] = '';
			$error['Corncoblength'] = '';
			$error['Earhuskleafcolor'] = '';
			$error['Flagleavesappearanceonear'] = '';
			$error['EarProtection'] = '';
			$error['Averagenumberofrows'] = '';
			$error['Foliagecolor'] = '';
			$error['Alternariapminfection'] = '';
			$error['Diseasespest'] = '';
			$error['Crackingroot'] = '';
			$error['Maturityvscontrol'] = '';
			$error['Subtype'] = '';
			$error['Plantheight'] = '';
			$error['Curdshape'] = '';
			$error['Curdweight'] = '';
			$error['DiameteratShoulder'] = '';
			$error['DiameteratMidpoint'] = '';
			$error['Carrotlength'] = '';
			$error['Carrotweight'] = '';


			$error['Plantstructure'] = '';
			$error['Fruitshapeuniformity'] = '';
			$error['Plantsideshootbehaviour'] = '';
			$error['Plantfrtsnode'] = '';
			$error['PowderyMildewSf'] = '';
			$error['SkinCucumber'] = '';
			$error['DownyMildewPcu'] = '';
			$error['Fruitcolour'] = '';
			$error['Fruitcolour_cucumber'] = '';
			$error['Fruitoverallquality'] = '';
			$error['DiseaseTolerance'] = '';
			$error['Fruitquality'] = '';
			$error['Yieldcontinuity'] = '';
			$error['VisualYield'] = '';
			$error['Yieldmarketablefrtsplnt'] = '';

			$error['Fleshcolor'] = '';
			$error['Seedcavity'] = '';
			$error['Fruittaste'] = '';
			$error['Fruitsplant'] = '';
			$error['Fruitsmarketable'] = '';
			$error['Fruitsmarketableplot'] = '';
			$error['Brix'] = '';
			$error['Fruitsperplant'] = '';
			$error['Fleshfirmness'] = '';
			$error['HollowHeartSeverity'] = '';
			$error['SeedsSize'] = '';
			$error['SeedsContent'] = '';
			$error['Shelflife'] = '';
			$error['Seedcolour'] = '';
			$error['Tipfilling'] = '';
			$error['Harvesting'] = '';
			$error['Kerneltenderness'] = '';
			$error['Earkernelcolour'] = '';
			$error['Curdanthocyanin'] = '';
			$error['Yieldestimated'] = '';
			$error['PlantCover'] = '';
			$error['InternodesLength'] = '';
			$error['LeafCurlingRolling'] = '';
			$error['ParthenocarpicFruits'] = '';
			$error['PlantBalance'] = '';
			$error['Fruitsetting'] = '';
			$error['Fruitsizeuniformity'] = '';
			$error['FruitSizeuniformitycluster'] = '';
			$error['FruitRibbness'] = '';
			$error['CalyxApperarance'] = '';
			$error['Fruitcolourmaturity'] = '';
			$error['Fruitcolourbeforematurity'] = '';
			$error['FruitRindPattern'] = '';
			$error['RindAttractivness'] = '';
			$error['Fruitcolouratmaturity'] = '';
			$error['Fruitweight'] = '';
			$error['FruitSize'] = '';
			$error['Fruitwallthickness'] = '';
			$error['Fruitrindthickness'] = '';
			$error['Plantsperm2'] = '';
			$error['Rootshape'] = '';
			$error['RootSmoothness'] = '';
			$error['Shouldershape'] = '';
			$error['Rootuniformity'] = '';
			$error['Rootskin'] = '';
			$error['RootExternalcolor'] = '';
			$error['Shoulderspurplinggreen'] = '';
			$error['SplittingBreakagetolerance'] = '';
			$error['Boltingresistance'] = '';

			$error['Typeofcultivation'] = '';
			$error['Plantvigur'] = '';
			$error['Maturityindays'] = '';
			$error['Growthheight'] = '';
			$error['Flowercolour'] = '';
			$error['Podcrosssection'] = '';
			$error['Podlength'] = '';
			$error['Poddiameter'] = '';
			$error['Stringless'] = '';

			$error['Glossyness'] = '';
			$error['Primarypodcolour'] = '';
			$error['Secondarypodcolour'] = '';
			$error['Cookingvalue'] = '';

			$error['Leafattachment'] = '';
			$error['Toplength'] = '';
			$error['Foliagelength'] = '';
			$error['Leafimplant'] = '';
			$error['Foliageatittude'] = '';
			$error['Rootinternalcolor'] = '';
			$error['Rootsize'] = '';
			$error['Taprootsize'] = '';
			$error['Skinsmoothness'] = '';
			$error['Zoning'] = '';
			$error['Rootweight'] = '';
			$error['Whiterings'] = '';
			$error['Sugarcontent'] = '';
			$error['Flavour'] = '';
			$error['Noofribs'] = '';
			$error['Spinedevelopment'] = '';
			$error['Planttype'] = '';
			$error['Podshape'] = '';
			$error['Podcolour'] = '';
			$error['Kernelsperpod'] = '';
			$error['Podspernode'] = '';
			$error['Standingleaves'] = '';
			$error['Radishshape'] = '';
			$error['Radishdevelopment'] = '';
			$error['Radishuniformity'] = '';
			$error['Root'] = '';
			$error['Radishcolour'] = '';
			$error['Yieldmarketablefrtsweight'] = '';
			$error['Headtype'] = '';
			$error['HeatColdresisttol'] = '';
			// Development
			$error['SupplierName'] = '';
			$error['Crop'] = '';
			$error['Variety'] = '';
			$error['Location'] = '';
			$error['Dateofsowing'] = '';
			$error['Dateoftransplanted'] = '';
			$error['Estimatedharvestingdate'] = '';
			$error['Fullname'] = '';
			$error['AddedDate'] = '';
		/*======= Default Error END =============*/

		/*======= Crops View START =============*/
			$Crops = array();
			$Crops['Broccoli']='broccoli.php';
			$Crops['Brussels']='brussels.php';
			$Crops['Sunflower']='sunflower.php';
			$Crops['Turnip']='turnip.php';
			$Crops['Spinach']='spinach.php';
			$Crops['leaf vegetable']='leafvegetable.php';
			$Crops['Bunching onion']='bunchingonion.php';
			$Crops['Celery']='celery.php';
			$Crops['Soybean']='soybean.php';
			$Crops['Corn']='corn.php';
			$Crops['Pumpkin']='pumpkin.php';
			$Crops['Cabbage']='cabbage.php';
			$Crops['Carrot']='carrot.php';
			$Crops['Cauliflower']='cauliflower.php';
			$Crops['Cucumber']='cucumber.php';
			$Crops['Cucumber- Indoor']='cucumber.php';
			$Crops['Cucumber- Outdoor']='cucumber.php';
			$Crops['Tomato- Det.']='dettomato.php';
			$Crops['Tomato- Indet.']='indettomato.php';
			$Crops['Eggplant']='eggplant.php';
			$Crops['Lettuce']='lettuce.php';
			$Crops['Melon']='melon.php';
			$Crops['Onion']='onion.php';
			$Crops['Pepper']='pepper.php';
			$Crops['Squash']='squash.php';
			$Crops['Sweet Corn']='sweetcorn.php';
			$Crops['Watermelon']='watermelon.php';
			$Crops['Beans']='beans.php';
			$Crops['Beetroot']='beetroot.php';
			$Crops['Kohlrabi']='kohlrabi.php';
			$Crops['Pea']='pea.php';
			$Crops['Radish']='radish.php';
			$Crops['Rootstock']='rootstock.php';
			$Crops['Chinese cabbage']='chinesecabbage.php';
			$Crops['Okra']='okra.php';


			$get_single_evaluation =array();
			
			$cropview = '';
			$getsampling = array();
			if(@$_GET['Internalseedcode']!=''){
				$get_sampling_count = $this->Evaluationadmin->get_sampling_count($_GET['Internalseedcode']);
				$getsampling = $get_sampling_count[0];			

				$location = $getsampling['Location'];

				$CropID = $getsampling['Crop'];
				$get_single_crop = $this->Evaluationadmin->get_single_crop($CropID);
				$crops_title = $get_single_crop['Title'];

				$ReceiverID = $getsampling['Receiver'];
				$get_receiver = $this->Evaluationadmin->get_crop_by_receiverid($ReceiverID);
				$Receiver_name = $get_receiver['Name'];

				$get_crop = $this->Evaluationadmin->get_crop($get_sampling_count[0]['Crop']);
				$getcropTitle = $get_crop['Title'];

				$get_seed = $this->Evaluationadmin->get_seed($get_sampling_count[0]['Seed']);
				$getseedStatus = $get_seed['Status'];
				
				$get_single_evaluation['CheckInternalsamplecodecontrolvariety'] = '';
				if($getseedStatus!='5'){
					$get_single_evaluation['CheckInternalsamplecodecontrolvariety'] = '1';
				}

				if (array_key_exists($getcropTitle,$Crops)){
					$cropview = $Crops[$getcropTitle];
				}else{
					$cropview = 'common.php';
				}
			}
		/*======= Crops View END =============*/

		/*======= Defult Value START =============*/
		
			if(@$_GET['Internalseedcode']!=''){
				$get_single_evaluation['Internalsamplecode'] = $_GET['Internalseedcode'];
				$get_single_evaluation['CheckInternalcode'] = '1';
			}else{
				$get_single_evaluation['Internalsamplecode'] = '';
				$get_single_evaluation['CheckInternalcode'] = '';
			}

			$get_single_evaluation['Internalsamplecodecontrolvariety'] = '';
			$get_single_evaluation['Picture'] = '';
			$get_single_evaluation['Dateofvisit'] = '';
			$get_single_evaluation['Plantvigur'] = '';
			$get_single_evaluation['Plantsize'] = '';
			$get_single_evaluation['Bulbshape'] = '';
			$get_single_evaluation['Bulbshapeuniformit'] = '';
			$get_single_evaluation['Varietytype'] = '';
			$get_single_evaluation['Headformation'] = '';
			$get_single_evaluation['Leafcolour'] = '';
			$get_single_evaluation['Headsize'] = '';
			$get_single_evaluation['Leaftexture'] = '';
			$get_single_evaluation['Fruitshape'] = '';
			$get_single_evaluation['Fruitnetting'] = '';
			$get_single_evaluation['Fruitribbing'] = '';
			$get_single_evaluation['Yield'] = '';
			$get_single_evaluation['Spongeness'] = '';
			$get_single_evaluation['FruitGreenShoulders'] = '';
			$get_single_evaluation['Fruitcracking'] = '';
			$get_single_evaluation['FruitFirmnessatfinalcolour'] = '';
			$get_single_evaluation['Fruitintensityofcolouratmaturity'] = '';
			$get_single_evaluation['Fruitintensityofcolourbeforematurity'] = '';
			$get_single_evaluation['Maturity'] = '';
			$get_single_evaluation['Firmness'] = '';
			$get_single_evaluation['Fruitglossiness'] = '';
			$get_single_evaluation['Uniformity'] = '';
			$get_single_evaluation['Fruitsettingunderlowtemperature'] = '';
			$get_single_evaluation['Fruitsettingunderhightemperature'] = '';
			$get_single_evaluation['Fieldstandingability'] = '';
			$get_single_evaluation['Resistance'] = '';
			$get_single_evaluation['Averagewieght'] = '';
			$get_single_evaluation['AveragewieghtIn'] = '';
			$get_single_evaluation['Friutwidth'] = '';
			$get_single_evaluation['Harvestlongevity'] = '';
			$get_single_evaluation['FriutwidthIn'] = '';
			$get_single_evaluation['Friutlength'] = '';
			$get_single_evaluation['Numberofseeds'] = '';
			$get_single_evaluation['ByWhen'] = '';
			$get_single_evaluation['Fruitdiameter'] = '';
			$get_single_evaluation['FriutlengthIn'] = '';
			$get_single_evaluation['Fruitcolor'] = '';
			$get_single_evaluation['Overallrating'] = '';
			$get_single_evaluation['Comment'] = '';
			$get_single_evaluation['Pictures'] = '';
			$get_single_evaluation['Status'] = '';
			$get_single_evaluation['Dropmessage'] = '';

			$get_single_evaluation['Plantframesize'] = '';
			$get_single_evaluation['Stemthickness'] = '';
			$get_single_evaluation['Headweight'] = '';
			$get_single_evaluation['Headlength'] = '';
			$get_single_evaluation['Headdiameter'] = '';
			$get_single_evaluation['Curdcolor'] = '';
			$get_single_evaluation['Curdcover'] = '';
			$get_single_evaluation['CurdUniformity'] = '';
			$get_single_evaluation['Fieldholdability'] = '';
			$get_single_evaluation['Headshape'] = '';
			$get_single_evaluation['Headknobbling'] = '';
			$get_single_evaluation['Beadsize'] = '';
			$get_single_evaluation['Headuniformity'] = '';
			$get_single_evaluation['Firmness_broccoli'] = '';
			$get_single_evaluation['Sideshoots'] = '';
			$get_single_evaluation['Fieldstandingability'] = '';
			$get_single_evaluation['Heatresittol'] = '';
			$get_single_evaluation['Coldresisttol'] = '';
			$get_single_evaluation['Rating'] = '';
			$get_single_evaluation['Dryskinafterharvest'] = '';
			$get_single_evaluation['Necksize'] = '';
			$get_single_evaluation['Thicknessofdryskin'] = '';
			$get_single_evaluation['Basecolourdryskin'] = '';
			$get_single_evaluation['Widthofneck'] = '';
			$get_single_evaluation['Storability'] = '';
			$get_single_evaluation['Noofdoublecenter'] = '';
			$get_single_evaluation['Yieldmarketable'] = '';
			$get_single_evaluation['Yieldnonmarketable'] = '';
			$get_single_evaluation['YieldD57'] = '';
			$get_single_evaluation['YieldD79'] = '';
			$get_single_evaluation['YieldD9'] = '';
			$get_single_evaluation['Conclusion'] = '';
			$get_single_evaluation['Advantages'] = '';
			$get_single_evaluation['Disadvantages'] = '';
			$get_single_evaluation['Remarks'] = '';
			$get_single_evaluation['Headcolor'] = '';
			$get_single_evaluation['Leafwaxiness'] = '';
			$get_single_evaluation['anthocyanincolorationofcoverleaf'] = '';
			$get_single_evaluation['Coresize'] = '';
			$get_single_evaluation['Headdensity'] = '';
			$get_single_evaluation['Marketsegment'] = '';
			$get_single_evaluation['Growthtype'] = '';
			$get_single_evaluation['Planthabit'] = '';
			$get_single_evaluation['Silvering'] = '';
			$get_single_evaluation['Branching'] = '';
			$get_single_evaluation['YongfruitRatio'] = '';
			$get_single_evaluation['Stripesripefruit'] = '';
			$get_single_evaluation['Blossomscar'] = '';
			$get_single_evaluation['Easypicking'] = '';
			$get_single_evaluation['PostHarvestQuality'] = '';
			$get_single_evaluation['EarlyYield'] = '';
			$get_single_evaluation['Fruitnumbercluster'] = '';
			$get_single_evaluation['TotalYield'] = '';
			$get_single_evaluation['Anthocyanin'] = '';
			$get_single_evaluation['Firstearheight'] = '';
			$get_single_evaluation['Earlength'] = '';
			$get_single_evaluation['Eardiameter'] = '';
			$get_single_evaluation['Numberofears'] = '';
			$get_single_evaluation['Corncoblength'] = '';
			$get_single_evaluation['Earhuskleafcolor'] = '';
			$get_single_evaluation['Flagleavesappearanceonear'] = '';
			$get_single_evaluation['EarProtection'] = '';
			$get_single_evaluation['Averagenumberofrows'] = '';
			$get_single_evaluation['Foliagecolor'] = '';
			$get_single_evaluation['Alternariapminfection'] = '';
			$get_single_evaluation['Diseasespest'] = '';
			$get_single_evaluation['Crackingroot'] = '';
			$get_single_evaluation['Maturityvscontrol'] = '';
			$get_single_evaluation['Subtype'] = '';
			$get_single_evaluation['Plantheight'] = '';
			$get_single_evaluation['Curdshape'] = '';
			$get_single_evaluation['Curdweight'] = '';
			$get_single_evaluation['DiameteratShoulder'] = '';
			$get_single_evaluation['DiameteratMidpoint'] = '';
			$get_single_evaluation['Carrotlength'] = '';
			$get_single_evaluation['Carrotweight'] = '';


			$get_single_evaluation['Plantstructure'] = '';
			$get_single_evaluation['Fruitshapeuniformity'] = '';
			$get_single_evaluation['Plantsideshootbehaviour'] = '';
			$get_single_evaluation['Plantfrtsnode'] = '';
			$get_single_evaluation['PowderyMildewSf'] = '';
			$get_single_evaluation['SkinCucumber'] = '';
			$get_single_evaluation['DownyMildewPcu'] = '';
			$get_single_evaluation['Fruitcolour'] = '';
			$get_single_evaluation['Fruitcolour_cucumber'] = '';
			$get_single_evaluation['Fruitoverallquality'] = '';
			$get_single_evaluation['DiseaseTolerance'] = '';
			$get_single_evaluation['Fruitquality'] = '';
			$get_single_evaluation['Yieldcontinuity'] = '';
			$get_single_evaluation['VisualYield'] = '';
			$get_single_evaluation['Yieldmarketablefrtsplnt'] = '';

			$get_single_evaluation['Fleshcolor'] = '';
			$get_single_evaluation['Seedcavity'] = '';
			$get_single_evaluation['Fruittaste'] = '';
			$get_single_evaluation['Fruitsplant'] = '';
			$get_single_evaluation['Fruitsmarketable'] = '';
			$get_single_evaluation['Fruitsmarketableplot'] = '';
			$get_single_evaluation['Brix'] = '';
			$get_single_evaluation['Fruitsperplant'] = '';
			$get_single_evaluation['Fleshfirmness'] = '';
			$get_single_evaluation['HollowHeartSeverity'] = '';
			$get_single_evaluation['SeedsSize'] = '';
			$get_single_evaluation['SeedsContent'] = '';
			$get_single_evaluation['Shelflife'] = '';
			$get_single_evaluation['Seedcolour'] = '';
			$get_single_evaluation['Tipfilling'] = '';
			$get_single_evaluation['Harvesting'] = '';
			$get_single_evaluation['Kerneltenderness'] = '';
			$get_single_evaluation['Earkernelcolour'] = '';
			$get_single_evaluation['Curdanthocyanin'] = '';
			$get_single_evaluation['Yieldestimated'] = '';
			$get_single_evaluation['PlantCover'] = '';
			$get_single_evaluation['InternodesLength'] = '';
			$get_single_evaluation['LeafCurlingRolling'] = '';
			$get_single_evaluation['ParthenocarpicFruits'] = '';
			$get_single_evaluation['PlantBalance'] = '';
			$get_single_evaluation['Fruitsetting'] = '';
			$get_single_evaluation['Fruitsizeuniformity'] = '';
			$get_single_evaluation['FruitSizeuniformitycluster'] = '';
			$get_single_evaluation['FruitRibbness'] = '';
			$get_single_evaluation['CalyxApperarance'] = '';
			$get_single_evaluation['Fruitcolourmaturity'] = '';
			$get_single_evaluation['Fruitcolourbeforematurity'] = '';
			$get_single_evaluation['FruitRindPattern'] = '';
			$get_single_evaluation['RindAttractivness'] = '';
			$get_single_evaluation['Fruitcolouratmaturity'] = '';
			$get_single_evaluation['Fruitweight'] = '';
			$get_single_evaluation['FruitSize'] = '';
			$get_single_evaluation['Fruitwallthickness'] = '';
			$get_single_evaluation['Fruitrindthickness'] = '';
			$get_single_evaluation['Plantsperm2'] = '';
			$get_single_evaluation['Rootshape'] = '';
			$get_single_evaluation['RootSmoothness'] = '';
			$get_single_evaluation['Shouldershape'] = '';
			$get_single_evaluation['Rootuniformity'] = '';
			$get_single_evaluation['Rootskin'] = '';
			$get_single_evaluation['RootExternalcolor'] = '';
			$get_single_evaluation['Shoulderspurplinggreen'] = '';
			$get_single_evaluation['SplittingBreakagetolerance'] = '';
			$get_single_evaluation['Boltingresistance'] = '';
			$get_single_evaluation['Typeofcultivation'] = '';
			$get_single_evaluation['Plantvigur'] = '';
			$get_single_evaluation['Maturityindays'] = '';
			$get_single_evaluation['Growthheight'] = '';
			$get_single_evaluation['Flowercolour'] = '';
			$get_single_evaluation['Podcrosssection'] = '';
			$get_single_evaluation['Podlength'] = '';
			$get_single_evaluation['Poddiameter'] = '';
			$get_single_evaluation['Stringless'] = '';
			$get_single_evaluation['Glossyness'] = '';

			$get_single_evaluation['Primarypodcolour'] = '';
			$get_single_evaluation['Secondarypodcolour'] = '';
			$get_single_evaluation['Cookingvalue'] = '';
			$get_single_evaluation['Leafattachment'] = '';
			$get_single_evaluation['Toplength'] = '';
			$get_single_evaluation['Foliagelength'] = '';
			$get_single_evaluation['Leafimplant'] = '';
			$get_single_evaluation['Foliageatittude'] = '';
			$get_single_evaluation['Rootinternalcolor'] = '';
			$get_single_evaluation['Rootsize'] = '';
			$get_single_evaluation['Taprootsize'] = '';
			$get_single_evaluation['Skinsmoothness'] = '';
			$get_single_evaluation['Zoning'] = '';
			$get_single_evaluation['Rootweight'] = '';
			$get_single_evaluation['Whiterings'] = '';
			$get_single_evaluation['Sugarcontent'] = '';
			$get_single_evaluation['Flavour'] = '';
			$get_single_evaluation['Noofribs'] = '';
			$get_single_evaluation['Spinedevelopment'] = '';
			$get_single_evaluation['Planttype'] = '';
			$get_single_evaluation['Podshape'] = '';
			$get_single_evaluation['Podcolour'] = '';
			$get_single_evaluation['Kernelsperpod'] = '';
			$get_single_evaluation['Podspernode'] = '';
			$get_single_evaluation['Standingleaves'] = '';
			$get_single_evaluation['Radishshape'] = '';
			$get_single_evaluation['Radishdevelopment'] = '';
			$get_single_evaluation['Radishuniformity'] = '';
			$get_single_evaluation['Root'] = '';
			$get_single_evaluation['Radishcolour'] = '';
			$get_single_evaluation['Yieldmarketablefrtsweight'] = '';
			$get_single_evaluation['Headtype'] = '';
			$get_single_evaluation['HeatColdresisttol'] = '';
		/*======= Defult Value END =============*/

		if($EvaluationID){
			$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);
			
			$get_single_evaluation['CheckInternalcode'] = '1';

			$get_sampling_count = $this->Evaluationadmin->get_sampling_count($get_single_evaluation['Internalsamplecode']);

			@$getsampling = $get_sampling_count[0];

			@$get_crop = $this->Evaluationadmin->get_crop($get_sampling_count[0]['Crop']);
			$getcropTitle = $get_crop['Title'];

			@$get_seed = $this->Evaluationadmin->get_seed($get_sampling_count[0]['Seed']);
			$getseedStatus = $get_seed['Status'];
			
			$get_single_evaluation['CheckInternalsamplecodecontrolvariety'] = '';
			if($getseedStatus!='5'){
				$get_single_evaluation['CheckInternalsamplecodecontrolvariety'] = '1';
			}

			if (array_key_exists($getcropTitle,$Crops)){
				$cropview = $Crops[$getcropTitle];
			}else{
				$cropview = 'common.php';
			}
			// Development
			$get_sampling = $this->Evaluationadmin->get_sampling($get_single_evaluation['Internalsamplecode']);
			$get_crop = $this->Evaluationadmin->get_crop($get_sampling['Crop']);
			$get_supplier = $this->Evaluationadmin->get_supplier($get_sampling['SupplierID']);
			if($get_supplier){
				$get_single_evaluation['SupplierName'] = $get_supplier['Name'];
			}
			if($get_crop){
				$get_single_evaluation['Crop'] = $get_crop['Title'];
			}
			$get_seed = $this->Evaluationadmin->get_seed($get_sampling['Seed']);
			if($get_seed){
				$get_single_evaluation['Variety'] = $get_seed['Variety'];
			}
			$get_single_evaluation['Location'] = $get_sampling['Location'];
			$get_single_evaluation['Dateofsowing'] = $get_sampling['Dateofsowing'];
			$get_single_evaluation['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
			$get_single_evaluation['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
			$get_users = $this->Evaluationadmin->get_users($get_single_evaluation['UserID']);
			if($get_users){
				$get_single_evaluation['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];
			}
			$get_single_evaluation['AddedDate'];
			$get_single_evaluation['userrole'];

			$data['heading_title']='Edit Evaluation';
		}else{
			$data['heading_title']='Add Evaluation';
		}

			
		/*======= Post Data START =============*/

		if (($this->input->server('REQUEST_METHOD') == 'POST')){
			$this ->load->library('form_validation');
			$this->form_validation->set_rules('Internalsamplecode', 'Internal sample code', 'required|trim');
			
			if ($this->form_validation->run() == FALSE) {
				if(form_error('Internalsamplecode')){
					$error['Internalsamplecode']  =form_error('Internalsamplecode');
				}
				
			}else{
				$datapost =array();			
				$datapost = $this->input->post();
				unset($datapost['CheckInternalcode']);
				unset($datapost['CheckInternalsamplecodecontrolvariety']);
				unset($datapost['img_exits']);

				if(@$_FILES["Picture"]["name"] != ''){	
		        	$config['upload_path']   = 'uploads/Evaluation';
		            //$config['allowed_types'] = 'jpg|png|jpeg';
		            //$config['max_size'] = '3072';
		            $config['file_name'] = time()."".rand(1,1000)."_".trim(preg_replace('/\s+/', ' ', $_FILES['Picture']['name']));

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if($this->upload->do_upload('Picture')){
		                $uploadData = $this->upload->data();
		                 $this->resizeImage($uploadData['file_name']); 
			            $datapost['Picture'] = $uploadData['file_name'];
					}
		        }
		        /*echo "<pre>";
		        print_r($this->input->post('img_exits'));
		        echo "</pre>"; die;*/
				$upload_filename = array();
				if( $this->input->post('img_exits') != '' ){
                    $img_exits_array  = $this->input->post('img_exits');
                    foreach($img_exits_array as $img_exits_value){
                         $img_exits_value;
                         $upload_filename[] =$img_exits_value;
                    }
                }

				if(@$_FILES["files"]["name"] != ''){
                    $targetDir = "uploads/Evaluation/";
                    $allowTypes = array('jpg','png','jpeg','gif','mp4','mov');
                    $images_arr = array();
                    $date = date('d_m_Y');
                    foreach($_FILES['files']['name'] as $key=>$val){

                        $image_name = time()."_".$key."_".$date."_".$_FILES['files']['name'][$key];
                        $tmp_name   = $_FILES['files']['tmp_name'][$key];
                        $size       = $_FILES['files']['size'][$key];
                        $type       = $_FILES['files']['type'][$key];
                        $error      = $_FILES['files']['error'][$key];
                        // File upload path
                        $fileName = basename($image_name);
                        $file_Name = str_replace(' ', '_', $fileName);
                        $targetFilePath = $targetDir . $file_Name;
                        // Check whether file type is valid
                        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                        //if(in_array($fileType, $allowTypes)){    
                            // Store file on the server
                            if(move_uploaded_file($_FILES['files']['tmp_name'][$key],$targetFilePath)){
                                $images_arr[] = $targetFilePath;

                                $single_file = array();
	                            $single_file['name'] = $file_Name;
	                            if($fileType=='mp4' || $fileType=='mov'){
	                            	$single_file['type'] = 2;
	                            	$this->create_videothumbnail($file_Name);
	                            }else{
	                            	$single_file['type'] = 1;
	                            	$this->resizeImage($file_Name);	
	                            }
                            	$upload_filename[] = $single_file;
                            }
                        //}
                    }
                }

            	$datapost['Pictures'] = json_encode($upload_filename);
				
                $datalog = array();
				$datalog['UserID'] = $this->session->userdata('UserID');
				if($EvaluationID){
					$getsingleevaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);
					$this->Evaluationadmin->update_evaluation($datapost,$EvaluationID);
					$this->session->set_flashdata('success', 'Evaluation update successfully.');

					$datalog['Activity'] = 'Update';
					$datalog['Title'] = 'Evaluation update EvaluationID: '.$EvaluationID;
					$datalog['Data'] = json_encode($getsingleevaluation);
				}else{
					$datapost['UserID'] = $this->session->userdata('UserID');
					$get_users = $this->Evaluationadmin->get_users($datapost['UserID']);
					// development
					$datapost['userrole'] = $get_users['userrole'];
					$datapost['Source'] = 'ADMIN';
					$EvaluationID= $this->Evaluationadmin->insert_evaluation($datapost);
					$this->session->set_flashdata('success', 'Evaluation added successfully.');
					$datalog['Activity'] = 'Insert';
					$datalog['Title'] = 'Evaluation added EvaluationID: '.$EvaluationID;
					$datalog['Data'] = json_encode($datapost);
				}	


				/*====== For Re-check and Pre-commercial ===========*/
				$datarecheck = array();
				$datarecheck['EvaluationID']=$EvaluationID;
				$get_rechecks_evaluation = $this->Evaluationadmin->get_rechecks_evaluation($EvaluationID);
				// $Internalsamplecode = $_GET['Internalseedcode'];
				foreach ($get_rechecks_evaluation as $value) {
					$Internalsamplecode = $value['Internalsamplecode'];
					$UserID = $value['UserID'];
					$Numberofseeds = $value['Numberofseeds'];
					$ByWhen = $value['ByWhen'];
				}
				$get_rechecks_sampling = $this->Evaluationadmin->get_rechecks_sampling($Internalsamplecode);
				foreach ($get_rechecks_sampling as $value) {
					$get_crop = $value['Crop'];
					$get_seed = $value['Seed'];
					$Supplier = $value['SupplierID'];
				}
				$get_rechecks_seeds = $this->Evaluationadmin->get_rechecks_seeds($get_seed);
				foreach ($get_rechecks_seeds as $value) {
					$Variety = $value['Variety'];
				}
				$datarecheck['UserID'] = $UserID;
				$datarecheck['Numebrofseedsrequast'] = $Numberofseeds;
				$datarecheck['Bywhen'] = $ByWhen;
				$datarecheck['Crop'] = $get_crop;
				$datarecheck['Variety'] = $Variety;
				$datarecheck['Supplier'] = $Supplier;
				$dataprecommercial = array();
				$dataprecommercial['EvaluationID']=$EvaluationID;

				if($EvaluationID){					
					if($this->input->post('Status')=='Re-check'){
						$check_recheck = $this->Evaluationadmin->check_recheck($datarecheck['Crop']);
						if($check_recheck==0){
							$this->Evaluationadmin->insert_recheck($datarecheck);
						}
						else{
							$this->Evaluationadmin->update_recheck($datarecheck,$datarecheck['Crop']);
						}
						$this->Evaluationadmin->delete_precommercial($EvaluationID);
					}elseif($this->input->post('Status')=='Pre-commercial'){
						$check_precommercial = $this->Evaluationadmin->check_precommercial($EvaluationID);
						if($check_precommercial==0){
							$this->Evaluationadmin->insert_precommercial($dataprecommercial);
						}
						$this->Evaluationadmin->delete_recheck($EvaluationID);
					}else{
						$this->Evaluationadmin->delete_precommercial($EvaluationID);
						$this->Evaluationadmin->delete_recheck($EvaluationID);
					}	
				}	
				/*======END For Re-check and Pre-commercial ===========*/

				$this->Evaluationadmin->insert_log($datalog);

				redirect('admin/evaluation');
				exit();
			}

			$get_single_evaluation = $this->input->post();
			$get_single_evaluation['Picture']='';
			$get_single_evaluation['CheckInternalcode'] = '1';

		}
		/*======= Post Data END =============*/

		/*======= Default Options Array START ===*/
		

			$Plantvigur_cabbage =array();
			$Plantvigur_cabbage[] = 'Very weak';
			$Plantvigur_cabbage[] = 'Weak';
			$Plantvigur_cabbage[] = 'Medium';
			$Plantvigur_cabbage[] = 'Strong';
			$Plantvigur_cabbage[] = 'Very strong';

			$Plantvigur_broccoli =array();
			$Plantvigur_broccoli[] = 'Very weak';
			$Plantvigur_broccoli[] = 'Weak';
			$Plantvigur_broccoli[] = 'Medium';
			$Plantvigur_broccoli[] = 'Strong';
			$Plantvigur_broccoli[] = 'Very strong';

			$Plantvigur_cucumber =array();
			$Plantvigur_cucumber[] = 'Very weak';
			$Plantvigur_cucumber[] = 'Weak';
			$Plantvigur_cucumber[] = 'Medium';
			$Plantvigur_cucumber[] = 'Strong';
			$Plantvigur_cucumber[] = 'Very strong';

			$Plantvigur_dettomato =array();
			$Plantvigur_dettomato[] = 'Very weak';
			$Plantvigur_dettomato[] = 'Weak';
			$Plantvigur_dettomato[] = 'Medium';
			$Plantvigur_dettomato[] = 'Strong';
			$Plantvigur_dettomato[] = 'Very strong';

			$Plantvigur_indtomato =array();
			$Plantvigur_indtomato[] = 'Very weak';
			$Plantvigur_indtomato[] = 'Weak';
			$Plantvigur_indtomato[] = 'Medium';
			$Plantvigur_indtomato[] = 'Strong';
			$Plantvigur_indtomato[] = 'Very strong';

			$Plantvigur_squash =array();
			$Plantvigur_squash[] = 'Very weak';
			$Plantvigur_squash[] = 'Weak';
			$Plantvigur_squash[] = 'Medium';
			$Plantvigur_squash[] = 'Strong';
			$Plantvigur_squash[] = 'Very strong';

			$Plantvigur_eggplant =array();
			$Plantvigur_eggplant[] = 'Very weak';
			$Plantvigur_eggplant[] = 'Weak';
			$Plantvigur_eggplant[] = 'Medium';
			$Plantvigur_eggplant[] = 'Strong';
			$Plantvigur_eggplant[] = 'Very strong';

			$Plantvigur_pepper =array();
			$Plantvigur_pepper[] = 'Very weak';
			$Plantvigur_pepper[] = 'Weak';
			$Plantvigur_pepper[] = 'Medium';
			$Plantvigur_pepper[] = 'Strong';
			$Plantvigur_pepper[] = 'Very strong';

			$Plantvigur_sweetcorn =array();
			$Plantvigur_sweetcorn[] = 'Very weak';
			$Plantvigur_sweetcorn[] = 'Weak';
			$Plantvigur_sweetcorn[] = 'Medium';
			$Plantvigur_sweetcorn[] = 'Strong';
			$Plantvigur_sweetcorn[] = 'Very strong';

			$Plantsize =array();
			$Plantsize[] = 'Small';
			$Plantsize[] = 'Medium';
			$Plantsize[] = 'Large';

			$Bulbshape =array();
			$Bulbshape[] = 'Broad obovate';
			$Bulbshape[] = 'Rhombic';
			$Bulbshape[] = 'Transverse medium elliptic';
			$Bulbshape[] = 'Transverse narrow elliptic';

			$Bulbshape_onion =array();
			$Bulbshape_onion[] = 'Elliptic';
			$Bulbshape_onion[] = 'Medium ovate';
			$Bulbshape_onion[] = 'Broad elliptic';
			$Bulbshape_onion[] = 'Circular';
			$Bulbshape_onion[] = 'Broad obovate';
			$Bulbshape_onion[] = 'Rhombic';
			$Bulbshape_onion[] = 'Transverse medium elliptic';
			$Bulbshape_onion[] = 'Transverse narrow elliptic';


			$Bulbshapeuniformit =array();
			$Bulbshapeuniformit[] = 'Very poor';
			$Bulbshapeuniformit[] = 'Poor';
			$Bulbshapeuniformit[] = 'Medium';
			$Bulbshapeuniformit[] = 'Good';
			$Bulbshapeuniformit[] = 'Very good';

			$Varietytype =array();
			$Varietytype[] = 'Iceberg';
			// $Varietytype[] = 'Crisphead';
			$Varietytype[] = 'Cos romaine';
			$Varietytype[] = 'Loose leaf';
			$Varietytype[] = 'Butterhead';
			$Varietytype[] = 'Batavia';

			$Varietytype_beans =array();
			$Varietytype_beans[] = 'Dwarf french';
			$Varietytype_beans[] = 'Dwarf slicing';
			$Varietytype_beans[] = 'Dwarf flageolet';
			$Varietytype_beans[] = 'Dwarf semi-dry/dry shelling';
			$Varietytype_beans[] = 'Pole';
			$Varietytype_beans[] = 'Runner';

			$Varietytype_kohlrabi =array();
			$Varietytype_kohlrabi[] = 'White green';
			$Varietytype_kohlrabi[] = 'Purple';

			$Varietytype_squash =array();
			$Varietytype_squash[] = 'Butternut';
			$Varietytype_squash[] = 'Zucchini';
			$Varietytype_squash[] = 'Scallop';
			$Varietytype_squash[] = 'Round/Ball';
			$Varietytype_squash[] = 'Acorn';
			$Varietytype_squash[] = 'Lebanese';

			$Varietytype_sweetcorn =array();
			$Varietytype_sweetcorn[] = 'Sweet';
			$Varietytype_sweetcorn[] = 'Super sweet';


			$Headformation =array();
			$Headformation[] = 'N.a.';
			$Headformation[] = 'No head';
			$Headformation[] = 'Open head';
			$Headformation[] = 'Closed head';

			$Headformation_lettuce =array();
			$Headformation_lettuce[] = 'No head';
			$Headformation_lettuce[] = 'Open head';
			$Headformation_lettuce[] = 'Closed head';

			$Leafcolour =array();
			$Leafcolour[] = 'Light green';
			$Leafcolour[] = 'Medium green';
			$Leafcolour[] = 'Dark green';
			$Leafcolour[] = 'Red';
			$Leafcolour[] = 'Ruby red';
			$Leafcolour[] = 'Bronze red';
			$Leafcolour[] = 'Extra dark red';
			$Leafcolour[] = 'Bronze-green';

			$Leafcolour_beetroot =array();
			$Leafcolour_beetroot[] = 'Light green';
			$Leafcolour_beetroot[] = 'Green';
			$Leafcolour_beetroot[] = 'Dark green';
			$Leafcolour_beetroot[] = 'Dark green, glossy';

			$Leafcolour_kohlrabi =array();
			$Leafcolour_kohlrabi[] = 'Light green';
			$Leafcolour_kohlrabi[] = 'Medium green';
			$Leafcolour_kohlrabi[] = 'Green';
			$Leafcolour_kohlrabi[] = 'Dark green';
			$Leafcolour_kohlrabi[] = 'Purplish green';

			$Leafcolour_okra =array();
			$Leafcolour_okra[] = 'Light green';
			$Leafcolour_okra[] = 'Medium green';
			$Leafcolour_okra[] = 'Dark green';

			$Headsize =array();
			$Headsize[] = 'Very small';
			$Headsize[] = 'Small';
			$Headsize[] = 'Medium';
			$Headsize[] = 'Large';
			$Headsize[] = 'Very large';

			$Leaftexture =array();
			$Leaftexture[] = 'Crisp';
			$Leaftexture[] = 'Waxy';

			$Fruitshape =array();

			$Fruitshape[] = 'Very poor';
			$Fruitshape[] = 'Poor';
			$Fruitshape[] = 'Medium';
			$Fruitshape[] = 'Good';
			$Fruitshape[] = 'Excellent';

			$Fruitshape_dettomato= array();
			$Fruitshape_dettomato[] = 'Round flat';
			$Fruitshape_dettomato[] = 'Round';
			$Fruitshape_dettomato[] = 'Oval';
			$Fruitshape_dettomato[] = 'Square round';
			$Fruitshape_dettomato[] = 'Elongated';
			$Fruitshape_dettomato[] = 'Other';

			$Fruitshape_eggplant = array();
			$Fruitshape_eggplant[] = 'Globular';
			$Fruitshape_eggplant[] = 'Ovide';
			$Fruitshape_eggplant[] = 'Obovate';
			$Fruitshape_eggplant[] = 'Pear shaped';
			$Fruitshape_eggplant[] = 'Club shaped';
			$Fruitshape_eggplant[] = 'Ellipsoid';
			$Fruitshape_eggplant[] = 'Cylindrical';

			$Fruitshape_indtomato = array();
			$Fruitshape_indtomato[] = 'Oblate';
			$Fruitshape_indtomato[] = 'Deep oblate/Beef';
			$Fruitshape_indtomato[] = 'Globe/Round';
			$Fruitshape_indtomato[] = 'Deep globe';
			$Fruitshape_indtomato[] = 'Square round';
			$Fruitshape_indtomato[] = 'Other';

			$Fruitshape_melon = array();
			$Fruitshape_melon[] = 'Very elongate';
			$Fruitshape_melon[] = 'Elongate';
			$Fruitshape_melon[] = 'Oval';
			$Fruitshape_melon[] = 'Round oval';
			$Fruitshape_melon[] = 'Round';

			$Fruitshape_okra = array();
			$Fruitshape_okra[] = 'Round';
			$Fruitshape_okra[] = 'Oval';
			$Fruitshape_okra[] = 'Elongated';

			$Fruitshape_pepper = array();
			$Fruitshape_pepper[] = 'Blocky';
			$Fruitshape_pepper[] = 'Lamuyo';
			$Fruitshape_pepper[] = 'Pointed';
			$Fruitshape_pepper[] = 'Other';

			$Fruitshape_squash = array();
			$Fruitshape_squash[] = 'Disc shaped';
			$Fruitshape_squash[] = 'Globular';
			$Fruitshape_squash[] = 'Top shaped';
			$Fruitshape_squash[] = 'Pear shaped';
			$Fruitshape_squash[] = 'Club shaped';
			$Fruitshape_squash[] = 'Cylindrical';

			$Fruitshape_watermelon = array();
			$Fruitshape_watermelon[] = 'Very elongated';
			$Fruitshape_watermelon[] = 'Elongated';
			$Fruitshape_watermelon[] = 'Oval';
			$Fruitshape_watermelon[] = 'Round oval';
			$Fruitshape_watermelon[] = 'Round';

			$Fruitshape_chinesecabbage = array();
			$Fruitshape_chinesecabbage[] = 'Circular';
			$Fruitshape_chinesecabbage[] = 'Elliptic';
			$Fruitshape_chinesecabbage[] = 'Ovate';
			$Fruitshape_chinesecabbage[] = 'Obovate';
			$Fruitshape_chinesecabbage[] = 'Oblong';
			$Fruitshape_chinesecabbage[] = 'Narrow oblong';

			$Headtype_chinesecabbage = array();
			$Headtype_chinesecabbage[] = 'Open';
			$Headtype_chinesecabbage[] = 'Half-open';
			$Headtype_chinesecabbage[] = 'Closed';

			$HeatColdresisttol_chinesecabbage = array();
			$HeatColdresisttol_chinesecabbage[] = 'Very low';
			$HeatColdresisttol_chinesecabbage[] = 'Low';
			$HeatColdresisttol_chinesecabbage[] = 'Medium';
			$HeatColdresisttol_chinesecabbage[] = 'High';
			$HeatColdresisttol_chinesecabbage[] = 'Very high';

			$Fruitnetting =array();
			$Fruitnetting[] = 'Very poor';
			$Fruitnetting[] = 'Poor';
			$Fruitnetting[] = 'Medium';
			$Fruitnetting[] = 'Good';
			$Fruitnetting[] = 'Very good';

			$Fruitribbing =array();
			$Fruitribbing[] = 'No ribs';
			$Fruitribbing[] = 'Ribbed';
			$Fruitribbing[] = 'Very ribbed';

			$Yield =array();
			$Yield[] = 'Very low';
			$Yield[] = 'Low';
			$Yield[] = 'Medium';
			$Yield[] = 'High';
			$Yield[] = 'Very high';

			$Spongeness =array();
			$Spongeness[] = 'No';
			$Spongeness[] = 'Low';
			$Spongeness[] = 'Medium';
			$Spongeness[] = 'High';

			$Fruitnumbercluster =array();
			$Fruitnumbercluster[] = '< 4';
			$Fruitnumbercluster[] = '4-5';
			$Fruitnumbercluster[] = '5-6';
			$Fruitnumbercluster[] = '7-8';
			$Fruitnumbercluster[] = '9-10';
			$Fruitnumbercluster[] = '>10';

			$Yield_cabbage =array();
			$Yield_cabbage[] = 'Very low';
			$Yield_cabbage[] = 'Low';
			$Yield_cabbage[] = 'Medium';
			$Yield_cabbage[] = 'High';
			$Yield_cabbage[] = 'Very high';

			$Yield_dettomato=array();
			$Yield_dettomato[] = 'Very low';
			$Yield_dettomato[] = 'Low';
			$Yield_dettomato[] = 'Medium';
			$Yield_dettomato[] = 'Good';
			$Yield_dettomato[] = 'Very good';

			$Yield_pepper=array();
			$Yield_pepper[] = 'Very low';
			$Yield_pepper[] = 'Low';
			$Yield_pepper[] = 'Medium';
			$Yield_pepper[] = 'Good';
			$Yield_pepper[] = 'Very good';

			$FruitGreenShoulders =array();
			// $FruitGreenShoulders[] = 'Very severe';
			$FruitGreenShoulders[] = 'Severe';
			$FruitGreenShoulders[] = 'Medium';
			$FruitGreenShoulders[] = 'Few symptoms';
			$FruitGreenShoulders[] = 'Non';

			$Fruitcracking =array();
			$Fruitcracking[] = 'Very weak';
			$Fruitcracking[] = 'Weak';
			$Fruitcracking[] = 'Medium';
			$Fruitcracking[] = 'Strong';
			$Fruitcracking[] = 'Very strong';

			$Fruitcracking_dettomato =array();
			// $Fruitcracking_dettomato[] = 'Too much';
			$Fruitcracking_dettomato[] = 'Severe';
			$Fruitcracking_dettomato[] = 'Some';
			$Fruitcracking_dettomato[] = 'A Little';
			$Fruitcracking_dettomato[] = 'Non';

			$Fruitcracking_indtomato =array();
			$Fruitcracking_indtomato[] = 'Too much';
			$Fruitcracking_indtomato[] = 'Severe';
			$Fruitcracking_indtomato[] = 'Some';
			$Fruitcracking_indtomato[] = 'A Little';
			$Fruitcracking_indtomato[] = 'Non';

			$Fruitcracking_pepper =array();
			$Fruitcracking_pepper[] = 'Very severe';
			$Fruitcracking_pepper[] = 'Severe';
			$Fruitcracking_pepper[] = 'Medium';
			$Fruitcracking_pepper[] = 'Few symptoms';
			$Fruitcracking_pepper[] = 'Non';

			$FruitFirmnessatfinalcolour =array();
			$FruitFirmnessatfinalcolour[] = 'Too soft';
			$FruitFirmnessatfinalcolour[] = 'Soft';
			$FruitFirmnessatfinalcolour[] = 'Medium';
			$FruitFirmnessatfinalcolour[] = 'Firm';
			// $FruitFirmnessatfinalcolour[] = 'Very firm';


			$Fruitintensityofcolourbeforematurity =array();
			$Fruitintensityofcolourbeforematurity[] = 'Very light';
			$Fruitintensityofcolourbeforematurity[] = 'Light';
			$Fruitintensityofcolourbeforematurity[] = 'Medium';
			$Fruitintensityofcolourbeforematurity[] = 'Dark';
			$Fruitintensityofcolourbeforematurity[] = 'Very dark';


			$Fruitintensityofcolouratmaturity =array();
			// $Fruitintensityofcolouratmaturity[] = 'Very light';
			$Fruitintensityofcolouratmaturity[] = 'Light';
			$Fruitintensityofcolouratmaturity[] = 'Normal';
			$Fruitintensityofcolouratmaturity[] = 'Deep';
			// $Fruitintensityofcolouratmaturity[] = 'Very deep red';

			$Fruitintensityofcolouratmaturity_pepper =array();
			/*$Fruitintensityofcolouratmaturity_pepper[] = 'Very light';*/
			$Fruitintensityofcolouratmaturity_pepper[] = 'Light';
			$Fruitintensityofcolouratmaturity_pepper[] = 'Medium';
			$Fruitintensityofcolouratmaturity_pepper[] = 'Dark';
			/*$Fruitintensityofcolouratmaturity_pepper[] = 'Very dark';*/


			$Fruitintensityofcolouratmaturity_dettomato =array();
			$Fruitintensityofcolouratmaturity_dettomato[] = 'Light red';
			$Fruitintensityofcolouratmaturity_dettomato[] = 'Red';
			$Fruitintensityofcolouratmaturity_dettomato[] = 'Deep red';

			$Maturity =array();
			$Maturity[] = 'Very late';
			$Maturity[] = 'Late';
			$Maturity[] = 'Medium';
			$Maturity[] = 'Low';
			$Maturity[] = 'Very early';

			$Maturity_cabbage =array();
			$Maturity_cabbage[] = 'Very early';
			$Maturity_cabbage[] = 'Medium early';
			$Maturity_cabbage[] = 'Early';
			$Maturity_cabbage[] = 'Medium';
			$Maturity_cabbage[] = 'Medium late';
			$Maturity_cabbage[] = 'Late';

			$Maturity_broccoli =array();
			$Maturity_broccoli[] = 'Very early';
			$Maturity_broccoli[] = 'Medium early';
			$Maturity_broccoli[] = 'Early';
			$Maturity_broccoli[] = 'Medium';
			$Maturity_broccoli[] = 'Medium late';

			$Maturity_carrot =array();
			$Maturity_carrot[] = 'Very early';
			$Maturity_carrot[] = 'Medium early';
			$Maturity_carrot[] = 'Early';
			$Maturity_carrot[] = 'Medium';
			$Maturity_carrot[] = 'Medium late';
			$Maturity_carrot[] = 'Late';

			$Maturity_cauliflower =array();
			$Maturity_cauliflower[] = 'Very early';
			$Maturity_cauliflower[] = 'Early';
			$Maturity_cauliflower[] = 'Medium early';
			$Maturity_cauliflower[] = 'Medium late';
			$Maturity_cauliflower[] = 'Late';

			$Maturity_dettomato =array();
			// $Maturity_dettomato[] = 'Very early';
			$Maturity_dettomato[] = 'Early';
			$Maturity_dettomato[] = 'Medium';
			$Maturity_dettomato[] = 'Medium late';
			//$Maturity_dettomato[] = 'Late';

			$Maturity_indettomato =array();
			$Maturity_indettomato[] = 'Very early';
			$Maturity_indettomato[] = 'Medium early';
			$Maturity_indettomato[] = 'Early';
			$Maturity_indettomato[] = 'Medium';
			$Maturity_indettomato[] = 'Medium late';
			$Maturity_indettomato[] = 'Late';

			$Maturity_eggplant =array();
			$Maturity_eggplant[] = 'Very early';
			$Maturity_eggplant[] = 'Early';
			$Maturity_eggplant[] = 'Medium';
			$Maturity_eggplant[] = 'Late';

			$Maturity_pepper =array();
			$Maturity_pepper[] = 'Very early';
			$Maturity_pepper[] = 'Medium early';
			$Maturity_pepper[] = 'Early';
			$Maturity_pepper[] = 'Medium';
			$Maturity_pepper[] = 'Medium late';
			$Maturity_pepper[] = 'Late';

			$Maturity_indtomato =array();
			$Maturity_indtomato[] = 'Very early';
			$Maturity_indtomato[] = 'Medium early';
			$Maturity_indtomato[] = 'Early';
			$Maturity_indtomato[] = 'Medium';
			$Maturity_indtomato[] = 'Medium late';
			$Maturity_indtomato[] = 'Late';

			$Maturity_squash =array();
			$Maturity_squash[] = 'Very early';
			$Maturity_squash[] = 'Medium early';
			$Maturity_squash[] = 'Early';
			$Maturity_squash[] = 'Medium';
			$Maturity_squash[] = 'Medium late';
			$Maturity_squash[] = 'Late';


			$Firmness =array();
			$Firmness[] = 'Very soft';
			$Firmness[] = 'Soft';
			$Firmness[] = 'Medium';
			$Firmness[] = 'Firm';
			$Firmness[] = 'Very firm';

			$Firmness_okra =array();
			$Firmness_okra[] = 'Soft';
			$Firmness_okra[] = 'Medium';
			$Firmness_okra[] = 'Firm';

			$Firmness_pepper =array();
			$Firmness_pepper[] = 'Too soft';
			$Firmness_pepper[] = 'Soft';
			$Firmness_pepper[] = 'Medium';
			$Firmness_pepper[] = 'Firm';
			$Firmness_pepper[] = 'Very firm';

			$Fruitglossiness =array();
			$Fruitglossiness[] = 'Very weak';
			$Fruitglossiness[] = 'Weak';
			$Fruitglossiness[] = 'Medium';
			$Fruitglossiness[] = 'Strong';
			$Fruitglossiness[] = 'Very strong';

			$Fruitglossiness_squash =array();
			$Fruitglossiness_squash[] = 'Very glossy';
			$Fruitglossiness_squash[] = 'Glossy';
			$Fruitglossiness_squash[] = 'Medium';
			$Fruitglossiness_squash[] = 'Dull';
			$Fruitglossiness_squash[] = 'Very dull';

			$Uniformity =array();
			$Uniformity[] = 'Excellent';
			$Uniformity[] = 'Medium';
			$Uniformity[] = 'Poor';

			$Uniformity_cabbage =array();
			$Uniformity_cabbage[] = 'Poor';
			$Uniformity_cabbage[] = 'Medium';
			$Uniformity_cabbage[] = 'Good';

			$Uniformity_cauliflower =array();
			$Uniformity_cauliflower[] = 'Poor';
			$Uniformity_cauliflower[] = 'Medium';
			$Uniformity_cauliflower[] = 'Good';

			$Uniformity_common =array();
			$Uniformity_common[] = 'Poor';
			$Uniformity_common[] = 'Medium';
			$Uniformity_common[] = 'Good';

			$Uniformity_chinesecabbage =array();
			$Uniformity_chinesecabbage[] = 'Poor';
			$Uniformity_chinesecabbage[] = 'Medium';
			$Uniformity_chinesecabbage[] = 'Good';

			$Fruitsettingunderlowtemperature =array();
			$Fruitsettingunderlowtemperature[] = 'Very poor';
			$Fruitsettingunderlowtemperature[] = 'Poor';
			$Fruitsettingunderlowtemperature[] = 'Medium';
			$Fruitsettingunderlowtemperature[] = 'Good';
			$Fruitsettingunderlowtemperature[] = 'Very good';

			$Fruitsettingunderhightemperature =array();
			$Fruitsettingunderhightemperature[] = 'Very poor';
			$Fruitsettingunderhightemperature[] = 'Poor';
			$Fruitsettingunderhightemperature[] = 'Medium';
			$Fruitsettingunderhightemperature[] = 'Good';
			$Fruitsettingunderhightemperature[] = 'Very good';

			$Fieldstandingability =array();
			$Fieldstandingability[] = 'Very poor';
			$Fieldstandingability[] = 'Poor';
			$Fieldstandingability[] = 'Medium';
			$Fieldstandingability[] = 'Good';
			$Fieldstandingability[] = 'Very good';

			$Resistance =array();
			$Resistance[] = 'Low';
			$Resistance[] = 'Medium';
			$Resistance[] = 'High';


			$AveragewieghtIn = array();
			$AveragewieghtIn[] = 'Gram';
			$AveragewieghtIn[] = 'Kg';

			$FriutwidthIn = array();
			$FriutwidthIn[] = 'CM';
			$FriutwidthIn[] = 'MM';


			$FriutlengthIn = array();
			$FriutlengthIn[] = 'CM';
			$FriutlengthIn[] = 'MM';

			$Fruitcolor = array();
			$Fruitcolor[] = 'Very light';
			$Fruitcolor[] = 'Light';
			$Fruitcolor[] = 'Medium';
			$Fruitcolor[] = 'Good';
			$Fruitcolor[] = 'Very deep';

			$Overallrating = array();
			$Overallrating[] = '1';
			$Overallrating[] = '2';
			$Overallrating[] = '3';
			$Overallrating[] = '4';
			$Overallrating[] = '5';
			$Overallrating[] = '6';
			$Overallrating[] = '7';
			$Overallrating[] = '8';
			$Overallrating[] = '9';
			$Overallrating[] = '10';

			$Status =array();
			$Status[] = 'Drop';
			$Status[] = 'Re-check';
			$Status[] = 'Pre-commercial';

			$Plantframesize = array();
			$Plantframesize[] = 'Small';
			$Plantframesize[] = 'Medium';
			$Plantframesize[] = 'Large';

			$Stemthickness = array();
			$Stemthickness[] = 'Thick';
			$Stemthickness[] = 'Medium thick';

			$Curdcolor = array();
			$Curdcolor[] = 'Lime green';
			$Curdcolor[] = 'Medium green';
			$Curdcolor[] = 'Deep green';
			$Curdcolor[] = 'Dark olive green';
			$Curdcolor[] = 'Dark green';


			$Curdcolor_brocoli = array();
			$Curdcolor_brocoli[] = 'Lime green';
			$Curdcolor_brocoli[] = 'Medium green';
			$Curdcolor_brocoli[] = 'Green';
			$Curdcolor_brocoli[] = 'Dark olive green';
			$Curdcolor_brocoli[] = 'Deep green';

			$Curdcolor_cauliflower = array();
			$Curdcolor_cauliflower[] = 'Bright white';
			$Curdcolor_cauliflower[] = 'White';
			$Curdcolor_cauliflower[] = 'Cream white';
			$Curdcolor_cauliflower[] = 'Fresh green';
			$Curdcolor_cauliflower[] = 'Yellow';

			$Curdcover = array();
			$Curdcover[] = 'Not covered';
			$Curdcover[] = 'Weak';
			$Curdcover[] = 'Medium';
			$Curdcover[] = 'Good';

			$CurdUniformity = array();
			$CurdUniformity[] = 'Very poor';
			$CurdUniformity[] = 'Poor';
			$CurdUniformity[] = 'Medium';
			$CurdUniformity[] = 'Good';
			$CurdUniformity[] = 'Very good';

			$Fieldholdability = array();
			$Fieldholdability[] = 'Very poor';
			$Fieldholdability[] = 'Poor';
			$Fieldholdability[] = 'Medium';
			$Fieldholdability[] = 'Good';
			$Fieldholdability[] = 'Very good';

			$Headshape = array();
			$Headshape[] = 'Circular';
			$Headshape[] = 'Borad eliptic';
			$Headshape[] = 'Medium eliptic';
			$Headshape[] = 'Narrow eliptic';


			$Headshape_brocoli = array();
			$Headshape_brocoli[] = 'Circular';
			$Headshape_brocoli[] = 'Broad elliptic';
			$Headshape_brocoli[] = 'Medium elliptic';
			$Headshape_brocoli[] = 'Narrow elliptic';


			$Headshape_cabbage = array();
			$Headshape_cabbage[] = 'Flat';
			$Headshape_cabbage[] = 'Semi flat';
			$Headshape_cabbage[] = 'Round';
			$Headshape_cabbage[] = 'Elliptic';

			$Headknobbling = array();
			$Headknobbling[] = 'Weak';
			$Headknobbling[] = 'Medium';
			$Headknobbling[] = 'Strong';		

			$Beadsize = array();
			$Beadsize[] = 'Large';
			$Beadsize[] = 'Medium';
			$Beadsize[] = 'Fine';

			$Headuniformity = array();
			$Headuniformity[] = 'Poor';
			$Headuniformity[] = 'Medium';
			$Headuniformity[] = 'Good';
			$Headuniformity[] = 'Very good';

			$Headuniformity_cabbage = array();
			$Headuniformity_cabbage[] = 'Very poor';
			$Headuniformity_cabbage[] = 'Poor';
			$Headuniformity_cabbage[] = 'Medium';
			$Headuniformity_cabbage[] = 'Good';

			$Headuniformity_lettuce = array();
			$Headuniformity_lettuce[] = 'Very poor';
			$Headuniformity_lettuce[] = 'Poor';
			$Headuniformity_lettuce[] = 'Moderate';
			$Headuniformity_lettuce[] = 'Good';
			$Headuniformity_lettuce[] = 'Very good';

			$Headuniformity_chinesecabbage = array();
			$Headuniformity_chinesecabbage[] = 'Very poor';
			$Headuniformity_chinesecabbage[] = 'Poor';
			$Headuniformity_chinesecabbage[] = 'Medium';
			$Headuniformity_chinesecabbage[] = 'Good';

			$Firmness_broccoli = array();
			$Firmness_broccoli[] = 'Loose';
			$Firmness_broccoli[] = 'Medium';
			$Firmness_broccoli[] = 'Firm';

			$Firmness_chinesecabbage = array();
			$Firmness_chinesecabbage[] = 'Loose';
			$Firmness_chinesecabbage[] = 'Medium';
			$Firmness_chinesecabbage[] = 'Firm';

			$Firmness_cauliflower = array();
			$Firmness_cauliflower[] = 'Loose';
			$Firmness_cauliflower[] = 'Medium';
			$Firmness_cauliflower[] = 'Firm';

			$Firmness_eggplant = array();
			$Firmness_eggplant[] = 'Very poor';
			$Firmness_eggplant[] = 'Poor';
			$Firmness_eggplant[] = 'Medium';
			$Firmness_eggplant[] = 'Good';
			$Firmness_eggplant[] = 'Very good';

			$Sideshoots = array();
			$Sideshoots[] = 'Absent';
			$Sideshoots[] = 'Few';
			$Sideshoots[] = 'Many';

			$Fieldstandingability = array();
			$Fieldstandingability[] = 'Very poor';
			$Fieldstandingability[] = 'Poor';
			$Fieldstandingability[] = 'Medium';
			$Fieldstandingability[] = 'Good';
			$Fieldstandingability[] = 'Very good';

			$Heatresittol = array();
			$Heatresittol[] = 'Very low';
			$Heatresittol[] = 'Low';
			$Heatresittol[] = 'Medium';
			$Heatresittol[] = 'High';
			$Heatresittol[] = 'Very high';

			$Heatresittol_cauliflower = array();
			$Heatresittol_cauliflower[] = 'Low';
			$Heatresittol_cauliflower[] = 'Medium';
			$Heatresittol_cauliflower[] = 'High';

			$Coldresisttol_cauliflower = array();
			$Coldresisttol_cauliflower[] = 'Low';
			$Coldresisttol_cauliflower[] = 'Medium';
			$Coldresisttol_cauliflower[] = 'High';


			$Coldresisttol = array();
			$Coldresisttol[] = 'Very low';
			$Coldresisttol[] = 'Low';
			$Coldresisttol[] = 'Medium';
			$Coldresisttol[] = 'High';
			$Coldresisttol[] = 'Very high';

			$Rating = array();
			$Rating[] = 'Very poor';
			$Rating[] = 'Poor';
			$Rating[] = 'Medium';
			$Rating[] = 'Good';     
			$Rating[] = 'Excellent';

			$Rating_brussels = array();
			$Rating_brussels[] = 'Bad';
			$Rating_brussels[] = 'Not good';
			$Rating_brussels[] = 'Medium';
			$Rating_brussels[] = 'Good';     
			$Rating_brussels[] = 'Very good';

			$Rating_broccoli = array();
			$Rating_broccoli[] = 'Very poor';
			$Rating_broccoli[] = 'Poor';
			$Rating_broccoli[] = 'Medium';
			$Rating_broccoli[] = 'Good';     
			$Rating_broccoli[] = 'Very good';

			$Rating_bunchingonion = array();
			$Rating_bunchingonion[] = 'Bad';
			$Rating_bunchingonion[] = 'Not good';
			$Rating_bunchingonion[] = 'Medium';
			$Rating_bunchingonion[] = 'Good';
			$Rating_bunchingonion[] = 'Very good';

			$Rating_celery = array();
			$Rating_celery[] = 'Bad';
			$Rating_celery[] = 'Not good';
			$Rating_celery[] = 'Medium';
			$Rating_celery[] = 'Good';
			$Rating_celery[] = 'Very good';

			$Rating_turnip = array();
			$Rating_turnip[] = 'Bad';
			$Rating_turnip[] = 'Not good';
			$Rating_turnip[] = 'Medium';
			$Rating_turnip[] = 'Good';
			$Rating_turnip[] = 'Very good';

			$Rating_sunflower = array();
			$Rating_sunflower[] = 'Bad';
			$Rating_sunflower[] = 'Not good';
			$Rating_sunflower[] = 'Medium';
			$Rating_sunflower[] = 'Good';
			$Rating_sunflower[] = 'Very good';

			$Rating_spinach = array();
			$Rating_spinach[] = 'Bad';
			$Rating_spinach[] = 'Not good';
			$Rating_spinach[] = 'Medium';
			$Rating_spinach[] = 'Good';
			$Rating_spinach[] = 'Very good';

			$Rating_corn = array();
			$Rating_corn[] = 'Bad';
			$Rating_corn[] = 'Not good';
			$Rating_corn[] = 'Medium';
			$Rating_corn[] = 'Good';
			$Rating_corn[] = 'Very good';

			$Rating_leafvegetable = array();
			$Rating_leafvegetable[] = 'Bad';
			$Rating_leafvegetable[] = 'Not good';
			$Rating_leafvegetable[] = 'Medium';
			$Rating_leafvegetable[] = 'Good';
			$Rating_leafvegetable[] = 'Very good';

			$Rating_pumpkin = array();
			$Rating_pumpkin[] = 'Bad';
			$Rating_pumpkin[] = 'Not good';
			$Rating_pumpkin[] = 'Medium';
			$Rating_pumpkin[] = 'Good';
			$Rating_pumpkin[] = 'Very good';

			$Rating_cauliflower = array();
			$Rating_cauliflower[] = 'Very poor';
			$Rating_cauliflower[] = 'Poor';
			$Rating_cauliflower[] = 'Medium';
			$Rating_cauliflower[] = 'Good';     
			$Rating_cauliflower[] = 'Very good';

			$Rating_radish = array();
			$Rating_radish[] = 'Very poor';
			$Rating_radish[] = 'Poor';
			$Rating_radish[] = 'Medium';
			$Rating_radish[] = 'Good';     
			$Rating_radish[] = 'Excellent';

			$Rating_rootstock = array();
			$Rating_rootstock[] = 'Bad';
			$Rating_rootstock[] = 'Not good';
			$Rating_rootstock[] = 'Medium';
			$Rating_rootstock[] = 'Good';
			$Rating_rootstock[] = 'Very good';

			$Rating_cucumber = array();
			$Rating_cucumber[] = 'Bad';
			$Rating_cucumber[] = 'Not good';
			$Rating_cucumber[] = 'Medium';
			$Rating_cucumber[] = 'Good';
			$Rating_cucumber[] = 'Very good';

			$Rating_melon = array();
			$Rating_melon[] = 'Bad';
			$Rating_melon[] = 'Not good';
			$Rating_melon[] = 'Medium';
			$Rating_melon[] = 'Good';
			$Rating_melon[] = 'Very good';

			$Rating_watermelon = array();
			$Rating_watermelon[] = 'Bad';
			$Rating_watermelon[] = 'Not good';
			$Rating_watermelon[] = 'Medium';
			$Rating_watermelon[] = 'Good';
			$Rating_watermelon[] = 'Very good';

			$Rating_onion = array();
			$Rating_onion[] = 'Bad';
			$Rating_onion[] = 'Not good';
			$Rating_onion[] = 'Medium';
			$Rating_onion[] = 'Good';
			$Rating_onion[] = 'Very good';

			$Rating_soybean = array();
			$Rating_soybean[] = 'Bad';
			$Rating_soybean[] = 'Not good';
			$Rating_soybean[] = 'Medium';
			$Rating_soybean[] = 'Good';
			$Rating_soybean[] = 'Very good';

			$Rating_sweetcorn = array();
			$Rating_sweetcorn[] = 'Bad';
			$Rating_sweetcorn[] = 'Not good';
			$Rating_sweetcorn[] = 'Medium';
			$Rating_sweetcorn[] = 'Good';
			$Rating_sweetcorn[] = 'Very good';


			$Rating_carrot = array();
			$Rating_carrot[] = 'Very poor';
			$Rating_carrot[] = 'Poor';
			$Rating_carrot[] = 'Medium';
			$Rating_carrot[] = 'Good';
			$Rating_carrot[] = 'Excellent';

			$Rating_cabbage = array();
			$Rating_cabbage[] = 'Very poor';
			$Rating_cabbage[] = 'Poor';
			$Rating_cabbage[] = 'Medium';
			$Rating_cabbage[] = 'Good';
			$Rating_cabbage[] = 'Very good';

			$Rating_chinesecabbage = array();
			$Rating_chinesecabbage[] = 'Very poor';
			$Rating_chinesecabbage[] = 'Poor';
			$Rating_chinesecabbage[] = 'Medium';
			$Rating_chinesecabbage[] = 'Good';
			$Rating_chinesecabbage[] = 'Very good';

			$Dryskinafterharvest = array();
			$Dryskinafterharvest[] = 'Weak';
			$Dryskinafterharvest[] = 'Medium';
			$Dryskinafterharvest[] = 'Strong';

			$Necksize = array();
			$Necksize[] = 'Very thin';
			$Necksize[] = 'Thin';
			$Necksize[] = 'Medium thick';
			$Necksize[] = 'Thick';

			$Thicknessofdryskin = array();
			$Thicknessofdryskin[] = 'Thin';
			$Thicknessofdryskin[] = 'Medium';
			$Thicknessofdryskin[] = 'Thick';

			$Basecolourdryskin = array();
			$Basecolourdryskin[] = 'White';
			$Basecolourdryskin[] = 'Grey';
			$Basecolourdryskin[] = 'Green';
			$Basecolourdryskin[] = 'Yellow';
			$Basecolourdryskin[] = 'Brown';
			$Basecolourdryskin[] = 'Pink';

			$Widthofneck = array();
			$Widthofneck[] = 'Very narrow';
			$Widthofneck[] = 'Narrow';
			$Widthofneck[] = 'Medium';
			$Widthofneck[] = 'Broad';
			$Widthofneck[] = 'Very broad';

			$Storability = array();
			$Storability[] = 'Very poor';
			$Storability[] = 'Poor';
			$Storability[] = 'Medium';
			$Storability[] = 'Good';
			$Storability[] = 'Very good';

			$Conclusion = array();
			$Conclusion[] = 'Control';
			$Conclusion[] = 'Commercial';
			$Conclusion[] = 'Recheck';		
			$Conclusion[] = 'Dropped';

			$Plantstructure = array();
			$Plantstructure[] = 'Very open';
			$Plantstructure[] = 'Open';
			$Plantstructure[] = 'MsoNormal';		
			$Plantstructure[] = 'Dense';
			$Plantstructure[] = 'Very dense';


			$Plantstructure_cucumber = array();
			$Plantstructure_cucumber[] = 'Very open';
			$Plantstructure_cucumber[] = 'Open';
			$Plantstructure_cucumber[] = 'Normal';		
			$Plantstructure_cucumber[] = 'Dense';
			$Plantstructure_cucumber[] = 'Very dense';

			$Plantstructure_radish = array();
			$Plantstructure_radish[] = 'Open';
			$Plantstructure_radish[] = 'Compact';

			$Plantstructure_common = array();
			$Plantstructure_common[] = 'Very open';
			$Plantstructure_common[] = 'Open';
			$Plantstructure_common[] = 'Normal';
			$Plantstructure_common[] = 'Dense';
			$Plantstructure_common[] = 'Very dense';

			$Fruitshapeuniformity = array();
			$Fruitshapeuniformity[] = 'Very poor';
			$Fruitshapeuniformity[] = 'Poor';
			$Fruitshapeuniformity[] = 'Medium';
			$Fruitshapeuniformity[] = 'Good';
			$Fruitshapeuniformity[] = 'Very good';

			$Plantsideshootbehaviour = array();
			$Plantsideshootbehaviour[] = 'Non';
			$Plantsideshootbehaviour[] = 'Self stop';
			$Plantsideshootbehaviour[] = 'Indeterm';
			$Plantsideshootbehaviour[] = 'Very long';

			$PowderyMildewSf = array();
			$PowderyMildewSf[] = 'Very severe';
			$PowderyMildewSf[] = 'Severe';
			$PowderyMildewSf[] = 'Medium';
			$PowderyMildewSf[] = 'Few symptoms';
			$PowderyMildewSf[] = 'Non';


			$SkinCucumber = array();
			$SkinCucumber[] = 'Smooth';
			$SkinCucumber[] = 'Slightly ribbed';
			$SkinCucumber[] = 'Ribbed';

			$DownyMildewPcu = array();
			$DownyMildewPcu[] = 'Very severe';
			$DownyMildewPcu[] = 'Severe';
			$DownyMildewPcu[] = 'Medium';
			$DownyMildewPcu[] = 'Few symptoms';
			$DownyMildewPcu[] = 'Non';

			$Fruitcolour = array();
			$Fruitcolour[] = 'Very light';
			$Fruitcolour[] = 'Light';
			$Fruitcolour[] = 'Medium';
			$Fruitcolour[] = 'Dark';
			$Fruitcolour[] = 'Very dark';

			$Fruitcolour_cucumber = array();
			$Fruitcolour_cucumber[] = 'Very light';
			$Fruitcolour_cucumber[] = 'Light';
			$Fruitcolour_cucumber[] = 'Medium';
			$Fruitcolour_cucumber[] = 'Dark';
			$Fruitcolour_cucumber[] = 'Very dark';

			$Fruitoverallquality = array();
			$Fruitoverallquality[] = 'Very poor';
			$Fruitoverallquality[] = 'Poor';
			$Fruitoverallquality[] = 'Medium';
			$Fruitoverallquality[] = 'Good';
			$Fruitoverallquality[] = 'Very good';


			$DiseaseTolerance = array();
			$DiseaseTolerance[] = 'Very poor';
			$DiseaseTolerance[] = 'Poor';
			$DiseaseTolerance[] = 'Medium';
			$DiseaseTolerance[] = 'Strong';
			$DiseaseTolerance[] = 'Very strong';

			$Fruitquality = array();
			$Fruitquality[] = 'Very poor';
			$Fruitquality[] = 'Poor';
			$Fruitquality[] = 'Medium';
			$Fruitquality[] = 'Good';
			$Fruitquality[] = 'Very good';

			$Yieldcontinuity = array();
			$Yieldcontinuity[] = 'Bad';
			$Yieldcontinuity[] = 'Not good';
			$Yieldcontinuity[] = 'Medium';
			$Yieldcontinuity[] = 'Good';
			$Yieldcontinuity[] = 'Very good';

			$Yieldcontinuity_Cucumber = array();
			$Yieldcontinuity_Cucumber[] = 'Bad';
			$Yieldcontinuity_Cucumber[] = 'Not very';
			$Yieldcontinuity_Cucumber[] = 'Medium';
			$Yieldcontinuity_Cucumber[] = 'Good';
			$Yieldcontinuity_Cucumber[] = 'Very good';

			$Yieldcontinuity_beans = array();
			$Yieldcontinuity_beans[] = 'Very low';
			$Yieldcontinuity_beans[] = 'Low';
			$Yieldcontinuity_beans[] = 'Medium';
			$Yieldcontinuity_beans[] = 'High';
			$Yieldcontinuity_beans[] = 'Very high';

			$Yieldcontinuity_dettomato = array();
			$Yieldcontinuity_dettomato[] = 'Very bad';
			$Yieldcontinuity_dettomato[] = 'Bad';
			$Yieldcontinuity_dettomato[] = 'Medium';
			$Yieldcontinuity_dettomato[] = 'Good';
			$Yieldcontinuity_dettomato[] = 'Very good';

			$Yieldcontinuity_eggplant = array();
			$Yieldcontinuity_eggplant[] = 'Very low';
			$Yieldcontinuity_eggplant[] = 'Low';
			$Yieldcontinuity_eggplant[] = 'Medium';
			$Yieldcontinuity_eggplant[] = 'High';
			$Yieldcontinuity_eggplant[] = 'Very high';

			$Yieldcontinuity_indtomato = array();
			$Yieldcontinuity_indtomato[] = 'Very bad';
			$Yieldcontinuity_indtomato[] = 'Bad';
			$Yieldcontinuity_indtomato[] = 'Medium';
			$Yieldcontinuity_indtomato[] = 'Good';
			$Yieldcontinuity_indtomato[] = 'Very good';

			$Yieldcontinuity_okra = array();
			$Yieldcontinuity_okra[] = 'Very low';
			$Yieldcontinuity_okra[] = 'Low';
			$Yieldcontinuity_okra[] = 'Medium';
			$Yieldcontinuity_okra[] = 'High';
			$Yieldcontinuity_okra[] = 'Very high';

			$Yieldcontinuity_pepper = array();
			$Yieldcontinuity_pepper[] = 'Very bad';
			$Yieldcontinuity_pepper[] = 'Bad';
			$Yieldcontinuity_pepper[] = 'Medium';
			$Yieldcontinuity_pepper[] = 'Good';
			$Yieldcontinuity_pepper[] = 'Very good';

			$Yieldcontinuity_squash = array();
			$Yieldcontinuity_squash[] = 'Very low';
			$Yieldcontinuity_squash[] = 'Low';
			$Yieldcontinuity_squash[] = 'Medium';
			$Yieldcontinuity_squash[] = 'High';
			$Yieldcontinuity_squash[] = 'Very high';


			$VisualYield = array();
			$VisualYield[] = 'Very low';
			$VisualYield[] = 'Low';
			$VisualYield[] = 'Medium';
			$VisualYield[] = 'High';
			$VisualYield[] = 'Very high';

			$VisualYield_melon = array();
			$VisualYield_melon[] = 'Very low';
			$VisualYield_melon[] = 'Low';
			$VisualYield_melon[] = 'Medium';
			$VisualYield_melon[] = 'Good';
			$VisualYield_melon[] = 'Very good';

			$VisualYield_common = array();
			$VisualYield_common[] = 'Very low';
			$VisualYield_common[] = 'Low';
			$VisualYield_common[] = 'Medium';
			$VisualYield_common[] = 'Good';
			$VisualYield_common[] = 'Very good';


			$Fleshcolor = array();
			$Fleshcolor[] = 'Yellow';
			$Fleshcolor[] = 'Orange';
			$Fleshcolor[] = 'Cream';
			$Fleshcolor[] = 'Green';
			$Fleshcolor[] = 'Other';

			$Fleshcolor_watermelon = array();
			$Fleshcolor_watermelon[] = 'Light red';
			$Fleshcolor_watermelon[] = 'Medium red';
			$Fleshcolor_watermelon[] = 'Red';
			$Fleshcolor_watermelon[] = 'Deep red';
			$Fleshcolor_watermelon[] = 'Yellow';
			$Fleshcolor_watermelon[] = 'Other';

			$Seedcavity = array();
			$Seedcavity[] = 'Yellow';
			$Seedcavity[] = 'Orange';

			$Seedcavity_melon = array();
			$Seedcavity_melon[] = 'Small';
			$Seedcavity_melon[] = 'Medium';
			$Seedcavity_melon[] = 'Large';

			$Fruittaste = array();
			$Fruittaste[] = 'Very poor';
			$Fruittaste[] = 'Poor';
			$Fruittaste[] = 'Medium';
			$Fruittaste[] = 'Good';
			$Fruittaste[] = 'Very good';

			$Fruittaste_dettomato = array();
			$Fruittaste_dettomato[] = 'Very bad';
			$Fruittaste_dettomato[] = 'Bad';
			$Fruittaste_dettomato[] = 'Medium';
			$Fruittaste_dettomato[] = 'Good';
			$Fruittaste_dettomato[] = 'Very good';

			$Fruittaste_eggplant = array();
			$Fruittaste_eggplant[] = 'Bad';
			$Fruittaste_eggplant[] = 'Medium';
			$Fruittaste_eggplant[] = 'Good';

			$Fruittaste_lettuce = array();
			$Fruittaste_lettuce[] = 'Sweet';
			$Fruittaste_lettuce[] = 'Low bitterness';
			$Fruittaste_lettuce[] = 'Medium bitterness';

			$Fruittaste_watermelon = array();
			$Fruittaste_watermelon[] = 'Very bad';
			$Fruittaste_watermelon[] = 'Bad';
			$Fruittaste_watermelon[] = 'Medium';
			$Fruittaste_watermelon[] = 'Good';
			$Fruittaste_watermelon[] = 'Very good';

			$Fleshfirmness = array();
			$Fleshfirmness[] = 'Soft';
			$Fleshfirmness[] = 'Medium';
			$Fleshfirmness[] = 'Firm';

			$Fleshfirmness_watermelon = array();
			$Fleshfirmness_watermelon[] = 'Very soft';
			$Fleshfirmness_watermelon[] = 'Soft';
			$Fleshfirmness_watermelon[] = 'Medium';
			$Fleshfirmness_watermelon[] = 'Firm';
			$Fleshfirmness_watermelon[] = 'Very firm';

			$HollowHeartSeverity = array();
			$HollowHeartSeverity[] = 'Very heavy';
			$HollowHeartSeverity[] = 'Heavy';
			$HollowHeartSeverity[] = 'Medium';
			$HollowHeartSeverity[] = 'Little';
			$HollowHeartSeverity[] = 'Not exist';

			$SeedsSize = array();
			$SeedsSize[] = 'Very small';
			$SeedsSize[] = 'Small';
			$SeedsSize[] = 'Medium';
			$SeedsSize[] = 'Large';
			$SeedsSize[] = 'Very large';

			$SeedsContent = array();
			$SeedsContent[] = 'Many';
			$SeedsContent[] = 'Normal';
			$SeedsContent[] = 'Few';
			
			$Shelflife = array();
			$Shelflife[] = 'Very short';
			$Shelflife[] = 'Short';
			$Shelflife[] = 'Medium';
			$Shelflife[] = 'Long';
			$Shelflife[] = 'Very long';

			$Shelflife_Melon = array();
			$Shelflife_Melon[] = 'Short';
			$Shelflife_Melon[] = 'Medium';
			$Shelflife_Melon[] = 'Long';

			$Shelflife_radish = array();
			$Shelflife_radish[] = 'Very poor';
			$Shelflife_radish[] = 'Poor';
			$Shelflife_radish[] = 'Medium';
			$Shelflife_radish[] = 'Good';
			$Shelflife_radish[] = 'Very good';

			$Seedcolour = array();
			$Seedcolour[] = 'Yellow';
			$Seedcolour[] = 'White';
			$Seedcolour[] = 'Bicolour';

			$Seedcolour_beans = array();
			$Seedcolour_beans[] = 'White';
			$Seedcolour_beans[] = 'Buff';
			$Seedcolour_beans[] = 'Coloured';
			$Seedcolour_beans[] = 'Black';
			$Seedcolour_beans[] = 'Purple buff';
			$Seedcolour_beans[] = 'Beige';
			$Seedcolour_beans[] = 'Red';
			$Seedcolour_beans[] = 'Yellow buff';
			$Seedcolour_beans[] = 'White green';
			$Seedcolour_beans[] = 'White/Red eye';
			$Seedcolour_beans[] = 'White/Black eye';
			$Seedcolour_beans[] = 'Buff light brown';
			$Seedcolour_beans[] = 'Light Brown';
			$Seedcolour_beans[] = 'Brown';
			$Seedcolour_beans[] = 'Dark brown';


			$Tipfilling = array();
			$Tipfilling[] = 'Very poor';
			$Tipfilling[] = 'Poor';
			$Tipfilling[] = 'Medium';
			$Tipfilling[] = 'Good';
			$Tipfilling[] = 'Very good';

			$Harvesting = array();
			$Harvesting[] = 'Very tough';
			$Harvesting[] = 'Tough';
			$Harvesting[] = 'Easy';
			$Harvesting[] = 'Very easy';

			$Harvesting_beans = array();
			$Harvesting_beans[] = 'Very early';
			$Harvesting_beans[] = 'Early';
			$Harvesting_beans[] = 'Medium';
			$Harvesting_beans[] = 'Late';
			$Harvesting_beans[] = 'Very late';

			$Harvesting_beetroot = array();
			$Harvesting_beetroot[] = 'Very early';
			$Harvesting_beetroot[] = 'Early';
			$Harvesting_beetroot[] = 'Medium (Same)';
			$Harvesting_beetroot[] = 'Late';
			$Harvesting_beetroot[] = 'Very late';

			$Harvesting_kohlrabi = array();
			$Harvesting_kohlrabi[] = 'Very early';
			$Harvesting_kohlrabi[] = 'Early';
			$Harvesting_kohlrabi[] = 'Medium (Same)';
			$Harvesting_kohlrabi[] = 'Late';
			$Harvesting_kohlrabi[] = 'Very late';

			$Harvesting_okra = array();
			$Harvesting_okra[] = 'Very early';
			$Harvesting_okra[] = 'Early';
			$Harvesting_okra[] = 'Medium (Same)';
			$Harvesting_okra[] = 'Late';
			$Harvesting_okra[] = 'Very late';

			$Harvesting_pea = array();
			$Harvesting_pea[] = 'Very early';
			$Harvesting_pea[] = 'Early';
			$Harvesting_pea[] = 'Medium (Same)';
			$Harvesting_pea[] = 'Late';
			$Harvesting_pea[] = 'Very late';

			$Harvesting_radish = array();
			$Harvesting_radish[] = 'Very early';
			$Harvesting_radish[] = 'Early';
			$Harvesting_radish[] = 'Medium (Same)';
			$Harvesting_radish[] = 'Late';
			$Harvesting_radish[] = 'Very late';
			

			$Kerneltenderness = array();
			$Kerneltenderness[] = 'Very soft';
			$Kerneltenderness[] = 'Soft';
			$Kerneltenderness[] = 'Medium';
			$Kerneltenderness[] = 'Firm';
			$Kerneltenderness[] = 'Very firm';


			$Curdanthocyanin = array();
			$Curdanthocyanin[] = 'Absent';
			$Curdanthocyanin[] = 'Present';

			$Yieldestimated = array();
			$Yieldestimated[] = 'Very low';
			$Yieldestimated[] = 'Low';
			$Yieldestimated[] = 'Medium';
			$Yieldestimated[] = 'Good';
			$Yieldestimated[] = 'Very good';

			$PlantCover = array();
			$PlantCover[] = 'Very open';
			$PlantCover[] = 'Open';
			$PlantCover[] = 'Normal';
			$PlantCover[] = 'Strong';
			$PlantCover[] = 'Very strong';

			$PlantCover_dettomato = array();
			$PlantCover_dettomato[] = 'Very open';
			$PlantCover_dettomato[] = 'Open';
			$PlantCover_dettomato[] = 'Normal';
			$PlantCover_dettomato[] = 'Strong';
			$PlantCover_dettomato[] = 'Very strong';

			$PlantCover_watermelon = array();
			$PlantCover_watermelon[] = 'Very weak';
			$PlantCover_watermelon[] = 'Weak';
			$PlantCover_watermelon[] = 'Medium';
			$PlantCover_watermelon[] = 'Strong';
			$PlantCover_watermelon[] = 'Very strong';

			$InternodesLength = array();
			// $InternodesLength[] = 'Very short';
			$InternodesLength[] = 'Short';
			$InternodesLength[] = 'Medium';
			$InternodesLength[] = 'Long';
			// $InternodesLength[] = 'Very long';

			$InternodesLength_okra = array();
			$InternodesLength_okra[] = 'Short';
			$InternodesLength_okra[] = 'Medium';
			$InternodesLength_okra[] = 'Long';

			$LeafCurlingRolling = array();
			$LeafCurlingRolling[] = 'No curling';
			$LeafCurlingRolling[] = 'Low curling';
			$LeafCurlingRolling[] = 'Medium curling';
			$LeafCurlingRolling[] = 'Curling';
			$LeafCurlingRolling[] = 'High curling';

			$LeafCurlingRolling_dettomato = array();
			$LeafCurlingRolling_dettomato[] = 'No curling';
			$LeafCurlingRolling_dettomato[] = 'Low curling';
			$LeafCurlingRolling_dettomato[] = 'Medium curling';
			$LeafCurlingRolling_dettomato[] = 'High curling';


			$ParthenocarpicFruits = array();
			$ParthenocarpicFruits[] = 'Not exist';
			$ParthenocarpicFruits[] = 'Very few';
			$ParthenocarpicFruits[] = 'Slightly high';
			$ParthenocarpicFruits[] = 'High';
			$ParthenocarpicFruits[] = 'Very high';


			$PlantBalance = array();
			$PlantBalance[] = 'Fully balanced';
			$PlantBalance[] = 'Medium balanced';
			$PlantBalance[] = 'Slightly balanced';
			$PlantBalance[] = 'Vegetative or generative';
			$PlantBalance[] = 'Extremly vegetative or generative';

			$Fruitsetting = array();
			$Fruitsetting[] = 'Very weak';
			$Fruitsetting[] = 'Weak';
			$Fruitsetting[] = 'Very strong';
			$Fruitsetting[] = 'Strong';
			$Fruitsetting[] = 'Medium';

			$Fruitsetting_dettomato = array();
			$Fruitsetting_dettomato[] = 'Very weak';
			$Fruitsetting_dettomato[] = 'Weak';
			$Fruitsetting_dettomato[] = 'Medium';
			$Fruitsetting_dettomato[] = 'Strong';
			$Fruitsetting_dettomato[] = 'Very strong';

			$Fruitsetting_indettomato = array();
			$Fruitsetting_indettomato[] = 'Very weak';
			$Fruitsetting_indettomato[] = 'Weak';
			$Fruitsetting_indettomato[] = 'Medium';
			$Fruitsetting_indettomato[] = 'Strong';
			$Fruitsetting_indettomato[] = 'Very strong';


			$Fruitsizeuniformity = array();
			$Fruitsizeuniformity[] = 'Very low';
			$Fruitsizeuniformity[] = 'Low';
			$Fruitsizeuniformity[] = 'Medium';
			$Fruitsizeuniformity[] = 'Good';
			$Fruitsizeuniformity[] = 'Very good';

			$Fruitsizeuniformity_eggplant = array();
			$Fruitsizeuniformity_eggplant[] = 'Very poor';
			$Fruitsizeuniformity_eggplant[] = 'Poor';
			$Fruitsizeuniformity_eggplant[] = 'Medium';
			$Fruitsizeuniformity_eggplant[] = 'Good';
			$Fruitsizeuniformity_eggplant[] = 'Very good';

			$Fruitsizeuniformity_melon= array();
			$Fruitsizeuniformity_melon[] = 'Very poor';
			$Fruitsizeuniformity_melon[] = 'Poor';
			$Fruitsizeuniformity_melon[] = 'Medium';
			$Fruitsizeuniformity_melon[] = 'Good';
			$Fruitsizeuniformity_melon[] = 'Very good';

			$Fruitsizeuniformity_okra = array();
			$Fruitsizeuniformity_okra[] = 'Very poor';
			$Fruitsizeuniformity_okra[] = 'Poor';
			$Fruitsizeuniformity_okra[] = 'Medium';
			$Fruitsizeuniformity_okra[] = 'Good';
			$Fruitsizeuniformity_okra[] = 'Very good';

			$Fruitsizeuniformity_onion = array();
			$Fruitsizeuniformity_onion[] = 'Very poor';
			$Fruitsizeuniformity_onion[] = 'Poor';
			$Fruitsizeuniformity_onion[] = 'Medium';
			$Fruitsizeuniformity_onion[] = 'Good';
			$Fruitsizeuniformity_onion[] = 'Very good';

			$Fruitsizeuniformity_pepper = array();
			$Fruitsizeuniformity_pepper[] = 'Very poor';
			$Fruitsizeuniformity_pepper[] = 'Poor';
			$Fruitsizeuniformity_pepper[] = 'Medium';
			$Fruitsizeuniformity_pepper[] = 'Good';
			$Fruitsizeuniformity_pepper[] = 'Very good';

			$Fruitsizeuniformity_squash = array();
			$Fruitsizeuniformity_squash[] = 'Very poor';
			$Fruitsizeuniformity_squash[] = 'Poor';
			$Fruitsizeuniformity_squash[] = 'Medium';
			$Fruitsizeuniformity_squash[] = 'Good';
			$Fruitsizeuniformity_squash[] = 'Very good';

			$Fruitsizeuniformity_watermelon = array();
			$Fruitsizeuniformity_watermelon[] = 'Very poor';
			$Fruitsizeuniformity_watermelon[] = 'Poor';
			$Fruitsizeuniformity_watermelon[] = 'Medium';
			$Fruitsizeuniformity_watermelon[] = 'Good';
			$Fruitsizeuniformity_watermelon[] = 'Very good';

			$Fruitsizeuniformity_common = array();
			$Fruitsizeuniformity_common[] = 'Very poor';
			$Fruitsizeuniformity_common[] = 'Poor';
			$Fruitsizeuniformity_common[] = 'Medium';
			$Fruitsizeuniformity_common[] = 'Good';
			$Fruitsizeuniformity_common[] = 'Very good';

			$FruitSizeuniformitycluster = array();
			$FruitSizeuniformitycluster[] = 'Very low';
			$FruitSizeuniformitycluster[] = 'Low';
			$FruitSizeuniformitycluster[] = 'Medium';
			$FruitSizeuniformitycluster[] = 'Good';
			$FruitSizeuniformitycluster[] = 'Very good';


			$FruitRibbness = array();
			// $FruitRibbness[] = 'Very smooth';
			$FruitRibbness[] = 'Smooth';
			$FruitRibbness[] = 'Medium';
			$FruitRibbness[] = 'Ribbed';
			$FruitRibbness[] = 'Very ribbed';

			$CalyxApperarance = array();
			$CalyxApperarance[] = 'Unattractive';
			$CalyxApperarance[] = 'Medium';
			$CalyxApperarance[] = 'Attractive';

			$CalyxApperarance_dettomato = array();
			$CalyxApperarance_dettomato[] = 'Unattractive';
			$CalyxApperarance_dettomato[] = 'Medium';
			$CalyxApperarance_dettomato[] = 'Attractive';


			$Fruitcolourmaturity = array();
			$Fruitcolourmaturity[] = 'Light';
			$Fruitcolourmaturity[] = 'Medium';
			$Fruitcolourmaturity[] = 'Dark';

			$Fruitcolourbeforematurity = array();
			$Fruitcolourbeforematurity[] = 'Light';
			$Fruitcolourbeforematurity[] = 'Medium';
			$Fruitcolourbeforematurity[] = 'Dark';

			$Fruitcolourmaturity_dettomato = array();
			$Fruitcolourmaturity_dettomato[] = 'Light';
			$Fruitcolourmaturity_dettomato[] = 'Medium';
			$Fruitcolourmaturity_dettomato[] = 'Dark';

			$FruitRindPattern = array();
			$FruitRindPattern[] = 'Dark green';
			$FruitRindPattern[] = 'Crimson';
			$FruitRindPattern[] = 'Tiger';
			$FruitRindPattern[] = 'Charleston grey';
			$FruitRindPattern[] = 'Other';

			$RindAttractivness = array();
			$RindAttractivness[] = 'Low';
			$RindAttractivness[] = 'Medium';
			$RindAttractivness[] = 'Good';

			$Fruitcolouratmaturity = array();
			$Fruitcolouratmaturity[] = 'Yellow';
			$Fruitcolouratmaturity[] = 'Orange';
			$Fruitcolouratmaturity[] = 'Red';
			$Fruitcolouratmaturity[] = 'Brown';
			$Fruitcolouratmaturity[] = 'Pink';

			$Fruitcolouratmaturity_eggplant = array();
			$Fruitcolouratmaturity_eggplant[] = 'White';
			$Fruitcolouratmaturity_eggplant[] = 'Light purple';
			$Fruitcolouratmaturity_eggplant[] = 'Purple';
			$Fruitcolouratmaturity_eggplant[] = 'Dark purple';
			$Fruitcolouratmaturity_eggplant[] = 'Deep purple black';

			$Fruitcolouratmaturity_okra = array();
			$Fruitcolouratmaturity_okra[] = 'Light green';
			$Fruitcolouratmaturity_okra[] = 'Medium green';
			$Fruitcolouratmaturity_okra[] = 'Dark green';
			$Fruitcolouratmaturity_okra[] = 'Red';

			$Fruitcolouratmaturity_squash = array();
			$Fruitcolouratmaturity_squash[] = 'Cream';
			$Fruitcolouratmaturity_squash[] = 'White';
			$Fruitcolouratmaturity_squash[] = 'Dark green';
			$Fruitcolouratmaturity_squash[] = 'Green';
			$Fruitcolouratmaturity_squash[] = 'Light green';
			$Fruitcolouratmaturity_squash[] = 'Yellow';
			$Fruitcolouratmaturity_squash[] = 'Golden';
			$Fruitcolouratmaturity_squash[] = 'Other';

			$Headcolor = array();
			$Headcolor[] = 'Light green';
			$Headcolor[] = 'Medium green';
			$Headcolor[] = 'Green';
			$Headcolor[] = 'Dark green';
			$Headcolor[] = 'Blue green';
			$Headcolor[] = 'Red';

			$Headcolor_chinesecabbage = array();
			$Headcolor_chinesecabbage[] = 'Whitish';
			$Headcolor_chinesecabbage[] = 'Yellow';
			$Headcolor_chinesecabbage[] = 'Orange';

			$Leafwaxiness = array();
			$Leafwaxiness[] = 'Weak';
			$Leafwaxiness[] = 'Medium';
			$Leafwaxiness[] = 'Strong';

			$Coresize = array();
			$Coresize[] = 'Short';
			$Coresize[] = 'Medium';
			$Coresize[] = 'Long';

			$Coresize_carrot = array();
			$Coresize_carrot[] = 'Very small';
			$Coresize_carrot[] = 'Small';
			$Coresize_carrot[] = 'Medium';
			$Coresize_carrot[] = 'Big';
			$Coresize_carrot[] = 'Very big';

			$anthocyanincolorationofcoverleaf = array();
			$anthocyanincolorationofcoverleaf[] = 'Absent';
			$anthocyanincolorationofcoverleaf[] = 'Present';
		

			$Headdensity = array();
			$Headdensity[] = 'Very loose';
			$Headdensity[] = 'Loose';
			$Headdensity[] = 'Medium';
			$Headdensity[] = 'Dense';
			$Headdensity[] = 'very dense';

			$Marketsegment = array();
			$Marketsegment[] = 'Pre-pack';
			$Marketsegment[] = 'Fresh market';
			$Marketsegment[] = 'Processing';
			$Marketsegment[] = 'Shelling fresh';
			$Marketsegment[] = 'Shelling dry';

			$Marketsegment_beans = array();
			$Marketsegment_beans[] = 'Fresh market';
			$Marketsegment_beans[] = 'Processing';

			$Marketsegment_beetroot = array();
			$Marketsegment_beetroot[] = 'Fresh market';
			$Marketsegment_beetroot[] = 'Processing';
			$Marketsegment_beetroot[] = 'Baby';
			// $Marketsegment_beetroot[] = 'Bunching';

			$Marketsegment_radish = array();
			$Marketsegment_radish[] = 'Fresh market';
			$Marketsegment_radish[] = 'Processing';
			$Marketsegment_radish[] = 'Baby';

			$Growthtype = array();
			$Growthtype[] = 'Bush';
			$Growthtype[] = 'Single stem';
			$Growthtype[] = 'Multi stem';
			$Growthtype[] = 'Runner';

			$Growthtype_beans = array();
			$Growthtype_beans[] = 'Climbing';
			$Growthtype_beans[] = 'Semi climbing';
			$Growthtype_beans[] = 'Dwarf';

			$Growthtype_okra = array();
			$Growthtype_okra[] = 'Compact bush';
			$Growthtype_okra[] = 'Bush';
			$Growthtype_okra[] = 'Upright';
			$Growthtype_okra[] = 'Tall upright';

			$Growthtype_radish = array();
			$Growthtype_radish[] = 'Quick';
			$Growthtype_radish[] = 'Slow';

			$Planthabit = array();
			$Planthabit[] = 'Fully erect';
			$Planthabit[] = 'Mostly erect';
			$Planthabit[] = 'Half erect';
			$Planthabit[] = 'Slightly prostrate';
			$Planthabit[] = 'Fully prostrate';

			$Planthabit_kohlrabi = array();
			$Planthabit_kohlrabi[] = 'Spreading';
			$Planthabit_kohlrabi[] = 'Semi-erect';
			$Planthabit_kohlrabi[] = 'Erect';


			$Silvering = array();
			$Silvering[] = 'Very low';
			$Silvering[] = 'Low';
			$Silvering[] = 'Medium';
			$Silvering[] = 'High';
			$Silvering[] = 'Very high';

			$Branching = array();
			$Branching[] = 'All plants with single stem';
			$Branching[] = 'Very few branching';
			$Branching[] = 'Few branching';
			$Branching[] = 'Considerable branching';
			$Branching[] = 'Many branching';


			$YongfruitRatio = array();
			$YongfruitRatio[] = 'Very small';
			$YongfruitRatio[] = 'Small';
			$YongfruitRatio[] = 'Medium';
			$YongfruitRatio[] = 'Large';


			$Stripesripefruit = array();
			$Stripesripefruit[] = 'Absent';
			$Stripesripefruit[] = 'Low';
			$Stripesripefruit[] = 'Moderate';
			$Stripesripefruit[] = 'High';

			$Blossomscar = array();
			$Blossomscar[] = 'Small';
			$Blossomscar[] = 'Medium';
			$Blossomscar[] = 'Large';

			$Easypicking = array();
			$Easypicking[] = 'Easy';
			$Easypicking[] = 'Medium';
			$Easypicking[] = 'Hard';

			$PostHarvestQuality = array();
			$PostHarvestQuality[] = 'Poor';
			$PostHarvestQuality[] = 'Medium';
			$PostHarvestQuality[] = 'Firm';

			$EarlyYield = array();
			$EarlyYield[] = 'Very low';
			$EarlyYield[] = 'Low';
			$EarlyYield[] = 'Medium';
			$EarlyYield[] = 'High';
			$EarlyYield[] = 'Very high';

			$TotalYield = array();
			$TotalYield[] = 'Very low';
			$TotalYield[] = 'Low';
			$TotalYield[] = 'Medium';
			$TotalYield[] = 'High';
			$TotalYield[] = 'Very high';

			$Anthocyanin = array();
			$Anthocyanin[] = 'Very few';
			$Anthocyanin[] = 'Few';
			$Anthocyanin[] = 'Medium';
			$Anthocyanin[] = 'Much';

			$Anthocyanin_beetroot = array();
			$Anthocyanin_beetroot[] = 'Very few/On margins';
			$Anthocyanin_beetroot[] = 'Few';
			$Anthocyanin_beetroot[] = 'Medium';
			$Anthocyanin_beetroot[] = 'Much';


			$Earhuskleafcolor = array();
			$Earhuskleafcolor[] = 'Light green';
			$Earhuskleafcolor[] = 'Medium green';
			$Earhuskleafcolor[] = 'Dark green';
			$Earhuskleafcolor[] = 'Other';

			$Flagleavesappearanceonear = array();
			$Flagleavesappearanceonear[] = 'Very poor';
			$Flagleavesappearanceonear[] = 'Poor';
			$Flagleavesappearanceonear[] = 'Medium';
			$Flagleavesappearanceonear[] = 'Good';
			$Flagleavesappearanceonear[] = 'Very good';

			$EarProtection = array();
			$EarProtection[] = 'Very poor';
			$EarProtection[] = 'Poor';
			$EarProtection[] = 'Medium';
			$EarProtection[] = 'Good';
			$EarProtection[] = 'Very good';

			$Averagenumberofrows = array();
			$Averagenumberofrows[] = '12 to 14';
			$Averagenumberofrows[] = '14 to 16';
			$Averagenumberofrows[] = '16 to 18';
			$Averagenumberofrows[] = '18 to 20';
			$Averagenumberofrows[] = '20 to 22';

			$Foliagecolor = array();
			$Foliagecolor[] = 'Very short';
			$Foliagecolor[] = 'Short';
			$Foliagecolor[] = 'Medium';
			$Foliagecolor[] = 'Long';
			$Foliagecolor[] = 'Very long';

			$Foliagecolor_carrot = array();
			$Foliagecolor_carrot[] = 'Light green';
			$Foliagecolor_carrot[] = 'Medium green';
			$Foliagecolor_carrot[] = 'Green';
			$Foliagecolor_carrot[] = 'Dark green';

			$Alternariapminfection = array();
			$Alternariapminfection[] = 'No exist';
			$Alternariapminfection[] = 'Very low';
			$Alternariapminfection[] = 'Medium';
			$Alternariapminfection[] = 'High';
			$Alternariapminfection[] = 'Very high';

			$Diseasespest = array();
			$Diseasespest[] = 'Very severe';
			$Diseasespest[] = 'Severe';
			$Diseasespest[] = 'Medium';
			$Diseasespest[] = 'Few symptoms';
			$Diseasespest[] = 'Non';

			$Crackingroot = array();
			$Crackingroot[] = 'Very few';
			$Crackingroot[] = 'Few';
			$Crackingroot[] = 'Some';
			$Crackingroot[] = 'Several';
			$Crackingroot[] = 'Many';

			$Maturityvscontrol = array();
			$Maturityvscontrol[] = 'Very early';
			$Maturityvscontrol[] = 'Medium early';
			$Maturityvscontrol[] = 'Early';
			$Maturityvscontrol[] = 'Medium';
			$Maturityvscontrol[] = 'Medium late';

			$Maturityvscontrol_lettuce = array();
			$Maturityvscontrol_lettuce[] = 'Very early';
			$Maturityvscontrol_lettuce[] = 'Medium early';
			$Maturityvscontrol_lettuce[] = 'Early';
			$Maturityvscontrol_lettuce[] = 'Medium';
			$Maturityvscontrol_lettuce[] = 'Medium late';
			$Maturityvscontrol_lettuce[] = 'Late';

			$Maturityvscontrol_melon = array();
			$Maturityvscontrol_melon[] = 'Very early';
			$Maturityvscontrol_melon[] = 'Medium early';
			$Maturityvscontrol_melon[] = 'Early';
			$Maturityvscontrol_melon[] = 'Medium late';
			$Maturityvscontrol_melon[] = 'Late';

			$Maturityvscontrol_onion = array();
			$Maturityvscontrol_onion[] = 'Very early';
			$Maturityvscontrol_onion[] = 'Medium early';
			$Maturityvscontrol_onion[] = 'Early';
			$Maturityvscontrol_onion[] = 'Medium late';
			$Maturityvscontrol_onion[] = 'Late';

			$Maturityvscontrol_sweetcorn = array();
			$Maturityvscontrol_sweetcorn[] = 'Very early';
			$Maturityvscontrol_sweetcorn[] = 'Medium early';
			$Maturityvscontrol_sweetcorn[] = 'Early';
			$Maturityvscontrol_sweetcorn[] = 'Medium late';
			$Maturityvscontrol_sweetcorn[] = 'Late';

			$Maturityvscontrol_watermelon = array();
			$Maturityvscontrol_watermelon[] = 'Very early';
			$Maturityvscontrol_watermelon[] = 'Medium early';
			$Maturityvscontrol_watermelon[] = 'Early';
			$Maturityvscontrol_watermelon[] = 'Medium late';
			$Maturityvscontrol_watermelon[] = 'Late';

			$Subtype = array();
			$Subtype[] = 'Extra fine';
			$Subtype[] = 'Very fine';
			$Subtype[] = 'Fine';
			$Subtype[] = 'Medium fine';
			$Subtype[] = 'Bobby';
			$Subtype[] = 'Filet';


			$Plantheight = array();
			$Plantheight[] = 'Very short';
			$Plantheight[] = 'Short';
			$Plantheight[] = 'Medium';
			$Plantheight[] = 'Tall';
			$Plantheight[] = 'Very tall';

			$Plantheight_chinesecabbage = array();
			$Plantheight_chinesecabbage[] = 'Short';
			$Plantheight_chinesecabbage[] = 'Medium short';
			$Plantheight_chinesecabbage[] = 'Medium';
			$Plantheight_chinesecabbage[] = 'Medium high';
			$Plantheight_chinesecabbage[] = 'High';

			$Curdshape = array();
			$Curdshape[] = 'Circular';
			$Curdshape[] = 'Transverse broad elliptic';
			$Curdshape[] = 'Transverse medium elliptic';
			$Curdshape[] = 'Transverse narrow elliptic';
			$Curdshape[] = 'Triangular';

			$Rootshape = array();
			$Rootshape[] = 'Conical';
			$Rootshape[] = 'Conical to cylindrical';
			$Rootshape[] = 'Cylindrical';
			$Rootshape[] = 'Fully cylenderical';
			$Rootshape[] = 'Round';

			$Rootshape_carrot = array();
			$Rootshape_carrot[] = 'Conical';
			$Rootshape_carrot[] = 'Cylindrical';

			$Rootshape_beetroot = array();
			$Rootshape_beetroot[] = 'Ellipitic';
			$Rootshape_beetroot[] = 'Circular';
			$Rootshape_beetroot[] = 'Obovate';
			$Rootshape_beetroot[] = 'Narrow oblong';

			$Rootshape_kohlrabi = array();
			$Rootshape_kohlrabi[] = 'Transverse narrow elliptic';
			$Rootshape_kohlrabi[] = 'Transverse elliptic';
			$Rootshape_kohlrabi[] = 'Transverse broad elliptic';
			$Rootshape_kohlrabi[] = 'Circular';
			$Rootshape_kohlrabi[] = 'Broad elliptic';

			$RootSmoothness = array();
			$RootSmoothness[] = 'Very smooth';
			$RootSmoothness[] = 'Smooth';
			$RootSmoothness[] = 'Medium';
			$RootSmoothness[] = 'Wrinkled';
			$RootSmoothness[] = 'Very wrinkled';


			$RootSmoothness_kohlrabi = array();
			$RootSmoothness_kohlrabi[] = 'Less smooth';
			$RootSmoothness_kohlrabi[] = 'Smooth';

			$Shouldershape = array();
			$Shouldershape[] = 'Fully flat';
			$Shouldershape[] = 'Slightly flat';
			$Shouldershape[] = 'Flat/Round';
			$Shouldershape[] = 'Slghtly round';

			$Shouldershape_carrot = array();
			$Shouldershape_carrot[] = 'Fully flat';
			$Shouldershape_carrot[] = 'Slightly flat';
			$Shouldershape_carrot[] = 'Round';


			$Rootuniformity = array();
			$Rootuniformity[] = 'Very poor';
			$Rootuniformity[] = 'Poor';
			$Rootuniformity[] = 'Medium';
			$Rootuniformity[] = 'Good';
			$Rootuniformity[] = 'Very good';

			$Rootskin = array();
			$Rootskin[] = 'Dimpled or Corrugated';
			$Rootskin[] = 'Smooth';
			$Rootskin[] = 'Very smooth';

			$RootExternalcolor = array();
			$RootExternalcolor[] = 'White';
			$RootExternalcolor[] = 'Purple';
			$RootExternalcolor[] = 'Yellow';
			$RootExternalcolor[] = 'Orange';
			$RootExternalcolor[] = 'Orange-red';

			$RootExternalcolor_beetroot = array();
			$RootExternalcolor_beetroot[] = 'Purple-red';
			$RootExternalcolor_beetroot[] = 'Red';
			$RootExternalcolor_beetroot[] = 'Dark red';
			$RootExternalcolor_beetroot[] = 'White';
			$RootExternalcolor_beetroot[] = 'Yellow';

			$RootExternalcolor_kohlrabi = array();
			$RootExternalcolor_kohlrabi[] = 'White green';
			$RootExternalcolor_kohlrabi[] = 'Green';
			$RootExternalcolor_kohlrabi[] = 'Pale violet';
			$RootExternalcolor_kohlrabi[] = 'Dark violet';


			$Shoulderspurplinggreen = array();
			$Shoulderspurplinggreen[] = 'Sensitive';
			$Shoulderspurplinggreen[] = 'Less';
			$Shoulderspurplinggreen[] = 'Non';

			$SplittingBreakagetolerance = array();
			$SplittingBreakagetolerance[] = 'Very poor';
			$SplittingBreakagetolerance[] = 'Poor';
			$SplittingBreakagetolerance[] = 'Medium';
			$SplittingBreakagetolerance[] = 'Good';
			$SplittingBreakagetolerance[] = 'Very good';

			$Boltingresistance = array();
			$Boltingresistance[] = 'Very poor';
			$Boltingresistance[] = 'Poor';
			$Boltingresistance[] = 'Medium';
			$Boltingresistance[] = 'Good';
			$Boltingresistance[] = 'Very good';

			$Boltingresistance_beetroot = array();
			$Boltingresistance_beetroot[] = 'Very low';
			$Boltingresistance_beetroot[] = 'Low';
			$Boltingresistance_beetroot[] = 'Medium';
			$Boltingresistance_beetroot[] = 'High';
			$Boltingresistance_beetroot[] = 'Very High';

			$Boltingresistance_carrot = array();
			$Boltingresistance_carrot[] = 'Very low';
			$Boltingresistance_carrot[] = 'Low';
			$Boltingresistance_carrot[] = 'Average';
			$Boltingresistance_carrot[] = 'High';
			$Boltingresistance_carrot[] = 'Very high';

			$Boltingresistance_kohlrabi = array();
			$Boltingresistance_kohlrabi[] = 'Low';
			$Boltingresistance_kohlrabi[] = 'Medium';
			$Boltingresistance_kohlrabi[] = 'High';

			$Boltingresistance_lettuce = array();
			$Boltingresistance_lettuce[] = 'Very low';
			$Boltingresistance_lettuce[] = 'Low';
			$Boltingresistance_lettuce[] = 'Medium';
			$Boltingresistance_lettuce[] = 'High';
			$Boltingresistance_lettuce[] = 'Very high';

			$Boltingresistance_onion = array();
			$Boltingresistance_onion[] = 'Very low';
			$Boltingresistance_onion[] = 'Low';
			$Boltingresistance_onion[] = 'Medium';
			$Boltingresistance_onion[] = 'High';
			$Boltingresistance_onion[] = 'Very high';

			$Typeofcultivation = array();
			$Typeofcultivation[] = 'Open field';
			$Typeofcultivation[] = 'Plastic house';

			$Plantvigur =array();
			$Plantvigur[] = 'Very high';
			$Plantvigur[] = 'High';
			$Plantvigur[] = 'Medium';
			$Plantvigur[] = 'Low';
			$Plantvigur[] = 'Very low';

			$Plantvigur_beans =array();
			$Plantvigur_beans[] = 'Very weak';
			$Plantvigur_beans[] = 'Weak';
			$Plantvigur_beans[] = 'Medium';
			$Plantvigur_beans[] = 'Strong';
			$Plantvigur_beans[] = 'Very strong';

			$Plantvigur_beetroot =array();
			$Plantvigur_beetroot[] = 'Very weak';
			$Plantvigur_beetroot[] = 'Weak';
			$Plantvigur_beetroot[] = 'Medium';
			$Plantvigur_beetroot[] = 'Strong';
			$Plantvigur_beetroot[] = 'Very strong';

			$Plantvigur_carrot =array();
			$Plantvigur_carrot[] = 'Very weak';
			$Plantvigur_carrot[] = 'Weak';
			$Plantvigur_carrot[] = 'Medium';
			$Plantvigur_carrot[] = 'Strong';
			$Plantvigur_carrot[] = 'Very strong';

			$Plantvigur_cauliflower =array();
			$Plantvigur_cauliflower[] = 'Very weak';
			$Plantvigur_cauliflower[] = 'Weak';
			$Plantvigur_cauliflower[] = 'Medium';
			$Plantvigur_cauliflower[] = 'Strong';
			$Plantvigur_cauliflower[] = 'Very strong';

			$Plantvigur_kohlrabi =array();
			$Plantvigur_kohlrabi[] = 'Very weak';
			$Plantvigur_kohlrabi[] = 'Weak';
			$Plantvigur_kohlrabi[] = 'Medium';
			$Plantvigur_kohlrabi[] = 'Strong';
			$Plantvigur_kohlrabi[] = 'Very strong';

			$Plantvigur_lettuce =array();
			$Plantvigur_lettuce[] = 'Very weak';
			$Plantvigur_lettuce[] = 'Weak';
			$Plantvigur_lettuce[] = 'Medium';
			$Plantvigur_lettuce[] = 'Strong';
			$Plantvigur_lettuce[] = 'Very strong';

			$Plantvigur_melon =array();
			$Plantvigur_melon[] = 'Very weak';
			$Plantvigur_melon[] = 'Weak';
			$Plantvigur_melon[] = 'Medium';
			$Plantvigur_melon[] = 'Strong';
			$Plantvigur_melon[] = 'Very strong';

			$Plantvigur_okra=array();
			$Plantvigur_okra[] = 'Very weak';
			$Plantvigur_okra[] = 'Weak';
			$Plantvigur_okra[] = 'Medium';
			$Plantvigur_okra[] = 'Strong';
			$Plantvigur_okra[] = 'Very strong';

			$Plantvigur_onion = array();
			$Plantvigur_onion[] = 'Very weak';
			$Plantvigur_onion[] = 'Weak';
			$Plantvigur_onion[] = 'Medium';
			$Plantvigur_onion[] = 'Strong';
			$Plantvigur_onion[] = 'Very strong';

			$Plantvigur_pea = array();
			$Plantvigur_pea[] = 'Very weak';
			$Plantvigur_pea[] = 'Weak';
			$Plantvigur_pea[] = 'Medium';
			$Plantvigur_pea[] = 'Strong';
			$Plantvigur_pea[] = 'Very strong';

			$Plantvigur_radish = array();
			$Plantvigur_radish[] = 'Very weak';
			$Plantvigur_radish[] = 'Weak';
			$Plantvigur_radish[] = 'Medium';
			$Plantvigur_radish[] = 'Strong';
			$Plantvigur_radish[] = 'Very strong';

			$Plantvigur_watermelon = array();
			$Plantvigur_watermelon[] = 'Very weak';
			$Plantvigur_watermelon[] = 'Weak';
			$Plantvigur_watermelon[] = 'Medium';
			$Plantvigur_watermelon[] = 'Strong';
			$Plantvigur_watermelon[] = 'Very strong';

			$Plantvigur_common= array();
			$Plantvigur_common[] = 'Very weak';
			$Plantvigur_common[] = 'Weak';
			$Plantvigur_common[] = 'Medium';
			$Plantvigur_common[] = 'Strong';
			$Plantvigur_common[] = 'Very strong';


			$Plantvigur_chinesecabbage =array();
			$Plantvigur_chinesecabbage[] = 'Very weak';
			$Plantvigur_chinesecabbage[] = 'Weak';
			$Plantvigur_chinesecabbage[] = 'Medium';
			$Plantvigur_chinesecabbage[] = 'Strong';
			$Plantvigur_chinesecabbage[] = 'Very strong';

			$Maturityindays = array();
			$Maturityindays[] = 'Very early';
			$Maturityindays[] = 'Early';
			$Maturityindays[] = 'Medium (Same)';
			$Maturityindays[] = 'Late';
			$Maturityindays[] = 'Very late';

			$Maturityindays_chinesecabbage = array();
			$Maturityindays_chinesecabbage[] = 'Very early';
			$Maturityindays_chinesecabbage[] = 'Early';
			$Maturityindays_chinesecabbage[] = 'Medium';
			$Maturityindays_chinesecabbage[] = 'Late';


			$Growthheight = array();
			$Growthheight[] = 'Very short';
			$Growthheight[] = 'Short';
			$Growthheight[] = 'Medium';
			$Growthheight[] = 'Long';
			$Growthheight[] = 'Very long';

			$Growthheight_carrot = array();
			$Growthheight_carrot[] = 'Very short';
			$Growthheight_carrot[] = 'Short';
			$Growthheight_carrot[] = 'Medium';
			$Growthheight_carrot[] = 'Long';
			$Growthheight_carrot[] = 'Very long';

			$Growthheight_dettomato = array();
			$Growthheight_dettomato[] = 'Very short';
			$Growthheight_dettomato[] = 'Short';
			$Growthheight_dettomato[] = 'Medium';
			$Growthheight_dettomato[] = 'Tall';
			$Growthheight_dettomato[] = 'Very tall';

			$Growthheight_indtomato= array();
			$Growthheight_indtomato[] = 'Very short';
			$Growthheight_indtomato[] = 'Short';
			$Growthheight_indtomato[] = 'Medium';
			$Growthheight_indtomato[] = 'Tall';
			$Growthheight_indtomato[] = 'Very tall';

			$Friutwidth_chinesecabbage= array();
			$Friutwidth_chinesecabbage[] = 'Narrow';
			$Friutwidth_chinesecabbage[] = 'Medium';
			$Friutwidth_chinesecabbage[] = 'Broad';

			$Flowercolour = array();
			$Flowercolour[] = 'White';
			$Flowercolour[] = 'Pinkish white';
			$Flowercolour[] = 'Pink';
			$Flowercolour[] = 'Violet';
			$Flowercolour[] = 'Red';
			$Flowercolour[] = 'Orange';

			$Flowercolour_pea = array();
			$Flowercolour_pea[] = 'White';
			$Flowercolour_pea[] = 'Purple';

			$Podcrosssection = array();
			$Podcrosssection[] = 'Round';
			$Podcrosssection[] = 'Flat';
			$Podcrosssection[] = 'Oval';

			$Stringless = array();
			$Stringless[] = 'No';
			$Stringless[] = 'Yes';

			$Glossyness = array();
			$Glossyness[] = 'Low';
			$Glossyness[] = 'Medium';
			$Glossyness[] = 'High';
			
			$Primarypodcolour = array();
			$Primarypodcolour[] = 'Light yellow';
			$Primarypodcolour[] = 'Medium yellow';
			$Primarypodcolour[] = 'Dark yellow';
			$Primarypodcolour[] = 'Purple';
			$Primarypodcolour[] = 'Dark purple';
			$Primarypodcolour[] = 'Light green';
			$Primarypodcolour[] = 'Medium green';
			$Primarypodcolour[] = 'Dark green';
			$Primarypodcolour[] = 'Very dark green';
			

			$Secondarypodcolour = array();
			$Secondarypodcolour[] = 'Purple stripes';
			$Secondarypodcolour[] = 'Light red stripes';
			$Secondarypodcolour[] = 'Medium red stripes';
			$Secondarypodcolour[] = 'Dark red stripes';

			$Cookingvalue = array();
			$Cookingvalue[] = 'Very poor';
			$Cookingvalue[] = 'Poor';
			$Cookingvalue[] = 'Medium';
			$Cookingvalue[] = 'Good';
			$Cookingvalue[] = 'Very good';

			$Leafattachment = array();
	        $Leafattachment[] = 'Very poor';
	        $Leafattachment[] = 'Poor';
	        $Leafattachment[] = 'Medium';
	        $Leafattachment[] = 'Good';
	        $Leafattachment[] = 'Very good';

	        $Foliagelength = array();
	        $Foliagelength[] = 'Short';
	        $Foliagelength[] = 'Medium';
	        $Foliagelength[] = 'Long';

	        $Leafimplant = array();
	        $Leafimplant[] = 'Small';
	        $Leafimplant[] = 'Medium';
	        $Leafimplant[] = 'Large';

	        $Leafimplant_radish = array();
	        $Leafimplant_radish[] = 'Less fine';
	        $Leafimplant_radish[] = 'fine';
	        $Leafimplant_radish[] = 'Round';
	        $Leafimplant_radish[] = 'Oval';

	        $Foliageatittude = array();
	        $Foliageatittude[] = 'Semi erect';
	        $Foliageatittude[] = 'Erect';

	        $Rootinternalcolor = array();
	        $Rootinternalcolor[] = 'Light red';
	        $Rootinternalcolor[] = 'Medium red';
	        $Rootinternalcolor[] = 'Blood red';
	        $Rootinternalcolor[] = 'Dark red';

	        $Rootinternalcolor_beetroot = array();
	        $Rootinternalcolor_beetroot[] = 'Light red';
	        $Rootinternalcolor_beetroot[] = 'Blood red';
	        $Rootinternalcolor_beetroot[] = 'Dark red';


	        $Rootsize = array();
	        $Rootsize[] = 'Small';
	        $Rootsize[] = 'Medium';
	        $Rootsize[] = 'Medium large';
	        $Rootsize[] = 'Large';

	        $Rootsize_radish = array();
	        $Rootsize_radish[] = 'Small';
	        $Rootsize_radish[] = 'Medium';
	        $Rootsize_radish[] = 'Large';

	        $Rootsize_beetroot = array();
	        $Rootsize_beetroot[] = 'Small';
	        $Rootsize_beetroot[] = 'Medium';
	        $Rootsize_beetroot[] = 'Large';

	        $Taprootsize = array();
	        $Taprootsize[] = 'Small';
	        $Taprootsize[] = 'Medium';
	        $Taprootsize[] = 'Large';

	        $Skinsmoothness = array();
	        $Skinsmoothness[] = 'Very poor';
	        $Skinsmoothness[] = 'Poor';
	        $Skinsmoothness[] = 'Medium';
	        $Skinsmoothness[] = 'Good';
	        $Skinsmoothness[] = 'Very good';

	        $Skinsmoothness_okra = array();
	        $Skinsmoothness_okra[] = 'Smooth';
	        $Skinsmoothness_okra[] = 'Ribbed';

			$Zoning = array();
	        $Zoning[] = 'Absent';
	        $Zoning[] = 'Present';

	        $Whiterings = array();
	        $Whiterings[] = 'None';
	        $Whiterings[] = 'Very few';
	        $Whiterings[] = 'Few';
	        $Whiterings[] = 'Fair';

	        $Whiterings_beetroot = array();
	        $Whiterings_beetroot[] = 'None';
	        $Whiterings_beetroot[] = 'Few';
	        $Whiterings_beetroot[] = 'Fair';

	        $Sugarcontent = array();
	        $Sugarcontent[] = 'Low';
	        $Sugarcontent[] = 'High';

	        $Flavour = array();
	        $Flavour[] = 'Mild';
	        $Flavour[] = 'Pungent';

	        $Spinedevelopment = array();
	        $Spinedevelopment[] = 'Present';
	        $Spinedevelopment[] = 'Absent';

	        $Planttype = array();
	        $Planttype[] = 'Normal';
	        $Planttype[] = 'Aphila';

	        $Podshape = array();
	        $Podshape[] = 'Blunt';
	        $Podshape[] = 'Flat';

	        $Podcolour = array();
	        $Podcolour[] = 'Light green';
	        $Podcolour[] = 'Medium green';
	        $Podcolour[] = 'Glossy green';
	        $Podcolour[] = 'Dark green';

	        $Standingleaves = array();
	        $Standingleaves[] = 'Broad semi-erect';
	        $Standingleaves[] = 'Broad erect';

	        $Radishshape = array();
	        $Radishshape[] = 'Elongated';
	        $Radishshape[] = 'Cylindrical';
	        $Radishshape[] = 'Round';
	        $Radishshape[] = 'Oval';

	        $Radishdevelopment = array();
	        $Radishdevelopment[] = 'Quick';
	        $Radishdevelopment[] = 'Slow';

	        $Radishuniformity = array();
	        $Radishuniformity[] = 'Very poor';
	        $Radishuniformity[] = 'Poor';
	        $Radishuniformity[] = 'Medium';
	        $Radishuniformity[] = 'Good';
	        $Radishuniformity[] = 'Very good';

	        $Root = array();
	        $Root[] = 'Less fine';
	        $Root[] = 'Fine';

	        $Radishcolour = array();
	        $Radishcolour[] = 'Pink';
	        $Radishcolour[] = 'Red';
	        $Radishcolour[] = 'Bright red';
	        $Radishcolour[] = 'White';
		/*======= Default Options Array END ===*/

		/*======= Data Array START ===*/
			$data['error']=$error;
			$data['active']='evaluation';
			$data['submenuactive']='evaluationedit';
			$data['Plantvigur_cabbage']=$Plantvigur_cabbage;
			$data['Plantvigur_eggplant']=$Plantvigur_eggplant;
			$data['Plantvigur_pepper']=$Plantvigur_pepper;
			$data['Plantvigur_sweetcorn']=$Plantvigur_sweetcorn;
			$data['Plantsize']=$Plantsize;
			$data['Bulbshape']=$Bulbshape;
			$data['Bulbshape_onion']=$Bulbshape_onion;
			$data['Bulbshapeuniformit']=$Bulbshapeuniformit;
			$data['Varietytype']=$Varietytype;
			$data['Varietytype_beans']=$Varietytype_beans;
			$data['Varietytype_kohlrabi']=$Varietytype_kohlrabi;
			$data['Varietytype_squash']=$Varietytype_squash;
			$data['Varietytype_sweetcorn']=$Varietytype_sweetcorn;
			$data['Headformation']=$Headformation;
			$data['Headformation_lettuce']=$Headformation_lettuce;
			$data['Leafcolour']=$Leafcolour;
			$data['Leafcolour_beetroot']=$Leafcolour_beetroot;
			$data['Leafcolour_kohlrabi']=$Leafcolour_kohlrabi;
			$data['Leafcolour_okra']=$Leafcolour_okra;
			$data['Headsize']=$Headsize;
			$data['Leaftexture']=$Leaftexture;
			$data['Plantvigur_broccoli']=$Plantvigur_broccoli;
			$data['Plantvigur_cucumber']=$Plantvigur_cucumber;
			$data['Plantvigur_dettomato']=$Plantvigur_dettomato;
			$data['Plantvigur_indtomato']=$Plantvigur_indtomato;
			$data['Plantvigur_squash']=$Plantvigur_squash;
			$data['Fruitshape']=$Fruitshape;
			$data['Fruitshape_dettomato']=$Fruitshape_dettomato;
			$data['Fruitshape_eggplant']=$Fruitshape_eggplant;
			$data['Fruitshape_indtomato']=$Fruitshape_indtomato;
			$data['Fruitshape_melon']=$Fruitshape_melon;
			$data['Fruitshape_okra']=$Fruitshape_okra;
			$data['Fruitshape_pepper']=$Fruitshape_pepper;
			$data['Fruitshape_squash']=$Fruitshape_squash;
			$data['Fruitshape_watermelon']=$Fruitshape_watermelon;
			$data['Fruitshape_chinesecabbage']=$Fruitshape_chinesecabbage;
			$data['Headtype_chinesecabbage']=$Headtype_chinesecabbage;
			$data['HeatColdresisttol_chinesecabbage']=$HeatColdresisttol_chinesecabbage;
			
			$data['Fruitnetting']=$Fruitnetting;
			$data['Fruitribbing']=$Fruitribbing;
			$data['Yield']=$Yield;
			$data['Spongeness']=$Spongeness;
			$data['Fruitnumbercluster']=$Fruitnumbercluster;
			$data['Yield_cabbage']=$Yield_cabbage;
			$data['Yield_dettomato']=$Yield_dettomato;
			$data['Yield_pepper']=$Yield_pepper;
			$data['FruitGreenShoulders']=$FruitGreenShoulders;
			$data['Fruitcracking']=$Fruitcracking;
			$data['Fruitcracking_dettomato']=$Fruitcracking_dettomato;
			$data['Fruitcracking_indtomato']=$Fruitcracking_indtomato;
			$data['Fruitcracking_pepper']=$Fruitcracking_pepper;
			$data['FruitFirmnessatfinalcolour']=$FruitFirmnessatfinalcolour;
			$data['Fruitintensityofcolourbeforematurity']=$Fruitintensityofcolourbeforematurity;
			$data['Fruitintensityofcolouratmaturity']=$Fruitintensityofcolouratmaturity;
			$data['Fruitintensityofcolouratmaturity_pepper']=$Fruitintensityofcolouratmaturity_pepper;
			$data['Fruitintensityofcolouratmaturity_dettomato']=$Fruitintensityofcolouratmaturity_dettomato;
			$data['Maturity']=$Maturity;
			$data['Maturity_cabbage']=$Maturity_cabbage;
			$data['Maturity_broccoli']=$Maturity_broccoli;
			$data['Maturity_carrot']=$Maturity_carrot;
			$data['Maturity_cauliflower']=$Maturity_cauliflower;
			$data['Maturity_dettomato']=$Maturity_dettomato;
			$data['Maturity_indettomato']=$Maturity_indettomato;
			$data['Maturity_indtomato']=$Maturity_indtomato;
			$data['Maturity_eggplant']=$Maturity_eggplant;
			$data['Maturity_pepper']=$Maturity_pepper;
			$data['Maturity_squash']=$Maturity_squash;
			$data['Firmness']=$Firmness;
			$data['Fruitglossiness']=$Fruitglossiness;
			$data['Fruitglossiness_squash']=$Fruitglossiness_squash;
			$data['Uniformity']=$Uniformity;
			$data['Uniformity_cabbage']=$Uniformity_cabbage;
			$data['Uniformity_cauliflower']=$Uniformity_cauliflower;
			$data['Uniformity_common']=$Uniformity_common;
			$data['Uniformity_chinesecabbage']=$Uniformity_chinesecabbage;
			$data['Fruitsettingunderlowtemperature']=$Fruitsettingunderlowtemperature;
			$data['Fruitsettingunderhightemperature']=$Fruitsettingunderhightemperature;
			$data['Fieldstandingability']=$Fieldstandingability;
			$data['Resistance']=$Resistance;
			$data['AveragewieghtIn']=$AveragewieghtIn;
			$data['FriutwidthIn']=$FriutwidthIn;
			$data['FriutlengthIn']=$FriutlengthIn;
			$data['Fruitcolor']=$Fruitcolor;
			$data['Overallrating']=$Overallrating;
			$data['Status']=$Status;

			$data['Plantframesize']=$Plantframesize;
			$data['Stemthickness']=$Stemthickness;
			$data['Curdcolor']=$Curdcolor;
			$data['Curdcolor_brocoli']=$Curdcolor_brocoli;
			$data['Curdcolor_cauliflower']=$Curdcolor_cauliflower;
			$data['Curdcover']=$Curdcover;
			$data['CurdUniformity']=$CurdUniformity;
			$data['Fieldholdability']=$Fieldholdability;
			$data['Headshape']=$Headshape;
			$data['Headshape_brocoli']=$Headshape_brocoli;
			$data['Headshape_cabbage']=$Headshape_cabbage;
			$data['Headknobbling']=$Headknobbling;
			$data['Beadsize']=$Beadsize;
			$data['Headuniformity']=$Headuniformity;
			$data['Headuniformity_cabbage']=$Headuniformity_cabbage;
			$data['Headuniformity_lettuce']=$Headuniformity_lettuce;
			$data['Headuniformity_chinesecabbage']=$Headuniformity_chinesecabbage;
			$data['Firmness_broccoli']=$Firmness_broccoli;
			$data['Firmness_pepper']=$Firmness_pepper;
			$data['Firmness_okra']=$Firmness_okra;
			$data['Firmness_chinesecabbage']=$Firmness_chinesecabbage;
			$data['Firmness_cauliflower']=$Firmness_cauliflower;
			$data['Firmness_eggplant']=$Firmness_eggplant;
			$data['Sideshoots']=$Sideshoots;
			$data['Fieldstandingability']=$Fieldstandingability;
			$data['Heatresittol']=$Heatresittol;
			$data['Heatresittol_cauliflower']=$Heatresittol_cauliflower;
			$data['Coldresisttol']=$Coldresisttol;
			$data['Coldresisttol_cauliflower']=$Coldresisttol_cauliflower;
			$data['Rating']=$Rating;
			$data['Rating_brussels']=$Rating_brussels;
			$data['Rating_sunflower']=$Rating_sunflower;
			$data['Rating_turnip']=$Rating_turnip;
			$data['Rating_broccoli']=$Rating_broccoli;
			$data['Rating_spinach']=$Rating_spinach;
			$data['Rating_cauliflower']=$Rating_cauliflower;
			$data['Rating_celery']=$Rating_celery;
			$data['Rating_corn']=$Rating_corn;
			$data['Rating_leafvegetable']=$Rating_leafvegetable;
			$data['Rating_pumpkin']=$Rating_pumpkin;
			$data['Rating_soybean']=$Rating_soybean;
			$data['Rating_radish']=$Rating_radish;
			$data['Rating_rootstock']=$Rating_rootstock;
			$data['Rating_melon']=$Rating_melon;
			$data['Rating_cucumber']=$Rating_cucumber;
			$data['Rating_carrot']=$Rating_carrot;
			$data['Rating_cabbage']=$Rating_cabbage;
			$data['Rating_chinesecabbage']=$Rating_chinesecabbage;
			$data['Rating_watermelon']=$Rating_watermelon;
			$data['Rating_bunchingonion']=$Rating_bunchingonion;
			$data['Rating_onion']=$Rating_onion;
			$data['Rating_sweetcorn']=$Rating_sweetcorn;
			$data['Dryskinafterharvest']=$Dryskinafterharvest;
			$data['Necksize']=$Necksize;
			$data['Thicknessofdryskin']=$Thicknessofdryskin;
			$data['Basecolourdryskin']=$Basecolourdryskin;
			$data['Widthofneck']=$Widthofneck;
			$data['Storability']=$Storability;
			$data['Conclusion']=$Conclusion;

			$data['Plantstructure']=$Plantstructure;
			$data['Plantstructure_cucumber']=$Plantstructure_cucumber;
			$data['Plantstructure_radish']=$Plantstructure_radish;
			$data['Plantstructure_common']=$Plantstructure_common;
			$data['Fruitshapeuniformity']=$Fruitshapeuniformity;
			$data['Plantsideshootbehaviour']=$Plantsideshootbehaviour;
			$data['PowderyMildewSf']=$PowderyMildewSf;
			$data['SkinCucumber']=$SkinCucumber;
			$data['DownyMildewPcu']=$DownyMildewPcu;
			$data['Fruitcolour']=$Fruitcolour;
			$data['Fruitcolour_cucumber']=$Fruitcolour_cucumber;
			$data['Fruitoverallquality']=$Fruitoverallquality;
			$data['DiseaseTolerance']=$DiseaseTolerance;
			$data['Fruitquality']=$Fruitquality;
			$data['Yieldcontinuity']=$Yieldcontinuity;
			$data['Yieldcontinuity_Cucumber']=$Yieldcontinuity_Cucumber;
			$data['Yieldcontinuity_beans']=$Yieldcontinuity_beans;
			$data['Yieldcontinuity_dettomato']=$Yieldcontinuity_dettomato;
			$data['Yieldcontinuity_eggplant']=$Yieldcontinuity_eggplant;
			$data['Yieldcontinuity_indtomato']=$Yieldcontinuity_indtomato;
			$data['Yieldcontinuity_okra']=$Yieldcontinuity_okra;
			$data['Yieldcontinuity_pepper']=$Yieldcontinuity_pepper;
			$data['Yieldcontinuity_squash']=$Yieldcontinuity_squash;
			$data['VisualYield_melon']=$VisualYield_melon;
			$data['VisualYield_common']=$VisualYield_common;
			$data['VisualYield']=$VisualYield;


			$data['Fleshcolor']=$Fleshcolor;
			$data['Fleshcolor_watermelon']=$Fleshcolor_watermelon;
			$data['Seedcavity']=$Seedcavity;
			$data['Seedcavity_melon']=$Seedcavity_melon;
			$data['Fruittaste']=$Fruittaste;
			$data['Fruittaste_dettomato']=$Fruittaste_dettomato;
			$data['Fruittaste_eggplant']=$Fruittaste_eggplant;
			$data['Fruittaste_lettuce']=$Fruittaste_lettuce;
			$data['Fruittaste_watermelon']=$Fruittaste_watermelon;
			$data['Fleshfirmness']=$Fleshfirmness;
			$data['Fleshfirmness_watermelon']=$Fleshfirmness_watermelon;
			$data['HollowHeartSeverity']=$HollowHeartSeverity;
			$data['SeedsSize']=$SeedsSize;
			$data['SeedsContent']=$SeedsContent;
			$data['Shelflife']=$Shelflife;
			$data['Shelflife_radish']=$Shelflife_radish;
			$data['Shelflife_Melon']=$Shelflife_Melon;
			$data['Seedcolour']=$Seedcolour;
			$data['Seedcolour_beans']=$Seedcolour_beans;
			$data['Tipfilling']=$Tipfilling;
			$data['Harvesting']=$Harvesting;
			$data['Harvesting_beans']=$Harvesting_beans;
			$data['Harvesting_beetroot']=$Harvesting_beetroot;
			$data['Harvesting_kohlrabi']=$Harvesting_kohlrabi;
			$data['Harvesting_okra']=$Harvesting_okra;
			$data['Harvesting_pea']=$Harvesting_pea;
			$data['Harvesting_radish']=$Harvesting_radish;
			
			$data['Kerneltenderness']=$Kerneltenderness;
			$data['Curdanthocyanin']=$Curdanthocyanin;
			$data['Yieldestimated']=$Yieldestimated;
			$data['PlantCover']=$PlantCover;
			$data['PlantCover_dettomato']=$PlantCover_dettomato;
			$data['PlantCover_watermelon']=$PlantCover_watermelon;
			$data['InternodesLength']=$InternodesLength;
			$data['InternodesLength_okra']=$InternodesLength_okra;
			$data['LeafCurlingRolling']=$LeafCurlingRolling;
			$data['LeafCurlingRolling_dettomato']=$LeafCurlingRolling_dettomato;
			$data['ParthenocarpicFruits']=$ParthenocarpicFruits;
			$data['PlantBalance']=$PlantBalance;
			$data['Fruitsetting']=$Fruitsetting;
			$data['Fruitsetting_dettomato']=$Fruitsetting_dettomato;
			$data['Fruitsetting_indettomato']=$Fruitsetting_indettomato;
			$data['Fruitsizeuniformity']=$Fruitsizeuniformity;
			$data['Fruitsizeuniformity_eggplant']=$Fruitsizeuniformity_eggplant;
			$data['Fruitsizeuniformity_melon']=$Fruitsizeuniformity_melon;
			$data['Fruitsizeuniformity_okra']=$Fruitsizeuniformity_okra;
			$data['Fruitsizeuniformity_onion']=$Fruitsizeuniformity_onion;
			$data['Fruitsizeuniformity_pepper']=$Fruitsizeuniformity_pepper;
			$data['Fruitsizeuniformity_squash']=$Fruitsizeuniformity_squash;
			$data['Fruitsizeuniformity_watermelon']=$Fruitsizeuniformity_watermelon;
			$data['Fruitsizeuniformity_common']=$Fruitsizeuniformity_common;
			$data['FruitSizeuniformitycluster']=$FruitSizeuniformitycluster;
			$data['FruitRibbness']=$FruitRibbness;
			$data['CalyxApperarance']=$CalyxApperarance;
			$data['CalyxApperarance_dettomato']=$CalyxApperarance_dettomato;
			$data['Fruitcolourmaturity']=$Fruitcolourmaturity;
			$data['Fruitcolourmaturity_dettomato']=$Fruitcolourmaturity_dettomato;
			$data['FruitRindPattern']=$FruitRindPattern;
			$data['RindAttractivness']=$RindAttractivness;
			$data['Fruitcolouratmaturity']=$Fruitcolouratmaturity;
			$data['Fruitcolouratmaturity_eggplant']=$Fruitcolouratmaturity_eggplant;
			$data['Fruitcolouratmaturity_okra']=$Fruitcolouratmaturity_okra;
			$data['Fruitcolouratmaturity_squash']=$Fruitcolouratmaturity_squash;
			
			$data['Headcolor']=$Headcolor;
			$data['Headcolor_chinesecabbage']=$Headcolor_chinesecabbage;
			$data['Leafwaxiness']=$Leafwaxiness;
			$data['Coresize']=$Coresize;
			$data['Coresize_carrot']=$Coresize_carrot;
			$data['anthocyanincolorationofcoverleaf']=$anthocyanincolorationofcoverleaf;
			$data['Headdensity']=$Headdensity;
			$data['Marketsegment_beans']=$Marketsegment_beans;
			$data['Marketsegment_beetroot']=$Marketsegment_beetroot;
			$data['Marketsegment']=$Marketsegment;
			$data['Marketsegment_radish']=$Marketsegment_radish;
			$data['Growthtype']=$Growthtype;
			$data['Growthtype_beans']=$Growthtype_beans;
			$data['Growthtype_okra']=$Growthtype_okra;
			$data['Growthtype_radish']=$Growthtype_radish;
			$data['Planthabit']=$Planthabit;
			$data['Planthabit_kohlrabi']=$Planthabit_kohlrabi;
			$data['Silvering']=$Silvering;
			$data['Branching']=$Branching;
			$data['YongfruitRatio']=$YongfruitRatio;
			$data['Stripesripefruit']=$Stripesripefruit;
			$data['Blossomscar']=$Blossomscar;
			$data['Easypicking']=$Easypicking;
			$data['PostHarvestQuality']=$PostHarvestQuality;
			$data['EarlyYield']=$EarlyYield;
			$data['TotalYield']=$TotalYield;
			$data['Anthocyanin']=$Anthocyanin;
			$data['Anthocyanin_beetroot']=$Anthocyanin_beetroot;
			$data['Earhuskleafcolor']=$Earhuskleafcolor;
			$data['Flagleavesappearanceonear']=$Flagleavesappearanceonear;
			$data['EarProtection']=$EarProtection;
			$data['Averagenumberofrows']=$Averagenumberofrows;
			$data['Foliagecolor']=$Foliagecolor;
			$data['Foliagecolor_carrot']=$Foliagecolor_carrot;
			$data['Alternariapminfection']=$Alternariapminfection;
			$data['Diseasespest']=$Diseasespest;
			$data['Crackingroot']=$Crackingroot;
			$data['Maturityvscontrol']=$Maturityvscontrol;
			$data['Maturityvscontrol_lettuce']=$Maturityvscontrol_lettuce;
			$data['Maturityvscontrol_melon']=$Maturityvscontrol_melon;
			$data['Maturityvscontrol_onion']=$Maturityvscontrol_onion;
			$data['Maturityvscontrol_sweetcorn']=$Maturityvscontrol_sweetcorn;
			$data['Maturityvscontrol_watermelon']=$Maturityvscontrol_watermelon;
			
			$data['Subtype']=$Subtype;
			$data['Plantheight']=$Plantheight;
			$data['Plantheight_chinesecabbage']=$Plantheight_chinesecabbage;
			$data['Curdshape']=$Curdshape;
			$data['Rootshape']=$Rootshape;
			$data['Rootshape_beetroot']=$Rootshape_beetroot;
			$data['Rootshape_kohlrabi']=$Rootshape_kohlrabi;
			$data['Rootshape_carrot']=$Rootshape_carrot;
			$data['RootSmoothness']=$RootSmoothness;
			$data['RootSmoothness_kohlrabi']=$RootSmoothness_kohlrabi;
			$data['Shouldershape']=$Shouldershape;
			$data['Shouldershape_carrot']=$Shouldershape_carrot;
			$data['Rootuniformity']=$Rootuniformity;
			$data['Rootskin']=$Rootskin;
			$data['RootExternalcolor']=$RootExternalcolor;
			$data['RootExternalcolor_beetroot']=$RootExternalcolor_beetroot;
			$data['RootExternalcolor_kohlrabi']=$RootExternalcolor_kohlrabi;
			$data['Shoulderspurplinggreen']=$Shoulderspurplinggreen;
			$data['SplittingBreakagetolerance']=$SplittingBreakagetolerance;
			$data['Boltingresistance']=$Boltingresistance;
			$data['Boltingresistance_beetroot']=$Boltingresistance_beetroot;
			$data['Boltingresistance_carrot']=$Boltingresistance_carrot;
			$data['Boltingresistance_kohlrabi']=$Boltingresistance_kohlrabi;
			$data['Boltingresistance_lettuce']=$Boltingresistance_lettuce;
			$data['Boltingresistance_onion']=$Boltingresistance_onion;

			$data['Typeofcultivation']=$Typeofcultivation;
			
			$data['Plantvigur']=$Plantvigur;
			$data['Plantvigur_beans']=$Plantvigur_beans;
			$data['Plantvigur_beetroot']=$Plantvigur_beetroot;
			$data['Plantvigur_carrot']=$Plantvigur_carrot;
			$data['Plantvigur_cauliflower']=$Plantvigur_cauliflower;
			$data['Plantvigur_kohlrabi']=$Plantvigur_kohlrabi;
			$data['Plantvigur_lettuce']=$Plantvigur_lettuce;
			$data['Plantvigur_melon']=$Plantvigur_melon;
			$data['Plantvigur_okra']=$Plantvigur_okra;
			$data['Plantvigur_onion']=$Plantvigur_onion;
			$data['Plantvigur_pea']=$Plantvigur_pea;
			$data['Plantvigur_radish']=$Plantvigur_radish;
			$data['Plantvigur_watermelon']=$Plantvigur_watermelon;
			$data['Plantvigur_common']=$Plantvigur_common;
			$data['Plantvigur_chinesecabbage']=$Plantvigur_chinesecabbage;
			$data['Maturityindays']=$Maturityindays;
			$data['Maturityindays_chinesecabbage']=$Maturityindays_chinesecabbage;
			$data['Growthheight']=$Growthheight;
			$data['Growthheight_carrot']=$Growthheight_carrot;
			$data['Growthheight_dettomato']=$Growthheight_dettomato;
			$data['Growthheight_indtomato']=$Growthheight_indtomato;
			$data['Friutwidth_chinesecabbage']=$Friutwidth_chinesecabbage;
			$data['Flowercolour']=$Flowercolour;
			$data['Flowercolour_pea']=$Flowercolour_pea;
			$data['Podcrosssection']=$Podcrosssection;
			$data['Stringless']=$Stringless;
			$data['Glossyness']=$Glossyness;
			$data['Primarypodcolour']=$Primarypodcolour;
			$data['Secondarypodcolour']=$Secondarypodcolour;
			$data['Cookingvalue']=$Cookingvalue;
			$data['Leafattachment']=$Leafattachment;
			$data['Foliagelength']=$Foliagelength;
			$data['Leafimplant']=$Leafimplant;
			$data['Leafimplant_radish']=$Leafimplant_radish;
			$data['Foliageatittude']=$Foliageatittude;
			$data['Rootinternalcolor']=$Rootinternalcolor;
			$data['Rootinternalcolor_beetroot']=$Rootinternalcolor_beetroot;
			$data['Rootsize']=$Rootsize;
			$data['Rootsize_beetroot']=$Rootsize_beetroot;
			$data['Rootsize_radish']=$Rootsize_radish;

			$data['Taprootsize']=$Taprootsize;
			$data['Skinsmoothness']=$Skinsmoothness;
			$data['Skinsmoothness_okra']=$Skinsmoothness_okra;
			$data['Zoning']=$Zoning;
			$data['Whiterings']=$Whiterings;
			$data['Whiterings_beetroot']=$Whiterings_beetroot;
			$data['Sugarcontent']=$Sugarcontent;
			$data['Flavour']=$Flavour;
			$data['Spinedevelopment']=$Spinedevelopment;
			$data['Planttype']=$Planttype;
			$data['Podshape']=$Podshape;
			$data['Podcolour']=$Podcolour;
			$data['Standingleaves']=$Standingleaves;
			$data['Radishshape']=$Radishshape;
			$data['Radishdevelopment']=$Radishdevelopment;
			$data['Radishuniformity']=$Radishuniformity;
			$data['Root']=$Root;
			$data['Radishcolour']=$Radishcolour;



			$data['Toplength']=$this->input->post('Toplength');
			$data['Podlength']=$this->input->post('Podlength');
			$data['Poddiameter']=$this->input->post('Poddiameter');
			$data['Rootweight']=$this->input->post('Rootweight');

			$data['get_single_evaluation']= $get_single_evaluation;
			$data['EvaluationID']= $EvaluationID;
			$data['cropview']= $cropview;
			$data['getsampling']= $getsampling;
			$data['location'] = @$location;
			$data['crops_title']=@$crops_title;
			$data['Receiver_name']=@$Receiver_name;
			$data['segment2']=$segment2;
		/*======= Data Array END ===*/

		if($segment2 == 'evaluationview'){
			$this->load->view('evaluationview',$data);
		}
		else{
			$this->load->view('evaluationedit',$data);
		}
		
	}

	public function evaluationclose(){
		$validateLogin = $this->validateLogin('evaluation','list');
		$get_user_detail=$this->Evaluationadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		if($userrole=='6'){
			redirect('admin/evaluationedit');
			exit();
		} 
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		// echo "<pre>";
		// print_r($data['userrole']);
		// echo "</pre>";
		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');
		$Variety = $this->input->get('Variety');
		$Location = $this->input->get('Location');
		$Techncialteam  = $this->input->get('Techncialteam');
		$FromDate  = $this->input->get('FromDate');
		$ToDate  = $this->input->get('ToDate');
		$Internalsamplingcode  = $this->input->get('Internalsamplingcode');

		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){

			$get_evaluation_close_all = $this->Evaluationadmin->filter_get_evaluation_close_count_all($data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
		}else{
			$get_evaluation_close_all = $this->Evaluationadmin->get_evaluation_close_all($data['userrole']);
		}

		$get_evaluation_close_all_arr = array();
		if($get_evaluation_close_all){
			foreach ($get_evaluation_close_all as $key => $value) {
				$get_sampling = $this->Evaluationadmin->get_sampling($value['Internalsamplecode']);
				$get_seed = $this->Evaluationadmin->get_seed($get_sampling['Seed']);
				if($get_seed){
					$get_evaluation_close_all_arr[$get_seed['Variety']] = $value['EvaluationID'];
				}
			}
		}

		$get_evaluation_close_all_arr1 = array();
		foreach ($get_evaluation_close_all_arr as $key => $value) {
			$get_evaluation_close_all_arr1[] = $value;
		}


		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$total_rows = $this->Evaluationadmin->filter_get_evaluation_close_count($data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode,$get_evaluation_close_all_arr1);
   		}else{
   			$total_rows = $this->Evaluationadmin->get_evaluation_close_count($data['userrole'],$get_evaluation_close_all_arr1);
   		}


		$config = array();
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['base_url'] =base_url('admin/evaluationclose');
		$config['use_page_numbers'] = false;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$config['num_links'] = 4;
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        if($this->uri->segment(3) > 0){
		    $start = $this->uri->segment(3)+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) + $config['per_page'];
		}else{
		    $start= (int)$this->uri->segment(3) * $config['per_page']+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
		}
		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$get_evaluation = $this->Evaluationadmin->filter_get_evaluation_close($config["per_page"], $page,$data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode,$get_evaluation_close_all_arr1);
   		}else{
			$get_evaluation = $this->Evaluationadmin->get_evaluation_close($config["per_page"], $page,$data['userrole'],$get_evaluation_close_all_arr1);
		}
		
		$evaluations = array();
		foreach ($get_evaluation as $evaluation_value) {
			$evaluation = array();
			$UserID = $evaluation_value['UserID'];
			$evaluation['EvaluationID'] = $evaluation_value['EvaluationID'];
			$evaluation['Internalsamplecode'] = $evaluation_value['Internalsamplecode'];
			$evaluation['Dateofvisit'] = $evaluation_value['Dateofvisit'];
			$evaluation['is_deleted'] = $evaluation_value['is_deleted'];
			$evaluation['Varity'] = '';
			$evaluation['Crop'] = '';
			$evaluation['Location'] = '';
			$evaluation['Receiver'] = '';
			$evaluation['Fullname']= '';
			$evaluation['AddedDate']= $evaluation_value['AddedDate'];
			@$evaluation['evaluation_AddedDate'] = $evaluation_value['evaluation_AddedDate'];

			$get_users = $this->Evaluationadmin->get_users($UserID);
			if($get_users){
				$evaluation['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];
			}

			$get_sampling = $this->Evaluationadmin->get_sampling($evaluation_value['Internalsamplecode']);
			
			if($get_sampling){
				$get_crop = $this->Evaluationadmin->get_crop($get_sampling['Crop']);
				if($get_crop){
					$evaluation['Crop'] = $get_crop['Title'];
				}
				$evaluation['Location'] = $get_sampling['Location'];
				$evaluation['Dateofsowing'] = $get_sampling['Dateofsowing'];
				$evaluation['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
				$evaluation['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];

				$get_receiver = $this->Evaluationadmin->get_receiver($get_sampling['Receiver']);
				if($get_receiver){
					$evaluation['Receiver'] = $get_receiver['Name'];
				}
				$evaluation['VarietyID'] = $get_sampling['Seed'];
				
				

				$get_seed = $this->Evaluationadmin->get_seed($get_sampling['Seed']);
				if($get_seed){
					$evaluation['Varity'] = $get_seed['Variety'];
				}
				$get_supplier = $this->Evaluationadmin->get_supplier($get_seed['Supplier']);
				if($get_seed){
					$evaluation['SupplierName'] = $get_supplier['Name'];
				}

			}

			$evaluations[] = $evaluation;
		}

		$get_crops = $this->Evaluationadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Evaluationadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

		$get_seeds = $this->Evaluationadmin->get_seeds();
	    $seeds = array();
	    foreach($get_seeds as $get_seed){
	        $seeds[$get_seed['SeedID']]= $get_seed['Variety'];
	    }
	    asort($seeds);
	    
	    $get_techncialteams = $this->Evaluationadmin->get_techncialteams();
	    $techncialteams = array();
	    foreach($get_techncialteams as $get_techncialteam){
	        $techncialteams[$get_techncialteam['TechncialteamID']]= $get_techncialteam['Name'];
	    }
	    //asort($techncialteams);

		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;
		$data["seeds"] = $seeds;
		$data["techncialteams"] = $techncialteams;

		$get_sampling_all = $this->Evaluationadmin->get_sampling_all_location();
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

        $data['heading_title']='Evaluation close';
		$data['active']='evaluation';
		$data['submenuactive']='evaluationclose';

		$data["evaluation"] = $evaluations;
        $data["links"] = $this->pagination->create_links();
		$this->load->view('evaluationclose',$data);
	}

	public function evaluationlocation(){

		$EvaluationID = @$_GET['EvaluationID'];
		
		$validateLogin = $this->validateLogin('evaluation','list');

		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$error = array();
		$error['Internalcode'] = '';
		$error['Date'] = '';
		$error['Description'] = '';
		$error['Pictures'] = '';
	

		$get_single_evaluation =array();
		$get_single_evaluation['Internalcode'] = '';
		$get_single_evaluation['Date'] = '';
		$get_single_evaluation['Description'] = '';
		$get_single_evaluation['Pictures'] = '';
		$get_single_evaluation['AddedDate'] = '';

		$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);
		
		$get_single_evaluation['added_location'];
		$get_single_evaluation['latitude'];
		$get_single_evaluation['longitude'];
		
		$data['heading_title']='View Evaluation Location';
		$data['error']=$error;
		$data['active']='evaluation';
		$data['submenuactive']='evaluation';
		$data['get_single_evaluation']= $get_single_evaluation;
		$this->load->view('evaluationlocation',$data);
	}

	public function viewcloseevaluation(){
		$validateLogin = $this->validateLogin('evaluation','list');
		$get_user_detail=$this->Evaluationadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		if($userrole=='6'){
			redirect('admin/evaluationedit');
			exit();
		} 
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		// echo "<pre>";
		// print_r($data['userrole']);
		// echo "</pre>";
		$Crop = $this->input->get('Crop');
		$Supplier = $this->input->get('Supplier');
		$Variety = $this->input->get('Variety');
		$Location = $this->input->get('Location');
		$Techncialteam  = $this->input->get('Techncialteam');
		$FromDate  = $this->input->get('FromDate');
		$ToDate  = $this->input->get('ToDate');
		$Internalsamplingcode  = $this->input->get('Internalsamplingcode');

		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$total_rows = $this->Evaluationadmin->filter_get_viewevaluation_close_count($data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
   		}else{
   			$total_rows = $this->Evaluationadmin->get_viewevaluation_close_count($data['userrole']);
   		}


		$config = array();
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['base_url'] =base_url('admin/viewcloseevaluation');
		$config['use_page_numbers'] = false;
		$config['first_url'] = $config['base_url'].'?'.http_build_query($_GET);
		$config['total_rows'] = $total_rows;
		$config['per_page'] = 20;
		$config['uri_segment'] = 3;
		$config['num_links'] = 4;
		$config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        if($this->uri->segment(3) > 0){
		    $start = $this->uri->segment(3)+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) + $config['per_page'];
		}else{
		    $start= (int)$this->uri->segment(3) * $config['per_page']+1;
		    $end = ($this->uri->segment(3) == floor($config['total_rows']/ $config['per_page']))? $config['total_rows'] : (int)$this->uri->segment(3) * $config['per_page'] + $config['per_page'];
		}
		$data['result_count']= "Showing ".$start." - ".$end." of ".$config['total_rows']." Results";

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		if ($Crop || $Supplier || $Variety || $Location || $Techncialteam || $FromDate || $ToDate || $Internalsamplingcode){
   			$get_evaluation = $this->Evaluationadmin->filter_get_viewevaluation_close($config["per_page"], $page,$data['userrole'],$Crop,$Supplier,$Variety,$Location,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
   		}else{
			$get_evaluation = $this->Evaluationadmin->get_viewevaluation_close($config["per_page"], $page,$data['userrole']);
		}
		
		$evaluations = array();
		foreach ($get_evaluation as $evaluation_value) {
			$evaluation = array();
			$UserID = $evaluation_value['UserID'];
			$evaluation['EvaluationID'] = $evaluation_value['EvaluationID'];
			$evaluation['Internalsamplecode'] = $evaluation_value['Internalsamplecode'];
			$evaluation['Dateofvisit'] = $evaluation_value['Dateofvisit'];
			$evaluation['is_deleted'] = $evaluation_value['is_deleted'];
			$evaluation['Varity'] = '';
			$evaluation['Crop'] = '';
			$evaluation['Location'] = '';
			$evaluation['Receiver'] = '';
			$evaluation['Fullname']= '';
			$evaluation['AddedDate']= $evaluation_value['AddedDate'];
			@$evaluation['evaluation_AddedDate'] = $evaluation_value['evaluation_AddedDate'];

			$get_users = $this->Evaluationadmin->get_users($UserID);
			if($get_users){
				$evaluation['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];
			}

			$get_sampling = $this->Evaluationadmin->get_sampling($evaluation_value['Internalsamplecode']);
			// echo "<pre>";
			// print_r($get_sampling);
			// echo "</pre>";
			if($get_sampling){
				$get_crop = $this->Evaluationadmin->get_crop($get_sampling['Crop']);
				if($get_crop){
					$evaluation['Crop'] = $get_crop['Title'];
				}
				$evaluation['Location'] = $get_sampling['Location'];
				$evaluation['Dateofsowing'] = $get_sampling['Dateofsowing'];
				$evaluation['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
				$evaluation['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];

				$get_receiver = $this->Evaluationadmin->get_receiver($get_sampling['Receiver']);
				if($get_receiver){
					$evaluation['Receiver'] = $get_receiver['Name'];
				}

				

				$get_seed = $this->Evaluationadmin->get_seed($get_sampling['Seed']);
				if($get_seed){
					$evaluation['Varity'] = $get_seed['Variety'];
				}
				$get_supplier = $this->Evaluationadmin->get_supplier($get_seed['Supplier']);
				if($get_seed){
					$evaluation['SupplierName'] = $get_supplier['Name'];
				}

			}

			$evaluations[] = $evaluation;
		}

		$get_crops = $this->Evaluationadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Evaluationadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

		$get_seeds = $this->Evaluationadmin->get_seeds();
	    $seeds = array();
	    foreach($get_seeds as $get_seed){
	        $seeds[$get_seed['SeedID']]= $get_seed['Variety'];
	    }
	    asort($seeds);
	    
	    $get_techncialteams = $this->Evaluationadmin->get_techncialteams();
	    $techncialteams = array();
	    foreach($get_techncialteams as $get_techncialteam){
	        $techncialteams[$get_techncialteam['TechncialteamID']]= $get_techncialteam['Name'];
	    }
	    //asort($techncialteams);

		$data["crops"] = $crops;
		$data["suppliers"] = $suppliers;
		$data["seeds"] = $seeds;
		$data["techncialteams"] = $techncialteams;

		$get_sampling_all = $this->Evaluationadmin->get_sampling_all_location();
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

        $data['heading_title']='View Evaluation close';
		$data['active']='evaluation';
		$data['submenuactive']='evaluationclose';

		$data["evaluation"] = $evaluations;
        $data["links"] = $this->pagination->create_links();
		$this->load->view('viewcloseevaluation',$data);
	}

	public function evaluationreport(){
		$validateLogin = $this->validateLogin('evaluation','evaluationedit');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];


		$Crops = array();
		$Crops['Broccoli']='broccoli';
		$Crops['Brussels']='brussels';
		$Crops['Sunflower']='sunflower';
		$Crops['Turnip']='turnip';
		$Crops['Bunching onion']='bunchingonion';
		$Crops['leaf vegetable']='leafvegetable';
		$Crops['Rootstock']='rootstock';
		$Crops['Pumpkin']='pumpkin';
		$Crops['Soybean']='soybean';
		$Crops['Spinach']='spinach';
		$Crops['Celery']='celery';
		$Crops['Corn']='corn';
		$Crops['Cabbage']='cabbage';
		$Crops['Carrot']='carrot';
		$Crops['Cauliflower']='cauliflower';
		$Crops['Cucumber']='cucumber';
		$Crops['Cucumber- Indoor']='cucumber';
		$Crops['Cucumber- Outdoor']='cucumber';
		$Crops['Tomato- Det.']='dettomato';
		$Crops['Tomato- Indet.']='indettomato';
		$Crops['Eggplant']='eggplant';
		$Crops['Lettuce']='lettuce';
		$Crops['Melon']='melon';
		$Crops['Onion']='onion';
		$Crops['Pepper']='pepper';
		$Crops['Squash']='squash';
		$Crops['Sweet Corn']='sweetcorn';
		$Crops['Watermelon']='watermelon';
		$Crops['Beans']='beans';
		$Crops['Beetroot']='beetroot';
		$Crops['Kohlrabi']='kohlrabi';
		$Crops['Pea']='pea';
		$Crops['Radish']='radish';
		$Crops['Chinese cabbage']='chinesecabbage';
		$Crops['Okra']='okra';

		$EvaluationID = @$_GET['EvaluationID'];		
		$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);

		
		$AddDate = $get_single_evaluation['AddedDate'];
		$Internalsamplecode = $get_single_evaluation['Internalsamplecode']; 
		$get_sampling_count = $this->Evaluationadmin->get_sampling_count($Internalsamplecode);
		$get_crop = $this->Evaluationadmin->get_crop($get_sampling_count[0]['Crop']);
		$getcropTitle = $get_crop['Title'];
		
		$cropview = '';
		if (array_key_exists($getcropTitle,$Crops)){
			$cropview = $Crops[$getcropTitle];
		}else{
			$cropview = 'common';
		}
		
		$evaluationreportcontent = $this->evaluationreportcontent($cropview,$get_single_evaluation,'1');		
		$editor1 = $evaluationreportcontent;

		$Pictures_1 = array();
		if(!empty($get_single_evaluation['Pictures'])){
           $getPictures = json_decode($get_single_evaluation['Pictures']);
           		
           foreach ($getPictures as  $value) {
           		$Picture = array();
            	$Picture['url'] = base_url().'uploads/Evaluation/'.$value->name;
            	if($value->type=='2'){
            		$Picture_name_pathinfo =  pathinfo($value->name);
            		$Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
					$Picture['thumbnail'] = base_url().'uploads/Evaluation/thumbnail/'.$Picture_name;
				}else{
					$Picture['thumbnail'] = base_url().'uploads/Evaluation/thumbnail/'.$value->name;
				}
           		$Picture['AddedDate'] = $get_single_evaluation['AddedDate'];
            	$Pictures_1[] = $Picture;
            } 
  

		}

		$get_trial = $this->Evaluationadmin->get_trial($Internalsamplecode);
		foreach ($get_trial as $value) {
			if(!empty($value['Pictures'])){
			$jason = json_decode($value['Pictures'],true);
				foreach ($jason as $value1) {
					$Picture = array();
					$Picture['url'] = base_url().'uploads/Trial/'.$value1['name'];
					if($value1['type']=='2'){
						$Picture_name_pathinfo =  pathinfo($value1['name']);
	            		$Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
						$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$Picture_name;
					}else{
						$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$value1['name'];
					}
					$Pictures_1[] = $Picture;
				}
			}
		}


		$editor2 = '';
		$Pictures_2 = array();
		$Internalsamplecodecontrolvariety = $get_single_evaluation['Internalsamplecodecontrolvariety'];
		if($Internalsamplecodecontrolvariety!=''){

			$get_sampling_count_1 = $this->Evaluationadmin->get_sampling_count($Internalsamplecode);
			$get_crop_1 = $this->Evaluationadmin->get_crop($get_sampling_count_1[0]['Crop']);
			$getcropTitle_1 = $get_crop_1['Title'];
			
			$cropview_1 = '';
			if (array_key_exists($getcropTitle_1,$Crops)){
				$cropview_1 = $Crops[$getcropTitle_1];
			}else{
				$cropview_1 = 'common';
			}
			$get_single_evaluation_1 = $this->Evaluationadmin->get_single_evaluation_by_internalsamplecode($Internalsamplecodecontrolvariety);
			if($get_single_evaluation_1){
				$evaluationreportcontent_1 = $this->evaluationreportcontent($cropview_1,$get_single_evaluation_1,'2');		
				$editor2 = $evaluationreportcontent_1;

				if(!empty($get_single_evaluation_1['Pictures'])){
           			
           			$getPictures = json_decode($get_single_evaluation_1['Pictures']);

		           foreach ($getPictures as  $value) {
		           		$Picture = array();
		            	$Picture['url'] = base_url().'uploads/Evaluation/'.$value->name;
		            	if($value->type=='2'){
							$Picture_name_pathinfo =  pathinfo($value->name);
							$Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
							$Picture['thumbnail'] = base_url().'uploads/Evaluation/thumbnail/'.$Picture_name;
						}else{
							$Picture['thumbnail'] = base_url().'uploads/Evaluation/thumbnail/'.$value->name;
						}
		            	$Pictures_2[] = $Picture;
		           } 
				}
			}

			$get_trial = $this->Evaluationadmin->get_trial($Internalsamplecodecontrolvariety);
			foreach ($get_trial as $value) {
				if(!empty($value['Pictures'])){
				$jason = json_decode($value['Pictures'],true);
					foreach ($jason as $value1) {
						$Picture = array();
						$Picture['url'] = base_url().'uploads/Trial/'.$value1['name'];
						if($value1['type']=='2'){
							$Picture_name_pathinfo =  pathinfo($value1['name']);
							$Picture_name = $Picture_name_pathinfo['filename'].'.jpg';
							$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$Picture_name;
						}else{
							$Picture['thumbnail'] = base_url().'uploads/Trial/thumbnail/'.$value1['name'];
						}
						$Pictures_2[] = $Picture;
					}
				}
			}

		}	


		$data['heading_title']='Generate Report';

		$data['active']='evaluation';
		$data['submenuactive']='';
		$data['AddDate'] = $AddDate;
		$data['Pictures_1']= $Pictures_1;
		$data['Pictures_2']= $Pictures_2;
		$data['editor1']= $editor1;
		$data['editor2']= $editor2;
		$this->load->view('evaluationreport',$data);
	}

	public function evaluationreportcontent($cropview,$data,$editer='1'){
		$EvaluationID = @$_GET['EvaluationID'];		
		$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);
		
		if($editer=='2' AND $get_single_evaluation['Internalsamplecodecontrolvariety']){
			$get_sampling = $this->Evaluationadmin->get_sampling($get_single_evaluation['Internalsamplecodecontrolvariety']);
		}else{
			$get_sampling = $this->Evaluationadmin->get_sampling($get_single_evaluation['Internalsamplecode']);
		}
		
		$get_users = $this->Evaluationadmin->get_users($get_single_evaluation['UserID']);
		$data['Fullname'] = $get_users['firstname'].' '.$get_users['lastname'];
		$userrole = $get_users['userrole'];

		
		$get_date = $get_single_evaluation['AddedDate'];
		if($get_date){
			$data['AddedDate'] = $get_date;
		}
		$get_seed = $this->Evaluationadmin->get_seed($get_sampling['Seed']);
		if($get_seed){
			$data['Varity'] = $get_seed['Variety'];
		}
		$get_crop = $this->Evaluationadmin->get_crop($get_sampling['Crop']);
		if($get_crop){
			$data['Crop'] = $get_crop['Title'];
		}
		$get_Control = $this->Evaluationadmin->get_seed($get_sampling['Controlvariety']);
		if($get_Control){
			$data['Controlvariety'] = $get_Control['Variety'];
		}
		$get_supplier = $this->Evaluationadmin->get_supplier($get_seed['Supplier']);
		if($get_seed){
			$data['Supplier'] = $get_supplier['Name'];
		}

		$get_supplier = $this->Evaluationadmin->get_supplier($get_Control['Supplier']);
		if($get_seed){
			$data['Supplier_controlvariety'] = $get_supplier['Name'];
		}
		
		$data['Location'] = $get_sampling['Location'];
		$data['Dateofsowing'] = $get_sampling['Dateofsowing'];
		$data['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
		$data['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
	
	      if($data['Dateofsowing'] != ''){
	        $newAddDate = $data['Dateofsowing'];
	        $NewDateofsowing = date("d-F-Y",strtotime($newAddDate));
	        }else{
	       $NewDateofsowing = '';
	      }

        if($data['Dateoftransplanted'] != ''){
	        $newAddDate = $data['Dateoftransplanted'];
	        $NewDateoftransplanted = date("d-F-Y",strtotime($newAddDate));
	        }else{
	        $NewDateoftransplanted = '';
	      }

        if($data['Estimatedharvestingdate'] != ''){
	        $newAddDate = $data['Estimatedharvestingdate'];
	        $NewEstimatedharvestingdate = date("d-F-Y",strtotime($newAddDate));
	        }else{
	        $NewEstimatedharvestingdate = '';
	      }

		$Internalsamplecodecontrolvariety = $get_single_evaluation['Internalsamplecodecontrolvariety'];
		
		if($data['Dateofvisit'] != ''){
           $date = $data['Dateofvisit'];
           $exdate = explode("/",$date); 
           $newDate       =   $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
           $newDate1   =   date("d-F-Y", strtotime($newDate));
        }else{
           $newDate1 = '';
        }


        if($data['ByWhen'] != ''){
           $date = $data['ByWhen'];
           $exdate = explode("/",$date); 
           $newDate       =   $exdate[2].'-'.$exdate[1].'-'.$exdate[0];
           $newByWhen   =   date("d-F-Y", strtotime($newDate));
        }else{
           $newByWhen = '';
        }


		$editor = '';
		if($cropview=='broccoli'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Broccoli : </b>'.$newDate1.'</p>';
			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity : </b>'.$data['Maturity'].'</p>';
			
			$editor .= '<p><b>Plant frame size : </b>'.$data['Plantframesize'].'</p>';
            $editor .= '<p><b>Stem thickness : </b>'.$data['Stemthickness'].'</p>';
            $editor .= '<p><b>Head  weight (gr) : </b>'.$data['Headweight'].'</p>';
            $editor .= '<p><b>Curd color : </b>'.$data['Curdcolor'].'</p>';
            $editor .= '<p><b>Head  shape : </b>'.$data['Headshape'].'</p>';
            $editor .= '<p><b>Bead size : </b>'.$data['Beadsize'].'</p>';
            $editor .= '<p><b>Head Uniformity  : </b>'.$data['Headuniformity'].'</p>';
            $editor .= '<p><b>Firmness : </b>'.$data['Firmness_broccoli'].'</p>';
            $editor .= '<p><b>Side shoots : </b>'.$data['Sideshoots'].'</p>';
            $editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
            $editor .= '<p><b>Heat resit./tol. : </b>'.$data['Heatresittol'].'</p>';
            $editor .= '<p><b>Cold resist./tol. : </b>'.$data['Coldresisttol'].'</p>';

			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='brussels'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Brussels : </b>'.$newDate1.'</p>';
			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='sunflower'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Sunflower : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='turnip'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Turnip : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='bunchingonion'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Bunchingonion : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
		
				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='celery'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Celery : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}	
		}elseif($cropview=='corn'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Corn : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				
				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}	
		}elseif($cropview=='soybean'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Soybean : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='spinach'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Spinach : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				
				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}	
			}
		}elseif($cropview=='cabbage'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Cabbage : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity : </b>'.$data['Maturity'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Head color : </b>'.$data['Headcolor'].'</p>';
			$editor .= '<p><b>Head shape : </b>'.$data['Headshape'].'</p>';
			$editor .= '<p><b>Head weight (Kg) : </b>'.$data['Headweight'].'</p>';
			$editor .= '<p><b>Head length (cm) : </b>'.$data['Headlength'].'</p>';
			$editor .= '<p><b>Head diameter (cm) : </b>'.$data['Headdiameter'].'</p>';
			$editor .= '<p><b>Head uniformity : </b>'.$data['Headuniformity'].'</p>';
			$editor .= '<p><b>Leaf waxiness : </b>'.$data['Leafwaxiness'].'</p>';
			$editor .= '<p><b>anthocyanin coloration of cover leaf : </b>'.$data['anthocyanincolorationofcoverleaf'].'</p>';
			$editor .= '<p><b>Core size : </b>'.$data['Coresize'].'</p>';
			$editor .= '<p><b>Head density : </b>'.$data['Headdensity'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Heat resit./tol. : </b>'.$data['Heatresittol'].'</p>';
			$editor .= '<p><b>Cold resist./tol. : </b>'.$data['Coldresisttol'].'</p>';
			$editor .= '<p><b>Yiled : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
	        $editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='carrot'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Carrot: </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity : </b>'.$data['Maturity'].'</p>';
			$editor .= '<p><b>PLANT:Top growth height : </b>'.$data['Growthheight'].'</p>';
			$editor .= '<p><b>Diameter at Midpoint(mm) : </b>'.$data['DiameteratMidpoint'].'</p>';
			$editor .= '<p><b>length (cm) : </b>'.$data['Carrotlength'].'</p>';
			$editor .= '<p><b>weight (gr) Measure at least 10 fruits which represent majority of fruits : </b>'.$data['Carrotweight'].'</p>';
			$editor .= '<p><b>Root: shape : </b>'.$data['Rootshape'].'</p>';
			$editor .= '<p><b>Root: Smoothness : </b>'.$data['RootSmoothness'].'</p>';
			$editor .= '<p><b>Shoulder shaped : </b>'.$data['Shouldershape'].'</p>';
			$editor .= '<p><b>Root: uniformity : </b>'.$data['Rootuniformity'].'</p>';
			$editor .= '<p><b>Root: External color : </b>'.$data['RootExternalcolor'].'</p>';
			$editor .= '<p><b>Root: Core size : </b>'.$data['Coresize'].'</p>';
			$editor .= '<p><b>Shoulders (purpling/green) : </b>'.$data['Shoulderspurplinggreen'].'</p>';
			$editor .= '<p><b>Splitting & Breakage tolerance : </b>'.$data['SplittingBreakagetolerance'].'</p>';
			$editor .= '<p><b>Bolting resistance : </b>'.$data['Boltingresistance'].'</p>';
			$editor .= '<p><b>Alternaria/PM Infection : </b>'.$data['Alternariapminfection'].'</p>';
			$editor .= '<p><b> Cracking root : </b>'.$data['Crackingroot'].'</p>';
			$editor .= '<p><b>Yiled : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='cauliflower'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }

			$editor .= '<p><b>Visit of Cauliflower : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity (vs control) : </b>'.$data['Maturityvscontrol'].'</p>';
			$editor .= '<p><b>Plant height : </b>'.$data['Plantheight'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Curd weight (gr) </b>'.$data['Curdweight'].'</p>';
			$editor .= '<p><b>Curd colour : </b>'.$data['Curdcolor'].'</p>';
			$editor .= '<p><b>Curd cover : </b>'.$data['Curdcover'].'</p>';
			$editor .= '<p><b>Curd Uniformity : </b>'.$data['CurdUniformity'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>Field hold ability : </b>'.$data['Fieldholdability'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>curd: anthocyanin coloration after harvest maturity : </b>'.$data['Curdanthocyanin'].'</p>';
			$editor .= '<p><b>Heat resit./tol. : </b>'.$data['Heatresittol'].'</p>';
			$editor .= '<p><b>Cold resist./tol. : </b>'.$data['Coldresisttol'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='cucumber'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Cucumber : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>PLANT: structure : </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>PLANT: side shoot behaviour : </b>'.$data['Plantsideshootbehaviour'].'</p>';
			$editor .= '<p><b>PLANT: frts/node : </b>'.$data['Plantfrtsnode'].'</p>';
			$editor .= '<p><b>Powdery Mildew (Sf) : </b>'.$data['PowderyMildewSf'].'</p>';
			$editor .= '<p><b>Skin : </b>'.$data['SkinCucumber'].'</p>';
			$editor .= '<p><b>Downy Mildew (Pcu) : </b>'.$data['DownyMildewPcu'].'</p>';
			$editor .= '<p><b>FRUIT: length (cm) </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>FRUIT: colour : </b>'.$data['Fruitcolour_cucumber'].'</p>';
			$editor .= '<p><b>FRUIT: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>YIELD: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>YIELD: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}	
		}elseif($cropview=='dettomato'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of tomato-det : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
			$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
			$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
			$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
			$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
			$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
			

			// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
			$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Plant: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant: Cover : </b>'.$data['PlantCover'].'</p>';
			$editor .= '<p><b>Fruit: Maturity : </b>'.$data['Maturity'].'</p>';
			//$editor .= '<p><b>Internodes Length : </b>'.$data['InternodesLength'].'</p>';
			//$editor .= '<p><b>Leaf Curling / Rolling: </b>'.$data['LeafCurlingRolling'].'</p>';
			//$editor .= '<p><b>Parthenocarpic Fruits (Ball fruits without seeds) : </b>'.$data['ParthenocarpicFruits'].'</p>';
			// $editor .= '<p><b>Plant Balance : </b>'.$data['PlantBalance'].'</p>';
			$editor .= '<p><b>Fruit setting : </b>'.$data['Fruitsetting'].'</p>';
			//$editor .= '<p><b>Plant: growth  height : </b>'.$data['Growthheight'].'</p>';
			$editor .= '<p><b>Fruit: shape : </b>'.$data['Fruitshape'].'</p>';
			$editor .= '<p><b>Fruit: size uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Fruit: weight (gr) : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Fruit: Ribbness : </b>'.$data['FruitRibbness'].'</p>';
			$editor .= '<p><b>Fruit: Calyx Apperarance : </b>'.$data['CalyxApperarance'].'</p>';
			//$editor .= '<p><b>Fruit: intensity of colour before maturity : </b>'.$data['Fruitcolourbeforematurity'].'</p>';
			//$editor .= '<p><b>Fruit: colour at maturity : </b>'.$data['Fruitcolouratmaturity'].'</p>';

			//$editor .= '<p><b>Fruit: intensity of colour at maturity : </b>'.$data['Fruitintensityofcolouratmaturity'].'</p>';
			$editor .= '<p><b>Fruit:  Green Shoulders : </b>'.$data['FruitGreenShoulders'].'</p>';
			$editor .= '<p><b>Fruit:  Cracking (all sorts) : </b>'.$data['Fruitcracking'].'</p>';
			// $editor .= '<p><b>Fruit: Glossiness : </b>'.$data['Fruitglossiness'].'</p>';
			$editor .= '<p><b>Fruit: Firmness at final colour : </b>'.$data['FruitFirmnessatfinalcolour'].'</p>';
			//$editor .= '<p><b>Fruit: diameter (mm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit:  Brix % : </b>'.$data['Brix'].'</p>';
			$editor .= '<p><b>Fruit:  taste : </b>'.$data['Fruittaste'].'</p>';
			$editor .= '<p><b>Pests & Disease (Remark which): </b>'.$data['Diseasespest'].'</p>';
			$editor .= '<p><b>Fruit setting under low temp. : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temp. : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Shelf life  : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>Yiled: marketable frts/plant (nomber)   : </b>'.$data['Yieldmarketablefrtsplnt'].'</p>';
			$editor .= '<p><b>Yiled: marketable frts/plant (weight; gr) : </b>'.$data['Yieldmarketablefrtsweight'].'</p>';
			$editor .= '<p><b>Yiled: continuity of yield : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yiled : </b>'.$data['Yield'].'</p>';
			// $editor .= '<p><b>Plants per m2 : </b>'.$data['Plantsperm2'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='indettomato'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Indettomato : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
			$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
			$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
			$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
			$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
			$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
			

			// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
			$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>Plant: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Fruit: Maturity : </b>'.$data['Maturity'].'</p>';
			$editor .= '<p><b>Internodes Length : </b>'.$data['InternodesLength'].'</p>';
			$editor .= '<p><b>Leaf Curling / Rolling: </b>'.$data['LeafCurlingRolling'].'</p>';
			$editor .= '<p><b>Parthenocarpic Fruits (Ball fruits without seeds) : </b>'.$data['ParthenocarpicFruits'].'</p>';
			$editor .= '<p><b>Plant Balance : </b>'.$data['PlantBalance'].'</p>';
			$editor .= '<p><b>Fruit setting : </b>'.$data['Fruitsetting'].'</p>';
			$editor .= '<p><b>Fruit: shape : </b>'.$data['Fruitshape'].'</p>';
			$editor .= '<p><b>Fruit: uniformity in maturity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Fruit: weight (gr) : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Fruit: Ribbness : </b>'.$data['FruitRibbness'].'</p>';
			$editor .= '<p><b>Fruit:  Calyx Apperarance : </b>'.$data['CalyxApperarance'].'</p>';
			$editor .= '<p><b>Fruit:  intensity of  colour before maturity : </b>'.$data['Fruitcolourbeforematurity'].'</p>';
			$editor .= '<p><b>Fruit: colour at maturity : </b>'.$data['Fruitcolouratmaturity'].'</p>';

			$editor .= '<p><b>Fruit:  intensity of colour at maturity : </b>'.$data['Fruitintensityofcolouratmaturity'].'</p>';
			$editor .= '<p><b>Fruit:  Green Shoulders : </b>'.$data['FruitGreenShoulders'].'</p>';
			$editor .= '<p><b>Fruit:  Cracking (all sorts) : </b>'.$data['Fruitcracking'].'</p>';
			$editor .= '<p><b>Fruit: Firmness at final colour : </b>'.$data['FruitFirmnessatfinalcolour'].'</p>';
			$editor .= '<p><b>Pests & Disease (Remark which): </b>'.$data['Diseasespest'].'</p>';
			$editor .= '<p><b>Fruit setting under low temp. : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temp. : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Shelf life  : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>Yiled: continuity of yield : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yiled : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='eggplant'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Eggplant : </b>'.$newDate1.'</p>';
			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier'].'</p>';
			}
			$editor .= '<p><b>Plant Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity : </b>'.$data['Maturity'].'</p>';
			$editor .= '<p><b>Plant:  growth height : </b>'.$data['Growthheight'].'</p>';
			$editor .= '<p><b>Plant: Internode length : </b>'.$data['InternodesLength'].'</p>';
			$editor .= '<p><b>Fruit : shape : </b>'.$data['Fruitshape'].'</p>';
			$editor .= '<p><b>Fruit: size uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Fruit: shape uniformity </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Diameter at Midpoint(cm) : </b>'.$data['DiameteratMidpoint'].'</p>';
			$editor .= '<p><b>length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>weight (gr) Measure at least 10 fruits which represent majority of fruits : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Fruit: colour at maturity : </b>'.$data['Fruitcolouratmaturity'].'</p>';
			$editor .= '<p><b>Fruit:glossiness : </b>'.$data['Fruitglossiness'].'</p>';
			$editor .= '<p><b>Fruit: Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>Fruit: Taste : </b>'.$data['Fruittaste'].'</p>';
			$editor .= '<p><b>Fruit setting : </b>'.$data['Fruitsetting'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>YIELD: continuity of yield : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yiled : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='lettuce'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Lettuce: </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Variety type : </b>'.$data['Varietytype'].'</p>';
			$editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity  vs control : </b>'.$data['Maturityvscontrol'].'</p>';
			$editor .= '<p><b>Head formation : </b>'.$data['Headformation'].'</p>';
			$editor .= '<p><b>Leaf colour : </b>'.$data['Leafcolour'].'</p>';
			$editor .= '<p><b>Head size : </b>'.$data['Headsize'].'</p>';
			$editor .= '<p><b>Head: density : </b>'.$data['Headdensity'].'</p>';
			$editor .= '<p><b>Head: Uniformity </b>'.$data['Headuniformity'].'</p>';
			$editor .= '<p><b>weight(gr) : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>Leaf texture : </b>'.$data['Leaftexture'].'</p>';
			$editor .= '<p><b>Taste : </b>'.$data['Fruittaste'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Heat / Cold resist./tol. : </b>'.$data['HeatColdresisttol'].'</p>';
			$editor .= '<p><b>Bolting resist./tol. : </b>'.$data['Boltingresistance'].'</p>';
			$editor .= '<p><b>Yield (Visual)  : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='leafvegetable'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Leafvegetable : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}	
		}elseif($cropview=='pumpkin'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Pumpkin : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='melon'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Melon: </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Powdery Mildew (Sf) : </b>'.$data['PowderyMildewSf'].'</p>';
			$editor .= '<p><b>Downy Mildew (Pcu) : </b>'.$data['DownyMildewPcu'].'</p>';
			$editor .= '<p><b>Marketable Fruits per plant : </b>'.$data['Fruitsperplant'].'</p>';
			$editor .= '<p><b>Maturity (vs control) : </b>'.$data['Maturityvscontrol'].'</p>';
			$editor .= '<p><b>Fruit shape : </b>'.$data['Fruitshape'].'</p>';
			$editor .= '<p><b>FRUIT: netting : </b>'.$data['Fruitnetting'].'</p>';
			$editor .= '<p><b>FRUIT: ribbing </b>'.$data['Fruitribbing'].'</p>';
			$editor .= '<p><b>FRUIT: size uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>FRUIT: shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>FRUIT: fruit weight (kg) : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Seed cavity : </b>'.$data['Seedcavity'].'</p>';
			$editor .= '<p><b>FRUIT: flesh color : </b>'.$data['Fleshcolor'].'</p>';
			$editor .= '<p><b>FRUIT: taste : </b>'.$data['Fruittaste'].'</p>';
			$editor .= '<p><b>Brix : </b>'.$data['Brix'].'</p>';
			$editor .= '<p><b>Flesh firmness : </b>'.$data['Fleshfirmness'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>YIELD: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}					
		}elseif($cropview=='onion'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Onion : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>Plant: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant size : </b>'.$data['Plantsize'].'</p>';
			$editor .= '<p><b>Bulb: Maturity  (vs control) : </b>'.$data['Maturityvscontrol'].'</p>';

			$editor .= '<p><b>Bulb: Shape: </b>'.$data['Bulbshape'].'</p>';
			$editor .= '<p><b>Bulb: : size uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Bulb: : shape uniformity  : </b>'.@$data['Bulbshapeuniformit'].'</p>';
			$editor .= '<p><b>Bulb: : fruit weight (gr)   : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Bulb: adherence of dry skin after harvest : </b>'.$data['Dryskinafterharvest'].'</p>';
			$editor .= '<p><b>Neck size : </b>'.$data['Necksize'].'</p>';
			$editor .= '<p><b>Bulb: thickness of dry skin : </b>'.$data['Thicknessofdryskin'].'</p>';
			$editor .= '<p><b>Bulb: base colour of dry skin : </b>'.$data['Basecolourdryskin'].'</p>';
			$editor .= '<p><b>Bulb: No of double center out of 10  : </b>'.$data['Noofdoublecenter'].'</p>';
			$editor .= '<p><b>Bolting resist./tol. : </b>'.$data['Boltingresistance'].'</p>';
			$editor .= '<p><b>Bulb: Storability : </b>'.$data['Storability'].'</p>';
			$editor .= '<p><b>YIELD: estimated : </b>'.$data['Yieldestimated'].'</p>';
			$editor .= '<p><b>Yield: Total marketable kg/m bed  : </b>'.$data['Yieldmarketable'].'</p>';
			$editor .= '<p><b>Yield: Non marketable kg/m bed : </b>'.$data['Yieldnonmarketable'].'</p>';
			$editor .= '<p><b>Pests & Disease (Remark which) : </b>'.$data['Diseasespest'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}	
		}elseif($cropview=='pepper'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Pepper : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';

			$editor .= '<p><b>PLANT: Maturity : </b>'.$data['Maturity'].'</p>';
			$editor .= '<p><b>Plant:  growth  height : </b>'.$data['Plantheight'].'</p>';
			$editor .= '<p><b>Plant: Cover : </b>'.$data['PlantCover'].'</p>';
			$editor .= '<p><b>Fruit : shape : </b>'.$data['Fruitshape'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Fruit: shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit:width(cm) : </b>'.$data['Friutwidth'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: weight (gr) : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Fruit: wall thickness in mm : </b>'.$data['Fruitwallthickness'].'</p>';
			$editor .= '<p><b>Fruit:  intensity of  colour before maturity : </b>'.$data['Fruitintensityofcolourbeforematurity'].'</p>';
			$editor .= '<p><b>Fruit:colour at maturity : </b>'.$data['Fruitcolouratmaturity'].'</p>';
			$editor .= '<p><b>Fruit:  intensity of colour at maturity : </b>'.$data['Fruitintensityofcolouratmaturity'].'</p>';
	
			$editor .= '<p><b>Fruit:Glossiness : </b>'.$data['Fruitglossiness'].'</p>';
			$editor .= '<p><b>Fruit: Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>YIELD: marketable frts/plnt. : </b>'.$data['Yieldmarketablefrtsplnt'].'</p>';
			$editor .= '<p><b>FRUIT: cracking (all sorts) : </b>'.$data['Fruitcracking'].'</p>';
			$editor .= '<p><b>Pests & Disease (Remark which) : </b>'.$data['Diseasespest'].'</p>';
			$editor .= '<p><b>Fruit setting under low temp. : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temp. : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>YIELD: continuity of yield : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='squash'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Squash: </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Variety type : </b>'.$data['Varietytype'].'</p>';
			$editor .= '<p><b>Plant Vigor : </b>'.$data['Plantvigur'].'</p>';

			$editor .= '<p><b>Maturity : </b>'.$data['Maturity'].'</p>';
			$editor .= '<p><b>Plant:  growth type : </b>'.$data['Growthtype'].'</p>';
			$editor .= '<p><b>Plant habit : </b>'.$data['Planthabit'].'</p>';
			$editor .= '<p><b>Silvering : </b>'.$data['Silvering'].'</p>';
			$editor .= '<p><b>Branching : </b>'.$data['Branching'].'</p>';
			$editor .= '<p><b>Fruit : shape : </b>'.$data['Fruitshape'].'</p>';
			$editor .= '<p><b>Fruit: size uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Fruit: shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>length (cm) : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>diameter(cm) : </b>'.$data['Fruitintensityofcolouratmaturity'].'</p>';
			$editor .= '<p><b>Weight (gr)- Measure at least 5 fruits : </b>'.$data['Fruitweight'].'</p>';
			$editor .= '<p><b>Fruit: colour at maturity : </b>'.$data['Fruitcolouratmaturity'].'</p>';
			$editor .= '<p><b>Yong fruit: Ratio length/maximum diameter : </b>'.$data['YongfruitRatio'].'</p>';
			$editor .= '<p><b>Stripes ripe fruit : </b>'.$data['Stripesripefruit'].'</p>';
			$editor .= '<p><b>Blossom scar : </b>'.$data['Blossomscar'].'</p>';
			$editor .= '<p><b>Fruit:glossiness : </b>'.$data['Fruitglossiness'].'</p>';
			$editor .= '<p><b>Fruit: Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>Easy Picking : </b>'.$data['Easypicking'].'</p>';
			$editor .= '<p><b>Fruit setting under low temp. : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temp. : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Post Harvest Quality: </b>'.$data['PostHarvestQuality'].'</p>';
			$editor .= '<p><b>YIELD: continuity of yield : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Early Yield : </b>'.$data['EarlyYield'].'</p>';
			$editor .= '<p><b>Total Yield : </b>'.$data['TotalYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='sweetcorn'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Sweetcorn : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>Variety type : </b>'.$data['Varietytype'].'</p>';
			$editor .= '<p><b>Plant: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Maturity  (vs control) : </b>'.$data['Maturityvscontrol'].'</p>';
			$editor .= '<p><b>Plant height (cm) : </b>'.$data['Plantheight'].'</p>';
			$editor .= '<p><b>Anthocyanin (leaf/stem) : </b>'.$data['Anthocyanin'].'</p>';
			$editor .= '<p><b>First ear height (cm) : </b>'.$data['Firstearheight'].'</p>';
			$editor .= '<p><b>Ear husk leaf color : </b>'.$data['Earhuskleafcolor'].'</p>';
			$editor .= '<p><b>Flag leaves appearance  on ear : </b>'.$data['Flagleavesappearanceonear'].'</p>';
			$editor .= '<p><b>Ear length (cm) : </b>'.$data['Earlength'].'</p>';
			$editor .= '<p><b>Ear diameter -in middle (cm) : </b>'.$data['Eardiameter'].'</p>';
			$editor .= '<p><b>Corn cob length(cm) : </b>'.$data['Corncoblength'].'</p>';
			$editor .= '<p><b>Number of ears per plan : </b>'.$data['Numberofears'].'</p>';
			$editor .= '<p><b>Ear Protection : </b>'.$data['EarProtection'].'</p>';
			$editor .= '<p><b>Average number of rows/ear : </b>'.$data['Averagenumberofrows'].'</p>';
			$editor .= '<p><b>Seed colour : </b>'.$data['Seedcolour'].'</p>';
			$editor .= '<p><b>Tip filling Tip fill is the percentage of 5 ears with full tips : </b>'.$data['Tipfilling'].'</p>';
			$editor .= '<p><b>Taste : </b>'.$data['Fruittaste'].'</p>';
			$editor .= '<p><b>Harvesting : </b>'.$data['Harvesting'].'</p>';
			$editor .= '<p><b>Kernel tenderness : </b>'.$data['Kerneltenderness'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>YIELD: estimated : </b>'.$data['Yieldestimated'].'</p>';
			$editor .= '<p><b>Pests & Disease (Remark which) : </b>'.$data['Diseasespest'].'</p>';

			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='watermelon'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Watermelon: </b>'.$newDate1.'</p>';
			$editor .= '<p><b>Supplier Name : </b>'.$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
			
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Plant: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant: Cover : </b>'.$data['PlantCover'].'</p>';
			$editor .= '<p><b>Fruit: Maturity  (vs control) : </b>'.$data['Maturityvscontrol'].'</p>';
			$editor .= '<p><b>Fruit:  Maturity Number of Days from sowing/transplanting day to the day most of the fruits are harvestable : </b>'.$data['Maturity'].'</p>';
            $editor .= '<p><b>Fruit : Rind Pattern : </b>'.$data['FruitRindPattern'].'</p>';
            $editor .= '<p><b>Rind Attractivness : </b>'.$data['RindAttractivness'].'</p>';
            $editor .= '<p><b>Fruit: Shape : </b>'.$data['Fruitshape'].'</p>';
            $editor .= '<p><b>Fruit: size uniformity  : </b>'.$data['Fruitsizeuniformity'].'</p>';
            $editor .= '<p><b>Fruit : shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
            $editor .= '<p><b>Fruit: Average fruit weight (kg)   : </b>'.$data['Fruitweight'].'</p>';
            $editor .= '<p><b>Fruit: Size (LxD cm) : </b>'.$data['FruitSize'].'</p>';
            $editor .= '<p><b>Fruit: rind thickness (mm) Meausre rind thickness of 3 -5 fruits by cm and calculate average : </b>'.$data['Fruitrindthickness'].'</p>';
            $editor .= '<p><b>Brix%:  Measure by refractometer middle section of at least   3-5 full ripen fruits and calculate the average : </b>'.$data['Brix'].'</p>';
            $editor .= '<p><b>Fruit: Flesh color : </b>'.$data['Fleshcolor'].'</p>';
            $editor .= '<p><b>Flesh Firmness : </b>'.$data['Fleshfirmness'].'</p>';
            $editor .= '<p><b>Hollow Heart Severity : </b>'.$data['HollowHeartSeverity'].'</p>';
            $editor .= '<p><b>Seeds Size : </b>'.$data['SeedsSize'].'</p>';
            $editor .= '<p><b>Seeds Content : </b>'.$data['SeedsContent'].'</p>';
            $editor .= '<p><b>Taste : </b>'.$data['Fruittaste'].'</p>';
            $editor .= '<p><b>Fruits/Plant: Calculate automatically and indicate plant setting/Yeild : </b>'.$data['Fruitsplant'].'</p>';
            $editor .= '<p><b>Number of Marketable fruits per 10 m2  : </b>'.$data['Fruitsmarketable'].'</p>';
            $editor .= '<p><b>Number of Marketable Fruits  in each plot : </b>'.$data['Fruitsmarketableplot'].'</p>';
            $editor .= '<p><b>YIELD: estimated  : </b>'.$data['Yieldestimated'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
			$editor .= '<p><b>Pests & Disease (Remark which) : </b>'.$data['Diseasespest'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
            $editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
           if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='beans'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Beans: </b>'.$newDate1.'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
				$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>Variety type: </b>'.$data['Varietytype'].'</p>';
			$editor .= '<p><b>Market segment : </b>'.$data['Marketsegment'].'</p>';
			$editor .= '<p><b>Type of cultivation : </b>'.$data['Typeofcultivation'].'</p>';
            $editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
            $editor .= '<p><b>Harvesting (maturity) vs control : </b>'.$data['Harvesting'].'</p>';
            $editor .= '<p><b>Plant growth type : </b>'.$data['Growthtype'].'</p>';
            $editor .= '<p><b>Flower colour : </b>'.$data['Flowercolour'].'</p>';
            $editor .= '<p><b>Pod cross section  : </b>'.$data['Podcrosssection'].'</p>';
            $editor .= '<p><b>Pod length (cm) : </b>'.$data['Podlength'].'</p>';
            $editor .= '<p><b>Pod diameter (mm) : </b>'.$data['Poddiameter'].'</p>';
            $editor .= '<p><b>Stringless : </b>'.$data['Stringless'].'</p>';
            $editor .= '<p><b>Primary pod colour : </b>'.$data['Primarypodcolour'].'</p>';
            $editor .= '<p><b>Seed colour : </b>'.$data['Seedcolour'].'</p>';
            $editor .= '<p><b>Cooking value : </b>'.$data['Cookingvalue'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
            $editor .= '<p><b>Yield : </b>'.$data['Yield'].'</p>';

			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			// $editor .= '<p><b>conclusion : </b>'.$data['Conclusion'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='okra'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Okra: </b>'.$newDate1.'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
				$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				

				// $editor .= '<p><b>Variety Name : </b>'.$data['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>Type of cultivation : </b>'.$data['Typeofcultivation'].'</p>';
            $editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
            $editor .= '<p><b>Harvesting (maturity) vs control : </b>'.$data['Harvesting'].'</p>';
            $editor .= '<p><b>Plant growth type : </b>'.$data['Growthtype'].'</p>';
            $editor .= '<p><b>PLANT: growth height : </b>'.$data['Growthheight'].'</p>';
            $editor .= '<p><b>Plant: Internode length : </b>'.$data['InternodesLength'].'</p>';
            $editor .= '<p><b>Pod:Fruit shape : </b>'.$data['Fruitshape'].'</p>';
            $editor .= '<p><b>Pod:Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
            $editor .= '<p><b>Pod:Fruit: colour at maturity : </b>'.$data['Fruitcolouratmaturity'].'</p>';
            $editor .= '<p><b>Skin smoothness : </b>'.$data['Skinsmoothness'].'</p>';
            $editor .= '<p><b>Fruit: size uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
            $editor .= '<p><b>Pod:Spine development  : </b>'.$data['Spinedevelopment'].'</p>';
            $editor .= '<p><b>Pod firmness : </b>'.$data['Firmness'].'</p>';
            $editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
            $editor .= '<p><b>Yield : </b>'.$data['Yield'].'</p>';

			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='beetroot'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Beetroot: </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>Market segment : </b>'.$data['Marketsegment'].'</p>';
			$editor .= '<p><b>Type of cultivation : </b>'.$data['Typeofcultivation'].'</p>';
            $editor .= '<p><b>vigor : </b>'.$data['Plantvigur'].'</p>';
            $editor .= '<p><b>Harvesting (maturity) vs control : </b>'.$data['Harvesting'].'</p>';

            $editor .= '<p><b>Leaf attachment : </b>'.$data['Leafattachment'].'</p>';
            $editor .= '<p><b>Leaf colour : </b>'.$data['Leafcolour'].'</p>';
            $editor .= '<p><b>Top length (cm) : </b>'.$data['Toplength'].'</p>';
            $editor .= '<p><b>Foliage length : </b>'.$data['Foliagelength'].'</p>';
            $editor .= '<p><b>Anthocyanin (leaf) : </b>'.$data['Anthocyanin'].'</p>';
            $editor .= '<p><b>Leaf implant : </b>'.$data['Leafimplant'].'</p>';
            $editor .= '<p><b>Foliage atittude : </b>'.$data['Foliageatittude'].'</p>';
            $editor .= '<p><b>Bolting resist./tol. : </b>'.$data['Boltingresistance'].'</p>';
            $editor .= '<p><b>Root shape : </b>'.$data['Rootshape'].'</p>';
            $editor .= '<p><b>Root external colour : </b>'.$data['RootExternalcolor'].'</p>';
            $editor .= '<p><b>Root internal colour : </b>'.$data['Rootinternalcolor'].'</p>';
            $editor .= '<p><b>Root size : </b>'.$data['Rootsize'].'</p>';
            $editor .= '<p><b>Tap root size : </b>'.$data['Taprootsize'].'</p>';
            $editor .= '<p><b>Root uniformity : </b>'.$data['Rootuniformity'].'</p>';
            $editor .= '<p><b>Skin smoothness : </b>'.$data['Skinsmoothness'].'</p>';
            $editor .= '<p><b>Zoning : </b>'.$data['Zoning'].'</p>';
            $editor .= '<p><b>Root weight (average 10 roots) : </b>'.$data['Rootweight'].'</p>';
            $editor .= '<p><b>White rings : </b>'.$data['Whiterings'].'</p>';
            $editor .= '<p><b>Sugar content : </b>'.$data['Sugarcontent'].'</p>';
            $editor .= '<p><b>Flavour : </b>'.$data['Flavour'].'</p>';

			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
            $editor .= '<p><b>Yield : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='kohlrabi'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Kohlrabi : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>Variety type : </b>'.$data['Varietytype'].'</p>';
            $editor .= '<p><b>vigor : </b>'.$data['Plantvigur'].'</p>';
            $editor .= '<p><b>Harvesting (maturity) vs control : </b>'.$data['Harvesting'].'</p>';

            $editor .= '<p><b>Plant habit: </b>'.$data['Planthabit'].'</p>';
            $editor .= '<p><b>Top length (cm) : </b>'.$data['Toplength'].'</p>';
            $editor .= '<p><b>Leaf colour : </b>'.$data['Leafcolour'].'</p>';
            $editor .= '<p><b>Bolting resist./tol. : </b>'.$data['Boltingresistance'].'</p>';
            $editor .= '<p><b>Root shape : </b>'.$data['Rootshape'].'</p>';
            $editor .= '<p><b>Root external colour : </b>'.$data['RootExternalcolor'].'</p>';
            $editor .= '<p><b>Root uniformity : </b>'.$data['Rootuniformity'].'</p>';
            $editor .= '<p><b>Skin smoothness : </b>'.$data['RootSmoothness'].'</p>';

            $editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
            $editor .= '<p><b>Heat / Cold  resit./tol. : </b>'.$data['Heatresittol'].'</p>';
            $editor .= '<p><b>Yield : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='pea'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Pea: </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].')</p>';
			}	
            $editor .= '<p><b>Vigor : </b>'.$data['Plantvigur'].'</p>';
            $editor .= '<p><b>Harvesting (maturity) vs control : </b>'.$data['Harvesting'].'</p>';
            $editor .= '<p><b>Pod shape : </b>'.$data['Podshape'].'</p>';
            $editor .= '<p><b>Pod colour : </b>'.$data['Podcolour'].'</p>';
            $editor .= '<p><b>Kernels per pod : </b>'.$data['Kernelsperpod'].'</p>';
            $editor .= '<p><b>Pods per node : </b>'.$data['Podspernode'].'</p>';
            $editor .= '<p><b>Flower colour : </b>'.$data['Flowercolour'].'</p>';
            $editor .= '<p><b>Pod firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>Shelf life : </b>'.$data['Shelflife'].'</p>';
            $editor .= '<p><b>Yield : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='radish'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Radish: </b>'.$newDate1.'</p>';
			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
            $editor .= '<p><b>Market segment : </b>'.$data['Marketsegment'].'</p>';
			$editor .= '<p><b>Type of cultivation: </b>'.$data['Typeofcultivation'].'</p>';
            $editor .= '<p><b>Plant Vigor : </b>'.$data['Plantvigur'].'</p>';
            $editor .= '<p><b>Harvesting (maturity) vs control : </b>'.$data['Harvesting'].'</p>';
            $editor .= '<p><b>Standing leaves: </b>'.$data['Standingleaves'].'</p>';
            $editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
            $editor .= '<p><b>Radish Shape: </b>'.$data['Radishshape'].'</p>';
            $editor .= '<p><b>Radish development: </b>'.$data['Radishdevelopment'].'</p>';
 			$editor .= '<p><b>Root uniformity </b>'.$data['Rootuniformity'].'</p>';
 			$editor .= '<p><b>Radish color: </b>'.$data['Radishcolour'].'</p>';
		    $editor .= '<p><b>shelf life: </b>'.$data['Shelflife'].'</p>';
		    $editor .= '<p><b>Heat/ Cold resist./tol.  : </b>'.$data['Heatresittol'].'</p>';
            $editor .= '<p><b>Yield: </b>'.$data['Yield'].'</p>';
            $editor .= '<p><b>spongeness: </b>'.$data['Spongeness'].'</p>';
            $editor .= '<p><b>Root size : </b>'.$data['Rootsize'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='rootstock'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }			
			$editor .= '<p><b>Visit of Rootstock : </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}	
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>friut quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}elseif($cropview=='chinesecabbage'){
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }
			$editor .= '<p><b>Visit of Chinesecabbage: </b>'.$newDate1.'</p>';

			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$data['Controlvariety'].'-'.@$data['Supplier_controlvariety'].'</p>';
			}
            $editor .= '<p><b>Vigor  : </b>'.$data['Plantvigur'].'</p>';
            $editor .= '<p><b>Maturity : </b>'.$data['Maturity'].'</p>';
			$editor .= '<p><b>Plant Uniformity : </b>'.$data['Uniformity'].'</p>';
            $editor .= '<p><b>Head: height : </b>'.$data['Plantheight'].'</p>';
            $editor .= '<p><b>Head: maximum width  : </b>'.$data['Friutwidth'].'</p>';

            $editor .= '<p><b>Head: shape  : </b>'.$data['Fruitshape'].'</p>';
            $editor .= '<p><b>Headtype  : </b>'.$data['Headtype'].'</p>';
			$editor .= '<p><b>Head weight (Kg) : </b>'.$data['Headweight'].'</p>';
            $editor .= '<p><b>Head:internal color : </b>'.$data['Headcolor'].'</p>';
            $editor .= '<p><b>Head:Firmness  : </b>'.$data['Firmness'].'</p>';

            $editor .= '<p><b>Head uniformity  : </b>'.$data['Headuniformity'].'</p>';
            $editor .= '<p><b>Heat/ Cold resist./tol.  : </b>'.$data['HeatColdresisttol'].'</p>';
            
            $editor .= '<p><b>Yield : </b>'.$data['Yield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
            $editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
            $editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
            if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}else{
			// $editor .= '<p><b>Internal sample code : </b>'.$data['Internalsamplecode'].'</p>';
			// if($data['Internalsamplecodecontrolvariety']!=''){
			// 	$editor .= '<p><b>Internal sample code control variety : </b>'.$data['Internalsamplecodecontrolvariety'].'</p>';
			// }		
			$editor .= '<p><b>Visit of Other : </b>'.$newDate1.'</p>';
			$editor .= '<p><b>Supplier Name : </b>'.@$data['Supplier'].'</p>';
			$editor .= '<p><b>Variety Name : </b>'.@$data['Varity'].'</p>';
			if($data['Internalsamplecodecontrolvariety']!=''){
				$editor .= '<p><b>Crop : </b>'.$data['Crop'].'</p>';
				$editor .= '<p><b>Location : </b>'.$data['Location'].'</p>';
				$editor .= '<p><b>Date of sowing : </b>'.@$NewDateofsowing.'</p>';
				$editor .= '<p><b>Date of transplanted : </b>'.@$NewDateoftransplanted.'</p>';
				$editor .= '<p><b>Estimated harvesting date : </b>'.@$NewEstimatedharvestingdate.'</p>';
				$editor .= '<p><b>Variety Name : </b>'.@$evaluation['Varity'].'</p>';
				$editor .= '<p><b>Control Variety Name : </b>'.@$evaluation['Controlvariety'].'-'.@$evaluation['Supplier_controlvariety'].'</p>';
			}
			$editor .= '<p><b>PLANT: Vigor : </b>'.$data['Plantvigur'].'</p>';
			$editor .= '<p><b>Plant uniformity : </b>'.$data['Uniformity'].'</p>';
			$editor .= '<p><b>Plant structure: </b>'.$data['Plantstructure'].'</p>';
			$editor .= '<p><b>Fruit shape uniformity : </b>'.$data['Fruitshapeuniformity'].'</p>';
			$editor .= '<p><b>Fruit size  uniformity : </b>'.$data['Fruitsizeuniformity'].'</p>';
			$editor .= '<p><b>Average wieght In gram : </b>'.$data['Averagewieght'].'</p>';
			$editor .= '<p><b>Firmness : </b>'.$data['Firmness'].'</p>';
			$editor .= '<p><b>Fruit quality : </b>'.$data['Fruitquality'].'</p>';
			$editor .= '<p><b>Fruit: length (cm) : </b>'.$data['Friutlength'].'</p>';
			$editor .= '<p><b>Fruit: Diameter (cm) : </b>'.$data['Fruitdiameter'].'</p>';
			$editor .= '<p><b>Fruit: colour : </b>'.$data['Fruitcolour'].'</p>';
			$editor .= '<p><b>Fruit: overall quality : </b>'.$data['Fruitoverallquality'].'</p>';
			$editor .= '<p><b>Disease Tolerance : </b>'.$data['DiseaseTolerance'].'</p>';
			$editor .= '<p><b>Fruit setting under low temperature : </b>'.$data['Fruitsettingunderlowtemperature'].'</p>';
			$editor .= '<p><b>Fruit setting under high temperature : </b>'.$data['Fruitsettingunderhightemperature'].'</p>';
			$editor .= '<p><b>Field standing ability : </b>'.$data['Fieldstandingability'].'</p>';
			$editor .= '<p><b>Yield: yield continuity : </b>'.$data['Yieldcontinuity'].'</p>';
			$editor .= '<p><b>Yield: visual yield : </b>'.$data['VisualYield'].'</p>';
			$editor .= '<p><b>Rating : </b>'.$data['Rating'].'</p>';
			$editor .= '<p><b>Advantages : </b>'.$data['Advantages'].'</p>';
			$editor .= '<p><b>Disadvantages : </b>'.$data['Disadvantages'].'</p>';
			$editor .= '<p><b>Remarks - Text (120 char) : </b>'.$data['Remarks'].'</p>';
			if($Internalsamplecodecontrolvariety!=''){
				if($editer=='1'){
					$editor .= '<p><b>Status : </b>'.$data['Status'].'</p>';
					if($data['Status']=='Drop'){
						$editor .= '<p><b>Drop message : </b>'.$data['Dropmessage'].'</p>';
					}
					if($data['Status']=='Re-check'){
						$editor .= '<p><b>By When : </b>'.$newByWhen.'</p>';
						$editor .= '<p><b>Number of seeds : </b>'.$data['Numberofseeds'].'</p>';
					}
				}else{
					$editor .= '<p><b>Status : </b>Commercial or control variety</p>';
				}
			}
		}	
		return $editor;
	}

	public function deleteevaluation_old(){
		$validateLogin = $this->validateLogin('evaluation');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$EvaluationID = $this->uri->segment(3);
		if($EvaluationID){
			$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);

			$this->Evaluationadmin->deleteevaluation($EvaluationID,$data['userrole']);
			$this->session->set_flashdata('success', 'Evaluation been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Evaluation been Deleted successfully EvaluationID: '.$EvaluationID;
			$datalog['Data'] = json_encode($get_single_evaluation);
			$this->Evaluationadmin->insert_log($datalog);

		}
		redirect('admin/evaluation');
		exit();
	}

	public function deleteevaluation(){
		$validateLogin = $this->validateLogin('evaluation');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$EvaluationID = $_POST['DeleteID'];
		if($EvaluationID){
			$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);

			$this->Evaluationadmin->deleteevaluation($EvaluationID,$data['userrole']);
			$this->session->set_flashdata('success', 'Evaluation been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Evaluation been Deleted successfully EvaluationID: '.$EvaluationID;
			$datalog['Data'] = json_encode($get_single_evaluation);
			$this->Evaluationadmin->insert_log($datalog);

		}

	}

	public function removeevaluation(){
		$validateLogin = $this->validateLogin('evaluation');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$EvaluationID = $_POST['CloseID'];
	
		if($EvaluationID){
			$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);
			$get_single_trial = $this->Evaluationadmin->get_single_trial($get_single_evaluation['Internalsamplecode']);
			$get_single_sampling = $this->Evaluationadmin->get_single_samplings($get_single_evaluation['Internalsamplecode']);
		
			$this->Evaluationadmin->closeevaluation($EvaluationID,$data['userrole']);
			$this->Evaluationadmin->closetrial($get_single_evaluation['Internalsamplecode'],$data['userrole']);
			$this->Evaluationadmin->closesampling($get_single_sampling['SamplingID'],$data['userrole']);
			$this->session->set_flashdata('success', 'Evaluation and Trail been close successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Evaluation been Deleted successfully EvaluationID: '.$EvaluationID;
			$datalog['Data'] = json_encode($get_single_evaluation);
			$this->Evaluationadmin->insert_log($datalog);

		}	

	}

	public function restoreevaluation(){
		$validateLogin = $this->validateLogin('evaluation');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$EvaluationID = $this->uri->segment(3);
		if($EvaluationID){
			$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);

			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Evaluationadmin->update_evaluation($datapost,$EvaluationID);
			$this->session->set_flashdata('success', 'Evaluation been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Evaluation been Restore successfully EvaluationID: '.$EvaluationID;
			$datalog['Data'] = json_encode($get_single_evaluation);
			$this->Evaluationadmin->insert_log($datalog);

		}
		redirect('admin/evaluation');
		exit();
	}

	public function checkinternalcode(){
		$Internalcode = $this->input->post('Internalcode',true);
		$get_sampling_count = $this->Evaluationadmin->get_sampling_count($Internalcode);
		$response = array();
		if(count($get_sampling_count)>0){
			$get_crop = $this->Evaluationadmin->get_crop($get_sampling_count[0]['Crop']);
			$getcropTitle = $get_crop['Title'];

			$response['cropview'] = $getcropTitle;
			$response['message'] = '';
		}else{
			$response['message'] = 'This Internal sample code not exits';
		}
		echo json_encode($response);
		die;
	}
	
	public function resizeImage($filename){
      $source_path = UPLOADROOT . 'Evaluation/' . $filename;
      $target_path = UPLOADROOT . 'Evaluation/thumbnail/';
      $config_manip = array(
          'image_library' => 'gd2',
          'source_image' => $source_path,
          'new_image' => $target_path,
          'maintain_ratio' => TRUE,
          'create_thumb' => TRUE,
          'thumb_marker' => '',
          'width' => 280,
          'height' => 280
      );

      $this->load->library('image_lib', $config_manip);
      $this->image_lib->initialize($config_manip);
      if (!$this->image_lib->resize()) {
          echo $this->image_lib->display_errors();
      }
      $this->image_lib->clear();
   	}

   	function create_videothumbnail($filename){
		$video = UPLOADROOT.'Evaluation/'.$filename;
		$pathinfo =  pathinfo($video); 
		$video_filename =  $pathinfo['filename'];  
	  	$image = UPLOADROOT.'Evaluation/thumbnail/'.$video_filename.'.jpg';

		$ffmpeg = '/usr/bin/ffmpeg';
		$second = 1;
		$thumbSize	= '280x280';
		$cmd = "$ffmpeg -i $video 2>&1";
		if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', $cmd, $time)) {
		    $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
		    $second = rand(1, ($total - 1));
		}
		$cmdreturn = "$ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -s $thumbSize -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
		exec($cmdreturn, $output, $retval);
	}

	private function validateLogin($module='',$type=''){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit();   
		}

		$get_user_detail=$this->Evaluationadmin->get_user_detail($this->session->userdata('UserID'));
		
		$userrole= $get_user_detail['userrole'];
		$user_permission= $get_user_detail['userpermission'];
		if($user_permission!=''){
			$userpermission= json_decode($user_permission);
		}else{	
			$userpermission= array();
		}

		if($userrole!='1' AND $userrole!='2' AND $userrole!='3' AND $userrole!='4' AND $userrole!='5' AND $userrole!='6' AND $userrole!='7'){
			redirect('admin/logout');
			exit();  
		}elseif (!in_array($module, $userpermission) AND ($userrole=='2' || $userrole=='3' || $userrole=='5')){
			redirect('admin/logout');
			exit();  
		}elseif ($type=='' AND ($userrole=='2' || $userrole=='3')){
			redirect('admin/logout');
			exit();  
		}
		$data['userpermission'] = $userpermission;
		$data['userrole'] = $userrole;
		return $data;
	} 

	public function reportevaluation(){
		$this->validateLogin('evaluation','evaluationedit');
		$EvaluationID = $this->uri->segment(3);
	
		$get_single_evaluation = $this->Evaluationadmin->get_single_evaluation($EvaluationID);
		$AddDate = $get_single_evaluation['AddedDate'];
		$Dateofvisit = $get_single_evaluation['Dateofvisit'];
		$exdate = explode("/",$Dateofvisit); 
        @$newDate = $exdate[0].'_'.$exdate[1].'_'.$exdate[2];

		$Internalsamplecodecontrolvariety = $get_single_evaluation['Internalsamplecodecontrolvariety'];
		
		$Internalsamplecode = $get_single_evaluation['Internalsamplecode'];

		$get_single_sampling = $this->Evaluationadmin->get_single_sampling($Internalsamplecode);
   
		$SupplierID = $get_single_sampling['SupplierID'];
		$CropID  = $get_single_sampling['Crop'];
		// $ControlvarietyID = $get_single_sampling['SamplingID'];

		$get_single_supplier = $this->Evaluationadmin->get_single_supplier($SupplierID);
		$supplier_name = $get_single_supplier['Name'];

		$get_single_crop = $this->Evaluationadmin->get_single_crop($CropID);
		$crops_title = $get_single_crop['Title'];

		// $get_single_variety = $this->Evaluationadmin->get_single_variety($ControlvarietyID);

		// $Controlvariety  = $get_single_sampling['Controlvariety'];

		// $Variety = $get_single_variety['Variety'];
		// $Variety = $get_single_evaluation['Varietytype'];
		
		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle($supplier_name.'_'.$crops_title.'_'.$Dateofvisit);
		$pdf->SetHeaderMargin(15);
		$pdf->SetTopMargin(15);
		$pdf->setFooterMargin(15);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->SetMargins(15, 15, 15);
		$pdf->SetAutoPageBreak(TRUE, 15);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		$lg = Array();
		$lg['a_meta_charset'] = 'UTF-8';
		// $lg['a_meta_dir'] = 'rtl';
		$lg['a_meta_language'] = 'fa';
		$lg['w_page'] = 'page';

		// set some language-dependent strings (optional)
		$pdf->setLanguageArray($lg);

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('dejavusans', '', 13);
		$pdf->AddPage();


		$htmlContent = "";
		$htmlContent1 = "";
		$htmlContent2 = "";
		$htmlimg1 = "";
		$htmlimg2 = "";
		$htmlImagename = "";

		$htmlContent .= "<div><b>".$supplier_name.' '.$crops_title.' '.$Dateofvisit."</b><div><br>";

		$pdf->writeHTML($htmlContent, true, 0, true, 0);
		if(isset($_POST['editor1']) AND $_POST['editor1']!=''){
			// $htmlContent1 .= "<p><b>Variety  :" .$Variety."</b>";
			// $htmlContent1 .= "<p><b>Control Variety :" .$Controlvariety."</b>";
			$htmlContent1 .= "<p>".$_POST['editor1']."</p><br/>";
		}

		$pdf->writeHTML($htmlContent1, true, 0, true, 0);

		$pdf->lastPage();

		$pdf->AddPage();
		$imgdata = base64_decode('iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABlBMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDrEX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==');

		// The '@' character is used to indicate that follows an image data stream and not an image file name
		$pdf->writeHTML($htmlimg1, true, 0, true, 0);
		//$pdf->lastPage();
		$x = 15;
		$y = 20;
		$w = 85;
		$h = 55;
		$a = 20;
		$b = 125;
		$c = 00;
		$d = 260;
		if(isset($_POST['Pictures_1'])){
			$Picture= $_POST['Pictures_1'];
			$cnt = 1;
			$cnt1 = 1;
			if(count($Picture)>0){
				foreach ($Picture as $value){

					//$htmlimg1 .= '<img src="'.$value.'" alt="test alt attribute" width="315" height="300" border="1" />'.' ';
			 		$image_name = explode('_', $value);
			 		$newimage_name = @$image_name[2].'_'.@$image_name[3].'_'.@$image_name[4];
					// print_r($newimage_name);
					// die();
					// $htmlImagename .= '<p  style="color: blue;margin-top:320px;">'.$newimage_name.'</p>';
					if($cnt1 == '7'){
						$pdf->AddPage();
						$y = 20;
						$a = 40;
						$c = 10;
						$b = 125;
						$d = 265;
						$cnt1 = 1;
					}
					if($cnt=='1'){
						// $pdf->Text(15, 110, $image_name);
						$pdf->Image($value, $x, $y, $w, $h, '', '', '', false, 300);
						$pdf->Cell($a,$b, $newimage_name, 0, false, 'C', 0, '', 0, false);
						// $htmlImagename .= '<br><br><br><br><br><div  style="color:black;font-size:15px;">'.$newimage_name.'</div>';
 						$cnt++;
						// $pdf->Text(50, 125 ,$newimage_name);
					}elseif($cnt=='2'){
						$x = 110;
						// $a = 170;
						$c = 75;
						// $pdf->Text(15, 205, $image_name);
						$pdf->Image($value, $x, $y, $w, $h, '', '', '', false, 350);
						$pdf->Cell($c,$d, $newimage_name, 0, false, 'C', 0, '', 0, false);
						// $pdf->Text(50, 125,$newimage_name);
						// $htmlImagename .= '<br><br><br><br><div  style="color:black;font-size:15px;">'.$newimage_name.'</div>';
						$cnt = 1;	
						$x = 15;
						// $a = 30; 
						$y = $y+70;
						// $b = $b+10;
						// $pdf->Text(120, 110, $image_name);
						// $pdf->Text(120, 205, $image_name);
					}
					$cnt1++;
					
				}
			}	
		}		

		$pdf->AddPage();

		if(isset($_POST['editor2']) AND $_POST['editor2']!=''){
			$htmlContent2 .= "<br/><p><b>Internal sample code control variety :</b>";
			$htmlContent2 .= "<p>".$_POST['editor2']."</p><br/>";
		}

		$pdf->writeHTML($htmlContent2, true, 0, true, 0);

		$pdf->AddPage();

		$x = 15;
		$y = 20;
		$w = 85;
		$h = 85;
		if(isset($_POST['Pictures_2'])){
			$Picture= $_POST['Pictures_2'];
			if(count($Picture)>0){
				$cnt = 1;
				$cnt1 = 1;
				foreach ($Picture as $value) {
					if($cnt1 == '7'){
						$pdf->AddPage();
						$y = 20;
						$cnt1 = 1;
					}
					if($cnt=='1'){
						$pdf->Image($value, $x, $y, $w, $h, '', '', '', false, 300);
						$cnt++;
					}elseif($cnt=='2'){
						$x = 110;
						$pdf->Image($value, $x, $y, $h, $h, '', '', '', false, 300);
						$cnt = 1;	
						$x = 15; 
						$y = $y+87;
					}
					$cnt1++;
				}
			}	
		}
		$pdf->writeHTML($htmlimg2, true, 0, true, 0);

		$pdf->Output($supplier_name.'_'.$crops_title.'_'.$newDate.'.pdf','I');
	}
}