<?php
defined('BASEPATH') OR exit('');


class Administrators extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->genlib->superOnly();
        
        $this->load->model(['admin']);
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function index(){
        $data['pageContent'] = $this->load->view('admin/admin', '', TRUE);
        $data['pageTitle'] = "Administrators";
        
        $this->load->view('main', $data);
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * lac_ = "Load all administrators"
     */
    public function laad_(){
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "name";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //count the total administrators in db (excluding the currently logged in admin)
        $totalAdministrators = count($this->admin->getAll());
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalAdministrators, "administrators/laad_", $limit, ['class'=>'lnp']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all customers from db
        $data['allAdministrators'] = $this->admin->getAll($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalAdministrators > 0 ? ($start+1) . "-" . ($start + count($data['allAdministrators'])) . " of " . $totalAdministrators : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        
        $json['adminTable'] = $this->load->view('admin/adminlist', $data, TRUE);//get view with populated customers table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /**
     * To add new admin
     */
    public function add1(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('fullName', 'Full name', ['required', 'trim', 'strtolower'], ['required'=>"required"]);
        //$this->form_validation->set_rules('email', 'E-mail', ['trim', 'required', 'valid_email', 'strtolower'], ['required'=>"required"]);
        
        $this->form_validation->set_rules('role', 'Role', ['required'], ['required'=>"required"]);

        $this->form_validation->set_rules('mobile1', 'Phone number', ['required', 'trim', 'numeric'],['required'=>"required"]);
        $this->form_validation->set_rules('mobile2', 'Other number', ['trim', 'numeric']);
        $this->form_validation->set_rules('passwordOrig', 'Password', ['required', 'min_length[8]'], ['required'=>"Enter password"]);
        $this->form_validation->set_rules('passwordDup', 'Password Confirmation', ['required', 'matches[passwordOrig]'], ['required'=>"Please retype password"]);
        //$json = ['status'=>1, 'msg'=>"Admin account successfully created"] ;

        //$this->output->set_content_type('application/json')->set_output(json_encode($json));
        
        if($this->form_validation->run() !== FALSE){
            
             //* insert info into db
             //* function header: add($f_name, $l_name, $email, $password, $role, $mobile1, $mobile2)
             

            $hashedPassword = password_hash(set_value('passwordOrig'), PASSWORD_BCRYPT);
            $passwordOrig = set_value('passwordOrig');
            $fullName = set_value('fullName');
            $email = set_value('email');
            $role = set_value('role');
            $mobile1 = set_value('mobile1');
            $mobile2 = set_value('mobile2');
            $passwordDup = set_value('passwordDup');
            
            //$inserted = $this->admin->add($fullName, $email, $hashedPassword, $role, $mobile1, $mobile2);
            
            
            //$json = $inserted ? 
              //  ['status'=>1, 'msg'=>"Admin account successfully created"] 
                //: 
                //['status'=>0, 'msg'=>"Oops! Unexpected server error! Pls contact administrator for help. Sorry for the embarrassment"];
            $json['n1'] = $hashedPassword;
            $json['e1'] = $email;
            $json['r1'] = $role;
            $json['m1'] = $mobile1;


            $json['msg'] = "One or more required fields are empty or not correctly filled hello pol";
            $json['status'] = 0;

        }
        else{
            //return all error messages
          //  $json = $this->form_validation->error_array();//get an array of all errors
            
            //$json['msg'] = "One or more required fields are empty or not correctly filled hello";
            //$json['status'] = 0;
        }
        //$json['msg'] = "One or more required fields are empty or not correctly filled hello";
        //$json['status'] = 0;
                    
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
        
    }
        public function add(){
        $this->genlib->ajaxOnly();
        
        //$this->load->library('form_validation');

        //$this->form_validation->set_error_delimiters('', '');
        
        
        //$this->form_validation->set_rules('fullName', 'Full Name', ['trim', 'required', 'strtolower'],['required'=>"required"]);

        //$this->form_validation->set_rules('username', 'Username', ['trim', 'required','strtolower'], 
        //        ['required'=>"required"]);

        //$this->form_validation->set_rules('role', 'Role', ['required'], ['required'=>"required"]);
        //$this->form_validation->set_rules('mobile1', 'Phone number', ['required', 'trim', 'numeric'],['required'=>"required"]);
        //$this->form_validation->set_rules('mobile2', 'Other number', ['trim', 'numeric']);

        //$this->form_validation->set_rules('passwordOrig', 'Password', ['required', 'min_length[8]'], ['required'=>"Enter password"]);
        //$this->form_validation->set_rules('passwordDup', 'Password Confirmation', ['required', 'matches[passwordOrig]'], ['required'=>"Please retype password"]);
        //$json = ['status'=>1, 'msg'=>"Admin account successfully created"] ;

        //$this->output->set_content_type('application/json')->set_output(json_encode($json));
        //$data['id'] = $this->input->post('id');
        $fullName = $this->input->post('fullName');
        $username = $this->input->post('username');
        $role = $this->input->post('role');
        $mobile1 = $this->input->post('mobile1');
        $mobile2 = $this->input->post('mobile2');
        $passwordOrig = $this->input->post('passwordOrig');
        //$mobile1 = $this->input->post('mobile1');
        //$data['outstandingBalance'] = $this->input->post('outstandingBalance');
        //$data['lastPayment'] = $this->input->post('lastPayment');
        //$data['lastPaymentDate'] = $this->input->post('lastPaymentDate');
        
        if(TRUE){
            /**
             * insert info into db
             * function header: add($f_name, $l_name, $email, $password, $role, $mobile1, $mobile2)
             */

            $hashedPassword = password_hash($passwordOrig, PASSWORD_BCRYPT);
            
            $inserted = $this->admin->add($fullName, $username, $hashedPassword,
                $role, $mobile1 ,$mobile2);
            
            
            $json = $inserted ? 
                ['status'=>1, 'msg'=>"Admin account successfully created"] 
                : 
                ['status'=>0, 'msg'=>"Oops! Unexpected server error! Pls contact administrator for help. Sorry for the embarrassment"];
        }
        
        else{
            //return all error messages
            //$json['errors'] = $this->form_validation->error_array();//get an array of all errors
            
            
        }
                    
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
        
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
    public function update(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('fullName', 'Full name', ['required', 'trim', 'max_length[20]'], ['required'=>"required"]);
        $this->form_validation->set_rules('mobile1', 'Phone number', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('mobile2', 'Other number', ['trim', 'numeric']);
        $this->form_validation->set_rules('username', 'Username', ['required', 'trim', 'callback_crosscheckUsername['. $this->input->post('adminId', TRUE).']']);
        $this->form_validation->set_rules('role', 'Role', ['required', 'trim'], ['required'=>"required"]);
        
        if($this->form_validation->run() !== FALSE){
            /**
             * update info in db
             * function header: update($admin_id, $first_name, $last_name, $email, $mobile1, $mobile2, $role)
             */
				
            $admin_id = $this->input->post('adminId', TRUE);

            $updated = $this->admin->update($admin_id, set_value('fullName'), set_value('username'),set_value('mobile1'),set_value('mobile2'),set_value('role'));
            
            
            $json = $updated ? 
                    ['status'=>1, 'msg'=>"Admin info successfully updated"] 
                    : 
                    ['status'=>0, 'msg'=>"Oops! Unexpected server error! Pls contact administrator for help. Sorry for the embarrassment"];
        }
        
        else{
            //return all error messages
            $json = $this->form_validation->error_array();//get an array of all errors
            
            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json['status'] = 0;
        }
                    
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    public function suspend(){
        $this->genlib->ajaxOnly();
        
        $admin_id = $this->input->post('_aId');
        $new_status = $this->genmod->gettablecol('admin', 'account_status', 'id', $admin_id) == 1 ? 0 : 1;
        
        $done = $this->admin->suspend($admin_id, $new_status);
        
        $json['status'] = $done ? 1 : 0;
        $json['_ns'] = $new_status;
        $json['_aId'] = $admin_id;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function delete(){
        $this->genlib->ajaxOnly();
        
        $admin_id = $this->input->post('_aId');
        $new_value = $this->genmod->gettablecol('admin', 'deleted', 'id', $admin_id) == 1 ? 0 : 1;
        
        $done = $this->admin->delete($admin_id, $new_value);
        
        $json['status'] = $done ? 1 : 0;
        $json['_nv'] = $new_value;
        $json['_aId'] = $admin_id;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * Used as a callback while updating admin info to ensure 'mobile1' field does not contain a number already used by another admin
     * @param type $mobile_number
     * @param type $admin_id
     */
    public function crosscheckMobile($mobile_number, $admin_id){
        //check db to ensure number was previously used for admin with $admin_id i.e. the same admin we're updating his details
        $adminWithNum = $this->genmod->getTableCol('admin', 'id', 'mobile1', $mobile_number);
        
        if($adminWithNum == $admin_id){
            //used for same admin. All is well.
            return TRUE;
        }
        
        else{
            $this->form_validation->set_message('crosscheckMobile', 'This number is already attached to an administrator');
                
            return FALSE;
        }
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * Used as a callback while updating admin info to ensure 'email' field does not contain an email already used by another admin
     * @param type $email
     * @param type $admin_id
     */
    public function crosscheckUsername($username, $admin_id){
        //check db to ensure email was previously used for admin with $admin_id i.e. the same admin we're updating his details
        $adminWithEmail = $this->genmod->getTableCol('admin', 'id', 'username', $username);
        
        if($adminWithEmail == $admin_id){
            //used for same admin. All is well.
            return TRUE;
        }
        
        else{
            $this->form_validation->set_message('crosscheckUsername', 'This username is already attached to an administrator');
                
            return FALSE;
        }
    }
    
}