<?php
defined('BASEPATH') OR exit('');


$current_accounts = [];

if(isset($accountss) && !empty($accountss)){    
    foreach($accountss as $get){
        $current_accounts[$get->accName] = [$get->accName, $get->balance];
    }
}


$current_customers = [];

if(isset($customers) && !empty($customers)){    
    foreach($customers as $get){
        $current_customers[$get->customerName] = [$get->customerName, $get->outstandingBalance];
    }
}
$current_payable = [];

if(isset($payable) && !empty($payable)){    
    foreach($payable as $get){
        $current_payable[$get->accName] = [$get->accName, $get->balance];
    }
}
$current_receivable = [];

if(isset($receivable) && !empty($receivable)){    
    foreach($receivable as $get){
        $current_receivable[$get->accName] = [$get->accName, $get->balance];
    }
}

?>

<script>
    console.log(<?=json_encode($transaction)?>);
    var currentAccounts = <?=json_encode($current_accounts)?>;
    var currentCustomers = <?=json_encode($current_customers)?>;
    var currentReceivable = <?=json_encode($current_receivable)?>;
    var currentPayable = <?=json_encode($current_payable)?>;
</script>
<div class="pwell hidden-print">   
    
    <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-success">
            <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
            </div>
    <?php } ?>
    
    <hr>
    
    <!-- row of adding new item form and items list table-->


        <!---form to create new transactions--->
            
            <!--end of form-->



    <div class="row">
        <div class="col-sm-12">
            <!--Form to add/update an item-->
            <div class="col-sm-10 " id='createNewItemDiv'>
                <div class="well">
                    <h1>Incoming Cash Transaction</h1>
                    <button class="close cancelAddItem">&times;</button><br>
                    <form name="addNewItemForm" id="addNewItemForm" role="form" method="post" action="<?php echo site_url()?>/Cashbook/editIncomingPost">
                        <div class="text-center errMsg" id='addItemErrMsg'></div>

                        <input type="hidden" value="<?php echo $transaction[0]->transId ?>"  class="form-control" name="transId" id="transId">
                        
                        <br>

                        <div class="row" id="categoryDiv">
                            <div class="col-sm-12 form-group-sm">
                                <label for="category">Category</label>
                                <select id="category" name="category" class="form-control cashCategory" required>
                                    <option value="<?php echo $transaction[0]->type ?>"><?php echo $transaction[0]->type ?></option>
                                    <option value="">Select Category</option>
                                    <option value="rent">Rent</option>
                                    <option value="customer">Customer</option>
                                    <option value="gola">Gola Sale</option>
                                    <option value="hardware">Hardware Sale</option>
                                    <option value="pvcDoor">Pvc Door Sale</option>
                                    <option value="petty">Petty Cash</option>
                                    <option value="account">Account</option>
                                    <option value="factory">Factory Payment</option>
                                    <option value="payable">Accounts Payable</option>
                                    <option value="receivable">Accounts Receivable</option>

                                </select>
                                <span class="help-block errMsg" id="categoryErr"></span>
                            </div>
                        </div>

                        <div class="row" id="fromDiv">
                            <div class="col-sm-12 form-group-sm">
                                <label for="from">From</label>
                                <select id="from" name="from" class="form-control cashFrom" required>
                                    <option value="<?php echo $transaction[0]->referenceNo ?>"><?php echo $transaction[0]->referenceNo ?></option>
                                </select>
                                <span class="help-block" id="balance"></span>
                                <span class="help-block errMsg" id="fromErr"></span>
                            </div>
                        </div>

                        <div class="row" id="amountDiv">
                            <div class="col-sm-12 form-group-sm">
                                <label for="amount">Amount</label>
                                <input type="text" id="amount" name="amount" placeholder="Amount in Rs"
                                    class="form-control amountRs" min="0" required value="<?php echo $transaction[0]->creditAmount ?>" onchange="checkAmountField()">
                                <span class="help-block errMsg" id="amountErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="category">Date</label>
                                <input type="date" id="date12" name="date1" value="<?php echo $transaction[0]->transactionDate ?>" 
                                    class="form-control" required>
                                <span class="help-block errMsg" id="date1Err"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="description">Description</label>
                                <input type="text" id="description" name="description" 
                                    class="form-control" placeholder="Description" value="<?php echo $transaction[0]->description ?>" required>
                                <span class="help-block errMsg" id="descriptionErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="hlink">Link</label>
                                <input type="text" id="hlink" name="hlink" 
                                    class="form-control" value="<?php echo $transaction[0]->hlink ?>" placeholder="Link" >
                                <span class="help-block errMsg" id="hlinkErr"></span>
                            </div>
                        </div>
                        
                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button type="submit" class="btn btn-primary btn-sm" id="" >Add Transaction</button>
                            </div>

                            <div class="hidden col-sm-6 form-group-sm">
                                <button type="reset" id="cancelAddItem" class="btn btn-danger btn-sm cancelAddItem" form='addNewItemForm'>Cancel</button>
                            </div>
                        </div>
                    </form><!-- end of form-->
                </div>
            </div>
            
            

        </div>
    </div>
    <!-- End of row of adding new item form and items list table-->
</div>


<div class="hidden" id="divToClone">

