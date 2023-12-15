<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sampling extends MX_Controller {
	function __construct()   {
		parent::__construct();
		$this->load->model('Samplingadmin','',TRUE);
		$this->load->library('session');
		$this->load->library('pagination');
		$this->load->model('Seedsadmin','',TRUE);
			
    } 

	public function index(){
		$validateLogin = $this->validateLogin('sampling','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];		

		$data['heading_title']='Sampling';
		$data['active']='sampling';
		$data['submenuactive']='sampling';

		$Crop = $this->input->get('Crop');
   		$Variety = $this->input->get('Variety');
   		$Supplier = $this->input->get('Supplier');
   		$Location = $this->input->get('Location');
   		$Receiver = $this->input->get('Receiver');
   		$Techncialteam  = $this->input->get('Techncialteam');
   		$FromDate = $this->input->get('FromDate');
   		$ToDate = $this->input->get('ToDate');

   		$SowingFromDate = $this->input->get('SowingFromDate');
   		$SowingToDate = $this->input->get('SowingToDate');

   		$HarvestFromDate  = $this->input->get('HarvestFromDate');
        $HarvestToDate  = $this->input->get('HarvestToDate');

        $TransplantFromDate  = $this->input->get('TransplantFromDate');
        $TransplantToDate  = $this->input->get('TransplantToDate');

        $DeliveryFromDate  = $this->input->get('DeliveryFromDate');
        $DeliveryToDate  = $this->input->get('DeliveryToDate');

   		$Internalsamplingcode = $this->input->get('Internalsamplingcode');

   		if ($Crop || $Variety || $Supplier || $Location || $Receiver || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $DeliveryFromDate || $DeliveryToDate || $Internalsamplingcode){
   			$total_rows = $this->Samplingadmin->filter_samplings_num_row($data['userrole'],$Crop,$Variety,$Supplier,$Location,$Receiver,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$DeliveryFromDate,$DeliveryToDate,$Internalsamplingcode);
   		}else{
   			$total_rows = $this->Samplingadmin->get_sampling_count($data['userrole']);
   		} 

		$config = array();
   		if ($Crop || $Variety || $Supplier || $Location || $Receiver || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $DeliveryFromDate || $DeliveryToDate || $Internalsamplingcode) $config['suffix'] = '?' . http_build_query($_GET, '', "&");

		$config['base_url'] = base_url() .'admin/sampling/';
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
		
		if ($Crop || $Variety || $Supplier || $Location || $Receiver || $Techncialteam || $FromDate || $ToDate || $SowingFromDate || $SowingToDate || $HarvestFromDate || $HarvestToDate || $TransplantFromDate || $TransplantToDate || $DeliveryFromDate || $DeliveryToDate || $Internalsamplingcode){
			$get_samplings = $this->Samplingadmin->get_filter_samplings($data['userrole'],$Crop, $Variety,$Supplier,$Location,$Receiver,$Techncialteam,$FromDate,$ToDate,$SowingFromDate,$SowingToDate,$HarvestFromDate,$HarvestToDate,$TransplantFromDate,$TransplantToDate,$DeliveryFromDate,$DeliveryToDate,$Internalsamplingcode,$config["per_page"], $page);
		}else{
			$get_samplings = $this->Samplingadmin->get_sampling($config["per_page"], $page,$data['userrole']);
			
		}	

		$samplings = array();
		foreach ($get_samplings as  $get_sampling) {
			$sampling = array();
			$sampling['get_crop'] = $this->Seedsadmin->get_crop($get_sampling['Crop']);
			
			$get_seed_Controlvariety = $this->Samplingadmin->get_seed($get_sampling['Controlvariety']);
			$get_seed = $this->Samplingadmin->get_seed($get_sampling['Seed']);
			if($get_seed_Controlvariety){
				$sampling['Controlvariety'] = $get_seed_Controlvariety['Variety'];
			}else{
				$sampling['Controlvariety'] ='';
			}

			if($get_seed){
				$sampling['Seed'] = $get_seed['Variety'];
			}else{
				$sampling['Seed'] ='';
			}

			
			$sampling['SamplingID'] = $get_sampling['SamplingID'];
			$sampling['Internalsamplingcode'] = $get_sampling['Internalsamplingcode'];
			$sampling['Location'] = $get_sampling['Location'];
			$sampling['Dateofsowing'] = $get_sampling['Dateofsowing'];
			$sampling['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
			$sampling['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
			$sampling['Deliverydate'] = $get_sampling['Deliverydate'];
			$sampling['Description'] = $get_sampling['Description'];
			$sampling['Technicalnotes'] = $get_sampling['Technicalnotes'];
			$sampling['is_deleted'] = $get_sampling['is_deleted'];
			$samplings[] = $sampling;
		}
		$data["samplings"] = $samplings;
        $data["links"] = $this->pagination->create_links();


        $get_crops = $this->Seedsadmin->get_crops();
		$crops = array();
		foreach ($get_crops as $value) {
			$crops[$value['CropID']] = $value['Title'];
		}
		//asort($crops);

		$get_suppliers = $this->Samplingadmin->get_suppliers();
		$suppliers = array();
		foreach ($get_suppliers as $value) {
			$suppliers[$value['SupplierID']] = $value['Name'];
		}
		//asort($suppliers);

		$get_receivers = $this->Samplingadmin->get_receivers();
		$receivers = array();
		foreach ($get_receivers as $value) {
			$receivers[$value['ReceiverID']] = $value['Name'];
		}
		//asort($receivers);

		$get_techncialteams = $this->Samplingadmin->get_techncialteams();
	    $techncialteams = array();
	 	foreach($get_techncialteams as $value){
	        $techncialteams[$value['TechncialteamID']]= $value['Name'];
	    }

        $data["crops"] = $crops;
        $data["suppliers"]=$suppliers;
        $data["receivers"]=$receivers;
        $data["techncialteams"]=$techncialteams;

        if($Crop!='' || $Supplier!=''){
        	$filter_samplings_rows = $this->Samplingadmin->filter_samplings_rows($data['userrole'],$Crop,$Supplier);
        	
        	$all_seeds = array();
    	    foreach($filter_samplings_rows as $filter_samplings_row){
    	        $filter_get_seed = $this->Samplingadmin->get_seed($filter_samplings_row['Seed']);
    	        $all_seeds[$filter_samplings_row['Seed']]= $filter_get_seed['Variety'];
    	    }
    	    asort($all_seeds);
        	$data["seeds"] = $all_seeds;        	
    	}else{
	        $all_get_seeds = $this->Samplingadmin->get_seeds();
		    $all_seeds = array();
		    foreach($all_get_seeds as $all_get_seed){
		        $all_seeds[$all_get_seed['SeedID']]= $all_get_seed['Variety'];
		    }
		    asort($all_seeds);
	    	$data["seeds"] = $all_seeds;
	    }	
        
        
        $get_sampling_all = $this->Samplingadmin->get_sampling_all_location($data['userrole']);
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

		$this->load->view('sampling',$data);
	}

	public function samplingedit(){
		$validateLogin = $this->validateLogin('sampling','seededit');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();
		$error['Receiver'] = '';
		$error['Location'] = '';
		$error['Techncialteam'] = '';
		$error['Crop'] = '';
		$error['Seed'] = '';
		$error['variety']= '';
		$error['Stockquantityfor'] = '';
		$error['Stockquantity'] = '';
		$error['Sendingmethod'] = '';
		//$error['Deliverydate'] = '';
		//$error['Dateofsowing'] = '';
		$error['Dateoftransplanted'] = '';
		$error['Estimatedharvestingdate'] = '';
		$error['Internalsamplingcode'] = '';
		$error['Controlvariety'] = '';
		$error['Description'] = '';
		$error['Technicalnotes'] = '';

		$SamplingID = @$_GET['SamplingID']; 

		$get_single_sampling =array();
		$get_single_sampling['Receiver'] = '';
		$get_single_sampling['Location'] = '';
		$get_single_sampling['Techncialteam'] = '';
		$get_single_sampling['Crop'] = '';
		$get_single_sampling['Seed'] = '';
		$get_single_sampling['Stockquantityfor'] = '';
		$get_single_sampling['Stockquantity'] = '';
		$get_single_sampling['Sendingmethod'] = '';
		$get_single_sampling['Deliverydate'] = '';
		$get_single_sampling['Dateofsowing'] = '';
		$get_single_sampling['Dateoftransplanted'] = '';
		$get_single_sampling['Estimatedharvestingdate'] = '';
		$get_single_sampling['Internalsamplingcode'] = $this->generateinternalsamplingcode();
		$get_single_sampling['Controlvariety'] = '';
		$get_single_sampling['Description'] = '';
		$get_single_sampling['Technicalnotes'] = '';

		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('Receiver', 'Receiver', 'required|trim');
			$this->form_validation->set_rules('Location', 'Location', 'required|trim');
			$this->form_validation->set_rules('Techncialteam', 'Techncial team', 'required|trim');
			$this->form_validation->set_rules('Crop', 'Crop', 'required|trim');
			$this->form_validation->set_rules('Seed', 'Seed', 'required|trim');
			$this->form_validation->set_rules('Stockquantityfor', 'Stock quantity for', 'required|trim');
			$this->form_validation->set_rules('Stockquantity', 'Stock quantity', 'required|trim');

			$this->form_validation->set_rules('Sendingmethod', 'Sending method', 'required|trim');
			//$this->form_validation->set_rules('Deliverydate', 'Delivery date', 'required|trim');
			//$this->form_validation->set_rules('Dateofsowing', 'Date of sowing', 'required|trim');
			$this->form_validation->set_rules('Internalsamplingcode', 'Internal sampling code', 'required|trim');
			/*$this->form_validation->set_rules('Controlvariety', 'Control variety', 'required|trim');*/
			

			if ($this->form_validation->run() == FALSE) {
				if(form_error('Receiver')){
					$error['Receiver']  =form_error('Receiver');
				}
				if(form_error('Location')){
					$error['Location']  =form_error('Location');
				}
				if(form_error('Techncialteam')){
					$error['Techncialteam']  =form_error('Techncialteam');
				}
				if(form_error('Crop')){
					$error['Crop']  =form_error('Crop');
				}
				if(form_error('Seed')){
					$error['Seed']  =form_error('Seed');
				}
				if(form_error('Stockquantityfor')){
					$error['Stockquantityfor']  =form_error('Stockquantityfor');
				}
				if(form_error('Stockquantity')){
					$error['Stockquantity']  =form_error('Stockquantity');
				}
				if(form_error('Sendingmethod')){
					$error['Sendingmethod']  =form_error('Sendingmethod');
				}
				if(form_error('Deliverydate')){
					$error['Deliverydate']  =form_error('Deliverydate');
				}
				if(form_error('Dateofsowing')){
					$error['Dateofsowing']  =form_error('Dateofsowing');
				}
				if(form_error('Internalsamplingcode')){
					$error['Internalsamplingcode']  =form_error('Internalsamplingcode');
				}
			}else{
				$Seed = $this->input->post('Seed',true);
				$Stockquantityfor = $this->input->post('Stockquantityfor',true);
				$Stockquantity = $this->input->post('Stockquantity',true);

				if($SamplingID){
					$get_seed_count = $this->Samplingadmin->get_seed_count($Seed,$Stockquantityfor,$Stockquantity,$SamplingID);
				}else{
					$get_seed_count = $this->Samplingadmin->get_seed_count($Seed,$Stockquantityfor,$Stockquantity);
				}

				if($get_seed_count['message']!=''){
					$error['Stockquantity']  =$get_seed_count['message'];
				}else{
				
					$datalog = array();
					$datalog['UserID'] = $this->session->userdata('UserID');

					$datapost = array();
					$datapost['Receiver'] = $this->input->post('Receiver');
					$datapost['Location'] = $this->input->post('Location');
					$datapost['Techncialteam'] = $this->input->post('Techncialteam');
					$datapost['Crop'] = $this->input->post('Crop');
					$datapost['Seed'] = $this->input->post('Seed');
					$datapost['Stockquantityfor'] = $this->input->post('Stockquantityfor');
					$datapost['Stockquantity'] = $this->input->post('Stockquantity');
					$datapost['Sendingmethod'] = $this->input->post('Sendingmethod');
					$datapost['Deliverydate'] = $this->input->post('Deliverydate');
					$datapost['Dateofsowing'] = $this->input->post('Dateofsowing');
					$datapost['Dateoftransplanted'] = $this->input->post('Dateoftransplanted');
					$datapost['Estimatedharvestingdate'] = $this->input->post('Estimatedharvestingdate');
					$datapost['Internalsamplingcode'] = $this->input->post('Internalsamplingcode');
					$datapost['Description'] = $this->input->post('Description');
					$datapost['Technicalnotes'] = $this->input->post('Technicalnotes');

					if ($this->input->post('Controlvariety')!=''){
						$datapost['Controlvariety'] = $this->input->post('Controlvariety');
					}	

					$get_seed = $this->Samplingadmin->get_seed($datapost['Seed']);
					
					if($get_seed){
						$datapost['SupplierID'] = $get_seed['Supplier'];
					}

					if($SamplingID){
						$getsinglesampling = $this->Samplingadmin->get_single_sampling($SamplingID);
	
						$this->Samplingadmin->update_sampling($datapost,$SamplingID);

						$this->session->set_flashdata('success', 'Sampling update successfully.');

						$datalog['Activity'] = 'Update';
						$datalog['Title'] = 'Sampling Update Seed: '.$this->input->post('Seed',true);
						$datalog['Data'] = json_encode($getsinglesampling);

					}else{
						$datapost['UserID'] = $this->session->userdata('UserID');
						// development
						$get_users = $this->Samplingadmin->get_users($datapost['UserID']);
						$datapost['userrole'] = $get_users['userrole'];
						
						$SamplingID = $this->Samplingadmin->insert_sampling($datapost);

						$this->session->set_flashdata('success', 'Sampling added successfully.');

						$datalog['Activity'] = 'Insert';
						$datalog['Title'] = 'Sampling added Seed: '.$this->input->post('Seed',true);
						$datalog['Data'] = json_encode($this->input->post());

					}
					$this->Samplingadmin->insert_log($datalog);

					if(@$_GET['rediret_url']!=''){
						redirect($_GET['rediret_url']);
					}else{
						redirect('admin/sampling');
					}
					exit();
				}		
			}

			$get_single_sampling['Techncialteam'] =  $this->input->post('Techncialteam',true);
			$get_single_sampling['Sendingmethod'] =  $this->input->post('Sendingmethod',true);
			$get_single_sampling['Deliverydate'] =  $this->input->post('Deliverydate',true);
			$get_single_sampling['Dateofsowing'] =  $this->input->post('Dateofsowing',true);
			$get_single_sampling['Dateoftransplanted'] =  $this->input->post('Dateoftransplanted',true);
			$get_single_sampling['Estimatedharvestingdate'] =  $this->input->post('Estimatedharvestingdate',true);
			$get_single_sampling['Internalsamplingcode'] =  $this->input->post('Internalsamplingcode',true);
			
			$get_single_sampling['Description'] =  $this->input->post('Description',true);
			$get_single_sampling['Technicalnotes'] =  $this->input->post('Technicalnotes',true);
		}

		

		if($SamplingID){			
			$get_single_sampling = $this->Samplingadmin->get_single_sampling($SamplingID);
			$data['heading_title']='Edit sampling';
			$data['SamplingID']= $SamplingID;
		}else{
			$data['SamplingID']= '';
			$data['heading_title']='Add sampling';
		}

		$get_seed_Controlvariety = $this->Samplingadmin->get_seed($get_single_sampling['Controlvariety']);
		
		$get_seed = $this->Samplingadmin->get_seed($get_single_sampling['Seed']);
		
		if($get_seed_Controlvariety){
			$get_single_sampling['Controlvariety'] = $get_seed_Controlvariety['Variety'];
		}else{
			$get_single_sampling['Controlvariety'] ='';
		}

		$get_single_sampling['SeedID'] = $get_single_sampling['Seed'];
		if($get_seed){
			$get_single_sampling['Seed'] = $get_seed['Variety'];
		}else{
			$get_single_sampling['Seed'] ='';
		}

		$get_sampling_all = $this->Samplingadmin->get_sampling_all_location($data['userrole']);
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

		$data["controlvariety"] = $this->Samplingadmin->get_controlvariety();
		$data["receivers"] = $this->Samplingadmin->get_receivers();
		$data["techncial_team"] = $this->Samplingadmin->get_techncialteam();
		$data["seeds"] = $this->Samplingadmin->get_seeds();
		$data["crops"]= $this->Samplingadmin->get_crops();
		$data["suppliers"]=$this->Samplingadmin->get_suppliers();

		$Sendingmethod =array();
		$Sendingmethod[] = 'By post';
		$Sendingmethod[] = 'By Person';

		$data['Sendingmethod']=$Sendingmethod;
		$data['error']=$error;
		$data['active']='sampling';
		$data['submenuactive']='samplingedit';
		$data['get_single_sampling']= $get_single_sampling;
		$data['baseurl']= base_url();
		$this->load->view('samplingedit',$data);
	}

	public function samplingview(){
		$validateLogin = $this->validateLogin('sampling','seededit');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$error = array();
		$error['Receiver'] = '';
		$error['Location'] = '';
		$error['Techncialteam'] = '';
		$error['Crop'] = '';
		$error['Seed'] = '';
		$error['Stockquantityfor'] = '';
		$error['Stockquantity'] = '';
		$error['Sendingmethod'] = '';
		//$error['Deliverydate'] = '';
		//$error['Dateofsowing'] = '';
		$error['Dateoftransplanted'] = '';
		$error['Estimatedharvestingdate'] = '';
		$error['Internalsamplingcode'] = '';
		$error['Controlvariety'] = '';
		$error['Description'] = '';
		$error['Technicalnotes'] = '';

		$SamplingID = @$_GET['SamplingID']; 

		$get_single_sampling =array();
		$get_single_sampling['Receiver'] = '';
		$get_single_sampling['Location'] = '';
		$get_single_sampling['Techncialteam'] = '';
		$get_single_sampling['Crop'] = '';
		$get_single_sampling['Seed'] = '';
		$get_single_sampling['Stockquantityfor'] = '';
		$get_single_sampling['Stockquantity'] = '';
		$get_single_sampling['Sendingmethod'] = '';
		$get_single_sampling['Deliverydate'] = '';
		$get_single_sampling['Dateofsowing'] = '';
		$get_single_sampling['Dateoftransplanted'] = '';
		$get_single_sampling['Estimatedharvestingdate'] = '';
		$get_single_sampling['Internalsamplingcode'] = $this->generateinternalsamplingcode();
		$get_single_sampling['Controlvariety'] = '';
		$get_single_sampling['Description'] = '';
		$get_single_sampling['Technicalnotes'] = '';


		if($SamplingID){			
			$get_single_sampling = $this->Samplingadmin->get_single_sampling($SamplingID);
			$data['heading_title']='Edit sampling';
			$data['SamplingID']= $SamplingID;
		}else{
			$data['SamplingID']= '';
			$data['heading_title']='Add sampling';
		}

		$get_seed_Controlvariety = $this->Samplingadmin->get_seed($get_single_sampling['Controlvariety']);
		
		$get_seed = $this->Samplingadmin->get_seed($get_single_sampling['Seed']);
		if($get_seed_Controlvariety){
			$get_single_sampling['Controlvariety'] = $get_seed_Controlvariety['Variety'];
		}else{
			$get_single_sampling['Controlvariety'] ='';
		}

		$get_single_sampling['SeedID'] = $get_single_sampling['Seed'];
		if($get_seed){
			$get_single_sampling['Seed'] = $get_seed['Variety'];
		}else{
			$get_single_sampling['Seed'] ='';
		}

		$get_sampling_all = $this->Samplingadmin->get_sampling_all_location($data['userrole']);
        $locations = array();
        foreach ($get_sampling_all as  $location_value) {
        	$locations[$location_value['Location']] = $location_value['Location'];
        }
        //asort($locations);
        $data["locations"]=$locations;

		$data["controlvariety"] = $this->Samplingadmin->get_controlvariety();
		$data["receivers"] = $this->Samplingadmin->get_receivers();
		$data["techncial_team"] = $this->Samplingadmin->get_techncialteam();
		$data["seeds"] = $this->Samplingadmin->get_seeds();
		$data["crops"]= $this->Samplingadmin->get_crops();
		$data["suppliers"]=$this->Samplingadmin->get_suppliers();

		$Sendingmethod =array();
		$Sendingmethod[] = 'By post';
		$Sendingmethod[] = 'By Person';

		$data['Sendingmethod']=$Sendingmethod;
		$data['error']=$error;
		$data['active']='sampling';
		$data['submenuactive']='samplingedit';
		$data['get_single_sampling']= $get_single_sampling;
		$data['baseurl']= base_url();
		$this->load->view('samplingview',$data);
	}

	public function location(){
		$ReceiverID = $this->input->post('Receiver',true);
		$Locationselect = $this->input->post('Locationselect',true);
		$get_receiver = $this->Samplingadmin->get_receiver($ReceiverID);
		$html = '';
		if($get_receiver['Location']!=''){
          	$get_Location = json_decode($get_receiver['Location']);
          	$html .= '<select class="form-control select2box" id="Location" name="Location">';	
                foreach ($get_Location as $value) {
             		$html .='<option value="'.$value.'" ';
             		if ($value == $Locationselect ){
             			$html .='selected' ;
             		}
             		$html .= '>'.$value.'</option>';
                }
            $html .='</select>';
        }else{
        	$html = 'Location Not Found.';
        }
        echo $html;
		die;
	}

	public function location_view(){
		$ReceiverID = $this->input->post('Receiver',true);
		$Locationselect = $this->input->post('Locationselect',true);
		$get_receiver = $this->Samplingadmin->get_receiver($ReceiverID);
		$html = '';
		if($get_receiver['Location']!=''){
          	$get_Location = json_decode($get_receiver['Location']);
          	foreach ($get_Location as $value) {
          		echo $value;
          	}
          	
        }else{
        	echo $html = 'Location Not Found.';
        }
		die;
	}

	public function seed(){
		$Crop = $this->input->post('Crop',true);
		$Seedselect = $this->input->post('Seedselect',true);
		$get_seed = $this->Samplingadmin->get_seed_by_crop($Crop);

		$response = array();

		$html = '';
		if(count($get_seed)>0){
          	$html .= '<select class="form-control select2box" id="Seed" name="Seed">';	
          	$html .= '<option value="">Please Select Seed</option>';
                foreach ($get_seed as $value) {
             		$html .='<option value="'.$value['SeedID'].'" ';
             		if ($value['SeedID'] == $Seedselect ){
             			$html .='selected' ;
             		}
             		$html .='>'.$value['Variety'].'</option>';
                }
            $html .='</select>';
        }else{
        	$html = 'Seeds Not Found.';
        }

        $response['seed'] = $html;        
		echo json_encode($response);
		die;
	}

	public function seed_view(){
		$Crop = $this->input->post('Crop',true);
		$Seedselect = $this->input->post('Seedselect',true);
		$get_seed = $this->Samplingadmin->get_seed_by_crop($Crop);

		$response = array();

		//$html = '';
		if(count($get_seed)>0){
                foreach ($get_seed as $value) {
                	if ($value['SeedID'] == $Seedselect ){
             		$html = $value['Variety'];
             		}
                }
        }else{
        	$html = 'Seeds Not Found.';
        }

        $response['seed'] = $html;        
		echo json_encode($response);
		die;
	}

	public function seedstock(){
		$Seed = $this->input->post('Seed',true);
		$Crop = $this->input->post('Crop',true);
		$Controlvarietyselect = $this->input->post('Controlvarietyselect',true);
		$get_seed_by_cropcontrolvariety = $this->Samplingadmin->get_seed_by_cropcontrolvariety($Crop);

		$response = array();

		$get_seed = $this->Samplingadmin->get_seed($Seed);
		$html = '';

		$get_samplingstock_count = $this->Seedsadmin->get_samplingstock_count($get_seed['SeedID']);
		$Getcount = $get_samplingstock_count['count'];

		if($get_seed['Stockquantityfor']=='1'){
			$count1 = $Getcount/1000;

			$count_seed = $get_seed['Stockquantity'];
			$Available_seed = $count_seed-$count1;
			$Availableseed = 0;
			if($Available_seed>0){
				$Availableseed =  $Available_seed;
			}
			$html .= '<b style="margin-right: 5px;">Available stock</b> '.$count_seed.' Kg';
			$html .= '<br/><input type="radio" class="formcontrol" id="Stockquantityfor1" name="Stockquantityfor" value="1" checked="checked"><label for="Stockquantityfor1">Kg</label>';
		}elseif($get_seed['Stockquantityfor']=='0'){

			$count_seed = $get_seed['Stockquantity'];
			$Available_seed = $count_seed-$Getcount;
			$Availableseed = 0;
			if($Available_seed>0){
				$Availableseed =  $Available_seed;
			}
			
			$html .= '<b style="margin-right: 5px;">Available stock</b> '.$count_seed.' Grams';
			$html .= '<br/><input type="radio" class="formcontrol" id="Stockquantityfor0" name="Stockquantityfor" value="0" checked="checked"><label for="Stockquantityfor0">Gram</label>';
		}elseif($get_seed['Stockquantityfor']=='2'){

			$count_seed = $get_seed['Stockquantity'];
			$Available_seed = $count_seed-$Getcount;
			$Availableseed = 0;
			if($Available_seed>0){
				$Availableseed =  $Available_seed;
			}
			
			$html .= '<b style="margin-right: 5px;">Available stock</b> '.$count_seed.' Seeds';
			$html .= '<br/><input type="radio" class="formcontrol" id="Stockquantityfor2" name="Stockquantityfor" value="2" checked="checked"><label for="Stockquantityfor2">Seed</label>';
		}

		$response['Stockquantityforbox'] = $html;

		$html = ''; 
		if($get_seed['Status']!='5'){
	        if(count($get_seed_by_cropcontrolvariety)>0){
	        	$html .= '<label for="" class="required">Control variety</label>';
	          	$html .= '<select class="form-control select2box" id="Controlvariety" name="Controlvariety">';	
	          	$html .= '<option value="">Please Select Control variety</option>';
	                foreach ($get_seed_by_cropcontrolvariety as $value) {
	             		$html .='<option value="'.$value['SeedID'].'" ';
	             		if($Controlvarietyselect == $value['SeedID']){ 
	             			$html .='selected';	
	             		}
	             		$html .='>'.$value['Variety'].'</option>';
	                }
	            $html .='</select>';
	        }else{
	        	$html = 'Control variety Not Found.';
	        }
	    }    

        
        $response['controlvariety'] = $html;

		echo json_encode($response);
		die;
	}

	public function seedstock_view(){
		$Seed = $this->input->post('Seed',true);
		$Crop = $this->input->post('Crop',true);
		$Controlvarietyselect = $this->input->post('Controlvarietyselect',true);
		$get_seed_by_cropcontrolvariety = $this->Samplingadmin->get_seed_by_cropcontrolvariety($Crop);

		$response = array();

		$get_seed = $this->Samplingadmin->get_seed($Seed);
		$html = '';

		$get_samplingstock_count = $this->Seedsadmin->get_samplingstock_count($get_seed['SeedID']);
		$Getcount = $get_samplingstock_count['count'];

		if($get_seed['Stockquantityfor']=='1'){
			$count1 = $Getcount/1000;

			$count_seed = $get_seed['Stockquantity'];
			$Available_seed = $count_seed-$count1;
			$Availableseed = 0;
			if($Available_seed>0){
				$Availableseed =  $Available_seed;
			}
			$html .= '<b style="margin-right: 5px;">Available stock</b> '.$count_seed.' Kg';
			$html .= '<br/><input type="radio" class="formcontrol" id="Stockquantityfor1" name="Stockquantityfor" value="1" checked="checked"><label for="Stockquantityfor1">Kg</label>';
		}elseif($get_seed['Stockquantityfor']=='0'){

			$count_seed = $get_seed['Stockquantity'];
			$Available_seed = $count_seed-$Getcount;
			$Availableseed = 0;
			if($Available_seed>0){
				$Availableseed =  $Available_seed;
			}
			
			$html .= '<b style="margin-right: 5px;">Available stock</b> '.$count_seed.' Grams';
			$html .= '<br/><input type="radio" class="formcontrol" id="Stockquantityfor0" name="Stockquantityfor" value="0" checked="checked"><label for="Stockquantityfor0">Gram</label>';
		}elseif($get_seed['Stockquantityfor']=='2'){

			$count_seed = $get_seed['Stockquantity'];
			$Available_seed = $count_seed-$Getcount;
			$Availableseed = 0;
			if($Available_seed>0){
				$Availableseed =  $Available_seed;
			}
			
			$html .= '<b style="margin-right: 5px;">Available stock</b> '.$count_seed.' Seeds';
			$html .= '<br/><input type="radio" class="formcontrol" id="Stockquantityfor2" name="Stockquantityfor" value="2" checked="checked"><label for="Stockquantityfor2">Seed</label>';
		}

		$response['Stockquantityforbox'] = $html;

		$html = ''; 
		if($get_seed['Status']!='5'){
	        if(count($get_seed_by_cropcontrolvariety)>0){
	        	$html .= '<label for="" class="required">Control variety</label>';
	          	$html .= '<select class="form-control select2box" id="Controlvariety" name="Controlvariety">';	
	          	$html .= '<option value="">Please Select Control variety</option>';
	                foreach ($get_seed_by_cropcontrolvariety as $value) {
	             		$html .='<option value="'.$value['SeedID'].'" ';
	             		if($Controlvarietyselect == $value['SeedID']){ 
	             			$html .='selected';	
	             		}
	             		$html .='>'.$value['Variety'].'</option>';
	                }
	            $html .='</select>';
	        }else{
	        	$html = 'Control variety Not Found.';
	        }
	    }  

        
        $response['controlvariety'] = $html;

		echo json_encode($response);
		die;
	}
	
	public function deletesampling_old(){
		$validateLogin = $this->validateLogin('sampling');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SamplingID = $this->uri->segment(3);
		if($SamplingID){
			$getsinglesampling = $this->Samplingadmin->get_single_sampling($SamplingID);
			
			$this->Samplingadmin->deletesampling($SamplingID,$data['userrole']);
			$this->session->set_flashdata('success', 'Sampling been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Sampling Delete Seed: '.$getsinglesampling['Seed'];
			$datalog['Data'] = json_encode($getsinglesampling);

			$this->Samplingadmin->insert_log($datalog);

		}
		redirect('admin/sampling');
		exit();
	}

	public function deletesampling(){
		$validateLogin = $this->validateLogin('sampling');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SamplingID = $_POST['DeleteID'];
		if($SamplingID){
			$getsinglesampling = $this->Samplingadmin->get_single_sampling($SamplingID);
			
			$this->Samplingadmin->deletesampling($SamplingID,$data['userrole']);
			$this->session->set_flashdata('success', 'Sampling been Deleted successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Delete';
			$datalog['Title'] = 'Sampling Delete Seed: '.$getsinglesampling['Seed'];
			$datalog['Data'] = json_encode($getsinglesampling);

			$this->Samplingadmin->insert_log($datalog);

		}
	}


	public function restoresampling(){
		$validateLogin = $this->validateLogin('sampling');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];
		$SamplingID = $this->uri->segment(3);
		if($SamplingID){
			$getsinglesampling = $this->Samplingadmin->get_single_sampling($SamplingID);
			
			$datapost = array();
			$datapost['is_deleted'] = '0';

			$this->Samplingadmin->update_sampling($datapost,$SamplingID);
			$this->session->set_flashdata('success', 'Sampling been Restore successfully.');

			$datalog = array();
			$datalog['UserID'] = $this->session->userdata('UserID');
			$datalog['Activity'] = 'Restore';
			$datalog['Title'] = 'Sampling Restore Seed: '.$getsinglesampling['Seed'];
			$datalog['Data'] = json_encode($getsinglesampling);

			$this->Samplingadmin->insert_log($datalog);

		}
		redirect('admin/sampling');
		exit();
	}

	public function check_Internalsamplingcode(){
		$data = array();
		$Internalsamplingcode = $this->input->post('Internalsamplingcode',true);
		$data['status'] = false;
		if($this->checkinternalsamplingcode($Internalsamplingcode)){
			$data['status'] = true;
			$data['message'] = 'This Internal sampling code is already exists.';
		}else{
			$data['message'] = '';
		}
		echo json_encode($data);
		die;		
	}
	public function refreshInternalsamplingcode(){
		$data = array();
		$Internalsamplingcode = $this->generateinternalsamplingcode();
		$data['code'] = $Internalsamplingcode;
		$data['status'] = false;
		if($this->checkinternalsamplingcode($Internalsamplingcode)){
			$data['status'] = true;
			$data['message'] = 'This Internal sampling code is already exists.';
		}else{
			$data['message'] = '';
		}
		echo json_encode($data);
		die;		
	}
	public function checkinternalsamplingcode($Internalsamplingcode){
		$where=array('Internalsamplingcode'=>$Internalsamplingcode);
		$this->db->where($where);
		$query = $this->db->get('sampling');
		$num = $query->num_rows();
		if($num>0){
			$result = $query->result_array();
			return $result[0];
		}else{
			return false;
		}
	}

	public function generateinternalsamplingcode(){
		$strength=4;
		$permitted_chars = '0123456789';
		$input_length = strlen($permitted_chars);
	    $random_string = '';
	    for($i = 0; $i < $strength; $i++) {
	        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
	        $random_string .= $random_character;
	    }	 
	    return $random_string;
	}

	function samplingsexport(){
		$validateLogin = $this->validateLogin('sampling','list');
		$data['userpermission']=$validateLogin['userpermission'];
		$data['userrole']=$validateLogin['userrole'];

		$Crop = $this->input->get('Crop');
   		$Variety = $this->input->get('Variety');
   		$Supplier = $this->input->get('Supplier');
   		$Location = $this->input->get('Location');
   		$Receiver = $this->input->get('Receiver');
   		$Techncialteam  = $this->input->get('Techncialteam');
   		$FromDate = $this->input->get('FromDate');
   		$ToDate = $this->input->get('ToDate');
   		$Internalsamplingcode = $this->input->get('Internalsamplingcode');

   		if ($Crop!='' || $Variety!='' || $Supplier!='' || $Location!=''|| $Techncialteam!='' || $Receiver!='' || $FromDate!='' || $ToDate!='' || $Internalsamplingcode!=''){
			$get_samplings = $this->Samplingadmin->get_samplings_export($data['userrole'],$Crop,$Variety,$Supplier,$Location,$Receiver,$Techncialteam,$FromDate,$ToDate,$Internalsamplingcode);
		}else{
			$get_samplings = $this->Samplingadmin->get_samplings_export($data['userrole']);
		}
        
		$samplings = array();
		foreach ($get_samplings as  $get_sampling) {
			$sampling = array();
			$get_receiver = $this->Samplingadmin->get_receiver($get_sampling['Receiver']);
			if($get_receiver){
				$sampling['Receiver'] = $get_receiver['Name'];
			}else{
				$sampling['Receiver'] ='';
			}

			$sampling['Location'] = $get_sampling['Location'];

			$get_single_techncialteam = $this->Samplingadmin->get_single_techncialteam($get_sampling['Techncialteam']);
			if($get_single_techncialteam){
				$sampling['Techncialteam'] = $get_single_techncialteam['Name'];
			}else{
				$sampling['Techncialteam'] ='';
			}
			
			$get_crop = $this->Seedsadmin->get_crop($get_sampling['Crop']);
			if($get_crop){
				$sampling['Crop'] = $get_crop['Title'];
			}else{
				$sampling['Crop'] ='';
			}

			$get_seed = $this->Samplingadmin->get_seed($get_sampling['Seed']);
			if($get_seed){
				$sampling['Seed'] = $get_seed['Variety'];
			}else{
				$sampling['Seed'] ='';
			}

			$get_supplier = $this->Samplingadmin->get_supplier($get_sampling['SupplierID']);
			if($get_supplier){
				$sampling['Supplier'] = $get_supplier['Name'];
			}else{
				$get_supplier['Supplier'] ='';
			}

			
			
			
			$sampling['Sendingmethod'] = $get_sampling['Sendingmethod'];
			$sampling['Deliverydate'] = $get_sampling['Deliverydate'];
			$sampling['Dateofsowing'] = $get_sampling['Dateofsowing'];
			$sampling['Dateoftransplanted'] = $get_sampling['Dateoftransplanted'];
			$sampling['Estimatedharvestingdate'] = $get_sampling['Estimatedharvestingdate'];
			$sampling['Internalsamplingcode'] = $get_sampling['Internalsamplingcode'];
			$get_seed_Controlvariety = $this->Samplingadmin->get_seed($get_sampling['Controlvariety']);

			if($get_seed_Controlvariety){
				$sampling['Controlvariety'] = $get_seed_Controlvariety['Variety'];
			}else{
				$sampling['Controlvariety'] ='';
			}
			$sampling['Description'] = $get_sampling['Description'];
			$sampling['Technicalnotes'] = $get_sampling['Technicalnotes'];
			if($get_sampling['Stockquantityfor']=='1'){
				$sampling['Stockquantityfor'] = 'Kg';
			}elseif($get_sampling['Stockquantityfor']=='2'){
				$sampling['Stockquantityfor'] = 'Seed';
			}else{
				$sampling['Stockquantityfor'] = 'Gram';
			}
			$sampling['Stockquantity'] = $get_sampling['Stockquantity'];
			$samplings[] = $sampling;
		}
		if(count($samplings)>0){
			$this->ExportFile($samplings);
		}
		redirect('admin/sampling');
		exit(); 
	}

	function ExportFile($records){
		require_once dirname(__FILE__) . '/../../../../PHPExcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("SHIMI YAZD Co.")
							 ->setLastModifiedBy("SHIMI YAZD Co.")
							 ->setTitle("SamplingReport")
							 ->setSubject("SamplingReport")
							 ->setDescription("SamplingReport")
							 ->setKeywords("SamplingReport")
							 ->setCategory("SamplingReport");

		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow(0,1,'Receiver')
            ->setCellValueByColumnAndRow(1,1,'Location')
            ->setCellValueByColumnAndRow(2,1,'Techncial team')
            ->setCellValueByColumnAndRow(3,1,'Crop')
            ->setCellValueByColumnAndRow(4,1,'Seed')
            ->setCellValueByColumnAndRow(5,1,'Supplier')
            ->setCellValueByColumnAndRow(6,1,'Sending method')
            ->setCellValueByColumnAndRow(7,1,'Delivery date')
            ->setCellValueByColumnAndRow(8,1,'Date of sowing')
            ->setCellValueByColumnAndRow(9,1,'Date of transplanted')
            ->setCellValueByColumnAndRow(10,1,'Estimated harvesting date')
            ->setCellValueByColumnAndRow(11,1,'Internal sampling code')
            ->setCellValueByColumnAndRow(12,1,'Control variety')
            ->setCellValueByColumnAndRow(13,1,'Description')
            ->setCellValueByColumnAndRow(14,1,'Technical notes')
            ->setCellValueByColumnAndRow(15,1,'Stock quantity for')
            ->setCellValueByColumnAndRow(16,1,'Stock quantity');

        $row = 2;
		foreach($records as $rec) {
			$col = 0;   
		    foreach ($rec as $value) {  
        		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
        		$col++;  
    		}   
		    $row++;
		} 
		    
        $objPHPExcel->getActiveSheet()->setTitle('SamplingReport');
        $objPHPExcel->setActiveSheetIndex(0);
  //       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8');
		header('Content-Disposition: attachment;filename="SamplingReport.csv"');
		// header('Cache-Control: max-age=0');
		// //header('Cache-Control: max-age=1');
		// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		// header ('Pragma: public'); // HTTP/1.0

		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;				 
	}

	private function validateLogin($module='',$type=''){
		if($this->session->userdata('logged_in') == false && $this->session->userdata('UserID') == ''){
			redirect('admin/logout');
			exit(); 
		}
		$get_user_detail=$this->Samplingadmin->get_user_detail($this->session->userdata('UserID'));
		$userrole= $get_user_detail['userrole'];
		$user_permission= $get_user_detail['userpermission'];
		if($user_permission!=''){
			$userpermission= json_decode($user_permission);
		}else{	
			$userpermission= array();
		}

		if($userrole!='1' AND $userrole!='2' AND $userrole!='3' AND $userrole!='4'){
			redirect('admin/logout');
			exit();  
		}elseif (!in_array($module, $userpermission) AND ($userrole=='2' || $userrole=='3')){
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
}