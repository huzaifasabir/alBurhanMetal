<?php
defined('BASEPATH') OR exit('');


class Item extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    public function getAll($orderBy, $orderFormat, $start=0, $limit='',$flag=''){
        $this->db->limit($limit, $start);
        $this->db->order_by($orderBy, $orderFormat);

        if($flag == 'all'){
            $run_q = $this->db->get('products');    
        }else{
            $this->db->where('subCategory', $flag);
            $run_q = $this->db->get('products');    
        }
        
        
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

    function getUserDetails(){
        $response = array();
        //$this->db->select('username,name,role');
        $q = $this->db->get('admin');
        $response = $q->result_array();
        return $response;
    }

    public function countAll($flag=''){
        

        if($flag == 'all'){
            $run_q = $this->db->count_all('products');    
        }else{
            $this->db->where('subCategory', $flag);
            $q = $this->db->get('products');
            $run_q = $q->num_rows();

        }
        
        
        
        
            return $run_q;
    }
    
    public function countAllPurchaseOrders() {
        $q = "SELECT count(DISTINCT REF) as 'totalTrans' FROM purchaseTransaction";

        $run_q = $this->db->query($q);

        if ($run_q->num_rows() > 0) {
            foreach ($run_q->result() as $get) {
                return $get->totalTrans;
            }
        }
        else {
            return FALSE;
        }
    }
    public function countAllReturnPurchaseOrders() {
        $q = "SELECT count(DISTINCT REF) as 'totalTrans' FROM returnPurchase";

        $run_q = $this->db->query($q);

        if ($run_q->num_rows() > 0) {
            foreach ($run_q->result() as $get) {
                return $get->totalTrans;
            }
        }
        else {
            return FALSE;
        }
    }
    public function getAllCategories() {
        $q = "SELECT DISTINCT subCategory as 'subCategory' FROM products";

        $run_q = $this->db->query($q);
        return $run_q->result();
        
    }
    public function getAllReceipt(){
        $this->db->select('ref');
        $this->db->distinct();
        $run_q = $this->db->get('purchaseTransaction');
        return $run_q->result();

    }
    public function receiptInfo($ref){

        $this->db->where('ref', $ref);
        $run_q = $this->db->get('purchaseTransaction');
        return $run_q->result();

    }
    public function getMaxReturnRef(){
        $this->db->select('MAX(ref) as ref1');
        $this->db->where('ref <', 99999);
        $result = $this->db->get('returnPurchase');
        return $result->result();
    }

