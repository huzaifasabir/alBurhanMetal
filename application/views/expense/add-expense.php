

<div class="pwell"> 

<div class="container">

  <h2>Add Expense</h2>  
    <form role="form" method="post" action="<?php echo site_url()?>/add-expense-post" >
              
            <div class="form-group">
        <label for="category">Category:</label>
        <input type="text" class="form-control" id="category" name="category">
      </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="<?=base_url()?>public/js/login.js"></script>

</div>
