  <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends My_Controller{

  function __construct(){
    parent::__construct();
    // Load google oauth library 
        $this->load->library('google'); 
        $this->config->load('facebook');
        $this->load->library('facebook');
        //$this->load->library('facebook'); 
    $this->load->model('home_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('text');
        $this->load->library('session');
        /*ini_set('display_error',1);
        ini_set('display_startup_error',1);
        error_reporting(E_ALL);*/
  } 
    public function login() {   
    	if($this->getSessionVal()){
            redirect(base_url().'home');
        }  
        if(isset($_POST['Submit']) && $_POST['Submit'] =='Submit'){
            $this->form_validation->set_rules($this->validation_rules['login']);
            if ($this->form_validation->run()){
                $post['customer_email'] = $_POST['login_name'];
                $post['customer_password'] = md5($_POST['customer_password']);
                 $result = $this->common_model->getData('tbl_customer', array('customer_email'=>$post['customer_email']), 'single');
                 $access_token =  $result->access_token;
                 $user_id =  $result->customer_id;
                 if($access_token==md5($user_id)){
                   $login_res = $this->home_model->checkUserLogin($post);
                  if(!empty($login_res)){
                    $this->session->set_userdata('uemp', $login_res);
    				$session = $this->session->all_userdata();
                    if(!empty($session['booking_data'])){
                        //$data['time_id'] = $session['booking_data']['time_id'];
			            // $data['booking_date'] = $session['booking_data']['booking_date'];
			            // $data['ground_id'] = $session['booking_data']['ground_id'];
			            // $data['center_id'] = $session['booking_data']['center_id'];
			            // //$this->db->insert('tbl_booking',$data);
                        //   $this->show_view_front('front/checkout', $data);
                        redirect(base_url().'home/checkout');
                    }else{
                        redirect(base_url().'home');
                    }
                }else{
                    $msg = '<span class="text-danger">Invalid Username And Password</span>';
                    $this->session->set_flashdata('message', $msg);
                    redirect(base_url().'home/login');
                }
              }else{
                 $msg = '<span class="text-danger">Account Not activate</span>';
                    $this->session->set_flashdata('message', $msg);
                    redirect(base_url().'home/login');
              }
            }
            else{           
                $this->show_view_front('front/login');
            }
        }else{
            $data['authURL'] =  $this->facebook->login_url(); 
            $data['loginURL'] = $this->google->loginURL(); 
            $this->show_view_front('front/login',$data);
        }
    }
}