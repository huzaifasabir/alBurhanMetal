<?php
defined('BASEPATH') OR exit('');
?>
<?php if($allTransInfo):?>
<?php $sn = 1; ?>
<div id="transReceiptToPrint">
    <div class="row">
        <div class="col-xs-12 text-center text-uppercase">
            <center style='margin-bottom:5px'><img src="<?=base_url()?>public/images/favicon.jpeg" alt="logo" class="img-responsive" width="60px"></center>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-12">
            <b>Date: <?=isset($transDate) ? date('jS M, Y', strtotime($transDate)) : ""?></b>
        </div>
    </div>
    
    <div class="row" style="margin-top:2px">
        <div class="col-sm-12">
            <label>Invoice No:</label>
            <span><?=isset($ref) ? $ref : ""?></span>
        </div>
    </div>
    
    <div class="row margin-top-5">
        <div class="col-xs-12">
            <b>Customer Name: <?=$cust_name?></b>
        </div>
    </div>
    <hr>
    <table class="table table-bordered table-striped">
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
    <?php $init_total = 0; ?>
    
    <?php foreach($allTransInfo as $get):?>
        <?php $location = $this->genmod->gettablecol('products', 'location', 'code', $get['itemCode']);?>
        <tr>
            <td><?= isset($location) ? $location: "na" ?></td>
            <td><?=$get['quantity']?></td>
            <td><?=ellipsize($get['itemName'], 100);?></td>
            <td><?=number_format($get['unitPrice'])?></td>
            <td><?=number_format($get['totalPrice'])?></td>
        </tr>
        <?php $init_total += $get['totalPrice'];?>
    <?php endforeach; ?>
    
    <hr style='margin-top:20px; margin-bottom:0px'>       
    
        <tr>
            <td class="col-xs-12 text-right"><b>Total: Rs;<?=isset($init_total) ? number_format($init_total, 2) : 0?></b>
            <br>
            <b>Discount: Rs <?=$discountAmount?></b></td>
        </tr>
    

    <div class="row">
        <div class="col-xs-12 text-right">
            <b>Previous Balance: Rs <?=$previousBalance?></b>
        </div>
    </div>            
      
    <div class="row">
        <div class="col-xs-12 text-right">
            <b>FINAL TOTAL: Rs<?=isset($cumAmount) ? number_format($cumAmount, 2) : ""?></b>
        </div>
    </div>
    <hr style='margin-top:20px; margin-bottom:0px'>
    
    <div class="row">
        <div class="col-xs-12">
            <b>Cash Received: Rs<?=isset($amountTendered) ? number_format($amountTendered, 2) : ""?></b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <b>Remaining Balance: Rs<?=isset($remainingBalance) ? number_format($remainingBalance, 2) : ""?></b>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <b>Change: Rs<?=isset($changeDue) ? number_format($changeDue, 2) : ""?></b>
        </div>
    </div>
    <hr style='margin-top:5px; margin-bottom:0px'>
    </tbody>
    </table>


    <br>
    <div class="row">
        <div class="col-xs-12 text-center">Goods once sold will be not Taken Back.</div>
        <div class="col-xs-12 text-center">Termite Wood Borer or Any Material Not Guaranted</div>
        <div class="col-xs-12 text-center">15% Deducted on Return &nbsp;&nbsp;&nbsp;&nbsp; 10% Deducted on Change</div>
        
    </div>
</div>
<br class="hidden-print">
<div class="row hidden-print">
    <div class="col-sm-12">
        <div class="text-center">
            <button type="button" class="btn btn-primary ptr">
                <i class="fa fa-print"></i> Print Receipt
            </button>
            
            <button type="button" data-dismiss='modal' class="btn btn-danger">
                <i class="fa fa-close"></i> Close
            </button>
        </div>
    </div>
</div>
<br class="hidden-print">
<?php endif;?>