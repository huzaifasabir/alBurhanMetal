<?php
defined('BASEPATH') OR exit('');


class Items extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->genlib->checkLogin();
        $this->load->library('session');
        
        $this->load->model(['item', 'vendor','transaction','AccountTransaction', 'AccountsTransaction','Account','products']);
    }

    public function editProductsPost() {
        $products_id = $this->input->post('products_id');
        $products = $this->products->getDataById($products_id);
        $data['name'] = $this->input->post('name');
        $data['subCategory'] = $this->input->post('subCategory');
        $data['description'] = $this->input->post('description');
        $data['thickness'] = $this->input->post('thickness');
        $data['quantity'] = $this->input->post('quantity');
        $data['location'] = $this->input->post('location');
        $data['costPrice'] = $this->input->post('costPrice');
        $data['sellingPrice'] = $this->input->post('sellingPrice');
        $data['vendorName'] = $this->input->post('vendorName');
        $data['hlink'] = $this->input->post('hlink');
        $edit = $this->products->update($products_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Products Updated');
            redirect('items/index1');
        }
    }

    public function export_csv(){ 
        /* file name */

        $filename = 'users_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       /* get data */
        $usersData = $this->item->getUserDetails();
        /* file creation */
        $file = fopen('php://output','w'); 
        $header = array("Username","Name","Role"); 
        fputcsv($file, $header);
        foreach ($usersData as $key=>$line){ 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
        //$transData['flag'] = 'all';
        //$transData['categories'] = $this->item->getAllCategories();
        //$data['pageContent'] = $this->load->view('items/allItems1', $transData, TRUE);
        //$data['pageTitle'] = "Items";
        //$data['flag'] = 'all';

        $this->load->view('main', '');
    }
    
    /**
     * 
     */
    public function index(){
        $transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $data['pageContent'] = $this->load->view('items/items', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function index1(){
        //$transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['flag'] = 'all';
        $transData['categories'] = $this->item->getAllCategories();
        $data['pageContent'] = $this->load->view('items/allItems1', $transData, TRUE);
        $data['pageTitle'] = "Items";
        $data['flag'] = 'all';

        $this->load->view('main', $data);
    }

    public function lasani(){
        //$transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['flag'] = 'lasani';
        $data['pageContent'] = $this->load->view('items/allItems', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function chipboard(){
        //$transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['flag'] = 'chipboard';
        $data['pageContent'] = $this->load->view('items/allItems', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function foamboard(){
        //$transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['flag'] = 'foamboard';
        $data['pageContent'] = $this->load->view('items/allItems', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }

    public function newProduct(){
        //$transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['categories'] = $this->item->getAllCategories();
        $transData['vendors'] = $this->vendor->getActiveVendors('companyName', 'ASC');//
        $data['pageContent'] = $this->load->view('items/newProduct', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);

    }
    public function purchaseOrder(){
        $transData['items'] = $this->item->getItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['vendors'] = $this->vendor->getActiveVendors('companyName', 'ASC');//
        
        $data['pageContent'] = $this->load->view('items/newPurchaseOrder', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function editPurchase($ref){
        $transData['transInfo']=$this->item->gettransinfo($ref);
        $transData['items'] = $this->item->getItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['vendors'] = $this->vendor->getActiveVendors('companyName', 'ASC');//
        
        $data['pageContent'] = $this->load->view('items/editPurchaseOrder', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function returnPurchaseOrder(){
        $transData['items'] = $this->item->getItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['vendors'] = $this->vendor->getActiveVendors('companyName', 'ASC');//
        $transData['receipts'] = $this->item->getAllReceipt();
        $data['pageContent'] = $this->load->view('items/returnPurchaseOrder', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function allPurchaseOrders(){
        //$transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['flag'] = 'all';
        $data['pageContent'] = $this->load->view('items/allPurchaseOrders', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function allReturnPurchase(){
        //$transData['items'] = $this->item->getActiveItems('name', 'ASC');//get items with at least one qty left, to be used when doing a new transaction
        $transData['flag'] = 'all';
        $data['pageContent'] = $this->load->view('items/allReturnPurchase', $transData, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }
    public function viewItem($itemCode) {
        //$data['itemCode'] = $itemCode;
        //$data['itemInfo'] = $this->item->getDataById($itemCode);

        //$customerName = $data['customers'][0]->customerName;
        $data1['sn'] = 1;
        $data1['itemSale'] = $this->transaction->getPurchaseItem($itemCode);
        $data1['itemReturns'] = $this->transaction->getReturnItem($itemCode);
        $data1['itemPurchase'] = $this->item->getPurchaseItem($itemCode);
        //$id$this->genmod->getTableCol('vendors', 'id', 'companyName', $companyName);
        $data['pageContent'] = $this->load->view('items/itemTransTable', $data1, TRUE);
        $data['pageTitle'] = "Items";

        $this->load->view('main', $data);
    }

    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    


    public function transactionInfo(){
        //$json['status'] = 0;
        
        $ref = $this->input->get('ref', TRUE);
        //echo $ref;
        //echo "string";
        //$ref = 0;
        $customerI = [];
        //$productArray = [];
        
        if($ref){
            $receipt_info = $this->item->receiptInfo($ref);
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
                $vendor = $receipt_info[0]->vendor;
                //$customer_info = $this->customerInfo($customerId);
                //echo $customerId;
                /*
                if($customer_info){
                    //echo $customer_info->customerName;
                    $vendor['name'] = $vendor;
                    $customerI['phone'] = $customer_info->phone;
                    $customerI['email'] = $customer_info->email;
                    $customerI['address'] = $customer_info->address;
                    $customerI['outstandingBalance'] = $customer_info->outstandingBalance;

                }*/
                foreach ($receipt_info as $row){
                    $productArray[$row->itemCode] = ['name' => ($this->genmod->gettablecol('products', 'description', 'code', $row->itemCode)), 'quantityPurchased' =>$row->quantity, 'unitPrice' => $row->costPrice];
                    //echo $row->itemName;
                }

                $json['vendor'] = $vendor;
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

    /**
     * "lilt" = "load Items List Table"
     */
    public function lilt(){
        $this->genlib->ajaxOnly();
        
        $this->load->helper('text');
        
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "name";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        $flag = $this->input->get('flag',TRUE);
        //$flag = 'all';
        //count the total number of items in db
        //$this->db->where('category', $flag);
        $totalItems = $this->item->countAll($flag);
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
	
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalItems, "items/lilt", $limit, ['onclick'=>'return lilt(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all items from db
        $data['allItems'] = $this->item->getAll($orderBy, $orderFormat, $start, $limit, $flag);
        $data['range'] = $totalItems > 0 ? "Showing " . ($start+1) . "-" . ($start + count($data['allItems'])) . " of " . $totalItems : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        $data['cum_total'] = $this->item->getItemsCumTotal($flag);
        $data['flag'] = $flag;
        
        $json['itemsListTable'] = $this->load->view('items/itemslisttable', $data, TRUE);//get view with populated items table
        //$json['flag'] = $flag;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function loadPurchase(){
        $this->genlib->ajaxOnly();
        
        $this->load->helper('text');
        
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "transDate";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //$flag = $this->input->get('flag',TRUE);
        //$flag = 'all';
        //count the total number of items in db
        //$this->db->where('category', $flag);
        $totalPurchase = $this->item->countAllPurchaseOrders();
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
    
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalPurchase, "items/loadPurchase", $limit, ['onclick'=>'return loadPurchase(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all items from db
        $data['allPurchase'] = $this->item->getAllPurchase($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalPurchase > 0 ? "Showing " . ($start+1) . "-" . ($start + count($data['allPurchase'])) . " of " . $totalPurchase : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        //$data['cum_total'] = $this->item->getItemsCumTotal();
        
        $json['purchaseListTable'] = $this->load->view('items/purchasetable', $data, TRUE);//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function loadPurchase1(){
        $this->genlib->ajaxOnly();
        
        $this->load->helper('text');
        
        //set the sort order
        $orderBy = $this->input->get('orderBy', TRUE) ? $this->input->get('orderBy', TRUE) : "transDate";
        $orderFormat = $this->input->get('orderFormat', TRUE) ? $this->input->get('orderFormat', TRUE) : "ASC";
        
        //$flag = $this->input->get('flag',TRUE);
        //$flag = 'all';
        //count the total number of items in db
        //$this->db->where('category', $flag);
        $totalPurchase = $this->item->countAllReturnPurchaseOrders();
        
        $this->load->library('pagination');
        
        $pageNumber = $this->uri->segment(3, 0);//set page number to zero if the page number is not set in the third segment of uri
    
        $limit = $this->input->get('limit', TRUE) ? $this->input->get('limit', TRUE) : 10;//show $limit per page
        $start = $pageNumber == 0 ? 0 : ($pageNumber - 1) * $limit;//start from 0 if pageNumber is 0, else start from the next iteration
        
        //call setPaginationConfig($totalRows, $urlToCall, $limit, $attributes) in genlib to configure pagination
        $config = $this->genlib->setPaginationConfig($totalPurchase, "items/loadPurchase1", $limit, ['onclick'=>'return loadPurchase1(this.href);']);
        
        $this->pagination->initialize($config);//initialize the library class
        
        //get all items from db
        $data['allPurchase'] = $this->item->getAllReturnPurchase($orderBy, $orderFormat, $start, $limit);
        $data['range'] = $totalPurchase > 0 ? "Showing " . ($start+1) . "-" . ($start + count($data['allPurchase'])) . " of " . $totalPurchase : "";
        $data['links'] = $this->pagination->create_links();//page links
        $data['sn'] = $start+1;
        //$data['cum_total'] = $this->item->getItemsCumTotal();
        
        $json['purchaseListTable'] = $this->load->view('items/returnPurchaseTable', $data, TRUE);//get view with populated items table

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    /*
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    ********************************************************************************************************************************
    */
    
    
    
    public function add(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('itemName', 'Item name', ['required', 'trim', 'max_length[80]', 'is_unique[products.name]'],
                ['required'=>"required"]);
        $this->form_validation->set_rules('category', 'Category', ['required', 'trim', 'max_length[80]'],
                ['required'=>"required"]);
        $this->form_validation->set_rules('thickness', 'Thickness', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('itemQuantity', 'Item quantity', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('costPrice', 'Cost Price', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('sellingPrice', 'Selling Price', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('vendor', 'Vendor', ['required', 'trim', 'max_length[80]'],
                ['required'=>"required"]);

        
        
        if($this->form_validation->run() !== FALSE){
            $this->db->trans_start();//start transaction
            
            ///**
             //* insert info into db
             //* function header: add($itemName, $itemQuantity, $itemPrice,$costPrice, //$itemDescription, $itemCode)
             
            
            $insertedId = $this->item->add(set_value('itemName'), set_value('category'), set_value('itemDescription'),set_value('thickness'), 
                    set_value('itemQuantity'), set_value('itemLocation'), set_value('costPrice'), set_value('sellingPrice'), set_value('vendor'), set_value('hlink'));
            //echo "hello";
            
            $itemName = set_value('itemName');
            $itemQty = set_value('itemQuantity');
            $sellingPrice = "".number_format(set_value('sellingPrice'), 2);
            $costPrice = "".number_format(set_value('costPrice'), 2);
            
            //insert into eventlog
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $desc = "Addition of {$itemQty} quantities of a new item '{$itemName}' with a unit price of {$sellingPrice} to stock";
            //$json['msg'] = "hello2";
            
            
            $insertedId ? $this->genmod->addevent("Creation of new item", $insertedId, $desc, "items", $this->session->admin_id) : "";
            
            $this->db->trans_complete();
            
            $json = $this->db->trans_status() !== FALSE ? 
                    ['status'=>1, 'msg'=>"Item successfully added"] 
                    : 
                    ['status'=>0, 'msg'=>"Oops! Unexpected server error! Please contact administrator for help. Sorry for the embarrassment"];
                    
                    //$json['msg'] = "One or more required fields are empty or not correctly filled hello01";
            //$json['status'] = 0;
        }
        
        else{
            //return all error messages
            //validation_errors();
            $json['error'] = $this->form_validation->error_array();//get an array of all errors
            
            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json['status'] = 0;
        }
                   
        //$json['msg'] = "One or more required fields are empty or not correctly filled hello";
          //  $json['status'] = 0;
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    
    


    public function nso_(){
        $this->genlib->ajaxOnly();
        
        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        //$cumAmount = $this->input->post('_ca', TRUE);//cumulative amount
        $temp1 = $this->input->post('_ca');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $cumAmount = $temp;
        $vendor = $this->input->post('vendor', TRUE);//vat percentage
        $transportCost = $this->input->post('transportCost', TRUE);//discount percentage
        $laborCost = $this->input->post('laborCost', TRUE);
        $vendorPayable = $this->input->post('vendorPayable', TRUE);
        $temp1 = $this->input->post('vendorPayable');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $vendorPayable = $temp;
        $date1 = $this->input->post('date1', TRUE);
    
        
        /*
         * Loop through the arrOfItemsDetails and ensure each item's details has not been manipulated
         * The unitPrice must match the item's unit price in db, the totPrice must match the unitPrice*qty
         * The cumAmount must also match the total of all totPrice in the arr in addition to the amount of 
         * VAT (based on the vat percentage) and minus the $discount_percentage (if available)
         */
        
        $allIsWell = True;//$this->validateItemsDet($arrOfItemsDetails, $cumAmount, $_at, $vatPercentage, $discount_percentage);
        
        if($allIsWell){//insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertTrToDb($arrOfItemsDetails, $cumAmount, $vendor, $transportCost, $laborCost, $vendorPayable, $date1);
            
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later "
                    . "or contact technical department for assistance";



            
            $json['transReceipt'] = $returnedData['transReceipt'];
            
            //list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            //$json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            //$json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($cumAmount, 2)
                    ." with reference number {$returnedData['transRef']} was purchased";
            
            $this->genmod->addevent("New Transaction", $returnedData['transRef'], $eventDesc, 'transactions', $this->session->admin_id);
            
            //$json['status'] = 0;
            //$json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks hello";
       }
        
        else{//return error msg
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    private function insertTrToDb($arrOfItemsDetails, $cumAmount, $vendor, $transportCost, $laborCost, $vendorPayable, $date1){
        $allTransInfo = [];//to hold info of all items' in transaction
        $date = $date1;
        
        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        $ref1 = $this->item->getMaxRef();
        $ref = $ref1[0]->ref1 + 1;
        
        //loop through the items' details and insert them one by one
        //start transaction
        $this->db->trans_start();

        foreach($arrOfItemsDetails as $get){
            $itemCode = $get->_iC;
            $itemName = $this->genmod->getTableCol('products', 'name', 'code', $itemCode);
            //$itemUrduName = $this->genmod->getTableCol('items', 'urduName', 'code', $itemCode);
            //$itemDescription = $this->genmod->gettcumAmountablecol('items', 'description', 'code', $itemCode);
            $qty = $get->qty;//qty selected for item in loop
            $unitFixedPrice = $get->unitFixedPrice;//unit price of item in loop
            $costPrice = $get->costPrice;//total cost price
            $sellingPrice = $get->sellingPrice;//total cost price
            //$totalCostPrice = $get->totalCostPrice;//total price for item in loop
            $temp1 = $get->totalCostPrice;
            $temp = explode(',',$temp1);
            $temp = implode('',$temp);
            $totalCostPrice = $temp;

            /*
             * add transaction to db
             * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, $_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             */
            //cal average cost price
            $itemOldQuantity = $this->genmod->getTableCol('products', 'quantity', 'code', $itemCode);
            $itemOldCostPrice = $this->genmod->getTableCol('products', 'costPrice', 'code', $itemCode);

            $transId = $this->item->addPurchaseOrder($itemName, $itemCode, $qty, $unitFixedPrice, $costPrice, $sellingPrice, $totalCostPrice, $cumAmount, $vendor, $transportCost, 
                    $laborCost, $vendorPayable, $ref, $date1, $itemOldCostPrice, $itemOldQuantity);
            
            $allTransInfo[$transId] = ['itemCode'=>$itemCode, 'itemName'=>$itemName,  'quantity'=>$qty, 'fixedCostPrice'=>$unitFixedPrice, 'costPrice'=>$costPrice, 'totalCostPrice'=>$totalCostPrice];

            


            $averageCost = ((($itemOldQuantity * $itemOldCostPrice)+($qty * $costPrice ))/($itemOldQuantity + $qty));

            $totalQty = $itemOldQuantity + $qty;
            $totalValue = $totalQty * $averageCost;
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)

            $this->item->updateInfo($itemCode, $qty, $averageCost, $sellingPrice, $date, $totalValue );
        }

        $this->vendor->updateBalance($vendor, $vendorPayable );
        //$dataAccountTransaction = ['accName'=>$vendor,  'creditAmount'=>$vendorPayable, 'type'=>'vendor', 'description'=>'vendor payable', 'installmentDate'=>$date];
        //$this->AccountTransaction->addTransaction($dataAccountTransaction );

        if( $laborCost != 0){
            $accountTransaction['accName'] = 'Cash in Hand';
            $accountTransaction['debitAmount'] = $laborCost;
            $accountTransaction['description'] = 'products purchased';
            $accountTransaction['type'] = 'labor';
            $accountTransaction['transactionDate'] = $date1;
            $accountTransaction['referenceNo'] = $ref;

            //echo $accountTransaction['accName'];

            $this->AccountsTransaction->insert($accountTransaction);
            $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) - $laborCost;
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData);
            //$dataExpenseLabor = ['description'=> 'labor',  'amount'=>$laborCost, 'expenseDate'=>$date, 'type'=>'shop'];
            //$this->AccountTransaction->addExpense($dataExpenseLabor );
        }
        if( $transportCost != 0){
            $accountTransaction['accName'] = 'Cash in Hand';
            $accountTransaction['debitAmount'] = $transportCost;
            $accountTransaction['description'] = 'products purchased';
            $accountTransaction['type'] = 'transport';
            $accountTransaction['transactionDate'] = $date1;
            $accountTransaction['referenceNo'] = $ref;

            //echo $accountTransaction['accName'];

            $this->AccountsTransaction->insert($accountTransaction);
            $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) - $transportCost;
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData);

           // $dataExpenseTransport = ['description'=> 'transport',  'amount'=>$transportCost, 'expenseDate'=>$date, 'type'=>'shop'];
            //$this->AccountTransaction->addExpense($dataExpenseTransport );

        }



        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            return false;
        }
        
        else{
            
            $dataToReturn = [];
            
            //get transaction date in db, to be used on the receipt. It is necessary since date and time must matc
            $dateInDb = $this->genmod->getTableCol('purchaseTransaction', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genTransReceipt($allTransInfo, $cumAmount, $dateInDb, $vendor, $transportCost, 
                    $laborCost, $vendorPayable, $ref);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
            
            //return True;
        }
    }

public function editPurchaseOrder(){
        $this->genlib->ajaxOnly();
        $transRef = $this->input->post('transRef', TRUE);
        if($transRef){
        $transInfo = $this->item->getTransInfo($transRef);
        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        //$cumAmount = $this->input->post('_ca', TRUE);//cumulative amount
        $temp1 = $this->input->post('_ca');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $cumAmount = $temp;
        $vendor = $this->input->post('vendor', TRUE);//vat percentage
        $transportCost = $this->input->post('transportCost', TRUE);//discount percentage
        $laborCost = $this->input->post('laborCost', TRUE);
        $vendorPayable = $this->input->post('vendorPayable', TRUE);
        $temp1 = $this->input->post('vendorPayable');
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $vendorPayable = $temp;
        $date1 = $this->input->post('date1', TRUE);
    
        
        /*
         * Loop through the arrOfItemsDetails and ensure each item's details has not been manipulated
         * The unitPrice must match the item's unit price in db, the totPrice must match the unitPrice*qty
         * The cumAmount must also match the total of all totPrice in the arr in addition to the amount of 
         * VAT (based on the vat percentage) and minus the $discount_percentage (if available)
         */
        
        $allIsWell = True;//$this->validateItemsDet($arrOfItemsDetails, $cumAmount, $_at, $vatPercentage, $discount_percentage);
        
        if($allIsWell){//insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertEditRow($transRef, $transInfo,$arrOfItemsDetails, $cumAmount, $vendor, $transportCost, $laborCost, $vendorPayable, $date1);
            
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later "
                    . "or contact technical department for assistance";



            
            $json['transReceipt'] = $returnedData['transReceipt'];
            
            //list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            //$json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            //$json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            $eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($cumAmount, 2)
                    ." with reference number {$returnedData['transRef']} was purchased";
            
            $this->genmod->addevent("New Transaction", $returnedData['transRef'], $eventDesc, 'transactions', $this->session->admin_id);
            
            //$json['status'] = 0;
            //$json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks hello";
       }
        
        else{//return error msg
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
        }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }


    private function insertEditRow($transRef, $transInfo,$arrOfItemsDetails, $cumAmount, $vendor, $transportCost, $laborCost, $vendorPayable, $date1){
        $allTransInfo = [];//to hold info of all items' in transaction
        $date = $date1;
        
        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        //$ref1 = $this->item->getMaxRef();
        //$ref = $ref1[0]->ref1 + 1;
        $ref = $transRef;
        
        //loop through the items' details and insert them one by one
        //start transaction
        $this->db->trans_start();
        $this->db->where('ref', $transRef)->delete('purchaseTransaction');

        foreach($transInfo as $get){
            //echo "here";
            $itemCode = $get['itemCode'];
            $quantity = $get['quantity'];

            $this->item->decrementItem($itemCode, $quantity);
            //$previousAmountTendered = $get->amountTendered;
            //$previousChangeDue = $get->changeDue;
            //$ref = $get->ref;
        }
        
        foreach($arrOfItemsDetails as $get){
            $itemCode = $get->_iC;
            $itemName = $this->genmod->getTableCol('products', 'name', 'code', $itemCode);
            $qty = $get->qty;//qty selected for item in loop
            $unitFixedPrice = $get->unitFixedPrice;//unit price of item in loop
            $costPrice = $get->costPrice;//total cost price
            $sellingPrice = $get->sellingPrice;//total cost price
            //$itemUrduName = $this->genmod->getTableCol('items', 'urduName', 'code', $itemCode);
            $flag = 0;
            $avgPrice = 0;
            $avgQuantity = 0;
            foreach($transInfo as $get1){
                $itemCodeTemp = $get1['itemCode'];
                //$quantityTemp = $get['quantity'];
                if($itemCode === $itemCodeTemp){
                  $flag = 1;
                  $previousTempQ = $get1['previousQuantity'];
                  $previouslTempP = $get1['previousCostPrice'];  
                  $avgPrice = (($previousTempQ * $previouslTempP) + ($qty * $costPrice))/($previousTempQ + $qty);
                  $avgQuantity = $previousTempQ + $qty;
                }
            }
            //$transDate1 = $get->
            if ($flag) {
                $itemPurchaseTrans = $this->item->getItemPurchaseInfo($itemCode, $date1);
            
            
            //$itemOldQuantityTemp = $this->genmod->getTableCol('purchaseTransaction', 'quantity', 'code', $itemCode);
                if($itemPurchaseTrans){
                foreach($itemPurchaseTrans as $get2){
                    $transactionId = $get2['transId'];
                    $this->item->updatePrevious($avgPrice, $avgQuantity, $transactionId);
                    $tempQ = $get2['quantity'];
                    $tempP = $get2['costPrice'];
                    $avgPrice = (($tempQ * $tempP) + ($avgQuantity * $avgPrice))/($tempQ + $avgQuantity);
                    $avgQuantity = $tempQ + $avgQuantity;
                    


                }
            }
            }else{
                $previousTempQ = $this->genmod->getTableCol('products', 'quantity', 'code', $itemCode);//$get1['previousQuantity'];
                $previouslTempP = $this->genmod->getTableCol('products', 'costPrice', 'code', $itemCode);//$get1['previousCostPrice'];
                $avgPrice = ((($previousTempQ * $previouslTempP)+($qty * $costPrice ))/($previousTempQ + $qty));
            }
            
            //$itemDescription = $this->genmod->gettcumAmountablecol('items', 'description', 'code', $itemCode);
            
            //$totalCostPrice = $get->totalCostPrice;//total price for item in loop
            $temp1 = $get->totalCostPrice;
            $temp = explode(',',$temp1);
            $temp = implode('',$temp);
            $totalCostPrice = $temp;

            /*
             * add transaction to db
             * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, $_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             */
            $transId = $this->item->addPurchaseOrder($itemName, $itemCode, $qty, $unitFixedPrice, $costPrice, $sellingPrice, $totalCostPrice, $cumAmount, $vendor, $transportCost, 
                    $laborCost, $vendorPayable, $ref, $date1, $previouslTempP, $previousTempQ );
            
            $allTransInfo[$transId] = ['itemCode'=>$itemCode, 'itemName'=>$itemName,  'quantity'=>$qty, 'fixedCostPrice'=>$unitFixedPrice, 'costPrice'=>$costPrice, 'totalCostPrice'=>$totalCostPrice];

            //cal average cost price
            $itemOldQuantity = $this->genmod->getTableCol('products', 'quantity', 'code', $itemCode);
            $itemOldCostPrice = $this->genmod->getTableCol('products', 'costPrice', 'code', $itemCode);

            $difference = $itemOldQuantity + $qty;

            if($difference <= 0){
                $avgPrice = 0;
            }
            else{
                    
            }
            

            $totalQty = $itemOldQuantity + $qty;
            $totalValue = $totalQty * $avgPrice;
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)

            $this->item->updateInfo($itemCode, $qty, $avgPrice, $sellingPrice, $date, $totalValue );
        }
        $this->vendor->updateBalanceDecrement($transInfo[0]['vendor'], $transInfo[0]['vendorPayable'] );

        $this->vendor->updateBalance($vendor, $vendorPayable );
        //$dataAccountTransaction = ['accName'=>$vendor,  'creditAmount'=>$vendorPayable, 'type'=>'vendor', 'description'=>'vendor payable', 'installmentDate'=>$date];
        //$this->AccountTransaction->addTransaction($dataAccountTransaction );

        if($transInfo[0]['labor'] != 0){
            $this->AccountsTransaction->deleteTransaction1($ref, 'labor');
            $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) + $transInfo[0]['labor'];
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData);
        }
        if($transInfo[0]['transport'] != 0){
            $this->AccountsTransaction->deleteTransaction1($ref, 'transport');
            $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) + $transInfo[0]['transport'];
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData);
        }
        
        if( $laborCost != 0){
            
            $accountTransaction['accName'] = 'Cash in Hand';
            $accountTransaction['debitAmount'] = $laborCost;
            $accountTransaction['description'] = 'products purchased';
            $accountTransaction['type'] = 'labor';
            $accountTransaction['transactionDate'] = $date1;
            $accountTransaction['referenceNo'] = $ref;

            //echo $accountTransaction['accName'];

            $this->AccountsTransaction->insert($accountTransaction);
            $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) - $laborCost;
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData);
            //$dataExpenseLabor = ['description'=> 'labor',  'amount'=>$laborCost, 'expenseDate'=>$date, 'type'=>'shop'];
            //$this->AccountTransaction->addExpense($dataExpenseLabor );

        }
        if( $transportCost != 0){
            $accountTransaction['accName'] = 'Cash in Hand';
            $accountTransaction['debitAmount'] = $transportCost;
            $accountTransaction['description'] = 'products purchased';
            $accountTransaction['type'] = 'transport';
            $accountTransaction['transactionDate'] = $date1;
            $accountTransaction['referenceNo'] = $ref;

            //echo $accountTransaction['accName'];

            $this->AccountsTransaction->insert($accountTransaction);
            $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) - $transportCost;
            //$accountData['lastUpdate'] = date('y-m-d');
            $this->Account->update(5,$accountData);

           // $dataExpenseTransport = ['description'=> 'transport',  'amount'=>$transportCost, 'expenseDate'=>$date, 'type'=>'shop'];
            //$this->AccountTransaction->addExpense($dataExpenseTransport );

        }



        $this->db->trans_complete();//end transaction

        //ensure there was no error
        //works in production since db_debug would have been turned off
        if($this->db->trans_status() === FALSE){
            return false;
        }
        
        else{
            
            $dataToReturn = [];
            
            //get transaction date in db, to be used on the receipt. It is necessary since date and time must matc
            $dateInDb = $this->genmod->getTableCol('purchaseTransaction', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genTransReceipt($allTransInfo, $cumAmount, $dateInDb, $vendor, $transportCost, 
                    $laborCost, $vendorPayable, $ref);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
            
            //return True;
        }

    }

    private function genTransReceipt($allTransInfo, $cumAmount, $dateInDb, $vendor, $transportCost, 
                    $laborCost, $vendorPayable, $ref){
        $data['allTransInfo'] = $allTransInfo;
        $data['cumAmount'] = $cumAmount;
        $data['vendor'] = $vendor;
        $data['vendorPayable'] = $vendorPayable;
        $data['ref'] = $ref;
        $data['transDate'] = $dateInDb;
        $data['transportCost'] = $transportCost;
        $data['laborCost'] = $laborCost;
        
        
        //generate and return receipt
        $transReceipt = $this->load->view('items/purchaseOrderReceipt', $data, TRUE);
        
        return $transReceipt;
    }

    public function returnOrder(){

        $arrOfItemsDetails = json_decode($this->input->post('_aoi', TRUE));
        
        $vendor = $this->input->post('vendor', TRUE);//cumulative amount
        $temp1 = $this->input->post('vendorPayable', TRUE);
        $temp = explode(',',$temp1);
        $temp = implode('',$temp);
        $totalAmount = $temp;
        //$totalAmount = $this->input->post('vendorPayable', TRUE);
        
        $receiptNo = $this->input->post('receiptNo', TRUE);
        //$remainingBalance = $this->input->post('remainingBalance', TRUE);
        //$previousBalance = $this->input->post('previousBalance', TRUE);//discount percentage
        //$profitReduction = $this->input->post('profitReduction', TRUE);
        //$amountPayable = $this->input->post('amountPayable', TRUE);
        //$invoiceTotal = $this->input->post('invoiceTotal', TRUE);

        $date1 = $this->input->post('date1', TRUE);
        
       
        $allIsWell = TRUE;
        //echo $allIsWell;
        //echo "string";

        if($allIsWell){
            //echo "\nhere";
            //insert each sales order into db, generate receipt and return info to client
            //$json['msg'] = "hello";
            //will insert info into db and return transaction's receipt
            $returnedData = $this->insertReturnRow($arrOfItemsDetails,$receiptNo,$vendor, $totalAmount, $date1);
            
            //$returnedData = TRUE;
            $json['status'] = $returnedData ? 1 : 0;
            $json['msg'] = $returnedData ? "Transaction successfully processed" : 
                    "Unable to process your request at this time. Pls try again later ";
            $json['transReceipt'] = $returnedData['transReceipt'];
            //echo $returnedData['transReceipt'];
            //list($profit,$total_earned_today) = $this->transaction->totalEarnedToday();
        
            //$json['totalEarnedToday'] = $total_earned_today ? number_format($total_earned_today, 2) : "0.00";
            //$json['profit'] = $profit ? number_format($profit, 2) : "0.00";

            
            //add into eventlog
            //function header: addevent($event, $eventRowIdOrRef, $eventDesc, $eventTable, $staffId) in 'genmod'
            //$eventDesc = count($arrOfItemsDetails). " items totalling Rs ". number_format($invoiceTotal, 2)
            //        ." with reference number {$returnedData['transRef']} was returned";
            
            //$this->genmod->addevent("Return Transaction", $returnedData['transRef'], $eventDesc, 'returnTransactions', $this->session->admin_id);

            
       }
        
        else{//return error msg
            $json['status'] = 0;
            $json['msg'] = "Transaction could not be processed. Please ensure there are no errors. Thanks";
            //echo "here23";
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    

    private function insertReturnRow($arrOfItemsDetails,$receiptNo,$vendor, $totalAmount, $date1){
        $allTransInfo = [];//to hold info of all items' in transaction
        
        //generate random string to use as transaction ref
        //keep regeneration the ref if generated ref exist in db
        $ref1 = $this->item->getMaxReturnRef();
        $ref = $ref1[0]->ref1 + 1;
        //$ref = 1;
        //loop through the items' details and insert them one by one
        //start transaction
        $this->db->trans_start();

        $vendorBalance = $this->genmod->getTableCol('vendors', 'outstandingBalance', 'companyName', $vendor);
        $vendorId = $this->genmod->getTableCol('vendors', 'id', 'companyName', $vendor);
        $vendorBalance = $vendorBalance - $totalAmount;
        $vendorData['outstandingBalance'] = $vendorBalance;
        $this->vendor->update($vendorId, $vendorData);


        
        foreach($arrOfItemsDetails as $get){
            $itemCode = $get->_iC;
            //$itemCode = $this->genmod->getTableCol('products', 'code', 'name', $itemName);
            //$itemUrduName = $this->genmod->getTableCol('items', 'urduName', 'code', $itemCode);
            //$itemDescription = $this->genmod->gettablecol('items', 'description', 'code', $itemCode);
            $qtySold = $get->qty;//qty selected for item in loop
            $unitPrice = $get->unitPrice;//unit price of item in loop
            //$costPrice = $get->costUnitPrice;//unit price of item in loop
            //$totalCostPrice = $get->totalCostPrice;//total cost price
            $totalPrice = $get->totalPrice;//total price for item in loop
            //$totalProfitItem = $get->totalProfitItem;

            
            // * add transaction to db
            // * function header: add($_iN, $_iC, $desc, $q, $_up, $_tp, $_tas, $_at, $_cd, $_mop, //$_tt, $ref, $_va, $_vp, $da, $dp, $cn, $cp, $ce)
             
            //$urduName = 'na';


            $transId = $this->item->addReturn($itemCode, $qtySold, $unitPrice, $totalPrice, $vendor, $totalAmount, $ref, $receiptNo, $date1);
            //$transId = 1;
            
            $allTransInfo[$transId] = ['itemCode'=>$itemCode, 'quantity'=>$qtySold, 'unitPrice'=>$unitPrice, 'totalPrice'=>$totalPrice];
            
            //update item quantity in db by removing the quantity bought
            //function header: decrementItem($itemId, $numberToRemove)
            $this->item->decrementItem($itemCode, $qtySold);
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
            $dateInDb = $this->genmod->getTableCol('returnPurchase', 'transDate', 'transId', $transId);
            
            //generate receipt to return
            $dataToReturn['transReceipt'] = $this->genReturnReceipt($allTransInfo, $vendor, $totalAmount, $ref, $receiptNo, $dateInDb);
            $dataToReturn['transRef'] = $ref;
            
            return $dataToReturn;
            
        }
        
        
    }

    private function genReturnReceipt($allTransInfo, $vendor, $totalAmount, $ref, $receiptNo, $dateInDb){
        $data['allTransInfo'] = $allTransInfo;
        $data['vendor'] = $vendor;
        $data['totalAmount'] = $totalAmount;
        //$data['amountPayable'] = $amountPayable;
        //$data['changeDue'] = $_cd;
        $data['ref'] = $ref;
        $data['transDate'] = $dateInDb;
        //$data['previousBalance'] = $previousBalance;
        //$data['remainingBalance'] = $remainingBalance;
        
        //$data['discountAmount'] = $discount_amount;
        
        //$data['cust_name'] = $cust_name;
        
        //generate and return receipt
        $transReceipt = $this->load->view('items/returnPurchaseReceipt', $data, TRUE);
        
        return $transReceipt;
    }


    public function vtrP(){
        //$this->genlib->ajaxOnly();
        
        $ref = $this->input->post('ref');

        //$allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name
        
        $transInfo = $this->item->gettransinfo($ref);
        //$transInfo = 0;
        //loop through the transInfo to get needed info
        
        if($transInfo){
            $json['status'] = 1;
            
            //$invoiceTotal = $transInfo[0]['cumulativeTotal'];
            $cumAmount = $transInfo[0]['cumulativeTotal'];
            $vendorPayable = $transInfo[0]['vendorPayable'];
            $dateInDb = $transInfo[0]['transDate'];
            $laborCost = $transInfo[0]['labor'];
            $transportCost = $transInfo[0]['transport'];
            $vendor = $transInfo[0]['vendor'];
            //$discountAmount = $transInfo[0]['discount_amount'];
            //$cust_name = $transInfo[0]['cust_name'];
            
            //echo $cust_name;
            $json['transReceipt'] = $this->genTransReceipt($transInfo, $cumAmount, $dateInDb, $vendor, $transportCost, 
                    $laborCost, $vendorPayable, $ref);
        }        
        else{
            $json['status'] = 0;
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
        
    }

    public function vtrPR(){
        //$this->genlib->ajaxOnly();
        
        $ref = $this->input->post('ref');

        //$allTransInfo, $invoiceTotal,$cumAmount, $previousBalance, $remainingBalance, $_at, $_cd, $ref, $dateInDb, $discount_amount, $cust_name
        
        $transInfo = $this->item->getreturntransinfo($ref);
        //$transInfo = 0;
        //loop through the transInfo to get needed info
        
        if($transInfo){
            $json['status'] = 1;
            
            //$invoiceTotal = $transInfo[0]['cumulativeTotal'];
            $totalAmount = $transInfo[0]['totalAmount'];
            //$vendorPayable = $transInfo[0]['vendorPayable'];
            $dateInDb = $transInfo[0]['transDate'];
            //$laborCost = $transInfo[0]['labor'];
            //$transportCost = $transInfo[0]['transport'];
            $vendor = $transInfo[0]['vendor'];
            //$discountAmount = $transInfo[0]['discount_amount'];
            //$cust_name = $transInfo[0]['cust_name'];
            $receiptNo = 1;
            
            //echo $cust_name;
            $json['transReceipt'] = $this->genReturnReceipt($transInfo, $vendor, $totalAmount, $ref, $receiptNo, $dateInDb);
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
     * Primarily used to check whether an item already has a particular random code being generated for a new item
     * @param type $selColName
     * @param type $whereColName
     * @param type $colValue
     */
    public function gettablecol($selColName, $whereColName, $colValue){
        $a = $this->genmod->gettablecol('items', $selColName, $whereColName, $colValue);
        
        $json['status'] = $a ? 1 : 0;
        $json['colVal'] = $a;
        
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
     */
    public function gcoandqty(){
        $json['status'] = 0;
        
        $itemCode = $this->input->get('_iC', TRUE);
        
        if($itemCode){
            $item_info = $this->item->getItemInfo(['code'=>$itemCode], ['quantity', 'thickness', 'name']);

            if($item_info){
                $json['info'] = $item_info;
                $json['availQty'] = (int)$item_info->quantity;
                //$json['unitPrice'] = $item_info->unitPrice;
                $json['name'] = $item_info->name;
                $json['thickness'] = $item_info->thickness;
                $json['status'] = 1;
            }
        }
        
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    public function itemInfo(){
        $json['status'] = 0;
        
        $itemCode = $this->input->get('_iC', TRUE);
        
        if($itemCode){
            $item_info = $this->item->getItemInfo(['code'=>$itemCode], ['quantity', 'name', 'costPrice','sellingPrice','thickness']);

            if($item_info){
                $json['info'] = $item_info;
                $json['availQty'] = (int)$item_info->quantity;
                $json['costPrice'] = $item_info->costPrice;
                $json['sellingPrice'] = $item_info->sellingPrice;
                $json['name'] = $item_info->name;
                $json['thickness'] = $item_info->thickness;

                $json['status'] = 1;
            }
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
    
    
    public function updatestock(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('_iId', 'Item ID', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('_upType', 'Update type', ['required', 'trim', 'in_list[newStock,deficit]'], ['required'=>"required"]);
        $this->form_validation->set_rules('qty', 'Quantity', ['required', 'trim', 'numeric'], ['required'=>"required"]);
        $this->form_validation->set_rules('desc', 'Update Description', ['required', 'trim'], ['required'=>"required"]);
        
        if($this->form_validation->run() !== FALSE){
            //update stock based on the update type
            $updateType = set_value('_upType');
            $itemId = set_value('_iId');
            $qty = set_value('qty');
            $desc = set_value('desc');
            
            $this->db->trans_start();
            
            $updated = $updateType === "deficit" 
                    ? 
                $this->item->deficit($itemId, $qty, $desc) 
                    : 
                $this->item->newstock($itemId, $qty, $desc);
            
            //add event to log if successful
            $stockUpdateType = $updateType === "deficit" ? "Deficit" : "New Stock";
            
            $event = "Stock Update ($stockUpdateType)";
            
            $action = $updateType === "deficit" ? "removed from" : "added to";//action that happened
            $itemName = $this->genmod->gettablecol('items', 'name', 'id', $itemId);
            $eventDesc = "{$qty} quantities of {$itemName} was {$action} stock
                Reason: {$desc}";

            $itemCode = $this->genmod->gettablecol('items', 'code', 'id', $itemId);
            
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $updated ? $this->genmod->addevent($event, $itemCode, $eventDesc, "items", $this->session->admin_id,$itemName) : "";
            
            $this->db->trans_complete();//end transaction
            
            $json['status'] = $this->db->trans_status() !== FALSE ? 1 : 0;
            $json['msg'] = $updated ? "Stock successfully updated" : "Unable to update stock at this time. Please try again later";
        }
        
        else{
            $json['status'] = 0;
            $json['msg'] = "One or more required fields are empty or not correctly filled";
            $json = $this->form_validation->error_array();
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
   
    public function edit(){
        $this->genlib->ajaxOnly();
        
        $this->load->library('form_validation');

        $this->form_validation->set_error_delimiters('', '');
        
        $this->form_validation->set_rules('_iId', 'Item ID', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('itemName', 'Item Name', ['required', 'trim', 
            'callback_crosscheckName['.$this->input->post('_iId', TRUE).']'], ['required'=>'required']);
        $this->form_validation->set_rules('itemCode', 'Item Code', ['required', 'trim', 
            'callback_crosscheckCode['.$this->input->post('_iId', TRUE).']'], ['required'=>'required']);
        $this->form_validation->set_rules('itemPrice', 'Item Unit Price', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('costPrice', 'Item Cost Price', ['required', 'trim', 'numeric']);
        $this->form_validation->set_rules('itemDesc', 'Item Description', ['trim']);
        
        if($this->form_validation->run() !== FALSE){
            $itemId = set_value('_iId');
            $itemDesc = set_value('itemDesc');
            $itemPrice = set_value('itemPrice');
            $costPrice = set_value('costPrice');
            $itemName = set_value('itemName');
            $itemCode = $this->input->post('itemCode', TRUE);
            $itemUrduName = $this->input->post('itemUrduName', TRUE);
            $itemLocation = $this->input->post('itemLocation', TRUE);
            
            //update item in db
            $updated = $this->item->edit($itemId, $itemName, $itemDesc, $itemPrice, $costPrice, $itemUrduName, $itemLocation);
            
            $json['status'] = $updated ? 1 : 0;
            
            //add event to log
            //function header: addevent($event, $eventRowId, $eventDesc, $eventTable, $staffId)
            $desc = "Details of item with code '$itemCode' was updated";
            
            $this->genmod->addevent("Item Update", $itemCode, $desc, 'items', $this->session->admin_id, $itemName);
        }
        
        else{
            $json['status'] = 0;
            $json = $this->form_validation->error_array();
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
    
    public function crosscheckName($itemName, $itemId){
        //check db to ensure name was previously used for the item we are updating
        $itemWithName = $this->genmod->getTableCol('items', 'id', 'name', $itemName);
        
        //if item name does not exist or it exist but it's the name of current item
        if(!$itemWithName || ($itemWithName == $itemId)){
            return TRUE;
        }
        
        else{//if it exist
            $this->form_validation->set_message('crosscheckName', 'There is an item with this name');
                
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
     * @param type $item_code
     * @param type $item_id
     * @return boolean
     */
    public function crosscheckCode($item_code, $item_id){
        //check db to ensure item code was previously used for the item we are updating
        $item_with_code = $this->genmod->getTableCol('items', 'id', 'code', $item_code);
        
        //if item code does not exist or it exist but it's the code of current item
        if(!$item_with_code || ($item_with_code == $item_id)){
            return TRUE;
        }
        
        else{//if it exist
            $this->form_validation->set_message('crosscheckCode', 'There is an item with this code');
                
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
    
    
    public function delete(){
        $this->genlib->ajaxOnly();
        
        $json['status'] = 0;
        $item_id = $this->input->post('i', TRUE);
        
        if($item_id){
            
            
            $json['status'] = 1;
            $itemName = $this->genmod->gettablecol('products', 'name', 'code', $item_id);
            

            $itemCode = $item_id;
            $this->db->where('code', $item_id)->delete('products');
           
            $desc = "item deleted with code '$itemCode'";

            
            $this->genmod->addevent("Item Deleted", $itemCode, $desc, 'items', $this->session->admin_id, $itemName);
        }

        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function deletePurchase(){
        $this->genlib->ajaxOnly();
        
        $json['status'] = 0;
        $transRef = $this->input->post('transRef', TRUE);
        if($transRef){
        $transInfo = $this->item->gettransinfo($transRef);

        $this->db->trans_start();


        foreach($transInfo as $get){

            $itemCode = $get['itemCode'];
            $itemQuantity = $get['quantity'];
            $itemCostPrice = $get['costPrice'];

            $itemOldQuantity = $this->genmod->getTableCol('products', 'quantity', 'code', $itemCode);
            $itemOldCostPrice = $this->genmod->getTableCol('products', 'costPrice', 'code', $itemCode);

            $difference = $itemOldQuantity - $itemQuantity;

            if($difference <= 0 ){
               $averageCost = 0; 
            }else{
              $averageCost = round((($itemOldQuantity * $itemOldCostPrice)-($itemQuantity * $itemCostPrice ))/($difference));  
            }
            
            $data['costPrice'] = $averageCost;

            $this->item->update($itemCode,$data);

            $updated = $this->item->decrementItem($itemCode,$itemQuantity);

            //if(!$updated){
              //  $json['status1'] = 100;
            //}

        }
        $vendorPayable = $transInfo[0]['vendorPayable'];
        $vendor = $transInfo[0]['vendor'];
        $transportCost = $transInfo[0]['transport'];
        $laborCost = $transInfo[0]['labor'];

        $accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) + $transportCost + $laborCost;
            //$accountData['lastUpdate'] = date('y-m-d');
        $this->Account->update(5,$accountData);

        $this->vendor->updateBalanceDecrement($vendor, $vendorPayable );

        if($transportCost != 0){
        $transid1 = $this->AccountsTransaction->getTransactionId($transRef, 'transport');

        if($transid1){
            $transid1 = $transid1[0]->transId;
        $this->db->where('transId', $transid1)->delete('accountTransactions');
        }

    }
    if($laborCost != 0){
        $transid1 = $this->AccountsTransaction->getTransactionId($transRef, 'labor');
        if($transid1){
            $transid1 = $transid1[0]->transId;
        $this->db->where('transId', $transid1)->delete('accountTransactions');
    }
        
    }
        //$this->db->where('referenceNo', $transRef)->delete('accountTransactions');
        $this->db->where('ref', $transRef)->delete('purchaseTransaction');



        
            //$this->db->where('ref', $transRef)->delete('transactions');
        $eventDesc = "Transaction with ref no: ".$transRef."was deleted";
            
        $this->genmod->addevent("Delete Transaction", $transRef, $eventDesc, 'purchaseTransaction', $this->session->admin_id);
            
        $json['status'] = 1;
        $json['itemCode'] = $itemCode;

        $this->db->trans_complete();

        
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    }
        public function deleteReturnPurchase(){
        $this->genlib->ajaxOnly();
        
        $json['status'] = 0;
        $transRef = $this->input->post('transRef', TRUE);
        if($transRef){
        $transInfo = $this->item->getreturntransinfo($transRef);

        $this->db->trans_start();


        foreach($transInfo as $get){

            $itemCode = $get['itemCode'];
            $itemQuantity = $get['quantity'];
            //$itemCostPrice = $get['unitPrice'];

            //$itemOldQuantity = $this->genmod->getTableCol('products', 'quantity', 'code', $itemCode);
            //$itemOldCostPrice = $this->genmod->getTableCol('products', 'costPrice', 'code', $itemCode);

            //$difference = $itemOldQuantity - $itemQuantity;


            //$averageCost = round((($itemOldQuantity * $itemOldCostPrice)-($itemQuantity * $itemCostPrice ))/($difference));
            //$data['costPrice'] = $averageCost;

            //$this->item->update($itemCode,$data);

            $updated = $this->item->incrementItem($itemCode,$itemQuantity);

            //if(!$updated){
              //  $json['status1'] = 100;
            //}

        }
        $totalAmount = $transInfo[0]['totalAmount'];
        $vendor = $transInfo[0]['vendor'];
        //$transportCost = $transInfo[0]['transport'];
        //$laborCost = $transInfo[0]['labor'];

        //$accountData['balance'] = $this->genmod->getTableCol('accounts', 'balance', 'accName', 'Cash In Hand' ) + $transportCost + $laborCost;
            //$accountData['lastUpdate'] = date('y-m-d');
        //$this->Account->update(5,$accountData);

        $this->vendor->updateBalance($vendor, $totalAmount );

        //$this->db->where('referenceNo', $transRef)->delete('accountTransactions');
        $this->db->where('ref', $transRef)->delete('returnPurchase');



        
            //$this->db->where('ref', $transRef)->delete('transactions');
        //$eventDesc = "Transaction with ref no: ".$transRef."was deleted";
            
        //$this->genmod->addevent("Delete Transaction", $transRef, $eventDesc, 'purchaseTransaction', $this->session->admin_id);
            
        $json['status'] = 1;
        $json['itemCode'] = $itemCode;

        $this->db->trans_complete();

        
        
        //set final output
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }
    }
}