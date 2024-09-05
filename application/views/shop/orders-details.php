<!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Orders Details</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="orders">Orders</a></li>
                            <li class="breadcrumb-item active">#<?php echo $orderData[0]['id'];?></li>
                        </ol>
                    </div><!--
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                                    <h4 class="m-t-0 text-info">$58,356</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                                    <h4 class="m-t-0 text-primary">$48,356</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>
                        </div>
                    </div>-->
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">ORDER SUMMARY: <strong>#<?php echo $orderData[0]['id'];?></strong></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                                <td style="border-top: none !important; padding: .75rem; vertical-align: bottom; border-bottom: 1px solid #dee2e6;"><!--Order Added<br>-->Order Date</td>
                                                <td style="border-top: none !important; padding: .75rem; vertical-align: bottom; border-bottom: 1px solid #dee2e6;"><?php echo uk_date($orderData[0]['added']); ?><?php echo uk_time($orderData[0]['added']); ?> <br> <?php //echo $orderData[0]['datetime']; ?></td>
                                            </tr>    
                                            <tr>
                                                <th>Total items</th>
                                                <th><?php if($orderItems!==FALSE){echo count($orderItems);}else{echo '0';}?></th>
                                            </tr>
                                            <tr>
                                                <th>Total Before Tax</th>
                                                <th><?= $shop_currency; ?> <?php echo bcdiv(($orderData[0]['total_value'] - $orderData[0]['tax']), 1, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th>Tax</th>
                                                <th><?= $shop_currency; ?> <?php echo  bcdiv(($orderData[0]['tax']), 1, 2); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                              <tr>
                                                <th>Total Savings</th>
                                                <th><?= $shop_currency; ?> <?php echo  bcdiv(($orderData[0]['total_savings']), 1, 2); ?></th>
                                            </tr>
                                              <tr>
                                                <th>Delivery Charges</th>
                                                <th><?= $shop_currency; ?> <?php echo  bcdiv(($orderData[0]['delivery_charges']), 1, 2); ?></th>
                                            </tr>
                                            <tr>
                                                <th style="font-size: 1.3rem">Total</th>
                                                <th style="font-size: 1.3rem"><?= $shop_currency; ?> <?php echo bcdiv(($orderData[0]['total_value']+$orderData[0]['delivery_charges']), 1, 2);  ?></th>
                                            </tr>
                                          
                                           
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><strong>Order Details</strong></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th><?php echo $orderData[0]['customer_name'].' (<span class="text-primary">'.$orderData[0]['customer_email'].'</span>)'; ?></th>
                                            </tr>
                                             <tr>
                                                <th>Customer Number</th>
                                                <th><?php echo '<span class="text-primary">'.$orderData[0]['booking_contact'].'</span>'; ?></th>
                                            </tr>
                                            <tr>
                                                <th>Shop Name</th>
                                                <th><?php echo $orderData[0]['shop_name'].' (<span class="text-primary">'.$orderData[0]['shop_mobile'].'</span>)'; ?></th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th><?php 
                                                echo $orderData[0]['house_no'].', '.$orderData[0]['address_line_2'].', '.$orderData[0]['address_line_3'].', '.$orderData[0]['state'].', '.$orderData[0]['city'].', '.$orderData[0]['pincode'];

                                                    ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                <td>Payment Method</td>
                                                <td><?php echo $orderData[0]['payment_method']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Transaction Id</td>
                                                <td><?php echo $orderData[0]['payment_transaction_code']; ?></td>
                                            </tr>
                                             <tr>
                                                <td>IP Address</td>
                                                <td><?php echo $orderData[0]['ip']; ?></td>
                                            </tr>
                                           <!--  <tr>
                                                <td>Bank Name</td>
                                                <td><?php echo $orderData[0]['bank_name']; ?></td>
                                            </tr> -->
                                             <tr>
                                                <td>Remarks</td>
                                                <td><?php echo $orderData[0]['remark']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><strong>Order Status</strong></h4>
                                <div class="table-responsive">
                                <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>
                                                    <select class="select" id="order-status" style="width: 100%" data-placeholder="Choose">
                                              <?php  $rs=$this->order_status_master_model->getCurrentStatus($orderData[0]['id']);
                                                             
                                                $orderStatusNew=$this->order_status_master_model->getRowsNew($rs->order)?>
                                                        <?php foreach($orderStatusNew as $orstatus):?>
                                                        <option value="<?=$orstatus->id;?>" ><?=$orstatus->name;?></option>
                                                    <?php  endforeach;?>
                                                    <?php

                                                        // if(isset($orderStatus) && $orderStatus!==FALSE){
                                                        //     if($orderData[0]['status']==='4' || $orderData[0]['status']==='6' || $orderData[0]['status']==='1'){
                                                        //         if($orderData[0]['status']==='4'){
                                                        //             echo '<option value="4">Completed</option>';
                                                        //         }else if($orderData[0]['status']==='1') {
                                                        //             echo '<option value="1">Pending Payment</option>';
                                                        //         }else{
                                                        //             echo '<option value="6">Cancelled</option>';
                                                        //         }
                                                        //     }else{
                                                        //         echo '<option value="">Select Order Status</option>';
                                                        //         foreach($orderStatus as $status){
                                                        //             if($status['order'] >= $orderStatusData[0]['order']){
                                                        //                 echo '<option value="'.$status['id'].'" ';
                                                        //                 if($status['id']===$orderData[0]['status']){
                                                        //                     echo 'selected';
                                                        //                 }
                                                        //                 echo '>'.$status['name'].'</option>';
                                                        //             }
                                                        //         }
                                                        //     }
                                                        // }
                                                    ?>
                                                    </select>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"><button class="btn btn-danger float-right" id="status-update">Update Status</button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                                <td>Assign Delivery Man</td>
                                                <td>
                                                    <?php 
                                                    $disabled = "disabled";
                                                    if(in_array($orderData[0]['status'], ['17','2','3','20'])  ){
                                                        $disabled = "";
                                                    } ?>
                                                    <select id="delivery_boy" class="select" <?=$disabled?>>
                                                        <option value=""> -- Select --</option>
                                                        <?php 
                                                        foreach ($delivery_boys as $dbvalue) {

                                                            $dbselected ='';
                                                            if (@$orderAssign[0]['delivery_boy_id']==$dbvalue->id) {
                                                                $dbselected = 'selected';
                                                            }
                                                            echo "<option value='".$dbvalue->id."' $dbselected >";
                                                            echo $dbvalue->full_name.' ('.$dbvalue->contact_number.')';
                                                            echo "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><button class="btn btn-warning float-right assign-delivery" <?=$disabled?>  >Assign</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        // $('#order-status').change(function(e){
                        //     e.preventDefault();
                        //     if($('#order-status option:selected').val() === '2'){
                        //         Swal.fire({
                        //           title: 'Please enter the Invoice number for this order',
                        //           input: 'text',
                        //           inputAttributes: {
                        //             autocapitalize: 'off'
                        //           }, 
                        //           confirmButtonText: 'Update',
                        //           showLoaderOnConfirm: true,
                        //           preConfirm: (login) => {
                        //             return $.ajax({
                        //                     type:"POST",
                        //                     url: "orders/updateOrderBillNo",
                        //                     data: {id: "<?php echo $orderData[0]['id'];?>",bill_no:login},
                        //                 });
                        //           },
                        //           allowOutsideClick: () => !Swal.isLoading()
                        //         }).then((result) => {
                        //           if (result.isConfirmed) {
                        //             Swal.fire({
                        //               title: 'Invoice number updated',
                        //             })
                        //           }
                        //         })
                        //     }
                        // });
                        $('#status-update').click(function(e){
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        cancelButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: true
                                })

                                swalWithBootstrapButtons.fire({
                                    title: 'Are you sure to update the status to '+$('#order-status option:selected').text()+' ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, please!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        return $.ajax({
                                            type:"POST",
                                            url: "orders/updateOrderStatus",
                                            data: {item:{id: "<?php echo $orderData[0]['id'];?>",status:$('#order-status option:selected').val()}},
                                            'success': function (data) {

                                                swalWithBootstrapButtons.fire(
                                                    'Success!',
                                                    'Status has been updated.',
                                                    'success',
                                                ).then((result) => {
                                                    //$("#grid_table").jsGrid("loadData");
                                                    location.reload();
                                                })
                                            }
                                        });
                                    } else if (
                                        /* Read more about handling dismissals below */
                                        result.dismiss === Swal.DismissReason.cancel
                                    ) {
                                        swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'You\'ve cancelled the transaction',
                                        'error'
                                        )
                                    }
                                })
                            
                        });
                       $('.assign-delivery').click(function(e){
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        cancelButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: true
                                })

                                swalWithBootstrapButtons.fire({
                                    title: 'Are you sure to assign this order to '+$('#delivery_boy option:selected').text()+' ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, please!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        return $.ajax({
                                            type:"POST",
                                            url: "orders/updateDeliveryBoy",
                                            data: {item:{id: "<?php echo $orderData[0]['id'];?>",delivery_boy:$('#delivery_boy option:selected').val()}},
                                            'success': function (data) {
                                                console.log(data);
                                                swalWithBootstrapButtons.fire(
                                                    'Success!',
                                                    'Status has been updated.',
                                                    'success',
                                                ).then((result) => {
                                                    //$("#grid_table").jsGrid("loadData");
                                                    // location.reload();
                                                })
                                            }
                                        });
                                    } else if (
                                        /* Read more about handling dismissals below */
                                        result.dismiss === Swal.DismissReason.cancel
                                    ) {
                                        swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'You\'ve cancelled the transaction',
                                        'error'
                                        )
                                    }
                                })
                            
                        });
                    </script>
                    <div class="col-lg-8">
                        <div class="card">
                            <!-- .left-right-aside-column-->
                            <div class="card-body">
                                <h4 class="card-title">Order Items</h4>                        
                                <div class="contact-page-aside">
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list" data-paging="true" data-paging-size="7">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Product</br>/Bundle</th>
                                                    <th>Product Name</th>
                                                    <th>Rate</th>
                                                    <th>Qty</th>
                                                    <th>Amount</th>
                                                    <th>Tax</th>
                                                    <th>Offer Applied (if any)</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $total=0;
                                                    if($orderItems!==FALSE){
                                                        $count=1;
                                                        foreach($orderItems as $items){
                                                            $rs = $this->order_items_model->get_value($items['product_id']);
                                                           
                                                            echo '<tr>';
                                                            echo '<td>'.$count.'</td>';
                                                            echo '<td>';
                                                            if($items['ProductFlag']=='bundle')
                                                            {
                                                            echo '<button data-toggle="modal" data-target="#exampleModal'.$items['item_id'].'"  class="btn btn-primary">Bundle</button>';
                                                            }elseif($items['ProductFlag']=='product')
                                                            {
                                                                echo '<button class="btn btn-primary">Product</button>';
                                                            }
                                                            echo'</td>';
                                                            echo '<td>';
                                                            echo '<img src="' . displayPhoto($items['img']) . '" style="width:100px; max-height:100px;">&nbsp;&nbsp;<p style="word-wrap: break-word; max-width: 400px;">' . $items['product_name'] . '</p><strong>(' . str_pad($items['product_code'], 6, '0', STR_PAD_LEFT) . ')</strong>';
                                                            
                                                            if (isset($items['flavour'])) {
                                                                echo '<span class="text-danger" style="width:100%">' . $items['flavour'] . ',</span> ';
                                                            }
                                                            
                                                            if (isset($rs->value)) {
                                                                echo '<span class="text-danger" style="width:100%">' . $rs->value . '</span>';
                                                            }
                                                            
                                                            echo '</td>';
                                                            // echo '<td>'.$items['unit_value'].' '.$items['unit_type'].'</td>';
                                                            echo '<td>'.$shop_currency.' '.bcdiv(($items['price_per_unit']), 1, 2).'</td>';
                                                            echo '<td>'.$items['qty'].'</td>';
                                                            echo '<td>'.$shop_currency.' '.bcdiv(($items['total_price']), 1, 2).'</td>';
                                                            echo '<td>'.$items['tax_value'].'%</td>';
                                                            echo '<td>'?><?php  if($items['discount_type']==1){ echo $items['offer_applied'].'% OFF';}elseif($items['discount_type']==0){ echo $shop_currency.''.$items['offer_applied'].' FLAT OFF';}elseif($items['discount_type']==2){echo $items['offer_applied'];}else{echo $items['offer_applied']; };?><?php '</td>';
                                                           // echo '<td>'.$shop_currency.' '.$items['total_price'].'</td>';
                                                           

                                                             
                                                               echo '<td>'.$shop_currency.' '.bcdiv( $items['total_price'], 1, 2).'</td>';
                                                                echo '</tr>';
                                                            $count++;
                                                           ?>
                                                              <!-- Modal -->
                                                              <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?= $items['item_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?= $items['product_name'] ?> ( <?= $items['product_code'] ?> )</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <div class="rows">
                                                 <div id="load-details-single-<?= $items['item_id']; ?>"></div>
                                                  </div>
                                                  <script>
                                                  $(document).ready(function () {
                                                  setTimeout(() => {
                                                  $("#load-details-single-<?= $items['item_id']; ?>").load("<?= base_url() ?>orders/load_bundle_details/<?= $items['item_id']; ?>");
                                                  }, 100);
                                                  });
                                                  </script>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                                       <?php  }
                                                    }
                                                ?>
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                    <!-- .left-aside-column-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->