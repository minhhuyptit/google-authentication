<?php 
    $flagLogin = true;
    if(empty($_SESSION['email'])) $flagLogin = false;

   $currentFile = pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME);

    $menus = [
        'login'     => ['name' => 'Login', 'link' => 'login.php', 'class' => ''],
        'register'  => ['name' => 'Register', 'link' => 'register.php', 'class' => ''],
        'setting'   => ['name' => 'Setting', 'link' => 'setting.php', 'class' => ''],
        'logout'    => ['name' => 'Logout', 'link' => 'logout.php', 'class' => ''],
    ];

    if($flagLogin) {
        unset($menus['login']);
        unset($menus['register']);
    }else{
        unset($menus['setting']);
        unset($menus['logout']);
    }

    $xhtmlMenu = '<ul class="nav navbar-nav">';
    foreach($menus as $key => $menu){
        if($key == $currentFile) $menu['class'] = "active";
        $xhtmlMenu .= '<li class="'.$menu['class'].'"><a href="'.$menu['link'].'">'.$menu['name'].'</a></li>';  
    }
    $xhtmlMenu .= '</ul>';  

   
?>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Demo Google Authenticator</a>
        </div>
        <?php echo $xhtmlMenu; ?>
    </div>
</nav>

