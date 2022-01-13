<?php defined('BASEPATH') OR exit('') ?>

<?= isset($range) && !empty($range) ? $range : ""; ?>
<div class="panel panel-primary" id="itemTrans">
    <!-- Default panel contents -->
    <div class="col-sm-12" id="transListTable">
    <h3>SALE TRANSACTIONS</h3>
    <?php if($itemSale): ?>
        
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Receipt No</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Amount Tendered</th>
                    <th>Remaining Balance</th>
                    <th>Total Profit</th>
                    <th>Staff</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($itemSale as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->ref?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vtr" title="Click to view receipt"><?= $get->ref ?></a></td>
                    <td><?= $get->quantity ?></td>
                    <td>Rs <?= $get->cumulativeAmount ?></td>
                    <td>Rs <?= $get->amountTendered ?></td>
                    <td>Rs <?= $get->remainingBalance ?></td>
                    <td>Rs <?=  $get->totalProfit?></td>
                    <td><?=$get->staffName?></td>
                    <td><?=$get->cust_name?></td>
                    <td><?= $get->transDate ?></td>
                    <td class="text-center"><i class="fa fa-trash text-danger delItem pointer"></i></td>
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>


<h3>ITEM RETURNS</h3>
    <?php if($itemReturns): ?>

        <?php $sn = 1; ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Receipt No</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Previous Balance</th>
                    <th>Amount Payable</th>
                    <th>Remaining Balance</th>
                    <th>Profit Reduction</th>
                    <th>Staff</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($itemReturns as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->returnRef?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vtrR" title="Click to view receipt"><?= $get->returnRef ?></a></td>
                    <td><?= $get->quantity ?></td>
                    <td>Rs <?= $get->invoiceTotal ?></td>
                    <td>Rs <?= $get->previousBalance ?></td>
                    <td>Rs <?= $get->amountPayable ?></td>
                    <td>Rs <?= $get->remainingBalance ?></td>
                    <td>Rs <?=  $get->profitReduction?></td>
                    <td><?=$get->staffName?></td>
                    <td><?=$get->cust_name?></td>
                    <td><?= $get->transDate ?></td>
                    <td class="text-center"><i class="fa fa-trash text-danger delItem pointer"></i></td>
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>

<h3>PURCHSE TRANSACTIONS</h3>
    <?php if($itemPurchase): ?>
    <div class="col-sm-12" id="purchaseListTable">
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Receipt No</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Vendor Payable</th>
                    <th>Labor Cost</th>
                    <th>Transport Cost</th>
                    <th>Staff</th>
                    <th>Vendor</th>
                    <th>Date</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($itemPurchase as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->ref?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vtrP" title="Click to view receipt"><?= $get->ref ?></a></td>
                    <td><?= $get->quantity ?></td>
                    <td>Rs <?= $get->cumulativeTotal ?></td>
                    <td>Rs <?= $get->vendorPayable ?></td>
                    <td>Rs <?= $get->labor ?></td>
                    <td>Rs <?=  $get->transport?></td>
                    <td><?=$get->staffName?></td>
                    <td><?=$get->vendor?></td>
                    <td><?= $get->transDate ?></td>
                    
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>

    
    </div>
    
    <!--Pagination div-->

</div>

<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('itemTrans')">Print</button></div>
</div> 
<!-- panel end-->

<script src="<?=base_url()?>public/js/login.js"></script>