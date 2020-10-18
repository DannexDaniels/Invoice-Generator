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
        <li class="nav-item active">
            <a class="nav-link" href="vat.php">
                <i class="fas fa-fw fa-percentage"></i>
                <span>Set VAT</span></a>
        </li>

        <!-- Nav Item - Update Invoices -->
        <li class="nav-item ">
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

            if(isset($_POST['update_vat'])){ //check if form was submitted
                $new_vat = $_POST['new_vat']; //get input text
                $vat_sql = "UPDATE vat SET value = ".$new_vat." WHERE id = 1";
                mysqli_query($connect, $vat_sql);
                echo "<script>alert('VAT Updated Successfully');</script>";
              } 

            $sql = "SELECT value FROM vat WHERE id = 1";

            $result = mysqli_query($connect, $sql);

            $vat = mysqli_fetch_assoc($result);

            mysqli_close($connect);

        ?>


            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5">
                        <center>
                            <h1>Current VAT</h1>
                            <strong><h3><?php echo $vat['value']."%";?></h3></strong>
                        </center>
                    </div>
                    <div class="col-lg-7">
                        <form action="" method="post" class="user">
                            <div class="form-group">
                            <input type="tel" name="new_vat" class="form-control form-control-user" placeholder="Enter Current VAT..." required>
                            </div>
                            <input type="submit" name="update_vat" class="btn btn-primary btn-user btn-block" value="Update Current VAT"/>
                        </form>
                    </div>
                </div>
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
