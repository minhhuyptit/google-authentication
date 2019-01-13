<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'html/head.php'; ?>
</head>
<body>
    <?php
        include_once 'autoload.php';

        $msg     = "";
        $type    = "";
        
        if(!empty($_POST['submit'])) {
            $fullName   = $_POST['fullName'];
            $email      = $_POST['email'];
            $password   = md5($_POST['password']);

            if(!empty($fullName) && !empty($email) && !empty($password)) {

                $data       = json_decode(file_get_contents(DATA_USER), true);
                 
                if(!empty($data[$email])) {
                    $msg     = "Email is exsist";
                    $type    = "error";
                }else {
                    $ga = new GoogleAuthenticator();
                    $secret = $ga->createSecret();

                    $data[$email]["email"]      = $email;
                    $data[$email]["password"]   = $password;
                    $data[$email]["fullName"]   = $fullName;  
                    $data[$email]["secret"]     = $secret;
                    $data[$email]["setting"]     = "init";

                    file_put_contents(DATA_USER, json_encode($data));
                    $msg     = "Register successfully. Please access <a href='index.php'>here</a> to redirect page login";
                    $type    = "success";
                }
            }else {
                $msg     = "Please enter full information";
                $type    = "error";
            }
        }
    ?>
    <?php include_once 'html/nav.php'; ?>

    <div class="container">
        <h1 class="text-center">Register</h1>
        <div class="col-md-12">
            <div class="modal-dialog" style="margin-bottom:0">
                <div class="modal-content">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <?php echo HTMLHelper::showMessage($msg, $type)?>
                        <form action="" method="POST" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Full Name" name="fullName" type="text" value="">
                                </div>
                                <input name="submit" type="submit" value="Register" class="btn btn-primary">
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'html/script.php'; ?>
</body>
</html>