<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    function __construct() {
        parent::__construct();
        
        // Load facebook library
        $this->load->library('facebook');

        // Load google library
        $this->load->library('google');
        
        //Load user model
        $this->load->model('user');
    }
    
    public function facebook(){
        $userData = array();
        
        // Check if user is logged in
        if($this->facebook->is_authenticated()){
            // Get user facebook profile details
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');
            print_r($fbUser); die;
            // Preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid']    = !empty($fbUser['id'])?$fbUser['id']:'';;
            $userData['name']    = $fbUser['first_name'] .' '.$fbUser['last_name'];
            $userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';
            $userData['picture']    = !empty($fbUser['picture']['data']['url'])?$fbUser['picture']['data']['url']:'';
            
            // Insert or update user data
            $userID = $this->user->checkUser($userData);
            
            // Check user data insert or update status
            if(!empty($userID)){
                $data['userData'] = $userData;
                $this->session->set_userdata('userData', $userData);
            }else{
               $data['userData'] = array();
            }
            
            // Get logout URL
            $data['logoutURL'] = $this->facebook->logout_url();

        }else if(isset($_GET['code'])){
            
            // Authenticate user with google
            if($this->google->getAuthenticate()){
            
                $google_data=$this->google->getUserInfo();
                print_r($google_data); die;
                $session_data=array(
                        'name'=>$google_data['name'],
                        'email'=>$google_data['email'],
                        'source'=>'google',
                        'profile_pic'=>$google_data['picture'],
                        'google_id'=>$google_data['id'],
                        'sess_logged_in'=>1
                        );
                $this->session->set_userdata($session_data);
            }
        }else{
            // Get login URL
            $data['fb_url'] =  $this->facebook->login_url();
            $data['ga_url'] = $this->google->loginURL();
        }
        
        // Load login & profile view
        $this->load->view('users/profile',$data);
    }

    public function profile(){
        // Redirect to login page if the user not logged in
        if(!$this->session->userdata('user_id')){
            redirect('/users/');
        }
        
        // Get user info from session
        $data['userData'] = $this->session->userdata('userData');
        
        // Load user profile view
        $this->load->view('users/profile',$data);
    }
    
    public function logout(){
        // Reset OAuth access token
        $this->google->revokeToken();

        $this->facebook->destroy_session();
        // Remove user data from session
        $this->session->unset_userdata('userData');
        
        // Remove token and user data from the session
        $this->session->unset_userdata('loggedIn');
        $this->session->unset_userdata('userData');
        
        // Destroy entire session data
        $this->session->sess_destroy();
        
        // Redirect to login page
        redirect('/users/');
    }
}