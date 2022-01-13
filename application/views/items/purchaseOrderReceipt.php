<?php
defined('BASEPATH') OR exit('');
?>
<?php if($allTransInfo):?>
<?php $sn = 1; ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<div id="transReceiptToPrint">
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
            <b >Vendor:</b> 
            <br>
            <b ><?=isset($vendor) ? $vendor : ""?></b>
            </div>
            </div>
        </div>
    </div>
    
    
    
        <table class="table table-bordered1" style="font-size: 10px;">
    <div class="row" >
        <thead>
                <tr>
                    
        <th>Item</th>
        <th>FixedPrice</th>
        <th>Qty</th>
        <th>CostPrice</th>
        <th>Total(Rs)</th>
    </tr>
        </thead>
    </div>
    
    <tbody>
    <?php $init_total = 0; ?>
    
    <?php foreach($allTransInfo as $get):?>
        <tr style="border: none;">
            <td><?= $this->genmod->gettablecol('products', 'description', 'code', $get['itemCode']);?></td>
            <td><?=number_format($get['fixedCostPrice'], 2);?></td>
            <td><?=$get['quantity']?></td>
            <td><?=number_format($get['costPrice'],2)?></td>
            <td><?=number_format($get['fixedCostPrice'] * $get['quantity'],2)?></td>
            
        </tr>
        <?php $init_total += ($get['fixedCostPrice'] * $get['quantity']);?>
    <?php endforeach; ?>
    </tbody>
    </table>

    <hr style='margin-top:2px; margin-bottom:0px'>       
    <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-8 text-right" style="border: 1px solid black; ">
            <b>Total: Rs<?=isset($init_total) ? number_format($init_total, 2) : 0?></b>
            <br>
            <b>Previous Balance: Rs<?php $outstandingBalance = $this->genmod->gettablecol('vendors', 'outstandingBalance', 'companyName', $vendor); if (!$outstandingBalance) {
                echo "0";
            }else{ ?>
            <?= number_format($this->genmod->gettablecol('vendors', 'outstandingBalance', 'companyName', $vendor) - $init_total, 2)?> <?php } ?></b>
            <br>
            <b>Total Balance: Rs<?= number_format($this->genmod->gettablecol('vendors', 'outstandingBalance', 'companyName', $vendor), 2)?></b>
        </div>
    </div>
          
    <div class="row">
        <div class="col-xs-2"></div>
        <div class="col-xs-8 text-right" style="border: 1px solid black; ">
            <b>Total Vendor Payable Rs <?=isset($vendorPayable) ? number_format($vendorPayable, 2) : ""?></b>
            <br>
            <b>Transport Cost Rs <?=isset($transportCost) ? number_format($transportCost, 2) : ""?></b>
            <br>
            <b>Labor Cost Rs <?=isset($laborCost) ? number_format($laborCost, 2) : ""?></b>
        </div>
        </div>
    </div>
    <hr style='margin-top:5px; margin-bottom:0px'>
    

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
