
<div class="modal-header">
          <b>Add Header Items</b>
          <span class="text-danger"></span>
           <span class="text-success"></span>
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="row pl-4 pr-4">
                        <div class="col-4">

            <div class="form-group">

            <label class="control-label">Groups:</label>

            <select class="form-control" style="width:100%;" name="group_id" id="group_id"onchange="fetch_parent_categories(this.value)">

            <option value="">Select</option>
                 <?php foreach ($group as $g) { ?>
                <option value="<?php echo $g->id; ?>">
                    <?php echo $g->name; ?>
                </option>
                <?php } ?>

            </select>

            </div>

        </div>
        <div class="col-4">
            <div class="form-group">
            <label class="control-label">Parent Categories:</label>
            <select class="form-control parent_id" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_sub_categories(this.value)">
            </select>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
            <label class="control-label">Sub Categories:</label>
            <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_results(this.value)">
            <?php if(!empty($cat_id)) { ?>
            <?php foreach ($sub_cat as $scat) { ?>
            <option value="<?php echo $scat->id; ?>" <?php if(!empty($cat_id)) { if($cat_id==$scat->id) {echo "selected"; } }?>>
                <?php echo $scat->name; ?>
            </option>
            <?php } ?>
            <?php }?>                                            
            </select>
           
            </div>
        </div>
    </div> 
   <input type="hidden" value="<?php echo $headerid; ?>" id="headerid">
            <div class="available_category">
            <div class="modal-body">
      
                                                                
      <table class="table" style="border:1px solid black">
      <thead class="thead-light">
          <tr style="border:1px solid black">
              <th class="text-center">Image</th>
              <th class="text-center">Category Name</th>
              <th class="text-center">Action</th>
          </tr>
          </thead>
          <tbody>
              <?php
              $flg=0;
              foreach($parent_cat as $parent) {?>
          <tr>
              <td class="text-center"><img src="<?php echo displayPhoto($parent->icon) ?>" alt="image" height="100"></td>
              <td class="text-center"><?php echo $parent->name; ?></td>
              <?php foreach($headers_mapping as $mapping) 
              {
                   if($mapping->value == $parent->id)
                   {
                           $flg=1;   
                   }
              }
              ?>
              <td class="btn btn-primary btn-sm" id="changeaction2<?= $parent->id ?>">
              <?php if($flg==1)
                  {?> 
                  <a href="javascript:void(0)" onclick="remove_map_category(<?= $parent->id ?>);" style="color:white;"> Remove </a>
              <?php } 
                  else { ?>
                  <a href="javascript:void(0)" onclick="map_category(<?= $parent->id ?>);" style="color:white;">Map</a>
                  <?php } ?>
              </td>
             
          </tr>
          <?php $flg=0; }?>
          </tbody>
             </table>
                                                                     
                </div>
            </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
           </div>      
<script type="text/javascript">
      function fetch_parent_categories(group_id)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_group_category'); ?>",
        method: "POST",
        data: {
            group:group_id
        },
        success: function(data){
            $(".parent_id").html(data);
        },
    });
   }
</script>   