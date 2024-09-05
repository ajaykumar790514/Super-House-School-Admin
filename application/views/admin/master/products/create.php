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

            parent_id:"required",

            parent_cat_id:"required",

           // unit_value:"required",

            //unit_type:"required",

            description:"required",                 

            //unit_type_id:"required",     

            tax_id:"required", 

            expiry_date:"required",   

            mfg_date:"required", 

            flag:"required", 

            group:"required",  

            mfg_date:"required",  

            product_code: {

                required:true,

                remote:"<?=$remote?>null/product_code"

            },

           name:{

               required:true,

               remote:"<?=$remote?>null/name"

           },
           name_portal:{

            required:true,

            remote:"<?=$remote?>null/name_portal"

            },

//           

        },

        messages: {

            //  name_portal:"Please enter product portal name",

            group:"Please select group",

            class:"Please select class",

            flag:"Please select product / bundel",

            product_code: {

                required : "Please enter product code!",

                remote : "Product code already exists!"

            },

            name: {

               required : "Please enter name !",

               remote : "Product Name already exists!"

           },
           name_portal: {

            required : "Please enter product portal name !",

            remote : "Product Portal Name already exists!"

            },

          

        }

    }); 

});

</script>



<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>

<div class="modal-body">        

    <div class="row">

    <!-- <div class="col-12">

                <div class="form-group">

                    <label class="control-label">Select Group:</label>

                    <select class="form-control groupload" name="group" id="group">

                    <option >--Select Group--</option>

                    <?php foreach($group_master as $group):?>

                    <option value="<?=$group->id;?>" ><?=$group->name;?></option>

                <?php endforeach;?>

                    </select>

                </div>

            </div>

            <div class="col-12 load-div"></div> -->

        <!-- <div class="col-4">

            <div class="form-group">

            <label class="control-label">Parent Categories:</label>

            <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_sub_categories(this.value)">

            <option value="">Select</option>

            <?php foreach ($parent_cat as $parent) { ?>

            <option value="<?php echo $parent->id; ?>">

                <?php echo $parent->name; ?>

            </option>

            <?php } ?>

            </select>

            </div>

        </div> -->



        <div class="col-3">

            <div class="form-group">

                <label class="control-label">APS Categories:</label>

                <div class="parent_cat_id" id="parent_cat_id" style="height: 250px;overflow: scroll;">

                    <?php 

                        foreach($parent_cat as $row){

                    ?>

                    <div class="form-check">

                        <input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="cat_id[]" id="defaultCheck<?= $row->id; ?>">

                        <label class="form-check-label" for="defaultCheck<?= $row->id; ?>"><?= $row->name; ?></label>

                    </div>

                    <?php

                        foreach($categories as $row2){

                            if ($row->id == $row2->is_parent) {

                                //echo $row2->name;

                                

                    ?>

                    <div class="form-check ml-4">

                        <input class="form-check-input" type="checkbox" value="<?= $row2->id; ?>" name="cat_id[]" onclick="select_parent_cat(this, <?= $row->id; ?>)" id="defaultCheck<?= $row2->id; ?>">

                        <label class="form-check-label" for="defaultCheck<?= $row2->id; ?>"><?= $row2->name; ?></label>

                    </div>

                    <?php

                            

                            foreach($categories as $row3){

                                if ($row2->id == $row3->is_parent) {

                                    //echo $row3->name;

                                    

                    ?>

                    <div class="form-check ml-5">

                        <input class="form-check-input" type="checkbox" value="<?= $row3->id; ?>" name="cat_id[]" onclick="select_parent_cat(this, <?= $row->id; ?>, <?= $row2->id; ?>)" id="defaultCheck<?= $row3->id; ?>" >

                        <label class="form-check-label" for="defaultCheck<?= $row3->id; ?>"><?= $row3->name; ?></label>

                    </div>

                    <?php

                                

                                }

                            }



                            }

                        }

                    }

                    ?>

                </div>

            </div>

        </div> 

        <div class="col-3">

            <div class="form-group">

                <label class="control-label">DPS Categories:</label>

                <div class="parent_cat_id" id="parent_cat_id" style="height: 250px;overflow: scroll;">

                    <?php 

                        foreach($parent_cat_dps as $row){

                            //echo $row->name;

                    ?>

                    <div class="form-check">

                        <input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="cat_id_dps[]" id="defaultCheck<?= $row->id; ?>">

                        <label class="form-check-label" for="defaultCheck<?= $row->id; ?>"><?= $row->name; ?></label>

                    </div>

                    <?php

                        foreach($categories_dps as $row2){

                            if ($row->id == $row2->is_parent) {

                                //echo $row2->name;

                                

                    ?>

                    <div class="form-check ml-4">

                        <input class="form-check-input" type="checkbox" value="<?= $row2->id; ?>" name="cat_id_dps[]" onclick="select_parent_cat(this, <?= $row->id; ?>)" id="defaultCheck<?= $row2->id; ?>">

                        <label class="form-check-label" for="defaultCheck<?= $row2->id; ?>"><?= $row2->name; ?></label>

                    </div>

                    <?php

                            

                            foreach($categories_dps as $row3){

                                if ($row2->id == $row3->is_parent) {

                                    //echo $row3->name;

                                    

                    ?>

                    <div class="form-check ml-5">

                        <input class="form-check-input" type="checkbox" value="<?= $row3->id; ?>" name="cat_id_dps[]" onclick="select_parent_cat(this, <?= $row->id; ?>, <?= $row2->id; ?>)" id="defaultCheck<?= $row3->id; ?>" >

                        <label class="form-check-label" for="defaultCheck<?= $row3->id; ?>"><?= $row3->name; ?></label>

                    </div>

                    <?php

                                

                                }

                            }



                            }

                        }

                    }

                    ?>

                </div>

            </div>

        </div> 
        <div class="col-3">

            <div class="form-group">

                <label class="control-label">AKids Categories:</label>

                <div class="parent_cat_id" id="parent_cat_id" style="height: 250px;overflow: scroll;">

                    <?php 

                        foreach($parent_cat_akids as $row){

                            //echo $row->name;

                    ?>

                    <div class="form-check">

                        <input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="cat_id_akids[]" id="defaultCheck<?= $row->id; ?>">

                        <label class="form-check-label" for="defaultCheck<?= $row->id; ?>"><?= $row->name; ?></label>

                    </div>

                    <?php

                        foreach($categories_akids as $row2){

                            if ($row->id == $row2->is_parent) {

                                //echo $row2->name;

                                

                    ?>

                    <div class="form-check ml-4">

                        <input class="form-check-input" type="checkbox" value="<?= $row2->id; ?>" name="cat_id_akids[]" onclick="select_parent_cat(this, <?= $row->id; ?>)" id="defaultCheck<?= $row2->id; ?>">

                        <label class="form-check-label" for="defaultCheck<?= $row2->id; ?>"><?= $row2->name; ?></label>

                    </div>

                    <?php

                            

                            foreach($categories_akids as $row3){

                                if ($row2->id == $row3->is_parent) {

                                    //echo $row3->name;

                                    

                    ?>

                    <div class="form-check ml-5">

                        <input class="form-check-input" type="checkbox" value="<?= $row3->id; ?>" name="cat_id_akids[]" onclick="select_parent_cat(this, <?= $row->id; ?>, <?= $row2->id; ?>)" id="defaultCheck<?= $row3->id; ?>" >

                        <label class="form-check-label" for="defaultCheck<?= $row3->id; ?>"><?= $row3->name; ?></label>

                    </div>

                    <?php

                                

                                }

                            }



                            }

                        }

                    }

                    ?>

                </div>

            </div>

            </div> 

        <div class="col-3">

        <div class="form-group">

                <label class="control-label">Classes:</label>

                <div class="classes" id="class" style="height: 250px;overflow: scroll;">

                    <?php 

                        foreach($class_master as $row):

                    ?>

                    <div class="form-check">

                        <input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="class[]" id="class<?= $row->id; ?>" required>

                        <label class="form-check-label" for="class<?= $row->id; ?>"><?=$row->name; ?></label>

                    </div>

                    <?php endforeach;?>

                </div>

        </div>

        </div>

    </div>

        <div class="row">

        <div class="col-12">

            <div class="form-group">

                <label class="control-label">Select Product / Bundle:</label>

                <select class="form-control" style="width:100%;" id="flag" name="flag" onchange="ckeckflag(this)" >

                         <option value="">--Select Product / Bundle --</option>  

                         <option value="product">Product</option>

                         <option value="bundle">Bundle</option>                                                 

                </select>               

            </div>

            

        </div>

            <div class="col-6">

                <div class="form-group">

                    <label class="control-label">Product Name:</label>

                    <input type="text" class="form-control" name="name">

                </div>

            </div>
            
            <div class="col-6">

                <div class="form-group">

                    <label class="control-label">Product Portal Name:</label>

                    <input type="text" class="form-control" name="name_portal">

                </div>

            </div>

            <div class="col-6">

                <div class="form-group">

                    <label class="control-label">Product Image:</label>

                    <input type="file" name="img[]" class="form-control"

