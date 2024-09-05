<!DOCTYPE html>
<html>
<head>
	<title>Bill Invoice</title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/fav-icon.png'); ?>">
    <link href="<?= base_url('assets/vendor/fontawesome/css/all.min.css'); ?>" rel="stylesheet">
	<style type="text/css">
        @page {
		  size: A4 portrait;
		}
		@page {
		  size: A4 portrait;
		}

		@page :first {
			margin-top: 35pt;
		}
		@page :left {
			margin-right: 30pt;
		}
		@page :right {
			margin-left: 30pt;
		}
		@media print {
			footer {
				display: none;
				position: fixed;
				bottom: 0;
			}
			header {
				display: none;
				position: fixed;
				top: 0;
			}
            .fa-download{
                display: none;
            }
		}
		table, figure {
			page-break-inside: avoid;
		}
		
		* { 
			margin: 0;
			padding: 0;
		}
		body {
			width: 100%;
			display: block;
		}
		#page-wrap { 
			width: 800px;
			margin: 0 auto;
			page-break-before: always;
		}
		#header { 
			width: 100%;
			text-align: center;
			color: black;
			text-transform: uppercase;
			padding: 2px 0px;
/*			page-break-before: always;*/
		}
	
		#company-logo {
			margin: 10px;
			max-width: 140px;
			max-height: 140px;
			overflow: none;
/*			position: absolute;*/
		}
		#company-logo > img {
			width: 100%;
			height: 100%;
		}
		#logo-header {
/*			margin-left: 200px;*/
/*			position: absolute;*/
/*			max-width: 600px;*/
            margin-top: 2px;
		}
		.copy {
			text-align:left;
			resize: none;	
			padding: 2px;
            font-family:  Helvetica, Sans-Serif;
            font-size: 13px;

		}

		#customer {
			overflow: hidden;
            width:40%;
            text-align: left;
            float: left;
            margin-bottom: 1rem;
		}
        #customers {
			overflow: hidden;
            width:50%;
            text-align: left;
            float: right;
            margin-bottom: 1rem;
		}
		#customer-data {
			position: relative;
		}
        #customer-datas {
			position: relative;
		}
		#customer-ship-to { 
			font-size: 13px;
			font-weight: bold;
			float: left; 
		}
		.customer-details {
			padding-top: 3px;
			font-size: 14px;
			font-weight: lighter;
			float: left; 	
		}
		#meta { 
			margin-left: 500px;
			margin-top: 1px;
			width: 300px;
			float: right;
		}

		#meta td {
			text-align: right;
		}
		#meta td.meta-head {
			text-align: left;
			background: #eee;
		}
		#meta td p {
			width: 100%;
			height: 20px;text-align: right;
		}

		p { border: 0; font: 14px, Serif; overflow: hidden; resize: none; }
		table { border-collapse: collapse; }
		table td, table th { border: 1px solid black; padding: 5px; }

		#items p { width: 80px; height: 50px; }
		
		
		#items th.description p, #items td.item-name p { width: 100%;border: none; }
		#items td.total-line { border-right: 0; text-align: right; }
		
		#items td.total-value { border-left: 0; padding: 10px; }
		
		#items td.total-value p { height: 20px; background: none; }
		#items td.balance { background: #eee; }
		#items td.blank { border: 0; }

		#total-amount { margin: 20px 0 0 5px; font-family:  Arial, Helvetica, sans-serif}

		#shop-details{
            text-align : center;
        }
        #invoice {
			overflow: hidden;
			margin-top: 20px;
		}
        #customer-name{
            font-size: 16px; 
            margin-top: 0.5rem;
        }
        #customer-names{
            font-size: 16px; 
            margin-top: 0.5rem;
        }
        #customer-text{
            font-size: 16px;
            margin-top: 3px;    
        }
        #customer-texts{
            font-size: 16px;
            margin-top: 3px;    
        }
		hr{
            border: 1px solid black;
            margin-top:15px;
        }
        hr.three {
        border-top: 2px dashed #000;
        border-bottom: none;
        margin-top: -0.1rem;
        width: 115%;
        margin-left: -4rem;
      }
         	hr.bottom{
            border: 1px solid black;
            margin-top:-0.00001px;
        }
      
        #shop-contact{
            margin-top:5px
        }
        #authorised
        {
            margin: 11px;
            margin-top: 1rem;
            font-family:  Arial, Helvetica, sans-serif;
        }
         #head
         {
            margin-top: 2rem;
         }
        .row #logo
        {
            float: right;
        }
        .row #logo img
        {
            padding-top: 2rem;
        }
        .row #data
        {
            float:left;
            text-align: left;
            margin-top: 2rem;
        }
        .row #data h2
        {
            text-align: left;
            font-family:  Arial, Helvetica, sans-serif;
        }
        .row #data p
        {
            text-align: left;
            font-family:  Helvetica, Sans-Serif;
            line-height: 20px;
            color: #000;
        }
       #tax
         {
       font-size: 1.2rem;font-weight:bold;font-family: Arial, Helvetica, sans-serif;
         }
         .vl {
  border-left: 2px solid black;
  height: 150px;
  position: absolute;
  left: 46.6%;
  margin-left: -3px;
  top: 18.7rem;
}

 	</style>
