<style>
.more {display: none;}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            props_id: { required : true },
            value   : { required : true }
        },
        messages: {
            props_id: { required : "Please select property!" },
            value   : { required : "Please enter value!" }
        }
    }); 
});
</script>
<table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Property Name</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Property Value</th>
                                                     <th class="jsgrid-header-cell jsgrid-align-center">Property Type</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($property_val as $prop) {?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $prop->name;?></td>
                                                     <td class="jsgrid-cell jsgrid-align-center">
                                                    <?= $prop->is_selectable == '1' ? 'Display':''; ?>
                                                    <?= $prop->is_selectable == '2' ? 'Filter':''; ?>
                                                    <?= $prop->is_selectable == '3' ? 'Selectable':''; ?>
                                                   
                                                     </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <?php
                                                        if (empty($prop->value)) {
                                                            $query = $this->db->where('id', $prop->value_id)->get('product_props_value')->result();
                                                            echo $query[0]->value;
                                                            //$propvalue = $prop->value_id;
                                                        }else{
                                                            //$propvalue = $prop->value;
                                                        }
                                                    ?>
                                                    <?php $desc = strip_tags( $prop->value);
    $desc = substr($desc,0,15); ?>
   <span id="less<?php echo $prop->id;?>"><?php echo $desc; ?></span><span id="more<?php echo $prop->id;?>" class="more"><?php echo $prop->value;?></span>
   <?php if(strlen($prop->value) > 15){ ?>   
    <span id="dots<?php echo $prop->id;?>">...</span><button class="btn btn-primary btn-sm" onclick="myFunction(<?php echo $prop->id;?>)" id="myBtn<?php echo $prop->id;?>">Read more</button> 
    <?php } ?>
                                                    </td>
                                                    
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        
                                                        <input type="hidden" value="<?= $pid?>" id="pid">           
                <a href="javscript:void(0)" id="editbtn" onclick="edit_prop_val(<?= $prop->id; ?>,<?= $prop->propid; ?>,'<?= $prop->value; ?>','<?= $prop->value_id; ?>')"><i class="fa fa-edit"></i></a>
                <a href="javscript:void(0)" onclick="delete_prop_val(<?php echo $prop->id;?>)"><i class="fa fa-trash"></i></a>
                
               
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                 
                                                </table>
<form class="ajaxsubmit needs-validation" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label class="control-label">Properties:</label>
        <select class="form-control select2" style="width:100%;" name="props_id" id="propinput" onchange="filter_props()">
        <option value="">Select Property</option>
        <?php foreach ($properties as $prop) { ?>
        <option value="<?php echo $prop->id; ?>" data-type="<?php echo $prop->is_selectable; ?>">
            <?php echo $prop->name; ?> (   <?= $prop->is_selectable == '1' ? 'Display':''; ?>
                                                    <?= $prop->is_selectable == '2' ? 'Filter':''; ?>
                                                    <?= $prop->is_selectable == '3' ? 'Selectable':''; ?>)
        </option>
        <?php } ?>
        </select>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Property Value</label>
                <textarea name="value" class="form-control" cols="30" rows="5" id="valueinput"></textarea>

                <select class="form-control select2" name="prop_value" style="width:100%;display:none;">
                    
                </select>
            </div>
        </div>       
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" onclick="add_prop_value(<?= $pid;?>)" ><i id="loader" class=""></i>Add</button>
        <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" id="add" /> -->
        <input type="button" class="btn btn-danger waves-light" value="Update" id="update" hidden />
    </div>
</form>

<script>
    function delete_prop_val(propid){
        if(confirm('Do you want to delete?') == true)
        {
            $('#showModal .modal-body').load("<?php echo base_url('master-data/products/delete_prop_val/')?>"+propid+"/"+<?=$pid?> );
            toastr.success('Property Deleted Successfully..');
        }
    }
</script>
<script>
    function myFunction(id) {
        // alert(id);
    var dots = document.getElementById("dots"+id);
    var moreText = document.getElementById("more"+id);
    var lessText = document.getElementById("less"+id);
    var btnText = document.getElementById("myBtn"+id);

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Read more"; 
        moreText.style.display = "none";
        lessText.style.display = "inline";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Read less"; 
        moreText.style.display = "inline";
        lessText.style.display = "none";
    }
    }
