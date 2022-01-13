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
$current_categories = [];

if(isset($categories) && !empty($categories)){    
    foreach($categories as $get){
        $current_categories[$get->subCategory] = $get->subCategory;
        //echo "string";
    }
}

?>
<script>
    var currentItems = <?=json_encode($current_items)?>;
    var currentVendors = <?=json_encode($current_vendors)?>;
    var currentCategories = <?=json_encode($current_categories)?>;
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
                    <form name="addNewItemForm" id="addNewItemForm" role="form">
                        <h1>Add New Product</h1>
                        <div class="text-center errMsg" id='addItemErrMsg'></div>
                        
                        <br>
                        
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="itemName">Item Name</label>
                                <input type="text" id="itemName" name="itemName" placeholder="Item Name (Must be unique)" maxlength="80"
                                    class="form-control" onchange="checkField(this.value, 'itemNameErr')">
                                <span class="help-block errMsg" id="itemNameErr"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="category">Category</label>
                                <input type="text" id="category1" name="category1" class="form-control" list="category" required />
                                <datalist id="category">
  
                                </datalist>
                                <span class="help-block errMsg" id="categoryErr"></span>
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-sm-12 form-group-sm hidden">
                                <label for="itemSize">Item Size</label>
                                <input type="text" id="itemSize" name="itemSize" placeholder="Item Size" maxlength="80"
                                    class="form-control" >
                                <span class="help-block errMsg" id="itemSizeErr"></span>
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
                                <select id="vendor" name="vendor" class="form-control" ></select>
                                <span class="help-block errMsg" id="vendorErr"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 form-group-sm">
                                <label for="hlink">Link</label>
                                <input type="text" id="hlink" name="hlink" 
                                    class="form-control" placeholder="Link" >
                                <span class="help-block errMsg" id="hlinkErr"></span>
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
<script src="<?=base_url()?>public/js/products/items.js"></script>