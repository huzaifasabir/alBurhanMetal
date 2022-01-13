'use strict';

var barCodeTextTimeOut;
var cumTotalWithoutVATAndDiscount = 0;

$(document).ready(function(){
    $("#selItemDefault").select2();
    
    
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
	
    //load all transactions on page load
    //latr_();
    //loadCustomers();
    //console.log(customersArray);
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
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
        calchadue();//also recalculate change due
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //reload transactions table when events occur
    $("#transListPerPage, #transListSortBy").change(function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        latr_();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    $("#transSearch").keyup(function(){
        var value = $(this).val();
        
        if(value){
            $.ajax({
                url: appRoot+"search/transsearch",
                type: "get",
                data: {v:value},
                success: function(returnedData){
                    $("#transListTable").html(returnedData.transTable);
                }
            });
        }
        
        else{
            //reload the table if all text in search box has been cleared
            latr_();
        }
    });


        $("#transListTable").on('click', ".delItem", function(e){
        e.preventDefault();

        var transRef = $(this).parents('tr').find('.curTransId').val();
        var transRow = $(this).closest('tr');//to be used in removing the currently deleted row

        //console.log("Are you sure you want to delete this transaction?" + transRef);
        //console.log(transRow);

        if(transRef){
            var confirm = window.confirm("Are you sure you want to delete this transaction? \n Transaction refrence: "+ transRef +" This cannot be undone.");
            
            if(confirm){
                displayFlashMsg('Please wait...', spinnerClass, 'black');
                
                $.ajax({
                    url: appRoot+"transactions/delete",
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

        /*
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
        */
        //launch modal
        //$("#reportModal").modal('show');
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //enable/disable amount tendered input field based on the selected mode of payment
    $("#modeOfPayment").change(function(){
        var modeOfPayment = $(this).val();
        
        //remove any error message we might have
        $("#amountTenderedErr").html("");
        
        //unset the values of cashAmount and posAmount
        $("#cashAmount, #posAmount").val("");
        
        if(modeOfPayment === "POS"){
            /**
             * Change the Label
             * set the "cumulative amount" value field as the value of "amount tendered" and make the amountTendered field disabled
             * change "changeDue" to 0.00
             * hide "cash" an "pos" fields
             * 
             */
            $("#amountTenderedLabel").html("Amount Tendered");
            $("#amountTendered").val($("#cumAmount").html()).prop('disabled', true);
            $("#changeDue").html('0.00');
            $(".cashAndPos").addClass('hidden');
        }
        
        else if(modeOfPayment === "Cash and POS"){
            /*
             * Change the label
             * make empty "amount tendered" field's value and also make it writable
             * unset any value that might be in "changeDue"
             * display "cash" an "pos" fields
             */
            $("#amountTenderedLabel").html("Total");
            $("#amountTendered").val('').prop('disabled', true);
            $("#changeDue").html('');
            $(".cashAndPos").removeClass('hidden');
        }
        
        else{//if cash. If something not recognise, we assume it is cash
            /*
             * change the label
             * empty and make amountTendered field writable
             * unset any value that might be in "changeDue"
             * hide "cash" an "pos" fields
             */
            $("#amountTenderedLabel").html("Amount Tendered");
            $("#amountTendered").val('').prop('disabled', false);
            $("#changeDue").html('');
            $(".cashAndPos").addClass('hidden');
        } 
    });
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //calculate the change due based on the amount tendered. Also ensure amount tendered is not less than the cumulative amount 
    $("#amountTendered").on('change focusout keyup keydown keypress', calchadue);
    //$("#amountTendered").off('change focusout keyup keydown keypress', calchadue);
    $("#amountTendered").change(function(){
        calchadue();
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /*
     * unset mode of payment each time ".itemTransQty" changes
     * This will allow the user to be able to reselect the mode of payment, 
     * thus enabling us to recalculate change due based on amount tendered
     */
    
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

    $("#appendClonedDivHere").on("change", ".itemUnitPrice", function(e){
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
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * If mode of payment is "Cash and POS", both #cashAmount and #posAmount fields will be visible to user to add values
     * The addition of both will be set as the amount tendered
     */
    $("#cashAmount, #posAmount").on("change", function(e){
        e.preventDefault();
        
        var totalAmountTendered = parseFloat($("#posAmount").val()) + parseFloat($("#cashAmount").val());
        
        //set amount tendered as the value of "totalAmountTendered" and then trigger the change event on it
        $("#amountTendered").val(isNaN(totalAmountTendered) ? "" : totalAmountTendered).change();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //calcuate cumulative amount if the percentage of VAT is changed
    $("#vat").change(ceipacp);
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //calcuate cumulative amount if the percentage of discount is changed
    $("#discount").change(ceipacp);
    
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
    
    //$("#previousBalance").change(ceipacp());
        
        //var discountValue = $(this).val();

        //var discountPercentage = (discountValue/cumTotalWithoutVATAndDiscount) * 100;

        //display the discount (%)
        //$("#discount").val(discountPercentage).change();
    
    
    $("#customerDiv").on("change", ".selectedNewCustomer", function(e){
        e.preventDefault();
        $("#custName").val("");
        $("#custPhone").val("");
        $("#custEmail").val("");
        $("#address").val("");
        $("#previousBalance").html("0");
    });

    $("#dateDiv").on("change", ".selectedDateDefault", function(e){
        e.preventDefault();
        var date1 = $("#date1").val();
        loadDailyCashBook(date1);
        
    });


    $("#customerDiv").on("change", ".selectedCustomerDefault", function(e){
        e.preventDefault();
        var customerId = $("#customer").val();
        //console.log(customerId);

        $.ajax({
            url: appRoot+"CustomersController/gcoandqty",
            type: "get",
            data: {customerId:customerId},
            success: function(returnedData){
                if(returnedData.status === 1){
                    //console.log("here");
                    //console.log(returnedData.info);
                    var info = returnedData.info;

                    console.log(info['customerName']);                    
                    $("#custName").val(info['customerName']);
                    $("#custPhone").val(info['phone']);
                    $("#custEmail").val(info['email']);
                    $("#custAddress").val(info['address']);
                    $("#previousBalance").html(info['outstandingBalance']);
                    ceipacp();
                    //itemUnitPriceElem.innerHTML = parseFloat(returnedData.thickness);
                    //costUnitPriceElem.innerHTML = parseFloat(returnedData.costPrice);
                    
                    //qtyNeededElem.value = 1;
                    
                    //ceipacp();//recalculate since item has been changed/added
                    //calchadue();//update change due as well in case amount tendered is not empty
                    
                    //hideFlashMsg();
                    
                    //return focus to the hidden barcode input
                    //$("#useScanner").click();
                }
                
                else{
                    $("#custName").val("");
                    $("#custPhone").val("");
                    $("#custEmail").val("");
                    $("#address").val("");
                    $("#previousBalance").html("");
                    //itemAvailQtyElem.innerHTML = "0";
                    //itemUnitPriceElem.innerHTML = "0.00";
                    
                    //ceipacp();//recalculate since item has been changed/added
                    //calchadue();//update change due as well in case amount tendered is not empty
                    
                    //changeFlashMsgContent("Item not found", "", "red", "");
                }
            },
            error: function(){
                alert("ERROR!");
            }
        });
        
        
        //$("#modeOfPayment").val("");
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //handles the submission of a new sales order
    $("#confirmSaleOrder").click(function(){
        
        //ensure all fields are properly filled
        
        var arrToSend = [];
        var newCustomer = $("#newCustomer")[0].checked;
        //console.log(parseInt($("#newCustomer")[0].checked));
        var custId = $("#customer").val();
        var custName = $("#custName").val();
        var custPhone = $("#custPhone").val();
        var custEmail = $("#custEmail").val();
        var custAddress = $("#custAddress").val();
        var totalProfit = parseInt($("#totalProfit").html());
        var discountPercentage = $("#discount").val();
        var discountValue = parseInt($("#discountValue").val());
        var invoiceTotal = parseInt($("#invoiceTotal").html());
        var previousBalance = parseFloat($("#previousBalance").html());
        var cumAmount = parseFloat($("#cumAmount").html());
        var amountTendered = parseInt($("#amountTendered").val());
        var remainingBalance = parseFloat($("#remainingBalance").html());
        var changeDue = parseFloat($("#changeDue").html());
        
        
        if(!custName){
            $("#customerNameErr").html("Required");
            return;
        }else{$("#customerNameErr").html("");}
        if(newCustomer){
            newCustomer = 1;
        }else{
            newCustomer = 0;
        }
        if(invoiceTotal === 0){
            
            $("#newTransErrMsg").html("Atleast Select One Item");
            
            return;
        }
        
        else{
            //remove error messages if any
            changeInnerHTML(["newTransErrMsg"], "");
            
            //now get details of all items to be sold (itemCode, qty, unitPrice, totPrice)
            var selectedItemNode = document.getElementsByClassName("selectedItem");//get all elem with class "selectedItem"
            var selectedItemNodeLength = selectedItemNode.length;//get the number of elements with the class name
            
            var verifyCumAmount = 0;

            for(var i = 0; i < selectedItemNodeLength; i++){
                var itemCode = selectedItemNode[i].value;
                
                //var itemAvailQtyElem = selectedNode.parentNode.parentNode.children[1].children[1];
        
       

                var availQtyNode = selectedItemNode[i].parentNode.parentNode.children[1].children[1];
                var qtyNode = selectedItemNode[i].parentNode.parentNode.children[3].children[1];
                var unitPriceNode = selectedItemNode[i].parentNode.parentNode.children[2].children[1];
                var costUnitPriceNode = selectedItemNode[i].parentNode.parentNode.parentNode.children[1].children[1].children[1];
                var totalPriceNode = selectedItemNode[i].parentNode.parentNode.children[4].children[1];
                var totalCostPriceNode = selectedItemNode[i].parentNode.parentNode.parentNode.children[1].children[3].children[1];
                var totalProfitItemNode = selectedItemNode[i].parentNode.parentNode.parentNode.children[1].children[2].children[1];


                
                //get values
                var availQty = parseInt(availQtyNode.innerHTML);
                var qty = parseInt(qtyNode.value);
                var unitPrice = parseFloat(unitPriceNode.value);
                var totalPrice = parseFloat(totalPriceNode.innerHTML);
                var totalCostPrice = parseFloat(totalCostPriceNode.innerHTML);
                var expectedTotPrice = +(unitPrice*qty);
                var costUnitPrice = parseInt(costUnitPriceNode.innerHTML);
                var totalProfitItem = parseInt(totalProfitItemNode.innerHTML);
                //validate data
                if((qty === 0) || (availQty < qty) || (expectedTotPrice !== totalPrice)){
                    //totalPriceNode.style.backgroundColor = expectedTotPrice !== totalPrice ? "red" : "";
                    qtyNode.style.backgroundColor = (qty === 0) || (availQty < qty) ? "red" : "";
                    
                    return;
                }

                else{
                    //if all is well, remove all error bg color
                    totalPriceNode.style.backgroundColor = "";
                    qtyNode.style.backgroundColor = "";
                    
                    
                    //then prepare data to add to array of items' info
                    var itemInfo = {_iC:itemCode, qty:qty, unitPrice:unitPrice, costUnitPrice:costUnitPrice, totalPrice:totalPrice, totalCostPrice:totalCostPrice, totalProfitItem:totalProfitItem};

                    arrToSend.push(itemInfo);//add data to array

                    //if all is well, add totalPrice to calculate cumAmount
                    verifyCumAmount = (parseFloat(verifyCumAmount) + parseFloat(totalPrice));
                }
            }
        
            
            
            return new Promise(function(resolve, reject){
                //calculate discount amount using the discount percentage
                var discountAmount = parseInt(getDiscountAmount(verifyCumAmount));//get discount amount

                //display discount amount in discount(value) field
                $("#discountValue").val(discountAmount);

                //now update verifyCumAmount by subtracting the discount amount from it
                verifyCumAmount = +(verifyCumAmount - discountAmount).toFixed(2);
                
                resolve();
            }).then(function(){
                //update verifyCumAmount by adding VAT
                var vatAmount = getVatAmount(verifyCumAmount);//get vat amount

                //now update verifyCumAmount by adding the amount of VAT to it
                verifyCumAmount = +(verifyCumAmount + vatAmount).toFixed(2);
            
                //stop execution if cumAmount is wrong
                

                var _aoi = JSON.stringify(arrToSend);//aoi = "All orders info"

                displayFlashMsg("Processing transaction...", spinnerClass, "", "");

                //window.location = ;
                //$.post(appRoot + "/transactions/newSalesOrder", {_aoi:_aoi, _at:amountTendered, _cd:changeDue,remainingBalance:remainingBalance, previousBalance:previousBalance, _ca:cumAmount,
                //        discount:discountPercentage, totalProfit:totalProfit, invoiceTotal:invoiceTotal, cn:custName, ce:custEmail, cp:custPhone, ca:custAddress, newCustomer:newCustomer, ci:custId}, function (data) {  
                //    alert(data);  
                //    });
                //send details to server
                
                $.ajax({
                    url: appRoot+"transactions/newSalesOrder",
                    method: "post",
                    data: {_aoi:_aoi, _at:amountTendered, _cd:changeDue,remainingBalance:remainingBalance, previousBalance:previousBalance, _ca:cumAmount,
                        discount:discountPercentage,discountValue:discountValue, totalProfit:totalProfit, invoiceTotal:invoiceTotal, cn:custName, ce:custEmail, cp:custPhone, ca:custAddress, newCustomer:newCustomer, ci:custId},

                    success:function(returnedData){
                        if(returnedData.status === 1){
                            hideFlashMsg();
                            //console.log("world");

                            //reset the form
                            resetSalesTransForm();

                            //display receipt
                            $("#transReceipt").html(returnedData.transReceipt);//paste receipt
                            $("#transReceiptModal").modal('show');//show modal

                            $("#totalProfit").html("");
                            //var discountPercentage = $("#discount").val();
                            //var discountValue = parseInt($("#discountValue").val());
                            $("#invoiceTotal").html("");
                            $("#previousBalance").html("");
                            $("#cumAmount").html("");
                            //$("#amountTendered").val());
                            $("#remainingBalance").html("");
                            $("#changeDue").html("");

                            //refresh the transaction list table
                            latr_();

                            //update total earned today and profit
                            //$("#totalEarnedToday").html(returnedData.totalEarnedToday);
                            //$("#totalProfitToday").html(returnedData.profit);

                            //remove all items list in transaction and leave just one
                            resetTransList();
                        }

                        else{
                            console.log("world1");
                            console.log(returnedData);
                            changeFlashMsgContent(returnedData.msg, "", "red", "");
                        }
                    },

                    error: function(request, error){
                        console.log(error);
                        //console.log("world1");
                        //console.log(arguments);
                        checkBrowserOnline(true);
                    }
                });
            }).catch(function(){
                console.log("Err");
            });
        }
        
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //handles the submission of a new sales transaction
    $("#cancelSaleOrder").click(function(e){
        e.preventDefault();
        
        resetSalesTransForm();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //WHEN THE "USE SCANNER" BTN IS CLICKED
    $("#useScanner").click(function(e){
        e.preventDefault();
        
        //focus on the barcode text input
        $("#barcodeText").focus();
    });
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //WHEN THE BARCODE TEXT INPUT VALUE CHANGED
    $("#barcodeText").keyup(function(e){
        e.preventDefault();
        
        clearTimeout(barCodeTextTimeOut);

        var bText = $(this).val();
        var allItems = [];

        barCodeTextTimeOut = setTimeout(function(){
            if(bText){
                for(let i in currentItems){
                    if(bText === i){
                        //remove any message that might have been previously displayed
                        $("#itemCodeNotFoundMsg").html("");
    
                        //if no select input has been added or the last select input has a value (i.e. an item has been selected)
                        if(!$(".selectedItem").length || $(".selectedItem").last().val()){
                            //add a new item by triggering the clickToClone btn. This will handle everything from 'appending a list of items' to 'auto-selecting
                            //the corresponding item to the value detected by the scanner'
                            $("#clickToClone").click();                   
                        }
    
                        //else if the last select input doesn't have a value
                        else{
                            //just change the selected item to the corresponding code in var bText
                            changeSelectedItemWithBarcodeText($(this), bText);
                        }
                        
                        break;
                    }
                    
                    //if the value doesn't match the code of any item
                    else{
                        //display message telling user item not found
                        $("#itemCodeNotFoundMsg").css('color', 'red').html("Item not found. Item may not be registered.");
                    }
                }
            }
        }, 1500);
    });
    
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    //TO SHOW/HIDE THE TRANSACTION FORM
    $("#showTransForm").click(function(){
        $("#newTransDiv").toggleClass('collapse');
        
        if($("#newTransDiv").hasClass('collapse')){
            $(this).html("<i class='fa fa-plus'></i> New Transaction");
        }
        
        else{
            $(this).html("<i class='fa fa-minus'></i> New Transaction");
            
            //remove error messages
            $("#itemCodeNotFoundMsg").html("");
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
    
    
    //PREVENT AUTO-SUBMISSION BY THE BARCODE SCANNER (this shouldn't matter but just to be on the safe side)
    $("#barcodeText").keypress(function(e){
        if(e.which === 13){
            e.preventDefault();
        }
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //INITIALISE datepicker on the "From date" and "To date" fields
    $('#datePair .date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        assumeNearbyYear: true,
        todayBtn: 'linked',
        todayHighlight: true,
        endDate: 'today'
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //INITIALISE datepair on the "From date" and "To date" fields
    $("#datePair").datepair();
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //WHEN "GENERATE REPORT" BUTTON IS CLICKED FROM THE MODAL
    $("#clickToGen").click(function(e){
        e.preventDefault();
        
        var fromDate = $("#transFrom").val();
        var toDate = $("#transTo").val();
        
        if(!fromDate){
            $("#transFromErr").html("Select date to start from");
            
            return;
        }
        
        /*
         * remove any error msg, hide modal, launch window to display the report in
         */
        
        $("#transFromErr").html("");
        $("#reportModal").modal('hide');

        var strWindowFeatures = "width=1000,height=500,scrollbars=yes,resizable=yes";

        window.open(appRoot+"transactions/report/"+fromDate+"/"+toDate, 'Print', strWindowFeatures);
    });
});


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

/**
 * gti_ = "Get Transaction Info"
 * @param {type} transId
 * @returns {Boolean}
 */
function gti_(transId){
    if(transId){
        $("#transReceipt").html("<i class='fa fa-spinner faa-spin animated'></i> Loading...");
        
        //make server request to get information about transaction
        $.ajax({
            type: "POST",
            url: appRoot+"transactions/transactionReceipt",
            data: {transId:transId},
            success: function(returnedData){
                if(returnedData.status === 1){
                    $("#transReceipt").html(returnedData.transReceipt);
                }
                
                else{
                    
                }
            },
            error: function(){
                alert("ERROR!");
            }
        });
    }
    
    return false;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//to update transaction
function uptr_(transId){
    //alert(transId);
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/**
 * ceipacp = "Calculate each item's price and cumulative price"
 * This calculates the total price of each item selected for sale and also their cumulative amount
 * @returns {undefined}
 */
function ceipacp(){
    var cumulativePrice = 0;
    var totalProfitTransaction = 0;
    var invoiceTotal = 0;
    var previousBalance = parseInt($("#previousBalance").html());
    
    //loop through the items selected to calculate the total of each item
    $(".transItemList").each(function(){
        //current item's available quantity
        var availQty = parseFloat($(this).find(".itemAvailQty").html());
        
        //current item's quantity to be sold
        var transQty = parseInt($(this).find(".itemTransQty").val());
        
        //if the qty needed is greater than the qty available
        if(transQty > availQty){
            //set the value back to the max available qty
            $(this).find(".itemTransQty").val(availQty);
            
            //display msg telling user the qty left
            $(this).find(".itemTransQtyErr").html("only "+ availQty + " left");
            //console.log('here1');
            transQty = availQty;
            //console.log(transQty);
            //ceipacp();//call itself in order to recalculate price
            //return;
        }
        
        
        //else{//if all is well
            //remove err msg if any
            $(this).find(".itemTransQtyErr").html("");
            
            //calculate the total price of current item
            var itemTotalPrice = parseFloat(($(this).find(".itemUnitPrice").val()) * transQty);
            
            //round to two decimal places
            itemTotalPrice = +(itemTotalPrice).toFixed(2);

            //calculate the total price of current item
            var totalCostPrice = parseFloat(($(this).find(".costUnitPrice").html()) * transQty);

            var unitProfit = parseInt($(this).find(".itemUnitPrice").val() - $(this).find(".costUnitPrice").html() );
            var totalProfitItem = unitProfit * transQty;

            $(this).find(".totalProfitItem").html(totalProfitItem);
            //round to two decimal places
            totalCostPrice = +(totalCostPrice).toFixed(2);
            
            totalProfitTransaction += totalProfitItem;

            //display the total price
            $(this).find(".itemTotalPrice").html(itemTotalPrice);

            //total cost price hidden
            $(this).find(".totalCostPrice").html(totalCostPrice);
            
            //add current item's total price to the cumulative amount
            invoiceTotal += itemTotalPrice;

            //set the total amount before any addition or dedcution
            cumTotalWithoutVATAndDiscount = invoiceTotal;
        
        
        //trigger the click event of "use barcode" btn to focus on the barcode input text
        $("#useScanner").click();

    });
    
    return new Promise(function(resolve, reject){
        console.log("here2")
        //calculate discount amount using the discount percentage
        var discountAmount = getDiscountAmount(invoiceTotal);//get discount amount

        //display discount amount in discount(value) field
        $("#discountValue").val(discountAmount.toFixed(2));

        //now update verifyCumAmount by subtracting the discount amount from it
        invoiceTotal = +(invoiceTotal - discountAmount).toFixed(2);
        totalProfitTransaction = totalProfitTransaction - discountAmount;
        
        resolve();
    }).then(function(){
        //get vat amount
        var vatAmount = getVatAmount(invoiceTotal);

        //now update cumulativePrice by adding the amount of VAT to it
        invoiceTotal = +(invoiceTotal + vatAmount).toFixed(2);
        $("#totalProfit").html(totalProfitTransaction);
        //display the cumulative amount
        $("#invoiceTotal").html(invoiceTotal);
        cumulativePrice = invoiceTotal + previousBalance;
        $("#cumAmount").html(cumulativePrice);
        //$("#remainingBalance").html(cumulativePrice);
        
        //update change due just in case amount tendered field is filled
        calchadue();
    }).catch(function(){
        console.log("Err");
    });
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
function selectedItem(selectedNode){
    if(selectedNode){
        //get the elements of the selected item's avail qty and unit price
        var itemAvailQtyElem = selectedNode.parentNode.parentNode.children[1].children[1];
        
        var itemUnitPriceElem = selectedNode.parentNode.parentNode.children[2].children[1];
        
        var qtyNeededElem = selectedNode.parentNode.parentNode.children[3].children[1];
        
        var totalPriceElem = selectedNode.parentNode.parentNode.children[4].children[1];
        
        var costUnitPriceElem = selectedNode.parentNode.parentNode.parentNode.children[1].children[1].children[1];
        
        var totalProfitItemElem = selectedNode.parentNode.parentNode.parentNode.children[1].children[2].children[1];
        //console.log(totalProfitItemElem);
        var totalCostPriceElem = selectedNode.parentNode.parentNode.parentNode.children[1].children[3].children[1];
        //console.log(totalCostPriceElem);



        var itemCode = selectedNode.value;
        //console.log(itemCode);
		
        //displayFlashMsg("Getting item info...", spinnerClass, "", "");
        
        //get item's available quantity and unitPrice
        $.ajax({
            url: appRoot+"items/itemInfo",
            type: "get",
            data: {_iC:itemCode},
            success: function(returnedData){
                if(returnedData.status === 1){
                    var unitProfit = parseFloat(returnedData.sellingPrice) - parseFloat(returnedData.costPrice);
                    itemAvailQtyElem.innerHTML = returnedData.availQty;
                    itemUnitPriceElem.value = parseFloat(returnedData.sellingPrice);
                    costUnitPriceElem.innerHTML = parseFloat(returnedData.costPrice);
                    qtyNeededElem.value = 1;
                    totalPriceElem.innerHTML = parseFloat(returnedData.sellingPrice);
                    totalProfitItemElem.innerHTML = unitProfit;
                    totalCostPriceElem.innerHTML = parseFloat(returnedData.costPrice);
                    
                    
                    
                    ceipacp();//recalculate since item has been changed/added
                    calchadue();//update change due as well in case amount tendered is not empty
					
                    //hideFlashMsg();
                    
                    //return focus to the hidden barcode input
                    $("#useScanner").click();
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
    var cumAmount = parseInt($("#cumAmount").html());
    var amountTendered = parseInt($("#amountTendered").val());
    var remainingBalance = 0;

    if((amountTendered < cumAmount)){
        //$("#amountTenderedErr").html("Amount cannot be less than &#8358;"+ cumAmount);
        remainingBalance = +(cumAmount - amountTendered);
        //remove change due if any
        $("#remainingBalance").html(remainingBalance);
        $("#changeDue").html("0");
    }

    else{ if(amountTendered){
        $("#changeDue").html(+(amountTendered - cumAmount));
        $("#remainingBalance").html("0");
        
        //remove error msg if any
        $("#amountTenderedErr").html("");
    }else{
        $("#remainingBalance").html(cumAmount);
        $("#changeDue").html("0");
    }}
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function resetSalesTransForm(){
    document.getElementById('salesTransForm').reset();
        
    $(".itemUnitPrice, .itemTotalPrice, #cumAmount, #changeDue").html("0.00");
    $(".itemAvailQty").html("0");
    $("#amountTendered").prop('disabled', false);
    
    //remove error messages
    $("#itemCodeNotFoundMsg").html("");
	
	//remove all appended lists
	$("#appendClonedDivHere").html("");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function loadCustomers(){

    for(let key in customersArray){
                    
                console.log(key);    
                        //if the item has not been selected, append it to the select list
                        $("#customer").append("<option value='"+key+"'>"+customersArray[key]+"</option>");
                    
                }
            
}


/**
 * ctr_ = "Close Transaction receipt". This is for the receipt being displayed immediately the sales order is done
 * @deprecated v1.0.0
 * @returns {undefined}
 */
function ctr_(){
    //hide receipt and display form
    $("#salesTransFormDiv").removeClass("hidden");
    $("#showTransReceipt").addClass("hidden").html("");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function resetTransList(){
    var tot = $(".transItemList").length;
    
    $(".transItemList").each(function(){
        if($(".transItemList").length > 1){
            $(this).remove();
        }
        
        else{
            return "";
        }
    });
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/**
 * latr_ = "Load all transactions"
 * @param {type} url
 * @returns {Boolean}
 */
function latr_(url){
    var orderBy = $("#transListSortBy").val().split("-")[0];
    var orderFormat = $("#transListSortBy").val().split("-")[1];
    var limit = $("#transListPerPage").val();
    
    $.ajax({
        type:'get',
        url: url ? url : appRoot+"cashbook/latr_/",
        data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
        
        success: function(returnedData){
            hideFlashMsg();
			$("#outgoingCash").html(returnedData.transTable);
            $("#incomingCash").html(returnedData.transTable);
            $("#transListTable").html(returnedData.transTable);
        },
        
        error: function(){
            
        }
    });
    
    return false;
}

function loadDailyCashBook(date1){
    //var orderBy = $("#transListSortBy").val().split("-")[0];
    //var orderFormat = $("#transListSortBy").val().split("-")[1];
    //var limit = $("#transListPerPage").val();
    console.log("here");
    
    $.ajax({
        type:'get',
        url: appRoot+"cashbook/loadDailyCashBook/",
        data: {date1:date1},
        
        success: function(returnedData){
            hideFlashMsg();
            $("#date2").html("<h3>" + returnedData.date1 + "</h3>");
            $("#outgoingCash").html(returnedData.outgoing);
            $("#incomingCash").html(returnedData.incoming);
            $("#transListTable").html(returnedData.transTable);
            $("#revenue").html(addCommas(returnedData.Revenue));
            $("#gross").html(addCommas(returnedData.Profit));
            $("#expense").html(addCommas(returnedData.ExpenseTotal));
            $("#net").html(addCommas(returnedData.NetProfit));
            //$("#cashHardware").html(addCommas(returnedData.CashHardware));
            //$("#cashGola").html(addCommas(returnedData.CashGola));

        },
        
        error: function(){
            console.log("error");
        }
    });
    
    return false;
}



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function changeSelectedItemWithBarcodeText(barcodeTextElem, selectedItem){
    $(".selectedItem").last().val(selectedItem).change();
            
    //then remove the value from the input
    $(barcodeTextElem).val("");
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getVatAmount(cumAmount){
    //update cumAmount by adding the amount VAT to it
    var vatPercentage = $("#vat").val();//get vat percentage

    //calculate the amount vat will be
    var vatAmount = parseFloat((vatPercentage/100) * cumAmount);
    
    return vatAmount;
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function getDiscountAmount(cumAmount){
    //update cumAmount by subtracting discount amount from it
    var discountPercentage = $("#discount").val();//get discount percentage

    //calculate the discount amount
    var discountAmount = parseFloat((discountPercentage/100) * cumAmount);
    
    return discountAmount;
}



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
