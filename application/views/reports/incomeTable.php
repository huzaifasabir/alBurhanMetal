<?php defined('BASEPATH') OR exit('') ?>

<div id="incomeReport">
<div class="panel panel-primary">
    
    <!-- Default panel contents -->
    <div class="panel-heading">Wastage Report</div>
    <?php if($totalRevenue): ?>

        <b>Total No. Of Batches:
        <?= number_format($totalRevenue) ?></b>
    <div class="table table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Production Stage</th>
                    <th>Total Sheets</th>
                    <th>Crowns</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                    <th class="transSN">1.</th>
                    <td>Total No. Of Sheets Processed</td>
                    <td><?= number_format($totalRevenue) ?></td>
                    <td></td>      
                </tr>
                <tr>
                    
                    <th class="transSN">2.</th>
                    <td>Print Rejected </td>
                    <td>2</td>
                    <td>540</td>      
                </tr>
                <tr>
                    
                    <th class="transSN">3.</th>
                    <td>Press Rejected </td>
                    <td>2</td>
                    <td>540</td>     
                </tr>
                <tr>
                   
                    <th class="transSN">4.</th>
                    <td>PMC Rejected </td>
                    <td>2</td>
                    <td>540</td>      
                </tr>
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


</div>
<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('incomeReport')">Print</button></div>
</div> 
<!-- panel end-->