
<div class="container">

  <h2>Update Accounts</h2>  
<form role="form" method="post" action="<?php echo site_url()?>edit-accounts-post" enctype="multipart/form-data">

 <input type="hidden" value="<?php echo $accounts[0]->id ?>"  class="form-control" name="accounts_id" id="accounts_id">
    
  <div class="form-group">
    <label for="accName">AccName:</label>
    <input type="text" value="<?php echo $accounts[0]->accName ?>" class="form-control" id="accName" name="accName" required>
  </div>
  <div class="form-group">
    <label for="balance">Balance:</label>
    <input type="number" value="<?php echo $accounts[0]->balance ?>" class="form-control" id="balance" name="balance" required>
  </div>
  <div class="form-group">
        <label for="type">Type:</label>
        <select id="type" name="type" class="form-control cashCategory" required>
                                    <option value="<?php echo $accounts[0]->type ?>"><?php echo $accounts[0]->type ?></option>
                                    <option value="">Select Type</option>
                                    <option value="cash">Cash</option>
                                    <option value="payable">Payable</option>
                                    <option value="receivable">Receivable</option>
                                </select>
  </div>
  <div class="form-group">
        <label for="accName">Page Number:</label>
        <input type="text" class="form-control" id="pageNo" value="<?php echo $accounts[0]->pageNo ?>" name="pageNo" >
  </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

