
<div class="pwell">  

<div class="container">

  <h2>Update Expense</h2>  
<form role="form" method="post" action="<?php echo site_url()?>edit-home-expense-post" enctype="multipart/form-data">

 <input type="hidden" value="<?php echo $expense[0]->id ?>"   name="expense_id">


      
    <div class="form-group">
    <label for="category">Category:</label>
    <input type="text" value="<?php echo $expense[0]->category ?>" class="form-control" id="category" name="category">
  </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</div>
<script src="<?=base_url()?>public/js/login.js"></script>