<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trial extends MX_Controller {

	function __construct()   {

		parent::__construct();
		$this->load->model('Trialapi','',TRUE);
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



			$getuser = $this->Trialapi->getuser($userid);



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



			$get_trial = $this->Trialapi->get_trial($userid);



			$trials= array();

			foreach ($get_trial as $value) {

				$trial = array();

				$trial['trialid'] = (int)$value['TrialID'];

				$trial['internalsamplecode'] = $value['Internalcode'];

				$trial['date'] = $value['Date'];

				$trial['description'] = $value['Description'];

				

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

							$Picture['thumbnail'] = base_url().'uploads/Trial/'.$Picturevalue_name;

						}

		            	$Pictures[] = $Picture;

		            }

				}

				$trial['pictures'] = $Pictures;

				$trials[] = $trial;

			}



			$output['status']=false;

			$output['data']['heading'] = 'Trial List';	

			$output['data']['trials'] = $trials;

			$output['message'] = 'Trial List';

		}else{

			$output['message'] = '405';

		}	

		echo json_encode($output);

		die;

    }	



	public function add(){
		/*ini_set('memory_limit', '-1');

		ini_set('post_max_size', '20M');

		ini_set('upload_max_filesize', '20M');

		ini_set('max_execution_time', '5000');*/
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
				}
				else{
					$Internalsamplecode = $this->input->post('internalsamplecode',true);
					$result = $this->Trialapi->get_sampling_count($Internalsamplecode);
					if($result){
						$output['message']  ='This Internal seed code not exits';
						echo json_encode($output);
						die;
					}
				}

				if($this->input->post('date',true)==''){
						$output['message']  ='Date field is required';
						echo json_encode($output);
						die;
				}

				$userid = $this->input->post('userid',true);

				$getuser = $this->Trialapi->getuser($userid);
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
				$datapost['Internalcode'] = $this->input->post('internalsamplecode',true);
				$datapost['Date'] = $this->input->post('date',true);
		        $datapost['Description'] = $this->input->post('description',true);
		        $datapost['added_location'] = $this->input->post('added_location',true);
		        $datapost['latitude'] = $this->input->post('latitude',true);
				$datapost['longitude'] = $this->input->post('longitude',true);
		        $upload_filename = array();

				if(@$_FILES["pictures"]["name"] != ''){
                    $targetDir = "uploads/Trial/";
                    $allowTypes = array('jpg','png','jpeg','gif','mp4','mov');
                    $images_arr = array();
                    foreach($_FILES['pictures']['name'] as $key=>$val){
                        $image_name = time()."_".$key."_".$_FILES['pictures']['name'][$key];
                        $tmp_name   = $_FILES['pictures']['tmp_name'][$key];
                        $size       = $_FILES['pictures']['size'][$key];
                        $type       = $_FILES['pictures']['type'][$key];
                        $error      = $_FILES['pictures']['error'][$key];
                        // File upload path

                        $fileName = basename($image_name);
                        $file_Name = str_replace(' ', '_', $fileName);
                        $targetFilePath = $targetDir . $file_Name;
                        // Check whether file type is valid

                        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);          

                        //if(in_array($fileType, $allowTypes)){    

                            if(move_uploaded_file($_FILES['pictures']['tmp_name'][$key],$targetFilePath)){
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

                    /*$upload_filename = trim($upload_filename,",");

                    $upload_filename = str_replace(' ', '_', $upload_filename);*/

                }
                $datapost['Pictures'] = json_encode($upload_filename);
                $datapost['UserID'] = $userid;
				$datapost['Source'] = 'APP';

				$this->Trialapi->addtrial($datapost);

				$datalog = array();
				$datalog['UserID'] = $userid;
				$datalog['ipaddress'] = $this->input->post('ipaddress',true);
				$datalog['Activity'] = 'Insert';
				$datalog['Title'] = 'Trial added Internal code: '.$this->input->post('Internalcode',true);
				$datalog['Data'] = json_encode($datapost);

				$PostData = array();
				$PostData['files'] = $_FILES;
				$PostData['post'] = $_POST;
				$datalog['PostData'] = json_encode($PostData);

				$this->Trialapi->insert_log($datalog);

				$output['status']=true;
				$output['data']['heading'] = 'Add Trial';	
				$output['message'] = 'Trial Add successfully';					
		}else{
			$output['message'] = '405';
		}	
		echo json_encode($output);
		die;	
	}



	/*================= EDIT API Incomplete is Need TO Check ============*/

	public function edit(){

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

				}elseif($this->input->post('trialid',true)==''){

						$output['message']  ='TrialID is required';

						echo json_encode($output);

						die;

				}



				if($this->input->post('internalsamplecode',true)==''){

						$output['message']  ='Internal seed code field is required';

						echo json_encode($output);

						die;

				}else{

					$Internalsamplecode = $this->input->post('internalsamplecode',true);

					$result = $this->Trialapi->get_sampling_count($Internalsamplecode);

					if($result){

						$output['message']  ='This Internal seed code not exits';

						echo json_encode($output);

						die;

					}

				}



				if($this->input->post('date',true)==''){

						$output['message']  ='Date field is required';

						echo json_encode($output);

						die;

				}



				$userid = $this->input->post('userid',true);



				$getuser = $this->Trialapi->getuser($userid);



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

				$TrialID = $this->input->post('trialid',true);

				$datapost['Internalcode'] = $this->input->post('internalsamplecode',true);

				$datapost['Date'] = $this->input->post('date',true);

		        $datapost['Description'] = $this->input->post('description',true);

		        $upload_filename = '';

				if(@$_FILES["pictures"]["name"] != ''){

                    $targetDir = "uploads/Trial/";

                    $allowTypes = array('jpg','png','jpeg','gif');

                    $images_arr = array();

                    foreach($_FILES['pictures']['name'] as $key=>$val){



                        $image_name = time()."_".$_FILES['pictures']['name'][$key];

                        $tmp_name   = $_FILES['pictures']['tmp_name'][$key];

                        $size       = $_FILES['pictures']['size'][$key];

                        $type       = $_FILES['pictures']['type'][$key];

                        $error      = $_FILES['pictures']['error'][$key];

                        // File upload path

                        $fileName = basename($image_name);

                        $file_Name = str_replace(' ', '_', $fileName);

                        $targetFilePath = $targetDir . $file_Name;

                        // Check whether file type is valid

                        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

                        //if(in_array($fileType, $allowTypes)){    

                            if(move_uploaded_file($_FILES['pictures']['tmp_name'][$key],$targetFilePath)){

                                $images_arr[] = $targetFilePath;

                            	$upload_filename .=$file_Name.",";

                            }

                        //}

                    }

                    $upload_filename = trim($upload_filename,",");

                    $upload_filename = str_replace(' ', '_', $upload_filename);

                }



                $datapost['Pictures'] = $upload_filename;



                $getsingletrial = $this->Trialapi->get_single_trial($TrialID);



				$this->Trialapi->update_trial($datapost,$TrialID);

				

				$datalog = array();

				$datalog['UserID'] = $userid;

				$datalog['ipaddress'] = $this->input->post('ipaddress',true);

				$datalog['Activity'] = 'Update';

				$datalog['Title'] = 'Trial Update Internal code: '.$this->input->post('Internalcode',true);

				$datalog['Data'] = json_encode($getsingletrial);



				$this->Trialapi->insert_log($datalog);

				

				$output['status']=true;

				$output['data']['heading'] = 'Update Trial';	

				$output['message'] = 'Trial Updated successfully';

						

		}else{

			$output['message'] = '405';

		}	

		echo json_encode($output);

		die;	

	}



	public function resizeImage($filename){

      $source_path = UPLOADROOT . 'Trial/' . $filename;

      $target_path = UPLOADROOT . 'Trial/thumbnail/';

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

		$video = UPLOADROOT.'Trial/'.$filename;

		$pathinfo =  pathinfo($video); 

		$video_filename =  $pathinfo['filename'];  

	  	$image = UPLOADROOT.'Trial/thumbnail/'.$video_filename.'.jpg';



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

			if(in_array('trial', $user_permission1)){

				$userpermission[] = 'trial';

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