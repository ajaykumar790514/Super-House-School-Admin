<div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Categories:</label>
                <div class="parent_cat_id" id="parent_cat_id" style="height: 250px;overflow: scroll;">
                    <?php 
                        foreach($parent_cat as $row){
                            //echo $row->name;
                            $checked1 = '';
                            foreach($cat_pro_map as $row_cat_id){ 
                                if ($row_cat_id->cat_id == $row->id) {
                                    $checked1 = 'checked';
                                }
                            }
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="cat_id[]" id="defaultCheck<?= $row->id; ?>" <?=$checked1;?>>
                        <label class="form-check-label" for="defaultCheck<?= $row->id; ?>"><?= $row->name; ?></label>
                    </div>
                    <?php
                        foreach($categories as $row2){
                            if ($row->id == $row2->is_parent) {
                                //echo $row2->name;
                                $checked2 = '';
                                foreach($cat_pro_map as $row_cat_id){ 
                                    if ($row_cat_id->cat_id == $row2->id) {
                                        $checked2 = 'checked';
                                    }
                                }
                    ?>
                    <div class="form-check ml-4">
                        <input class="form-check-input" type="checkbox" value="<?= $row2->id; ?>" name="cat_id[]" onclick="select_parent_cat(this, <?= $row->id; ?>)" id="defaultCheck<?= $row2->id; ?>" <?=$checked2;?>>
                        <label class="form-check-label" for="defaultCheck<?= $row2->id; ?>"><?= $row2->name; ?></label>
                    </div>
                    <?php
                            
                            foreach($categories as $row3){
                                if ($row2->id == $row3->is_parent) {
                                    //echo $row3->name;
                                    $checked = '';
                                    foreach($cat_pro_map as $row_cat_id){ 
                                        if ($row_cat_id->cat_id == $row3->id) {
                                            $checked = 'checked';
                                        }
                                    }
                    ?>
                    <div class="form-check ml-5">
                        <input class="form-check-input" type="checkbox" value="<?= $row3->id; ?>" name="cat_id[]" onclick="select_parent_cat(this, <?= $row->id; ?>, <?= $row2->id; ?>)" id="defaultCheck<?= $row3->id; ?>" <?=$checked;?>>
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
        <div class="col-6">
        <div class="form-group">
                <label class="control-label">Classes:</label>
                <div class="classes" id="class" style="height: 250px;overflow: scroll;">
                    <?php 
                        foreach($class_master as $row):
                            $checked = '';
                            foreach($class_pro_map as $row_class){ 
                                if ($row_class->class == $row->id) {
                                    $checked = 'checked';
                                }
                            }
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="class[]" id="class<?= $row->id; ?>" <?=$checked;?> required>
                        <label class="form-check-label" for="class<?= $row->id; ?>"><?=getOrdinal($row->name); ?></label>
                    </div>
                    <?php endforeach;?>
                </div>
        </div>
        </div>
    </div>