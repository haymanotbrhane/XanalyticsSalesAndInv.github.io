<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php

$response = find_all_order_response();
$category = find_all_price_category();
$branchs = find_all_branch();
$product = find_all_product();
// $expiered_date = find_purchase_inventory_by_item_and_warehouse();
$items = find_all_inventory();
$k = 4;

include_once("header.php");
?>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>POS</h2>

        <div class="right-wrapper text-right">
            <ol class="breadcrumbs" style="margin-right: 50px;">
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>POS</span></li>
            </ol>

        </div>
    </header>

    <!-- start: page -->
    <div id="message">

    </div>

    <div class="row">

        <div class="col-md-7" style="padding-right: 0">

            <section class="card">
                <header class="card-header">

                    <h2 class="card-title">Search item and add to cart</h2>

                </header>
                <div class="card-body">
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label class="control-label text-lg-right pt-2">Price Group</label>

								<select name="category" id="category" data-plugin-selectTwo
										class="form-control populate" onchange="displayItem()"
										required>
									<option value="">Select Price Group</option>
									<?php
									while ($row = mysqli_fetch_assoc($category)) {
										?>
										<option
											value="<?php echo $row["id"] ?>"><?php echo $row["title"]; ?></option>
									<?php } ?>
								</select>
							</div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="col-form-label" for="formGroupExampleInput">Company/Person Name</label>
                                <input type="text" class="form-control" id="company" placeholder=""
                                       onchange="focusCode()">
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="col-form-label" for="formGroupExampleInput">Tin Number</label>
                                <input type="text" class="form-control" id="tin" placeholder=""
                                       onchange="focusCode()">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
								<label class="col-form-label" for="formGroupExampleInput">Branch</label>
                                <select name="branch" id="branch" data-plugin-selectTwo onchange="displayItem()"
                                        class="form-control populate" style="width: 100%" required>
                                    <?php
                                    echo "<option value=''>Select Branch</option>";
                                    while ($row = mysqli_fetch_assoc($branchs)) {
                                        ?>
                                        <option
                                            value='<?php echo $row["id"]; ?>'><?php echo $row["title"]; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-lg-4">
                          
                            <div class="form-group">
                                <label class="col-form-label" for="formGroupExampleInput">Item Code</label>
                               
                                <select name="code" id="code" data-plugin-selectTwo
                                    class="form-control populate" onchange="displayItem()" autofocus
                                    required>

                                    <option value="">Select Item</option>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($product)) {
                                        ?>
                                        <option
                                            value="<?php echo $row["code"] ?>"><?php echo $row["code"] . " /" . $row["title"]; ?></option>
                                    <?php } ?>
                                    
                                </select>
                            </div>

                        </div>
                        <div class="col-lg-4">
                          
                            <div class="form-group">
                                <label class="col-form-label" for="formGroupExampleInput">Expire Date</label>
                               
                                <select name="expiered_date" id="expiered_date" data-plugin-selectTwo
                                    class="form-control populate"  autofocus onchange="displayItem()"
                                    required>

                                    <option value="">Select Expire Date</option>
                                    <?php
                                    //   while ($row = mysqli_fetch_assoc($items)) {
                                        
                                       $expire_inv =find_purchase_inventory_ED();
                                    //_item($item);
                                       while ($row1 = mysqli_fetch_assoc($expire_inv)) {
                                        ?>
                                        <option
                                            value="<?php echo $row1["expiered_date"] ?>"><?php echo $row1["expiered_date"]; ?></option>
                                    <?php }?>
                                    
                                </select>
                            </div>

                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="col-form-label" for="formGroupExampleInput">Quantity</label>
                                <input type="text" class="form-control" id="qty" placeholder=""
                                       onchange="focusBtn()" required>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                          
                            <div class="form-group">
                                <label class="col-form-label" for="formGroupExampleInput">Vat Type</label>
                               
                                <select name="vat" id="vat" data-plugin-selectTwo
                                    class="form-control populate" onchange="focusBtn()" autofocus
                                    required>

                                    <option  value="0">With Vat</option>
                                    <option  value="1">Without Vat</option>
                                    
                                </select>
                            </div>

                        </div>
                        
                        <div class="col-lg-4">
                          
                            <div class="form-group">
                                <label class="col-form-label" for="formGroupExampleInput">Payment Type</label>
                               
                                <select name="payment" id="payment" data-plugin-selectTwo
                                    class="form-control populate" onchange="focusBtn()" autofocus
                                    required>
                                    <option value="Cash">Cash</option>
                                    <option value="Credit">Credit</option>
                                    <option value="Check">Check</option>
                                    
                                </select>
                            </div>

                        </div>
                    
                        <div class="col-lg-4">
                            <label class="col-form-label" for="formGroupExampleInput">Add Item</label>
                            <button class="btn btn-success" id="addtocart" onclick="addToCart()"
                                    style="display: block">Add To Cart
                            </button>
                        </div>
                    </div>

                </div>

            </section>


            <section class="card" style="margin-top: 1px">
                <div class="card-body" style="padding: 1.25rem 2px;">

                    <table class="table table-no-more table-bordered table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="text-left">Code</th>
                            <th class="text-left">Item</th>
                            <th class="text-left">Price</th>                    
                            <th class="text-left">Warehouse</th>
                            <th class="text-left">Latest Expire Date</th>
                            <th class="text-left">Quantity</th>
                            <th class="text-left">Total Stock</th>
                        </tr>
                        </thead>
                        <tbody id="viewitem">
                       

                      

                        </tbody>
                   
                    </table>
                    </div>
  
            </section>
        </div>

        <section class="card col-md-5" style="padding-left: 1px">
            <header class="card-header">

                <h2 class="card-title">Item in carts</h2>

            </header>
            <div class="card-body" style="padding: 1.25rem 0;">
                <div class="invoice" style="padding: 0 2px 5px;width: 100%" id="print">
                    <header class="clearfix">
                        <div class="row" style="width: 100%;margin-left: 0;margin-right: 0">
                            <div class="mt-2" style="width: 100%">
                                <address class="ib ml-2" style="color: #000000;text-align: center;width: 100%">
                                    <strong style="font-size: 18px;">Jub Trading PLC.</strong>
                                    <br/>
                                    
                                </address>
                            </div>
                        </div>
                    </header>
                    <table class="table"
                           style="font-size: 12px;color: #000000;table-layout: fixed;width: 100%">
                        <thead>
                            <tr class="text-dark">
                                <th id="cell-item" class="font-weight-semibold">Item</th>
                                <th id="cell-price" class="text-right font-weight-semibold">Price</th>
                                <th id="cell-qty" class="text-right font-weight-semibold">Quantity</th>
                                <th id="cell-total" class="text-right font-weight-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody id="orders">

                        </tbody>
                    </table>

                  
                <div class="text-right mr-4">
                    <button class="btn btn-danger ml-3" onclick="cancelOrder()">
                        <i class="fa fa-close"></i> Cancel
                    </button>

                    <button class="btn btn-success ml-3" onclick="createOrder()">
                        <i class="fa fa-check"></i> Approve
                    </button>

                    <button class="btn btn-info ml-3" onclick="printContetn('print')">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>

            </div>
        </section>

    </div>
    <!-- end: page -->
