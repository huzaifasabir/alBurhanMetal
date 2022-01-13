'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
    //load all items once the page is ready
    //lilt();
    
    
    //loadVendors();
    //WHEN USE BARCODE SCANNER IS CLICKED
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Toggle the form to add a new item
     */
    $("#createVendor").click(function(){
        console.log("here");
        $("#itemsListDiv").toggleClass("col-sm-8", "col-sm-12");
        $("#createNewVendorDiv").toggleClass('hidden');
        $("#companyName").focus();
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    $(".cancelAddVendor").click(function(){
        //reset and hide the form
        document.getElementById("addNewVendorForm").reset();//reset the form
        $("#createNewVendorDiv").addClass('hidden');//hide the form
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
    $("#addNewVendor").click(function(e){
        e.preventDefault();
        console.log("here");
        
        changeInnerHTML(['companyNameErr', 'salesRepresentativeErr', 'emailErr','phoneErr', 'addressErr', 'outstandingBalanceErr' , 'addVendorErrMsg'], "");
        
        var companyName = $("#companyName").val();
        var salesRepresentative = $("#salesRepresentative").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var outstandingBalance = $("#outstandingBalance").val();
        
        
        
        if(!companyName || !salesRepresentative || !email || !phone|| !address){
            !companyName ? $("#companyNameErr").text("required") : "";
            !salesRepresentative ? $("#salesRepresentativeErr").text("required") : "";
            !email ? $("#emailErr").text("required") : "";
            !phone ? $("#phoneErr").text("required") : "";
            !address ? $("#addressErr").text("required") : "";
            
            $("#addVendorErrMsg").text("One or more required fields are empty");
            
            return;
        }
        if(ValidateEmail(email, 'emailErr')){

        }else{
            return;
        }
        
        displayFlashMsg("Adding Vendor '"+companyName+"'", "fa fa-spinner faa-spin animated", '', '');
        
        $.ajax({
            type: "post",
            url: appRoot+"vendors/add",
            data:{companyName:companyName, salesRepresentative:salesRepresentative, email:email, phone:phone,  address:address, outstandingBalance:outstandingBalance},
            
            success: function(returnedData){
                if(returnedData.status === 1){
                    changeFlashMsgContent(returnedData.msg, "text-success", '', 5000);
                    console.log(returnedData.msg);
                    document.getElementById("addNewVendorForm").reset();
                    
                    //refresh the items list table
                    //lilt();
                    
                    //return focus to item code input to allow adding item with barcode scanner
                    $("#companyName").focus();
                }
                
                else{
                    hideFlashMsg();
                    
                    //display all errors
                    $("#companyNameErr").text(returnedData.error['companyName']);
                    $("#salesRepresentativeErr").text(returnedData.itemPrice);
                    $("#emailErr").text(returnedData.costPrice);
                    $("#phoneErr").text(returnedData.itemCode);
                    $("#addressErr").text(returnedData.itemQuantity);
                    $("#addVendorErrMsg").text(returnedData.msg);
                }
            },

            error: function(){
                if(!navigator.onLine){
                    changeFlashMsgContent("You appear to be offline. Please reconnect to the internet and try again", "", "red", "");
                }

                else{
                    changeFlashMsgContent("Unable to process your hello3 request at this time. Pls try again later!", "", "red", "");
                }
            }
        });
    });

    //handles the submission of adding new item
    $("#addNewTransaction").click(function(e){
        e.preventDefault();
        
        changeInnerHTML(['vendorErr', 'amountErr', 'transDateErr', 'addTransactionErrMsg'], "");
        
        var vendor = $("#vendor").val();
        var amount = $("#amount").val();
        var transDate = $("#transDate").val();
        
        
        
        if(!vendor || !amount || !transDate ){
            !vendor ? $("#vendorErr").text("required") : "";
            !amount ? $("#amountErr").text("required") : "";
            !transDate ? $("#transDateErr").text("required") : "";
            
            
            $("#addTransactionErrMsg").text("One or more required fields are empty");
            
            return;
        }
        
        displayFlashMsg("Adding Transaction for'"+vendor+"'", "fa fa-spinner faa-spin animated", '', '');
        
        $.ajax({
            type: "post",
            url: appRoot+"vendors/addNewTransaction",
            data:{vendor:vendor, amount:amount, transDate:transDate},
            
            success: function(returnedData){
                if(returnedData.status === 1){
                    changeFlashMsgContent(returnedData.msg, "text-success", '', 5000);
                    console.log(returnedData.msg);
                    document.getElementById("addTransactionForm").reset();
                    
                    //refresh the items list table
                    //lilt();
                    
                    //return focus to item code input to allow adding item with barcode scanner
                    //$("#companyName").focus();
                }
                
                else{
                    hideFlashMsg();
                    
                    //display all errors
                    
                }
            },

            error: function(){
                if(!navigator.onLine){
                    changeFlashMsgContent("You appear to be offline. Please reconnect to the internet and try again", "", "red", "");
                }

                else{
                    changeFlashMsgContent("Unable to process your hello3 request at this time. Pls try again later!", "", "red", "");
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
        lilt();
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


function ValidateEmail(value, errorElementId)
{
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

if(value.match(mailformat)){
        $("#"+errorElementId).html('');
        return true;
    }
    
    else{
        $("#"+errorElementId).html('wrong email format');
        return false;
    }
}
/**
 * "lilt" = "load Items List Table"
 * @param {type} url
 * @returns {undefined}
 */
function lilt(url){
    var orderBy = $("#itemsListSortBy").val().split("-")[0];
    var orderFormat = $("#itemsListSortBy").val().split("-")[1];
    var limit = $("#itemsListPerPage").val();
    
    
    $.ajax({
        type:'get',
        url: url ? url : appRoot+"items/lilt/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
        
        success: function(returnedData){
            //hideFlashMsg();
            $("#itemsListTable").html(returnedData.itemsListTable);
        },
        
        error: function(){
            
        }
    });
    
    return false;
}

function loadVendors(){

    for(let key in currentVendors){
                    
                //console.log(key);    
                        //if the item has not been selected, append it to the select list
                        $("#vendor").append("<option value='"+currentVendors[key]+"'>"+currentVendors[key]+"</option>");
                    
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