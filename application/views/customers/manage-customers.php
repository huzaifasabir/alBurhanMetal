<div class="pwell">   
<div class="container" id="customers">
  <div class="row">
    <div class="col-lg-5">
  <h2>Manage Customers</h2>
  </div>
  <div class="col-lg-7"><h3>Customers Total Balance: <?=isset($customerTotal) ? number_format($customerTotal) : ""?></h3></div>
  </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($customerss)) {?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>SL No</th>
        <th class="hidden-print"> Id </th>
        <th>Name</th>
        <th class="hidden-print">Phone</th>
        <th class="hidden-print">Email</th>
        <th class="hidden-print">Address</th>
        <th>Outstanding Balance</th>
        <th class="hidden-print">Last Payment</th>
        <th class="hidden-print">Last Payment Date</th>

      </tr>
    </thead>
    <tbody>
      
    <?php $i=1; foreach($customerss as $customers) { ?>
      <tr>
        <?php if(number_format($customers->outstandingBalance) == 0){ ?>
        <td class="hidden-print"><h3> <?php echo $i; ?> </h3></td>
        <?php }else{ ?>
        <td ><h3> <?php echo $i; ?> </h3></td>
      <?php } ?>
        <td class="hidden-print"><h3> <a href="<?php echo site_url()?>view-customers/<?php echo $customers->id?>" > <?php echo $customers->id ?> </a></h3></td>
        <?php if(number_format($customers->outstandingBalance) == 0){ ?>
        <td class="hidden-print"><h3> <?php echo $customers->customerName ?></h3></td>
        <?php }else{ ?>
        <td ><h3> <?php echo $customers->customerName ?></h3></td>
      <?php } ?>
        <td class="hidden-print"><?php echo $customers->phone ?></td>
        <td class="hidden-print"><?php echo $customers->email ?></td>
        <td class="hidden-print"><?php echo $customers->address ?></td>
        <?php if(number_format($customers->outstandingBalance) == 0){ ?>
        <td class="hidden-print"><h3>Rs <?php echo number_format($customers->outstandingBalance) ?></h3></td>
        <?php }else{ ?>
        <td ><h3>Rs <?php echo number_format($customers->outstandingBalance) ?></h3></td>
        <?php } ?>
        <td class="hidden-print">Rs <?php echo number_format($customers->lastPayment) ?></td>
        <td class="hidden-print"><?php echo $customers->lastPaymentDate ?></td>
        <td class="hidden-print">
        <a href="<?php echo site_url()?>edit-customers/<?php echo $customers->id?>" >Edit</a>
        <a href="<?php echo site_url()?>delete-customers/<?php echo $customers->id?>" onclick="return confirm('are you sure to delete')">Delete</a>
        </td>

      </tr>
    <?php $i++; } ?>

    </tbody>
  </table>
  <?php } else {?>
  <div class="alert alert-info" role="alert">
                    <strong>No Customerss Found!</strong>
                </div>
  <?php } ?>
</div>
<div class="row">
                    <div class="col-sm-2">
                    <button class="btn btn-primary btn-sm" id="print" onclick="printDiv('customers')">Print</button></div>
    </div> 
</div>

<script src="<?=base_url()?>public/js/login.js"></script>