</head>
<body onload="window.print()">
<!-- onload="window.print()" -->
	<div id="page-wrap">
		
		<div id="company-details">
            <div class="row" id="head">
               
                <div class="col-8" id="data">
                <div id="company-data">
                <h2 style="letter-spacing:1px;font-size: 1.5rem">Ship to:</h2>
                <p style="font-size:1.2rem"><?=$invoice[0]['booking_name'];?></p>
                <p style="font-size:1.2rem"><?=$invoice[0]['cust_house_no']. ' '.$invoice[0]['floor']. ' '.$invoice[0]['apartment_name']. ' '.$invoice[0]['address2']. ' '.$invoice[0]['address3'];?> </p>
                <p style="font-size:1.2rem"><?=$invoice[0]['cust_state'].',&nbsp;'.$invoice[0]['cust_city'].', &nbsp;'.$invoice[0]['cust_pincode'];?></p>
                <p style="font-size:1.2rem">Contact No.: <?php if($invoice[0]['booking_contact']==''){echo "N/A";}else{echo $invoice[0]['booking_contact'];}; ?></b></p>
                <p style="font-size:1.2rem">Alternate No.: <?php if($invoice[0]['cus_mobile']==''){echo "N/A";}else{echo $invoice[0]['cus_mobile'];}; ?></b></p>
                 </div>
                </div>
                <div class="col-4" id="logo">
                <div id="company-logo">
            	<img id="image" src="<?= IMGS_URL.$invoice[0]['logo']; ?>" alt="logo"/>
                 </div>
                </div>
            </div>
		</div>
        
         <p id="header" >  <hr class="three"> </p>
         <div id="logo-header">
            	<p class="copy">
                Order Id: <b><?=$invoice[0]['orderid']; ?></b>
            	</p>
            	<p class="copy">
                Thank you for buying from <b><?php echo $invoice[0]['shop_name'];?>.</b>
            	</p>
            </div>
            <?php 
             $date = $invoice[0]['added'];
             $day = date('D, F d, Y', strtotime($date));
             
            ?>
            <table width="95%" style="margin-left: 1rem;margin-top: 0.5rem;height:10px !important">
                <tr>
                    <td style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif">Order Date</td>
                    <th style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif"><?php echo  $day;?></th>
                    <td style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif">Shipping Service </td>
                    <th style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif"><?=$invoice[0]['courier_company'];?></th>
                </tr>
                <tr>
                    <td style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif">Buyer Name</td>
                    <th style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif"><?=$invoice[0]['booking_name'];?></th>
                    <td style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif">Tracking Number </td>
                    <th style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif"><?=$invoice[0]['courier_code'];?></th>
                </tr>
            </table>

            <table width="95%" style="margin-left: 1rem;margin-top:1rem">
                <tr>
                    <th style="border: 3px solid #000;text-align:center;width:7%;font-family:  Arial, Helvetica, sans-serif">S.No</td>
                    <th style="border: 3px solid #000;text-align:center;width:30%;font-family:  Arial, Helvetica, sans-serif">Product Details</th>
                    <th style="border: 3px solid #000;text-align:center;width:8%;font-family:  Arial, Helvetica, sans-serif">HSN </td>
                    <th style="border: 3px solid #000;text-align:center;width:8%;font-family:  Arial, Helvetica, sans-serif">Qty.</th>
                    <th style="border: 3px solid #000;text-align:center;width:10%;font-family:  Arial, Helvetica, sans-serif">RATE <br>[Rs.Ps.]</th>
                    <th style="border: 3px solid #000;text-align:center;width:10%;font-family:  Arial, Helvetica, sans-serif">Disc. <br>[% / Rs.]</th>
                    <th style="border: 3px solid #000;text-align:center;width:10%;font-family:  Arial, Helvetica, sans-serif">Amount <br>[Rs.Ps.]</th>
                </tr>
                <?php
          // discount
          
            $i=1;$taxableamount=0;
            foreach($invoice as $row):
                if($row['discount_type']==1)
                {
                  $amount = ($row['selling_rate']-$row['offer_applied']);
                  $discount = $row['selling_rate']-$amount;
                }elseif($row['discount_type']==0)
                {
                    $per = ($row['selling_rate']*$row['offer_applied'])/100;
                     $amount = $row['selling_rate']-$per; 
                    $discount = $row['offer_applied'];
                }
                // $diff =  $row['mrp']-$row['price_per_unit'];
                //  $discount = (100*$diff)/$row['mrp'];
			?>
                <tr>
                    <td style="border: 3px solid #000;text-align:center;font-family:  Arial, Helvetica, sans-serif"><?=$i?>.</td>
                    <td style="border: 3px solid #000;text-align:center;font-family:  Arial, Helvetica, sans-serif"><?= $row['product_name']; ?></td>
                    <td style="border: 3px solid #000;text-align:center;font-family:  Arial, Helvetica, sans-serif">N/A</td>
                    <td style="border: 3px solid #000;text-align:center;font-family:  Arial, Helvetica, sans-serif"><?=$row['item_qty'];?></td>
                    <td style="border: 3px solid #000;text-align:center;font-family:  Arial, Helvetica, sans-serif">₹<?= $row['selling_rate']; ?> </td>
                    <td style="border: 3px solid #000;text-align:center;font-family:  Arial, Helvetica, sans-serif"><?=round(($discount),2)?><?php if($row['discount_type']==1){echo " OFF";}elseif($row['discount_type']==0){echo "%";}?></td>
                    <td style="border: 3px solid #000;text-align:center;font-family:  Arial, Helvetica, sans-serif">₹<?php echo number_format((float)($amount*$row['item_qty']), 2, '.', ''); ?> </td>
                </tr>
                <?php
                $taxableamount = $taxableamount+$amount*$row['item_qty'];
            $i=$i+1;
            endforeach;
            
            ?>
        
                 <tr>
                    <td colspan="6"style="border: 3px solid #000;text-align:right;font-family:  Arial, Helvetica, sans-serif">
                    <p>Additional Charges (Shipping, COD, etc.)</p>
                    <p style="margin-top: 0.5rem;">Total Taxable Value</p>
                     </td>
                    <td colspan="2" style="border: 3px solid #000;text-align:right;font-family:  Arial, Helvetica, sans-serif">
                    <p>₹0.00</p>
                   
                    <p style="margin-top: 0.5rem;">₹<?php echo  number_format((float)($taxableamount), 2, '.', '') ?></p>
                  </td>
                </tr>
                
                 <tr>
                    <td colspan="9"style="border: 3px solid #000;text-align:left;font-family:  Arial, Helvetica, sans-serif">Note: This is not a Tax Invoice. You can download tax invoices from My Orders section of our mobile app.</td>
                </tr>
            </table>
            <p style="margin-top: 10px;font-family:  Arial, Helvetica, sans-serif">To provide feedback please visit please contact us. To contact us, go to contact section on our mobile app</p>
           <p style="font-size:1.2rem;margin-top: 1rem;font-family:  Arial, Helvetica, sans-serif">Return Address:</p>
           <h2 style="font-family:  Arial, Helvetica, sans-serif;font-size:1rem"><?=$invoice[0]['shop_name'];?></h2>
           <p style="font-size:1.2rem;font-family:  Arial, Helvetica, sans-serif"><?=$invoice[0]['address'];?> </p>
                <p style="font-size:1.2rem;font-family:  Arial, Helvetica, sans-serif"> <?=$invoice[0]['state_name'].',&nbsp;'.$invoice[0]['city_name'].', &nbsp;'.$invoice[0]['pin_code'];?>, India</p>


    

      
	</div>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</body>
</html>