size="55550" accept=".png, .jpg, .jpeg, .gif ,.webP, .svg" multiple="" required>

                </div>

            </div>



            <div class="col-6">

                <div class="form-group">

                    <label class="control-label">Search Keyword:</label>

                    <input type="text" class="form-control" name="search_keywords">

                </div>

            </div>

            <div class="col-6">

                <div class="form-group">

                    <label class="control-label">Product Code:</label>

                    <input type="text" class="form-control" name="product_code" >

                </div>

            </div>

            <div class="col-6" style="display:none">

                <div class="form-group">

                <label class="control-label">Brand Name:</label>

                    <select class="form-control select2" style="width:100%;" name="brand_id">

                    <option value="">Select Brand</option>

                    <?php foreach ($brands as $brand) { ?>

                    <option value="<?php echo $brand->id; ?>,<?php echo $brand->name; ?>">

                        <?php echo $brand->name; ?>

                    </option>

                    <?php } ?>

                    </select>

                </div>

            </div>



            <!-- <div class="col-6">

                <div class="form-group">

                <label class="control-label">Flavour Name:</label>

                    <select class="form-control select2" style="width:100%;" name="flavour_id">

                    <option value="">Select Flavour</option>

                    <?php foreach ($flavours as $flavour) { ?>

                    <option value="<?php echo $flavour->id; ?>,<?php echo $flavour->name; ?>">

                        <?php echo $flavour->name; ?>

                    </option>

                    <?php } ?>

                    </select>

                </div>

            </div> -->

        

        <!--    <div class="col-6">-->

        <!--        <div class="form-group">-->

        <!--            <label class="control-label">Product Quantity:</label>-->

        <!--            <input type="number" class="form-control" name="unit_value" value="1">-->

        <!--        </div>-->

        <!--    </div>-->

        <!--    <div class="col-6">-->

                

        <!--    <div class="form-group">-->

        <!--    <label class="control-label">Quantity Type:</label>-->

        <!--    <select class="form-control select2" style="width:100%;" name="unit_type_id">-->

        <!--    <option value="">Select Quantity Type</option>-->

        <!--    <?php foreach ($unit_type as $unit) { ?>-->

        <!--    <option value="<?php echo $unit->id; ?>,<?php echo $unit->name; ?>" <?php if($unit->name=='PIECE'){echo "selected";} ;?>>-->

        <!--        <?php echo $unit->name; ?>-->

        <!--    </option>-->

        <!--    <?php } ?>-->

        <!--    </select>-->

        <!--</div>-->

        <!--    </div>-->

           

            

           <div class="col-6">

             <div class="form-group">

                    <label class="control-label">Tax Slab:</label>

                    <select class="form-control select2" style="width:100%;" name="tax_id">

                   <option value="">Select Tax Slab</option>

                   <?php foreach ($tax_slabs as $value) { ?>

                    <option value="<?php echo $value->id; ?>,<?php echo $value->slab; ?>" <?php if($value->is_select=='0'){echo "selected";} ;?> >

                        <?php echo $value->slab; ?>

                    </option>

                    <?php } ?>

                    </select>

                </div>

            </div> 

            

            <div class="col-6">

                <div class="form-group">

                    <label class="control-label">Hsn/Sac Code:</label>

                    <input type="text" class="form-control" name="sku" >

                </div>

            </div>

            <div class="col-6">

             <div class="form-group">

                    <label class="control-label">Select Subject :</label>

                    <select class="form-control select2" style="width:100%;" name="subject">

                   <option value="">Select Subject</option>

                   <?php foreach ($subjects as $sub) { ?>

                    <option value="<?php echo $sub->id; ?>" >

                        <?php echo $sub->name; ?>

                    </option>

                    <?php } ?>

                    </select>

                </div>

            </div>

            <div class="col-6" style="display:none">

                <div class="form-group">

                    <label for="recipient-name" class="control-label">Application</label>

                    <input type="file" class="form-control" name="application">

                </div>

            </div>

            <!-- <div class="col-6">

                <div class="form-group">

                    <label class="control-label">Select Group:</label>

                    <select class="form-control group" name="group" id="group">

                    <option >--Select Group--</option>

                    <?php //foreach($group_master as $group):?>

                    <option value="<?//=$group->id;?>" ><?//=$group->name;?></option>

                <?php //endforeach;?>

                    </select>

                </div>

            </div>

            <div class="col-6">

                <div class="form-group">

                  <label class="control-label">Select Class:</label>

                    <select class="form-control class" name="class" id="class">

                        

                    </select>

                </div>

            </div> -->

        </div>

        

        <div class="row">

            <div class="col-12">

                <div class="form-group">

                    <label class="control-label">Description:</label>

                    <textarea id="editor" cols="92" rows="5" class="form-control" name="description"></textarea>

                </div>

            </div>

        </div>

 

        <div class="row">

    

            <div class="col-6 bundle">

                <div class="form-group">

                    <label for="recipient-name" class="control-label">Stock Quantity:</label>

                    <input type="number" class="form-control" name="s_qty" min="0" id="recipient-qty" required>

                </div>

            </div>

            

            <div class="col-6 bundle">

                <div class="form-group">

                    <label for="recipient-name" class="control-label">Purchase Rate:</label>

                    <input type="number" class="form-control" name="purchase_rate"  id="recipient-pr" required>

                </div>

            </div>

          

            <!-- <div class="col-6 bundle"> -->

           <!--  <div class="col-6">

                <div class="form-group">

                    <label for="recipient-name" class="control-label">Selling Rate:</label>

                    <input type="number" class="form-control" name="selling_rate" id="recipient-sr"  required>

                </div>

            </div>

            <div class="col-6 bundle">

            </div> -->

            <div class="col-6 bundle">

                <div class="form-group">

                    <label for="recipient-name" class="control-label">MRP:</label>

                    <input type="number" class="form-control" name="mrp" id="recipient-sr"  required>

                </div>

            </div>

     

        </div>

        <h3>SEO Friendly Meta</h3>

        <hr>

        <div class="row">

   

    <div class="col-6">

        <div class="form-group">

            <label for="recipient-name" class="control-label">Meta Title:</label>

            <input type="text" class="form-control" name="meta_title" >

        </div>

    </div>

    

    <div class="col-6">

        <div class="form-group">

            <label for="recipient-name" class="control-label">Meta Keywords:</label>

            <input type="text" class="form-control" name="meta_keywords"  >

        </div>

    </div>

  

    <div class="col-12">

        <div class="form-group">

            <label for="recipient-name" class="control-label">Meta Description:</label>

            <textarea class="form-control" name="meta_description"  ></textarea>

        </div>

    </div>

    <hr>

   

    <!-- <div class="col-12">

         <h4>Apply Offers</h4>

        <div class="form-group">

            <label for="recipient-name" class="control-label">Select Offer:</label>

            <select name="offer" id="" class="form-control">

                <option value="">--Select Offer--</option>

                <?php foreach($offers as $offer):?>

                 <option value="<?=$offer->id;?>"><?=$offer->title;?> ( <?php if($offer->discount_type==1){ echo $offer->value."%";}elseif($offer->discount_type==0){echo $offer->value."OFF";} ;?> )</option>

                <?php endforeach;?>    

            </select>

        </div>

    </div> -->



</div>

</div>

<div class="modal-footer">

    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>

    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->

</div>



</form>



<script src="<?=base_url()?>/public/assets/plugins/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

<script>

//     $('#group').change(function() {

//     var id = $(this).val();

//     $('#class').load('<?=base_url()?>master-data/getClass/'+id);

// })

$('.groupload').change(function() {

    var id = $(this).val();

    $('.load-div').load('<?=base_url()?>master-data/getCategoryClass/'+id);

})

  tinymce.init({

    selector: '#mytextarea'

  });



  function ckeckflag(flag)

  {

    var flags = $("#flag").val();

    if(flags=='bundle')

    {

        $('.bundle').hide();

    }else

    {

        $('.bundle').show(); 

    }

  }

CKEDITOR.replace( 'editor', {

toolbar: [

{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },

{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },

{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },

{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },

'/',

{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },

{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },

{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },

{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },

'/',

{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },

{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },

{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },

{ name: 'others', items: [ '-' ] },

]

});

</script>

            



