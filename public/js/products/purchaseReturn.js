'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
    //load all items once the page is ready
    loadPurchase1();
    
    //console.log(flag);
    
    //WHEN USE BARCODE SCANNER IS CLICKED
    $("#useBarcodeScanner").click(function(e){
        e.preventDefault();
        
        $("#itemCode").focus();
    });



    $("#clickToClone").on('click', function(e){
        e.preventDefault();
        
        var cloned = $("#divToClone").clone();
        
        //remove the id 'divToClone' from the cloned div
        cloned.addClass('transItemList').removeClass('hidden').attr('id', '');
        
        //reset the form values (in the cloned div) to default
        cloned.find(".selectedItemDefault").addClass("selectedItem").val("");
        cloned.find(".itemAvailQty").html("0");
        cloned.find(".itemTransQty").val("0");
        cloned.find(".itemTotalPrice").html("0.00");
        
        //loop through the currentItems variable to add the items to the select input
        return new Promise((resolve, reject)=>{
            //if an item has been selected (i.e. added to the current transaction), do not add it to the list. This way, an item will appear just once.
            //We start by forming an array of all selected items, then skip that item in the loop appending items to select dropdown
            var selectedItemsArr = [];
            
            return new Promise((res, rej)=>{
                $(".selectedItem").each(function(){
                    //push the selected value (which is the item code [a key in currentItems object]) to the array
                    $(this).val() ? selectedItemsArr.push($(this).val()) : "";
                });
                
                res();
            }).then(()=>{
                for(let key in currentItems){
                    //if the current key in the loop is in our 'selectedItemsArr' array
                    if(!inArray(key, selectedItemsArr)){
                        //if the item has not been selected, append it to the select list
                        cloned.find(".selectedItemDefault").append("<option value='"+key+"'>"+currentItems[key]+"</option>");
                    }
                }
            
                //prepend 'select item' to the select option
                cloned.find(".selectedItemDefault").prepend("<option value='' selected>Select Item</option>");
                
                resolve(selectedItemsArr);
            });
        }).then((selectedItemsArray)=>{
            //If the input is from the barcode scanner, we need to check if the item has already been added to the list and just increment the qty instead of 
            //re-adding it to the list, thus duplicating the item.
            if($("#barcodeText").val()){
                //This means our clickToClone btn was triggered after an item was scanned by the barcode scanner
                //Check the gotten selected items array if the item scanned has already been selected
                if(inArray($("#barcodeText").val().trim(), selectedItemsArray)){
                    //increment it
                    $(".selectedItem").each(function(){
                        if($(this).val() === $("#barcodeText").val()){
                            var newVal = parseInt($(this).closest('div').siblings('.itemTransQtyDiv').find('.itemTransQty').val()) + 1;
            
                            $(this).closest('div').siblings('.itemTransQtyDiv').find('.itemTransQty').val(newVal);
                            
                            //unset value in barcode input
                            $("#barcodeText").val('');
                            
                            return false;
                        }
                    });
                }
                
                else{
                    //if it has not been selected previously, append it to the list and set it as the selected item
                    //then append our cloned div to div with id 'appendClonedDivHere'
                    cloned.appendTo("#appendClonedDivHere");
                    
                    //add select2 to the 'select input'
                    cloned.find('.selectedItemDefault').select2();
                    
                    //set it as the selected item
                    changeSelectedItemWithBarcodeText($("#barcodeText"), $("#barcodeText").val());
                }
            }
            
            else{//i.e. clickToClone clicked manually by user
                //do not append if no item is selected in the last select list
                if($(".selectedItem").length > 0 && (!$(".selectedItem").last().val())){
                    //do nothing
                }
                
                else{
                    //then append our cloned div to div with id 'appendClonedDivHere'
                    cloned.appendTo("#appendClonedDivHere");
                    
                    //add select2 to the 'select input'
                    cloned.find('.selectedItemDefault').select2();
                }
            }
        }).catch(()=>{
            console.log('outer promise err');
        });
        
        return false;
    });
    
    
    
    $("#purchaseListTable").on('click', ".delItem", function(e){
        e.preventDefault();
        console.log("t");
        var transRef = $(this).parents('tr').find('.curTransId').val();
        var transRow = $(this).closest('tr');//to be used in removing the currently deleted row

        //console.log("Are you sure you want to delete this transaction?" + transRef);
        //console.log(transRow);

        if(transRef){
            var confirm = window.confirm("Are you sure you want to delete this transaction? \n Transaction refrence: "+ transRef +" This cannot be undone.");
            
            if(confirm){
                displayFlashMsg('Please wait...', spinnerClass, 'black');

                
                $.ajax({
                    url: appRoot+"items/deleteReturnPurchase",
                    method: "POST",
                    data: {transRef:transRef}
                }).done(function(rd){
                    if(rd.status === 1){
                        //remove item from list, update items' SN, display success msg
                        //$(itemRow).remove();

                        //update the SN
                        //resetItemSN();
                        //console.log(rd.status1);
                        //console.log(rd.m1);
                        loadPurchase1();

                        //display success message
                        changeFlashMsgContent('Transaction deleted', '', 'green', 1000);
                    }

                    else{

                    }
                }).fail(function(){
                    console.log('Req Failed');
                });
            }
        }
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //TO HIDE THE TRANSACTION FORM FROM THE TRANSACTION FORM
    $("#hideTransForm").click(function(){
        $("#newTransDiv").toggleClass('collapse');
        
        //remove error messages
        $("#itemCodeNotFoundMsg").html("");
        
        //change main "new transaction" button back to default
        $("#showTransForm").html("<i class='fa fa-plus'></i> New Transaction");
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Toggle the form to add a new item
     */
    $("#createItem").click(function(){
        $("#itemsListDiv").toggleClass("col-sm-8", "col-sm-12");
        $("#createNewItemDiv").toggleClass('hidden');
        $("#itemName").focus();
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    $(".cancelAddItem").click(function(){
        //reset and hide the form
        document.getElementById("addNewItemForm").reset();//reset the form
        $("#createNewItemDiv").addClass('hidden');//hide the form
        $("#itemsListDiv").attr('class', "col-sm-12");//make the table span the whole div
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //execute when 'auto-generate' checkbox is clicked while trying to add a new item
    $("#gen4me").click(function(){
        //if checked, generate a unique item code for user. Else, clear field
        if($("#gen4me").prop("checked")){
            var codeExist = false;
            
            do{
                //generate random string, reduce the length to 10 and convert to uppercase
                var rand = Math.random().toString(36).slice(2).substring(0, 10).toUpperCase();
                $("#itemCode").val(rand);//paste the code in input
                $("#itemCodeErr").text('');//remove the error message being displayed (if any)
                
                //check whether code exist for another item
                $.ajax({
                    type: 'get',
                    url: appRoot+"items/gettablecol/id/code/"+rand,
                    success: function(returnedData){
                        codeExist = returnedData.status;//returnedData.status could be either 1 or 0
                    }
                });
            }
            
            while(codeExist);
            
        }
        
        else{
            $("#itemCode").val("");
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //handles the submission of adding new item
    $("#addNewItem").click(function(e){
        e.preventDefault();
        
        changeInnerHTML(['itemNameErr', 'itemQuantityErr', 'itemPriceErr','costPriceErr', 'itemCodeErr', 'addCustErrMsg'], "");
        
        var itemName = $("#itemName").val();
        var itemQuantity = $("#itemQuantity").val();
        var itemPrice = $("#itemPrice").val().replace(",", "");
        var costPrice = $("#costPrice").val().replace(",", "");
        var itemCode = $("#itemCode").val();
        var itemDescription = $("#itemDescription").val();
        var itemLocation = $("#itemLocation").val();
        var itemUrduName = $("#itemUrduName").val();
        
        if(!itemName || !itemQuantity || !itemPrice || !costPrice|| !itemCode){
            !itemName ? $("#itemNameErr").text("required") : "";
            !itemQuantity ? $("#itemQuantityErr").text("required") : "";
            !itemPrice ? $("#itemPriceErr").text("required") : "";
            !costPrice ? $("#costPriceErr").text("required") : "";
            !itemCode ? $("#itemCodeErr").text("required") : "";
            
            $("#addCustErrMsg").text("One or more required fields are empty");
            
            return;
        }
        
        displayFlashMsg("Adding Item '"+itemName+"'", "fa fa-spinner faa-spin animated", '', '');
        
        $.ajax({
            type: "post",
            url: appRoot+"items/add",
            data:{itemName:itemName, itemQuantity:itemQuantity, itemPrice:itemPrice, costPrice:costPrice,  itemDescription:itemDescription, itemCode:itemCode, itemUrduName,itemUrduName, itemLocation:itemLocation},
            
            success: function(returnedData){
                if(returnedData.status === 1){
                    changeFlashMsgContent(returnedData.msg, "text-success", '', 5000);
                    console.log(returnedData.msg);
                    document.getElementById("addNewItemForm").reset();
                    
                    //refresh the items list table
                    lilt();
                    
                    //return focus to item code input to allow adding item with barcode scanner
                    $("#itemCode").focus();
                }
                
                else{
                    hideFlashMsg();
                    
                    //display all errors
                    $("#itemNameErr").text(returnedData.itemName);
                    $("#itemPriceErr").text(returnedData.itemPrice);
                    $("#costPriceErr").text(returnedData.costPrice);
                    $("#itemCodeErr").text(returnedData.itemCode);
                    $("#itemQuantityErr").text(returnedData.itemQuantity);
                    $("#addCustErrMsg").text(returnedData.msg);
                }
            },

            error: function(){
                if(!navigator.onLine){
                    changeFlashMsgContent("You appear to be offline. Please reconnect to the internet and try again", "", "red", "");
                }

                else{
                    changeFlashMsgContent("Unable to process your hello request at this time. Pls try again later!", "", "red", "");
                }
            }
        });
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //reload items list table when events occur
    $("#itemsListPerPage, #itemsListSortBy").change(function(){
        //displayFlashMsg("Please wait...", spinnerClass, "", "");
        loadPurchase1();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $("#itemSearch").keyup(function(){
        var value = $(this).val();
        
        if(value){
            $.ajax({
                url: appRoot+"search/itemsearch",
                type: "get",
                data: {v:value},
                success: function(returnedData){
                    $("#itemsListTable").html(returnedData.itemsListTable);
                }
            });
        }
        
        else{
            //reload the table if all text in search box has been cleared
            //displayFlashMsg("Loading page...", spinnerClass, "", "");
            lilt();
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //triggers when an item's "edit" icon is clicked
    $("#itemsListTable").on('click', ".editItem", function(e){
        e.preventDefault();
        
        //get item info
        var itemId = $(this).attr('id').split("-")[1];
        var itemDesc = $("#itemDesc-"+itemId).attr('title');
        var itemName = $("#itemName-"+itemId).html();
        var itemPrice = $("#itemPrice-"+itemId).html().split(".")[0].replace(",", "");
        var costPrice = $("#costPrice-"+itemId).html().split(".")[0].replace(",", "");
        var itemCode = $("#itemCode-"+itemId).html();
        var itemUrduName = $("#itemUrduName-"+itemId).html();
        var itemLocation = $("#itemLocation-"+itemId).html();
        
        //prefill form with info
        $("#itemIdEdit").val(itemId);
        $("#itemNameEdit").val(itemName);
        $("#itemCodeEdit").val(itemCode);
        $("#itemPriceEdit").val(itemPrice);
        $("#costPriceEdit").val(costPrice);
        $("#itemDescriptionEdit").val(itemDesc);
        $("#itemUrduNameEdit").val(itemUrduName);
        $("#locationEdit").val(itemLocation);
        //remove all error messages that might exist
        $("#editItemFMsg").html("");
        $("#itemNameEditErr").html("");
        $("#itemCodeEditErr").html("");
        $("#itemPriceEditErr").html("");
        $("#costPriceEditErr").html("");
        
        //launch modal
        $("#editItemModal").modal('show');
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $("#editItemSubmit").click(function(){
        var itemName = $("#itemNameEdit").val();
        var itemPrice = $("#itemPriceEdit").val();
        var costPrice = $("#costPriceEdit").val();
        var itemDesc = $("#itemDescriptionEdit").val();
        var itemId = $("#itemIdEdit").val();
        var itemCode = $("#itemCodeEdit").val();
        var itemUrduName = $("#itemUrduNameEdit").val();
        var itemLocation = $("#locationEdit").val();
        
        if(!itemName || !itemPrice || !costPrice || !itemId){
            !itemName ? $("#itemNameEditErr").html("Item name cannot be empty") : "";
            !itemPrice ? $("#itemPriceEditErr").html("Item price cannot be empty") : "";
            !costPrice ? $("#costPriceEditErr").html("Cost price cannot be empty") : "";
            !itemId ? $("#editItemFMsg").html("Unknown item") : "";
            return;
        }
        
        $("#editItemFMsg").css('color', 'black').html("<i class='"+spinnerClass+"'></i> Processing your request....");
        
        $.ajax({
            method: "POST",
            url: appRoot+"items/edit",
            data: {itemName:itemName, itemPrice:itemPrice,costPrice:costPrice, itemDesc:itemDesc, _iId:itemId, itemCode:itemCode, itemUrduName:itemUrduName, itemLocation:itemLocation}
        }).done(function(returnedData){
            if(returnedData.status === 1){
                $("#editItemFMsg").css('color', 'green').html("Item successfully updated");
                
                setTimeout(function(){
                    $("#editItemModal").modal('hide');
                }, 1000);
                
                lilt();
            }
            
            else{
                $("#editItemFMsg").css('color', 'red').html("One or more required fields are empty or not properly filled");
                
                $("#itemNameEditErr").html(returnedData.itemName);
                $("#itemCodeEditErr").html(returnedData.itemCode);
                $("#itemPriceEditErr").html(returnedData.itemPrice);
                $("#costPriceEditErr").html(returnedData.costPrice);
            }
        }).fail(function(){
            $("#editItemFMsg").css('color', 'red').html("Unable to process your request at this time. Please check your internet connection and try again");
        });
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //trigers the modal to update stock
    $("#itemsListTable").on('click', '.updateStock', function(){
        //get item info and fill the form with them
        var itemId = $(this).attr('id').split("-")[1];
        var itemName = $("#itemName-"+itemId).html();
        var itemCurQuantity = $("#itemQuantity-"+itemId).html();
        var itemCode = $("#itemCode-"+itemId).html();
        
        $("#stockUpdateItemId").val(itemId);
        $("#stockUpdateItemName").val(itemName);
        $("#stockUpdateItemCode").val(itemCode);
        $("#stockUpdateItemQInStock").val(itemCurQuantity);
        
        $("#updateStockModal").modal('show');
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //runs when the update type is changed while trying to update stock
    //sets a default description if update type is "newStock"
    $("#stockUpdateType").on('change', function(){
        var updateType = $("#stockUpdateType").val();
        
        if(updateType && (updateType === 'newStock')){
            $("#stockUpdateDescription").val("New items were purchased");
        }
        
        else{
            $("#stockUpdateDescription").val("");
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //handles the updating of item's quantity in stock
    $("#stockUpdateSubmit").click(function(){
        var updateType = $("#stockUpdateType").val();
        var stockUpdateQuantity = $("#stockUpdateQuantity").val();
        var stockUpdateDescription = $("#stockUpdateDescription").val();
        var itemId = $("#stockUpdateItemId").val();
        
        if(!updateType || !stockUpdateQuantity || !stockUpdateDescription || !itemId){
            !updateType ? $("#stockUpdateTypeErr").html("required") : "";
            !stockUpdateQuantity ? $("#stockUpdateQuantityErr").html("required") : "";
            !stockUpdateDescription ? $("#stockUpdateDescriptionErr").html("required") : "";
            !itemId ? $("#stockUpdateItemIdErr").html("required") : "";
            
            return;
        }
        
        $("#stockUpdateFMsg").html("<i class='"+spinnerClass+"'></i> Updating Stock.....");
        
        $.ajax({
            method: "POST",
            url: appRoot+"items/updatestock",
            data: {_iId:itemId, _upType:updateType, qty:stockUpdateQuantity, desc:stockUpdateDescription}
        }).done(function(returnedData){
            if(returnedData.status === 1){
                $("#stockUpdateFMsg").html(returnedData.msg);
                
                //refresh items' list
                lilt();
                
                //reset form
                document.getElementById("updateStockForm").reset();
                
                //dismiss modal after some secs
                setTimeout(function(){
                    $("#updateStockModal").modal('hide');//hide modal
                    $("#stockUpdateFMsg").html("");//remove msg
                }, 1000);
            }
            
            else{
                $("#stockUpdateFMsg").html(returnedData.msg);
                
                $("#stockUpdateTypeErr").html(returnedData._upType);
                $("#stockUpdateQuantityErr").html(returnedData.qty);
                $("#stockUpdateDescriptionErr").html(returnedData.desc);
            }
        }).fail(function(){
            $("#stockUpdateFMsg").html("Unable to process your request at this time. Please check your internet connection and try again");
        });
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //PREVENT AUTO-SUBMISSION BY THE BARCODE SCANNER
    $("#itemCode").keypress(function(e){
        if(e.which === 13){
            e.preventDefault();
            
            //change to next input by triggering the tab keyboard
            $("#itemName").focus();
        }
    });
    
    
    
    //TO DELETE AN ITEM (The item will be marked as "deleted" instead of removing it totally from the db)
    $("#itemsListTable").on('click', '.delItem', function(e){
        e.preventDefault();
        
        //get the item id
        var itemId = $(this).parents('tr').find('.curItemId').val();
        var itemRow = $(this).closest('tr');//to be used in removing the currently deleted row
        
        if(itemId){
            var confirm = window.confirm("Are you sure you want to delete item? This cannot be undone.");
            
            if(confirm){
                displayFlashMsg('Please wait...', spinnerClass, 'black');
                
                $.ajax({
                    url: appRoot+"items/delete",
                    method: "POST",
                    data: {i:itemId}
                }).done(function(rd){
                    if(rd.status === 1){
                        //remove item from list, update items' SN, display success msg
                        $(itemRow).remove();

                        //update the SN
                        resetItemSN();

                        //display success message
                        changeFlashMsgContent('Item deleted', '', 'green', 1000);
                    }

                    else{

                    }
                }).fail(function(){
                    console.log('Req Failed');
                });
            }
        }
    });
});



/**
 * "lilt" = "load Items List Table"
 * @param {type} url
 * @returns {undefined}
 */
function loadPurchase1(url){
    var orderBy = $("#itemsListSortBy").val().split("-")[0];
    var orderFormat = $("#itemsListSortBy").val().split("-")[1];
    var limit = $("#itemsListPerPage").val();
    
    
    $.ajax({
        type:'get',
        url: url ? url : appRoot+"items/loadPurchase1/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
        
        success: function(returnedData){
            //hideFlashMsg();
            $("#purchaseListTable").html(returnedData.purchaseListTable);
        },
        
        error: function(){
            
        }
    });
    
    return false;
}


function selectedItem(selectedNode){
    if(selectedNode){
        //get the elements of the selected item's avail qty and unit price
        var itemAvailQtyElem = selectedNode.parentNode.parentNode.children[1].children[1];
        var itemUnitPriceElem = selectedNode.parentNode.parentNode.children[2].children[1];
        var qtyNeededElem = selectedNode.parentNode.parentNode.children[3].children[1];
        var costUnitPriceElem = selectedNode.parentNode.parentNode.children[7].children[1];

        var itemCode = selectedNode.value;
        
        //displayFlashMsg("Getting item info...", spinnerClass, "", "");
        
        //get item's available quantity and unitPrice
        $.ajax({
            url: appRoot+"items/gcoandqty",
            type: "get",
            data: {_iC:itemCode},
            success: function(returnedData){
                if(returnedData.status === 1){
                    itemAvailQtyElem.innerHTML = returnedData.availQty;
                    itemUnitPriceElem.innerHTML = parseFloat(returnedData.unitPrice);
                    costUnitPriceElem.innerHTML = parseFloat(returnedData.costPrice);
                    
                    qtyNeededElem.value = 1;
                    
                    //ceipacp();//recalculate since item has been changed/added
                    //calchadue();//update change due as well in case amount tendered is not empty
                    
                    //hideFlashMsg();
                    
                    //return focus to the hidden barcode input
                    //$("#useScanner").click();
                }
                
                else{
                    itemAvailQtyElem.innerHTML = "0";
                    itemUnitPriceElem.innerHTML = "0.00";
                    
                    ceipacp();//recalculate since item has been changed/added
                    calchadue();//update change due as well in case amount tendered is not empty
                    
                    //changeFlashMsgContent("Item not found", "", "red", "");
                }
            }
        });
    }
}

/**
 * "vittrhist" = "View item's transaction history"
 * @param {type} itemId
 * @returns {Boolean}
 */
function vittrhist(itemId){
    if(itemId){
        
    }
    
    return false;
}



function resetItemSN(){
    $(".itemSN").each(function(i){
        $(this).html(parseInt(i)+1);
    });
}