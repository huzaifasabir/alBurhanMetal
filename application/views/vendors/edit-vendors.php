
<div class="pwell hidden-print">  
<div class="container">

  <h2>Update Vendors</h2>  
<form role="form" method="post" action="<?php echo site_url()?>edit-vendors-post" enctype="multipart/form-data">

 <input type="hidden" value="<?php echo $vendors[0]->id ?>"   name="vendors_id">


      <div class="form-group">
    <label for="companyName">CompanyName:</label>
    <input type="text" value="<?php echo $vendors[0]->companyName ?>" class="form-control" id="companyName" name="companyName" required>
  </div>
    <div class="form-group">
    <label for="phone">Phone:</label>
    <input type="text" value="<?php echo $vendors[0]->phone ?>" class="form-control" id="phone" name="phone" required>
  </div>
    <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" value="<?php echo $vendors[0]->email ?>" class="form-control" id="email" name="email" required>
  </div>
    <div class="form-group">
    <label for="outstandingBalance">OutstandingBalance:</label>
    <input type="number" value="<?php echo $vendors[0]->outstandingBalance ?>" class="form-control" id="outstandingBalance" name="outstandingBalance" required>
  </div>
    <div class="form-group">
    <label for="salesRepresentative">SalesRepresentative:</label>
    <input type="text" value="<?php echo $vendors[0]->salesRepresentative ?>" class="form-control" id="salesRepresentative" name="salesRepresentative" required>
  </div>
    <div class="form-group">
    <label for="address">Address:</label>
    <input type="text" value="<?php echo $vendors[0]->address ?>" class="form-control" id="address" name="address" required>
  </div>
  <div class="form-group">
        <label for="accName">Page Number:</label>
        <input type="text" class="form-control" id="pageNo" value="<?php echo $vendors[0]->pageNo ?>" name="pageNo" >
  </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>

<script src="<?=base_url()?>public/js/login.js"></script>