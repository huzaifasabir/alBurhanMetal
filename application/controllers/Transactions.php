<?php
defined('BASEPATH') OR exit('');
require_once 'functions.php';

class Transactions extends CI_Controller{
    private $total_before_discount = 0, $discount_amount = 0, $vat_amount = 0, $eventual_total = 0;
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->load->model(['transaction', 'item','customer','CustomerTransaction','AccountsTransaction', 'Account']);
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function index(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $data['pageContent'] = $this->load->view('transactions/transactions', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
    }

    public function newSale(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $data['pageContent'] = $this->load->view('transactions/transactions', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
    }
    public function newQuotation(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $data['pageContent'] = $this->load->view('transactions/quotation', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
    }
    public function allTransactions(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $data['pageContent'] = $this->load->view('transactions/allTransactions', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
    }
    public function allReturnTransactions(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $data['pageContent'] = $this->load->view('transactions/allReturnTransactions', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
    }
    
    public function editTransaction($ref) {
        $data1['transInfo']=$this->transaction->gettransinfo($ref);
        //$data1['products_id'] = $products_id;
        $data1['customers'] = $this->customer->getAll();//get customers
        $data1['items'] = $this->item->getItems('name', 'ASC');
        //$data1['products'] = $this->products->getDataById($products_id);
        //$data1['vendors'] = $this->vendor->getActiveVendors('companyName', 'ASC');//
        
        $data['pageContent'] = $this->load->view('transactions/editTransaction', $data1, TRUE);
        $data['pageTitle'] = "Transactions";
        $this->load->view('main', $data);
    }
    public function returnProduct(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers
        $transData['receipts'] = $this->transaction->getAllReceipt();//get customers 
        $data['pageContent'] = $this->load->view('transactions/returnTransaction', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
    }

    public function transactionInfo(){
        //$json['status'] = 0;
        
        $ref = $this->input->get('ref', TRUE);
        //echo $ref;
        //echo "string";
        //$ref = 0;
        $customerI = [];
        //$productArray = [];
        
        if($ref){
            $receipt_info = $this->transaction->receiptInfo($ref);
            //echo "string";
            //$json['status'] = 1;
            //echo $receipt_info[0]->cust_id;
            //foreach ($receipt_info as $row)
            //    {
            //       echo $row->cust_id;
                   //echo $row->name;
                   //echo $row->body;
            //    }
            //echo $receipt_info->cust_id;
            //$receipt_info = 0;

            if($receipt_info){
                $customerId = $receipt_info[0]->cust_id;
                $customer_info = $this->customerInfo($customerId);
                //echo $customerId;
                if($customer_info){
                    //echo $customer_info->customerName;
                    $customerI['name'] = $customer_info->customerName;
                    $customerI['phone'] = $customer_info->phone;
                    $customerI['email'] = $customer_info->email;
                    $customerI['address'] = $customer_info->address;
                    $customerI['outstandingBalance'] = $customer_info->outstandingBalance;

                }
                foreach ($receipt_info as $row){
                    $productArray[$row->itemCode] = ['name' => ($this->genmod->gettablecol('products', 'name', 'code', $row->itemCode)), 'quantityPurchased' =>$row->quantity, 'unitPrice' => $row->unitPrice, 'costUnitPrice' => $row->costUnitPrice];
                    //echo $row->itemName;
                }

                $json['customerI'] = $customerI;
                $json['productI'] = $productArray;

                //$json['info'] = $customer_info;
                //$json['customerName'] = $item_info->customerName;
                //$json['unitPrice'] = $item_info->unitPrice;
                //$json['phone'] = $item_info->phone;
                //$json['email'] = $item_info->email;
                //$json['address'] = $item_info->address;
                $json['status'] = 1;
            }

        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function customerInfo($customerId){
        //$json['status'] = 0;
        
        //$customerId = $this->input->get('customerId', TRUE);
        
        if($customerId){
            $customer_info = $this->customer->getCustomerInfo(['id'=>$customerId], ['customerName', 'phone', 'email','address','outstandingBalance']);
            //$json['status'] = 1;
            if($customer_info){
                return $customer_info;            }
        }
        return False;
        
        //$json['customerId'] = $customerId;
        //$json['status'] = 1;
        
        //$this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * latr_ = "Load All Transactions"
     */
    public function latr_(){
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "transId";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "DESC";
        
        //count the total number of transaction group (grouping by the ref) in db
        $totalTransactions = $this->transaction->totalTransactions();
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
    
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalTransactions, "transactions/latr_", $limit, ['onclick'=>'return latr_(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all transactions from db
        $data['allTransactions'] = $this->transaction->getAllTransactions($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalTransactions > 0 ? ($start+1) . "-" . ($start + count($data['allTransactions'])) . " of " . $totalTransactions : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        
        $json['transTable'] = $this->load->view('transactions/transtable', $data, TRUE);//get view with populated transactions table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    public function loadReturn(){
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "transId";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "DESC";
        
        //count the total number of transaction group (grouping by the ref) in db
        $totalTransactions = $this->transaction->totalReturnTransactions();
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
    
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalTransactions, "transactions/loadReturn", $limit, ['onclick'=>'return loadReturn(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all transactions from db
        $data['allTransactions'] = $this->transaction->getAllReturnTransactions($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalTransactions > 0 ? ($start+1) . "-" . ($start + count($data['allTransactions'])) . " of " . $totalTransactions : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        
        $json['transTable'] = $this->load->view('transactions/returnTable', $data, TRUE);//get view with populated transactions table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    /**
     * nso_ = "New Sales Order"
     */
    public function nso_(){
        $this->genlib->ajaxOnly();
        
        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        $_mop = $this->input->post('_mop', TRUE);//mode of payment
        $_at = round($this->input->post('_at', TRUE), 2);//amount tendered
        $_cd = $this->input->post('_cd', TRUE);//change due
        $cumAmount = $this->input->post('_ca', TRUE);//cumulative amount
        $vatPercentage = $this->input->post('vat', TRUE);//vat percentage
        $discount_percentage = $this->input->post('discount', TRUE);//discount percentage
        $cust_name = $this->input->post('cn', TRUE);
        $cust_phone = $this->input->post('cp', TRUE);
        $cust_email = $this->input->post('ce', TRUE);
        
        /*
         * Loop through the arrOfItemsDetails and ensure each item's details has not been manipulated
         * The unitPrice must match the item's unit price in db, the totPrice must match the unitPrice*qty
         * The cumAmount must also match the total of all totPrice in the arr in addition to the amount of 
         * VAT (based on the vat percentage) and minus the $discount_percentage (if available)
         */
        
        $allIsWell = $this->validateItemsDet($arrOfItemsDetails, $cumAmount, $_at, $vatPercentage, $discount_percentage);
        
        if($allIsWell){//insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertTrToDb($arrOfItemsDetails, $_mop, $_at, $cumAmount, $_cd, $this->vat_amount, $vatPercentage, $this->discount_amount, 
                    $discount_percentage, $cust_name, $cust_phone, $cust_email);
            
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later "
                    . "or contact technical department for assistance";
            $json['transReceipt'] = $returnedData['transReceipt'];
            
            list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            $json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            $json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($cumAmount, 2)
                    ." with reference number {$returnedData['transRef']} was purchased";
            
            $this->genmod->addevent("New Transaction", $returnedData['transRef'], $eventDesc, 'transactions', $this->session->admin_id);
       }
        
        else{//return error msg
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    public function newSalesOrder(){
        //$postA = $this->input->post('custName');
        //echo "string";
        //echo $postA;

        
        $this->genlib->ajaxOnly();
        
        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        //$_mop = $this->input->post('_mop', TRUE);//mode of payment
        $temp1 = $this->input->post('_at');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $_at = $temp;//amount tendered
        $temp1 = $this->input->post('_cd');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $_cd = $temp;//change due
        $temp1 = $this->input->post('_ca');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $cumAmount = $temp;//cumulative amount
        //$vatPercentage = $this->input->post('vat', TRUE);//vat percentage
        $discount_percentage = $this->input->post('discount', TRUE);//discount percentage
        $discount_amount = $this->input->post('discountValue', TRUE);//discount percentage
        $cust_name = $this->input->post('cn', TRUE);
        $cust_phone = $this->input->post('cp', TRUE);
        $cust_email = $this->input->post('ce', TRUE);
        $cust_address = $this->input->post('ca', TRUE);
        $cust_id = $this->input->post('ci', TRUE);
        $temp1 = $this->input->post('remainingBalance');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $remainingBalance = $temp;
        $previousBalance = $this->input->post('previousBalance', TRUE);//discount percentage
        $temp1 = $this->input->post('totalProfit');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $totalProfit = $temp;
        $newCustomer = $this->input->post('newCustomer', TRUE);
        $temp1 = $this->input->post('invoiceTotal');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $invoiceTotal = $temp;
        
        $date1 = $this->input->post('date1', TRUE);
        /*
         * Loop through the arrOfItemsDetails and ensure each item's details has not been manipulated
         * The unitPrice must match the item's unit price in db, the totPrice must match the unitPrice*qty
         * The cumAmount must also match the total of all totPrice in the arr in addition to the amount of 
         * VAT (based on the vat percentage) and minus the $discount_percentage (if available)
         */
        
        //$allIsWell = $this->validateItemsDet($arrOfItemsDetails, $cumAmount, $_at, $discount_percentage, $previousBalance);
        

        $allIsWell = TRUE;
        //echo $allIsWell;
        //echo "string";

        if($allIsWell){
            //echo "\nhere";
            //insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertTrToDb($arrOfItemsDetails, $_at, $cumAmount, $_cd,  $discount_amount, $remainingBalance, $previousBalance, $totalProfit, $discount_percentage, $invoiceTotal, $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id, $newCustomer, $date1);
            
            //$returnedData = TRUE;
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later "
                    . "or contact technical department for assistance";
            $json['transReceipt'] = $returnedData['transReceipt'];
            //echo $returnedData['transReceipt'];
            //list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            //$json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            //$json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($cumAmount, 2)
                    ." with reference number {$returnedData['transRef']} was purchased";
            
            //$this->genmod->addevent("New Transaction", $returnedData['transRef'], $eventDesc, 'transactions1', $this->session->admin_id);

            
       }
        
        else{//return error msg
            $json['ref'] =  $ref;
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
            //echo "here23";
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function newQuotationOrder(){
        //$postA = $this->input->post('custName');
        //echo "string";
        //echo $postA;

        
        
        
        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        //$_mop = $this->input->post('_mop', TRUE);//mode of payment
        $_at = round($this->input->post('_at', TRUE), 2);//amount tendered
        $_cd = $this->input->post('_cd', TRUE);//change due
        $cumAmount = $this->input->post('_ca', TRUE);//cumulative amount
        //$vatPercentage = $this->input->post('vat', TRUE);//vat percentage
        $discount_percentage = $this->input->post('discount', TRUE);//discount percentage
        $discount_amount = $this->input->post('discountValue', TRUE);//discount percentage
        $cust_name = $this->input->post('cn', TRUE);
        $cust_phone = $this->input->post('cp', TRUE);
        $cust_email = $this->input->post('ce', TRUE);
        $cust_address = $this->input->post('ca', TRUE);
        $cust_id = $this->input->post('ci', TRUE);
        $remainingBalance = $this->input->post('remainingBalance', TRUE);
        $previousBalance = $this->input->post('previousBalance', TRUE);//discount percentage
        $totalProfit = $this->input->post('totalProfit', TRUE);
        $newCustomer = 1;
        $invoiceTotal = $this->input->post('invoiceTotal', TRUE);
        
        /*
         * Loop through the arrOfItemsDetails and ensure each item's details has not been manipulated
         * The unitPrice must match the item's unit price in db, the totPrice must match the unitPrice*qty
         * The cumAmount must also match the total of all totPrice in the arr in addition to the amount of 
         * VAT (based on the vat percentage) and minus the $discount_percentage (if available)
         */
        
        //$allIsWell = $this->validateItemsDet($arrOfItemsDetails, $cumAmount, $_at, $discount_percentage, $previousBalance);
        $allIsWell = TRUE;
        //echo $allIsWell;
        //echo "string";

        if($allIsWell){
            //echo "\nhere";
            //insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertQuotation($arrOfItemsDetails, $_at, $cumAmount, $_cd,  $discount_amount, $remainingBalance, $previousBalance, $totalProfit, $discount_percentage, $invoiceTotal, $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id, $newCustomer);
            
            //$returnedData = TRUE;
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later "
                    . "or contact technical department for assistance";
            $json['transReceipt'] = $returnedData['transReceipt'];
            //echo $returnedData['transReceipt'];
            //list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            //$json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            //$json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($cumAmount, 2)
                    ." with reference number {$returnedData['transRef']} was purchased";
            
            //$this->genmod->addevent("New Transaction", $returnedData['transRef'], $eventDesc, 'transactions1', $this->session->admin_id);

            
       }
        
        else{//return error msg
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
            //echo "here23";
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    private function insertQuotation($arrOfItemsDetails, $_at, $cumAmount, $_cd,  $discount_amount, $remainingBalance, $previousBalance, $totalProfit, 
                    $discount_percentage, $invoiceTotal, $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id, $newCustomer){
        $allTransInfo = [];//to hold info of all items' in transaction
        
        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        do{
            $ref = strtoupper(generateRandomCode('numeric', 6, 10, ""));
        }
        
        while($this->transaction->isRefExist($ref));
        
        //loop through the items' details and insert them one by one
        //start transaction
        $this->db->trans_start();
        $customerData = [];
        if($newCustomer){

            $customerData['customerName'] = $cust_name;
            $customerData['phone'] = $cust_phone;
            $customerData['email'] = $cust_email;
            $customerData['address'] = $cust_address;
            $customerData['outstandingBalance'] = $remainingBalance;
            //$cust_id = $this->customer->insert($customerData);
        }else{
            $customerData['outstandingBalance'] = $remainingBalance;
            //$this->customer->update($cust_id, $customerData);
        }

        
        foreach($arrOfItemsDetails as $get){
            $itemCode = $get->_iC;
            $itemName = $this->genmod->getTableCol('products', 'name', 'code', $itemCode);
            //$itemUrduName = $this->genmod->getTableCol('items', 'urduName', 'code', $itemCode);
            //$itemDescription = $this->genmod->gettablecol('items', 'description', 'code', $itemCode);
            $qtySold = $get->qty;//qty selected for item in loop
            $unitPrice = $get->unitPrice;//unit price of item in loop
            $costPrice = $get->costUnitPrice;//unit price of item in loop
            $totalCostPrice = $get->totalCostPrice;//total cost price
            $totalPrice = $get->totalPrice;//total price for item in loop
            $totalProfitItem = $get->totalProfitItem;

            
            // * add transaction to db
            // * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, //$_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             
            //$urduName = 'na';


            //$transId = $this->transaction->add($itemName, $itemCode, $qtySold, $unitPrice, $costPrice, $totalPrice, $totalCostPrice, $cumAmount, $remainingBalance, $previousBalance, $totalProfit, $invoiceTotal, $_at, $_cd, $ref, $discount_amount, $cust_name, $cust_id);
            $transId = $itemCode;
            
            $allTransInfo[$transId] = ['itemCode'=>$itemCode,'itemName'=>$itemName, 'quantity'=>$qtySold, 'unitPrice'=>$unitPrice, 'totalPrice'=>$totalPrice];
            
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)
            //$this->item->decrementItem($itemCode, $qtySold);
        }
        //$this->db->trans_complete();
        
        $incoming_cash = $_at - $_cd;
        //echo $incoming_cash;
        
        //$customerTransaction = [];
        //$customerTransaction['customerId'] = $cust_id;
        //$customerTransaction['debitAmount'] = $invoiceTotal;
        //$customerTransaction['creditAmount'] = $incoming_cash;
        //$customerTransaction['description'] = 'products purchased';
        //$customerTransaction['transactionDate'] = date('y-m-d');
        //$customerTransaction['refrenceNo'] = $ref;

        //$this->CustomerTransaction->insert($customerTransaction);


        
        //$accountTransaction = [];
        $accountTransaction['accName'] = 'Cash in Hand';
        $accountTransaction['creditAmount'] = $incoming_cash;
        $accountTransaction['description'] = 'products sold';
        $accountTransaction['type'] = 'productsSold';
        $accountTransaction['transactionDate'] = date('y-m-d');
        $accountTransaction['referenceNo'] = $ref;

        //echo $accountTransaction['accName'];

        //$this->AccountsTransaction->insert($accountTransaction);

        //$accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $accountTransaction['accName'] ) + $incoming_cash;
        //$accountData['lastUpdate'] = date('y-m-d');
        //$this->Account->update(5,$accountData);

        //echo $this->db->error();
        //$this->db->trans_complete();


        $this->db->trans_complete();//end transaction

        

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            
            return false;

        }
        
        else{
            $dataToReturn = [];
            
            //get transaction date in db, to be used on the receipt. It is necessary since date and time must matc
            $dateInDb = date("Y-m-d H:i:s");//$this->genmod->getTableCol('transactions', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genQuotationReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
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
    
    /**
     * 
     * @param type $arrOfItemsDetails
     * @param type $_mop
     * @param type $_at
     * @param type $cumAmount
     * @param type $_cd
     * @param type $vatAmount
     * @param type $vatPercentage
     * @param type $discount_amount
     * @param type $discount_percentage
     * @param type $cust_name
     * @param type $cust_phone
     * @param type $cust_email
     * @return boolean
     */
    private function insertTrToDb($arrOfItemsDetails, $_at, $cumAmount, $_cd,  $discount_amount, $remainingBalance, $previousBalance, $totalProfit, 
                    $discount_percentage, $invoiceTotal, $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id, $newCustomer, $date1){
        $allTransInfo = [];//to hold info of all items' in transaction
        
        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        //do{
        //    $ref = strtoupper(generateRandomCode('numeric', 6, 10, ""));
        //}
            
        
        //while($this->transaction->isRefExist($ref));
        $ref1 = $this->transaction->getMaxRef();
        $ref = $ref1[0]->ref1 + 1;
        //loop through the items' details and insert them one by one
        //start transaction
        $this->db->trans_start();
        $customerData = [];
        if($newCustomer){

            $customerData['customerName'] = $cust_name;
            $customerData['phone'] = $cust_phone;
            $customerData['email'] = $cust_email;
            $customerData['address'] = $cust_address;
            $customerData['outstandingBalance'] = $remainingBalance;
            $cust_id = $this->customer->insert($customerData);
        }else{
            $customerData['outstandingBalance'] = $remainingBalance;
            $this->customer->update($cust_id, $customerData);
        }

        
        foreach($arrOfItemsDetails as $get){
            $itemCode = $get->_iC;
            $itemName = $this->genmod->getTableCol('products', 'name', 'code', $itemCode);
            $itemDescription = $this->genmod->getTableCol('products', 'description', 'code', $itemCode);
            //$itemUrduName = $this->genmod->getTableCol('items', 'urduName', 'code', $itemCode);
            //$itemDescription = $this->genmod->gettablecol('items', 'description', 'code', $itemCode);
            $qtySold = $get->qty;//qty selected for item in loop
            $unitPrice = $get->unitPrice;//unit price of item in loop
            $costPrice = $get->costUnitPrice;//unit price of item in loop
            $totalCostPrice = $get->totalCostPrice;//total cost price
            $temp1 = $get->totalPrice;
            $temp = explode(',',$temp1);
            $temp = implode('',$temp);
            $totalPrice = $temp;//total price for item in loop

            $temp1 = $get->totalProfitItem;
            $temp = explode(',',$temp1);
            $temp = implode('',$temp);
            $totalProfitItem = $temp;

            
            // * add transaction to db
            // * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, //$_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             
            //$urduName = 'na';


            $transId = $this->transaction->add($itemCode, $qtySold, $unitPrice, $costPrice, $totalPrice, $totalCostPrice, $cumAmount, $remainingBalance, $previousBalance, $totalProfit, $invoiceTotal, $_at, $_cd, $ref, $discount_amount, $cust_name, $cust_id, $date1);
            //$transId = 1;
            
            $allTransInfo[$transId] = ['itemCode'=>$itemCode, 'costUnitPrice' => $costPrice, 'itemDescription'=>$itemDescription, 'itemName'=>$itemName, 'quantity'=>$qtySold, 'unitPrice'=>$unitPrice, 'totalPrice'=>$totalPrice];
            
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)
            $this->item->decrementItem($itemCode, $qtySold);
        }
        //$this->db->trans_complete();
        
        $incoming_cash = $_at - $_cd;
        //echo $incoming_cash;
        
        //$customerTransaction = [];
        //$customerTransaction['customerId'] = $cust_id;
        //$customerTransaction['debitAmount'] = $invoiceTotal;
        //$customerTransaction['creditAmount'] = $incoming_cash;
        //$customerTransaction['description'] = 'products purchased';
        //$customerTransaction['transactionDate'] = date('y-m-d');
        //$customerTransaction['refrenceNo'] = $ref;

        //$this->CustomerTransaction->insert($customerTransaction);


        
        //$accountTransaction = [];
        $accountTransaction['accName'] = 'Cash in Hand';
        $accountTransaction['creditAmount'] = $incoming_cash;
        $accountTransaction['description'] = 'products sold';
        $accountTransaction['type'] = 'productsSold';
        $accountTransaction['transactionDate'] = $date1;
        $accountTransaction['referenceNo'] = $ref;

        //echo $accountTransaction['accName'];

        $this->AccountsTransaction->insert($accountTransaction);

        $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $accountTransaction['accName'] ) + $incoming_cash;
        //$accountData['lastUpdate'] = date('y-m-d');
        $this->Account->update(5,$accountData);

        //echo $this->db->error();
        //$this->db->trans_complete();


        $this->db->trans_complete();//end transaction

        

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            
            return false;

        }
        
        else{
            $dataToReturn = [];
            
            //get transaction date in db, to be used on the receipt. It is necessary since date and time must matc
            $dateInDb = $this->genmod->getTableCol('transactions1', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genTransReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
        }
        
        
    }
    public function editSalesOrder(){
        //$postA = $this->input->post('custName');
        //echo "string";
        //echo $postA;

        
        $this->genlib->ajaxOnly();
        $transRef = $this->input->post('transRef', TRUE);
        if($transRef){
        //$transInfo = json_decode($this->input->post('transInfo', TRUE));
        $transInfo = $this->transaction->getTransInfo($transRef);
        
        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        //$_mop = $this->input->post('_mop', TRUE);//mode of payment
        $temp1 = $this->input->post('_at');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $_at = $temp;//amount tendered
        $temp1 = $this->input->post('_cd');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $_cd = $temp;//change due
        $temp1 = $this->input->post('_ca');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $cumAmount = $temp;//cumulative amount
        //$vatPercentage = $this->input->post('vat', TRUE);//vat percentage
        $discount_percentage = $this->input->post('discount', TRUE);//discount percentage
        $discount_amount = $this->input->post('discountValue', TRUE);//discount percentage
        $cust_name = $this->input->post('cn', TRUE);
        $cust_phone = $this->input->post('cp', TRUE);
        $cust_email = $this->input->post('ce', TRUE);
        $cust_address = $this->input->post('ca', TRUE);
        $cust_id = $this->input->post('ci', TRUE);
        $temp1 = $this->input->post('remainingBalance');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $remainingBalance = $temp;
        $previousBalance = $this->input->post('previousBalance', TRUE);//discount percentage
        $temp1 = $this->input->post('totalProfit');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $totalProfit = $temp;
        $newCustomer = $this->input->post('newCustomer', TRUE);
        $temp1 = $this->input->post('invoiceTotal');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $invoiceTotal = $temp;
        
        $date1 = $this->input->post('date1', TRUE);
        /*
         * Loop through the arrOfItemsDetails and ensure each item's details has not been manipulated
         * The unitPrice must match the item's unit price in db, the totPrice must match the unitPrice*qty
         * The cumAmount must also match the total of all totPrice in the arr in addition to the amount of 
         * VAT (based on the vat percentage) and minus the $discount_percentage (if available)
         */
        
        //$allIsWell = $this->validateItemsDet($arrOfItemsDetails, $cumAmount, $_at, $discount_percentage, $previousBalance);
        

        $allIsWell = TRUE;
        //echo $allIsWell;
        //echo "string";

        if($allIsWell){
            //echo "\nhere";
            //insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertEditRow($transRef, $transInfo, $arrOfItemsDetails, $_at, $cumAmount, $_cd,  $discount_amount, $remainingBalance, $previousBalance, $totalProfit, $discount_percentage, $invoiceTotal, $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id, $newCustomer, $date1);
            
            //$returnedData = TRUE;
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later "
                    . "or contact technical department for assistance";
            $json['transReceipt'] = $returnedData['transReceipt'];
            //echo $returnedData['transReceipt'];
            //list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            //$json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            //$json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($cumAmount, 2)
                    ." with reference number {$returnedData['transRef']} was purchased";
            
            //$this->genmod->addevent("New Transaction", $returnedData['transRef'], $eventDesc, 'transactions1', $this->session->admin_id);

            
       }
        
        else{//return error msg
            $json['ref'] =  $ref;
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
            //echo "here23";
        }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
        private function insertEditRow($transRef, $transInfo, $arrOfItemsDetails, $_at, $cumAmount, $_cd,  $discount_amount, $remainingBalance, $previousBalance, $totalProfit, 
                    $discount_percentage, $invoiceTotal, $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id, $newCustomer, $date1){
        $allTransInfo = [];//to hold info of all items' in transaction
        
        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        //do{
        //    $ref = strtoupper(generateRandomCode('numeric', 6, 10, ""));
        //}
            
        
        //while($this->transaction->isRefExist($ref));
        //$ref1 = $this->transaction->getMaxRef();
        //$ref = $ref1[0]->ref1 + 1;
        $ref = $transRef;
        //echo "ref";
        //loop through the items' details and insert them one by one
        //start transaction

        $this->db->trans_start();
        $this->db->where('ref', $transRef)->delete('transactions1');
        $customerData = [];
        if($newCustomer){

            $customerData['customerName'] = $cust_name;
            $customerData['phone'] = $cust_phone;
            $customerData['email'] = $cust_email;
            $customerData['address'] = $cust_address;
            $customerData['outstandingBalance'] = $remainingBalance;
            $cust_id = $this->customer->insert($customerData);
        }else{
            $customerData['outstandingBalance'] = $remainingBalance;
            $this->customer->update($cust_id, $customerData);
        }
        foreach($transInfo as $get){
            //echo "here";
            $itemCode = $get['itemCode'];
            $quantity = $get['quantity'];

            $this->item->incrementItem($itemCode, $quantity);
            //$previousAmountTendered = $get->amountTendered;
            //$previousChangeDue = $get->changeDue;
            //$ref = $get->ref;
        }

        
        foreach($arrOfItemsDetails as $get){
            $itemCode = $get->_iC;
            $itemName = $this->genmod->getTableCol('products', 'name', 'code', $itemCode);
            $itemDescription = $this->genmod->getTableCol('products', 'description', 'code', $itemCode);
            //$itemUrduName = $this->genmod->getTableCol('items', 'urduName', 'code', $itemCode);
            //$itemDescription = $this->genmod->gettablecol('items', 'description', 'code', $itemCode);
            $qtySold = $get->qty;//qty selected for item in loop
            $unitPrice = $get->unitPrice;//unit price of item in loop
            $costPrice = $get->costUnitPrice;//unit price of item in loop
            $totalCostPrice = $get->totalCostPrice;//total cost price
            $temp1 = $get->totalPrice;
            $temp = explode(',',$temp1);
            $temp = implode('',$temp);
            $totalPrice = $temp;//total price for item in loop

            $temp1 = $get->totalProfitItem;
            $temp = explode(',',$temp1);
            $temp = implode('',$temp);
            $totalProfitItem = $temp;
            //$transId = $get->transId;

            
            // * add transaction to db
            // * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, //$_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             
            //$urduName = 'na';


            $transId = $this->transaction->add($itemCode, $qtySold, $unitPrice, $costPrice, $totalPrice, $totalCostPrice, $cumAmount, $remainingBalance, $previousBalance, $totalProfit, $invoiceTotal, $_at, $_cd, $ref, $discount_amount, $cust_name, $cust_id, $date1);
            //$transId = 1;
            
            $allTransInfo[$transId] = ['itemCode'=>$itemCode, 'costUnitPrice' => $costPrice, 'itemDescription'=>$itemDescription, 'itemName'=>$itemName, 'quantity'=>$qtySold, 'unitPrice'=>$unitPrice, 'totalPrice'=>$totalPrice];
            
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)
            $this->item->decrementItem($itemCode, $qtySold);
        }
        //$this->db->trans_complete();
        
        $incoming_cash = $_at - $_cd;
        //echo $incoming_cash;
        

        $transactionId = $this->AccountsTransaction->getTransactionId($ref,'productsSold');
        
        //$accountTransaction = [];
        $accountTransaction['accName'] = 'Cash in Hand';
        $accountTransaction['creditAmount'] = $incoming_cash;
        $accountTransaction['description'] = 'products sold';
        $accountTransaction['type'] = 'productsSold';
        $accountTransaction['transactionDate'] = $date1;
        $accountTransaction['referenceNo'] = $ref;

        //echo $accountTransaction['accName'];

        $this->AccountsTransaction->updateTransaction($transactionId[0]->transId,$accountTransaction);


        $previousIncomingCash = $transInfo[0]['amountTendered'] - $transInfo[0]['changeDue'];

        $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $accountTransaction['accName'] ) - $previousIncomingCash;
        //$accountData['lastUpdate'] = date('y-m-d');
        $this->Account->update(5,$accountData);

        $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $accountTransaction['accName'] ) + $incoming_cash;
        //$accountData['lastUpdate'] = date('y-m-d');
        $this->Account->update(5,$accountData);

        //echo $this->db->error();
        //$this->db->trans_complete();


        $this->db->trans_complete();//end transaction

        

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            
            return false;

        }
        
        else{
            $dataToReturn = [];
            
            //get transaction date in db, to be used on the receipt. It is necessary since date and time must matc
            $dateInDb = $this->genmod->getTableCol('transactions1', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genTransReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
        }
        
        
    }

    public function returnOrder(){

        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        
        $cumAmount = $this->input->post('_ca', TRUE);//cumulative amount
       
        $cust_name = $this->input->post('cn', TRUE);
        
        $receiptNo = $this->input->post('receiptNo', TRUE);
        $remainingBalance = $this->input->post('remainingBalance', TRUE);
        $previousBalance = $this->input->post('previousBalance', TRUE);//discount percentage
        $profitReduction = $this->input->post('profitReduction', TRUE);
        $amountPayable = $this->input->post('amountPayable', TRUE);
        $invoiceTotal = $this->input->post('invoiceTotal', TRUE);

        $date1 = $this->input->post('date1', TRUE);
        
       
        $allIsWell = TRUE;
        //echo $allIsWell;
        //echo "string";

        if($allIsWell){
            //echo "\nhere";
            //insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertReturnRow($arrOfItemsDetails,$cumAmount, $remainingBalance, $previousBalance, $profitReduction, $invoiceTotal, $amountPayable, $receiptNo, $cust_name, $date1);
            
            //$returnedData = TRUE;
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later "
                    . "or contact technical department for assistance";
            $json['transReceipt'] = $returnedData['transReceipt'];
            //echo $returnedData['transReceipt'];
            //list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            //$json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            //$json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($invoiceTotal, 2)
                    ." with reference number {$returnedData['transRef']} was returned";
            
            $this->genmod->addevent("Return Transaction", $returnedData['transRef'], $eventDesc, 'returnTransactions', $this->session->admin_id);

            
       }
        
        else{//return error msg
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
            //echo "here23";
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    

    private function insertReturnRow($arrOfItemsDetails,$cumAmount, $remainingBalance, $previousBalance, $profitReduction, $invoiceTotal, $amountPayable, $receiptNo, $cust_name , $date1){
        $allTransInfo = [];//to hold info of all items' in transaction
        
        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        $ref1 = $this->transaction->getMaxReturnRef();
        $ref = $ref1[0]->ref1 + 1;
        
        //loop through the items' details and insert them one by one
        //start transaction
        $this->db->trans_start();

        $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $cust_name);
        $customerData['outstandingBalance'] = $remainingBalance;
        $this->customer->update($cust_id, $customerData);


        
        foreach($arrOfItemsDetails as $get){
            $itemName = $get->_iN;
            $itemCode = $this->genmod->getTableCol('products', 'code', 'name', $itemName);
            //$itemUrduName = $this->genmod->getTableCol('items', 'urduName', 'code', $itemCode);
            //$itemDescription = $this->genmod->gettablecol('items', 'description', 'code', $itemCode);
            $qtySold = $get->qty;//qty selected for item in loop
            $unitPrice = $get->unitPrice;//unit price of item in loop
            $costPrice = $get->costUnitPrice;//unit price of item in loop
            //$totalCostPrice = $get->totalCostPrice;//total cost price
            $totalPrice = $get->totalPrice;//total price for item in loop
            //$totalProfitItem = $get->totalProfitItem;

            
            // * add transaction to db
            // * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, //$_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             
            //$urduName = 'na';


            $transId = $this->transaction->addReturn($itemName, $itemCode, $qtySold, $unitPrice, $costPrice, $totalPrice, $cumAmount, $remainingBalance, $previousBalance, $profitReduction, $invoiceTotal, $amountPayable, $ref, $receiptNo, $cust_name, $cust_id, $date1);
            //$transId = 1;
            
            $allTransInfo[$transId] = ['itemCode'=>$itemCode,'itemName'=>$itemName, 'quantity'=>$qtySold, 'unitPrice'=>$unitPrice, 'totalPrice'=>$totalPrice];
            
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)
            $this->item->incrementItem($itemCode, $qtySold);
        }
        //$this->db->trans_complete();
        
        //$incoming_cash = $_at - $_cd;
        //echo $incoming_cash;
        
        //$customerTransaction = [];
        
        
            //$creditEntry = $previousBalance - $remainingBalance;
            //$customerTransaction['customerId'] = $cust_id;
            //$customerTransaction['debitAmount'] = $amountPayable;
            //$customerTransaction['creditAmount'] = $invoiceTotal;
            //$customerTransaction['description'] = 'products returned';
            //$customerTransaction['transactionDate'] = date('y-m-d');
            //$customerTransaction['referenceNo'] = $receiptNo;
            //$this->CustomerTransaction->insert($customerTransaction);    
        
        


        if($amountPayable === '0'){
        }
        else{

            $accountTransaction['accName'] = 'Cash in Hand';
            $accountTransaction['debitAmount'] = $amountPayable;
            $accountTransaction['description'] = 'products returned';
            $accountTransaction['type'] = 'productReturned';
            $accountTransaction['transactionDate'] =  $date1;
            $accountTransaction['referenceNo'] = $ref;

            //echo $accountTransaction['accName'];

            $this->AccountsTransaction->insert($accountTransaction);
            $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $accountTransaction['accName'] ) - $amountPayable;
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData);

        }
        //$accountTransaction = [];
        
        
        

        //echo $this->db->error();
        //$this->db->trans_complete();


        $this->db->trans_complete();//end transaction

        

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            
            return false;

        }
        
        else{
            
            $dataToReturn = [];
            
            //get transaction date in db, to be used on the receipt. It is necessary since date and time must matc
            $dateInDb = $this->genmod->getTableCol('returnTransactions', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genReturnReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $profitReduction, $amountPayable, $ref, $dateInDb,  $cust_name);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
            
        }
        
        
    }

    
    /**
     * Validates the details of items sent from client to prevent manipulation
     * @param type $arrOfItemsInfo
     * @param type $cumAmountFromClient
     * @param type $amountTendered
     * @param type $vatPercentage
     * @param type $discount_percentage
     * @return boolean
     */
    private function validateItemsDet($arrOfItemsInfo, $cumAmountFromClient, $amountTendered, $discount_percentage, $previousBalance){
        $error = 0;
        
        //loop through the item's info and validate each
        //return error if at least one seems suspicious (i.e. fails validation)
        foreach ($arrOfItemsInfo as $get){
            $itemCode = $get->_iC;//use this to get the item's unit price, then multiply it with the qty sent from client
            $qtyToBuy = $get->qty;
            $unitPriceFromClient = $get->unitPrice;
            $unitPriceInDb = $this->genmod->gettablecol('products', 'sellingPrice', 'code', $itemCode);
            $totPriceFromClient = $get->totalPrice;
            
            //ensure both unit price matches
            $unitPriceInDb == $unitPriceFromClient ? "" : $error++;
            
            $expectedTotPrice = round($qtyToBuy*$unitPriceInDb, 2);//calculate expected totPrice
            
            //ensure both matches
            $expectedTotPrice == $totPriceFromClient ? "" : $error++;
            
            //no need to validate others, just break out of the loop if one fails validation
            if($error > 0){
                return FALSE;
            }
            
            $this->total_before_discount += $expectedTotPrice;
        }
        
        /**
         * We need to save the total price before tax, tax amount, total price after tax, discount amount, eventual total
         */
        
        $expectedCumAmount = $this->total_before_discount + $previousBalance;
        
        //now calculate the discount amount (if there is discount) based on the discount percentage and subtract it(discount amount) 
        //from $total_before_discount
        if($discount_percentage){
            $this->discount_amount = $this->getDiscountAmount($expectedCumAmount, $discount_percentage);

            $expectedCumAmount = round($expectedCumAmount - $this->discount_amount, 2);
        }
        
                
        
        //check if cum amount also matches and ensure amount tendered is not less than $expectedCumAmount
        if(($expectedCumAmount != $cumAmountFromClient) || ($expectedCumAmount > $amountTendered)){
            return FALSE;
        }
        
        //if code execution reaches here, it means all is well
        $this->eventual_total = $expectedCumAmount;
        return TRUE;
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
     * @param type $allTransInfo
     * @param type $cumAmount
     * @param type $_at
     * @param type $_cd
     * @param type $ref
     * @param type $transDate
     * @param type $_mop
     * @param type $vatAmount
     * @param type $vatPercentage
     * @param type $discount_amount
     * @param type $discount_percentage
     * @param type $cust_name
     * @param type $cust_phone
     * @param type $cust_email
     * @return type
     */
    private function genTransReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name){
        $data['allTransInfo'] = $allTransInfo;
        $data['invoiceTotal'] = $invoiceTotal;
        $data['cumAmount'] = $cumAmount;
        $data['amountTendered'] = $_at;
        $data['changeDue'] = $_cd;
        $data['ref'] = $ref;
        $data['transDate'] = $dateInDb;
        $data['previousBalance'] = $previousBalance;
        $data['remainingBalance'] = $remainingBalance;
        
        $data['discountAmount'] = $discount_amount;
        
        $data['cust_name'] = $cust_name;
        
        //generate and return receipt
        $transReceipt = $this->load->view('transactions/transReceipt', $data, TRUE);
        
        return $transReceipt;
    }

    private function genQuotationReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name){
        $data['allTransInfo'] = $allTransInfo;
        $data['invoiceTotal'] = $invoiceTotal;
        $data['cumAmount'] = $cumAmount;
        $data['amountTendered'] = $_at;
        $data['changeDue'] = $_cd;
        $data['ref'] = $ref;
        $data['transDate'] = $dateInDb;
        $data['previousBalance'] = $previousBalance;
        $data['remainingBalance'] = $remainingBalance;
        
        $data['discountAmount'] = $discount_amount;
        
        $data['cust_name'] = $cust_name;
        
        //generate and return receipt
        $transReceipt = $this->load->view('transactions/quotationReceipt', $data, TRUE);
        
        return $transReceipt;
    }

    private function genReturnReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $profitReduction, $amountPayable, $ref, $dateInDb, $cust_name){
        $data['allTransInfo'] = $allTransInfo;
        $data['invoiceTotal'] = $invoiceTotal;
        $data['cumAmount'] = $cumAmount;
        $data['amountPayable'] = $amountPayable;
        //$data['changeDue'] = $_cd;
        $data['ref'] = $ref;
        $data['transDate'] = $dateInDb;
        $data['previousBalance'] = $previousBalance;
        $data['remainingBalance'] = $remainingBalance;
        
        //$data['discountAmount'] = $discount_amount;
        
        $data['cust_name'] = $cust_name;
        
        //generate and return receipt
        $transReceipt = $this->load->view('transactions/returnReceipt', $data, TRUE);
        
        return $transReceipt;
    }
    
    
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * vtr_ = "View transaction's receipt"
     * Used when a transaction's ref is clicked
     */
    public function vtr_(){
        //$this->genlib->ajaxOnly();
        
        $ref = $this->input->post('ref');

        //$allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name
        
        $transInfo = $this->transaction->getTransInfo($ref);
        
        //loop through the transInfo to get needed info
        
        if($transInfo){
            $json['status'] = 1;
            
            $invoiceTotal = $transInfo[0]['invoiceTotal'];
            $cumAmount = $transInfo[0]['cumulativeAmount'];
            $previousBalance = $transInfo[0]['previousBalance'];
            $dateInDb = $transInfo[0]['transDate'];
            $remainingBalance = $transInfo[0]['remainingBalance'];
            $_at = $transInfo[0]['amountTendered'];
            $_cd = $transInfo[0]['changeDue'];
            $discountAmount = $transInfo[0]['discount_amount'];
            $cust_name = $transInfo[0]['cust_name'];
            
            //echo $cust_name;
            $json['transReceipt'] = $this->genTransReceipt($transInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discountAmount, $cust_name);
        }
        
        else{
            $json['status'] = 0;
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
        
    }

    public function vtrR(){
        //$this->genlib->ajaxOnly();
        
        $ref = $this->input->post('ref');

        //$allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name
        
        $transInfo = $this->transaction->getReturnTranInfo($ref);
        
        //loop through the transInfo to get needed info
        
        if($transInfo){
            $json['status'] = 1;
            
            $invoiceTotal = $transInfo[0]['invoiceTotal'];
            $cumAmount = $transInfo[0]['cumulativeAmount'];
            $previousBalance = $transInfo[0]['previousBalance'];
            $dateInDb = $transInfo[0]['transDate'];
            $remainingBalance = $transInfo[0]['remainingBalance'];
            $profitReduction = $transInfo[0]['profitReduction'];
            $amountPayable = $transInfo[0]['amountPayable'];
            //$discountAmount = $transInfo[0]['discount_amount'];
            $cust_name = $transInfo[0]['cust_name'];
            
            //echo $cust_name;
            $json['transReceipt'] = $this->genReturnReceipt($transInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $profitReduction, $amountPayable, $ref, $dateInDb, $cust_name);
        }        
        else{
            $json['status'] = 0;
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
        
    }
    
    /*
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * Calculates the amount of VAT
     * @param type $cumAmount the total amount to calculate the VAT from
     * @param type $vatPercentage the percentage of VAT
     * @return type
     */
    private function getVatAmount($cumAmount, $vatPercentage){
        $vatAmount = ($vatPercentage/100) * $cumAmount;

        return $vatAmount;
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    /**
     * Calculates the amount of Discount
     * @param type $cum_amount the total amount to calculate the discount from
     * @param type $discount_percentage the percentage of discount
     * @return type
     */
    private function getDiscountAmount($cum_amount, $discount_percentage){
        $discount_amount = ($discount_percentage/100) * $cum_amount;

        return $discount_amount;
    }
    
    /*
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    ****************************************************************************************************************************
    */
    
    public function report($from_date, $to_date=''){        
        //get all transactions from db ranging from $from_date to $to_date
        $data['from'] = $from_date;
        $data['to'] = $to_date ? $to_date : date('Y-m-d');
        
        $data['allTransactions'] = $this->transaction->getDateRange($from_date, $to_date);
        
        $this->load->view('transactions/transReport', $data);
    }

    public function delete(){
        $this->genlib->ajaxOnly();
        
        $json['status'] = 0;
        $transRef = $this->input->post('transRef', TRUE);
        if($transRef){
        $transInfo = $this->transaction->getTransInfo($transRef);

        $this->db->trans_start();


        foreach($transInfo as $get){
            $itemCode = $get['itemCode'];
            $itemQuantity = $get['quantity'];
            //$itemId = $this->genmod->gettablecol('items', 'id', 'code', $itemCode);
            $updated = $this->item->incrementItem($itemCode,$itemQuantity);
            //if(!$updated){
              //  $json['status1'] = 100;
            //}

        }
        $cust_id = $transInfo[0]['cust_id'];
        //$itemId = $this->genmod->gettablecol('items', 'id', 'code', $itemCode);
        $invoiceTotal = $transInfo[0]['invoiceTotal'];
        //$cumulativeTotal = $transInfo[0]['cumulativeTotal'];
        $amountTendered = $transInfo[0]['amountTendered'];
        $changeDue = $transInfo[0]['changeDue'];
        //$difference = $cumulativeTotal - $invoiceTotal;
        $customerData['outstandingBalance'] = $this->genmod->gettablecol('customers', 'outstandingBalance', 'id', $cust_id) + $transInfo[0]['previousBalance'] - $transInfo[0]['remainingBalance'] ;
        $this->customer->update($cust_id, $customerData);

        $transid1 = $this->AccountsTransaction->getTransactionId($transRef, 'productsSold');

        $transid1 = $transid1[0]->transId; 
        $creditAmount = $this->genmod->gettablecol('accountTransactions', 'creditAmount', 'transId', $transid1);
        $this->db->where('transId', $transid1)->delete('accountTransactions');
        $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) - $creditAmount;
            //$accountData['lastUpdate'] = date('y-m-d');
        $this->Account->update(5,$accountData);


        $this->db->where('ref', $transRef)->delete('transactions1');
            //$this->db->where('ref', $transRef)->delete('transactions');
        $eventDesc = "Transaction with ref no: ".$transRef."was deleted";
            
        $this->genmod->addevent("Delete Transaction", $transRef, $eventDesc, 'transactions1', $this->session->admin_id);
            
        $json['status'] = 1;
        $json['itemCode'] = $itemCode;

        $this->db->trans_complete();

        
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    }
    public function deleteReturn(){
        $this->genlib->ajaxOnly();
        
        $json['status'] = 0;
        $transRef = $this->input->post('transRef', TRUE);
        if($transRef){
        $transInfo = $this->transaction->getReturnTranInfo($transRef);

        $this->db->trans_start();


        foreach($transInfo as $get){
            $itemCode = $get['itemCode'];
            $itemQuantity = $get['quantity'];
            //$itemId = $this->genmod->gettablecol('items', 'id', 'code', $itemCode);
            $updated = $this->item->decrementItem($itemCode,$itemQuantity);
            //if(!$updated){
              //  $json['status1'] = 100;
            //}

        }
        $cust_id = $transInfo[0]['cust_id'];
        $invoiceTotal = $transInfo[0]['invoiceTotal'];
        //$cumulativeTotal = $transInfo[0]['cumulativeTotal'];
        $amountPayable = $transInfo[0]['amountPayable'];
        //$itemId = $this->genmod->gettablecol('items', 'id', 'code', $itemCode);
        //$previousBalance = $transInfo[0]['previousBalance'];
        $customerData['outstandingBalance'] = $this->genmod->gettablecol('customers', 'outstandingBalance', 'id', $cust_id) + $invoiceTotal - $amountPayable;
        $this->customer->update($cust_id, $customerData);
        //$amountPayable = $transInfo[0]['amountPayable'];
        
        $debitAmount = $this->genmod->gettablecol('accountTransactions', 'debitAmount', 'referenceNo', $transRef);
        $this->db->where('referenceNo', $transRef)->delete('accountTransactions');  
        $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) + $debitAmount;
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData); 
        

        //$creditAmount = $this->genmod->gettablecol('accountTransactions', 'creditAmount', 'referenceNo', $transRef);
        //$this->db->where('referenceNo', $transRef)->delete('accountTransactions');
        


        $this->db->where('returnRef', $transRef)->delete('returnTransactions');
            //$this->db->where('ref', $transRef)->delete('transactions');
        $eventDesc = "Return Transaction with ref no: ".$transRef."was deleted";
            
        $this->genmod->addevent("Delete Return Transaction", $transRef, $eventDesc, 'returnTransactions', $this->session->admin_id);
            
        $json['status'] = 1;
        $json['itemCode'] = $itemCode;

        $this->db->trans_complete();

        
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    }
}