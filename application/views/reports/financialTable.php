<?php defined('BASEPATH') OR exit('') ?>

<div id="financialReport">
<h3> Financial Statement</h3>
<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Assets</div>
    <?php if($totalCash): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                    <th class="transSN">1.</th>
                    <td>Total Cash</td>
                    <td>Rs<?= number_format($totalCash) ?></td>      
                </tr>
                <tr>
                    
                    <th class="transSN">2.</th>
                    <td>Total Inventory Value</td>
                    <td>Rs<?= number_format($totalInventory) ?></td>      
                </tr>
                <tr>
                    
                    <th class="transSN">3.</th>
                    <td>Total Accounts Receivable</td>
                    <td>Rs<?= number_format($totalAccountsReceivable) ?></td>      
                </tr>
                <tr>
                   
                    <th class="transSN">4.</th>
                    <td>Total Customer Receivable</td>
                    <td>Rs<?= number_format($totalCustomerBalance) ?></td>      
                </tr>
                <?php if($factoryFlag): ?>
                <tr>
                   
                    <th class="transSN">4.</th>
                    <td>Total Factory Receivable</td>
                    <td>Rs<?= number_format($factoryBalance) ?></td>      
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Values</li></ul>
    <?php endif; ?>
</div>

<br>
<br>
<hr>

<div class="panel panel-primary">
    <!-- Default panel contents -->
    <div class="panel-heading">Liabilities</div>
    <?php if($totalCash): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                    <th class="transSN">1.</th>
                    <td>Total Vendor Payable</td>
                    <td>Rs<?= number_format($totalVendorBalance) ?></td>      
                </tr>
                <tr>
                    
                    <th class="transSN">2.</th>
                    <td>Total Accounts Payable</td>
                    <td>Rs<?= number_format($totalAccountsPayable) ?></td>      
                </tr>
                
                <?php if($factoryFlag): ?>
                <?php else: ?>
                <tr>
                   
                    <th class="transSN">4.</th>
                    <td>Total Factory Payable</td>
                    <td>Rs<?= number_format($factoryBalance) ?></td>      
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Values</li></ul>
    <?php endif; ?>
</div>
<br>
    <br>
    <hr>

<div class="panel panel-primary">
    

    <div class="panel-heading">Accounts Receivable Details</div>
    <?php $sn=1; ?>
    <?php if($accountsReceivable): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                

                <?php foreach($accountsReceivable as $get): ?>
                
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><?= $get->accName ?></td>
                    <td>Rs <?= number_format($get->balance) ?></td>        
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Accounts Receivable</li></ul>
    <?php endif; ?>
    
    
</div>
<!-- panel end-->
<br>
    <br>
    <hr>
<div class="panel panel-primary">
    

    <div class="panel-heading">Customer Receivable Details</div>
    <?php $sn=1; ?>
    <?php if($customers): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                

                <?php foreach($customers as $get): ?>
                
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><?= $get->customerName ?></td>
                    <td>Rs <?= number_format($get->outstandingBalance) ?></td>        
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Customer Receivable</li></ul>
    <?php endif; ?>
    
    
</div>

<br>
    <br>
    <hr>
<div class="panel panel-primary">
    

    <div class="panel-heading">Vendor Payable Details</div>
    <?php $sn=1; ?>
    <?php if($vendors): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                

                <?php foreach($vendors as $get): ?>
                
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><?= $get->companyName ?></td>
                    <td>Rs <?= number_format($get->outstandingBalance) ?></td>        
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Vendor Payable</li></ul>
    <?php endif; ?>
    
    
</div>
<br>
    <br>
    <hr>
<div class="panel panel-primary">
    

    <div class="panel-heading">Accounts Payable Details</div>
    <?php $sn=1; ?>
    <?php if($accountsPayable): ?>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                

                <?php foreach($accountsPayable as $get): ?>
                
                <tr>
                    <th class="transSN"><?= $sn ?>.</th>
                    <td><?= $get->accName ?></td>
                    <td>Rs <?= number_format($get->balance) ?></td>        
                </tr>
                <?php $sn++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<!-- table div end-->
    <?php else: ?>
        <ul><li>No Accounts Payable</li></ul>
    <?php endif; ?>
    
    
</div>

</div>
<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('financialReport')">Print</button></div>
</div> 