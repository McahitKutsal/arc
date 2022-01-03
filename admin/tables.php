<?php
    //include auth.php file on all secure pages
    include("../auth/adminauth.php");
    header('Content-Type: text/html; charset=utf-8');
    require('../db/config.php');
    session_start();
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
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <link rel="icon" href="../img/icon.ico">
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="../index.php">HOMEPAGE</a>
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
                                Dashboard
                            </a>
                            
                            
                            <div class="sb-sidenav-menu-heading">Stock Tracking</div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                                Stock Data
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
                            
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Tables</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Stock Table
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" style="white-space:nowrap;">
                                    <thead>
                                        <tr>
                                            <th>Stock Name</th>
                                            <th>Description</th>
                                            <th>Stock Number</th>
                                            <th>Update Stock Number</th>
                                            <th>Approve</th>                              
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM `stock`";
                                        $stmt = $pdo->query($query);
                                        while ($row = $stmt->fetch()) {
                                            echo "<tr>";
                                            echo "<td>".$row['name']."</td>";
                                            echo "<td>".$row['description']."</td>";
                                            echo "<td white-space: nowrap;><input type='number' name=".$row['id']." class='form-control text' value='".$row['number']."' aria-label='Username' aria-describedby='basic-addon1'/>
                                                
                                            </td>";
                                            echo "<td><button id=".$row['id']." type='button' onclick='updateStockNumber(".$row['id'].")' class='btn btn-success'><i class='fa fa-check'aria-hidden='true'></i></button></td>";
                                            echo "<td>
                                                    <div class='form-check form-switch'>
                                                      <input class='form-check-input' onchange='updateStockApprove(".$row['id'].")' type='checkbox' id=".$row['id']."
                                                      ";
                                                      if ($row['is_approved']) {
                                                          echo "checked='true'";
                                                      }
                                            echo "/>
                                                    </div>
                                                </td>";
                                             echo "<td><button type='button' onclick='deleteStock(".$row['id'].")' class='btn btn-danger'><i class='fa fa-trash' aria-hidden='true'></i></button></td>";
                                            echo "<tr>";
                                        }
                                        ?>
                                </table>
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
            function updateStockApprove(id){
                var Id = id;
                request = $.ajax({
                url: "../api/stock-api.php",
                type: "patch",
                data: JSON.stringify({'id':Id}),
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
            function updateStockNumber(id){
                var Id = id
                var value = document.getElementsByName(id)[0].value;
                
                request = $.ajax({
                url: "../api/stock-api.php",
                type: "put",
                data: JSON.stringify({'id':Id, 'value':value}),
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
            function deleteStock(id){
                var Id = id
                console.log(Id)
                var result = confirm("Want to delete?");
                if (result) {
                    request = $.ajax({
                    url: "../api/stock-api.php",
                    type: "delete",
                    data: JSON.stringify({'id':Id}),
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
                }else{
                    console.log("not deleted");
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
