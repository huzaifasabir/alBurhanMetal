 
<?php

class Titles extends CI_Model {

    /*
    return all Titless.
    created by your name
    created at 18-10-20.
    */
    public function getAll() {
        return $this->db->get('titles')->result();
    }
    /*
    function for create Titles.
    return Titles inserted id.
    created by your name
    created at 18-10-20.
    */
    public function insert($data) {
        $this->db->insert('titles', $data);
        return $this->db->insert_id();
    }
    /*
    return Titles by id.
    created by your name
    created at 18-10-20.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('titles')->result();
    }
    /*
    function for update Titles.
    return true.
    created by your name
    created at 18-10-20.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('titles', $data);
        return true;
    }
    /*
    function for delete Titles.
    return true.
    created by your name
    created at 18-10-20.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('titles');
        return true;
    }
    /*
    function for change status of Titles.
    return activated of deactivated.
    created by your name
    created at 18-10-20.
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