<div class="container-fluid">
    <div class="row">
        <div class="table-responsive">
            <table style="width:100%" class="table table-fluid">
                <thead class="bg-light">
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qty = $total = 0;
                    foreach ($bundle as $b) :
                        $qty = $qty + $b->pro_qty;
                        $total = $total + $b->pro_price;
                    ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo displayPhoto($b->thumbnail); ?>" class="rounded-circle" alt="" style="width: 100px; height: 100px" />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1"><?= $b->name; ?></p>
                                        <p class="text-muted mb-0"><?= $b->product_code; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-muted mb-0"><?= $b->pro_qty; ?></p>
                            </td>
                            <td><b><?= $b->pro_price; ?></b></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td align="left">Total</td>
                        <td><b><?= $qty; ?></b></td>
                        <td><b><?= $total; ?></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
