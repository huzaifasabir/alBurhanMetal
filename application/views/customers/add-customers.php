
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
?>
<script>
    var currentItems = <?=json_encode($current_items)?>;
    var currentVendors = <?=json_encode($current_vendors)?>;
</script>
<div class="pwell hidden-print">   
    
    
    
    <hr>
    
    <!-- row of adding new item form and items list table-->


        <!---form to create new transactions--->
            
            <!--end of form-->



    <div class="row">
        <div class="col-sm-12">
            <!--Form to add/update an item-->
            <div class="col-sm-10 " id='createNewItemDiv'>
                <div class="well">
                    
                    <button class="close cancelAddItem">&times;</button><br>
                        <form role="form" method="post" action="<?php echo site_url()?>/add-customers-post" >
              
            <div class="form-group">
        <label for="customerName">CustomerName:</label>
        <input type="text" class="form-control" id="customerName" name="customerName" required>
      </div>
            <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" class="form-control" id="phone" name="phone">
      </div>
            <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email">
      </div>
            <div class="form-group">
        <label for="address">Address:</label>
        <input type="text" class="form-control" id="address" name="address">
      </div>
            <div class="form-group">
        <label for="outstandingBalance">OutstandingBalance:</label>
        <input type="number" class="form-control" id="outstandingBalance" name="outstandingBalance">
      </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
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

<script src="<?=base_url()?>public/js/login.js"></script>