<?php
defined('BASEPATH') OR exit('');
?>

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
.red{
color: red; font-size: 15px;
}
@media print {
    .modal-header {
        
        -webkit-print-color-adjust: exact !important;
    }
    .red{
color: red !important;
}
}
</style>
   <div class="row" style="font-size: 15px; margin-left: 5px;">
       <b >Estimate</b>
       <br>
       <b><?php if($creditAmount === NULL){echo "Outgoing Cash Voucher"; } else{ echo "Incoming Cash Voucher";}?></b>
   </div>
    <div class="row "style="margin-right: 5px; margin-left: 5px;">
        <div class="col-xs-4" style="border: 1px solid black; ">
            
            <b>Invoice No:</b><br>
            <b><?=isset($transId) ? $transId : ""?></b>
        </div>
        <div class="col-xs-4">
            
        </div>
        <div class="col-sm-4" >
            <div class="row" style="border: 1px solid black; ">
            <b >Date:</b>
            <br>
            <b > <?=isset($transactionDate) ? ($transactionDate) : ""?></b>
            </div>
            <div class="row" style="border: 1px solid black; margin-top: 10px; ">
                <div >
            
            </div>
            </div>
        </div>
    </div>
    
    
    
    
    <table class="table table-bordered1" style="font-size: 10px;">
    <div class="row" >
        <thead>
                <tr>
                    
        <th>Category</th>
        <th>Description</th>
        <th><?php if($creditAmount === NULL){ echo "To";} else{ echo "From";}?></th>
        <th>Amount</th>
    </tr>
        </thead>
    </div>
    
    <tbody>
    <?php $init_total = 0; $profitTotal = 0; ?>
    
    
        <?php ?>
        <tr style="border: none;">
            <td><?= isset($type) ? $type: "" ?></td>
            <td><?=$description?></td>
            <td><?= $referenceNo ?></td>
            <td><?php if($creditAmount === NULL){ echo number_format($debitAmount);} else{ echo number_format($creditAmount);}?></td>
        </tr>
        
    
    
    </tbody>
    </table>
          
    <div >
        <div class="row" style="margin-right: 5px;">
            <div class="col-xs-2"></div>
            <div class="col-xs-8 text-right" style="border: 1px solid black; "><b>Total: Rs<?php if($creditAmount === NULL){ echo number_format($debitAmount);} else{ echo number_format($creditAmount);}?></b>
            
        </div>
        </div>

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
