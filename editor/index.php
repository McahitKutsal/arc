<?php
    //include auth.php file on all secure pages
    include("../auth/editorauth.php");
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
        <title>ARC Editorial Board</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="icon" href="../img/icon.ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="../index.php">HOMEPAGE</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>-->
            <!-- Navbar
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>-->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">ARC</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Editorial Board
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
                            <a href="tables.php" class="nav-link" >
                                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                                Stock Tracking
                            </a>

                            <div class="sb-sidenav-menu-heading">Machine Operations</div>
                            <a data-bs-target="#machineModal" data-bs-toggle="modal" href="" class="nav-link" >
                                <div class="sb-nav-link-icon"><i class="fa fa-cog"></i></div>
                                Create New Machine
                            </a>
                            <div class="sb-sidenav-menu-heading">laboratory Operations</div>
                            <a data-bs-target="#labratoryModal" data-bs-toggle="modal" href="" class="nav-link" >
                                <div class="sb-nav-link-icon"><i class="fa fa-flask"></i></div>
                                Create New Laboratory
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
                    <div class="modal fade" id="machineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create a New Machine</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Machine Name: </span>
                              </div>
                              <input type="text" id="machineInput" class="form-control" placeholder="type name..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick='createMachine()' data-bs-dismiss="modal">Create Machine</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal fade" id="labratoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create a New Labratory</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Labratory Name: </span>
                              </div>
                              <input type="text" id="laboratoryInput" class="form-control" placeholder="type name..." aria-label="LabratoryName" aria-describedby="basic-addon1">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick='createLaboratory()' data-bs-dismiss="modal">Create Labratory</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">ITU-ARC</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Editorial Board</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Laboratories Table
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple3">
                                    <thead>
                                        <tr>
                                            <th>Laboratory Name</th>
                                            <th>Number of Machines Covered by This Lab</th>
                                            <th>Delete</th>                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT
                                                      laboratories.id,
                                                      laboratories.name,
                                                      COUNT(machines.id) AS total
                                                    FROM
                                                      laboratories
                                                    LEFT JOIN machines ON laboratories.id = machines.laboratory_id
                                                    GROUP BY laboratories.id,laboratories.name;";
                                        $stmt = $pdo->query($query);
                                        $labArray = array();
                                        $sayac = 0;
                                        while ($row = $stmt->fetch()) {
                                            $labArray[$sayac]['id'] = $row["id"];
                                            $labArray[$sayac]['name'] = $row["name"];
                                            $sayac++;
                                            echo "<tr>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['total'] . "</td>";
                                            echo "<td><button type='button' onclick='deleteLaboratory(".$row['id'].")' class='btn btn-danger'>Delete</button></td>";
                                            echo "<tr>";
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Machines Table
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Machine Name</th>
                                            <th>Current Status</th>
                                            <th>Current Laboratory</th>
                                            <th>Set Status</th>
                                            <th>Set Laboratory</th>
                                            <th>Delete</th>                                
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM `machines`";
                                        $stmt = $pdo->query($query);
                                        while ($row = $stmt->fetch()) {
                                            echo "<tr>";
                                            echo "<td>" . $row['name'] . "</td>";
                                            echo "<td>" . $row['status'] . "</td>";
                                            
                                            echo "<td>" . $row['laboratory_name'] . "</td>";
                                            echo "<td><select class='form-select' onchange='updateMachine(this);' id=".$row['id']." aria-label='Rol Listesi'>
                                                    <option disabled selected value='default'>Choose a Status...</option>
                                                    <option value='active'>Active</option>
                                                    <option value='out of order'>Out of Order</option>
                                                    </select></td>";
                                            echo "<td><select class='form-select' onchange='updateMachineLab(this);' id=".$row['id']." aria-label='Lab Listesi'>
                                                    <option disabled selected value='default'>Choose a Laboratory...</option>";
                                                    foreach ($labArray as $lab) {
                                                        echo "<option value='".$lab['id']."'>".$lab['name']."</option>";
                                                    }
                                            echo "</select></td>";
                                            echo "<td><button type='button' onclick='deleteMachine(".$row['id'].")' class='btn btn-danger'>Delete</button></td>";
                                            echo "<tr>";
                                        }
                                        ?>
                                        
                                    </tbody>
                                </table>
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
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script type="text/javascript">

            function createLaboratory(){
                var laboratoryName = document.getElementById("laboratoryInput").value;
                console.log("labratory: ",laboratoryName);
                request = $.ajax({
                url: "../api/laboratory-api.php",
                type: "post",
                data: JSON.stringify({'name':laboratoryName}),
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
            function updateMachineLab(select)
            {
                var labName = select.options[select.selectedIndex].text;
                var labId = select.value;
                var machineId = select.id;
                console.log("id: ", labId, "lab: ", labName, "machine id: ", machineId);
                request = $.ajax({
                url: "../api/machine-api.php",
                type: "patch",
                data: JSON.stringify({'labId':labId, 'labName':labName, 'machineId':machineId}),
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
            function deleteLaboratory(id){
                var result = confirm("Want to delete?");
                if (result) {
                    request = $.ajax({
                    url: "../api/laboratory-api.php",
                    type: "delete",
                    data: JSON.stringify({'id':id}),
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

            function createMachine(){
                var machineName = document.getElementById("machineInput").value;
                request = $.ajax({
                url: "../api/machine-api.php",
                type: "post",
                data: JSON.stringify({'name':machineName}),
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
            function updateMachine(select)
            {
                request = $.ajax({
                url: "../api/machine-api.php",
                type: "put",
                data: JSON.stringify({'id':select.id, 'status':select.value}),
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
            function deleteMachine(id){
                var result = confirm("Want to delete?");
                if (result) {
                    request = $.ajax({
                    url: "../api/machine-api.php",
                    type: "delete",
                    data: JSON.stringify({'id':id}),
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
    </body>
</html>
