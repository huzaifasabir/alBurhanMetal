<?php


class CustomersController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->genlib->checkLogin();
        $this->load->model(['customer','item','transaction','AccountsTransaction']);
        $this->load->library('session');
    }



    public function gcoandqty(){
        $json['status'] = 0;
        
        $customerId = $this->input->get('customerId', TRUE);
        
        if($customerId){
            $customer_info = $this->customer->getCustomerInfo(['id'=>$customerId], ['customerName', 'phone', 'email','address','outstandingBalance']);
            //$json['status'] = 1;
            if($customer_info){
                $json['info'] = $customer_info;
                //$json['customerName'] = $item_info->customerName;
                //$json['unitPrice'] = $item_info->unitPrice;
                //$json['phone'] = $item_info->phone;
                //$json['email'] = $item_info->email;
                //$json['address'] = $item_info->address;
                $json['status'] = 1;
            }
        }

        
        //$json['customerId'] = $customerId;
        //$json['status'] = 1;
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    /*
    function for manage Customers.
    return all Customerss.
    created by your name
    created at 30-06-20.
    */
    public function manageCustomers() { 
        $data1["customerss"] = $this->customer->getAll();
        $customerTotal = $this->customer->getTotalBalance();
        $data1["customerTotal"] = $customerTotal[0]->sum1;
        $data['pageContent'] = $this->load->view('customers/manage-customers', $data1, TRUE);

        $data['pageTitle'] = "Customers";

        $this->load->view('main', $data);
    }
    /*
    function for  add Customers get
    created by your name
    created at 30-06-20.
    */
    public function addCustomers() {
        $data['pageContent'] = $this->load->view('customers/add-customers','', TRUE);
        $data['pageTitle'] = "Customers";

        $this->load->view('main', $data);
        
    }
    /*
    function for add Customers post
    created by your name
    created at 30-06-20.
    */
    public function addCustomersPost() {
        //$data['id'] = $this->input->post('id');
        $data['customerName'] = $this->input->post('customerName');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['address'] = $this->input->post('address');
        $data['outstandingBalance'] = $this->input->post('outstandingBalance');
        $data['lastPayment'] = $this->input->post('lastPayment');
        $data['lastPaymentDate'] = $this->input->post('lastPaymentDate');
        $this->customer->insert($data);
        $this->session->set_flashdata('success', 'Customers added Successfully');
        redirect('manage-customers');
    }
    /*
    function for edit Customers get
    returns  Customers by id.
    created by your name
    created at 30-06-20.
    */
    public function editCustomers($customers_id) {
        $data1['customers_id'] = $customers_id;
        $data1['customers'] = $this->customer->getDataById($customers_id);
        

        $data['pageContent'] = $this->load->view('customers/edit-customers', $data1, TRUE);

        $data['pageTitle'] = "Customers";

        $this->load->view('main', $data);
    }
    /*
    function for edit Customers post
    created by your name
    created at 30-06-20.
    */
    public function editCustomersPost() {
        $customers_id = $this->input->post('customers_id');
        $customers = $this->customer->getDataById($customers_id);
        //$data['id'] = $this->input->post('id');
        $data['customerName'] = $this->input->post('customerName');
        $data['phone'] = $this->input->post('phone');
        $data['email'] = $this->input->post('email');
        $data['address'] = $this->input->post('address');
        $data['outstandingBalance'] = $this->input->post('outstandingBalance');
        $data['lastPayment'] = $this->input->post('lastPayment');
        $data['lastPaymentDate'] = $this->input->post('lastPaymentDate');
    $edit = $this->customer->update($customers_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Customers Updated');
            redirect('manage-customers');
        }
    }
    /*
    function for view Customers get
    created by your name
    created at 30-06-20.
    */
    public function viewCustomers($customers_id) {
        $data['customers_id'] = $customers_id;
        $data['customers'] = $this->customer->getDataById($customers_id);

        $customerName = $data['customers'][0]->customerName;
        $data1['sn'] = 1;
        $data1['customerPurchase'] = $this->transaction->getPurchaseCustomer($customerName);
        $data1['customerReturns'] = $this->transaction->getReturnCustomer($customerName);
        $data1['customerTransactions'] = $this->AccountsTransaction->customerTransactions($customerName);
        $data1['customerLedger'] = $this->customer->getLedgerCustomer($customerName);
        $data1['outstandingBalance'] = $data['customers'][0]->outstandingBalance;
        $data1['customerName'] = $customerName;
        //$data1['']
        //$id$this->genmod->getTableCol('vendors', 'id', 'companyName', $companyName);
        $data['pageContent'] = $this->load->view('customers/customerTransTable', $data1, TRUE);
        $data['pageTitle'] = "Customers";

        $this->load->view('main', $data);
    }
    /*
    function for delete Customers    created by your name
    created at 30-06-20.
    */
    public function deleteCustomers($customers_id) {
        $delete = $this->customer->delete($customers_id);
        $this->session->set_flashdata('success', 'customers deleted');
        redirect('manage-customers');
    }
    /*
    function for activation and deactivation of Customers.
    created by your name
    created at 30-06-20.
    */
    public function changeStatusCustomers($customers_id) {
        $edit = $this->customer->changeStatus($customers_id);
        $this->session->set_flashdata('success', 'customers '.$edit.' Successfully');
        redirect('manage-customers');
    }
    
}