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
              <td class="text-center"><img src="<?php echo displayPhoto($parent->icon); ?>" alt="image" height="100"></td>
              <td class="text-center"><?php echo $parent->name; ?></td>
              <?php foreach($headers_mapping as $mapping) 
              {
               // print_r($headers_mapping);
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
          <?php /*foreach($categories as $cat):
                if($cat->is_parent==$parent->id)
                 {?>
                   <tr> 
                <td class="text-center"><img src="<?php echo IMGS_URL.$cat->icon; ?>" alt="image" height="100"></td>
              <td class="text-center"><i class="fas fa-arrow-right ml-5">  <?php echo $cat->name; ?></td>
              <?php foreach($headers_mapping as $mapping) 
              {
                   if($mapping->value == $cat->id)
                   {
                           $flg=1;   
                   }
              }
              ?>
              <td class="btn btn-primary btn-sm" id="changeaction2<?= $cat->id ?>">
              <?php if($flg==1)
                  {?> 
                  <a href="javascript:void(0)" onclick="remove_map_category(<?= $cat->id ?>);" style="color:white;"> Remove </a>
              <?php } 
                  else { ?>
                  <a href="javascript:void(0)" onclick="map_category(<?= $cat->id ?>);" style="color:white;">Map</a>
                  <?php } ?>
              </td>
                  </tr>
                <?php }; endforeach; */?>
          <?php $flg=0; }?>
          </tbody>
             </table>
                                                                     
                </div>