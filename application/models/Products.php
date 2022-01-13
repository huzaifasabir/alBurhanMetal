<?php

class Products extends CI_Model {

    /*
    return all Productss.
    created by your name
    created at 22-07-20.
    */
    public function getAll() {
        return $this->db->get('products')->result();
    }

    public function getTotalInventory() {
        

        //$this->db->where('accName !=', 'factory');
        $this->db->select('SUM(totalValue) as sum1');

        return $this->db->get('products')->result();
    }

    /*
    function for create Products.
    return Products inserted id.
    created by your name
    created at 22-07-20.
    */
    public function insert($data) {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }
    /*
    return Products by id.
    created by your name
    created at 22-07-20.
    */
    public function getDataById($id) {
        $this->db->where('code', $id);
        return $this->db->get('products')->result();
    }
    /*
    function for update Products.
    return true.
    created by your name
    created at 22-07-20.
    */
    public function update($id,$data) {
        $this->db->where('code', $id);
        $this->db->update('products', $data);
        return true;
    }
    /*
    function for delete Products.
    return true.
    created by your name
    created at 22-07-20.
    */
    public function delete($id) {
        $this->db->where('code', $id);
        $this->db->delete('products');
        return true;
    }
    /*
    function for change status of Products.
    return activated of deactivated.
    created by your name
    created at 22-07-20.
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