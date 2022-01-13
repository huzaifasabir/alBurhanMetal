<?php

class Account extends CI_Model {

    /*
    return all Accountss.
    created by your name
    created at 30-06-20.
    */
    public function getAll1() {
        //$this->db->where('type','cash');
        return $this->db->get('accounts')->result();
    }
    public function getAll() {
        $this->db->where('type','cash');
        return $this->db->get('accounts')->result();
    }

    public function getAllPayable() {
        $this->db->where('type','payable');
        return $this->db->get('accounts')->result();
    }

    public function getAllReceivable() {
        $this->db->where('type','receivable');
        return $this->db->get('accounts')->result();
    }

    public function getCashHand($db) {
        $otherdb = $this->load->database($db, TRUE);
        $otherdb->where('accName','Cash In Hand');
        //$this->db->where('type','receivable');
        return $otherdb->get('accounts')->result();
    }





    public function getTotalCash() {
        

        $this->db->where('type','cash');
        $this->db->select('SUM(balance) as sum1');

        return $this->db->get('accounts')->result();
    }

    public function getTotalReceivable() {
        

        $this->db->where('type','receivable');
        $this->db->select('SUM(balance) as sum1');

        return $this->db->get('accounts')->result();
    }
    public function getTotalPayable() {
        

        $this->db->where('type','payable');
        $this->db->select('SUM(balance) as sum1');

        return $this->db->get('accounts')->result();
    }
    public function factoryBalance() {

        $this->db->where('accName', 'factory');
        $this->db->select('balance as sum1');
        return $this->db->get('accounts')->result();
    
    }
    /*
    function for create Accounts.
    return Accounts inserted id.
    created by your name
    created at 30-06-20.
    */
    public function insert($data) {
        $this->db->insert('accounts', $data);
        return $this->db->insert_id();
    }
    /*
    return Accounts by id.
    created by your name
    created at 30-06-20.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('accounts')->result();
    }
    /*
    function for update Accounts.
    return true.
    created by your name
    created at 30-06-20.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('accounts', $data);
        return true;
    }
    /*
    function for delete Accounts.
    return true.
    created by your name
    created at 30-06-20.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('accounts');
        return true;
    }
    /*
    function for change status of Accounts.
    return activated of deactivated.
    created by your name
    created at 30-06-20.
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