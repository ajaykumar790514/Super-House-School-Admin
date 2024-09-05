
                                                <?php $i=1; $n=0; foreach($pincodes_criteria as $value){
                                                    $ids[] = uniqid();
                                                    
                                                 ?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                                                        <label for="multiple_delete<?= $value->id; ?>"></label>
                                                    </td>
                                                    <th class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->pincode;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->shop_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?=$shop_details->currency;?> <?php echo $value->price;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->kilometer;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a  data-toggle="modal" href="#" data-target="#edit-pincode-criteria<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('master-data/delete_pincodes_criteria/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                        
                                                   
                                                    </td>
                                                </tr> 
                                                <div id="edit-pincode-criteria<?php echo $value->id; ?>" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Pincode Criteria</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form clas="<?=$ids[$n]?>" action="<?php echo base_url('master-data/edit_pincodes_criteria/'.$value->id); ?>" method="post" >

                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Business:</label>
                                                                                <select class="form-control select2" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
                                                                                <option value="">Select Business</option>
                                                                                <?php foreach ($business as $busi) { ?>
                                                                                <option value="<?php echo $busi->id; ?>" <?php if($busi->id == $value->business_id) {
                                                                                    echo "selected";
                                                                                } ?>>
                                                                                    <?php echo $busi->title; ?>
                                                                                </option>
                                                                                <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Shop:</label>
                                                                                <select class="form-control shop_id" style="width:100%;" name="shop_id" id="shop_id">
                                                                                    <option value="<?php echo $value->shop_id; ?>">
                                                                                    <?php echo $value->shop_name; ?>
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Pin Code:</label>
                                                                                <input type="number" class="form-control" value="<?php echo $value->pincode; ?>" name="pincode">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="control-label">Price</label>
                                                                                <input type="number" class="form-control" name="price" value="<?php echo $value->price; ?>" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Kilometer</label>
                                                                                <input type="number" class="form-control" name="kilometer" step="any" value="<?php echo $value->kilometer; ?>" >
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
                            
                                                <?php  $n++; } ?> 
                                                <div class="statusdata"></div>