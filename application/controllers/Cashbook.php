<?php
defined('BASEPATH') OR exit('');
require_once 'functions.php';

class Cashbook extends CI_Controller{
    private $total_before_discount = 0, $discount_amount = 0, $vat_amount = 0, $eventual_total = 0;
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        
        $this->load->model(['transaction', 'item','customer','CustomerTransaction','AccountsTransaction', 'account', 'vendor','expense','HomeExpense']);
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
        $data['pageContent'] = $this->load->view('cashbook/transactions', $transData, TRUE);
        $data['pageTitle'] = "Cashbook";
        
        $this->load->view('main', $data);
    }

    public function allTransactions(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $data['pageContent'] = $this->load->view('cashbook/allCashTransactions', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
    }

    public function dailyCashBook(){
        $date = date('y-m-d');
        if($this->session->flashdata('date1')){ 
            $date = $this->session->flashdata('date1'); 
         }            
    
        
        //$date = date('2020-07-16');
        
        list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        $dataArray1['allTransactions'] = $this->transaction->getReturnTransactionsByDate($date);
        $totalRevenueReduction = 0;
        $profitTotalReduction = 0;
        if($dataArray1['allTransactions']){
        foreach($dataArray1['allTransactions'] as $get){
            $profitTotalReduction+=$get->profitReduction;
            $totalRevenueReduction+=$get->invoiceTotal;
        }
        }
        $totalCashToday = $this->AccountsTransaction->getDailyCash($date);
        $totalCashMinusToday = $this->AccountsTransaction->getDailyCashMinus($date);
        $totalRevenue = $totalCashToday[0]->sumCredit - $totalCashMinusToday[0]->sumDebit;
        $profitTotal = $profit - $profitTotalReduction;

        $expenseDetails = $this->AccountsTransaction->getExpenseByDate($date);
        $totalExpenses = 0;
        if($expenseDetails){
        foreach($expenseDetails as $get){
            if($get->referenceNo === 'gola' || $get->referenceNo === 'hardware'){
            
        }else{
            //echo "amount: ", $get->sum1;
            //echo "type: ", $get->type;
            //echo "detail: ", $get->referenceNo;
            //echo "<br>";
            $totalExpenses+=$get->sum1;
        }

        }
        }

        //echo "\nTotal Expenses: " , $totalExpenses;
        //echo "<br>";
        $netProfit = $profitTotal - $totalExpenses;

        $outputA['Revenue'] = $totalRevenue;
        $outputA['Profit'] = $profitTotal;
        $outputA['ExpenseTotal'] = $totalExpenses;
        $outputA['NetProfit'] = $netProfit;

        $hardwareCash = $this->account->getCashHand('hardwareDb');
        $outputA['hardwareCash'] = $hardwareCash[0]->balance;

        $golaCash = $this->account->getCashHand('golaDb');
        $outputA['golaCash'] = $golaCash[0]->balance;
        $plyCash = $this->genmod->gettablecol('accounts', 'balance', 'id', 5 ) ;
        $outputA ['totalCash'] = $plyCash + $outputA['hardwareCash'] + $outputA['golaCash'];


        $data['allTransactions'] = $this->transaction->getDailyTransactions($date);
        $data['sn'] = 1;
        $dataArray['Cash'] = $this->AccountsTransaction->getDailyIncoming($date);
        $dataArray['sn'] = 1;
        $dataArray['flag'] = 'From';
        $dataArray['heading']='INCOMING CASH TRANSACTIONS';
        $outputA['incoming'] = $this->load->view('cashbook/dailyTable', $dataArray, TRUE);
        $dataArray['Cash'] = $this->AccountsTransaction->getDailyOutgoing($date); 
        $dataArray['heading']='OUTGOING CASH TRANSACTIONS';
        $dataArray['flag'] = 'To';
        $outputA['outgoing'] = $this->load->view('cashbook/dailyTable', $dataArray, TRUE);
        
        $outputA['transTable'] = $this->load->view('cashbook/transtable', $data, TRUE);//get view with populated transactions table
        $outputA['date1'] = $date;

        $data['pageContent'] = $this->load->view('cashbook/dailyCashBook', $outputA, TRUE);
        $data['pageTitle'] = "Cashbook";
        
        $this->load->view('main', $data);

        //$this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function incomingCash(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $transData["accountss"] = $this->account->getAll();
        $transData["payable"] = $this->account->getAllPayable();
        $transData["receivable"] = $this->account->getAllReceivable();
        $data['pageContent'] = $this->load->view('cashbook/incomingCash', $transData, TRUE);
        $data['pageTitle'] = "Cashbook";
        
        $this->load->view('main', $data);
    }
    public function incomingCashEdit($transId){
        $transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $transData["accountss"] = $this->account->getAll();
        $transData["payable"] = $this->account->getAllPayable();
        $transData["receivable"] = $this->account->getAllReceivable();
        $data['pageContent'] = $this->load->view('cashbook/incomingCashEdit', $transData, TRUE);
        $data['pageTitle'] = "Cashbook";
        
        $this->load->view('main', $data);
        
    }
    public function outgoingCashEdit($transId){
        $transData['vendors'] = $this->vendor->getActive();//get items with at least one qty left, to be used when doing a new transaction
        $transData['shopExpenseCategory'] = $this->expense->getAllCategory();
        $transData['homeExpenseCategory'] = $this->HomeExpense->getAllCategory();
        $transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData["payable"] = $this->account->getAllPayable();
        $transData["receivable"] = $this->account->getAllReceivable();
        $transData['customers'] = $this->customer->getAll();
        $transData["accountss"] = $this->account->getAll();
        $data['pageContent'] = $this->load->view('cashbook/outgoingCashEdit', $transData, TRUE);
        $data['pageTitle'] = "Cashbook";
        
        $this->load->view('main', $data);
        
    }

    public function outgoingCash(){
        $transData['vendors'] = $this->vendor->getActive();//get items with at least one qty left, to be used when doing a new transaction
        $transData['shopExpenseCategory'] = $this->expense->getAllCategory();
        $transData['homeExpenseCategory'] = $this->HomeExpense->getAllCategory();
        $transData["accountss"] = $this->account->getAll();
        $transData["payable"] = $this->account->getAllPayable();
        $transData['customers'] = $this->customer->getAll();
        $transData["receivable"] = $this->account->getAllReceivable();
        $data['pageContent'] = $this->load->view('cashbook/outgoingCash', $transData, TRUE);
        $data['pageTitle'] = "Cashbook";
        
        $this->load->view('main', $data);
    }

    public function returnProduct(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['customers'] = $this->customer->getAll();//get customers 
        $data['pageContent'] = $this->load->view('transactions/returnTransaction', $transData, TRUE);
        $data['pageTitle'] = "Transactions";
        
        $this->load->view('main', $data);
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
        $totalTransactions = $this->AccountsTransaction->totalTransactions();
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
    
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalTransactions, "cashbook/latr_", $limit, ['onclick'=>'return latr_(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all transactions from db
        //$date = date('y-m-d');
        $data['allTransactions'] = $this->AccountsTransaction->getAllTrans($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalTransactions > 0 ? ($start+1) . "-" . ($start + count($data['allTransactions'])) . " of " . $totalTransactions : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        
        $json['transTable'] = $this->load->view('cashbook/allCashTable', $data, TRUE);//get view with populated transactions table
        //$json['transTable'] = 1;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    public function loadDailyCashBook(){
       
        $date = $this->input->get('date1', TRUE);


        list($profit,$total_earned_today) = $this->transaction->totalEarnedByDate($date);
        $dataArray1['allTransactions'] = $this->transaction->getReturnTransactionsByDate($date);
        $totalRevenueReduction = 0;
        $profitTotalReduction = 0;
        if($dataArray1['allTransactions']){
        foreach($dataArray1['allTransactions'] as $get){
            $profitTotalReduction+=$get->profitReduction;
            $totalRevenueReduction+=$get->invoiceTotal;
        }
        }
        $totalCashToday = $this->AccountsTransaction->getDailyCash($date);
        $totalCashMinusToday = $this->AccountsTransaction->getDailyCashMinus($date);
        $totalRevenue = $totalCashToday[0]->sumCredit - $totalCashMinusToday[0]->sumDebit;
        $profitTotal = $profit - $profitTotalReduction;

        $expenseDetails = $this->AccountsTransaction->getExpenseByDate($date);
        $totalExpenses = 0;
        if($expenseDetails){
        foreach($expenseDetails as $get){
            if($get->referenceNo === 'gola' || $get->referenceNo === 'hardware'){
            
        }else{
            //echo "amount: ", $get->sum1;
            //echo "type: ", $get->type;
            //echo "detail: ", $get->referenceNo;
            //echo "<br>";
            $totalExpenses+=$get->sum1;
        }

        }
        }

        //echo "\nTotal Expenses: " , $totalExpenses;
        //echo "<br>";
        $netProfit = $profitTotal - $totalExpenses;

        $json['Revenue'] = $totalRevenue;
        $json['Profit'] = $profitTotal;
        $json['ExpenseTotal'] = $totalExpenses;
        $json['NetProfit'] = $netProfit;

        $json['NetProfit'] = $netProfit;

        //$hardwareCash = $this->account->getHardwareCash('hardwareDb');
        //$json['hardwareCash'] = $hardwareCash[0]->balance;
        //$json['ProfitHardware'] = $netProfit;        

        //$golaCash = $this->account->getHardwareCash('golaDb');
        //$json['golaCash'] = $golaCash[0]->balance;



        $data['allTransactions'] = $this->transaction->getDailyTransactions($date);
        $data['sn'] = 1;
        $dataArray['Cash'] = $this->AccountsTransaction->getDailyIncoming($date);
        $dataArray['sn'] = 1;
        $dataArray['flag'] = 'From';
        $dataArray['heading']='INCOMING CASH TRANSACTIONS';
        $json['incoming'] = $this->load->view('cashbook/dailyTable', $dataArray, TRUE);
        $dataArray['Cash'] = $this->AccountsTransaction->getDailyOutgoing($date); 
        $dataArray['heading']='OUTGOING CASH TRANSACTIONS';
        $dataArray['flag'] = 'To';
        $json['outgoing'] = $this->load->view('cashbook/dailyTable', $dataArray, TRUE);
        
        $json['transTable'] = $this->load->view('cashbook/transtable', $data, TRUE);//get view with populated transactions table
        
        $json['date1'] = $date;

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    public function addIncomingPost(){
        
        
        $data['accName'] = 'Cash in Hand';
        $data['type'] = $this->input->post('category');
        $data['referenceNo'] = $this->input->post('from');
        $creditAmount = $this->input->post('amount');
        $temp = explode(',',$creditAmount);
        $temp = implode('',$temp);
        $data['creditAmount'] = $temp;
        $data['transactionDate'] = $this->input->post('date1');
        $data['description'] = $this->input->post('description');
        $data['hlink'] = $this->input->post('hlink');
        //echo "string";
        //$this->session->set_flashdata('success', 'Accounts added Successfully');
        
        
        $this->db->trans_start();
        $transId = $this->AccountsTransaction->insert($data);

        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) + $data['creditAmount'];
        $this->account->update($accId,$cashData);
        
        switch ($data['type']) {
            case '0':
                break;
            case 'rent':
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $data['referenceNo']);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $data['referenceNo']);
                $customerData['outstandingBalance'] = $cust_balance - $data['creditAmount'];
                $customerData['lastPayment'] = $data['creditAmount'];
                $customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) - $data['creditAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) + $data['creditAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) - $data['creditAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $data['type']);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['type'] ) + $data['creditAmount'];
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $data['type']);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['type'] ) + $data['creditAmount'];
                $this->account->update($accId,$accountData);
                break;
        }
        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('success', 'Transaction not added Successfully');
            redirect('incoming-cash');
        }
        else{
            $this->session->set_flashdata('success', 'Transaction added Successfully');
            redirect('incoming-cash');
        }
        

    }
    public function editIncomingPost(){
        
        
        $data['accName'] = 'Cash in Hand';
        $data['type'] = $this->input->post('category');
        $data['referenceNo'] = $this->input->post('from');
        $creditAmount = $this->input->post('amount');
        $temp = explode(',',$creditAmount);
        $temp = implode('',$temp);
        $data['creditAmount'] = $temp;
        $data['transactionDate'] = $this->input->post('date1');
        $data['description'] = $this->input->post('description');
        $data['hlink'] = $this->input->post('hlink');
        $transId = $this->input->post('transId');
        $transData = $this->AccountsTransaction->getTransDataById($transId);

        //echo "string";
        //$this->session->set_flashdata('success', 'Accounts added Successfully');
        
        
        $this->db->trans_start();

        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) - $transData[0]->creditAmount;
        $this->account->update($accId,$cashData);






        $transId = $this->AccountsTransaction->updateTransaction($transId,$data);


        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) + $data['creditAmount'];
        $this->account->update($accId,$cashData);


        switch ($transData[0]->type) {
            case '0':
                break;
            case 'rent':
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $transData[0]->referenceNo);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $transData[0]->referenceNo);
                $customerData['outstandingBalance'] = $cust_balance + $transData[0]->creditAmount;
                //$customerData['lastPayment'] = $data['creditAmount'];
                //$customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);$transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) - $transData[0]->creditAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo );
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);$transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) + $transData[0]->creditAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo );
                $this->account->update($accId,$accountData);
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);$transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) + $transData[0]->creditAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo );
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $transData[0]->type);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->type ) - $transData[0]->creditAmount;
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', 'pvcDoor');
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['type'] ) - $transData[0]->creditAmount;
                $this->account->update($accId,$accountData);
                break;
        }

        
        switch ($data['type']) {
            case '0':
                break;
            case 'rent':
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $data['referenceNo']);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $data['referenceNo']);
                $customerData['outstandingBalance'] = $cust_balance - $data['creditAmount'];
                $customerData['lastPayment'] = $data['creditAmount'];
                $customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) + $data['creditAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) - $data['creditAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);$transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) - $data['creditAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $data['type']);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['type'] ) + $data['creditAmount'];
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $data['type']);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['type'] ) + $data['creditAmount'];
                $this->account->update($accId,$accountData);
                break;
        }
        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('success', 'Transaction not updated Successfully');
            $this->session->set_flashdata('date1', $transData[0]->transactionDate);
            redirect('Cashbook/dailyCashBook');
        }
        else{
            $this->session->set_flashdata('success', 'Transaction updated Successfully');
            $this->session->set_flashdata('date1', $data['transactionDate']);
            redirect('Cashbook/dailyCashBook');
        }
        

    }

    public function deleteIncomingPost($transId){
        
        
        $data['accName'] = 'Cash in Hand';
        
        //$transId = $this->input->post('transId');
        $transData = $this->AccountsTransaction->getTransDataById($transId);

        //echo "string";
        //$this->session->set_flashdata('success', 'Accounts added Successfully');
        
        
        $this->db->trans_start();

        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) - $transData[0]->creditAmount;
        $this->account->update($accId,$cashData);

        $this->AccountsTransaction->deleteTransaction($transId);




        switch ($transData[0]->type) {
            case '0':
                break;
            case 'rent':
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $transData[0]->referenceNo);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $transData[0]->referenceNo);
                $customerData['outstandingBalance'] = $cust_balance + $transData[0]->creditAmount;
                //$customerData['lastPayment'] = $data['creditAmount'];
                //$customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);$transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) + $transData[0]->creditAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo );
                $this->account->update($accId,$accountData);
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);$transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) - $transData[0]->creditAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo );
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);$transData['transaction'] = $this->AccountsTransaction->getTransDataById($transId);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) + $transData[0]->creditAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo );
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $transData[0]->type);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->type ) - $transData[0]->creditAmount;
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  'pvcDoor');
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) - $transData[0]->creditAmount;
                $this->account->update($accId,$accountData);
                break;
        }

        
        
        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('success', 'Transaction not deleted Successfully');
            $this->session->set_flashdata('date1', $transData[0]->transactionDate);
            redirect('Cashbook/dailyCashBook');
        }
        else{
            $this->session->set_flashdata('success', 'Transaction deleted Successfully');
            $this->session->set_flashdata('date1', $transData[0]->transactionDate);
            redirect('Cashbook/dailyCashBook');
        }
        

    }
    public function addOutgoingPost(){
        
        
        $data['accName'] = 'Cash in Hand';
        $data['type'] = $this->input->post('category');
        $data['referenceNo'] = $this->input->post('to');
        $debitAmount = $this->input->post('amount');
        $temp = explode(',',$debitAmount);
        $temp = implode('',$temp);
        $data['debitAmount'] = $temp;
        //$data['debitAmount'] = $this->input->post('amount');
        $data['transactionDate'] = $this->input->post('date1');
        $data['description'] = $this->input->post('description');
        $data['hlink'] = $this->input->post('hlink');
        //echo "string";
        //$this->session->set_flashdata('success', 'Accounts added Successfully');

        
        
        $this->db->trans_start();
        $transId = $this->AccountsTransaction->insert($data);

        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) - $data['debitAmount'];
        $this->account->update($accId,$cashData);
        
        switch ($data['type']) {
            case 'vendor':
                $vendor_id = $this->genmod->getTableCol('vendors', 'id', 'companyName', $data['referenceNo']);
                $vendor_balance = $this->genmod->getTableCol('vendors', 'outstandingBalance', 'companyName', $data['referenceNo']);
                $vendorData['outstandingBalance'] = $vendor_balance - $data['debitAmount'];
                $vendorData['lastPayment'] = $data['debitAmount'];
                $vendorData['lastPaymentDate'] = $data['transactionDate'];
                $this->vendor->update($vendor_id, $vendorData); 
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $data['referenceNo']);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $data['referenceNo']);
                $customerData['outstandingBalance'] = $cust_balance + $data['debitAmount'];
                //$customerData['lastPayment'] = $data['creditAmount'];
                //$customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) + $data['debitAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) - $data['debitAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) + $data['debitAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $data['type']);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['type'] ) - $data['debitAmount'];
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  'pvcDoor');
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'pvcDoor' ) - $data['debitAmount'];
                $this->account->update($accId,$accountData);
                break;
        }
        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('success', 'Transaction not added Successfully');
            redirect('outgoing-cash');
        }
        else{
            $this->session->set_flashdata('success', 'Transaction added Successfully');
            redirect('outgoing-cash');
        }
        

    }

    public function editOutgoingPost(){
        
        
        $data['accName'] = 'Cash in Hand';
        $data['type'] = $this->input->post('category');
        $data['referenceNo'] = $this->input->post('to');
        $debitAmount = $this->input->post('amount');
        $temp = explode(',',$debitAmount);
        $temp = implode('',$temp);
        $data['debitAmount'] = $temp;
        $data['transactionDate'] = $this->input->post('date1');
        $data['description'] = $this->input->post('description');
        $data['hlink'] = $this->input->post('hlink');

        //echo "string";
        //$this->session->set_flashdata('success', 'Accounts added Successfully');
        $transId = $this->input->post('transId');
        $transData = $this->AccountsTransaction->getTransDataById($transId);
        
        
        $this->db->trans_start();
        //$transId = $this->AccountsTransaction->insert($data);

        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) + $transData[0]->debitAmount;
        $this->account->update($accId,$cashData);

        $transId = $this->AccountsTransaction->updateTransaction($transId,$data);


        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) - $data['debitAmount'];
        $this->account->update($accId,$cashData);


        switch ($transData[0]->type) {
            case 'vendor':
                $vendor_id = $this->genmod->getTableCol('vendors', 'id', 'companyName', $transData[0]->referenceNo);
                $vendor_balance = $this->genmod->getTableCol('vendors', 'outstandingBalance', 'companyName', $transData[0]->referenceNo);
                $vendorData['outstandingBalance'] = $vendor_balance + $transData[0]->debitAmount;
                //$vendorData['lastPayment'] = $data['creditAmount'];
                //$vendorData['lastPaymentDate'] = $data['transactionDate'];
                $this->vendor->update($vendor_id, $vendorData); 
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $data['referenceNo']);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $transData[0]->referenceNo);
                $customerData['outstandingBalance'] = $cust_balance - $transData[0]->debitAmount;
                //$customerData['lastPayment'] = $data['creditAmount'];
                //$customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) - $transData[0]->debitAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo);
                $this->account->update($accId,$accountData);
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) + $transData[0]->debitAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo);
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) - $transData[0]->debitAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo);
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $transData[0]->type);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->type ) + $transData[0]->debitAmount;
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  'pvcDoor');
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'pvcDoor' ) + $transData[0]->debitAmount;
                $this->account->update($accId,$accountData);
                break;
        }
        

        switch ($data['type']) {
            case 'vendor':
                $vendor_id = $this->genmod->getTableCol('vendors', 'id', 'companyName', $data['referenceNo']);
                $vendor_balance = $this->genmod->getTableCol('vendors', 'outstandingBalance', 'companyName', $data['referenceNo']);
                $vendorData['outstandingBalance'] = $vendor_balance - $data['debitAmount'];
                $vendorData['lastPayment'] = $data['debitAmount'];
                $vendorData['lastPaymentDate'] = $data['transactionDate'];
                $this->vendor->update($vendor_id, $vendorData); 
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $data['referenceNo']);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $data['referenceNo']);
                $customerData['outstandingBalance'] = $cust_balance + $data['debitAmount'];
                //$customerData['lastPayment'] = $data['creditAmount'];
                //$customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) + $data['debitAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) - $data['debitAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['referenceNo'] ) + $data['debitAmount'];
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['referenceNo'] );
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $data['type']);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['type'] ) - $data['debitAmount'];
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  'pvcDoor');
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'pvcDoor' ) - $data['debitAmount'];
                $this->account->update($accId,$accountData);
                break;
        }
        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('success', 'Transaction not updated Successfully');
            $this->session->set_flashdata('date1', $transData[0]->transactionDate);
            redirect('Cashbook/dailyCashBook');
        }
        else{
            $this->session->set_flashdata('success', 'Transaction updated Successfully');
            $this->session->set_flashdata('date1', $data['transactionDate']);
            redirect('Cashbook/dailyCashBook');
        }
        

    }

    public function deleteOutgoingPost($transId){
        
        
        $data['accName'] = 'Cash in Hand';
        //echo "string";
        //$this->session->set_flashdata('success', 'Accounts added Successfully');
        //$transId = $this->input->post('transId');
        $transData = $this->AccountsTransaction->getTransDataById($transId);
        
        
        $this->db->trans_start();
        //$transId = $this->AccountsTransaction->insert($data);

        $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $data['accName'] );
        $cashData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $data['accName'] ) + $transData[0]->debitAmount;
        $this->account->update($accId,$cashData);

        $this->AccountsTransaction->deleteTransaction($transId);


        


        switch ($transData[0]->type) {
            case 'vendor':
                $vendor_id = $this->genmod->getTableCol('vendors', 'id', 'companyName', $transData[0]->referenceNo);
                $vendor_balance = $this->genmod->getTableCol('vendors', 'outstandingBalance', 'companyName', $transData[0]->referenceNo);
                $vendorData['outstandingBalance'] = $vendor_balance + $transData[0]->debitAmount;
                //$vendorData['lastPayment'] = $data['creditAmount'];
                //$vendorData['lastPaymentDate'] = $data['transactionDate'];
                $this->vendor->update($vendor_id, $vendorData); 
                break;
            case 'customer':
                $cust_id = $this->genmod->getTableCol('customers', 'id', 'customerName', $data['referenceNo']);
                $cust_balance = $this->genmod->getTableCol('customers', 'outstandingBalance', 'customerName', $transData[0]->referenceNo);
                $customerData['outstandingBalance'] = $cust_balance - $transData[0]->debitAmount;
                //$customerData['lastPayment'] = $data['creditAmount'];
                //$customerData['lastPaymentDate'] = $data['transactionDate'];
                $this->customer->update($cust_id, $customerData); 
                break;
            case 'account':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) - $transData[0]->debitAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo);
                $this->account->update($accId,$accountData);
                break;
            case 'payable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) + $transData[0]->debitAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo);
                $this->account->update($accId,$accountData);
                break;
            case 'receivable':
                //$this->AccountsTransaction->insert($accountTransaction);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->referenceNo ) - $transData[0]->debitAmount;
                //$accountData['lastUpdate'] = date('y-m-d');
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName', $transData[0]->referenceNo);
                $this->account->update($accId,$accountData);
                break;
            case 'factory':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  $transData[0]->type);
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $transData[0]->type ) + $transData[0]->debitAmount;
                $this->account->update($accId,$accountData);
                break;
            case 'pvcDoor':
                $accId = $this->genmod->getTableCol('accounts', 'id', 'accName',  'pvcDoor');
                $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'pvcDoor' ) + $transData[0]->debitAmount;
                $this->account->update($accId,$accountData);
                break;
        }
        

        
        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            $this->session->set_flashdata('success', 'Transaction not deleted Successfully');
            $this->session->set_flashdata('date1', $transData[0]->transactionDate);
            redirect('Cashbook/dailyCashBook');
        }
        else{
            $this->session->set_flashdata('success', 'Transaction deleted Successfully');
            $this->session->set_flashdata('date1', $transData[0]->transactionDate);
            redirect('Cashbook/dailyCashBook');
        }
        

    }


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
        $newCustomer = $this->input->post('newCustomer', TRUE);
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
            $returnedData = $this->insertTrToDb($arrOfItemsDetails, $_at, $cumAmount, $_cd,  $discount_amount, $remainingBalance, $previousBalance, $totalProfit, $discount_percentage, $invoiceTotal, $cust_name, $cust_phone, $cust_email, $cust_address, $cust_id, $newCustomer);
            
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
            
            $this->genmod->addevent("New Transaction", $returnedData['transRef'], $eventDesc, 'transactions1', $this->session->admin_id);

            
       }
        
        else{//return error msg
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
            //echo "here23";
        }
        
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
            $cust_id = $this->customer->insert($customerData);
        }else{
            $customerData['outstandingBalance'] = $remainingBalance;
            $this->customer->update($cust_id, $customerData);
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


            $transId = $this->transaction->add($itemName, $itemCode, $qtySold, $unitPrice, $costPrice, $totalPrice, $totalCostPrice, $cumAmount, $remainingBalance, $previousBalance, $totalProfit, $invoiceTotal, $_at, $_cd, $ref, $discount_amount, $cust_name, $cust_id);
            //$transId = 1;
            
            $allTransInfo[$transId] = ['itemName'=>$itemName, 'quantity'=>$qtySold, 'unitPrice'=>$unitPrice, 'totalPrice'=>$totalPrice];
            
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)
            $this->item->decrementItem($itemCode, $qtySold);
        }
        //$this->db->trans_complete();
        
        $incoming_cash = $_at - $_cd;
        //echo $incoming_cash;
        
        //$customerTransaction = [];
        $customerTransaction['customerId'] = $cust_id;
        $customerTransaction['debitAmount'] = $invoiceTotal;
        $customerTransaction['creditAmount'] = $incoming_cash;
        $customerTransaction['description'] = 'products purchased';
        $customerTransaction['transactionDate'] = date('y-m-d');
        $customerTransaction['refrenceNo'] = $ref;

        $this->CustomerTransaction->insert($customerTransaction);


        
        //$accountTransaction = [];
        $accountTransaction['accName'] = 'Cash in Hand';
        $accountTransaction['creditAmount'] = $incoming_cash;
        $accountTransaction['description'] = 'products sold';
        $accountTransaction['type'] = 'account';
        $accountTransaction['transactionDate'] = date('y-m-d');
        $accountTransaction['refrenceNo'] = $ref;

        //echo $accountTransaction['accName'];

        $this->AccountsTransaction->insert($accountTransaction);

        $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', $accountTransaction['accName'] ) + $incoming_cash;
        $accountData['lastUpdate'] = date('y-m-d');
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
            $dateInDb = $this->genmod->getTableCol('transactions', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genTransReceipt($allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
        }
        
        
    }

    public function vICr(){
        //$this->genlib->ajaxOnly();
        
        $ref = $this->input->post('ref');

        //$allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name
        
        $transInfo = $this->AccountsTransaction->getTransDataById($ref);
        
        //loop through the transInfo to get needed info
        
        if($transInfo){
            $json['status'] = 1;
            
            $data['creditAmount'] = $transInfo[0]->creditAmount;
            $data['debitAmount'] = $transInfo[0]->debitAmount;
            $data['description'] = $transInfo[0]->description;
            $data['transactionDate'] = $transInfo[0]->transactionDate;
            $data['referenceNo'] = $transInfo[0]->referenceNo;
            $data['type'] = $transInfo[0]->type;
            $data['transId'] = $ref;
            //$_cd = $transInfo[0]['changeDue'];
            //$discountAmount = $transInfo[0]['discount_amount'];
            //$cust_name = $transInfo[0]['cust_name'];
            
            //echo $cust_name;
            
            $json['transReceipt'] = $this->load->view('cashbook/incomingCashReceipt', $data, TRUE);
        
        //return $transReceipt;
        }
        
        else{
            $json['status'] = 0;
        }
        
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
        $this->genlib->ajaxOnly();
        
        $ref = $this->input->post('ref');
        
        $transInfo = $this->transaction->getTransInfo($ref);
        
        //loop through the transInfo to get needed info
        if($transInfo){
            $json['status'] = 1;
            
            $cumAmount = $transInfo[0]['totalMoneySpent'];
            $amountTendered = $transInfo[0]['amountTendered'];
            $changeDue = $transInfo[0]['changeDue'];
            $transDate = $transInfo[0]['transDate'];
            $modeOfPayment = $transInfo[0]['modeOfPayment'];
            $vatAmount = $transInfo[0]['vatAmount'];
            $vatPercentage = $transInfo[0]['vatPercentage'];
            $discountAmount = $transInfo[0]['discount_amount'];
            $discountPercentage = $transInfo[0]['discount_percentage'];
            $cust_name = $transInfo[0]['cust_name'];
            $cust_phone = $transInfo[0]['cust_phone'];
            $cust_email = $transInfo[0]['cust_email'];
            
            $json['transReceipt'] = $this->genTransReceipt($transInfo, $cumAmount, $amountTendered, $changeDue, $ref, 
                $transDate, $modeOfPayment, $vatAmount, $vatPercentage, $discountAmount, $discountPercentage, $cust_name,
                $cust_phone, $cust_email);
        }
        
        else{
            $json['status'] = 0;
        }
        
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
            $itemId = $this->genmod->gettablecol('items', 'id', 'code', $itemCode);
            $updated = $this->item->newStock($itemId,$itemQuantity);
            //if(!$updated){
              //  $json['status1'] = 100;
            //}

        }
        


        $this->db->trans_complete();

        $status = $this->db->trans_status();

        }
        if($status){
            $this->db->where('ref', $transRef)->delete('transactions');
            //$this->db->where('ref', $transRef)->delete('transactions');
            $eventDesc = "Transaction with ref no: ".$transRef."was deleted";
            
            $this->genmod->addevent("Delete Transaction", $transRef, $eventDesc, 'transactions', $this->session->admin_id);
            
            $json['status'] = 1;
            $json['itemCode'] = $itemCode;

        }
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
}
