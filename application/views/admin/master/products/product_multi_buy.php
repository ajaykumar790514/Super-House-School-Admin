<style>
.more {display: none;}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            qty: { required : true },
            price: { required : true }
        },
        messages: {
            qty: { required : "Please select quantity!" },
            price: { required : "Please enter price!" }
        }
    }); 
});
</script>
<table class="jsgrid-table">
    <tr class="jsgrid-header-row">
        <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
        <th class="jsgrid-header-cell jsgrid-align-center">Quantity</th>
        <th class="jsgrid-header-cell jsgrid-align-center">Price</th>
        <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
    </tr>
    <?php $i=1; foreach($multi_buys as $row) {?>
        <tr class="jsgrid-filter-row">
            <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></td>
            <td class="jsgrid-cell jsgrid-align-center"><?php echo $row->qty;?></td>
            <td class="jsgrid-cell jsgrid-align-center"><?php echo $row->price;?></td>
            
            <td class="jsgrid-cell jsgrid-align-center">                
                <input type="hidden" value="<?= $pid?>" id="pid">           
                <a href="javscript:void(0)" id="editbtn" onclick="edit_multi_buy(<?= $row->id; ?>,<?= $row->qty; ?>,'<?= $row->price; ?>',<?= $pid;?>)"><i class="fa fa-edit"></i></a>
                <a href="javscript:void(0)" onclick="delete_multi_buy(<?=$row->id;?>)"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
    <?php }?>
 
</table>
<form class="ajaxsubmit needs-validation" method="post" enctype="multipart/form-data">
    
    <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label">Quantity:</label>
            <input type="number" name="qty" class="form-control">
        </div>

        <div class="form-group col-md-6">
            <label class="control-label">Price:</label>
            <input type="number" name="price" class="form-control" step="0.01">
        </div>
              
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" onclick="add_multi_buy(<?= $pid;?>)" ><i id="loader" class=""></i>Add</button>
        <input type="button" class="btn btn-danger waves-light" value="Update" id="update" hidden />
    </div>
</form>

<script>
    function delete_multi_buy(id){
        if(confirm('Do you want to delete?') == true)
        {
            $('#showModal .modal-body').load("<?php echo base_url('master-data/products/delete_multi_buy/')?>"+id+"/"+<?=$pid?> );
            toastr.success('Multi Buy Deal Deleted Successfully..');
        }
    }
    
    function edit_multi_buy(id,qty,price,pid){
        
        $('[name=qty]').val(qty);
        $('[name=price]').val(price);

        $('#btnsubmit').hide();
        $("#update").prop('hidden', false);
        $("#update").click(function(){
            var qty = $('[name=qty]').val();
            var price = $('[name=price]').val();

            var formData = new FormData();
                formData.append("id", id);
                formData.append("qty", qty);
                formData.append("price", price);
                formData.append("pid", pid);

            $.ajax({
                url: "<?php echo base_url('master-data/products/update_multi_buy'); ?>",
                method: "POST",
                data : formData,
                contentType: false,
                processData: false,
                cache: false,                
                success: function(data){
                    toastr.success('Multi Buy Deal Updated Successfully..');
                    $("#showModal .modal-body").html(data);
                },
            });
        });
    }
</script>
<script>
    function add_multi_buy(pid){
        var qty = $('[name=qty]').val();
        var price = $('[name=price]').val();

        var formData = new FormData();
        formData.append("qty", qty);
        formData.append("price", price);
        formData.append("pid", pid);

        $.ajax({
            url: "<?php echo base_url('master-data/products/add-multi-buy'); ?>",
            method: "POST",
            data : formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(data){
                var element = document.getElementById("loader");
                element.classList.remove("fa-spinner");
                $("#btnsubmit").prop('disabled', false);
                    toastr.success('Multi Buy Deal Added Successfully..');
                    $("#showModal .modal-body").html(data);
                },
        });
    }
</script>