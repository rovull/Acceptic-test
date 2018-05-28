<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User information</title>
    <link rel="stylesheet" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/css/user_inf.css">
</head>
<body>
<header class="container-fluid">
</header>
<?php
error_reporting( E_ERROR );
require_once 'global.inc.php';


    if(!isset($_SESSION['logged_in'])) {
        header("Location: index.php");}
        //take user object from session
        $user = unserialize($_SESSION['user']);
        // echo $user->username;
         $db = new DB();
         $id = $user->id;
        $row = $db->select('user', "id = $id");
        $user = $row["login"];
        $name = $row["name"];
        $education = $row["education"];
        $address = $row["address"];
        $phone = $row["phone"];

        if($_POST) {
            $name_us=trim($_POST["name"]);
            $education_us=trim($_POST["education"]);
            $address_us = trim($_POST["address"]);
            $phone_us = trim($_POST["phone"]);
            $data = array(
                "name" => "'$name_us'",
                "education" => "'$education_us'",
                "address" => "'$address_us'",
                "phone" => "'$phone_us'"
            );
            $db->update($data, 'user', "id = $id");
            header("Location: user_information.php");
        }


?>
<nav class="navbar navbar-inverse">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><span class="text-center"></span> Site</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="user_information.php">Персональная информация</a></li>
                <li><a href="logout.php">Выйти</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<main class="container">
    <section class="row">
        <div class="col-md-12 well">
            <h3 class="text-left" id="name"> Приветствую, <?php echo $user;?></h3>
            <pre class="text-left"> Имя: <?php echo $name;?> </pre>
            <pre class="text-left"> Образование: <?php echo $education;?> </pre>
            <pre class="text-left"> Адрес: <?php echo $address;?></pre>
            <pre class="text-left"> Телефон:<?php echo $phone;?> </pre>
            <button class="btn btn-success edit" type="button" data-toggle="modal" data-target="#myModal" id="go">Редактировать</button>
        </div>
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
                        <h4 class="modal-title">Редактировать данные</h4>
                    </div>
                    <div class="modal-body text-center">
                        <form  method="post" class="form-signin form-group" action="user_information.php"  id="formx">
                            <div class="form-group">
                                 <input type="text"  name="name" placeholder="Имя" value="<?php echo $name;?>" class="form-input input-block-level"/>
                                </div>
                            <div class="form-group">
                            <input type="text" name="education" placeholder="Образование" value="<?php echo $education;?>" class="form-input input-block-level" />
                                </div>
                            <div class="form-group">
                            <input type="text" name="address" placeholder="Адрес" value="<?php echo $address;?>" class="form-input input-block-level"/>
                                </div>
                            <div class="form-group">
                            <input type="text" name="phone" placeholder="Телефон" value="<?php echo $phone;?>" class="form-input input-block-level"/>
                                </div>
                            <div class="submit">
                             <button  class="btn btn-success" type="submit" name="edit" id="edit">Редактировать</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="footer navbar-fixed-bottom">
  <div class="container">
      <p>Test task for Acceptic</p>
  </div>
</footer>

<script src="lib/js/jquery/dist/jquery.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
<script src="lib/js/ajax_go_edit.js"></script>

</body>
</html>