</section>
</div>

</section>

<!-- Vendor -->
<script src="vendor/jquery/jquery.js"></script>
<script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="vendor/jquery-cookie/jquery-cookie.js"></script>
<script src="master/style-switcher/style.switcher.js"></script>
<script src="vendor/popper/umd/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.js"></script>
<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="vendor/common/common.js"></script>
<script src="vendor/nanoscroller/nanoscroller.js"></script>
<script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="vendor/jquery-placeholder/jquery-placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="vendor/select2/js/select2.js"></script>
<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/media/js/dataTables.bootstrap4.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js"></script>
<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js"></script>
<script src="vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js"></script>
<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js"></script>
<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="js/theme.js"></script>

<!-- Theme Custom -->
<script src="js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="js/theme.init.js"></script>

<!-- Examples -->
<script src="js/examples/examples.datatables.default.js"></script>
<script src="js/examples/examples.datatables.row.with.details.js"></script>
<script src="js/examples/examples.datatables.tabletools.js"></script>
<script>
    $.ajax({
        type: "POST",
        url: "generated/pos.php",
        data: "cartView=" + "test",
        success: function (response) {
            $("#orders").html(response);
        }

    });

    $.ajax({
        type: "POST",
        url: "generated/pos.php",
        data: "totalPrice=" + "price",
        success: function (response) {
            $("#priceDev").html(response);
        }

    });

    function req(po) {
        document.cookie = "activation=" + po;
    }

    function printContetn(div) {

        $.ajax({
            type: "POST",
            url: "generated/pos.php",
            data: "createOrder=orders",
            success: function (response) {
                var print = document.getElementById(div).innerHTML;
                var orginal = document.body.innerHTML;

                document.body.innerHTML = print;

                window.print();

                document.body.innerHTML = orginal;

                window.location = "pos.php";
            }

        });

    }

    function displayItem() {

        var item = $('#code').val();
		var category = $('#category').val();
		var branch = $('#branch').val();
        var expiered_date = $('#expiered_date').val();
        if (item != "" && category != "" && branch != ""){
            $.ajax({
                type: "POST",
                url: "generated/pos.php",
                data: "itemChecking=" + item + "&category=" + category + "&branch=" + branch + "&expiered_date=" + expiered_date,
                success: function (response) {
                    $("#viewitem").html(response);
                    $('#qty').focus();
                }

            });
        }
    }
    function displayExpireDate() {

    var item = $('#code').val();
    var category = $('#category').val();
    var branch = $('#branch').val();
	var expiered_date = $('#expiered_date').val();
    if (item != "" && category != "" && branch != "" && expiered_date != ""){
    $.ajax({
        type: "POST",
        url: "generated/pos.php",
        data: "itemChecking=" + item + "&category=" + category + "&branch=" + branch+ "&expiered_date=" + expiered_date,
        success: function (response) {
            $("#viewdate").html(response);
            $('#qty').focus();
        }

    });
}
}

    function focusBtn() {

        var qty = $('#qty').val();

        if (qty != "") {
            $('#addtocart').focus();
        }
    }

    function focusComp() {

        $('#company').focus();

    }

    function focusCode() {

        $('#code').focus();

    }


    function addToCart() {

        var tin = $('#tin').val();
        var comp = $('#company').val();
        var item = $('#code').val();
        var qty = $('#qty').val();
		var category = $('#category').val();
		var branch = $('#branch').val();
		var vat = $('#vat').val();
		var payment = $('#payment').val();
        var expiered_date = $('#expiered_date').val();
        if (item != "" && qty != "" && category != "" && branch != "")   {
            $.ajax({
                type: "POST",
                url: "generated/pos.php",
                data: "itemAdded=" + item + "&qty=" + qty + "&tin=" + tin + "&company=" + comp + "&category=" + category + "&branch=" + branch + "&vat=" + vat + "&payment=" + payment + "&expiered_date=" + expiered_date,
                success: function (response) {
                    $('#code').val("");
                    $('#qty').val("");
                    $('#code').focus();
                    $("#orders").html(response);
                }

            });


        }
    }

    function createOrder() {
        var item = $('#code').val();
        var qty = $('#qty').val();
        var expiered_date = $('#expiered_date').val();
        var branch = $('#branch').val();
        $.ajax({
            type: "POST",
            url: "generated/pos.php",
            data: "createOrder=orders" + "&expiered_date=" + expiered_date + "&branch=" + branch  + "&qty=" + qty + "&item=" + item ,
            
            success: function (response) {
                window.location = "pos.php";
            }

        });

    }

    function cancelOrder() {

        $.ajax({
            type: "POST",
            url: "generated/pos.php",
            data: "cancelOrder=cancelOrders",
            success: function (response) {
                window.location = "pos.php";
            }

        });

    }

</script>
<script>
</script>
</body>

</html>