
<div class="pwell hidden-print">   
<div class="container">

  <h2>Update Customers</h2>  
<form role="form" method="post" action="<?php echo site_url()?>edit-customers-post" enctype="multipart/form-data">

 <input type="hidden" value="<?php echo $customers[0]->id ?>"   name="customers_id">


      
    <div class="form-group">
    <label for="customerName">CustomerName:</label>
    <input type="text" value="<?php echo $customers[0]->customerName ?>" class="form-control" id="customerName" name="customerName" required>
  </div>
    <div class="form-group">
    <label for="phone">Phone:</label>
    <input type="text" value="<?php echo $customers[0]->phone ?>" class="form-control" id="phone" name="phone">
  </div>
    <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" value="<?php echo $customers[0]->email ?>" class="form-control" id="email" name="email">
  </div>
    <div class="form-group">
    <label for="address">Address:</label>
    <input type="text" value="<?php echo $customers[0]->address ?>" class="form-control" id="address" name="address">
  </div>
    <div class="form-group">
    <label for="outstandingBalance">OutstandingBalance:</label>
    <input type="number" value="<?php echo $customers[0]->outstandingBalance ?>" class="form-control" id="outstandingBalance" name="outstandingBalance">
  </div>
    <div class="form-group">
    <label for="lastPayment">LastPayment:</label>
    <input type="number" value="<?php echo $customers[0]->lastPayment ?>" class="form-control" id="lastPayment" name="lastPayment">
  </div>
    <div class="form-group">
    <label for="lastPaymentDate">LastPaymentDate:</label>
    <input type="date" value="<?php echo $customers[0]->lastPaymentDate ?>" class="form-control" id="lastPaymentDate" name="lastPaymentDate">
  </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</div>
<script src="<?=base_url()?>public/js/login.js"></script>