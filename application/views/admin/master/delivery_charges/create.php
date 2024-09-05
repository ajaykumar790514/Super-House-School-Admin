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
           min:"required",
           max:"required",
           price:"required",
        },
        messages: {
            min:"Please enter min amount",
           max:"Please enter max amount",
           price:"Please enter price",
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post">
<div class="modal-body">
        <div class="row">
            <div class="col-4">
                    <div class="form-group">
                        <label class="control-label">Min Amount:</label>
                        <input type="number" class="form-control" value="<?=@$value->min;?>" placeholder="Enter  min amount" name="min">
                    </div>
            </div>
            <div class="col-4">
                    <div class="form-group">
                        <label class="control-label">Min Amount:</label>
                        <input type="number" class="form-control" value="<?=@$value->max;?>" placeholder="Enter max amount" name="max">
                    </div>
            </div>
            <div class="col-4">
                    <div class="form-group">
                        <label class="control-label">Price:</label>
                        <input type="number" class="form-control" value="<?=@$value->price;?>" placeholder="Enter  price" name="price">
                    </div>
            </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
</div>

</form>
            

