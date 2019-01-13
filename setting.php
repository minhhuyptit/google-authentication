<?php
    include_once 'autoload.php';
   

    if(empty(Session::get('email'))) URL::redirect("login.php"); 
    
    $ga         = new GoogleAuthenticator();
    $email      = Session::get('email');
    $data       = json_decode(file_get_contents(DATA_USER), true);
    $userInfo   = $data[$email];
    $secretCode = $userInfo['secret'];
    $qrCodeUrl  = $ga->getQRCodeGoogleUrl("minhhuy97.ptit@gmail.com", $secretCode, 'Demo 2FA Code');

    $msg     = "";
    $type    = "";

    if(!empty($_POST['submit'])){
        if(empty($_POST['code'])) {
            $msg     = "Please enter code!";
            $type    = "error";
        }else {
            $checkResult = $ga->verifyCode($secretCode, $_POST['code']);
            if($checkResult) {
                $userInfo['setting'] = $_POST["setting"];

                if($userInfo['setting'] == "off") {
                    $userInfo['secret'] = $ga->createSecret();
                }

                $data[$email] = $userInfo;
                
                file_put_contents(DATA_USER, json_encode($data));
                $msg     = "Update successful";
                $type    = "success";
            }else{
                $msg     = "Code is not valid";
                $type    = "error";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'html/head.php'; ?>
</head>
<body>
    <?php include_once 'html/nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Image QR Code</div>
                    <div class="panel-body">
                        <?php if($userInfo["setting"] == "init" || $userInfo["setting"] == "off") { ?>
                            <div class="qr-code text-center">
                                <img src='<?php echo $qrCodeUrl; ?>' />
                            </div>
                            <div class="two-fa-code">
                                <input type="text" name="secret" id="secret" class="form-control" disabled value="<?php echo $secretCode; ?>">
                            </div>

                            <div style="margin-top:10px" class="guide">
                                <p><strong>Guide :</strong> To enable service 2 FA code you need to scan this image into app or enter secret code into app</p>
                            </div>
                        <?php } else {?>
                            <div style="margin-top:10px" class="guide">
                                <p>You had enabled 2FA Code. Should we hide image QR Code and Secret Code. </p>
                            </div>    
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Setting 2FA Code</div>
                    <div class="panel-body">
                        
                        <?php echo HTMLHelper::showMessage($msg, $type)?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="Setting">Enabled 2FA Code when login</label>
                                <div class="radio">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><input <?php echo ($userInfo["setting"] == "on" ? 'checked' : ''); ?> type="radio" name="setting" id="optionsRadios0" value="on">Yes</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label><input  <?php echo ( ($userInfo["setting"] == "off" || $userInfo["setting"] == "init") ? 'checked' : ''); ?> type="radio" name="setting" id="optionsRadios1" value="off">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Code">2FA Code</label>
                                <input type="text" name="code" class="form-control" id="2fa-code" placeholder="2FA Code">
                            </div>
                            <input type="submit" name="submit" class="btn btn-success" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'html/script.php'; ?>
</body>
</html>