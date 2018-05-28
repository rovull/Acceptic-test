<?php
error_reporting( E_ERROR );
require_once 'global.inc.php';
//initialize php variables used in the form
$form_name = "";
$form_email = "";
$form_pswd1 = "";
$form_pswd2 = "";
$name_exist = "";
$email_exist="";
$email_err="";
$pasw_err_match="";
$pasw_err="";
//echo 'Текущая версия PHP: ' . phpversion();

//check to see that the form has been submitted
if(isset($_POST["create_user"])) {

    //retrieve the $_POST variables
    $username = trim($_POST['form_name']);
    $email = trim($_POST['form_email']);
    $password =trim($_POST['form_pswd1']);
    $password_confirm = trim($_POST['form_pswd2']);
    //initialize variables for form validation
    $success = true;

    //validate that the form was filled out correctly
    //check to see if user name already exists
    if($user_tools->checkUsernameExists($username))    {
        $name_exist  = "К сожалению, логин уже занят!";
        $success = false;
    }
    //check to see if email already exists
    if($user_tools->checkEmailExists($email)) {
        $email_exist  = "К сожалению, почта уже занята!";
        $success = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {// filters a variable with a specified filter
        $email_err = "Неправильный формат почты!";
        $success = false;
    }
    //Check to see if passwords match
    if($password != $password_confirm) {
        $pasw_err_match = "Пароль не соответсвует!";
        $success = false;
    }
    if(mb_strlen($password)!=6){ //gets the length of the string
        $pasw_err = "Пароль должен содержать 6 символов!";
        $success = false;
    }

    if($success) {
        //prep the data for saving in a new user object
        $data['us_login'] = $username;
        $data['us_email'] = $email;
        $data['us_encoded_pasw'] = password_hash($password, PASSWORD_DEFAULT); //encrypt the password for storage
        //create the new user object
        $new_user = new User($data);
        //save the new user to the database
        $new_user->save('false');
        $db = new DB();
        $active = $db->select("user","login = '$username'");
//        var_dump($active);
        $id_active = $active["id"];
        $activation = md5($id_active);
        $subject = "Подтверждение регистрации";
        $message = "Здравствуйте! Спасибо за регистрацию !\nВаш логин: ".$username."\n Перейдите по ссылке, чтобы активировать ваш аккаунт:\n
http://localhost/Login_form/www/activation_user.php".$username."&activation=".$activation."\n\n";
        //automatically sends the message
        mail($email, $subject, $message, "Content-type:text/plain; Charset=windows-1251\r\n");
       header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration form</title>
    <link rel="stylesheet" href="lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="lib/css/style.css">
</head>
<body>
<header class="container-fluid">
</header>

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

<div class="container registr">
    <form class="form-signin" method="post" action="" id="js-register-form" >
        <div class="message js-form-message"></div>
        <div class="form-group">
            <h4 class="form-signin-heading">Пожалуйста, введите данные</h4>
            <div class="form-group">
                <input type="text" class="form-input input-block-level" placeholder="Логин" name="form_name" value="<?php echo $form_name;?>" required>
                <p class="error" id="result"><?php echo $name_exist?></p>
            </div>
            <div class="form-group">
                <input type="text" class="form-input input-block-level" placeholder="Почта" name="form_email" value="<?php echo $form_email;?>" required>
                <p class="error"><?php echo $email_err, $email_exist?></p>
            </div>
            <div class="form-group">
                <input type="password" class="form-input input-block-level" placeholder="Пароль" name="form_pswd1" id="form_pswd1" value="<?php echo $form_pswd1;?>" required>
                <span class="error"><?php echo $pasw_err?></span>
            </div>
            <div class="form-group">
                <input type="password" class="form-input input-block-level" placeholder="Подтвердите пароль" name="form_pswd2" value="<?php echo $form_pswd2;?>" required>
                <p class="error"><?php echo $pasw_err,$pasw_err_match?></p>
            </div>
            <button class="btn btn-large btn-default" type="submit" name="create_user">Зарегистрироваться</button>
            <a href="index.php">Войти</a>
        </div>
    </form>
</div>

<footer class="footer navbar-fixed-bottom">
    <div class="container">
        <p>Test task for Acceptic</p>
    </div>
</footer>


<script src="lib/js/jquery/dist/jquery.min.js"></script>
<script src="lib/js/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="lib/js/custom.js"></script>
<script src="lib/js/bootstrap.min.js"></script>

</body>
</html>