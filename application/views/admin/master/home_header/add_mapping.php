<div class="modal-header">
    <b>Add Header Items</b>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form class="needs-validation" action="" method="post">
        <div class="row">
                <div class="col-3">

            <div class="form-group">

            <label class="control-label">Groups:</label>

            <select class="form-control" style="width:100%;" name="group_id" id="group_id"onchange="fetch_parent_categories(this.value)">

            <option value="">Select</option>
                 <?php foreach ($group as $g) { ?>
                <option value="<?php echo $g->id; ?>">
                    <?php echo $g->name; ?>
                </option>
                <?php } ?>

            </select>

            </div>

        </div>
            <div class="col-3">
                <div class="form-group">
                <label class="control-label">Parent Categories:</label>
                <select class="form-control select2 parent_id" style="width:100%;" name="parent_id" onchange="fetch_category(this.value)">
                </select>
                </div>
                    </div>
                    <div class="col-3">
            <div class="form-group">
            <label class="control-label"> Sub Categories:</label>
            <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_sub_category(this.value)">
         
            </select>
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
            <label class="control-label"> Categories:</label>
            <select class="form-control sub_parent_cat_id" style="width:100%;" name="sub_parent_cat_id" id="sub_parent_cat_id" onchange="fetch_products(this.value)">
            </select>                                                     
                    
            </div>
    
        </div>
        <input type="hidden" value="<?php echo $headerid; ?>" id="headerid">
                    <!-- <div class="col-6">
                <div class="form-group">
                <label class="control-label">Categories:</label>
                <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_products(this.value)">
                </select>                                                     
                        
                </div>
                <input type="hidden" value="<?php echo $headerid; ?>" id="headerid">
        
            </div> -->
            <div class="col-12" id="available_products">
                
            </div>
        </div>
    </form>
    
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
</div>
      
<script type="text/javascript">
      function fetch_parent_categories(group_id)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_group_category'); ?>",
        method: "POST",
        data: {
            group:group_id
        },
        success: function(data){
            $(".parent_id").html(data);
        },
    });
   }
</script>                                                            