<?php


class AccountsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['account','AccountsTransaction']);
        $this->load->library('session');
    }
    /*
    function for manage Accounts.
    return all Accountss.
    created by your name
    created at 30-06-20.
    */
    public function manageAccounts() { 
        $data1["accountss"] = $this->account->getAll1();
        
        //$data1["customerss"] = $this->customer->getAll();
        $data['pageContent'] = $this->load->view('accounts/manage-accounts', $data1, TRUE);

        $data['pageTitle'] = "Accounts";

        $this->load->view('main', $data);
    }
    /*
    function for  add Accounts get
    created by your name
    created at 30-06-20.
    */
    public function addAccounts() {
        $data['pageContent'] = $this->load->view('accounts/add-accounts','',TRUE);

        $data['pageTitle'] = "Accounts";

        $this->load->view('main', $data);
        //$this->load->view('accounts/add-accounts');
    }
    /*
    function for add Accounts post
    created by your name
    created at 30-06-20.
    */
    public function addAccountsPost() {
        //$data['id'] = $this->input->post('id');
        $data['accName'] = $this->input->post('accName');
        $data['pageNo'] = $this->input->post('pageNo');
        $data['balance'] = $this->input->post('balance');
        $data['type'] = $this->input->post('type');
        //$data['lastUpdate'] = date('y-m-d');;
        $data['dateCreated'] = date('y-m-d');
        $this->account->insert($data);
        $this->session->set_flashdata('success', 'Accounts added Successfully');
        redirect('manage-accounts');
    }
    /*
    function for edit Accounts get
    returns  Accounts by id.
    created by your name
    created at 30-06-20.
    */
    public function editAccounts($accounts_id) {
        $data1['accounts_id'] = $accounts_id;
        $data1['accounts'] = $this->account->getDataById($accounts_id);
        $data['pageContent'] = $this->load->view('accounts/edit-accounts', $data1, TRUE);
        $data['pageTitle'] = "Accounts";

        $this->load->view('main', $data);

    }
    /*
    function for edit Accounts post
    created by your name
    created at 30-06-20.
    */
    public function editAccountsPost() {
        $accounts_id = $this->input->post('accounts_id');
        //echo $accounts_id;
        $accounts = $this->account->getDataById($accounts_id);
        //$data['id'] = $this->input->post('id');
        $data['accName'] = $this->input->post('accName');
        $data['pageNo'] = $this->input->post('pageNo');
        $data['balance'] = $this->input->post('balance');
        $data['type'] = $this->input->post('type');
        //$data['lastUpdate'] = date('y-m-d');
        //$data['dateCreated'] = $this->input->post('dateCreated');
        $edit = $this->account->update($accounts_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Accounts Updated');
            redirect('manage-accounts');
        }
    }
    /*
    function for view Accounts get
    created by your name
    created at 30-06-20.
    */
    public function viewAccounts($accounts_id) {
        $data['accounts_id'] = $accounts_id;
        $data['accounts'] = $this->account->getDataById($accounts_id);
        //$this->load->view('accounts/view-accounts', $data);

        
        $accountName = $data['accounts'][0]->accName;
        $data1['sn'] = 1;
        $data1['accName'] = $accountName;
        $data1['pageNo'] = $data['accounts'][0]->pageNo;
        $data1['type'] = $data['accounts'][0]->type;
        $data1['balance'] = $data['accounts'][0]->balance;
        //$data1['vendorPurchase'] = $this->item->getPurchaseVendor($companyName);
        if($accountName === 'Cash In Hand'){
            $data1['accountTransactions'] = $this->AccountsTransaction->cashInHandTrans($accountName);
        }else{
            $data1['accountTransactions'] = $this->AccountsTransaction->accountTrans1($accountName);
        }
        

        //$id$this->genmod->getTableCol('vendors', 'id', 'companyName', $companyName);
        $data['pageContent'] = $this->load->view('accounts/view-accounts', $data1, TRUE);
        $data['pageTitle'] = "Accounts";

        $this->load->view('main', $data);


    }
    /*
    function for delete Accounts    created by your name
    created at 30-06-20.
    */
    public function deleteAccounts($accounts_id) {
        $delete = $this->account->delete($accounts_id);
        $this->session->set_flashdata('success', 'accounts deleted');
        redirect('manage-accounts');
    }
    /*
    function for activation and deactivation of Accounts.
    created by your name
    created at 30-06-20.
    */
    public function changeStatusAccounts($accounts_id) {
        $edit = $this->account->changeStatus($accounts_id);
        $this->session->set_flashdata('success', 'accounts '.$edit.' Successfully');
        redirect('manage-accounts');
    }
    
}