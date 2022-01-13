    <?php
    defined('BASEPATH') OR exit('');

    $current_items = [];

    if(isset($items) && !empty($items)){    
        foreach($items as $get){
            $current_items[$get->code] = $get->name;
        }
    }
    $customers_array = [];

    if(isset($customers) && !empty($customers)){    
        foreach($customers as $get){
            $customers_array[$get->id] = $get->customerName;
        }
    }
    $receipts_array = [];

    if(isset($receipts) && !empty($receipts)){    
        foreach($receipts as $get){
            $receipts_array[$get->ref] = $get->ref;
        }
    }

    ?>

    <style href="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.css')?>" rel="stylesheet"></style>

    <script>
        var currentItems = <?=json_encode($current_items)?>;
        var customersArray = <?=json_encode($customers_array)?>;
        var receiptsArray = <?=json_encode($receipts_array)?>;
    </script>

    <div class="pwell hidden-print">   
        <div class="row">
            <div class="col-sm-12">
                <!--- Row to create new transaction-->
                <h1>Return Product Transaction</h1>
                <br>
                <!--- End of row to create new transaction-->
                <!---form to create new transactions--->
                <div class="row " id="newTransDiv">
                    <!---div to display transaction form--->
                    <div class="col-sm-12" id="salesTransFormDiv">
                        <div class="well">

                            <form name="salesTransForm" id="salesTransForm" role="form" >
                                <div class="text-center errMsg" id='newTransErrMsg'></div>
                                <br>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row" id="receiptDiv">
                                            <div class="col-sm-4 form-group-sm">
                                                <label for="receiptNo">ReceiptNo.</label>
                                                <select id="receiptNo" name="receiptNo" class="form-control selectedReceiptDefault" onchange="">
                                                    <option value="0">Select</option>
                                                </select>
                                                <span class="help-block errMsg" id="receiptNoErr"></span>
                                            </div>
                                            

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3 form-group-sm">
                                                <label for="custName">Customer Name</label>
                                                <span id="custName" class="form-control staticlabel"></span>
                                            </div>
                                            
                                            <div class="col-sm-3 form-group-sm">
                                                <label for="custPhone">Customer Phone</label>
                                                <span id="custPhone" class="form-control staticlabel"></span>
                                            </div>
                                            
                                            <div class="col-sm-3 form-group-sm">
                                                <label for="custEmail">Customer Email</label>
                                                <span id="custEmail" class="form-control staticlabel"></span>
                                            </div>
                                            <div class="col-sm-3 form-group-sm">
                                                <label for="address">Address</label>
                                                <span id="custAddress" class="form-control staticlabel"></span>
                                            </div>
                                        </div>
                                        <hr>
                                        

                                        <!--Cloned div comes here--->
                                        <div id="appendClonedDivHere"></div>
                                        <!--End of cloned div here--->
                                        
                                        <!--- Text to click to add another item to transaction-->
                                        <div class="row">
                                            <div class="col-sm-2 text-primary pointer">
                                                <button class="btn btn-primary btn-sm" id="clickToClone"><i class="fa fa-plus"></i> Add item</button>
                                            </div>
                                            
                                            <br class="visible-xs">
                                            
                                            <div class="col-sm-2 form-group-sm">
                                                <input type="text" id="barcodeText" class="form-control" placeholder="item code" autofocus>
                                                <span class="help-block errMsg" id="itemCodeNotFoundMsg"></span>
                                            </div>
                                        </div>
                                        <!-- End of text to click to add another item to transaction-->
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-4 form-group-sm">
                                                <label for="totalProfit">Total Profit Reduction</label>
                                            <span id="totalProfit" class="form-control staticlabel">0</span>
                                            </div>
                                            <div class="col-sm-4 form-group-sm">
                                                <label for="date1">Date</label>
                                                <input type="date"  id="date1" class="form-control" >
                                                <span class="help-block date1Err"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-4 form-group-sm">
                                                <label for="invoiceTotal">Invoice Total</label>
                                                <span id="invoiceTotal" class="form-control staticlabel">0</span>
                                            </div>
                                            <div class="col-sm-4 form-group-sm">
                                                <label for="previousBalance">Previous Balance</label>
                                                <span id="previousBalance" class="form-control staticlabel">0</span>
                                            </div>
                                            <div class="col-sm-4 form-group-sm">
                                                <label for="cumAmount">Cumulative Amount</label>
                                                <span id="cumAmount" name="cumAmount"class="form-control staticlabel">0</span>
                                            </div>
                                            
                                            <div class="col-sm-4 form-group-sm">
                                                <div class="cashAndPos hidden">
                                                    <label for="cashAmount">Cash</label>
                                                    <input type="text" class="form-control" id="cashAmount">
                                                    <span class="help-block errMsg"></span>
                                                </div>

                                                <div class="cashAndPos hidden">
                                                    <label for="posAmount">POS</label>
                                                    <input type="text" class="form-control" id="posAmount">
                                                    <span class="help-block errMsg"></span>
                                                </div>

                                                
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="row">

                                            <div class="col-sm-4 form-group-sm">


                                                <div id="amountTenderedDiv">
                                                    <label for="amountPayable" id="amountPayableLabel">Amount Payable</label>
                                                    <span id="amountPayable" class="form-control staticlabel">0</span>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-sm-4 form-group-sm">


                                                <label for="remainingBalance">Remaining Balance</label>
                                                <span id="remainingBalance" class="form-control staticlabel">0</span>

                                                
                                            </div>
                                            

                                        </div>
                                        
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-sm-2 form-group-sm">
                                        <button class="btn btn-primary btn-sm" id='useScanner'>Use Barcode Scanner</button>
                                    </div>
                                    <br class="visible-xs">
                                    <div class="col-sm-6"></div>
                                    <br class="visible-xs">
                                    <div class="col-sm-4 form-group-sm">
                                        <button type="button" class="btn btn-primary btn-sm" id="confirmSaleOrder">Confirm Order</button>
                                        <button type="button" class="btn btn-danger btn-sm" id="cancelSaleOrder">Clear Order</button>
                                        <button type="button" class="btn btn-danger btn-sm" id="hideTransForm">Close</button>
                                    </div>
                                </div>
                            </form><!-- end of form-->
                        </div>
                    </div>
                    <!-- end of div to display transaction form-->
                </div>
                <!--end of form-->


                <br><br>
                <!-- sort and co row-->
                
                <!-- end of sort and co div-->
            </div>
        </div>
        
        <hr>
        
        <!-- transaction list table-->
        <div class="row">
            <!-- Transaction list div-->
            
            <!-- End of transactions div-->
        </div>
        <!-- End of transactions list table-->
    </div>




    <div class="hidden" id="divToClone">
        <div class="row">
            <div class="col-sm-3 form-group-sm">
                <label>Item</label>
                <select class="form-control selectedItemDefault" onchange="selectedItem(this)"></select>
            </div>

            <div class="col-sm-2 form-group-sm itemAvailQtyDiv">
                <label>Quantity Purchased</label>
                <span class="form-control itemAvailQty">0</span>
            </div>

            <div class="col-sm-2 form-group-sm">
                <label>Unit Price</label>
                <span class="form-control itemUnitPrice">0.00</span>
            </div>


            <div class="col-sm-2 form-group-sm itemTransQtyDiv">
                <label>Quantity</label>
                <input type="number" min="0" class="form-control itemTransQty" value="0">
                <span class="help-block itemTransQtyErr errMsg"></span>
            </div>

            <div class="col-sm-2 form-group-sm">
                <label>Total Price</label>
                <span class="form-control itemTotalPrice">0</span>

            </div>
            <div class="col-sm-1">
                <button class="close retrit">&times;</button>
            </div>
            <div class="col-sm-2 form-group-sm">
                <label>Unit Cost Price</label>
                <span class="form-control costUnitPrice">0</span>
            </div>
            
        </div>
 
    </div>


        <div class="modal fade" id='reportModal' data-backdrop='static' role='dialog'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="close" data-dismiss='modal'>&times;</div>
                        <h4 class="text-center">Generate Report</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row" id="datePair">
                            <div class="col-sm-6 form-group-sm">
                                <label class="control-label">From Date</label>                                    
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input type="text" id='transFrom' class="form-control date start" placeholder="YYYY-MM-DD">
                                </div>
                                <span class="help-block errMsg" id='transFromErr'></span>
                            </div>

                            <div class="col-sm-6 form-group-sm">
                                <label class="control-label">To Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <span><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input type="text" id='transTo' class="form-control date end" placeholder="YYYY-MM-DD">
                                </div>
                                <span class="help-block errMsg" id='transToErr'></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" id='clickToGen'>Generate</button>
                        <button class="btn btn-danger" data-dismiss='modal'>Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!---End of copy of div to clone when adding more items to sales transaction---->
        <script src="<?=base_url()?>public/js/returnTransactions.js"></script>
        <script src="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js')?>"></script>
        <script src="<?=base_url('public/ext/datetimepicker/jquery.timepicker.min.js')?>"></script>
        <script src="<?=base_url()?>public/ext/datetimepicker/datepair.min.js"></script>
        <script src="<?=base_url()?>public/ext/datetimepicker/jquery.datepair.min.js"></script>