<?php
session_start();


require_once "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_SESSION['register_data'])) {
    unset($_SESSION['register_data']);
}

$sql = "SELECT id, name, surname, email, role FROM users";
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>ADMIN | Dashboard</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">


    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
<div id="wrapper">
    <?php require_once 'admin_sidebar.php'; ?>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php require_once 'navbar.php'?>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Filters</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="firstname">Firstname</label>
                                    <input type="text" class="form-control" name="name" id="name"/>
                                </div>
                                <div class="col-sm-3">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" class="form-control" name="surname" id="surname"/>
                                </div>
                                <div class="col-sm-3">
                                    <label for="birthday">Birthday</label>
                                    <input type="text" class="form-control" name="birthday" id="birthday" autocomplete="off"/>
                                </div>
                                <div class="col-sm-1">
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <button class="btn btn-outline-primary" id="btn-filter">Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>USERS</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-wrench"></i>

                                </a>
                                <ul class="dropdown-menu p-3" style="width:250px;">
                                    <li>
                                        <input type="text" id="filterName" class="form-control mb-2" placeholder="Filter Name">
                                    </li>
                                    <li>
                                        <input type="text" id="filterSurname" class="form-control mb-2" placeholder="Filter Surname">
                                    </li>
                                    <li>
                                        <input type="text" id="filterEmail" class="form-control mb-2" placeholder="Filter Email">
                                    </li>
                                    <li>
                                        <input type="text" id="filterAddress" class="form-control mb-2" placeholder="Filter Address">
                                    </li>
                                    <li>
                                        <input type="text" id="filterRole" class="form-control mb-2" placeholder="Filter Role">
                                    </li>


                                    <li>
                                        <div class="form-group" id="data_5">
                                            <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" class="form-control-sm form-control" id="start" name="start"/>
                                                <span class="input-group-addon">to</span>
                                                <input type="text" class="form-control-sm form-control" id="end" name="end"/>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <button id="applyFilter">Apply</button>
                                        <button id="clearFilter">Clear</button>
                                    </li>


                                </ul>
                                <a class="close-link"><i class="fa fa-times"></i></a>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id="userTable" class="table table-bordered table-striped">
                                    <thead class="table-light">
                                    <tr>
                                        <th class="display-order">Id</th>
                                        <th class="display-order">Name</th>
                                        <th class="display-order">Surname</th>
                                        <th class="display-order">Email</th>
                                        <th class="display-order">Address</th>
                                        <th class="display-order">Role</th>
                                        <th class="display-order">Birthday</th>
                                        <th class="display-order">Verification</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require_once 'footer.php'?>
        </div>
    </div>
</div>

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- DataTables JS -->
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>
<!-- Data picker -->
<script src="js/plugins/fullcalendar/moment.min.js"></script>
<script src="js/plugins/daterangepicker/daterangepicker.js"></script>

<script>
    let table;

    $(document).ready(function () {

        table = $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: "fetch_users.php",
                type: "POST",
                data: function (d) {
                    d.filters = {
                        strings: {
                            name: $('#name').val(),
                            surname: $('#surnname').val(),
                        },
                        dates: {
                            birthday: $('#birthday').val()
                        }
                    }
                }
            },
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "surname" },
                { data: "email" },
                { data: "address" },
                { data: "role" },
                { data: "birthday" },
                { data: "email_verified" }
            ]
        });

        $("#btn-filter").click(function(){
            table.draw();
        });

        $("#birthday").daterangepicker({
            autoApply: false
        }, function (start, end, label) {
            $("#birthday").val(start.format("YYYY-MM-DD") + " - " + end.format("YYYY-MM-DD"))
        });


        // $('#applyFilter').on('click', function () {
        //     table.page('first').draw('page');
        // });
        //
        // $('#clearFilter').on('click', function () {
        //     $('#filterName, #filterSurname, #filterEmail, #filterAddress,#start,#end').val('');
        //     table.page('first').draw('page');
        // });



    });


    $('.close-link').click(function () {
        var ibox = $(this).closest('.ibox');
        ibox.remove();
    });










</script>



</body>
</html>

