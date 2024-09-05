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
            business_id:"required",
            shop_id:"required",                     
            name:"required", 
        },
        messages: {
            name:"Please enter group name", 
            shop_id:"Please Select Shop",
            business_id:"Please Select Business",
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post">
<div class="modal-body">
    
        
        <div class="row">
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Business:</label>
                    <select class="form-control" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
                    <option value="">Select Business</option>
                    <?php foreach ($business as $busi) { ?>
                    <option value="<?php echo $busi->id; ?>" <?php  if(@$value->business_id==$busi->id){echo "selected";} ;?>>
                        <?php echo $busi->title; ?>(<?php echo $busi->owner_name; ?>)
                    </option>
                    <?php } ?>
                    </select>
                </div>                         
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Shop:</label>
                    <select class="form-control shop_id" style="width:100%;" name="shop_id" id="shop_id">
                    <option value="<?php echo @$shops->id; ?>">
                        <?php echo @$shops->shop_name; ?>
                    </option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                    <div class="form-group">
                        <label class="control-label">Group Name:</label>
                        <input type="text" class="form-control" value="<?=@$value->name;?>" placeholder="Enter group name" name="name">
                    </div>
            </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
</div>

</form>
            

