<?php

class CustomerTransaction extends CI_Model {

    /*
    return all Accountss.
    created by your name
    created at 30-06-20.
    */
    public function getAll() {
        return $this->db->get('accounts')->result();
    }
    /*
    function for create Accounts.
    return Accounts inserted id.
    created by your name
    created at 30-06-20.
    */
    public function insert($data) {
        $this->db->insert('customerTransactions', $data);
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