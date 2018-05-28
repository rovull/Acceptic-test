<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form</title>
    <link rel="stylesheet" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/css/style.css">
</head>
<body>
<header class="container-fluid">
</header>
<?php
error_reporting( E_ERROR );
require_once 'global.inc.php';
//initialization of the variables
$form_login = "";
$form_password = "";
$email_err="";
$pasw_err="";


if(isset($_POST["enter_form"])) {
    //retrieve the $_POST variables
    $login = trim($_POST['form_login']);
    $password = trim($_POST['form_password']);
    //initialize variables for form validation
    $success = true;

   if (mb_strlen($password) != 6) { //gets the length of the string
        $pasw_err = "Пароль должен содержать 6 символов!";
        $success = false;
   }
   if ($success) {
       //$user_tools = new User_tools();
       if ($user_tools->login($login, $password)) {
           //удачный вход, редирект на страницу
           header("Location: user_information.php");
       } else {
           $error = "Неправильный логин или пароль! Попробуйте еще раз";
       }
   }
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
                <li><a href="index.php">Войти</a></li>
                <li><a href="registr.php">Регистрация</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<main class="container-fluid enter">
    <form class="form-signin" action="index.php" method="post"">
        <h4 class="form-signin-heading">Пожалуйста, войдите</h4>
        <input type="text" class="input-block-level" placeholder="Логин" name="form_login" value="<?php echo $form_login;?>" required>
        <input type="password" class="input-block-level" placeholder="Пароль" name="form_password" value="<?php echo $form_password;?>" required>
        <span class="error"><?php echo $pasw_err?></span>
        <div class="row">
            <button class="btn btn-large btn-default enter" type="submit" name="enter_form">Войти</button>
            <a href="registr.php">Зарегистрироваться</a>
        </div>
    </form>
</main>

<footer class="footer navbar-fixed-bottom">
    <div class="container">
        <p >Test task for Acceptic </p>
    </div>
</footer>

    <script src="lib/js/jquery/dist/jquery.min.js"></script>
    <script src="lib/js/custom.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
</body>
</html>