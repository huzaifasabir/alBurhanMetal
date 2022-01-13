<?php


class ExpenseController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('expense');
        $this->load->library('session');
    }
    /*
    function for manage Expense.
    return all Expenses.
    created by your name
    created at 31-08-20.
    */
    public function manageExpense() { 

        $data1["expenses"] = $this->expense->getAllCategory();
        
        $data['pageContent'] = $this->load->view('expense/manage-expense', $data1, TRUE);
        $data['pageTitle'] = "Expense";

        $this->load->view('main', $data);
        
       // $this->load->view('expense/manage-expense', $data);
    }
    /*
    function for  add Expense get
    created by your name
    created at 31-08-20.
    */
    public function addExpense() {
        $data['pageContent'] = $this->load->view('expense/add-expense','', TRUE);
        $data['pageTitle'] = "Expense";
        $this->load->view('main', $data);

    }
    /*
    function for add Expense post
    created by your name
    created at 31-08-20.
    */
    public function addExpensePost() {
        $data['id'] = $this->input->post('id');
        $data['category'] = $this->input->post('category');
    $this->expense->insert($data);
        $this->session->set_flashdata('success', 'Expense added Successfully');
        redirect('manage-expense');
    }
    /*
    function for edit Expense get
    returns  Expense by id.
    created by your name
    created at 31-08-20.
    */
    public function editExpense($expense_id) {
        $data1['expense_id'] = $expense_id;
        $data1['expense'] = $this->expense->getDataById($expense_id);
        //$this->load->view('expense/edit-expense', $data);
        $data['pageContent'] = $this->load->view('expense/edit-expense', $data1, TRUE);
        $data['pageTitle'] = "Expense";
        $this->load->view('main', $data);

    }
    /*
    function for edit Expense post
    created by your name
    created at 31-08-20.
    */
    public function editExpensePost() {
        $expense_id = $this->input->post('expense_id');
        $expense = $this->expense->getDataById($expense_id);
        $data['id'] = $this->input->post('id');
        $data['category'] = $this->input->post('category');
    $edit = $this->expense->update($expense_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Expense Updated');
            redirect('manage-expense');
        }
    }
    /*
    function for view Expense get
    created by your name
    created at 31-08-20.
    */
    public function viewExpense($expense_id) {
        $data['expense_id'] = $expense_id;
        $data['expense'] = $this->expense->getDataById($expense_id);
        $this->load->view('expense/view-expense', $data);
    }
    /*
    function for delete Expense    created by your name
    created at 31-08-20.
    */
    public function deleteExpense($expense_id) {
        $delete = $this->expense->delete($expense_id);
        $this->session->set_flashdata('success', 'expense deleted');
        redirect('manage-expense');
    }
    /*
    function for activation and deactivation of Expense.
    created by your name
    created at 31-08-20.
    */
    public function changeStatusExpense($expense_id) {
        $edit = $this->expense->changeStatus($expense_id);
        $this->session->set_flashdata('success', 'expense '.$edit.' Successfully');
        redirect('manage-expense');
    }
    
}