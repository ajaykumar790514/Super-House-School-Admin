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
            name:"required",
            contact_number: {
                required:true,
                minlength:10,
                maxlength:10,
                number: true,
                remote:"<?=$remote?>null/contact_number"
            },
            email: {
                email:true,
            },
            state:"required",
            city:"required",
            address:"required", 
        },
        messages: {
            contact_number: {
                remote : "Mobile No. Already Exists!!"
            }
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post">
<div class="modal-body">
        <div class="row">
            <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Name:</label>
                        <input type="text" class="form-control" name="name" value="<?= @$value->full_name;?>">
                    </div>
            </div>
            <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Email:</label>
                        <input type="email" class="form-control" name="email" value="<?= @$value->email_id;?>">
                    </div>
            </div>
            <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Mobile:</label>
                        <input type="number" class="form-control" name="contact_number" value="<?= @$value->contact_number;?>">
                    </div>
            </div>

            <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Photo:</label>
                        <input type="file" class="form-control" name="photo" accept="image/*">
                        <input type="hidden" class="form-control" name="old_photo" value="<?=@$value->photo?>">
                        <?php if($value->photo!='delivery_boy/default.jpg' && $value->photo!=NULL){ ?>
                            <img src="<?=IMGS_URL.$value->photo?>">
                        <?php } ?>
                    </div>
            </div>
            
            
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Address:</label>
                    <textarea cols="92" rows="5" class="form-control" name="address"><?= @$value->address;?></textarea>
                </div>
            </div>
        
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Save</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
</div>

</form>
            

