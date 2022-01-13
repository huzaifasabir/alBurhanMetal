<?php defined('BASEPATH') OR exit('') ?>


<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Rent Report</div>
    <?php if($allTransactions): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th class="hidden-print">Trans Id</th>
                    <th >Transaction Date</th>
                    <th class="hidden-print">Category</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Link</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $cumTotal = 0;
                 ?>

                <?php foreach($allTransactions as $get): ?>
                <tr>
                    <input type="hidden" value="<?=$get->transId?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    
                        <td><a class="pointer vICr" title="Click to view receipt"><?= $get->transId ?></a></td>
                    
                    <td ><?= $get->transactionDate ?></td>
                    <td class="hidden-print"><?= $get->type ?></td>
                    <td class="hidden-print"><?= $get->referenceNo ?></td>
                    <td><?= isset($get->creditAmount)? number_format($get->creditAmount) : number_format($get->debitAmount) ?></td>
                    <td><?= $get->description ?></td>
                    <td><a href="<?= $get->hlink ?>" target="blank"><?= $get->hlink ?></a></td>

                    
        
                                
                </tr>
                <?php $sn++; isset($get->creditAmount)? $cumTotal+=$get->creditAmount : $cumTotal+=$get->debitAmount; 
                 ?>
                <?php endforeach; ?>
                <tr>
                    <th class="hidden-print"></th>
                    <td class="hidden-print"></td>
                    <td></td>
                    <td>Total</td>
                    <td><b>Rs<?= number_format($cumTotal) ?></b></td>
                    <td class="hidden-print"></td>
                    <td class="hidden-print"></td>

                </tr>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Transactions</li></ul>
    <?php endif; ?>
    
    
</div>
<!-- panel end-->