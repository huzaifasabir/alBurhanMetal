<?php
defined('BASEPATH') OR exit('');
?>
<div class="container" id="accounts">
  <h2>Manage Accounts</h2>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($accountss)) {?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th><h3>SL No</h3></th>
        <th class="hidden-print"><h3>Id</h3></th>
        <th><h3>Page No</h3></th>
        <th><h3>Name</h3></th>
        <th><h3>Balance</h3></th>
        <th class="hidden-print">Type</th>
        <th class="hidden-print">Last Upadate</th>
        <th class="hidden-print">Date Created</th>
       <th class="hidden-print">Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($accountss as $accounts) { if($accounts->type === 'cash'){if ($this->session->admin_access === "all") {
      # code...
    ?>
      <tr>
        <td><h3> <?php echo $i; ?></h3> </td>
        <td class="hidden-print"> <h3><a href="<?php echo site_url()?>view-accounts/<?php echo $accounts->id?>" > <?php echo $accounts->id ?> </a> </h3></td>
        <td> <h3> <?php echo $accounts->pageNo ?> </h3></td> 
        <td> <h3> <?php echo $accounts->accName ?> </h3></td>        
        <td> <h3><?php echo number_format($accounts->balance) ?></h3></td>
        <td class="hidden-print"><?php echo $accounts->type ?></td>
        <td class="hidden-print"><?php echo $accounts->lastUpdate ?></td>
        <td class="hidden-print"><?php echo $accounts->dateCreated ?></td>

        <td class="hidden-print">
        <?php if($accounts->accName === 'factory' || $accounts->accName === 'Cash In Hand') {}else{?>
        <a href="<?php echo site_url()?>edit-accounts/<?php echo $accounts->id?>" >Edit</a>
        <a href="<?php echo site_url()?>delete-accounts/<?php echo $accounts->id?>" onclick="return confirm('are you sure to delete')">Delete</a>
        </td>
      <?php }?>
      </tr>
    <?php $i++; } }else{ ?>
      <tr>
        <td><h3> <?php echo $i; ?></h3> </td>
        <td class="hidden-print"> <h3><a href="<?php echo site_url()?>view-accounts/<?php echo $accounts->id?>" > <?php echo $accounts->id ?> </a> </h3></td>
        <td> <h3> <?php echo $accounts->pageNo ?> </h3></td> 
        <td> <h3> <?php echo $accounts->accName ?> </h3></td>        
        <td> <h3><?php echo number_format($accounts->balance) ?></h3></td>
        <td class="hidden-print"><?php echo $accounts->type ?></td>
        <td class="hidden-print"><?php echo $accounts->lastUpdate ?></td>
        <td class="hidden-print"><?php echo $accounts->dateCreated ?></td>

        <td class="hidden-print">
        <?php if($accounts->accName === 'factory' || $accounts->accName === 'Cash In Hand') {}else{?>
        <a href="<?php echo site_url()?>edit-accounts/<?php echo $accounts->id?>" >Edit</a>
        <a href="<?php echo site_url()?>delete-accounts/<?php echo $accounts->id?>" onclick="return confirm('are you sure to delete')">Delete</a>
        </td>
      <?php }?>
      </tr>
    <?php $i++; } }?>
    </tbody>
  </table>
  <?php } else {?>
  <div class="alert alert-info" role="alert">
                    <strong>No Accountss Found!</strong>
                </div>
  <?php } ?>
</div>

<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('accounts')">Print</button></div>
</div>  

<script src="<?=base_url()?>public/js/cashbook.js"></script>
<script src="<?=base_url('public/ext/datetimepicker/bootstrap-datepicker.min.js')?>"></script>
<script src="<?=base_url('public/ext/datetimepicker/jquery.timepicker.min.js')?>"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/datepair.min.js"></script>
<script src="<?=base_url()?>public/ext/datetimepicker/jquery.datepair.min.js"></script>

