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

$sql = "SELECT id, name, surname, email, role FROM user";
$result = $conn->query($sql);
?>

<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>INSPINIA | Dashboard</title>

    <link href="inspinia-master/HTML5_Full_Version/css/bootstrap.min.css" rel="stylesheet">
    <link href="inspinia-master/HTML5_Full_Version/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="inspinia-master/HTML5_Full_Version/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="inspinia-master/HTML5_Full_Version/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="inspinia-master/HTML5_Full_Version/css/animate.css" rel="stylesheet">
    <link href="inspinia-master/HTML5_Full_Version/css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>



    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                "ajax": "fetch_users.php",
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "surname" },
                    { "data": "email" },
                    { "data": "adress" },
                    { "data": "role" },
                    { "data": "birthday" },
                ]
            });
        });
    </script>

</head>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                            <span class="block m-t-xs font-bold">Admin</span>
                        </a>

                    </div>

                </li>
                <li>
                    <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Users</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">

                    </ul>
                </li>



            </ul>
                </li>



            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">

                    </form>
                </div>


            </nav>
        </div>
        <table id="userTable" class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Address</th>
                <th>Role</th>
                <th>Birthday</th>

            </tr>
            </thead>

        </table>

            </div>



        </div>

        <div class="footer">
            <div class="float-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2018
            </div>
        </div>
    </div>



</div>
<!-- Mainly scripts -->
<script src="inspinia-master/HTML5_Full_Version/js/popper.min.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/bootstrap.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="inspinia-master/HTML5_Full_Version/js/plugins/flot/jquery.flot.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="inspinia-master/HTML5_Full_Version/js/plugins/peity/jquery.peity.min.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="inspinia-master/HTML5_Full_Version/js/inspinia.js"></script>
<script src="inspinia-master/HTML5_Full_Version/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="inspinia-master/HTML5_Full_Version/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="inspinia-master/HTML5_Full_Version/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="inspinia-master/HTML5_Full_Version/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="inspinia-master/HTML5_Full_Version/js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="inspinia-master/HTML5_Full_Version/js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<script src="inspinia-master/HTML5_Full_Version/js/plugins/toastr/toastr.min.js"></script>


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
