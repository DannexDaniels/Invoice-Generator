<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Marc Invoices</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="sidebar-brand-text mx-3">MARC</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - List Invoices -->
        <li class="nav-item">
            <a class="nav-link" href="invoices.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Invoices</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Settings
        </div>

        <!-- Nav Item - Set VAT -->
        <li class="nav-item">
            <a class="nav-link" href="vat.php">
                <i class="fas fa-fw fa-percentage"></i>
                <span>Set VAT</span></a>
        </li>

        <!-- Nav Item - Update Invoices -->
        <li class="nav-item active">
            <a class="nav-link" href="update_invoice.php">
                <i class="fas fa-fw fa-edit"></i>
                <span>Update Invoice</span></a>
        </li>

        <!-- Nav Item - add Invoices -->
        <li class="nav-item">
            <a class="nav-link" href="../index.php">
                <i class="fas fa-fw fa-save"></i>
                <span>Add Invoice</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


            </nav>
            <!-- End of Topbar -->

            <script>
                var addRowClick = 0;
                 function setAmount(amount = '0',rate = '0', quantity = '0') {
                    if (amount!='0' || rate!='0' || quantity!=0){
                        amountValue = amount;
                        rateValue = rate;
                        quantityValue = quantity;
                    }

                    if (amountValue == "" || rateValue == "" || quantity == ""){
                        alert("Fill all the fields above first");
                    }else {
                        console.log("amount: "+amountValue+" Rate: "+rateValue);
                        document.getElementById(amountValue).value = document.getElementById(quantityValue).value * document.getElementById(rateValue).value;
                    }
                }

                function deleterow(row) {
                    if(confirm('Are you sure you want to delete?')){
                        var div = document.getElementById(row.className);
                        div.parentNode.removeChild(div);
                    }

                }

                function addrow(counter) {
                    counter = Number(counter) + Number(addRowClick);
                    
                    
                    var section = document.getElementById("additional");
                    var divrow = document.createElement("div");
                    
                    divrow.innerHTML = "<div id=\"div"+counter+"\"><div class=\"row\" required>\n" +
                        "            <div class=\"col-sm-1\">\n" +
                        "                <label for=\"item\">Item</label>\n" +
                        "                <input type=\"text\" class=\"form-control\" name=\"item"+counter+"\" required value="+counter+">\n" +
                        "            </div>\n" +
                        "            <div class=\"col-sm-4\">\n" +
                        "                <label for=\"description\">Description</label>\n" +
                        "                <input type=\"text\" class=\"form-control\" name=\"description"+counter+"\" required>\n" +
                        "            </div>\n" +
                        "            <div class=\"col-sm-2\">\n" +
                        "                <label for=\"quantity\">Quantity</label>\n" +
                        "                <input type=\"text\" class=\"form-control\" name=\"quantity"+counter+"\" id=\"quantity"+counter+"\" required>\n" +
                        "            </div>\n" +
                        "            <div class=\"col-sm-2\">\n" +
                        "                <label for=\"rate\">Rate</label>\n" +
                        "                <input type=\"text\" class=\"form-control\" name=\"rate"+counter+"\" id=\"rate"+counter+"\" onkeydown=\"setAmount('amount"+counter+"','rate"+counter+"', 'quantity"+counter+"')\" required>\n" +
                        "            </div>\n" +
                        "            <div class=\"col-sm-2\">\n" +
                        "                <label for=\"amount\">Amount</label>\n" +
                        "                <input type=\"text\" class=\"form-control\" name=\"amount"+counter+"\" id=\"amount"+counter+"\" required readonly>\n" +
                        "            </div>\n" +
                        "            <div class=\"col-sm-1\">\n"+
                        "               <br />\n"+
                        "               <img src=\"https://img.icons8.com/fluent/48/000000/delete-sign.png\" class=\"div"+counter+"\" onclick=\"deleterow(this)\"/>\n"+
                        "            </div>\n"+
                        "\n" +
                        "        </div></div>";
                    section.appendChild(divrow);
                    setAmount();
                    addRowClick++;
                }

                function submitData(e) {
                    setAmount()
                    if(!confirm('Do you want to proceed?'))e.preventDefault();
                }
            </script>

            <?php
                // $host_name = "localhost";
                // $db_username = "dannexte_root";
                // $db_password = "BitifyPro@2020";
                // $db_name = "dannexte_invoices";
                $host_name = "localhost";
                $db_username = "root";
                $db_password = "";
                $db_name = "invoice_generator";

                $connect = mysqli_connect($host_name, $db_username, $db_password, $db_name);


                if (!$connect) {
                    echo "<script>alert('Could not connect to the database');</script>";
                    exit;
                }

            ?>




            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-6">
                        <form action="" method="post" class="user">
                            <div class="form-group">
                                <input type="tel" name="invoice_no" id="invoice_no" class="form-control form-control-user" placeholder="Enter Invoice Number" required>
                            </div>
                                <input type="submit" name="search_invoice" class="btn btn-primary btn-user btn-block" value="Search Invoice"/>
                        </form>
                    </div>
                    <div class="col-sm-3">
                    </div>
                </div>

                <form action="../create_invoice.php" method="POST">

                <?php 
                    //beginning of condition
                    if(isset($_POST['search_invoice'])){ //check if form was submitted
                        $invoice = $_POST['invoice_no']; //get input text
                        
                        $sql_items = "SELECT * FROM items WHERE itemInvoiceNo = '".$invoice."'";
                        $sql_invoice = "SELECT * FROM invoice WHERE invoiceNo = '".$invoice."'";

                        $result_items = mysqli_query($connect, $sql_items);
                        
                        $result_invoice = mysqli_query($connect, $sql_invoice);

                        while($invoice = mysqli_fetch_array($result_invoice, MYSQLI_ASSOC)) {
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" >
                                    <label for="bill_to">Bill To</label>
                                    <textarea class="form-control" name="bill_to" rows="3" required ><?php echo $invoice['billTo'];?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="desc_inv_no">Description</label>
                                    <textarea class="form-control" name="desc_inv_no" rows="3" required><?php echo $invoice['description'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <?php
                        }//end of loop 
                            $counter = 1;
                            while($items = mysqli_fetch_array($result_items, MYSQLI_ASSOC)) {
                                
                        ?>
                        <div class="row" id="<?php echo 'div'.$counter ?>">
                            <div class="col-sm-1">
                                <label for="item1">Item</label>
                                <input type="text" class="form-control" name="<?php echo 'item'.$counter?>" value="<?php echo $items['itemNo'];?>" required>
                            </div>
                            <div class="col-sm-4">
                                <label for="description1">Description</label>
                                <input type="text" class="form-control" name="<?php echo 'description'.$counter?>" value="<?php echo $items['itemDescription'];?>" required>
                            </div>
                            <div class="col-sm-2">
                                <label for="quantity1">Quantity</label>
                                <input type="text" class="form-control" name="<?php echo 'quantity'.$counter?>" id="<?php echo 'quantity'.$counter?>" value="<?php echo $items['itemQuantity'];?>" required>
                            </div>
                            <div class="col-sm-2">
                                <label for="rate1">Rate</label>
                                <input type="text" class="form-control" name="<?php echo 'rate'.$counter?>" id="<?php echo 'rate'.$counter?>" value="<?php echo $items['itemRate'];?>" required onkeydown="setAmount('<?php echo 'amount'.$counter?>','<?php echo 'rate'.$counter?>','<?php echo 'quantity'.$counter?>')">
                            </div>
                            <div class="col-sm-2">
                                <label for="amount1">Amount</label>
                                <input type="text" class="form-control" name="<?php echo 'amount'.$counter?>" id="<?php echo 'amount'.$counter?>" required readonly value="<?php echo $items['itemRate']*$items['itemQuantity'];?>">
                            </div>
                            <div class="col-sm-1">
                               <br />
                               <img src="https://img.icons8.com/fluent/48/000000/delete-sign.png" class="<?php echo 'div'.$counter?>" onclick="deleterow(this)"/>
                            </div>
                        </div>
                        
                        <?php
                            $counter++;
                            }//end of loop
                            $result_invoice = mysqli_query($connect, $sql_invoice);
                            $invoice_result = mysqli_fetch_assoc($result_invoice);
                            ?>
                            
                            <input type=text value="update" name="invoice_type" hidden/>
                            <input type=text value="<?php echo $invoice_result['invoiceNo'];?>" name="invoice_no" hidden/>
                            <div id="additional"></div>
                            <button type="button" class="btn btn-primary" onclick="addrow('<?php echo $counter?>')">Add Item</button>
                            <br /><br /><br />
                            <button type="submit" class="btn btn-primary" id="submit" onclick="submitData(event)">Update Invoice</button>
                </form>
                            <?php
                    } //end of condition
                    mysqli_close($connect);
                ?>
                    
                    
                    












                
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Marc 2020</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
