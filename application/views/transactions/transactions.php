<?php
defined('BASEPATH') OR exit('');

$current_items = [];

if(isset($items) && !empty($items)){    
    foreach($items as $get){
        $current_items[$get->code] = $get->description;
    }
}
$customers_array = [];

if(isset($customers) && !empty($customers)){    
    foreach($customers as $get){
        $customers_array[$get->id] = $get->customerName;
    }
}
?>

<style href="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.css')?>" rel="stylesheet"></style>

<script>
    var currentItems = <?=json_encode($current_items)?>;
    var customersArray = <?=json_encode($customers_array)?>;
    jQuery(function ($) {
    var $inputs = $('input[name=customer],input[name=newCustomer]');
    $inputs.on('input', function () {
        // Set the required property of the other input to false if this input is not empty.
        $inputs.not(this).prop('required', !$(this).val().length);
    });
});
</script>

<div class="pwell hidden-print">   
    <div class="row">
        <div class="col-sm-12">
            <!--- Row to create new transaction-->
            <h1>New Batch Order</h1>
            <br>
            <!--- End of row to create new transaction-->
            <!---form to create new transactions--->
            <div class="row " id="newTransDiv">
                <!---div to display transaction form--->
                <div class="col-sm-12" id="salesTransFormDiv">
                    <div class="well">

                        <!--<form name="salesTransForm" id="salesTransForm" role="form" >-->
                            <form role="form" method="post" action="<?php echo site_url()?>edit-products-post" enctype="multipart/form-data">
                            <div class="text-center errMsg" id='newTransErrMsg'></div>
                            <br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row" id="customerDiv">
                                        <div class="col-sm-4 form-group-sm">
                                <label for="customer">Customer</label>
                                <select id="customer" name="customer" class="form-control selectedCustomerDefault" onchange="" required>
                                    <option value="">Select</option>
                                </select>
                                <span class="help-block errMsg" id="customerErr"></span>
                            </div>
                            <div class="col-sm-2 form-group-sm">
                                <label for="newCustomer">New Customer</label>
                                <input class="form-control selectedNewCustomer" type="checkbox" id="newCustomer" name="newCustomer" value="1" required>
                                
                            </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="custName">Customer Name</label>
                                            <input type="text" id="custName" name="custName" class="form-control" placeholder="Name">
                                            <span class="help-block errMsg" id="customerNameErr"></span>
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="custPhone">Customer Phone</label>
                                            <input type="tel" id="custPhone" class="form-control" placeholder="Phone Number">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="custEmail">Customer Email</label>
                                            <input type="email" id="custEmail" class="form-control" placeholder="E-mail Address">
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Address</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="Address">
                                        </div>
                                    </div>
                                    <hr>
                                    
                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Batch No.</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="Batch No. (must be unique)">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="date1">Date</label>
                                            <input type="date"  id="date1" class="form-control" >
                                            <span class="help-block date1Err"></span>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Purchase Order No.</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Brand Top/Face</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Color</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="Enter Colors Comma Seperated">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Crown Type</label>
                                            <select id="customer" name="" class="form-control selectedCustomerDefault" onchange="">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Liner Material</label>
                                            <select id="customer" name="" class="form-control selectedCustomerDefault" onchange="">
                                                <option value="">Select</option>
                                            </select>

                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Sheet Type</label>
                                            <select id="customer" name="" class="form-control selectedCustomerDefault" onchange="">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">No. of Cases</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="No. of Cartons">
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Quantity</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="No. of Cartons">

                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            
                                            <label for="date1">Due Date</label>
                                            <input type="date"  id="date1" class="form-control" >
                                            <span class="help-block date1Err"></span>
                                        
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Ups</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="">

                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="address">Total Sheets</label>
                                            <input type="text" id="custAddress" class="form-control" placeholder="">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            
                                        </div>
                                    </div>
                                    <!--Cloned div comes here--->
                                    <div id="appendClonedDivHere"></div>
                                    <!--End of cloned div here--->
                                    
                                    <!--- Text to click to add another item to transaction-->
                                    <div class="row hidden">
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
                                    
                                    <div class="row hidden">
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="totalProfit">Total Profit</label>
                                            <span id="totalProfit" class="form-control staticlabel">0</span>
                                        </div>
                                        <div class="hidden col-sm-4 form-group-sm">
                                            <label for="vat">GST(%)</label>
                                            <input type="number" min="0" id="vat" class="form-control" value="0">
                                        </div>
                                        
                                        <div class="col-sm-4 form-group-sm hidden">
                                            <label for="discount">Discount(%)</label>
                                            <input type="number" min="0" id="discount" class="form-control" value="0">
                                        </div>
                                        
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="discount">Discount(value)</label>
                                            <input type="number" min="0" id="discountValue" class="form-control" value="0">
                                        </div>
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="date1">Date</label>
                                            <input type="date"  id="date1" class="form-control" >
                                            <span class="help-block date1Err"></span>
                                        </div>
                                        
                                        <div class="hidden col-sm-3 form-group-sm">
                                            <label for="modeOfPayment">Mode of Payment</label>
                                            <select class="form-control checkField" id="modeOfPayment">
                                                <option value="Cash">Cash</option>
                                                <option value="POS">POS</option>
                                                <option value="Cash and POS">Cash and POS</option>
                                            </select>
                                            <span class="help-block errMsg" id="modeOfPaymentErr"></span>
                                        </div>
                                    </div>
                                        
                                    <div class="row hidden">
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
                                        <div class="row hidden">

                                            <div class="col-sm-4 form-group-sm">
                                            

                                            <div id="amountTenderedDiv">
                                                <label for="amountTendered" id="amountTenderedLabel">Amount Tendered</label>
                                                <input type="text" class="form-control" id="amountTendered" placeholder="0">
                                                <span class="help-block errMsg" id="amountTenderedErr"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 form-group-sm">
                                            
                                            
                                            <label for="remainingBalance">Remaining Balance</label>
                                            <span id="remainingBalance" class="form-control staticlabel">0</span>
                                        
                                            
                                        </div>
                                        <div class="col-sm-4 form-group-sm">
                                            <label for="changeDue">Change Due</label>
                                            <span class="form-control staticlabel" id="changeDue"></span>
                                        </div>

                                        </div>
                                    
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                
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
        <label>Available Quantity</label>
        <span class="form-control itemAvailQty staticlabel">0</span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Unit Price</label>
        <!--<span class="form-control itemUnitPrice">0.00</span>-->
        <input type="number" min="0" class="form-control itemUnitPrice" value="0">
    </div>
    

    <div class="col-sm-2 form-group-sm itemTransQtyDiv">
        <label>Quantity</label>
        <input type="number" min="0" class="form-control itemTransQty" value="0">
        <span class="help-block itemTransQtyErr errMsg"></span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Total Price</label>
        <span class="form-control itemTotalPrice staticlabel">0</span>

    </div>
    <div class="col-sm-1">
        <button class="close retrit">&times;</button>
    </div>
    </div>
    <div class="row">
    
    
    <div class="col-sm-8 form-group-sm">
        
    </div>
    <div class="col-sm-2 form-group-sm">
        <label>Unit Cost Price</label>
        <span class="form-control costUnitPrice staticlabel">0</span>
    </div>
    <div class="col-sm-2 form-group-sm">
        <label>Total Profit Item</label>
        <span class="form-control totalProfitItem staticlabel">0</span>
    </div>
    <div class="hidden col-sm-2 form-group-sm">
        <label>Total Cost Price</label>
        <span class="form-control totalCostPrice staticlabel">0</span>
    </div>

    
    <br class="visible-xs">
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
<script src="<?=base_url()?>public/js/newTransactions.js"></script>
<script src="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('public/ext/datetimepicker/jquery.timepicker.min.js')?>"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/datepair.min.js"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/jquery.datepair.min.js"></script>