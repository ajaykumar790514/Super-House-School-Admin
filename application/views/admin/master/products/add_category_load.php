<div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Categories:</label>
                <div class="parent_cat_id" id="parent_cat_id" style="height: 250px;overflow: scroll;">
                    <?php 
                        foreach($parent_cat as $row){
                            //echo $row->name;
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
        <div class="col-6">
        <div class="form-group">
                <label class="control-label">Classes:</label>
                <div class="classes" id="class" style="height: 250px;overflow: scroll;">
                    <?php 
                        foreach($class_master as $row):
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="<?= $row->id; ?>" name="class[]" id="class<?= $row->id; ?>" required>
                        <label class="form-check-label" for="class<?= $row->id; ?>"><?=getOrdinal($row->name); ?></label>
                    </div>
                    <?php endforeach;?>
                </div>
        </div>
        </div>
    </div>