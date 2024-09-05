<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: { 
            group:"required",      
            name:"required", 
        },
        messages: {
            name:"Please enter school  name", 
            group:"Please Select Group",
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post">
<div class="modal-body">
    
        
        <div class="row">
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Group:</label>
                    <select class="form-control" style="width:100%;" name="group" id="group" >
                    <option value="">Select Group</option>
                    <?php foreach ($group as $g) { ?>
                    <option value="<?php echo $g->id; ?>" <?php  if(@$value->group_id==$g->id){echo "selected";} ;?>>
                        <?php echo $g->name; ?>
                    </option>
                    <?php } ?>
                    </select>
                </div>                         
            </div>
            <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">School Name:</label>
                        <input type="text" class="form-control" value="<?=@$value->name;?>" placeholder="Enter school name" name="name">
                    </div>
            </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
</div>

</form>
            

