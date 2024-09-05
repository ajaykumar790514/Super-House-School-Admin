                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-wrapper">
                <div class="container-fluid" style="max-width: 100% !important;">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data/'.$menu_id); ?>">Master</a></li>
                            <li class="breadcrumb-item active">Product Property</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h3 class="card-title" id="test">Product Property Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-product-property" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Property</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('master-data/add_product_property/'); ?>" method="post">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Property Name</label>
                                                                                <input type="text" class="form-control" name="name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <!-- <input type='checkbox' name='is_selectable' id="is_selectable">
                                                                                <label for="is_selectable">Selectable</label> -->

                                                                                <select name="is_selectable" class="form-control" required>
                                                                                    <option value="1">Display</option>
                                                                                    <option value="2">Filter</option>
                                                                                    <option value="3">Selectable</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <select name="display_type" class="form-control">
                                                                                    <option value="">Select Display Type</option>
                                                                                    <option value="1">Dropdown</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                       
                                                                    </div>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="CREATE">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-product-property">Add Property</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete Selected</button></th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Property Name</th>
                                                     <th class="jsgrid-header-cell jsgrid-align-center">Property Type</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($properties as $value){ ?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                                                        <label for="multiple_delete<?= $value->id; ?>"></label>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->name;?></td>
                                                     <td class="jsgrid-cell jsgrid-align-center">
                                                    <?= $value->is_selectable == '1' ? 'Display':''; ?>
                                                    <?= $value->is_selectable == '2' ? 'Filter':''; ?>
                                                    <?= $value->is_selectable == '3' ? 'Selectable':''; ?>
                                                   
                                                     </td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <a href="#" data-toggle="modal" data-target="#property-value<?php echo $value->id; ?>"><i class="fa fa-plus"></i></a>
                                                    <a  data-toggle="modal" href="#" data-target="#edit-product-property<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('master-data/delete_product_property/'.$value->id); ?>" onclick="return confirm('this property  could be mapped with products. Are you sure?')"><i class="fa fa-trash"></i></a>

                                                        <!-------- property value ---->
                                                         <div id="property-value<?php echo $value->id; ?>" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog  modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b>Property Value</b>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        
                                                                        <form action="" method="post" class="row">
                                                                            <div class="col-5">
                                                                                <label class="control-label">Name</label>
                                                                                 <div class="form-group">
                                                                                    <input type="text" name="name<?= $value->id; ?>" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                 <label class="control-label">Other Value</label>
                                                                                 <div class="form-group">
                                                                                    <input type="text" name="othervalue<?= $value->id; ?>" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-3 mt-4">
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-success waves-light" onclick="add_prop_value(<?= $value->id; ?>);" id="add_btn_prop_value<?= $value->id; ?>">Add</button>
                                                                                    <button type="button" class="btn btn-success waves-light" onclick="update_product_property_value(<?= $value->id; ?>);" id="update_btn_prop_value<?= $value->id; ?>" data-id="" style="display: none;">Update</button>
                                                                                </div>
                                                                            </div> 
                                                                        </form> 
                                                                        <div class="row">  
                                                                            <div class="col-12">
                                                                                <table class="jsgrid-table">
                                                                                    <tr class="jsgrid-header-row">
                                                                                        <th class="jsgrid-header-cell">Name</th>
                                                                                         <th class="jsgrid-header-cell">Other Value</th>
                                                                                         <th class="jsgrid-header-cell">Sequence</th>
                                                                                        <th class="jsgrid-header-cell">Action</th>
                                                                                    </tr>
                                                                                    <tbody id="data-property-value<?= $value->id; ?>">
                                                                                        <?php 
                                                                                            foreach($property_value as $row): 
                                                                                                if ($value->id == $row->prop_id):
                                                                                        ?>
                                                                                            <tr class="jsgrid-filter-row">
                                                                                                <th class="jsgrid-cell"><?= $row->value; ?></th>
                                                                                                 <th class="jsgrid-cell"><?= $row->other_value; ?></th>
                                                                                                <th><input type="number" value="<?=$row->seq?>" data="<?=$row->id?>,product_props_value,id,seq" class="change-indexing" min="0"></th>
                                                                                                <th class="jsgrid-cell">
                                                                                                    <a href="javscript:void(0)" onclick="edit_product_property_value(this, <?= $row->id; ?>, <?= $row->prop_id; ?>)"><i class="fa fa-edit"></i></a>
                                                                                                    <a href="javscript:void(0)" onclick="delete_product_property_value(<?= $row->id; ?>, <?= $row->prop_id; ?>)"><i class="fa fa-trash"></i></a>
                                                                                                </th>
                                                                                            </tr>
                                                                                        <?php endif; endforeach; ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>                                                                   
                                                                        </div>
                                                                                                                                       
                                                                    </div>                                                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                 
                                                        <!-------- property value end----> 

                                                    </td>
                                                </tr>

                                                <div id="edit-product-property<?php echo $value->id; ?>" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Product Property</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('master-data/edit_product_property/'.$value->id); ?>" method="post">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Property Name</label>
                                                                                <input type="text" name="name" class="form-control" value="<?php echo $value->name;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <!-- <input type='checkbox' name='is_selectable' id="is_selectable<?php echo $value->id;?>" <?php if($value->is_selectable == '1' ){echo "checked";} ?>>
                                                                                <label for="is_selectable<?php echo $value->id;?>">Selectable</label> -->

                                                                                <select name="is_selectable" id="is_selectable<?php echo $value->id;?>" class="form-control" required>
                                                                                    <option value="1" <?= $value->is_selectable == '1' ? 'selected' :''; ?>>Display</option>
                                                                                    <option value="2" <?= $value->is_selectable == '2' ? 'selected' :''; ?>>Filter</option>
                                                                                    <option value="3" <?= $value->is_selectable == '3' ? 'selected' :''; ?>>Selectable</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <select name="display_type" class="form-control">
                                                                                    <option value="">Select Display Type</option>
                                                                                    <option value="1" <?= $value->display_type == '1' ? 'selected' :''; ?>>Dropdown</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                       
                                                                    </div>
                                                               
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="UPDATE">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div> 

                                                

                                                 
                                                <?php } ?>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- Include Toastr CSS from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Include Toastr JS from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            name:{
                required:true,
                remote:"<?=$remote?>null"
            }
        },
        messages: {
            name: {
                required : "Please enter name!",
                remote : "Property already exists!"
            }
        }
    });
});
</script>
<script>
       var timer;
        $(document).on('input','.change-indexing',function (event) {
            clearInterval(timer);
            t = $(this);
            timer = setTimeout(function() {
                var data =  t.attr('data');
                var value = t.val();
                 $.post('<?=base_url()?>master-data/changeIndexing/',{data:data,value:value})
                 .done(function() {
                    toastr.success("Saved.");
                 })
                .fail(function() {
                    toastr.error("error");
                  })
            }, 1000);
        })
    function add_prop_value(prop_id){        
        var name = $('input[name="name'+prop_id+'"]').val();
        var othervalue = $('input[name="othervalue'+prop_id+'"]').val();
        // alert(name);
        $.ajax({
            url: "<?php echo base_url('master-data/add_product_property_value'); ?>",
            method: "POST",
            data: {
                prop_id:prop_id,
                name:name,
                othervalue:othervalue
            },
            success:function(data){
                $("#data-property-value"+prop_id).html(data);
            }
        });
    }
    function edit_product_property_value(btn,id,prop_id){
         $.ajax({
            url: "<?php echo base_url('master-data/get_product_property_value'); ?>",
            method: "POST",
            data: {
                prop_id:prop_id,
                id:id,
            },
            success:function(data){
                console.log(data);
                response = jQuery.parseJSON( data );
                if(response.res='success'){
                $('input[name="name'+prop_id+'"]').val(response.value);
                $('input[name="othervalue'+prop_id+'"]').val(response.other_value);
               }
            }
        });
        // $('input[name="name'+prop_id+'"]').val($(btn).parent().prev().text());
        // var name = $('input[name="name'+prop_id+'"]').val();
        //  $('input[name="othervalue'+prop_id+'"]').val($(btn).parent().prev().text());
        // var othervalue = $('input[name="othervalue'+prop_id+'"]').val();
        $("#add_btn_prop_value"+prop_id).hide();
        $("#update_btn_prop_value"+prop_id).show();
        $("#update_btn_prop_value"+prop_id).data('id', id);
    }
    function update_product_property_value(prop_id){
        var name = $('input[name="name'+prop_id+'"]').val();
        var othervalue = $('input[name="othervalue'+prop_id+'"]').val();
        var id = $("#update_btn_prop_value"+prop_id).data('id');
        // alert(id);
        $.ajax({
            url: "<?php echo base_url('master-data/update_product_property_value'); ?>",
            method: "POST",
            data: {
                id:id,
                prop_id:prop_id,
                name:name,
                othervalue:othervalue
            },
            success:function(data){
                $("#data-property-value"+prop_id).html(data);
                $("#add_btn_prop_value"+prop_id).show();
                $("#update_btn_prop_value"+prop_id).hide();
                $('input[name="name'+prop_id+'"]').val('');
                 $('input[name="othervalue'+prop_id+'"]').val('');
            }
        });
    }
    function delete_product_property_value(id,prop_id){
        $.ajax({
            url: "<?php echo base_url('master-data/delete_product_property_value'); ?>",
            method: "POST",
            data: {
                id:id,
                prop_id:prop_id,
            },
            success:function(data){
                console.log(data);
                $("#data-property-value"+prop_id).html(data);
            }
        });
    }
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('master-data/change_prod_prop_status'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
    });
    }
        //multiple delete
        $('.delete_checkbox').click(function(){
        if($(this).is(':checked'))
        {
        $(this).closest('tr').addClass('removeRow');
        }
        else
        {
        $(this).closest('tr').removeClass('removeRow');
        }
    });
   $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        var table = 'product_props_master';
            if(checkbox.length > 0)
            {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>master-data/multiple_delete",
                method:"POST",
                data:{checkbox_value:checkbox_value,table:table},
                success:function(data)
                {
                    $('.removeRow').fadeOut(1500);
                }
            })
            }
            else
            {
            alert('Select atleast one record');
            }
   })
</script>