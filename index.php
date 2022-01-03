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
        <link rel="icon" href="img/icon.ico">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="#">HOMEPAGE</a>
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
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Homepage
                            </a>
                            
                            <div class="sb-sidenav-menu-heading"></div>
                            <a class="nav-link collapsed" id="collapsable" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fa fa-flask"></i></div>
                                Laboratories
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav" id="collapseNav">
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Stock Tracking</div>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                                Stock Data
                            </a>
                            <!--<a data-bs-target="#stockModal" data-bs-toggle="modal" href="" class="nav-link">
                                <div class="sb-nav-link-icon"><i class="fas fa-paper-plane"></i></div>
                                Send a Stock Request
                            </a>-->
                            
                            
                            
                            <div class="sb-sidenav-menu-heading">User Operations</div>
                            <a class="nav-link" href="../reset-password.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-key "></i></div>
                                Change Password
                            </a>
                            <a class="nav-link" href="../logout.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged In :</div>
                        <div id="userNameDiv">
                        <?php 
                            echo $_SESSION["username"];
                        ?>
                        </div>
                        <div class="small">As :</div>
                        <div id="roleDiv">
                        <?php 
                            echo $_SESSION["role"];
                        ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">ITU-ARC</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Homepage</li>
                            <li class="breadcrumb-item active">&#128994; => Active &#128308; => Passive</li>
                        </ol>
                        <div class="px-3">
                        <div class="row justify-content-center">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Set Date: </span>
                              </div>
                              <input type="text" id="dateId" onchange="dateChanged(this)" class="form-control" placeholder="Click or touch here..." aria-label="Username" aria-describedby="basic-addon1">
                              
                            </div>
                            <div class="row">
                                <div class="col-6 col-lg-3 blockquote">
                                    <p style="cursor: pointer;" id="00:00 - 01:00" onclick="timeClicked(this)" class="text-secondary time">00:00 - 01:00</p>
                                    <p style="cursor: pointer;" id="01:00 - 02:00" onclick="timeClicked(this)" class="text-secondary time">01:00 - 02:00</p>
                                    <p style="cursor: pointer;" id="02:00 - 03:00" onclick="timeClicked(this)" class="text-secondary time">02:00 - 03:00</p>
                                    <p style="cursor: pointer;" id="03:00 - 04:00" onclick="timeClicked(this)" class="text-secondary time">03:00 - 04:00</p>
                                    <p style="cursor: pointer;" id="04:00 - 05:00" onclick="timeClicked(this)" class="text-secondary time">04:00 - 05:00</p>
                                    <p style="cursor: pointer;" id="05:00 - 06:00" onclick="timeClicked(this)" class="text-secondary time">05:00 - 06:00</p>
                                    
                                </div>
                                <div class="col-6 col-lg-3 blockquote">
                                    <p style="cursor: pointer;" id="06:00 - 07:00" onclick="timeClicked(this)" class="text-secondary time">06:00 - 07:00</p>
                                    <p style="cursor: pointer;" id="07:00 - 08:00" onclick="timeClicked(this)" class="text-secondary time">07:00 - 08:00</p>
                                    <p style="cursor: pointer;" id="08:00 - 09:00" onclick="timeClicked(this)" class="text-secondary time">08:00 - 09:00</p>
                                    <p style="cursor: pointer;" id="09:00 - 10:00"onclick="timeClicked(this)" class="text-secondary time">09:00 - 10:00</p>
                                    <p style="cursor: pointer;" id="10:00 - 11:00" onclick="timeClicked(this)" class="text-secondary time">10:00 - 11:00</p>
                                    <p style="cursor: pointer;" id="11:00 - 12:00" onclick="timeClicked(this)" class="text-secondary time">11:00 - 12:00</p>
                                </div>
                                <div class="col-6 col-lg-3 blockquote">
                                    <p style="cursor: pointer;" id="12:00 - 13:00" onclick="timeClicked(this)" class="text-secondary time">12:00 - 13:00</p>
                                    <p style="cursor: pointer;" id="13:00 - 14:00" onclick="timeClicked(this)" class="text-secondary time">13:00 - 14:00</p>
                                    <p style="cursor: pointer;" id="14:00 - 15:00" onclick="timeClicked(this)" class="text-secondary time">14:00 - 15:00</p>
                                    <p style="cursor: pointer;" id="15:00 - 16:00" onclick="timeClicked(this)" class="text-secondary time">15:00 - 16:00</p>
                                    <p style="cursor: pointer;" id="16:00 - 17:00" onclick="timeClicked(this)" class="text-secondary time">16:00 - 17:00</p>
                                    <p style="cursor: pointer;" id="17:00 - 18:00" onclick="timeClicked(this)" class="text-secondary time">17:00 - 18:00</p>
                                </div>
                                <div class="col-6 col-lg-3 blockquote">
                                    <p style="cursor: pointer;" id="18:00 - 19:00" onclick="timeClicked(this)" class="text-secondary time">18:00 - 19:00</p>
                                    <p style="cursor: pointer;" id="19:00 - 20:00" onclick="timeClicked(this)" class="text-secondary time">19:00 - 20:00</p>
                                    <p style="cursor: pointer;" id="20:00 - 21:00" onclick="timeClicked(this)" class="text-secondary time">20:00 - 21:00</p>
                                    <p style="cursor: pointer;" id="21:00 - 22:00" onclick="timeClicked(this)" class="text-secondary time">21:00 - 22:00</p>
                                    <p style="cursor: pointer;" id="22:00 - 23:00" onclick="timeClicked(this)" class="text-secondary time">22:00 - 23:00</p>
                                    <p style="cursor: pointer;" id="23:00 - 24:00" onclick="timeClicked(this)" class="text-secondary time">23:00 - 24:00</p>
                                </div>
                                <button type="button" onclick="wholeDayBooking()" class="btn btn-info">Booking for the whole day</button>
                                <button type="button" onclick="wholeDayDelete()" class="btn btn-danger mt-2">Delete all your appointments for this day</button>
                            </div>
                        </div>
                        <div class="col-sm" role="group" id="buttonGroup"></br>

                        </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Would you like to add a note?</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Note: </span>
                              </div>
                              <input type="text" id="appointmentInput" class="form-control" placeholder="Optional..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick='setAppointmentNote()' data-bs-dismiss="modal">Book</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="modal" id="wholeDayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Would you like to add a note for whole day appointment?</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Note: </span>
                              </div>
                              <input type="text" id="wholeDayInput" class="form-control" placeholder="Optional..." aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick='setWholeDayNote()' data-bs-dismiss="modal">Book</button>
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
            <!-- Modal for booking information-->
            <div class="modal fade" id="bookingInformationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Appointment information</h5>
                  </div>
                  <div class="modal-body">
                    <p id="bookerName">
                        
                    </p>
                    <p id="bookingNote">
                        
                    </p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="admin/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        
        
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="admin/js/datatables-simple-demo.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script type="text/javascript">
            var userName = document.getElementById('userNameDiv').textContent.trim();
            var role = document.getElementById('roleDiv').textContent.trim();
            var visitor = 'visitor'
            userName = userName.trim()+ " ";
            var buttonName = "Not selected yet.";
            var selectedDate = "";
            var selectedTime = "";
            var appointmentNote = "";
            var wholeDayNote = "";
            var resultDate = "";
            var arr = [];
            var timeArr = []; 
            const fp = flatpickr("#dateId", {

            });
            function checkRole(){
                if (role.localeCompare('visitor') === 0) {
                    return true;
                }
                else{
                    return false;
                }
            }
            function dateChanged(input){
                
                selectedDate = input.value
                var paragraphs = document.getElementsByClassName('time');
                for (var i = 0; i < paragraphs.length; i++) {
                    paragraphs[i].className = "text-secondary time";
                }
                if (buttonName !== 'Not selected yet.') {
                    $.ajax({
                    url: "../api/getAppointmentsByDate/appointments-by-date.php",
                    type: "get",
                    data: { 
                        machineName: buttonName,
                        date: selectedDate
                      },
                    context: document.body,
                    success: function(result){
                        timeArr=[]
                        for (var i = 0; i < result.length; i++) {
                            timeArr[i] = result[i].appointment_date.substring(11);
                        }
                        var paragraphs = document.getElementsByClassName('time');
                        for (var i = 0; i < paragraphs.length; i++) {
                            paragraphs[i].className = "text-success time";
                        }
                        
                        for (var i = 0; i < timeArr.length; i++) {

                            for (var j = 0; j < arr.length; j++) {
                                if (timeArr[i] === arr[j]) {
                                    var p = document.getElementById(timeArr[i]);
                                    p.className = "text-danger time";
                                }else{

                                }
                            }
                        }
                    }});
                }
                
            }

            $(".time").hover(function() {
                $(this).css({"text-decoration":"underline"});
            }, function() {
                $(this).css({"text-decoration":""});
            });
        </script>

        <script type="text/javascript">

            document.addEventListener("DOMContentLoaded", function() {
                getAllLabs();
                var paragraphs = document.getElementsByClassName('time');
                for (var i = 0; i < paragraphs.length; i++) {
                    arr[i]=paragraphs[i].innerHTML;
                }
            });
            function getAllLabs(){
                $.ajax({
                    url: "../api/laboratory-api.php",
                    type: "get",
                    context: document.body,
                    success: function(result){
                        document.getElementById("collapseNav").innerHTML = '';
                        for (var i = 0; i < result.length; i++) {
                            const link = document.createElement('a');
                            const textnode = document.createTextNode(result[i].name);
                            link.appendChild(textnode);
                            link.href = "javascript:void(0);";
                            let labId = result[i].id
                            link.addEventListener('click', function(){
                                getMachinesByLab(labId);
                            });
                            link.className += "nav-link";
                            document.getElementById("collapseNav").appendChild(link);
                        }

                    }
                });
            }
            function getMachinesByLab(labId){
                buttonName = "";
                var paragraphs = document.getElementsByClassName('time');
                for (var i = 0; i < paragraphs.length; i++) {
                    paragraphs[i].className = "text-secondary time";
                }
                $.ajax({
                    url: "../api/getMachinesById/machines-by-lab.php",
                    type: "get",
                    data: { 
                        id: labId
                      },
                    context: document.body,
                    success: function(result){
                        document.getElementById("buttonGroup").innerHTML = '';
                        let p = document.createElement('p');
                        p.innerHTML = "The Machine Selected:";
                        p.className += "m-2";
                        p.setAttribute("id","selectedMachineText");
                        document.getElementById("buttonGroup").appendChild(p);
                        for (var i = 0; i < result.length; i++) {
                            let button = document.createElement('button');
                            button.innerHTML = result[i].name;
                            button.addEventListener('click', function(){
                                buttonClicked(this);
                            });
                            if (result[i].status === 'active') {
                                button.className += "btn btn-success m-2";
                            }else{
                                button.className += "btn btn-danger m-2 disabled";
                            }
                            document.getElementById("buttonGroup").appendChild(button);
                        }
                        
                    }
                });
            }
            
            function buttonClicked(button){
                var buttonText = button.innerText;
                buttonName = buttonText;
                document.getElementById("selectedMachineText").innerHTML= "The Machine Selected: " + buttonName;
            }
            function timeClicked(paragraph){
                if (checkRole()) {
                    alert("You are not authorized for this process");
                    return
                }
                var timeText = paragraph.innerHTML;
                var pClass = paragraph.className;
                selectedTime = timeText;
                resultDate = selectedDate + " " + selectedTime
                
                 if(pClass === 'text-danger time'){
                    getBookingInfo(resultDate);
                }else{
                    var result = confirm("Do you want to book this reservation?");
                    if (result) {
                        if (selectedDate === "" || buttonName === "" || buttonName === "Not selected yet.") {
                            alert("Please select date and machine before booking");
                        }else if(appointmentNote === ""){
                            $("#appointmentModal").modal('show');
                            paragraph.className = 'text-danger time';
                        }
                        else{
                            alert("Something went wrong, please contact the developer.")  
                        }
                    }else{

                    } 
                }
                
            }
            function setAppointmentNote(){
                appointmentNote = document.getElementById("appointmentInput").value;
                request = $.ajax({
                    url: "../api/appoinment-api.php",
                    type: "post",
                    data: JSON.stringify({'userName':userName, 'date':resultDate,'machine':buttonName, 'note': appointmentNote}),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",

                    });
                    request.done(function (response, textStatus, jqXHR){
                        alert(response.result);
                        appointmentNote = "";
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                        );
                        appointmentNote = "";
                    });
            }
            function getBookingInfo(date){
                $.ajax({
                    url: "../api/getBookingInfo/get-booking-info.php",
                    type: "get",
                    data: { 
                        machineName: buttonName,
                        date: date
                      },
                    context: document.body,
                    success: function(result){
                        var bookerName = result[0].appointment_user
                        var bookerName = bookerName.trim();
                        var note = result[0].appointment_note;
                        var bookingId = result[0].id;
                        console.log(bookerName)
                        if (bookerName === userName.trim()) {
                          var result = confirm("Do you want to cancel this reservation?");
                          if (result) {
                            deleteAppointment(bookingId);
                          } 
                        }else{
                            p = document.getElementById("bookerName")
                            p.innerHTML = "This appointment has already been booked by: "+ bookerName;
                            p2 = document.getElementById("bookingNote")
                            p2.innerHTML = "Notes: "+ note;
                            $("#bookingInformationModal").modal('show');
                        }
                        
                }});
            }
            function deleteAppointment(bookingId){
                var dataa = {'id':bookingId}
                axios.delete('api/appoinment-api.php', { data: dataa}).then(function (response) {
                    alert(response.data.result)
                })
            }
            function wholeDayBooking(){
                if (checkRole()) {
                    alert("You are not authorized for this process");
                    return
                }
                var result = confirm("Do you want to book this reservation?");
                if (result) {
                    if (selectedDate === "" || buttonName === "" || buttonName === "Not selected yet.") {
                        alert("Please select date and machine before booking");
                    }else if(appointmentNote === ""){
                        $("#wholeDayModal").modal('show');
                    }
                    else{
                        alert("Something went wrong, please contact the developer.")  
                    }
                }else{

                } 
            }
            function setWholeDayNote(){
                wholeDayNote = document.getElementById("wholeDayInput").value;
                request = $.ajax({
                    url: "../api/wholeDayBooking/whole-day.php",
                    type: "post",
                    data: JSON.stringify({'userName':userName, 'date':selectedDate,'machine':buttonName, 'note': wholeDayNote, 'timeArray':arr}),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",

                    });
                    request.done(function (response, textStatus, jqXHR){
                        alert(response.result);
                        wholeDayNote = "";
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                        );
                        wholeDayNote = "";
                    });
            }
            function wholeDayDelete(){
                if (checkRole()) {
                    alert("You are not authorized for this process");
                    return
                }
                var result = confirm("Do you want to delete all your reservations?");
                if (result) {
                    if (selectedDate === "" || buttonName === "" || buttonName === "Not selected yet.") {
                        alert("Please select date and machine before booking");
                    }
                    else{

                        dataa = {'userName':userName, 'machineName':buttonName, 'date':selectedDate}
                        axios.delete('../api/wholeDayBooking/whole-day.php', { data: dataa}).then(function (response) {
                            alert(response.data.result)
                        })
                    }
                }else{
                    alert("Something went wrong, please contact the developer.")
                } 
            }
        </script>
        
    </body>
</html>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ITU-ARC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="img/icon.ico">
    <link rel="stylesheet" type="text/css" href="table/datatables.min.css"/>
 
    <script type="text/javascript" src="table/datatables.min.js"></script>
</head>
<body>
    <div class="d-flex justify-content-center mt-5">
        <div class="">
            <h1 class="my-5 text-center">Merhaba, 
                <b><?php// echo htmlspecialchars($_SESSION["username"]); ?></b>
                <b><?php// echo htmlspecialchars($_SESSION["role"]); ?></b>
                . Hoşgeldin.
            </h1>
            <img src="img/arc.jpg" class="rounded mx-auto d-block img-fluid" alt="resim" width="500" height="600">
            <p class="text-center">
                <a href="reset-password.php" class="btn btn-warning">Şifre Değiştir</a>
                <a href="logout.php" class="btn btn-danger ml-3">Çıkış Yap</a>
            </p>
        </div>
    </div>
</body>
</html>
-->