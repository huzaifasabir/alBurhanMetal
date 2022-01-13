

<?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
<?php } ?>
<div class="row">


<div class='col-xs-12'>
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading hidden-print" style="text-transform: uppercase;"></div>
        
        <div class="table table-responsive">
            <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Category</th>
                        <th>Total Value</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0;  foreach($allTransactions as $get): ?>
                    <tr>
                        <th class="itemSN"><?=$sn?>.</th>
                        <td ><?= $get->subCategory ?></td>
                        <td ><?= number_format($get->totalValue,2) ?></td>
                    </tr>
                    <?php $total += $get->totalValue;  $sn++; ?>
                    <?php endforeach; ?>
                     <tr>
                        <td ></td>
                        <td ></td>
                        <td ><?= number_format($total,2) ?></td>
                     </tr>
                </tbody>
            </table>
        </div>
        <!-- table div end-->
        
    </div>
    <!--- panel end-->
</div>

<!---Pagination div-->
<div class="col-sm-12 text-center hidden-print">
    <ul class="pagination">
        <?= isset($links) ? $links : "" ?>
    </ul>
</div>
</div>
