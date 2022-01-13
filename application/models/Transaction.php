<?php

defined('BASEPATH') OR exit('');


class Transaction extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Get all transactions
     * @param type $orderBy
     * @param type $orderFormat
     * @param type $start
     * @param type $limit
     * @return boolean
     */
    public function getAll($orderBy, $orderFormat, $start, $limit) {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                GROUP BY ref
                ORDER BY {$orderBy} {$orderFormat}
                LIMIT {$limit} OFFSET {$start}";

            $run_q = $this->db->query($q);
        }
        else {
            $this->db->select('transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.name as "staffName",
                transactions.cust_name, transactions.cust_phone, transactions.cust_email');
            
            $this->db->select_sum('transactions.quantity');
            
            $this->db->join('admin', 'transactions.staffId = admin.id', 'LEFT');
            $this->db->limit($limit, $start);
            $this->db->group_by('ref');
            $this->db->order_by($orderBy, $orderFormat);

            $run_q = $this->db->get('transactions');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function getDailyTransactions($date) {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                GROUP BY ref
                ORDER BY {$orderBy} {$orderFormat}
                LIMIT {$limit} OFFSET {$start}";

            $run_q = $this->db->query($q);
        }
        else {

            $this->db->select('transactions1.ref, transactions1.cumulativeAmount,  transactions1.staffId,
                transactions1.transDate, transactions1.amountTendered, transactions1.remainingBalance, transactions1.previousBalance,transactions1.totalProfit, transactions1.changeDue,
                admin.name as "staffName",
                transactions1.cust_name');
            
            $this->db->select_sum('transactions1.quantity');
            
            $this->db->join('admin', 'transactions1.staffId = admin.id', 'LEFT');
            $this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            
            $this->db->group_by('ref');
            

            $run_q = $this->db->get('transactions1');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function getMonthlyTransactions($from, $to) {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                GROUP BY ref
                ORDER BY {$orderBy} {$orderFormat}
                LIMIT {$limit} OFFSET {$start}";

            $run_q = $this->db->query($q);
        }
        else {

            $this->db->select('transactions1.ref, transactions1.cumulativeAmount,  transactions1.staffId,transactions1.invoiceTotal,
                transactions1.transDate, transactions1.amountTendered, transactions1.changeDue, transactions1.remainingBalance,transactions1.totalProfit,
                admin.name as "staffName",
                transactions1.cust_name');
            
            $this->db->select_sum('transactions1.quantity');
            //$this->db->select_sum('transactions1.totalProfit');
            //$this->db->select_sum('transactions1.invoiceTotal');
            
            $this->db->join('admin', 'transactions1.staffId = admin.id', 'LEFT');
            $this->db->where('Date(transDate) >=',$from);
            $this->db->where('Date(transDate) <=',$to);
            //$this->db->where('transDate ==',$date);
            
            $this->db->group_by('ref');
            

            $run_q = $this->db->get('transactions1');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }
    public function getMonthlyReturnTransactions($from, $to) {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                GROUP BY ref
                ORDER BY {$orderBy} {$orderFormat}
                LIMIT {$limit} OFFSET {$start}";

            $run_q = $this->db->query($q);
        }
        else {

            $this->db->select('returnTransactions.returnRef, returnTransactions.invoiceTotal,  returnTransactions.staffId,
                Date(returnTransactions.transDate) as "transDate", returnTransactions.amountPayable, returnTransactions.remainingBalance, returnTransactions.previousBalance,returnTransactions.profitReduction,
                admin.name as "staffName",
                returnTransactions.cust_name');
            
            $this->db->select_sum('returnTransactions.quantity');
            
            $this->db->join('admin', 'returnTransactions.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            $this->db->where('Date(transDate) >=',$from);
            $this->db->where('Date(transDate) <=',$to);
            
            $this->db->group_by('returnRef');
            

            $run_q = $this->db->get('returnTransactions');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function getReturnTransactionsByDate($date) {
        if ($this->db->platform() == "sqlite3") {
           
        }
        else {

            $this->db->select('returnTransactions.returnRef, returnTransactions.invoiceTotal,  returnTransactions.staffId,
                Date(returnTransactions.transDate) as "transDate", returnTransactions.amountPayable, returnTransactions.remainingBalance, returnTransactions.previousBalance,returnTransactions.profitReduction,
                admin.name as "staffName",
                returnTransactions.cust_name');
            
            $this->db->select_sum('returnTransactions.quantity');
            
            $this->db->join('admin', 'returnTransactions.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            $this->db->where('Date(transDate) ',$date);
            //$this->db->where('Date(transDate) <=',$to);
            
            $this->db->group_by('returnRef');
            

            $run_q = $this->db->get('returnTransactions');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function getAllTransactions($orderBy, $orderFormat, $start, $limit) {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                GROUP BY ref
                ORDER BY {$orderBy} {$orderFormat}
                LIMIT {$limit} OFFSET {$start}";

            $run_q = $this->db->query($q);
        }
        else {

            $this->db->select('transactions1.ref, transactions1.cumulativeAmount,  transactions1.staffId,
                Date(transactions1.transDate) as "transDate", transactions1.amountTendered, transactions1.remainingBalance,transactions1.totalProfit,
                admin.name as "staffName",
                transactions1.cust_name');
            
            $this->db->select_sum('transactions1.quantity');
            
            $this->db->join('admin', 'transactions1.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            
            $this->db->limit($limit, $start);
            $this->db->group_by('ref');
            $this->db->order_by($orderBy, $orderFormat);
            

            $run_q = $this->db->get('transactions1');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function getPurchaseCustomer($customer) {
        

            $this->db->select('transactions1.ref, transactions1.cumulativeAmount,  transactions1.staffId,
                Date(transactions1.transDate) as "transDate", transactions1.amountTendered, transactions1.previousBalance, transactions1.remainingBalance,transactions1.totalProfit,
                admin.name as "staffName",
                transactions1.cust_name');
            
            $this->db->select_sum('transactions1.quantity');
            
            $this->db->join('admin', 'transactions1.staffId = admin.id', 'LEFT');
            $this->db->where('transactions1.cust_name',$customer);
            //$this->db->where('transDate ==',$date);
            
            $this->db->group_by('ref');
            $this->db->order_by('transDate','DESC');
            
            $run_q = $this->db->get('transactions1');
        

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function getMaxRef(){
        $this->db->select('MAX(ref) as ref1');
        $this->db->where('ref <', 99999);
        $result = $this->db->get('transactions1');
        return $result->result();
    }
    public function getMaxReturnRef(){
        $this->db->select('MAX(returnRef) as ref1');
        $this->db->where('returnRef <', 99999);
        $result = $this->db->get('returnTransactions');
        return $result->result();
    }

    public function getPurchaseItem($itemCode) {
        

            $this->db->select('transactions1.ref, transactions1.cumulativeAmount,  transactions1.staffId,
                Date(transactions1.transDate) as "transDate", transactions1.amountTendered, transactions1.remainingBalance,transactions1.totalProfit,
                admin.name as "staffName",
                transactions1.cust_name');
            
            $this->db->select_sum('transactions1.quantity');
            
            $this->db->join('admin', 'transactions1.staffId = admin.id', 'LEFT');
            $this->db->where('transactions1.itemCode',$itemCode);
            //$this->db->where('transDate ==',$date);
            
            $this->db->group_by('ref');
            $this->db->order_by('transDate','desc');
            

            $run_q = $this->db->get('transactions1');
        

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }


    public function getAllReturnTransactions($orderBy, $orderFormat, $start, $limit) {
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                GROUP BY ref
                ORDER BY {$orderBy} {$orderFormat}
                LIMIT {$limit} OFFSET {$start}";

            $run_q = $this->db->query($q);
        }
        else {

            $this->db->select('returnTransactions.returnRef, returnTransactions.invoiceTotal,  returnTransactions.staffId,
                Date(returnTransactions.transDate) as "transDate", returnTransactions.amountPayable, returnTransactions.remainingBalance, returnTransactions.previousBalance,returnTransactions.profitReduction,
                admin.name as "staffName",
                returnTransactions.cust_name');
            
            $this->db->select_sum('returnTransactions.quantity');
            
            $this->db->join('admin', 'returnTransactions.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
            $this->db->limit($limit, $start);
            $this->db->group_by('returnRef');
            $this->db->order_by($orderBy, $orderFormat);
            
            

            $run_q = $this->db->get('returnTransactions');
        }

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function getReturnCustomer($customer) {
        
            $this->db->select('returnTransactions.returnRef, returnTransactions.invoiceTotal,  returnTransactions.staffId,
                Date(returnTransactions.transDate) as "transDate", returnTransactions.amountPayable, returnTransactions.remainingBalance, returnTransactions.previousBalance,returnTransactions.profitReduction,
                admin.name as "staffName",
                returnTransactions.cust_name');
            
            $this->db->select_sum('returnTransactions.quantity');
            
            $this->db->join('admin', 'returnTransactions.staffId = admin.id', 'LEFT');
            $this->db->where('returnTransactions.cust_name',$customer);
            //$this->db->where('transDate ==',$date);
            
            $this->db->group_by('returnRef');
            

            $run_q = $this->db->get('returnTransactions');
        

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }
    public function getReturnItem($itemCode) {
        
            $this->db->select('returnTransactions.returnRef, returnTransactions.invoiceTotal,  returnTransactions.staffId,
                Date(returnTransactions.transDate) as "transDate", returnTransactions.amountPayable, returnTransactions.remainingBalance, returnTransactions.previousBalance,returnTransactions.profitReduction,
                admin.name as "staffName",
                returnTransactions.cust_name');
            
            $this->db->select_sum('returnTransactions.quantity');
            
            $this->db->join('admin', 'returnTransactions.staffId = admin.id', 'LEFT');
            $this->db->where('returnTransactions.itemCode',$itemCode);
            //$this->db->where('transDate ==',$date);
            
            $this->db->group_by('returnRef');
            
            $this->db->order_by('transDate','desc');
            $run_q = $this->db->get('returnTransactions');
        

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }


    public function getAllReceipt(){
        $this->db->select('ref');
        $this->db->distinct();
        $run_q = $this->db->get('transactions1');
        return $run_q->result();

    }

    public function receiptInfo($ref){

        $this->db->where('ref', $ref);
        $run_q = $this->db->get('transactions1');
        return $run_q->result();

    }
    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * 
     * @param type $_iN item Name
     * @param type $_iC item Code
     * @param type $desc Desc
     * @param type $q quantity bought
     * @param type $_up unit price
     * @param type $_tp total price
     * @param type $_tas total amount spent
     * @param type $_at amount tendered
     * @param type $_cd change due
     * @param type $_mop mode of payment
     * @param type $_tt transaction type whether (sale{1} or return{2})
     * @param type $ref
     * @param float $_va VAT Amount
     * @param float $_vp VAT Percentage
     * @param float $da Discount Amount
     * @param float $dp Discount Percentage
     * @param {string} $cn Customer Name
     * @param {string} $cp Customer Phone
     * @param {string} $ce Customer Email
     * @return boolean
     */
    //$itemName, $itemCode, $qtySold, $unitPrice, $costUnitPrice, $totalPrice, $totalCostPrice, $cumAmount, $remainingBalance, $previousBalance, $totalProfit, $_at, $_cd, $ref, $discount_amount, $cust_name, $cust_id
    public function add( $itemCode, $qtySold, $unitPrice, $costUnitPrice, $totalPrice, $totalCostPrice, $cumAmount, $remainingBalance, $previousBalance, $totalProfit, $invoiceTotal, $_at, $_cd, $ref, $discount_amount, $cust_name, $cust_id , $date1) {
        $data = [ 'itemCode' => $itemCode, 'quantity' => $qtySold, 'unitPrice' => $unitPrice, 'costUnitPrice' => $costUnitPrice, 'totalPrice' => $totalPrice, 'totalCostPrice' => $totalCostPrice, 'remainingBalance' => $remainingBalance, 'previousBalance' => $previousBalance, 'totalProfit' => $totalProfit, 'invoiceTotal' => $invoiceTotal, 
            'amountTendered' => $_at, 'changeDue' => $_cd, 
            'staffId' => $this->session->admin_id, 'cumulativeAmount' => $cumAmount, 'ref' => $ref,  'discount_amount'=>$discount_amount,  'cust_name'=>$cust_name, 'cust_id'=>$cust_id, 'transDate'=>$date1];

        //echo $data;
        
        //set the datetime based on the db driver in use
        //$this->db->platform() == "sqlite3" ?
        //    $this->db->set('transDate', "datetime('now')", FALSE) :
        //    $this->db->set('transDate', "NOW()", FALSE);

        $this->db->insert('transactions1', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        else {
            return FALSE;
        }
        
    }

    public function updateTransaction( $itemCode, $qtySold, $unitPrice, $costUnitPrice, $totalPrice, $totalCostPrice, $cumAmount, $remainingBalance, $previousBalance, $totalProfit, $invoiceTotal, $_at, $_cd, $ref, $discount_amount, $cust_name, $cust_id , $date1, $transId) {
        $data = [ 'itemCode' => $itemCode, 'quantity' => $qtySold, 'unitPrice' => $unitPrice, 'costUnitPrice' => $costUnitPrice, 'totalPrice' => $totalPrice, 'totalCostPrice' => $totalCostPrice, 'remainingBalance' => $remainingBalance, 'previousBalance' => $previousBalance, 'totalProfit' => $totalProfit, 'invoiceTotal' => $invoiceTotal, 
            'amountTendered' => $_at, 'changeDue' => $_cd, 
            'staffId' => $this->session->admin_id, 'cumulativeAmount' => $cumAmount,  'discount_amount'=>$discount_amount,  'cust_name'=>$cust_name, 'cust_id'=>$cust_id, 'transDate'=>$date1];

        //echo $data;
        
        //set the datetime based on the db driver in use
        //$this->db->platform() == "sqlite3" ?
        //    $this->db->set('transDate', "datetime('now')", FALSE) :
        //    $this->db->set('transDate', "NOW()", FALSE);
        $this->db->where('transId', $transId);
        $this->db->update('transactions1', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        else {
            return FALSE;
        }
        
    }


    public function addReturn($itemName, $itemCode, $qtySold, $unitPrice, $costPrice, $totalPrice, $cumAmount, $remainingBalance, $previousBalance, $profitReduction, $invoiceTotal, $amountPayable, $ref, $receiptNo, $cust_name, $cust_id , $date1) {
        $data = ['itemName' => $itemName, 'itemCode' => $itemCode, 'quantity' => $qtySold, 'unitPrice' => $unitPrice, 'costUnitPrice' => $costPrice, 'totalPrice' => $totalPrice, 'remainingBalance' => $remainingBalance, 'previousBalance' => $previousBalance, 'profitReduction' => $profitReduction, 'invoiceTotal' => $invoiceTotal, 
            'amountPayable' => $amountPayable,
            'staffId' => $this->session->admin_id, 'cumulativeAmount' => $cumAmount, 'returnRef' => $ref,  'referenceRef'=>$receiptNo,  'cust_name'=>$cust_name, 'cust_id'=>$cust_id, 'transDate'=> $date1];

        //echo $data;
        
        //set the datetime based on the db driver in use
        //$this->db->platform() == "sqlite3" ?
            //$this->db->set('transDate', "datetime('now')", FALSE) :
            //$this->db->set('transDate', "NOW()", FALSE);

        $this->db->insert('returnTransactions', $data);

        if ($this->db->affected_rows()) {
            return $this->db->insert_id();
        }
        else {
            return FALSE;
        }
        
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Primarily used t check whether a prticular ref exists in db
     * @param type $ref
     * @return boolean
     */
    public function isRefExist($ref) {
        $q = "SELECT DISTINCT ref FROM transactions1 WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function isReturnRefExist($ref) {
        $q = "SELECT DISTINCT returnRef FROM returnTransactions WHERE returnRef = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }


    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    public function transSearch($value) {
        $this->db->select('transactions1.ref, transactions1.cumulativeAmount,  transactions1.staffId,
                Date(transactions1.transDate) as "transDate", transactions1.amountTendered, transactions1.remainingBalance,transactions1.totalProfit,
                admin.name as "staffName",
                transactions1.cust_name');
            
        $this->db->select_sum('transactions1.quantity');
            
        $this->db->join('admin', 'transactions1.staffId = admin.id', 'LEFT');
        
        
        $this->db->like('ref', $value);
        $this->db->or_like('Date(transDate)', $value);
        //$this->db->or_like('itemCode', $value);
        //$this->db->or_like('transDate', $value);
        //$this->db->or_like('transactions1.quantity', $value);
        $this->db->group_by('ref');

        $run_q = $this->db->get('transactions1');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    public function transReturnSearch($value) {
        $this->db->select('returnTransactions.returnRef, returnTransactions.invoiceTotal,  returnTransactions.staffId,
                Date(returnTransactions.transDate) as "transDate", returnTransactions.amountPayable, returnTransactions.remainingBalance, returnTransactions.previousBalance,returnTransactions.profitReduction,
                admin.name as "staffName",
                returnTransactions.cust_name');
            
        $this->db->select_sum('returnTransactions.quantity');
            
        $this->db->join('admin', 'returnTransactions.staffId = admin.id', 'LEFT');
            //$this->db->where('Date(transDate)',$date);
            //$this->db->where('transDate ==',$date);
        $this->db->like('returnRef', $value);
        $this->db->or_like('Date(transDate)', $value);
        $this->db->group_by('returnRef');
            

        $run_q = $this->db->get('returnTransactions');

        
        
        
        //$this->db->or_like('itemName', $value);
        //$this->db->or_like('itemCode', $value);
        //$this->db->or_like('transDate', $value);
        //$this->db->or_like('transactions1.quantity', $value);
        //$this->db->group_by('ref');

        //$run_q = $this->db->get('transactions1');

        if ($run_q->num_rows() > 0) {
            return $run_q->result();
        }
        else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Get all transactions with a particular ref
     * @param type $ref
     * @return boolean
     */
    public function gettransinfo($ref) {
        $q = "SELECT * FROM transactions1 WHERE ref = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return $run_q->result_array();
        }
        else {
            return FALSE;
        }
    }

    public function getReturnTranInfo($ref) {
        $q = "SELECT * FROM returnTransactions WHERE returnRef = ?";

        $run_q = $this->db->query($q, [$ref]);

        if ($run_q->num_rows() > 0) {
            return $run_q->result_array();
        }
        else {
            return FALSE;
        }
    }
    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * selects the total number of transactions done so far
     * @return boolean
     */
    public function totalTransactions() {
        $q = "SELECT count(DISTINCT REF) as 'totalTrans' FROM transactions1";

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
    public function totalReturnTransactions() {
        $q = "SELECT count(DISTINCT returnRef) as 'totalTrans' FROM returnTransactions";

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
    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    /**
     * Calculates the total amount earned today and profit
     * @return boolean
     */
    public function totalEarnedToday() {
        $q = "SELECT invoiceTotal, totalProfit FROM transactions1 WHERE DATE(transDate) = CURRENT_DATE GROUP BY ref";


        $run_q = $this->db->query($q);

        if ($run_q->num_rows()) {
            $totalEarnedToday = 0;
            $totalProfitToday = 0;

            foreach ($run_q->result() as $get) {
                $totalEarnedToday += $get->invoiceTotal;
                $totalProfitToday += $get->totalProfit;
            }
            
            return array($totalProfitToday, $totalEarnedToday);
        }
        else {
            return FALSE;
        }
    }

    public function totalEarnedByDate($date) {
        $q = "SELECT invoiceTotal, totalProfit FROM transactions1 WHERE DATE(transDate) = {$date} GROUP BY ref";

        $this->db->where('DATE(transDate)', $date);
        $this->db->group_by('ref');
        $run_q = $this->db->get('transactions1'); 

        //$run_q = $this->db->query($q);

        if ($run_q->num_rows()) {
            $totalEarnedToday = 0;
            $totalProfitToday = 0;

            foreach ($run_q->result() as $get) {
                $totalEarnedToday += $get->invoiceTotal;
                $totalProfitToday += $get->totalProfit;
            }
            
            return array($totalProfitToday, $totalEarnedToday);
        }
        else {
            return FALSE;
        }
    }

    public function totalEarnedByDateOtherDb($date, $db) {
        $q = "SELECT invoiceTotal, totalProfit FROM transactions1 WHERE DATE(transDate) = {$date} GROUP BY ref";
        $otherdb = $this->load->database($db, TRUE);

        $otherdb->where('DATE(transDate)', $date);
        $otherdb->group_by('ref');
        $run_q = $otherdb->get('transactions1'); 

        //$run_q = $this->db->query($q);

        if ($run_q->num_rows()) {
            $totalEarnedToday = 0;
            $totalProfitToday = 0;

            foreach ($run_q->result() as $get) {
                $totalEarnedToday += $get->invoiceTotal;
                $totalProfitToday += $get->totalProfit;
            }
            
            return array($totalProfitToday, $totalEarnedToday);
        }
        else {
            return FALSE;
        }
    }



    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */

    //Not in use yet
    public function totalEarnedOnDay($date) {
        $q = "SELECT SUM(totalPrice) as 'totalEarnedToday' FROM transactions WHERE DATE(transDate) = {$date}";

        $run_q = $this->db->query($q);

        if ($run_q->num_rows() > 0) {
            foreach ($run_q->result() as $get) {
                return $get->totalEarnedToday;
            }
        }
        else {
            return FALSE;
        }
    }

    /*
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     * *******************************************************************************************************************************
     */
    
    public function getDateRange($from_date, $to_date){
        if ($this->db->platform() == "sqlite3") {
            $q = "SELECT transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                admin.first_name || ' ' || admin.last_name AS 'staffName', SUM(transactions.quantity) AS 'quantity',
                transactions.cust_name, transactions.cust_phone, transactions.cust_email
                FROM transactions
                LEFT OUTER JOIN admin ON transactions.staffId = admin.id
                WHERE 
                date(transactions.transDate) >= {$from_date} AND date(transactions.transDate) <= {$to_date}
                GROUP BY ref
                ORDER BY transactions.transId DESC";

            $run_q = $this->db->query($q);
        }
        
        else {
            $this->db->select('transactions.ref, transactions.totalMoneySpent, transactions.modeOfPayment, transactions.staffId,
                    transactions.transDate, transactions.lastUpdated, transactions.amountTendered, transactions.changeDue,
                    CONCAT_WS(" ", admin.first_name, admin.last_name) AS "staffName",
                    transactions.cust_name, transactions.cust_phone, transactions.cust_email');

            $this->db->select_sum('transactions.quantity');

            $this->db->join('admin', 'transactions.staffId = admin.id', 'LEFT');

            $this->db->where("DATE(transactions.transDate) >= ", $from_date);
            $this->db->where("DATE(transactions.transDate) <= ", $to_date);

            $this->db->order_by('transactions.transId', 'DESC');

            $this->db->group_by('ref');

            $run_q = $this->db->get('transactions');
        }
        
        return $run_q->num_rows() ? $run_q->result() : FALSE;
    }
}
