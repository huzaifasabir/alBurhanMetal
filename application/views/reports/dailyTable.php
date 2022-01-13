<?php defined('BASEPATH') OR exit('') ?>

<div id="incomeReport" style="font-size: 18px">
<div class="row">
    <div class="col-xs-6">
<div class="panel panel-primary">
    
    <!-- Default panel contents -->
    <div class="panel-heading">Incoming</div>
    <?php $incomingTotal = 0; $incomingTotal += $plywoodSale; $incomingTotal += $hardwareSale; $incomingTotal += $golaSale; $incomingTotal += $pvcSale; $incomingTotal += $rent;  $incomingTotal += $pettyCashIn; ?>
    
    <b>Sale: <br>
    Plywood: <?=isset($plywoodSale) ? number_format($plywoodSale) : "0"?> <br>
    Hardware: <?=isset($hardwareSale) ? number_format($hardwareSale) : "0"?> <br>
    Gola: <?=isset($golaSale) ? number_format($golaSale) : "0"?> <br>

    PvcDoor: <?=isset($pvcSale) ? number_format($pvcSale) : "0"?> <br>
    <hr>
    Rent: <?=isset($rent) ? number_format($rent) : "0"?> <br>
    <hr>

    Factory:<br></b>
    <?php if($factory): ?>
        <?php foreach($factory as $get): ?>
            <?php if($get->creditAmount):  $incomingTotal += $get->creditAmount;?>
            <?= $get->referenceNo ?> : | <?= number_format($get->creditAmount) ?>  | <?= $get->description ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<hr>
    <b>Cash From Home:<br></b>
    <?php if($homeCash): ?>
        <?php foreach($homeCash as $get): ?>
            <?php if($get->creditAmount): $incomingTotal += $get->creditAmount; ?>
            <?= $get->referenceNo ?> : | <?= number_format($get->creditAmount) ?>  | <?= $get->description ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<hr>
    <b>Petty Cash: <?=isset($pettyCashIn) ? number_format($pettyCashIn) : "0"?> <br>
<hr>
    Cash From Bank:<br></b>
    <?php if($bank): ?>
        <?php foreach($bank as $get): ?>
            <?php if($get->creditAmount): $incomingTotal += $get->creditAmount; ?>
            <?= $get->referenceNo ?> : | <?= number_format($get->creditAmount) ?>  | <?= $get->description ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

<hr>
<b>Total: <?=isset($incomingTotal) ? number_format($incomingTotal) : "0"?> <br></b>


<!-- table div end-->
    
    </div>
</div>
<div class="col-xs-6">
<div class="panel panel-primary">
    
    <!-- Default panel contents -->
    <div class="panel-heading">Outgoing</div>
    <?php $outgoingTotal = 0; $outgoingTotal += $shopExpense; $outgoingTotal += $hardwareExpense; $outgoingTotal += $golaExpense; $outgoingTotal += $pvcExpense; $outgoingTotal += $homeExpense;  $outgoingTotal += $pettyCashOut; $outgoingTotal += $transportLabor;?>
    
    <b>Sale: <br>
    Shop Expense: <?=isset($shopExpense) ? number_format($shopExpense) : "0"?> <br>
    Hardware Expense: <?=isset($hardwareExpense) ? number_format($hardwareExpense) : "0"?> <br>
    Gola Expense: <?=isset($golaExpense) ? number_format($golaExpense) : "0"?> <br>

    PvcDoor Expense: <?=isset($pvcExpense) ? number_format($pvcExpense) : "0"?> 
    
<hr>
Home Expense: <?=isset($homeExpense) ? number_format($homeExpense) : "0"?> 
<hr>
    Factory:<br></b>
    <?php if($factory): ?>
        <?php foreach($factory as $get): ?>
            <?php if($get->debitAmount): $outgoingTotal += $get->debitAmount;?>
            <?= $get->referenceNo ?> : | <?= number_format($get->debitAmount) ?>  | <?= $get->description ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<hr>
    <b>Cash Going Home:<br></b>
    <?php if($homeCash): ?>
        <?php foreach($homeCash as $get): ?>
            <?php if($get->debitAmount): $outgoingTotal += $get->debitAmount;?>
            <?= $get->referenceNo ?> : | <?= number_format($get->debitAmount) ?>  | <?= $get->description ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<hr>
    <b>Petty Cash: <?=isset($pettyCashOut) ? number_format($pettyCashOut) : "0"?></b> 
<hr>
    <b>Cash Going to Bank:<br></b>
    <?php if($bank): ?>
        <?php foreach($bank as $get): ?>
            <?php if($get->debitAmount): $outgoingTotal += $get->debitAmount;?>
            <?= $get->referenceNo ?> : | <?= number_format($get->debitAmount) ?>  | <?= $get->description ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<hr>
    <b>Vendor Payments:<br></b>
    <?php if($vendor): ?>
        <?php foreach($vendor as $get): $outgoingTotal += $get->debitAmount;?>
            <?php if($get->debitAmount): ?>
            <?= $get->referenceNo ?> : | <?= number_format($get->debitAmount) ?>  | <?= $get->description ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <hr>
    <b>Transport Plus Labor Cost: <?=isset($transportLabor) ? number_format($transportLabor) : "0"?> <br>

<hr>
Total: <?=isset($outgoingTotal) ? number_format($outgoingTotal) : "0"?> <br></b>

<!-- table div end-->
    
    </div>
</div>
</div>
<br>
    <br>
    <hr>

</div>
<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv1('incomeReport')">Print</button></div>
</div> 
<!-- panel end-->