    public function addReturn($itemCode, $qtySold, $unitPrice, $totalPrice, $vendor, $totalAmount, $ref, $receiptNo, $date1) {
        $data = ['itemCode' => $itemCode, 'quantity' => $qtySold, 'unitPrice' => $unitPrice, 'totalPrice' => $totalPrice, 'totalAmount' => $totalAmount, 'vendor' => $vendor, 
            'staffId' => $this->session->admin_id, 'ref' => $ref,  'referenceRef'=>$receiptNo, 'transDate'=> $date1];

        //echo $data;
        
        //set the datetime based on the db driver in use
        //$this->db->platform() == "sqlite3" ?
            //$this->db->set('transDate', "datetime('now')", FALSE) :
            //$this->db->set('transDate', "NOW()", FALSE);

        $this->db->insert('returnPurchase', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        else {
            return FALSE;
        }
        
    }

    public function getAllPurchase($orderBy, $orderFormat, $start=0, $limit=''){
        
        $this->db->select('purchaseTransaction.ref, purchaseTransaction.cumulativeTotal,  purchaseTransaction.staffId,
                Date(purchaseTransaction.transDate) as "transDate", purchaseTransaction.vendorPayable, purchaseTransaction.labor, purchaseTransaction.transport,
                admin.name as "staffName",
                purchaseTransaction.vendor');
            
            $this->db->select_sum('purchaseTransaction.quantity');
            
            $this->db->join('admin', 'purchaseTransaction.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            $this->db->limit($limit, $start);
            $this->db->order_by($orderBy, $orderFormat);
            $this->db->group_by('ref');
            

            $run_q = $this->db->get('purchaseTransaction');

        
        //$run_q = $this->db->get('purchaseTransaction');    
        
        
        
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    public function getAllReturnPurchase($orderBy, $orderFormat, $start=0, $limit=''){
        
        $this->db->select('returnPurchase.ref, returnPurchase.totalAmount,  returnPurchase.staffId,
                Date(returnPurchase.transDate) as "transDate", 
                admin.name as "staffName",
                returnPurchase.vendor');
            
            $this->db->select_sum('returnPurchase.quantity');
            
            $this->db->join('admin', 'returnPurchase.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            $this->db->limit($limit, $start);
            $this->db->order_by($orderBy, $orderFormat);
            $this->db->group_by('ref');
            

            $run_q = $this->db->get('returnPurchase');

        
        //$run_q = $this->db->get('purchaseTransaction');    
        
        
        
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

    public function getPurchaseVendor($vendor){
        
        $this->db->select('purchaseTransaction.ref, purchaseTransaction.cumulativeTotal,  purchaseTransaction.staffId,
                Date(purchaseTransaction.transDate) as "transDate", purchaseTransaction.vendorPayable, purchaseTransaction.labor, purchaseTransaction.transport,
                admin.name as "staffName",
                purchaseTransaction.vendor');
            
            $this->db->select_sum('purchaseTransaction.quantity');
            
            $this->db->join('admin', 'purchaseTransaction.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            //$this->db->limit($limit, $start);
            //$this->db->order_by($orderBy, $orderFormat);
            $this->db->where('vendor',$vendor);
            $this->db->order_by('transDate','DESC');
            $this->db->group_by('ref');
            

            $run_q = $this->db->get('purchaseTransaction');

        
        //$run_q = $this->db->get('purchaseTransaction');    
        
        
        
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
       public function getPurchaseItem($itemCode){
        
        $this->db->select('purchaseTransaction.ref, purchaseTransaction.cumulativeTotal,  purchaseTransaction.staffId,
                Date(purchaseTransaction.transDate) as "transDate", purchaseTransaction.vendorPayable, purchaseTransaction.labor, purchaseTransaction.transport,
                admin.name as "staffName",
                purchaseTransaction.vendor');
            
            $this->db->select_sum('purchaseTransaction.quantity');
            
            $this->db->join('admin', 'purchaseTransaction.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            //$this->db->limit($limit, $start);
            //$this->db->order_by($orderBy, $orderFormat);
            $this->db->where('itemCode',$itemCode);
            $this->db->group_by('ref');
            $this->db->order_by('transDate','desc');
            

            $run_q = $this->db->get('purchaseTransaction');

        
        //$run_q = $this->db->get('purchaseTransaction');    
        
        
        
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }



    public function gettransinfo($ref) {
        $q = "SELECT * FROM purchaseTransaction WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return $run_q->result_array();
        }
        else {
            return FALSE;
        }
    }
    public function getItemPurchaseInfo($itemCode, $transDate) {
        $q = "SELECT * FROM purchaseTransaction WHERE itemCode = ? AND transDate > '".$transDate."'";

        $run_q = $this->db->query($q, [$itemCode]);

        if ($run_q->num_rows() > 0) {
            return $run_q->result_array();
        }
        else {
            return FALSE;
        }
    }
    public function getreturntransinfo($ref) {
        $q = "SELECT * FROM returnPurchase WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return $run_q->result_array();
        }
        else {
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
    public function add($itemName, $category, $itemDescription, $thickness, $itemQuantity, $itemLocation, $costPrice, $sellingPrice, $vendor , $link){
        $totalValue  = $itemQuantity * $costPrice;
        
        $data = ['name'=>$itemName, 'category'=>'plywood', 'subCategory'=>$category, 'description'=>$itemDescription, 'quantity'=>$itemQuantity, 'location'=>$itemLocation, 'costPrice'=>$costPrice, 'sellingPrice'=>$sellingPrice,  'totalValue'=>$totalValue, 'thickness'=>$thickness,  'vendorName'=>$vendor, 'hlink'=>$link];
        
                
        //set the datetime based on the db driver in use
        $this->db->platform() == "sqlite3" 
                ? 
        $this->db->set('dateAdded', "datetime('now')", FALSE) 
                : 
        $this->db->set('dateAdded', "NOW()", FALSE);
        
        
        //debug_to_console("Test");

        $this->db->insert('products', $data);
        
        if($this->db->insert_id()){
            return $this->db->insert_id();
        }
        
        else{
            return FALSE;
        }
        
        return false;
    }
    public function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
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
    public function itemsearch($value, $flag){
        //$q = "SELECT * FROM products 
        //    WHERE 
        //    (name LIKE '%".$this->db->escape_like_str($value)."%'
        //    || 
        //    code LIKE '%".$this->db->escape_like_str($value)."%')";

        $this->db->like('name', $value);
        $this->db->where('subCategory', $flag);
        $this->db->order_by('description', 'ASC');
        
        $run_q = $this->db->get('products');//$this->db->query($q, [$flag,$value, $value]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    
     public function itemsearchAll($value, $category){
        //$q = "SELECT * FROM products 
        //    WHERE 
        //    (name LIKE '%".$this->db->escape_like_str($value)."%'
        //    || 
        //    code LIKE '%".$this->db->escape_like_str($value)."%')";
        if($category){
        $value = str_replace(" ", "%", $value);
         $q = ("select *
from products
where name like '%".$value."%' AND subCategory = '".$category."'");
     }else{
        $value = str_replace(" ", "%", $value);
         $q = ("select *
from products
where name like '%".$value."%'");
     }
        //$this->db->like('name', $value);

        //$this->db->order_by('description', 'ASC');
        $run_q = $this->db->query($q);//$this->db->query($q, [$flag,$value, $value]);
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }
    public function itemsearchCategory($value){
        //$q = "SELECT * FROM products 
        //    WHERE 
        //    (name LIKE '%".$this->db->escape_like_str($value)."%'
        //    || 
        //    code LIKE '%".$this->db->escape_like_str($value)."%')";

        $this->db->where('subCategory', $value);

        $this->db->order_by('description', 'ASC');
        $run_q = $this->db->get('products');//$this->db->query($q, [$flag,$value, $value]);
        
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
    public function incrementItem($itemCode, $numberToadd){


        $q = "UPDATE products SET quantity = quantity + ? WHERE code = ?";
        
        $this->db->query($q, [$numberToadd, $itemCode]);
        
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
        $q = "UPDATE products SET quantity = quantity - ? WHERE code = ?";
        
        $this->db->query($q, [$numberToRemove, $itemCode]);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }

    public function isRefExist($ref) {
        $q = "SELECT DISTINCT ref FROM purchaseTransaction WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function getMaxRef(){
        $this->db->select('MAX(ref) as ref1');
        $this->db->where('ref <', 99999);
        $result = $this->db->get('purchaseTransaction');
        return $result->result();
    }

    public function updateInfo($itemCode, $newQty, $costPrice, $sellingPrice, $date, $totalValue){
        //$this->db->set('lastPurchased', "NOW()", FALSE);
        //$date = date('y-m-d');

        $q = "UPDATE products SET quantity = quantity + ?, costPrice = ?, sellingPrice = ?, lastPurchased = ?, totalValue = ? WHERE code = ?";
        
        $this->db->query($q, [$newQty, $costPrice, $sellingPrice, $date, $totalValue, $itemCode]);
        
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        
        else{
            return FALSE;
        }
    }

    public function update($code,$data) {
        $this->db->where('code', $code);
        $this->db->update('products', $data);
        return true;
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
   public function edit($itemId, $itemName, $itemDesc, $itemPrice, $costPrice, $itemUrduName, $itemLocation){
       $data = ['name'=>$itemName, 'unitPrice'=>$itemPrice,'costPrice'=>$costPrice, 'description'=>$itemDesc, 'urduName'=>$itemUrduName, 'location'=>$itemLocation];
       
       $this->db->where('id', $itemId);
       $this->db->update('items', $data);
       
       return TRUE;
   }
   
   public function updatePrevious($previousCostPrice , $previousQuantity, $transId){
       $data = ['previousCostPrice'=>$previousCostPrice, 'previousQuantity'=>$previousQuantity];
       
       $this->db->where('transId', $transId);
       $this->db->update('purchaseTransaction', $data);
       
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
        
        $run_q = $this->db->get('products');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        
        else{
            return FALSE;
        }
    }

    public function getItems($orderBy, $orderFormat){
        $this->db->order_by($orderBy, $orderFormat);
        
        //$this->db->where('quantity >=', 1);
        
        $run_q = $this->db->get('products');
        
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

        $run_q = $this->db->get('products');
        
        return $run_q->num_rows() ? $run_q->row() : FALSE;
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */

    public function getItemsCumTotal($flag){
        $this->db->select("SUM(costPrice*quantity) as cumPrice");
        if($flag === 'all'){
                
        }else{
            $this->db->where('subCategory', $flag);
        }
        

        $run_q = $this->db->get('products');
        
        return $run_q->num_rows() ? $run_q->row()->cumPrice : FALSE;
    }
    
    public function getItemsCumTotalCategory(){
        $this->db->select("subCategory, SUM(costPrice*quantity) as totalValue");

        $this->db->group_by('subCategory');
        $run_q = $this->db->get('products');
        
        if($run_q->num_rows() > 0){
            return $run_q->result();
        }
        else{
            return FALSE;
        }
    }



    public function addPurchaseOrder($itemName, $itemCode, $qty, $unitFixedPrice, $costPrice, $sellingPrice, $totalCostPrice, $cumAmount, $vendor, $transportCost, 
                    $laborCost, $vendorPayable, $ref, $date1, $previousCostPrice, $previousQuantity) {
        $totalFixedCostPrice = $unitFixedPrice * $qty; 
        $data = ['itemName' => $itemName, 'itemCode'=>$itemCode, 'quantity' => $qty, 'fixedCostPrice' => $unitFixedPrice, 'costPrice' => $costPrice, 'sellingPrice' => $sellingPrice, 'totalCostPrice' => $totalCostPrice, 'totalFixedCostPrice' => $totalFixedCostPrice,
            'cumulativeTotal' => $cumAmount, 'vendor' => $vendor, 'transport' => $transportCost, 'labor' => $laborCost,'staffId' => $this->session->admin_id, 'vendorPayable' => $vendorPayable, 'ref' => $ref, 'transDate' => $date1, 'previousCostPrice' => $previousCostPrice , 'previousQuantity' => $previousQuantity ];

        //set the datetime based on the db driver in use
        //$this->db->platform() == "sqlite3" ?
        //    $this->db->set('transDate', "datetime('now')", FALSE) :
        //    $this->db->set('transDate', "NOW()", FALSE);

        $this->db->insert('purchaseTransaction', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        else {
            return FALSE;
        }
    }
}