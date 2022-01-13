<?php
defined('BASEPATH') OR exit('');


class Vendor extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function getActive() {
        //$this->db->where('outstandingBalance >', 0);
        return $this->db->get('vendors')->result();
    }
    
    
    public function update($id,$data) {
        $this->db->where('id', $id);
        //$this->db->error();
        $update = $this->db->update('vendors', $data);
         
        return true;
    }
    public function getTotalBalance() {
        

        //$this->db->where('accName !=', 'factory');
        $this->db->select('SUM(outstandingBalance) as sum1');

        return $this->db->get('vendors')->result();
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
    public function add($companyName, $salesRepresentative, $email, $phone, $address, $outstandingBalance){
        $data = ['companyName'=>$companyName, 'salesRepresentative'=>$salesRepresentative, 'email'=>$email, 'phone'=>$phone, 'address'=>$address, 'outstandingBalance'=>$outstandingBalance];
                
        //set the datetime based on the db driver in use
        //$this->db->platform() == "sqlite3" 
                //? 
        //$this->db->set('dateAdded', "datetime('now')", FALSE) 
                //: 
        //$this->db->set('dateAdded', "NOW()", FALSE);
        
        
        //debug_to_console("Test");

        $this->db->insert('vendors', $data);
        
        if($this->db->insert_id()){
            return $this->db->insert_id();
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
    
    

    public function updateBalance($companyName, $vendorPayable){
        $q = "UPDATE vendors SET outstandingBalance = outstandingBalance + ? WHERE companyName = ?";
        
        $this->db->query($q, [$vendorPayable, $companyName]);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }
    public function getLedgerVendor($Vendor){
        $q = "SELECT  purchaseTransaction.transId, purchaseTransaction.ref, purchaseTransaction.vendor, purchaseTransaction.itemName as 'name', purchaseTransaction.fixedCostPrice as 'costPrice', purchaseTransaction.quantity as 'qty', purchaseTransaction.totalFixedCostPrice as 'amount',  purchaseTransaction.transDate,'link', 'purchase' as 'tableName' FROM purchaseTransaction WHERE purchaseTransaction.vendor = ?
UNION All
SELECT accountTransactions.transId, accountTransactions.type, accountTransactions.type,accountTransactions.description as 'desc', accountTransactions.referenceNo,  accountTransactions.creditAmount, accountTransactions.debitAmount, accountTransactions.transactionDate, accountTransactions.hlink, 'cash' as 'tableName' FROM accountTransactions
WHERE accountTransactions.type = 'vendor' AND accountTransactions.referenceNo = ?
UNION ALL
SELECT  returnPurchase.transId, returnPurchase.ref, returnPurchase.vendor, returnPurchase.itemCode as 'name', returnPurchase.unitPrice as 'costPrice', returnPurchase.quantity as 'qty', returnPurchase.totalPrice as 'amount',  returnPurchase.transDate, 'link', 'return' as 'tableName' FROM returnPurchase WHERE returnPurchase.vendor = ?
ORDER BY transDate ASC, ref ASC, transId ASC";
        
        $run_q = $this->db->query($q, [$Vendor, $Vendor, $Vendor]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }

    }
    public function decrementBalance($companyName, $amount, $transDate){
        $q = "UPDATE vendors SET outstandingBalance = outstandingBalance - ?, lastPayment = ?, lastPaymentDate = ? WHERE companyName = ?";
        
        $this->db->query($q, [$amount, $amount, $transDate, $companyName]);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }

    public function updateBalanceDecrement($companyName, $vendorPayable){
        $q = "UPDATE vendors SET outstandingBalance = outstandingBalance - ? WHERE companyName = ?";
        
        $this->db->query($q, [$vendorPayable, $companyName]);
        
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

    
   
   
   
   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
  
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
   
   /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
   
	public function getActiveVendors($orderBy, $orderFormat){
        $this->db->order_by($orderBy, $orderFormat);
		
		//$this->db->where('outstandingBalance >=', 0);
        
        $run_q = $this->db->get('vendors');
        
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
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function getAllVendors() {
        return $this->db->get('vendors')->result();
    }
    /*
    function for create Vendors.
    return Vendors inserted id.
    created by your name
    created at 22-07-20.
    */
    public function insert($data) {
        $this->db->insert('vendors', $data);
        return $this->db->insert_id();
    }
    /*
    return Vendors by id.
    created by your name
    created at 22-07-20.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('vendors')->result();
    }
    /*
    function for update Vendors.
    return true.
    created by your name
    created at 22-07-20.
    */
    public function updateVendor($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('vendors', $data);
        return true;
    }
    /*
    function for delete Vendors.
    return true.
    created by your name
    created at 22-07-20.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('vendors');
        return true;
    }
    /*
    function for change status of Vendors.
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