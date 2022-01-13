<?php
defined('BASEPATH') OR exit('');
?>
<?php if($allTransInfo):?>
<?php $sn = 1; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<div id="transReceiptToPrint" style="margin-top: -20px; font-size: 12px;">

<style type="text/css">
        .table{
            margin-bottom: 0px;
        }
    table.table-bordered1{
    border:1px solid black;
    margin-top:0px;
  }
    table.table-bordered1 > thead > tr > th{
    border:1px solid black;
}
    table.table-bordered1> tbody > tr > td{
    border-right:1px solid black;
}
.modal-header {
     padding: 5px; 
     border-bottom: none; 
     -webkit-print-color-adjust: exact !important;
}
.red1{
    color: red;
}
.green1{
    color: green;
}
@media print {
    .modal-header {
        
        -webkit-print-color-adjust: exact !important; 
    }
    .red1{
    color: red !important;
}
.green1{
    color: green !important;
}
}
</style>
   <div class="row" style="font-size: 15px; margin-left: 5px;">
       <b>Sales Invoice</b>
       <br> 
       <b >Estimate</b>
   </div>
    <div class="row "style="margin-right: 5px; margin-left: 5px;">
        <div class="col-xs-4" style="border: 1px solid black; ">
            
            <b>Invoice No:</b><br>
            <b><?=isset($ref) ? $ref : ""?></b>
        </div>
        <div class="col-xs-4">
            
        </div>
        <div class="col-sm-4" >
            <div class="row" style="border: 1px solid black; ">
            <b >Date:</b>
            <br>
            <b > <?=isset($transDate) ? date('jS M, Y', strtotime($transDate)) : ""?></b>
            </div>
            <div class="row" style="border: 1px solid black; margin-top: 10px; ">
                <div >
            <b >Customer:</b> 
            <br>
            <b ><?=$cust_name?></b>
            </div>
            </div>
        </div>
    </div>
    
    
    
    
    <table class="table table-bordered1" style="font-size: 10px;">
    <div class="row" >
        <thead>
                <tr>
                    
        <th>Location</th>
        <th>Qty</th>
        <th>Item</th>
        <th>Price</th>
        <th>Amount</th>
    </tr>
        </thead>
    </div>
    
    <tbody>
    <?php $init_total = 0; $profitTotal = 0; ?>
    
    <?php foreach($allTransInfo as $get):?>
        <?php $location = $this->genmod->gettablecol('products', 'location', 'code', $get['itemCode']); $profit = ($get['unitPrice'] - $get['costUnitPrice'])*$get['quantity'];?>
        <tr style="border: none;">
            <td><?= isset($location) ? $location: "na" ?></td>
            <td><?=$get['quantity']?></td>
            <td><?= $this->genmod->gettablecol('products', 'description', 'code', $get['itemCode']);?></td>
            <td><?=number_format($get['unitPrice'])?></td>
            <td><?=number_format($get['totalPrice'])?></td>
            <td class="hidden-print"><?=number_format($profit,2)?></td>
        </tr>
        <?php $init_total += $get['totalPrice']; $profitTotal += $profit;?>
    <?php endforeach; ?>
    <tr class="hidden-print">
        <td></td><td></td><td></td><td></td><td></td><td><?= $profitTotal - $discountAmount ?></td>
    </tr>
    </tbody>
    </table>
          
    <div >
        <div class="row" style="margin-right: 5px;">
            <div class="col-xs-2"></div>
            <div class="col-xs-8 text-right" style="border: 1px solid black; "><b>Total: Rs;<?=isset($init_total) ? number_format($init_total, 2) : 0?></b>
            <br>
            <b>Discount: Rs <?=$discountAmount?></b>
            <br>
            <b>Previous Balance: Rs <?=$previousBalance?></b>
            <br>
            <b>FINAL TOTAL: Rs<?=isset($cumAmount) ? number_format($cumAmount, 2) : ""?></b>
        </div>
        </div>

    </div>
    
    
    <div class="row" style="margin-right: 5px;">
        <div class="col-xs-2"></div>
        <div class="col-xs-8" style="border: 1px solid black; ">
            <b>Cash Received: Rs<?=isset($amountTendered) ? number_format($amountTendered, 2) : ""?></b>
            <br>
            <b>Remaining Balance: Rs<?=isset($remainingBalance) ? number_format($remainingBalance, 2) : ""?></b>
            <br>
            <b>Change: Rs<?=isset($changeDue) ? number_format($changeDue, 2) : ""?></b>
        </div>
    </div>
   
    
    


    <br>
    <div class="row">
        <div class="col-xs-12 text-center">Goods once sold will be not Taken Back.</div>
        <div class="col-xs-12 text-center">Termite Wood Borer or Any Material Not Guaranted</div>
        <div class="col-xs-12 text-center" style="font-size: 10px;"><b>15% Deducted on Return &nbsp;&nbsp;&nbsp;&nbsp; 10% Deducted on Change</b></div>
        
    </div>
</div>
<br class="hidden-print">
<div class="row hidden-print">
    <div class="col-sm-12">
        <div class="text-center">
            <button class="btn btn-primary btn-sm" id="print" onclick="printDivHalf('cotent1')">Print</button>
            
            <button type="button" data-dismiss='modal' class="btn btn-danger">
                <i class="fa fa-close"></i> Close
            </button>
        </div>
    </div>
</div>
<br class="hidden-print">
<?php endif;?>