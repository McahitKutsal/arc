<?php
//include auth.php file on all secure pages
include("auth/auth.php");
require('db/config.php');
header('Content-Type: text/html; charset=utf-8');
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>ITU-ARC</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="admin/css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="icon" href="img/icon.ico">
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Homepage</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            
            <!-- Navbar-->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">ARC</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Homepage
                            </a>
                            
                            
                            <div class="sb-sidenav-menu-heading">Stock Tracking</div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                                Stock Data
                            </a>
                            <a data-bs-target="#stockModal" data-bs-toggle="modal" href="" class="nav-link">
                                <div class="sb-nav-link-icon"><i class="fas fa-paper-plane"></i></div>
                                Send a Stock Request
                            </a>
                            
                            
                            <div class="sb-sidenav-menu-heading">User Operations</div>
                            <a class="nav-link" href="../reset-password.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-key "></i></div>
                                Change Password
                            </a>
                            <a class="nav-link" href="../logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                            <div class="sb-sidenav-footer">
                            <div class="small">Logged In As:</div>
                            <div id="roleDiv">
                            <?php 
                                echo $_SESSION["role"];
                            ?>
                            </div>
                    </div>
                            
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Homepage</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Stock Table
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Stock Name</th>
                                            <th>Stock Number</th>
                                            <th>Description</th>                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM `stock` where `is_approved`!='disapproved'";
                                        $stmt = $pdo->query($query);
                                        while ($row = $stmt->fetch()) {
                                            echo "<tr>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['number']."</td>";
                                            echo "<td>".$row['description']."</td>";
                                            echo "<tr>";
                                        }
                                        ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Fill in the form below to send a stock request.</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group mb-3">
                              <label for="stockName" class="col-form-label">Stock Name: </label>
                              <input type="text" id="stockName" class="form-control" placeholder="type name..." aria-label="Username" aria-describedby="basic-addon1">
                              <label for="stockNumber" class="col-form-label">Stock Number: </label>
                              <input type="number" id="stockNumber" class="form-control" placeholder="type number..." aria-label="Username" aria-describedby="basic-addon1">
                              <label for="description" class="col-form-label">Description: </label>
                              <textarea class="form-control" id="description"></textarea>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick='sendStockRequest()' data-bs-dismiss="modal">Send Request</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">ITU Aerospace Research Center &copy;</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script type="text/javascript">
            var role = document.getElementById('roleDiv').textContent.trim();
            function checkRole(){
                if (role.localeCompare('visitor')) {
                    return false;
                }
                else{
                    return true;
                }
            }

            function sendStockRequest(){
                if (checkRole()) {
                    alert("You are not authorized for this process");
                    return
                }
                var stockName = document.getElementById("stockName").value;
                var stockNumber = document.getElementById("stockNumber").value;
                var description = document.getElementById("description").value;
                request = $.ajax({
                url: "../api/stock-api.php",
                type: "post",
                data: JSON.stringify({'name':stockName, 'number':stockNumber, 'description':description}),
                contentType: "application/json; charset=utf-8",
                dataType: "json",

                });
                request.done(function (response, textStatus, jqXHR){
                    alert(response.result);
                });

                request.fail(function (jqXHR, textStatus, errorThrown){
                    // Log the error to the console
                    console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                    );
                });
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="admin/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="admin/js/datatables-simple-demo.js"></script>
    </body>
</html>
