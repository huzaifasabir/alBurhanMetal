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
                    <th>Type</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Account</th>
                    <th>Amount</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($allTransactions as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->transId?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><a class="pointer vICr" title="Click to view receipt"><?= $get->transId ?></a></td>
                    <td><?= $get->type ?></td>
                    <td><?= $get->description ?></td>
                    <td><?= $get->transactionDate ?></td>
                    <td><?= $get->referenceNo ?></td>
                    <td>Rs <?= isset($get->debitAmount) ? number_format($get->debitAmount) : number_format($get->creditAmount) ?></td>
                    <td class="text-center text-primary hidden-print">
                        <a href="<?php echo site_url(); echo isset($get->creditAmount)? 'Cashbook/incomingCashEdit/' : 'Cashbook/outgoingCashEdit/' ; echo $get->transId;?>" >Edit</a>
                            <i class="fa fa-pencil pointer"></i>
                    </td>
                    <td class="text-center hidden-print" id="<?=$get->transId?>">
                        <a href="<?php echo site_url(); echo isset($get->creditAmount)? 'Cashbook/deleteIncomingPost/' : 'Cashbook/deleteOutgoingPost/' ; echo $get->transId;?>" ><i class="fa fa-trash text-danger delItem pointer"></i></a>
                        </td>
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