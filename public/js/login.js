'use strict';

$(document).ready(function(){
    checkDocumentVisibility(checkLogin);//check document visibility in order to confirm user's log in status
    checkLogin();
/*	
console.log("e");
console.log(document.getElementById("ledger").rows.length);
var x = document.getElementById("ledger").rows;
console.log(x[1]);
 var info = document.getElementById('info');
var d1 = new Date('01-02-2014');
var d2 = new Date('02-02-2014');
var d1 = new Date('2020-09-19');
var d2 = new Date('2020-10-03');
console.log(d2);
if(d2 > d1){
	console.log(d1);	
}

var date1 = '19th Sep, 2020';
var myTab = $('#ledger');
console.log(myTab);
var flag = 0;
myTab.find('tr').each(function (key, val) {
	console.log($(this)[0].cells.item(2).innerHTML);
			var d3 = $(this)[0].cells.item(2).innerHTML;
			d3 = new Date(d3);
			if(d3 >= d1){
				flag = 1;
        	}
        	if (flag == 1) {
        		if (d3 > d2) {
        			flag = 0;
        		}
        	}
        	if (flag == 0) {
        		$(this).addClass("hidden-print");
        	}
            	//console.log($(this));
                //var productId = val[key].innerHTML; // this isn't working
                //var product = ?
                //var Quantity = ?
            
        });/*

        /*
        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
        for (var i = 1; i < 10; i++) {

            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
            var objCells = myTab.rows.item(i).cells;

            //console.log(objCells[0].parentNode.addClass("hidden-print"));
            console.log(objCells.find("tr"));
            console.log(objCells.item(2).parentNode.addClass("hidden-print"));
            var d2 = objCells.item(2).innerHTML;
            // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
            for (var j = 0; j < objCells.length; j++) {
              //  info.innerHTML = info.innerHTML + ' ' + objCells.item(j).innerHTML;
            }
            //info.innerHTML = info.innerHTML + '<br />';     // ADD A BREAK (TAG).
        }*/


});




