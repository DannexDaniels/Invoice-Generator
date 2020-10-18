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
      <li class="nav-item active">
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

      <!-- Nav Item - Update Invoice -->
      <li class="nav-item">
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

            $sql = "SELECT * FROM invoice ORDER BY datebilled DESC";

            $result = mysqli_query($connect, $sql);

        ?>


        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Invoices Generated</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo $result->num_rows; ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Current VAT Rate</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                      <?php
                                        $vat_sql = "SELECT value FROM vat WHERE id = 1";

                                        $vat_result = mysqli_query($connect, $vat_sql);
                            
                                        $vat = mysqli_fetch_assoc($vat_result);

                                        echo $vat['value']."%";

                                      ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Income</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Sh. 40,000</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Value Added Tax</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Sh. 8,000</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Invoices</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Invoice Number</th>
                      <th>Bill To</th>
                      <th>Description</th>
                      <th>Date Billed</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Bill To</th>
                        <th>Description</th>
                        <th>Date Billed</th>
                        <th></th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <tr>
                    <?php
                    while($invoice = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo $invoice['invoiceNo'];?></td>
                            <td><?php echo $invoice['billTo'];?></td>
                            <td><?php echo $invoice['description'];?></td>
                            <td><?php echo $invoice['dateBilled'];?></td>
                            <td>
                                <a href="<?php echo $invoice['invoicePath'];?>" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                      <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="text">View</span>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }

                    mysqli_close($connect);
                    ?>

                    
                  </tbody>
                </table>
              </div>
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

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
