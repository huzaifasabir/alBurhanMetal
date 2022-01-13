

<?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
<?php } ?>
<div class="row">
<div class='col-sm-6 hidden-print'>
    <?= isset($range) && !empty($range) ? $range : "hello"; ?>
</div>


<div class='col-xs-12'>
    <div class="panel panel-primary">
        <!-- Default panel contents -->
        <div class="panel-heading hidden-print" style="text-transform: uppercase;"><?= $flag ?></div>
        <?php if($allItems): ?>
        <div class="table table-responsive">
            <table class="table table-bordered table-striped" style="background-color: #f5f5f5">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th class="hidden-print">ITEM NAME</th>
                        <th class="hidden-print">ITEM CODE</th>
                        <?php if($flag === 'all'): ?>
                        <th>Category</th>
                        <?php endif; ?>
                        <th>DESCRIPTION</th>
                        <th>LOCATION</th>
                        <th>QTY IN STOCK</th>
                        <th class="hidden-print">SELLING PRICE</th>
                        <th id="costPriceHeader">COST PRICE</th>
                        <th>TOTAL SOLD</th>
                        <th id="totalValueHeader">TOTAL VALUE</th>
                        <th>Link</th>
                        
                        
                        <th class="hidden-print">EDIT</th>
                        <th class="hidden-print">DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allItems as $get): ?>
                    <tr>
                        <input type="hidden" value="<?=$get->code?>" class="curItemId">
                        <th class="itemSN"><?=$sn?>.</th>
                        <td class="hidden-print"><a href="<?php echo site_url()?>view-item/<?php echo $get->code?>" > <?php echo $get->name ?> </a></td>
                        <td class="hidden-print"><span id="itemCode-<?=$get->code?>"><?=$get->code?></td>
                        <?php if($flag === 'all'): ?>
                            <td><?=$get->subCategory?></td>
                        <?php endif; ?> 
                        <td>
                            <span id="itemDesc-<?=$get->code?>" data-toggle="tooltip" title="<?=$get->description?>" data-placement="auto">
                                <?=word_limiter($get->description, 15)?>
                            </span>
                        </td>
                        <td><span id="itemLocation-<?=$get->code?>"><?=$get->location?></span></td>
                        <td class="<?=$get->quantity <= 10 ? 'bg-danger' : ($get->quantity <= 25 ? 'bg-warning' : '')?>">
                            <span id="itemQuantity-<?=$get->code?>"><?=$get->quantity?></span>
                        </td>
                        <td class="hidden-print"><span id="itemPrice-<?=$get->code?>"><?=number_format($get->sellingPrice)?></span></td>
                        <td class="costPriceRow"><span id="costPrice-<?=$get->code?>"><?=number_format($get->costPrice,2)?></span></td>
                        <td><?=$this->genmod->gettablecol('transactions1', 'SUM(quantity)', 'itemCode', $get->code)?></td>
                        <td class="totalValueRow"><span id="totalValue-<?=$get->code?>"><?=number_format($get->totalValue)?></span></td>
                        <td><a href="<?= $get->hlink ?>" target="blank"><?= $get->hlink ?></a></td>
                        
                        <td class="hidden-print"><a href="<?php echo site_url()?>edit-products/<?php echo $get->code?>" >Edit</a></td>
                        <td class="text-center hidden-print"><i class="fa fa-trash text-danger delItem pointer"></i></td>

                    </tr>
                    <?php $sn++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- table div end-->
        <?php else: ?>
        <ul><li>No items</li></ul>
        <?php endif; ?>
    </div>
    <!--- panel end-->
</div>
<div class='col-sm-12'><center><b style="font-size: 20px; text-align: center">Items Total Worth/Price: Rs<?=$cum_total ? number_format($cum_total, 2) : '0.00'?></b></center></div>


<!---Pagination div-->
<div class="col-sm-12 text-center hidden-print">
    <ul class="pagination">
        <?= isset($links) ? $links : "" ?>
    </ul>
</div>
</div>
