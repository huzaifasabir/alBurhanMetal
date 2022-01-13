<?php
defined('BASEPATH') OR exit('');

$current_items = [];

if(isset($items) && !empty($items)){    
    foreach($items as $get){
        $current_items[$get->code] = $get->name;
    }
}


$current_vendors = [];

if(isset($vendors) && !empty($vendors)){    
    foreach($vendors as $get){
        $current_vendors[$get->id] = $get->companyName;
    }
}
$transInfo_array = [];
//echo $transInfo[0]['cust_name'];
if(isset($transInfo) && !empty($transInfo)){    
    foreach($transInfo as $get){
        $quantity = $this->genmod->gettablecol('products', 'quantity', 'code', $get['itemCode']) - $get['quantity'];
        $thickness =  $this->genmod->gettablecol('products', 'thickness', 'code', $get['itemCode']);
        $transInfo_array[$get['transId']] = [$quantity, $thickness];
    }
}
?>
<script>
    var currentItems = <?=json_encode($current_items)?>;
    var currentVendors = <?=json_encode($current_vendors)?>;
    var transInfoArray = <?=json_encode($transInfo_array)?>;
    var transInfo = <?=json_encode($transInfo)?>;
</script>
<div class="pwell hidden-print">   
    
    
    
    <hr>
    
    <!-- row of adding new item form and items list table-->


        <!---form to create new transactions--->
            <div class="row " id="newPurchaseOrderDiv">
                <!---div to display transaction form--->
                <div class="col-sm-12" id="inventoryPurchaseFormDiv">
                    <div class="well">
                        <form name="inventoryPurchaseForm" id="inventoryPurchaseForm" role="form">
                            <h1>Edit Purchase Order</h1>
                            <div class="text-center errMsg" id='newInventoryPurchaseErrMsg'></div>
                            <br>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">

                                    
                                </div>
                                    <!--Cloned div comes here--->
                                    <div id="appendClonedDivHere"></div>
                                    <!--End of cloned div here--->
                                    
                                    <!--- Text to click to add another item to transaction-->
                                    <div class="row">
                                        <div class="col-sm-2 text-primary pointer">
                                            <button class="btn btn-primary btn-sm" id="clickToClone"><i class="fa fa-plus"></i> Add Product</button>
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
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="vendor">Vender</label>
                                            <input type="text"  id="vendor" name="vendor" class="form-control" value="<?= $transInfo[0]['vendor']?>">
                                            <span class="help-block vendorErr"></span>
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="transportCost">Transport Cost</label>
                                            <input type="number" min="0" id="transportCost" class="form-control" value="0">
                                        </div>
                                        
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="laborCost">Labor Cost</label>
                                            <input type="number" min="0" id="laborCost" class="form-control" value="0">
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="date1">Date</label>
                                            <input type="date"  id="date1" class="form-control" >
                                            <span class="help-block date1Err"></span>
                                        </div>
                                        
                        
                                    </div>

                                    <hr>
                                        
                                    <div class="row">
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="cumAmount">Vendor Payable</label>
                                            <span id="vendorPayable" class="form-control staticlabel">0</span>
                                            <span class="help-block vendorPayableErr"></span>
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="cumAmount">Transport + Labor Cost</label>
                                            <span id="transLabor" class="form-control staticlabel">0</span>
                                        </div>
                                        <div class="col-sm-3 form-group-sm">
                                            <label for="cumAmount">Cumulative Total Amount</label>
                                            <span id="cumAmount" class="form-control staticlabel">0</span>
                                            <span class="help-block cumErr"></span>
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
                                        

                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col-sm-2 form-group-sm">
                                </div>
                                <br class="visible-xs">
                                <div class="col-sm-6"></div>
                                <br class="visible-xs">
                                <div class="col-sm-4 form-group-sm">
                                    <button type="button" class="btn btn-primary btn-sm" id="confirmPurchaseOrder">Confirm Order</button>
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



    <div class="row">
        <div class="col-sm-12">
            <!--Form to add/update an item-->
            <div class="col-sm-4 hidden" id='createNewItemDiv'>
                <div class="well">
                    
                    <button class="close cancelAddItem">&times;</button><br>
                    <form name="addNewItemForm" id="addNewItemForm" role="form">
                        <div class="text-center errMsg" id='addCustErrMsg'></div>
                        
                        <br>
                        
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemName">Item Name</label>
                                <input type="text" id="itemName" name="itemName" placeholder="Item Name" maxlength="80"
                                    class="form-control" onchange="checkField(this.value, 'itemNameErr')">
                                <span class="help-block errMsg" id="itemNameErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm hidden">
                                <label for="itemUrduName">Urdu Name (Optional)</label>
                                <input type="text" id="itemUrduName" name="itemUrduName" placeholder="Urdu Name (Optional)" maxlength="80" class="form-control" >
                                <span class="help-block errMsg" id="itemUrduNameErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemDescription" class="">Description (Optional)</label>
                                <textarea class="form-control" id="itemDescription" name="itemDescription" rows='4'
                                    placeholder="Optional Item Description"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="thickness">Thickness</label>
                                <input type="number" id="thickness" name="thickness" placeholder="Thickness in mm"
                                    class="form-control" min="0" onchange="checkField(this.value, 'thicknessErr')">
                                <span class="help-block errMsg" id="thicknessErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemQuantity">Quantity</label>
                                <input type="number" id="itemQuantity" name="itemQuantity" placeholder="Available Quantity"
                                    class="form-control" min="0" onchange="checkField(this.value, 'itemQuantityErr')">
                                <span class="help-block errMsg" id="itemQuantityErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemLocation" class="">Location (Optional)</label>
                                <input type="text" id="itemLocation" name="itemLocation" placeholder="Item Location (Optional)" maxlength="80" class="form-control" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="costPrice">(Rs)Cost Price</label>
                                <input type="text" id="costPrice" name="costPrice" placeholder="(Rs)Cost Price" class="form-control"
                                    onchange="checkField(this.value, 'costPriceErr')">
                                <span class="help-block errMsg" id="costPriceErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="sellingPrice">(Rs)Selling Price</label>
                                <input type="text" id="sellingPrice" name="sellingPrice" placeholder="(Rs)Selling Price" class="form-control"
                                    onchange="checkField(this.value, 'sellingPriceErr')">
                                <span class="help-block errMsg" id="sellingPriceErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="vendor">Vendor</label>
                                <select id="" name="" class="form-control selectedVendorDefault" onchange="selectedItem(this)"></select>
                                <span class="help-block errMsg" id="vendorErr"></span>
                            </div>
                        </div>

                        
                        <br>
                        <div class="row text-center">
                            <div class="col-sm-6 form-group-sm">
                                <button class="btn btn-primary btn-sm" id="addNewItem">Add Product</button>
                            </div>

                            <div class="col-sm-6 form-group-sm">
                                <button type="reset" id="cancelAddItem" class="btn btn-danger btn-sm cancelAddItem" form='addNewItemForm'>Cancel</button>
                            </div>
                        </div>
                    </form><!-- end of form-->
                </div>
            </div>
            
            <!--- Item list div-->
            <div class="col-sm-12" id="itemsListDiv">
                <!-- Item list Table-->
                <div class="row">
                    <div class="col-sm-12" id="itemsListTable"></div>
                </div>
                <!--end of table-->
            </div>
            <!--- End of item list div-->

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
        <span class="form-control itemAvailQty staticlabel">0</span>
    </div>

    <div class="col-sm-2 form-group-sm">
        <label>Thickness</label>
        <span class="form-control itemThickness staticlabel">0.00</span>
    </div>

    <div class="col-sm-2 form-group-sm itemTransQtyDiv">
        <label>Quantity</label>
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
        <input type="number" min="0" class="form-control itemFixedPrice" value="0">
    </div>
    
    
    <br class="visible-xs">
    
    
    <div class="col-sm-2 form-group-sm">
        <label>Unit Cost Price</label>
        <span class="form-control itemCostPrice staticlabel">0</span>
    </div>
    
    <div class="col-sm-2 form-group-sm">
        <label>Total Cost Price</label>
        <span class="form-control totalCostPrice staticlabel">0</span>
    </div>
    <div class="col-sm-2 form-group-sm">
        <label>New Selling Price</label>
        <input type="number" min="0" class="form-control itemSellingPrice" value="0">
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
<script src="<?=base_url()?>public/js/products/editPurchaseOrder.js"></script>