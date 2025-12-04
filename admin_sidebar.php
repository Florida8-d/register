<?php

require_once "config.php";

if ($_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
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



<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="images/admin_img.jpg"/  style="width:50px; height:50px; object-fit: cover;">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                        <span class="text-muted text-xs block">
                            <?php echo $_SESSION['user']['name']; ?>

                            <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="profile.html">Profile</a></li>
                        <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                        <li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="active">
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Users</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">


                </ul>
            </li>
            <li>
                <a href="layouts.html"><i class="fa fa-diamond"></i> <span class="nav-label">Layouts</span></a>
            </li>
        </ul>
    </div>
</nav>