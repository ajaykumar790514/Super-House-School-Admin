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
            name:{
                required:true,
                remote:"<?=$remote?>null/name"
            }
        },
        messages: {
            name: {
                required : "Please enter subject name.",
                remote : "Subject already exists!"
            } 
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post">
<div class="modal-body">
    
        
        <div class="row">
            <div class="col-12">
                    <div class="form-group">
                        <label class="control-label">Subject Name:</label>
                        <input type="text" class="form-control" value="<?=@$value->name;?>" placeholder="Enter Subject name" name="name">
                    </div>
            </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
</div>

</form>
            

