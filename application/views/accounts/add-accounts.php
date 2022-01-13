

<div class="container">

  <h2>Add Accounts</h2>  
    <form role="form" method="post" action="<?php echo site_url()?>/add-accounts-post" >     
            <div class="form-group">
        <label for="accName">AccName:</label>
        <input type="text" class="form-control" id="accName" name="accName" required>
      </div>
      <div class="form-group">
        <label for="balance">Balance:</label>
        <input type="number" class="form-control" id="balance" name="balance" required>
      </div>
      <div class="form-group">
        <label for="type">Type:</label>
        <select id="type" name="type" class="form-control cashCategory" required>
                                    <option value="">Select Type</option>
                                    <option value="cash">Cash</option>
                                    <option value="payable">Payable</option>
                                    <option value="receivable">Receivable</option>
                                </select>
      </div>
      <div class="form-group">
        <label for="accName">Page Number:</label>
        <input type="text" class="form-control" id="pageNo" name="pageNo" >
      </div>
            
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

