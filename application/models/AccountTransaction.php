<?php
defined('BASEPATH') OR exit('');

/**
 * Description of Customer
 *
 * @author Amir <amirsanni@gmail.com>
 * @date 4th RabThaani, 1437AH (15th Jan, 2016)
 */
class AccountTransaction extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function addTransaction($data){

        $this->db->insert('accountTransactions', $data);
        
        if($this->db->insert_id()){
            return $this->db->insert_id();
        }
        
        else{
            return FALSE;
        }

    }
        public function addExpense($data){

        $this->db->insert('expense', $data);
        
        if($this->db->insert_id()){
            return $this->db->insert_id();
        }
        
        else{
            return FALSE;
        }

    }
    
    public function getIndividualInstallment($loanAcc, $loanType, $description){
        $q = "SELECT * FROM loanTransaction WHERE loanAccNo = ? AND loanType = ? AND description = ?";
        
        $run_q = $this->db->query($q, [$loanAcc, $loanType, $description]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    public function getCollectiveInstallment( $installmentDate, $loanType, $description){
        $q = "SELECT * FROM loanTransaction WHERE installmentDate = ? AND loanType = ? AND description = ?";
        //$q = "SELECT * FROM loanTransaction WHERE loanAccNo = ? AND loanType = ? AND description = ?";
       
        
        $run_q = $this->db->query($q, [$installmentDate, $loanType, $description]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

    public function getMissingInstallment( $installmentDate, $loanType){
        $q = "SELECT * FROM employee_detail WHERE lastInstallmentDate != ? AND loanType = ? ";
        //$q = "SELECT * FROM loanTransaction WHERE loanAccNo = ? AND loanType = ? AND description = ?";
       
        
        $run_q = $this->db->query($q, [$installmentDate, $loanType]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    public function getLiabilityStatement($loanAcc){
        $q = "SELECT * FROM employee_detail WHERE loanAcNo = ?";
        //$q = "SELECT * FROM loanTransaction WHERE loanAccNo = ? AND loanType = ? AND description = ?";
       
        
        $run_q = $this->db->query($q, [$loanAcc]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

    public function getAccountStatementDetails($loanAcc, $loanType){
        $q = "SELECT * FROM employee_detail WHERE loanAcNo = ? AND loanType = ?";
        //$q1 = "SELECT * FROM loanTransaction WHERE loanAccNo = ? AND loanType = ?";
       
        
        $run_q = $this->db->query($q, [$loanAcc, $loanType]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    public function getAccountStatementTransactions($loanAcc, $loanType){
        //$q = "SELECT * FROM employee_detail WHERE loanAcNo = ? AND loanType = ?";
        $q = "SELECT * FROM loanTransaction WHERE loanAccNo = ? AND loanType = ?";
       
        
        $run_q = $this->db->query($q, [$loanAcc, $loanType]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

    public function getAll($orderBy, $orderFormat, $start=0, $limit=''){
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);
        
        $run_q = $this->db->get('items');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /**
     * 
     * @param type $itemName
     * @param type $itemQuantity
     * @param type $itemPrice
     * @param type $costPrice
     * @param type $itemDescription
     * @param type $itemCode
     * @return boolean
     */
    public function add($data){
                        
                
        
        //debug_to_console("Test");

        $this->db->insert('loanTransaction', $data);
        
        if($this->db->insert_id()){
            return $this->db->insert_id();
        }
        
        else{
            return FALSE;
        }
    }

    public function updateMarkup_n_principal($sapId, $loanType, $currentMarkup, $currentPrincipal, $lastInstallmentDate){
       $q = "UPDATE employee_detail SET currentMarkup = ?, currentPrincipal = ? , lastInstallmentDate= ? WHERE sapId = ? AND loanType = ?";
       
       $this->db->query($q, [$currentMarkup, $currentPrincipal,$lastInstallmentDate, $sapId, $loanType]);
       
       if($this->db->affected_rows()){
           return TRUE;
       }
       
       else{
           return FALSE;
       }
    }


    public function updateAddress($sapId, $loanType, $address){
       $q = "UPDATE employee_detail SET addressProperty = ? WHERE sapId = ? AND loanType = ?";
       
       $this->db->query($q, [$address,  $sapId, $loanType]);
       
       if($this->db->affected_rows()){
           return TRUE;
       }
       
       else{
           return FALSE;
       }
    }


    public function debug_to_console($data) {
        

        echo "<script>console.log('Debug Objects: " . $data . "' );</script>";
    }
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * 
     * @param type $value
     * @return boolean
     */
    public function itemsearch($value){
        $q = "SELECT * FROM items 
            WHERE 
            name LIKE '%".$this->db->escape_like_str($value)."%'
            || 
            code LIKE '%".$this->db->escape_like_str($value)."%'";
        
        $run_q = $this->db->query($q, [$value, $value]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * To add to the number of an item in stock
     * @param type $itemId
     * @param type $numberToadd
     * @return boolean
     */
    public function incrementItem($itemId, $numberToadd){
        $q = "UPDATE items SET quantity = quantity + ? WHERE id = ?";
        
        $this->db->query($q, [$numberToadd, $itemId]);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function decrementItem($itemCode, $numberToRemove){
        $q = "UPDATE items SET quantity = quantity - ? WHERE code = ?";
        
        $this->db->query($q, [$numberToRemove, $itemCode]);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
   public function newstock($itemId, $qty){
       $q = "UPDATE items SET quantity = quantity + $qty WHERE id = ?";
       
       $this->db->query($q, [$itemId]);
       
       if($this->db->affected_rows()){
           return TRUE;
       }
       
       else{
           return FALSE;
       }
   }
   
   
   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
   public function deficit($itemId, $qty){
       $q = "UPDATE items SET quantity = quantity - $qty WHERE id = ?";
       
       $this->db->query($q, [$itemId]);
       
       if($this->db->affected_rows()){
           return TRUE;
       }
       
       else{
           return FALSE;
       }
   }
   
   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
   /**
    * 
    * @param type $itemId
    * @param type $itemName
    * @param type $itemDesc
    * @param type $itemPrice
    * @param type $costPrice
    */
   public function edit($itemId, $itemName, $itemDesc, $itemPrice, $costPrice){
       $data = ['name'=>$itemName, 'unitPrice'=>$itemPrice,'costPrice'=>$costPrice, 'description'=>$itemDesc];
       
       $this->db->where('id', $itemId);
       $this->db->update('items', $data);
       
       return TRUE;
   }
   
   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
	public function getActiveItems($orderBy, $orderFormat){
        $this->db->order_by($orderBy, $orderFormat);
		
		$this->db->where('quantity >=', 1);
        
        $run_q = $this->db->get('items');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }


    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    /**
     * array $where_clause
     * array $fields_to_fetch
     * 
     * return array | FALSE
     */
    public function getItemInfo($where_clause, $fields_to_fetch){
        $this->db->select($fields_to_fetch);
        
        $this->db->where($where_clause);

        $run_q = $this->db->get('items');
        
        return $run_q->num_rows() ? $run_q->row() : FALSE;
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function getItemsCumTotal(){
        $this->db->select("SUM(unitPrice*quantity) as cumPrice");

        $run_q = $this->db->get('items');
        
        return $run_q->num_rows() ? $run_q->row()->cumPrice : FALSE;
    }
}