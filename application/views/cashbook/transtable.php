<?php defined('BASEPATH') OR exit('') ?>


<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">SALE TRANSACTIONS</div>
    <?php if($allTransactions): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th class="hidden-print">Receipt No</th>
                    <th>Customer</th>
                    <th class="">Amount</th>
                    <th>Cash Received</th>
                    <th>Profit</th>
                </tr>
            </thead>
            <tbody>
                <?php $cumTotal = 0;
                        $amountTenderedTotal = 0;
                        $profitTotal = 0;
                        

                 ?>

                <?php foreach($allTransactions as $get): ?>
                <tr>
                    <?php $amount1 = $get->cumulativeAmount - $get->previousBalance;
                        $amount2 = $get->amountTendered - $get->changeDue;?>
                    <input type="hidden" value="<?=$get->ref?>" class="curTransId">
                    <th class="transSN"><?= $sn ?>.</th>
                    <td class="hidden-print"><a class="pointer vtr" title="Click to view receipt"><?= $get->ref ?></a></td>
                    <td><?= $get->cust_name ?></td>
                    <?php if($amount1 == $amount2): ?>
                        <td >Rs 0</td>
                    <?php else: ?>
                    <td >Rs<?= number_format($get->cumulativeAmount - $get->previousBalance)   ?></td>
                    <?php endif; ?>
                    <td class="">Rs<?= number_format($get->amountTendered - $get->changeDue) ?></td>
                    <td>Rs<?= number_format($get->totalProfit) ?></td>
                    <td class="hidden-print"><a href="<?php echo site_url()?>edit-transaction/<?php echo $get->ref?>" >Edit</a></td>
                    <td class="text-center hidden-print"><i class="fa fa-trash text-danger delItem pointer"></i></td>
                    
                </tr>
                <?php $sn++; if($amount1 == $amount2){}else{$cumTotal+= ($get->cumulativeAmount - $get->previousBalance);} $amountTenderedTotal+=($get->amountTendered - $get->changeDue); 
                $profitTotal+=$get->totalProfit; ?>
                <?php endforeach; ?>
                <tr>
                    <th></th>
                    <th class="hidden-print"></th>
                    <td>Total</td>
                    <td><b>Rs<?= number_format($cumTotal) ?></b></td>
                    <td class=""><b>Rs<?= number_format($amountTenderedTotal) ?></b></td>
                    <?php if ($this->session->admin_access === "all") { ?>
                    <td><b>Rs<?= number_format($profitTotal) ?></b></td>
                <?php } ?>
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