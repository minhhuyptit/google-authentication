<!-- PHP Class for handling Google Authenticator 2-factor authentication -->
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'html/head.php'; ?>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Google Authenticator</h1>
        <div class="col-md-12">
           
            <div class="modal-dialog" style="margin-bottom:0">
                <div class="modal-content">
                    <div class="panel-heading">
                        <h3 class="panel-title">Verify</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                            include_once 'autoload.php';

                            $ga = new GoogleAuthenticator();

                            echo "<pre>";
                            print_r($ga);
                            echo "</pre>";
                            
                            // 1. Create Secret
                            echo $secret = $ga->createSecret();

                            // 2. Create Image
                            $secretCode = "PTM6QXK3YXZJAANN";
                            $qrCodeUrl  = $ga->getQRCodeGoogleUrl("minhhuy97@gmail.com", $secretCode, 'Demo 2FA Code');
                            echo $imgCode    = '<img src="' . $qrCodeUrl . '" />';

                            // 3. Verify Code
                            $content    = "";
                            $type       = "";
                            if(!empty($_POST['submit'])) {
                                $checkResult = $ga->verifyCode($secretCode, $_POST['code']);
                                if($checkResult) {
                                    $content = "Mã code nhập chính xác";
                                    $type    = "success";
                                }else{
                                    $content = "Mã code nhập không chính xác";
                                    $type    = "error";
                                }
                            }
                        ?>

                        <?php echo HTMLHelper::showMessage($content, $type)?>
                   
                        <form action="" method="POST">
                            <div class="form-group">
                                <input class="form-control" type="text" name="code"/>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'html/script.php'; ?>
</body>
</html>