<?php

class Batch extends CI_Model {

    /*
    return all Batchs.
    created by your name
    created at 13-01-22.
    */
    public function getAll() {
        return $this->db->get('batch')->result();
    }
    /*
    function for create Batch.
    return Batch inserted id.
    created by your name
    created at 13-01-22.
    */
    public function insert($data) {
        $this->db->insert('batch', $data);
        return $this->db->insert_id();
    }
    /*
    return Batch by id.
    created by your name
    created at 13-01-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('batch')->result();
    }
    /*
    function for update Batch.
    return true.
    created by your name
    created at 13-01-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('batch', $data);
        return true;
    }
    /*
    function for delete Batch.
    return true.
    created by your name
    created at 13-01-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('batch');
        return true;
    }
    /*
    function for change status of Batch.
    return activated of deactivated.
    created by your name
    created at 13-01-22.
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