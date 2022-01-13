<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Search extends CI_Controller{
    protected $value;
    
    public function __construct() {
        parent::__construct();
        
        //$this->gen->checklogin();
        
        $this->genlib->ajaxOnly();
        
        $this->load->model(['transaction', 'item','admin','elog', 'expense','AccountsTransaction']);
        
        $this->load->helper('text');
        
        $this->value = $this->input->get('v', TRUE);
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    public function index(){
        /**
         * function will call models to do all kinds of search just to check whether there is a match for the searched value
         * in the search criteria or not. This applies only to global search
         */
        
        
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    public function expenseSearch(){
        $flag = $this->input->get('flag', TRUE);
        $data['allItems'] = $this->expense->expensesearch($this->value, $flag);
        $data['sn'] = 1;
        $data['cum_total'] = $this->item->getItemsCumTotal($flag);
        $data['flag'] = $flag;

        $json['itemsListTable'] = $data['allItems'] ? $this->load->view('expense/expenseslisttable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }   
    public function expenseSearchDate(){
        $flag = $this->input->get('flag', TRUE);
        $d1 = $this->input->get('d1', TRUE);
        $d2 = $this->input->get('d2', TRUE);
        $data['allItems'] = $this->expense->expensesearchdate($this->value, $flag, $d1, $d2);
        $data['sn'] = 1;
        $data['cum_total'] = $this->item->getItemsCumTotal($flag);
        $data['flag'] = $flag;

        $json['itemsListTable'] = $data['allItems'] ? $this->load->view('expense/expenseslisttable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }    
    

    public function itemSearch(){
        $flag = $this->input->get('flag', TRUE);
        $data['allItems'] = $this->item->itemsearch($this->value, $flag);
        $data['sn'] = 1;
        $data['cum_total'] = $this->item->getItemsCumTotal($flag);
        $data['flag'] = $flag;

        $json['itemsListTable'] = $data['allItems'] ? $this->load->view('items/itemslisttable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function itemSearchAll(){
        
        $category = $this->input->get('category', TRUE);
        $data['allItems'] = $this->item->itemsearchAll($this->value,$category);
        $data['sn'] = 1;
        $data['cum_total'] = $this->item->getItemsCumTotal('all');
        $data['flag'] = 'all';

        $json['itemsListTable'] = $data['allItems'] ? $this->load->view('items/itemslisttable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function itemSearchCategory(){
        $category = $this->input->get('category', TRUE);
        $data['allItems'] = $this->item->itemsearchCategory($category);
        $data['sn'] = 1;
        $data['cum_total'] = $this->item->getItemsCumTotal($category);
        $data['flag'] = 'all';

        $json['itemsListTable'] = $data['allItems'] ? $this->load->view('items/itemslisttable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    
    public function logSearch(){
        $data['allLog'] = $this->elog->logsearch($this->value);
        $data['sn'] = 1;
        
        
        $json['logListTable'] = $data['allLog'] ? $this->load->view('logs/loglisttable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    
    public function transSearch(){
        $data['allTransactions'] = $this->transaction->transsearch($this->value);
        $data['sn'] = 1;
        
        $json['transTable'] = $data['allTransactions'] ? $this->load->view('transactions/transtable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function cashTransSearch(){
        $data['allTransactions'] = $this->AccountsTransaction->cashTransSearch1($this->value);
        $data['sn'] = 1;
        
        $json['transTable'] = $data['allTransactions'] ? $this->load->view('cashbook/allCashTable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function transReturnSearch(){
        $data['allTransactions'] = $this->transaction->transReturnSearch($this->value);
        $data['sn'] = 1;
        
        $json['transTable'] = $data['allTransactions'] ? $this->load->view('transactions/returnTable', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    public function adminSearch(){
        $data['allAdministrators'] = $this->transaction->adminSearch($this->value);
        $data['sn'] = 1;
        //$json['allAdministrators'] = $this->transaction->adminSearch($this->value);
        $json['adminTable'] = $data['allAdministrators'] ? $this->load->view('admin/adminlist', $data, TRUE) : "No match found";
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function otherSearch(){
        
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
}
