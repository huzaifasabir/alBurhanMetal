<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller {

    public function __construct(){
        parent::__construct();
        
        if(!empty($_SESSION['admin_id'])){
            redirect('dashboard');
        }
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    public function index() {
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->load->view('home');
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /**
     * 
     */
    public function login(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_error_delimiters('', '');
        
        //$this->form_validation->set_rules('email', 'E-mail', ['required', 'trim', 'valid_email']);
        //$this->form_validation->set_rules('password', 'Password', ['required']);
        
        if(True){//$this->form_validation->run() !== FALSE){
            $username = strtolower(set_value('username'));
            $givenPassword = set_value('password');
            
            $passwordInDb = $this->genmod->getTableCol('admin', 'password', 'username', $username);
            $account_status = $this->genmod->getTableCol('admin', 'account_status', 'username', $username);
            $deleted = $this->genmod->getTableCol('admin', 'deleted', 'username', $username);
        
            //verify password if $passwordInDb has a value (i.e. is set)
            $verifiedPassword = $passwordInDb ? password_verify($givenPassword, $passwordInDb) : FALSE;
            
            //allow log in if password and email matches and admin's account has not been suspended or deleted
            //$json ['temp1'] = $givenPassword;
            if($verifiedPassword && $account_status != 0 && $deleted != 1){
                $this->load->model('admin');
                
                //set session details
                $admin_info = $this->admin->get_admin_info($username);
                
                if($admin_info){
                    foreach($admin_info as $get){
                        $admin_id = $get->id;
                        
                        $_SESSION['admin_id'] = $admin_id;
                        $_SESSION['admin_access'] = $get->access;
                        $_SESSION['admin_username'] = $username;
                        $_SESSION['admin_role'] = $get->role;
                        $_SESSION['admin_initial'] = strtoupper(substr($get->name, 0, 1));
                        $_SESSION['admin_name'] = $get->name;
                    }
                    
                    //update user's last log in time
                    $this->admin->update_last_login($admin_id);
                }

                
                $json ['status'] = 1;//set status to return
                //$json['msg'] = "hello";
            }
            
            else{//if password is not correct
                $json['msg'] = "Incorrect email and password combination hello";
                $json['status'] = 0;
            }
            

        }
        
        else{//if form validation fails            
            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json['status'] = 0;
        }
        
        //$json ['status'] = 1;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
}