<div class="row">
    <div class="col-sm-4 form-group-sm">
        <label>Item</label>
        <select class="form-control selectedItemDefault" onchange="selectedItem(this)"></select>
    </div>

    <div class="col-sm-2 form-group-sm itemAvailQtyDiv">
        <label>Available Quantity</label>
        <span class="form-control itemAvailQty">0</span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Unit Price</label>
        <span class="form-control itemUnitPrice">0.00</span>
    </div>

    <div class="col-sm-1 form-group-sm itemTransQtyDiv">
        <label>Quantity</label>
        <input type="number" min="0" class="form-control itemTransQty" value="0">
        <span class="help-block itemTransQtyErr errMsg"></span>
    </div>
    <div class="col-sm-1 form-group-sm itemTransQtyDiv">
        <label>Thickness</label>
        <input type="number" min="0" class="form-control itemTransQty" value="0">
        <span class="help-block itemTransQtyErr errMsg"></span>
    </div>
    
    <div class="col-sm-1">
        <button class="close retrit">&times;</button>
    </div>
</div>
<div class="row">
    <div class="col-sm-2 form-group-sm">
    </div>
    <div class="col-sm-2 form-group-sm">
    </div>
    <div class="col-sm-2 form-group-sm">
        <label>Unit Fixed Cost Price</label>
        <span class="form-control itemTotalPrice">0.00</span>
    </div>
    
    
    <br class="visible-xs">
    
    
    <div class="col-sm-2 form-group-sm">
        <label>Unit Cost Price</label>
        <span class="form-control costUnitPrice">0.00</span>
    </div>
    
    <div class="col-sm-2 form-group-sm">
        <label>Total Cost Price</label>
        <span class="form-control totalCostPrice">0.00</span>
    </div>

</div>
<hr>
    
    
</div>

<!--modal to update stock-->
<div id="updateStockModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Update Stock</h4>
                <div id="stockUpdateFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form name="updateStockForm" id="updateStockForm" role="form">
                    <div class="row">
                        <div class="col-sm-4 form-group-sm">
                            <label>Item Name</label>
                            <input type="text" readonly id="stockUpdateItemName" class="form-control">
                        </div>
                        
                        <div class="col-sm-4 form-group-sm">
                            <label>Item Code</label>
                            <input type="text" readonly id="stockUpdateItemCode" class="form-control">
                        </div>
                        
                        <div class="col-sm-4 form-group-sm">
                            <label>Quantity in Stock</label>
                            <input type="text" readonly id="stockUpdateItemQInStock" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 form-group-sm">
                            <label for="stockUpdateType">Update Type</label>
                            <select id="stockUpdateType" class="form-control checkField">
                                <option value="">---</option>
                                <option value="newStock">New Stock</option>
                                <option value="deficit">Deficit</option>
                            </select>
                            <span class="help-block errMsg" id="stockUpdateTypeErr"></span>
                        </div>
                        
                        <div class="col-sm-6 form-group-sm">
                            <label for="stockUpdateQuantity">Quantity</label>
                            <input type="number" id="stockUpdateQuantity" placeholder="Update Quantity"
                                class="form-control checkField" min="0">
                            <span class="help-block errMsg" id="stockUpdateQuantityErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="stockUpdateDescription" class="">Description</label>
                            <textarea class="form-control checkField" id="stockUpdateDescription" placeholder="Update Description"></textarea>
                            <span class="help-block errMsg" id="stockUpdateDescriptionErr"></span>
                        </div>
                    </div>
                    
                    <input type="hidden" id="stockUpdateItemId">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="stockUpdateSubmit">Update</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->



<!--modal to edit item-->
<div id="editItemModal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-center">Edit Item</h4>
                <div id="editItemFMsg" class="text-center"></div>
            </div>
            <div class="modal-body">
                <form role="form">
                    <div class="row">
                        <div class="col-sm-4 form-group-sm">
                            <label for="itemNameEdit">Item Name</label>
                            <input type="text" id="itemNameEdit" placeholder="Item Name" autofocus class="form-control checkField">
                            <span class="help-block errMsg" id="itemNameEditErr"></span>
                        </div>
                        <div class="col-sm-4 form-group-sm">
                            <label for="itemUrduNameEdit">Urdu Name (Optional)</label>
                            <input type="text" id="itemUrduNameEdit" placeholder="Urdu Name" autofocus class="form-control checkField">
                            <span class="help-block errMsg" id="itemUrduNameEditErr"></span>
                        </div>
                        
                        <div class="col-sm-4 form-group-sm">
                            <label for="itemCode">Item Code</label>
                            <input type="text" id="itemCodeEdit" class="form-control">
                            <span class="help-block errMsg" id="itemCodeEditErr"></span>
                        </div>
                        
                        <div class="col-sm-4 form-group-sm">
                            <label for="unitPrice">Unit Price</label>
                            <input type="text" id="itemPriceEdit" name="itemPrice" placeholder="Unit Price" class="form-control checkField">
                            <span class="help-block errMsg" id="itemPriceEditErr"></span>
                        </div>
                        <div class="col-sm-4 form-group-sm">
                            <label for="costPrice">Cost Price</label>
                            <input type="text" id="costPriceEdit" name="costPrice" placeholder="Cost Price" class="form-control checkField">
                            <span class="help-block errMsg" id="costPriceEditErr"></span>
                        </div>
                        <div class="col-sm-4 form-group-sm">
                            <label for="location">Location (Optional)</label>
                            <input type="text" id="locationEdit" name="location" placeholder="Location" class="form-control checkField">
                            <span class="help-block errMsg" id="locationEditErr"></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 form-group-sm">
                            <label for="itemDescriptionEdit" class="">Description (Optional)</label>
                            <textarea class="form-control" id="itemDescriptionEdit" placeholder="Optional Item Description"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="itemIdEdit">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="editItemSubmit">Save</button>
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!--end of modal-->
<script src="<?=base_url()?>public/js/cashbook/incomingCash.js"></script>