</script>

<script>
    function filter_props() {
        var prop_id = $("#propinput").val();
        var type = $("#propinput").find('option:selected');
        type = $(type).data('type');
        if (type == 2 || type == 3) {
            $("select[name='prop_value']").show();
            $("#valueinput").hide();
            $.ajax({
                url: "<?php echo base_url('master-data/get_properties_value'); ?>",
                method: "POST",
                data: {
                    prop_id:prop_id,
                },
                success: function(data){
                    console.log(data);
                    $("select[name='prop_value']").html(data);
                },
            });
        }else{
            $("select[name='prop_value']").hide();
            $("#valueinput").show();
        }
    }
    
    function get_default(id,props_id,pid) {
        $.ajax({
            url: "<?php echo base_url('master-data/products/set-property-default'); ?>",
            method: "POST",
            data: {
                id:id,
                props_id:props_id,
                pid:pid              
            },
            success: function(data){
                console.log(data);
                var element = document.getElementById("loader");
                element.classList.remove("fa-spinner");
                $("#btnsubmit").prop('disabled', false);
                    toastr.success('Set Default Successfully..');
                    $("#showModal .modal-body").html(data);
                },
        });
    }
    function edit_prop_val(id,propid,propval,propval_id){
        if (propval_id > 0) {
            $("select[name='prop_value']").show();
            $("#valueinput").hide();
            $.ajax({
                url: "<?php echo base_url('master-data/get_properties_value'); ?>",
                method: "POST",
                data: {
                    prop_id:propid,
                    value_id:propval_id,
                },
                success: function(data){
                    console.log(data);
                    $("select[name='prop_value']").html(data);
                },
            });
        }
        $('#valueinput').val(propval);
        $('#propinput').val(propid);
        var pid = $('#pid').val();

        $('#btnsubmit').hide();
        $("#update").prop('hidden', false);
        $("#propinput").prop('disabled', true);
        $("#update").click(function(){
            var propvalue = $('#valueinput').val();
            var value_id = $("select[name='prop_value']").val();           
            var props_id = $('#propinput').val();

            var formData = new FormData();
                formData.append("id", id);
                formData.append("props_id", props_id);
                formData.append("propvalue", propvalue);
                formData.append("pid", pid);
                formData.append("value_id", value_id);
                //alert(formData);

            $.ajax({
                url: "<?php echo base_url('master-data/products/update_prop_value'); ?>",
                method: "POST",
                data : formData,
                contentType: false,
                processData: false,
                cache: false,                
                success: function(data){
                    toastr.success('Property Updated Successfully..');
                    $("#showModal .modal-body").html(data);
                },
            });
        });
    }
</script>
<script>
    function add_prop_value(pid){
        var value = $('#valueinput').val();
        var props_id = $('#propinput').val();
        var value_id = $("select[name='prop_value']").val();

        var formData = new FormData();
        formData.append("props_id", props_id);
        formData.append("value", value);
        formData.append("pid", pid);
        formData.append("value_id", value_id);

        $.ajax({
            url: "<?php echo base_url('master-data/products/add-property-value'); ?>",
            method: "POST",
            data : formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(data){
               if(data =='')
               {
                toastr.error('Property Already Added ..');
               }else
               {
                 var element = document.getElementById("loader");
                element.classList.remove("fa-spinner");
                $("#btnsubmit").prop('disabled', false);
                    toastr.success('Property Added Successfully..');
                    $("#showModal .modal-body").html(data);
               }
            },
        });
    }
</script>