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



    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


</head>

<body>
<div id="wrapper">
    <?php require_once 'admin_sidebar.php'; ?>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php require_once 'navbar.php'?>
        <div class="ibox-content">
        </div>
        <div class="ibox-content">
        <div class="table-responsive">

        <table id="userTable" class="table table-bordered table-striped">
                        <thead class="table-light">
                        <tr class="filter-row">
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
                        </tr>
                        </thead>

                    </table>
        </div>
        <?php require_once 'footer.php'?>
        </div>
    </div>
</div>

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>

<!-- DataTables JS -->
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

<script>
    $('#userTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "fetch_users.php",
            "type": "POST"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "surname" },
            { "data": "email" },
            { "data": "address" },
            { "data": "role" },
            { "data": "birthday" },
            { "data": "email_verified" }
        ]
    });


</script>


<script>
    $(document).ready(function() {
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

        }, 1300);


        var data1 = [
            [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,30],[11,10],[12,13],[13,4],[14,3],[15,3],[16,6]
        ];
        var data2 = [
            [0,1],[1,0],[2,2],[3,0],[4,1],[5,3],[6,1],[7,5],[8,2],[9,3],[10,2],[11,1],[12,0],[13,2],[14,8],[15,0],[16,0]
        ];
        $("#flot-dashboard-chart").length && $.plot($("#flot-dashboard-chart"), [
                data1, data2
            ],
            {
                series: {
                    lines: {
                        show: false,
                        fill: true
                    },
                    splines: {
                        show: true,
                        tension: 0.4,
                        lineWidth: 1,
                        fill: 0.4
                    },
                    points: {
                        radius: 0,
                        show: true
                    },
                    shadowSize: 2
                },
                grid: {
                    hoverable: true,
                    clickable: true,
                    tickColor: "#d5d5d5",
                    borderWidth: 1,
                    color: '#d5d5d5'
                },
                colors: ["#1ab394", "#1C84C6"],
                xaxis:{
                },
                yaxis: {
                    ticks: 4
                },
                tooltip: false
            }
        );

        var doughnutData = {
            labels: ["App","Software","Laptop" ],
            datasets: [{
                data: [300,50,100],
                backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
            }]
        } ;


        var doughnutOptions = {
            responsive: false,
            legend: {
                display: false
            }
        };


        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

        var doughnutData = {
            labels: ["App","Software","Laptop" ],
            datasets: [{
                data: [70,27,85],
                backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
            }]
        } ;


        var doughnutOptions = {
            responsive: false,
            legend: {
                display: false
            }
        };


        var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

    });
</script>
</body>
</html>

