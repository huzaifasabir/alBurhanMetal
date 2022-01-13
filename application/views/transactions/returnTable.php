<?php defined('BASEPATH') OR exit('') ?>

<?= isset($range) && !empty($range) ? $range : ""; ?>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">TRANSACTIONS</div>
    <?php if($allTransactions): ?>
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
                <?php foreach($allTransactions as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->returnRef?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vtrR" title="Click to view receipt"><?= $get->returnRef ?></a></td>
                    <td><?= $get->quantity ?></td>
                    <td>Rs <?= number_format($get->invoiceTotal) ?></td>
                    <td>Rs <?= number_format($get->previousBalance) ?></td>
                    <td>Rs <?= number_format($get->amountPayable) ?></td>
                    <td>Rs <?= number_format($get->remainingBalance) ?></td>
                    <td>Rs <?=  number_format($get->profitReduction)?></td>
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
    
    <!--Pagination div-->
    <div class="col-sm-12 text-center">
        <ul class="pagination">
            <?= isset($links) ? $links : "" ?>
        </ul>
    </div>
</div>
<!-- panel end-->