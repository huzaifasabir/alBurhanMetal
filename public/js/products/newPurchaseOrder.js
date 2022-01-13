'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
    //load all items once the page is ready
    //lilt();
    loadVendors();
    //console.log();
    //console.log(document.getElementById("vendor"));
    
    //WHEN USE BARCODE SCANNER IS CLICKED
    $("#useBarcodeScanner").click(function(e){
        e.preventDefault();
        
        $("#itemCode").focus();
    });

    document.getElementById('date1').valueAsDate = new Date();



    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    

    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Toggle the form to add a new item
     */
 
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //handles the submission of adding new item
    $("#addNewItem").click(function(e){
        e.preventDefault();
        
        changeInnerHTML(['itemNameErr', 'categoryErr', 'thicknessErr','itemQuantityErr', 'sellingPriceErr','costPriceErr','vendorErr', 'addItemErrMsg'], "");
        
        var itemName = $("#itemName").val();
        var category = $("#category").val();
        var itemDescription = $("#itemDescription").val(); // optional
        var thickness = $("#thickness").val();
        var itemQuantity = $("#itemQuantity").val();
        var itemLocation = $("#itemLocation").val(); // optional
        var costPrice = $("#costPrice").val().replace(",", "");  
        var sellingPrice = $("#sellingPrice").val().replace(",", "");
        var vendor = $("#vendor").val();
        
        //var itemCode = $("#itemCode").val();
        //console.log(category);
        //var vendor = $("#vendor").val();
        //console.log(document.getElementById("vendor"));
        //console.log(vendor);
        //console.log($('#vendor').value());
        //var selectedCountry = $(#vendor).children("option:selected").val();
        //var itemUrduName = $("#itemUrduName").val();
        
        if(!itemName || !category || !thickness || !itemQuantity || !sellingPrice || !costPrice || !vendor){
            !itemName ? $("#itemNameErr").text("required") : "";
            !category ? $("#categoryErr").text("required") : "";
            !thickness ? $("#thicknessErr").text("required") : "";
            !itemQuantity ? $("#itemQuantityErr").text("required") : "";
            !sellingPrice ? $("#sellingPriceErr").text("required") : "";
            !costPrice ? $("#costPriceErr").text("required") : "";
            !vendor ? $("#vendorErr").text("required") : "";
            
            $("#addItemErrMsg").text("One or more required fields are empty");
            
            return;
        }
        
        
        displayFlashMsg("Adding Item '"+itemName+"'", "fa fa-spinner faa-spin animated", '', '');
        
        $.ajax({
            type: "post",
            url: appRoot+"items/add",
            data:{itemName:itemName, category:category, itemDescription:itemDescription, thickness:thickness, itemQuantity:itemQuantity, itemLocation:itemLocation, costPrice:costPrice,  sellingPrice:sellingPrice, vendor:vendor},
            
            success: function(returnedData){
                if(returnedData.status === 1){
                    changeFlashMsgContent(returnedData.msg, "text-success", '', '');
                    console.log(returnedData.msg);
                    document.getElementById("addNewItemForm").reset();
                    
                    //refresh the items list table
                    //lilt();
                    
                    //return focus to item code input to allow adding item with barcode scanner
                    $("#itemCode").focus();
                }
                
                else{
                    hideFlashMsg();
                    
                    //display all errors
                    //console.log(returnedData.error);
                    $("#itemNameErr").text(returnedData.error['itemName']);
                    $("#itemPriceErr").text(returnedData.error['sellingPrice']);
                    $("#costPriceErr").text(returnedData.error['costPrice']);
                    //$("#itemCodeErr").text(returnedData.itemCode);
                    $("#itemQuantityErr").text(returnedData.error['itemQuantity']);
                    $("#addItemErrMsg").text(returnedData.msg);
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
    //WHEN USER CLICKS BTN TO REMOVE AN ITEM FROM THE TRANSACTION LIST
    $("#appendClonedDivHere").on('click', '.retrit', function(e){
        e.preventDefault();
        
        $(this).closest(".transItemList").remove();
        
        ceipacp();//recalculate price
        //calchadue();//also recalculate change due
    });


    $("#appendClonedDivHere").on("change", ".itemTransQty", function(e){
        e.preventDefault();
        
        return new Promise((resolve, reject)=>{
            //$("#modeOfPayment").val("");
            
            resolve();
        }).then(()=>{
            ceipacp();
        }).catch();
        
        //recalculate
        ceipacp();
        
        //$("#modeOfPayment").val("");
    });

    $("#appendClonedDivHere").on("change", ".itemFixedPrice", function(e){
        e.preventDefault();
        
        return new Promise((resolve, reject)=>{
            //$("#modeOfPayment").val("");
            
            resolve();
        }).then(()=>{
            ceipacp();
        }).catch();
        
        //recalculate
        ceipacp();
        
        //$("#modeOfPayment").val("");
    });

    //$("#discount").change(ceipacp);
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //calculate discount percentage when discount (value) is changed
    $("#discountValue").change(function(){
        var discountValue = $(this).val();

        var discountPercentage = (discountValue/cumTotalWithoutVATAndDiscount) * 100;

        //display the discount (%)
        $("#discount").val(discountPercentage).change();
    });
    $("#laborCost").change(function(){
        ceipacp();
    });
    $("#transportCost").change(function(){
        ceipacp();
    });


    //when text/btn ("Add item") to clone the div to add an item is clicked
    $("#clickToClone").on('click', function(e){
        e.preventDefault();
        
        var cloned = $("#divToClone").clone();
        
        //remove the id 'divToClone' from the cloned div
        cloned.addClass('transItemList').removeClass('hidden').attr('id', '');
        
        //reset the form values (in the cloned div) to default
        cloned.find(".selectedItemDefault").addClass("selectedItem").val("");
        cloned.find(".itemAvailQty").html("0");
        cloned.find(".itemTransQty").val("0");
        //cloned.find(".itemTotalPrice").html("0.00");
        
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
    
    //handles the submission of a new sales order
    $("#confirmPurchaseOrder").click(function(){
        
        //ensure all fields are properly filled
        var vendor = $("#vendor").val();
        var date1 = $("#date1").val();
        var transportCost = parseInt($("#transportCost").val());
        var laborCost = parseInt($("#laborCost").val());
        
        var vendorPayable = ($("#vendorPayable").html());
        var cumAmount = ($("#cumAmount").html());
        var arrToSend = [];
        //console.log(vendorPayable);
        
        
        
        if( (!vendor || !date1 || vendorPayable === '0' || cumAmount === '0')){
            !vendor ? $("#vendorErr").text("required") : "";
            !vendorPayable ? $("#vendorPayableErr").text("Cannot be 0") : "";
            !cumAmount ? $("#cumErr").text("Cannot be 0") : "";
            !date1 ? $("#date1Err").text("required") : "";
            //console.log("modeOfPayment");
            return;
        }
        
        else{
            //remove error messages if any
            changeInnerHTML(["vendorErr", "vendorPayableErr","cumErr","date1Err"], "");
            
            //now get details of all items to be sold (itemCode, qty, unitPrice, totPrice)
            var selectedItemNode = document.getElementsByClassName("selectedItem");//get all elem with class "selectedItem"
            var selectedItemNodeLength = selectedItemNode.length;//get the number of elements with the class name
            
            var verifyCumAmount = 0;

            for(var i = 0; i < selectedItemNodeLength; i++){
                var itemCode = selectedItemNode[i].value;
                //console.log(itemCode);
                
                var availQtyNode = selectedItemNode[i].parentNode.parentNode.children[1].children[1];
                var qtyNode = selectedItemNode[i].parentNode.parentNode.children[3].children[1];
                //console.log(qtyNode);
                var unitFixedPriceNode = selectedItemNode[i].parentNode.parentNode.parentNode.children[1].children[2].children[1];
                //console.log(unitFixedPriceNode);
                var costPriceNode = selectedItemNode[i].parentNode.parentNode.parentNode.children[1].children[4].children[1];
                //console.log(costPriceNode);
                var totalCostPriceNode = selectedItemNode[i].parentNode.parentNode.parentNode.children[1].children[5].children[1];
                //console.log(totalCostPriceNode);
                var sellingPriceNode = selectedItemNode[i].parentNode.parentNode.parentNode.children[1].children[6].children[1];
                //console.log(sellingPriceNode);

                //console.log(unitFixedPriceNode);
                
                //get values
                var availQty = parseInt(availQtyNode.innerHTML);
                var qty = parseInt(qtyNode.value);
                var unitFixedPrice = parseInt(unitFixedPriceNode.value);
                var costPrice = parseFloat(costPriceNode.innerHTML);
                console.log(costPrice);
                var sellingPrice = parseFloat(sellingPriceNode.value);
                var totalCostPrice = (totalCostPriceNode.innerHTML);
                //var expectedTotPrice = +(unitPrice*qty).toFixed(2);
                //validate data
                if((qty === 0) ){
                    //totalPriceNode.style.backgroundColor = expectedTotPrice !== totalPrice ? "red" : "";
                    qtyNode.style.backgroundColor = (qty === 0) ? "red" : "";   
                    return;
                }

                else{
                    //if all is well, remove all error bg color
                    //totalPriceNode.style.backgroundColor = "";
                    qtyNode.style.backgroundColor = "";
                    
                    
                    //then prepare data to add to array of items' info
                    var itemInfo = {_iC:itemCode, qty:qty, unitFixedPrice:unitFixedPrice, costPrice:costPrice, sellingPrice:sellingPrice,totalCostPrice:totalCostPrice};

                    arrToSend.push(itemInfo);//add data to array

                    //if all is well, add totalPrice to calculate cumAmount
                    //verifyCumAmount = (parseFloat(verifyCumAmount) + parseFloat(totalPrice));
                }
            }
            
            
            return new Promise(function(resolve, reject){
                
                
                resolve();
            }).then(function(){
                

                var _aoi = JSON.stringify(arrToSend);//aoi = "All orders info"
                console.log(_aoi);

                displayFlashMsg("Processing transaction...", spinnerClass, "", "");
                console.log(date1);

                //send details to server
                $.ajax({
                    url: appRoot+"items/nso_",
                    method: "post",
                    data: {_aoi:_aoi,  _ca:cumAmount, vendor:vendor,  transportCost:transportCost, laborCost:laborCost,vendorPayable:vendorPayable, date1:date1},

                    success:function(returnedData){
                        if(returnedData.status === 1){
                            hideFlashMsg();
                            console.log("world1");

                            //reset the form
                            //resetSalesTransForm();
                            document.getElementById('inventoryPurchaseForm').reset();

                            //display receipt
                            //console.log(returnedData.transReceipt);
                            //console.log(returnedData.transRef);
                            $("#transReceipt").html(returnedData.transReceipt);//paste receipt
                            $("#transReceiptModal").modal('show');//show modal

                            //refresh the transaction list table
                            //latr_();

                            //update total earned today and profit
                            $("#vendorPayable").html("");
                            $("#transLabor").html("");
                            $("#cumAmount").html("");
                            document.getElementById('date1').valueAsDate = new Date();
                            //remove all items list in transaction and leave just one
                            resetTransList();
                        }

                        else{
                            console.log("world");
                            changeFlashMsgContent(returnedData.msg, "", "red", "");
                        }
                    },

                    error: function(request, error){
                        console.log(error);
                        //console.log("world1");
                        //console.log(arguments);
                        //checkBrowserOnline(true);
                    }
                });
            }).catch(function(){
                console.log("Err");
            });
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



function ceipacp(){
    var cumulativeVendorPayable = 0;
    var cumulativePrice = 0;
    var cumulativeThickMULQuant = 0;
    var transportCost = parseInt($('#transportCost').val());
    var laborCost = parseInt($('#laborCost').val());  
    var transLabor = (laborCost + transportCost);
    
    //loop through the items selected to calculate the total of each item
    $(".transItemList").each(function(){
        //current item's available quantity
        var availQty = parseInt($(this).find(".itemAvailQty").html());
        var itemThickness = parseInt($(this).find(".itemThickness").html());

        var itemFixedPrice = parseInt($(this).find(".itemFixedPrice").val());
        
        //current item's quantity to be sold
        var transQty = parseInt($(this).find(".itemTransQty").val());
        
        var thickMULQuant = itemThickness * transQty;
        //if the qty needed is greater than the qty available

        cumulativeThickMULQuant += thickMULQuant;
        
        
        
    });
    console.log(cumulativeThickMULQuant);

    //var temp = (laborCost + transportCost);
    //console.log(temp);
    var tempConst = (transLabor) / cumulativeThickMULQuant;
    //console.log(tempConst);
    //console.log(Math.round(tempConst));

    $(".transItemList").each(function(){
        //current item's available quantity
        

        var availQty = parseInt($(this).find(".itemAvailQty").html());
        var itemThickness = parseInt($(this).find(".itemThickness").html());

        var thickMULconst = tempConst * itemThickness;


        var itemFixedPrice = parseInt($(this).find(".itemFixedPrice").val());
        var itemCostPrice = (itemFixedPrice + thickMULconst);
        $(this).find(".itemCostPrice").html(itemCostPrice);

        //current item's quantity to be sold
        var transQty = parseInt($(this).find(".itemTransQty").val());

        var itemTotalCostPrice =  itemCostPrice * transQty; 

        $(this).find(".totalCostPrice").html(addCommas(itemTotalCostPrice));
        

        
        //var thickMULQuant = itemThickness * transQty;
        //if the qty needed is greater than the qty available

        cumulativePrice += itemTotalCostPrice;
        cumulativeVendorPayable += itemFixedPrice * transQty;
        
    });
    $("#cumAmount").html(addCommas(cumulativePrice));
    $("#vendorPayable").html(addCommas(cumulativeVendorPayable));
    $("#transLabor").html(addCommas(transLabor));

   
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * Populates the available quantity and unit price of selected item to be sold
 * Auto set the quantity needed to 1
 * @param {type} selectedNode
 * @returns {undefined}
 */

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * calchadue = "Calculate change due"
 * @returns {undefined}
 */
function calchadue(){
    var cumAmount = parseFloat($("#cumAmount").html());
    var amountTendered = parseFloat($("#amountTendered").val());

    if(amountTendered && (amountTendered < cumAmount)){
        $("#amountTenderedErr").html("Amount cannot be less than &#8358;"+ cumAmount);

        //remove change due if any
        $("#changeDue").html("");
    }

    else if(amountTendered){
        $("#changeDue").html(+(amountTendered - cumAmount).toFixed(2));
        
        //remove error msg if any
        $("#amountTenderedErr").html("");
    }
}



function loadVendors(){
    //console.log(currentVendors);

    for(let key in currentVendors){
                    
                //console.log(key);    
                        //if the item has not been selected, append it to the select list
                        $("#vendor").append("<option value='"+currentVendors[key]+"'>"+currentVendors[key]+"</option>");
                    
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
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit, flag:flag},
        
        success: function(returnedData){
            //hideFlashMsg();
            $("#itemsListTable").html(returnedData.itemsListTable);
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
        //var costUnitPriceElem = selectedNode.parentNode.parentNode.children[7].children[1];

        var itemCode = selectedNode.value;
        console.log(itemUnitPriceElem);
        
        //displayFlashMsg("Getting item info...", spinnerClass, "", "");
        
        //get item's available quantity and unitPrice
        $.ajax({
            url: appRoot+"items/gcoandqty",
            type: "get",
            data: {_iC:itemCode},
            success: function(returnedData){
                if(returnedData.status === 1){
                    //console.log(returnedData.info);
                    itemAvailQtyElem.innerHTML = returnedData.availQty;
                    itemUnitPriceElem.innerHTML = parseFloat(returnedData.thickness);
                    //costUnitPriceElem.innerHTML = parseFloat(returnedData.costPrice);
                    
                    qtyNeededElem.value = 1;
                    
                    ceipacp();//recalculate since item has been changed/added
                    //calchadue();//update change due as well in case amount tendered is not empty
                    
                    //hideFlashMsg();
                    
                    //return focus to the hidden barcode input
                    //$("#useScanner").click();
                }
                
                else{
                    //itemAvailQtyElem.innerHTML = "0";
                    //itemUnitPriceElem.innerHTML = "0.00";
                    
                    ceipacp();//recalculate since item has been changed/added
                    //calchadue();//update change due as well in case amount tendered is not empty
                    
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
function resetTransList(){
    var tot = $(".transItemList").length;
    
    $(".transItemList").each(function(){
        if($(".transItemList").length >= 1){
            $(this).remove();
        }
        
        else{
            return "";
        }
    });
}
