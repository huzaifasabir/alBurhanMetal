<?php


class BatchController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('batch');
        $this->load->library('session');
    }
    /*
    function for manage Batch.
    return all Batchs.
    created by your name
    created at 13-01-22.
	santosh salve
    */
    public function manageBatch() { 
        $data['batchs'] = $this->batch->getAll();
        $this->load->view('batch/manage-batch', $data);
    }
    /*
    function for  add Batch get
    created by your name
    created at 13-01-22.
    */
    public function addBatch() {
        $this->load->view('batch/add-batch');
    }
    /*
    function for add Batch post
    created by your name
    created at 13-01-22.
    */
    public function addBatchPost() {
        $data['cust_id'] = $this->input->post('cust_id');
        $data['batch_no'] = $this->input->post('batch_no');
        $data['date'] = $this->input->post('date');
        $data['purchase_order_no'] = $this->input->post('purchase_order_no');
        $data['brand_top'] = $this->input->post('brand_top');
        $data['color'] = $this->input->post('color');
        $data['crown_type'] = $this->input->post('crown_type');
        $data['liner_material'] = $this->input->post('liner_material');
        $data['sheet_type'] = $this->input->post('sheet_type');
        $data['quantity'] = $this->input->post('quantity');
        $data['due_date'] = $this->input->post('due_date');
        $data['no_cases'] = $this->input->post('no_cases');
        $data['ups'] = $this->input->post('ups');
        $data['total_sheets'] = $this->input->post('total_sheets');
    $this->batch->insert($data);
        $this->session->set_flashdata('success', 'Batch added Successfully');
        redirect('manage-batch');
    }
    /*
    function for edit Batch get
    returns  Batch by id.
    created by your name
    created at 13-01-22.
    */
    public function editBatch($batch_id) {
        $data['batch_id'] = $batch_id;
        $data['batch'] = $this->batch->getDataById($batch_id);
        $this->load->view('batch/edit-batch', $data);
    }
    /*
    function for edit Batch post
    created by your name
    created at 13-01-22.
    */
    public function editBatchPost() {
        $batch_id = $this->input->post('batch_id');
        $batch = $this->batch->getDataById($batch_id);
        $data['cust_id'] = $this->input->post('cust_id');
        $data['batch_no'] = $this->input->post('batch_no');
        $data['date'] = $this->input->post('date');
        $data['purchase_order_no'] = $this->input->post('purchase_order_no');
        $data['brand_top'] = $this->input->post('brand_top');
        $data['color'] = $this->input->post('color');
        $data['crown_type'] = $this->input->post('crown_type');
        $data['liner_material'] = $this->input->post('liner_material');
        $data['sheet_type'] = $this->input->post('sheet_type');
        $data['quantity'] = $this->input->post('quantity');
        $data['due_date'] = $this->input->post('due_date');
        $data['no_cases'] = $this->input->post('no_cases');
        $data['ups'] = $this->input->post('ups');
        $data['total_sheets'] = $this->input->post('total_sheets');
    $edit = $this->batch->update($batch_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Batch Updated');
            redirect('manage-batch');
        }
    }
    /*
    function for view Batch get
    created by your name
    created at 13-01-22.
    */
    public function viewBatch($batch_id) {
        $data['batch_id'] = $batch_id;
        $data['batch'] = $this->batch->getDataById($batch_id);
        $this->load->view('batch/view-batch', $data);
    }
    /*
    function for delete Batch    created by your name
    created at 13-01-22.
    */
    public function deleteBatch($batch_id) {
        $delete = $this->batch->delete($batch_id);
        $this->session->set_flashdata('success', 'batch deleted');
        redirect('manage-batch');
    }
    /*
    function for activation and deactivation of Batch.
    created by your name
    created at 13-01-22.
    */
    public function changeStatusBatch($batch_id) {
        $edit = $this->batch->changeStatus($batch_id);
        $this->session->set_flashdata('success', 'batch '.$edit.' Successfully');
        redirect('manage-batch');
    }
    
}