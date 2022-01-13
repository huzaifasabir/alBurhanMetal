
<div class="pwell">  
<div class="container" id='vendors'>
  
  <div class="row">
    <div class="col-lg-5">
  <h2>Manage Vendors</h2>
  </div>
  <div class="col-lg-7"><h3>Vendors Total Balance: <?=isset($vendorTotal) ? number_format($vendorTotal) : ""?></h3></div>
  </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($vendorss)) {?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>SL No</th>
        <th class="hidden-print">Id</th>
        <th>Page No</th>
        <th>Company Name</th>
        <th class="hidden-print">Sales Representative</th>
        <th class="hidden-print">Address</th>
        <th class="hidden-print">Phone</th>
        <th class="hidden-print">Email</th>
        <th>Outstanding Balance</th>
        <th class="hidden-print">Last Payment</th>
        <th class="hidden-print">Last Payment Date</th>
       <th class="hidden-print">Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($vendorss as $vendors) { ?>
      <tr>
        <?php if(number_format($vendors->outstandingBalance) == 0){ ?>
        <td class="hidden-print"><h3> <?php echo $i; ?> </h3></td>
        <?php }else{ ?>
        <td><h3> <?php echo $i; ?> </h3></td>  
        <?php } ?>

        <td class="hidden-print"><h3> <a  href="<?php echo site_url()?>view-vendors/<?php echo $vendors->id?>" > <?php echo $vendors->id ?> </a>  </h3></td>
        <td class="hidden-print"><h3><?php echo $vendors->pageNo?></h3></td>
        <?php if(number_format($vendors->outstandingBalance) == 0){ ?>
          <td class="hidden-print"><h3><?php echo $vendors->companyName ?></h3> </td>
        <?php }else{ ?>
        <td><h3><?php echo $vendors->companyName ?></h3> </td>
      <?php } ?>
        <td class="hidden-print"><?php echo $vendors->salesRepresentative?></td>
        <td class="hidden-print"><?php echo $vendors->address?></td>
        <td class="hidden-print"><?php echo $vendors->phone?></td>
        <td class="hidden-print"><?php echo $vendors->email?></td>
        <?php if(number_format($vendors->outstandingBalance) == 0){ ?>
        <td class="hidden-print"><h3><?php echo number_format($vendors->outstandingBalance)?></h3></td>
        <?php }else{ ?>
        <td ><h3><?php echo number_format($vendors->outstandingBalance)?></h3></td>
        <?php } ?>
        <td class="hidden-print"><?php echo number_format($vendors->lastPayment)?></td>
        <td class="hidden-print"><?php echo $vendors->lastPaymentDate?></td>
        <td class="hidden-print">
        <a href="<?php echo site_url()?>edit-vendors/<?php echo $vendors->id?>" >Edit</a>
        <a href="<?php echo site_url()?>delete-vendors/<?php echo $vendors->id?>" onclick="return confirm('are you sure to delete')">Delete</a>
        </td>

      </tr>
    <?php $i++; } ?>
    </tbody>
  </table>
  <?php } else {?>
  <div class="alert alert-info" role="alert">
                    <strong>No Vendorss Found!</strong>
                </div>
  <?php } ?>
</div>
<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('vendors')">Print</button></div>
</div> 
</div>

<script src="<?=base_url()?>public/js/login.js"></script>