<?php

class HomeExpense extends CI_Model {

    /*
    return all Expenses.
    created by your name
    created at 01-07-20.
    */
    //public function getAll() {
    //    return $this->db->get('expense')->result();
    //}
    /*
    function for create Expense.
    return Expense inserted id.
    created by your name
    created at 01-07-20.
    */
    public function insert($data) {
        $this->db->insert('homeExpense', $data);
        return $this->db->insert_id();
    }


    public function countAll($flag=''){
        

        
            $this->db->where('type', $flag);
            $expense = $this->db->get('accountTransactions');
            $run_q = $expense->num_rows();

        
        
        
        
        
            return $run_q;
    }
    public function expensesearch($value, $flag){
        //$q = "SELECT * FROM products 
        //    WHERE 
        //    (name LIKE '%".$this->db->escape_like_str($value)."%'
        //    || 
        //    code LIKE '%".$this->db->escape_like_str($value)."%')";
        if($flag === 'shopExpense' ){
            $this->db->like('referenceNo', $value);    
        }
        else{
            $this->db->like('referenceNo', $value);    
        }
        
        $this->db->where('type', $flag);
        
        
        $run_q = $this->db->get('accountTransactions');//$this->db->query($q, [$flag,$value, $value]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    public function getAll($orderBy, $orderFormat, $start, $limit, $flag){
        

            $this->db->limit($limit, $start);
            $this->db->order_by($orderBy, $orderFormat);
            $this->db->where('type', $flag);
            $expense = $this->db->get('accountTransactions');
            

        
        
        
        
            return $expense->result();
    }
    public function getAllCategory() {
        return $this->db->get('homeExpense')->result();
    }
    /*
    return Expense by id.
    created by your name
    created at 01-07-20.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('homeExpense')->result();
    }
    /*
    function for update Expense.
    return true.
    created by your name
    created at 01-07-20.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('homeExpense', $data);
        return true;
    }
    /*
    function for delete Expense.
    return true.
    created by your name
    created at 01-07-20.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('homeExpense');
        return true;
    }
    /*
    function for change status of Expense.
    return activated of deactivated.
    created by your name
    created at 01-07-20.
    */
    public function changeStatus($id) {
        $table=$this->getDataById($id);
             if($table[0]->status==0)
             {
                $this->update($id,array('status' => '1'));
                return "Activated";
             }else{
                $this->update($id,array('status' => '0'));
                return "Deactivated";
             }
    }

}