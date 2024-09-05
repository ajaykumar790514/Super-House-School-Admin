
<form id="MyForm">
<div class="modal-body">
        <div class="row">
        <div class="col-4">
                <div class="form-group">
                    <label class="control-label">Parent Categories:</label>
                    <select class="form-control select2" style="width:100%;" id="parent_id" name="parent_id" onchange="fetch_category(this.value)">
                        <option value="">Select</option>
                        <?php foreach ($parent_cat as $parent) { ?>
                        <option value="<?php echo $parent->id; ?>">
                            <?php echo $parent->name; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="control-label">Sub Categories:</label>
                    <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_products(this.value)">
                    </select>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <label class="control-label">Categories:</label>
                    <select class="form-control cat_id" style="width:100%;" name="cat_id" id="cat_id" onchange="fetch_products_by_cat(this.value)">
                    </select>
                </div>
            </div>
            <div class="col-12">
             <div class="form-group">
             <label class="control-label">Return Days:</label>
             <input type="number" class="form-control" value="<?=@$value->days;?>" placeholder="Enter no of return days" id="days" name="days">
             </div>
            </div>
</div>
<div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="parentbtn" type="button" class="btn btn-danger waves-light"><i id="loader" class=""></i>Apply On Parent Categories</button>
        <button id="subbtn" type="button" class="btn btn-danger waves-light"><i id="loader" class=""></i>Apply On Sub Categories:</button>
        <button id="categorybtn" type="button" class="btn btn-danger waves-light"><i id="loader" class=""></i>Apply On Categories</button>
        <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
    </div>

</form>
            
<script>
 $(document).ready(function () {
    $('#parentbtn').on('click', function () {
    var parent_id = $("#parent_id").val();
    if (parent_id !== '') {
        var formData = $('#MyForm').serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>return-policy-master/parent_category_save',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.res === 'success') {
                    $('#showModal').modal('hide');
                    loadtb();
                    setTimeout(function() {
                    window.location.reload();
                }, 1000); 
                }
                alert(response.msg);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    } else {
        alert('Please select a parent category');
    }
});

$('#subbtn').on('click', function () {
    var parent_cat_id = $("#parent_cat_id").val();
    if (parent_cat_id !== '') {
        var formData = $('#MyForm').serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>return-policy-master/sub_category_save',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.res === 'success') {
                    $('#showModal').modal('hide');
                    loadtb();
                    setTimeout(function() {
                    window.location.reload();
                }, 1000); 
                }
                alert(response.msg);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    } else {
        alert('Please select a sub category');
    }
});

$('#categorybtn').on('click', function () {
    var cat_id = $("#cat_id").val();
    if (cat_id !== '') {
        var formData = $('#MyForm').serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>return-policy-master/category_save',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.res === 'success') {
                    $('#showModal').modal('hide');
                    loadtb();
                    setTimeout(function() {
                    window.location.reload();
                }, 1000); 
                }
                alert(response.msg);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    } else {
        alert('Please select a  category ');
    }
});

    });

</script>

