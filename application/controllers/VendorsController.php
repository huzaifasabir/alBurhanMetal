<?php


class VendorsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['vendor','item','AccountsTransaction']);
        $this->load->library('session');
    }
    /*
    function for manage Vendors.
    return all Vendorss.
    created by your name
    created at 22-07-20.
    */
    public function manageVendors() { 
        $data1["vendorss"] = $this->vendor->getAllVendors();
        $vendorTotal = $this->vendor->getTotalBalance();
        $data1["vendorTotal"] = $vendorTotal[0]->sum1;
        $data['pageContent'] = $this->load->view('vendors/manage-vendors', $data1, TRUE);
        $data['pageTitle'] = "Vendors";

        $this->load->view('main', $data);
    }
    /*
    function for  add Vendors get
    created by your name
    created at 22-07-20.
    */
    public function addVendors() {
        $this->load->view('vendors/add-vendors');
    }
    /*
    function for add Vendors post
    created by your name
    created at 22-07-20.
    */
    public function addVendorsPost() {
        $data['companyName'] = $this->input->post('companyName');
        $data['pageNo'] = $this->input->post('pageNo');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['outstandingBalance'] = $this->input->post('outstandingBalance');
        $data['salesRepresentative'] = $this->input->post('salesRepresentative');
        $data['address'] = $this->input->post('address');
    $this->vendor->insert($data);
        $this->session->set_flashdata('success', 'Vendors added Successfully');
        redirect('manage-vendors');
    }
    /*
    function for edit Vendors get
    returns  Vendors by id.
    created by your name
    created at 22-07-20.
    */
    public function editVendors($vendors_id) {
        $data1['vendors_id'] = $vendors_id;
        $data1['vendors'] = $this->vendor->getDataById($vendors_id);
        
        
        
        $data['pageContent'] = $this->load->view('vendors/edit-vendors', $data1, TRUE);
        $data['pageTitle'] = "Vendors";

        $this->load->view('main', $data);

    }
    /*
    function for edit Vendors post
    created by your name
    created at 22-07-20.
    */
    public function editVendorsPost() {
        $vendors_id = $this->input->post('vendors_id');
        $vendors = $this->vendor->getDataById($vendors_id);
        $data['companyName'] = $this->input->post('companyName');
        $data['pageNo'] = $this->input->post('pageNo');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['outstandingBalance'] = $this->input->post('outstandingBalance');
        $data['salesRepresentative'] = $this->input->post('salesRepresentative');
        $data['address'] = $this->input->post('address');
        $edit = $this->vendor->update($vendors_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Vendors Updated');
            redirect('manage-vendors');
        }
    }
    /*
    function for view Vendors get
    created by your name
    created at 22-07-20.
    */
    public function viewVendors($vendors_id) {
        $data['vendors_id'] = $vendors_id;
        $data['vendors'] = $this->vendor->getDataById($vendors_id);
        $companyName = $data['vendors'][0]->companyName;
        $data1['sn'] = 1;
        $data1['vendorPurchase'] = $this->item->getPurchaseVendor($companyName);
        $data1['vendorTransactions'] = $this->AccountsTransaction->vendorTransactions($companyName);
        $data1['vendorLedger'] = $this->vendor->getLedgerVendor($companyName);

        $data1['outstandingBalance'] = $data['vendors'][0]->outstandingBalance;
        $data1['customerName'] = $companyName;
        //$id$this->genmod->getTableCol('vendors', 'id', 'companyName', $companyName);
        $data['pageContent'] = $this->load->view('vendors/purchaseTableVendor', $data1, TRUE);
        $data['pageTitle'] = "Vendors";

        $this->load->view('main', $data);
        //$this->load->view('vendors/view-vendors', $data);
    }
    /*
    function for delete Vendors    created by your name
    created at 22-07-20.
    */
    public function deleteVendors($vendors_id) {
        $delete = $this->vendor->delete($vendors_id);
        $this->session->set_flashdata('success', 'vendors deleted');
        redirect('manage-vendors');
    }
    /*
    function for activation and deactivation of Vendors.
    created by your name
    created at 22-07-20.
    */
    public function changeStatusVendors($vendors_id) {
        $edit = $this->vendor->changeStatus($vendors_id);
        $this->session->set_flashdata('success', 'vendors '.$edit.' Successfully');
        redirect('manage-vendors');
    }
    
}