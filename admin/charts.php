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
        <title>ARC Dashboard</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="icon" href="../img/icon.ico">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="../index.php">HOMEPAGE</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            
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
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        User Operations
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="../reset-password.php">
                                                <div class="sb-nav-link-icon"><i class="fas fa-key "></i></div>
                                                Change Password
                                            </a>
                                            <a class="nav-link" href="../logout.php">
                                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                                Logout
                                            </a>
                                            <a class="nav-link" href="../register.php">
                                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                                Create New User
                                            </a>
                                        </nav>
                                    </div>
                            <!--<div class="sb-sidenav-menu-heading">User Operations</div>
                            <a class="nav-link" href="../reset-password.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-key "></i></div>
                                Change Password
                            </a>
                            <a class="nav-link" href="../logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                            <a class="nav-link" href="../register.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Create New User
                            </a>
                            -->
                            <div class="sb-sidenav-menu-heading">Analysis</div>
                            <a href="charts.php" class="nav-link" >
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                                Chart Analysis
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged In As:</div>
                        <?php 
                            echo $_SESSION["role"];
                        ?>
                        
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Charts</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Charts</li>
                        </ol>
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <select id="labSelect" class='form-select' onchange='labSelected(this);' aria-label='Rol Listesi'>
                                    <option disabled selected value='default'>Choose a Laboratory...</option>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <select id="machineSelect" class='form-select' onchange='machineSelected(this);' aria-label='Rol Listesi'>
                                    <option disabled selected value='default'>Choose a Machine...</option>
                                </select>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <input type="text" id="monthId" onchange="mounthChanged(this)" class="form-control" placeholder="Choose a month here..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>  
                        <div class="card mb-4">
                            <div class="card-body">
                                Data Analysis Page
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Area Chart For Selected Month
                            </div>
                            <div class="card-body"><canvas id="chartForWeek" width="100%" height="30"></canvas></div>
                            <div class="card-footer small text-muted">ITU - ARC</div>
                        </div>
                        <!--<div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Bar Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="50"></canvas></div>
                                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-pie me-1"></i>
                                        Pie Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myPieChart" width="100%" height="50"></canvas></div>
                                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                                </div>
                            </div>
                        </div>-->
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
            document.addEventListener("DOMContentLoaded", function() {
                getAllLabs();
            });
            
        </script>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/demo/chart-pie-demo.js"></script>
    </body>
</html>
