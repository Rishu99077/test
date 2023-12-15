<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Evaluation extends MX_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Evaluationapi','',TRUE);
		$this->load->library('session');
		$this->load->library('email');
    } 

    /*================= LIST API Incomplete is Need TO Check ============*/

    public function index(){
    	$output=array();
		$output['status']=false;
		if((!empty($this->input->get('access_token'))) && file_get_contents(base_url().'resource.php?access_token='.$this->input->get('access_token'))){
			if($this->input->post('userid',true)==''){
				$output['message'] = 'User ID is required';
				echo json_encode($output);
				die;
			}elseif($this->input->post('ipaddress',true)==''){
					$output['message']  ='ipaddress field is required';
					echo json_encode($output);
					die;
			}

			$userid = $this->input->post('userid',true);

			$getuser = $this->Evaluationapi->getuser($userid);

			if($getuser['userstatus']=='0'){
				$output['message'] = "Your account not activated yet!";
				echo json_encode($output);
				die;
			}
			if(!$this->validateLogin($getuser)){
				$output['message'] = "You don't have permission to access the account!";
				echo json_encode($output);
				die;
			}

			$get_evaluation = $this->Evaluationapi->get_evaluation($userid);
			$evaluations= array();
			foreach ($get_evaluation as $value) {
				$evaluation = array();
				$evaluation = $value;
				$evaluation['EvaluationID'] = (int)$value['EvaluationID'];
				$evaluation['picture'] = base_url().'uploads/Evaluation/'.$value['Picture'];
				$Pictures = array();
				if($value['Pictures']!=''){
					$getPictures = json_decode($value['Pictures']);
					foreach ($getPictures as  $Picturevalue) {
						$Picture = array();
						$Picturevalue_type = $Picturevalue->type;
						$Picturevalue_name = $Picturevalue->name;


						$Picture['type'] = $Picturevalue_type;
						$Picture['name'] = base_url().'uploads/Trial/'.$Picturevalue_name;
						if($Picturevalue_type=='2'){
							$Picture['thumbnail'] = base_url().'adminasset/images/dummy.png';
						}else{
							$Picture['thumbnail'] = base_url().'uploads/Evaluation/'.$Picturevalue_name;
						}
		            	$Pictures[] = $Picture;
		            }
				}

				$evaluation['pictures'] = $Pictures;
				$evaluations[] = $evaluation;
			}
			$output['status']=false;
			$output['data']['heading'] = 'Evaluation List';	
			$output['data']['evaluations'] = $evaluations;
			$output['message'] = 'Evaluations List';
		}else{
			$output['message'] = '405';
		}	
		echo json_encode($output);
		die;
	}

	public function add(){
		$output=array();
		$output['status']=false;
		/*$output['files'] = $_FILES;
		$output['post'] = $_POST;
		echo json_encode($output);
		die;*/
		if((!empty($this->input->get('access_token'))) && file_get_contents(base_url().'resource.php?access_token='.$this->input->get('access_token'))){	
				if($this->input->post('userid',true)==''){
					$output['message'] = 'User ID is required';
					echo json_encode($output);
					die;
				}elseif($this->input->post('ipaddress',true)==''){
						$output['message']  ='ipaddress field is required';
						echo json_encode($output);
						die;
				}elseif($this->input->post('internalsamplecode',true)==''){
						$output['message']  ='Internal seed code field is required';
						echo json_encode($output);
						die;
				}
				// elseif($this->input->post('added_location',true)==''){
				// 		$output['message']  ='Added Location field is required';
				// 		echo json_encode($output);
				// 		die;
				// }
				elseif($this->input->post('latitude',true)==''){
						$output['message']  ='Latitude field is required';
						echo json_encode($output);
						die;
				}elseif($this->input->post('longitude',true)==''){
						$output['message']  ='Longitude field is required';
						echo json_encode($output);
						die;
				}else{
					$Internalsamplecode = $this->input->post('internalsamplecode',true);
					$result = $this->Evaluationapi->get_sampling_count($Internalsamplecode);
					if($result){
						$output['message']  ='This Internal seed code not exits';
						echo json_encode($output);
						die;
					}
				}

				$userid = $this->input->post('userid',true);
				$getuser = $this->Evaluationapi->getuser($userid);
				if($getuser['userstatus']=='0'){
					$output['message'] = "Your account not activated yet!";
					echo json_encode($output);
					die;
				}

				if(!$this->validateLogin($getuser)){
					$output['message'] = "You don't have permission to access the account!";
					echo json_encode($output);
					die;
				}


				$datapost =array();	
				$datapost = $this->input->post();
				$picture = '';

				if(@$_FILES["Picture"]["name"] != ''){	
		        	$config['upload_path']   = 'uploads/Evaluation';
		            //$config['allowed_types'] = 'jpg|png|jpeg';

		            //$config['max_size'] = '3072';

		            $config['allowed_types'] = '*';
		            $config['file_name'] = time()."".rand(1,1000)."_".trim(preg_replace('/\s+/', ' ', $_FILES['Picture']['name']));
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if($this->upload->do_upload('Picture')){
		                $uploadData = $this->upload->data();
		                 $this->resizeImage($uploadData['file_name']); 
			            $picture = $uploadData['file_name'];
					}
		        }
			    $datapost['Picture'] = $picture;
		        $upload_filename = array();
				if(@$_FILES["files"]["name"] != ''){
                    $targetDir = "uploads/Evaluation/";
                    $allowTypes = array('jpg','png','jpeg','gif','mp4','mov');
                    $images_arr = array();
                    foreach($_FILES['files']['name'] as $key=>$val){
                        $image_name = time()."_".$key."_".$_FILES['files']['name'][$key];
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
				$datapost['Source'] = 'APP';

				$EvaluationID = $this->Evaluationapi->addevaluation($datapost);
				/*====== For Re-check and Pre-commercial ===========*/

				$datarecheck = array();
				$datarecheck['EvaluationID']=$EvaluationID;
				$dataprecommercial = array();
				$dataprecommercial['EvaluationID']=$EvaluationID;

				if($EvaluationID){					
					if($this->input->post('Status')=='Re-check'){
						$check_recheck = $this->Evaluationapi->check_recheck($EvaluationID);
						if($check_recheck==0){
							$this->Evaluationapi->insert_recheck($datarecheck);
						}
						$this->Evaluationapi->delete_precommercial($EvaluationID);
					}elseif($this->input->post('Status')=='Pre-commercial'){
						$check_precommercial = $this->Evaluationapi->check_precommercial($EvaluationID);
						if($check_precommercial==0){
							$this->Evaluationapi->insert_precommercial($dataprecommercial);
						}
						$this->Evaluationapi->delete_recheck($EvaluationID);
					}else{
						$this->Evaluationapi->delete_precommercial($EvaluationID);
						$this->Evaluationapi->delete_recheck($EvaluationID);
					}	

				}	

				/*======END For Re-check and Pre-commercial ===========*/

				$datalog = array();
				$datalog['UserID'] = $userid;
				$datalog['ipaddress'] = $this->input->post('ipaddress',true);
				$datalog['added_location'] = $this->input->post('added_location',true);
				$datalog['latitude'] = $this->input->post('latitude',true);
				$datalog['longitude'] = $this->input->post('longitude',true);
				$datalog['Activity'] = 'Insert';
				$datalog['Title'] = 'Evaluation added EvaluationID: '.$EvaluationID;
				$datalog['Data'] = json_encode($datapost);
				$PostData = array();

				$PostData['files'] = $_FILES;
				$PostData['post'] = $_POST;
				$datalog['PostData'] = json_encode($PostData);

				$this->Evaluationapi->insert_log($datalog);				

				$output['status']=true;
				$output['data']['heading'] = 'Add Evaluation';	
				$output['message'] = 'Evalution added sucessfully';
		}else{
			$output['message'] = '405';
		}	
		echo json_encode($output);
		die;	
	}

	public function internalsamplecode(){

		$output=array();

		$output['status']=false;



		if((!empty($this->input->get('access_token'))) && file_get_contents(base_url().'resource.php?access_token='.$this->input->get('access_token'))){

			if($this->input->post('userid',true)==''){

					$output['message'] = 'User ID is required';

					echo json_encode($output);

					die;

			}elseif($this->input->post('ipaddress',true)==''){

						$output['message']  ='ipaddress field is required';

						echo json_encode($output);

						die;

			}else{

				$get_sampling = $this->Evaluationapi->get_sampling();

				$internalsamplecode = array();

				foreach ($get_sampling as $getsampling) {

					

					

					$internalsamplecode_arr = array();

					$get_crop = $this->Evaluationapi->get_crop($getsampling['Crop']);

					$get_seed = $this->Evaluationapi->get_seed($getsampling['Seed']);

					$get_location = $getsampling['Location'];



					$ReceiverID = $getsampling['Receiver'];

					$get_receiver = $this->Evaluationapi->get_crop_by_receiverid($ReceiverID);

					$receiver_name = $get_receiver['Name'];

					



					$internalsamplecode_arr['internalsamplingcode'] = $getsampling['Internalsamplingcode'];

					if($get_crop){

						$internalsamplecode_arr['crop'] = $get_crop['Title'];

					}else{

						$internalsamplecode_arr['crop'] = '';

					}



					if($get_location){

						$internalsamplecode_arr['location'] = $get_location;

					}else{

						$internalsamplecode_arr['location'] = '';

					}



					if($receiver_name){

						$internalsamplecode_arr['receiver_name'] = $receiver_name;

					}else{

						$internalsamplecode_arr['receiver_name'] = '';

					}



					if($get_seed){

						$internalsamplecode_arr['controlvariety'] = $get_seed['Status'];

						$internalsamplecode_arr['variety'] = $get_seed['Variety'];

					}else{

						$internalsamplecode_arr['controlvariety'] = NULL;

						$internalsamplecode_arr['variety'] = NULL;

					}



					$internalsamplecode[] = $internalsamplecode_arr;

					

				}

				$output['status']=true;

				$output['data']['internalsamplecode'] = $internalsamplecode;	

				$output['data']['heading'] = 'Internal sample code list';	

				$output['message'] = 'Internal sample code';

			}	

		}else{

			$output['message'] = '405';

		}	

		echo json_encode($output);

		die;	
	}

	public function checkinternalsamplecode(){

		$output=array();

		$output['status']=false;



		if((!empty($this->input->get('access_token'))) && file_get_contents(base_url().'resource.php?access_token='.$this->input->get('access_token'))){

			if($this->input->post('userid',true)==''){

					$output['message'] = 'User ID is required';

					echo json_encode($output);

					die;

			}elseif($this->input->post('ipaddress',true)==''){

						$output['message']  ='ipaddress field is required';

						echo json_encode($output);

						die;

			}elseif($this->input->post('internalsamplecode',true)==''){

						$output['message']  ='internalsamplecode field is required';

						echo json_encode($output);

						die;

			}else{

				$get_sampling = $this->Evaluationapi->get_single_sampling($this->input->post('internalsamplecode',true));

				if($get_sampling){

					$internalsamplecode = array();

					foreach ($get_sampling as $getsampling) {

						$internalsamplecode_arr = array();

						$get_crop = $this->Evaluationapi->get_crop($getsampling['Crop']);

						$get_seed = $this->Evaluationapi->get_seed($getsampling['Seed']);

						$get_location = $getsampling['Location'];



						$ReceiverID = $getsampling['Receiver'];

						$get_receiver = $this->Evaluationapi->get_crop_by_receiverid($ReceiverID);

						$receiver_name = $get_receiver['Name'];



						$internalsamplecode_arr['internalsamplingcode'] = $getsampling['Internalsamplingcode'];

						if($get_crop){

							$internalsamplecode_arr['crop'] = $get_crop['Title'];

						}else{

							$internalsamplecode_arr['crop'] = '';

						}



						if($get_location){

							$internalsamplecode_arr['location'] = $get_location;

						}else{

							$internalsamplecode_arr['location'] = '';

						}



						if($receiver_name){

							$internalsamplecode_arr['receiver_name'] = $receiver_name;

						}else{

							$internalsamplecode_arr['receiver_name'] = '';

						}



						if($get_seed){

							$internalsamplecode_arr['controlvariety'] = $get_seed['Status'];

							$internalsamplecode_arr['variety'] = $get_seed['Variety'];



						}else{

							$internalsamplecode_arr['controlvariety'] = NULL;

							$internalsamplecode_arr['variety'] = NULL;

						}



						$internalsamplecode[] = $internalsamplecode_arr;

					}

					$output['status']=true;

					$output['data']['internalsamplecode'] = $internalsamplecode;	

					$output['data']['heading'] = 'Check Internal sample code';	

					$output['message'] = 'Check Internal sample code';

				}else{

					$output['message'] = 'This Internal sample code are not exists';

				}	

			}	

		}else{

			$output['message'] = '405';

		}	

		echo json_encode($output);

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

   	private function validateLogin($user){

		$userrole= $user['userrole'];

		$user_permission= $user['userpermission'];

		if($user_permission!=''){

			$user_permission1 = json_decode($user_permission);

			$userpermission = array();

			if(in_array('evaluation', $user_permission1)){

				$userpermission[] = 'evaluation';

			}

		}else{	

			$userpermission= array();

		}



		if($userrole=='5' || $userrole=='7'){

			if(count($userpermission)>0){

				return true;

			}else{

				return false;

			}

		}else{

			return false;

		}
	}

}