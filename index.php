<?php

use common\Wallet;

include "common/Wallet.php";
include("connect.inc.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/index.css">
    <title>Small Bank</title>
</head>
<body>
    <div class="container2">
        <div class="nav">
           <?php
           if(!empty($_SESSION['user_id'])){
               echo "<a href='action/logout.php'>logout</a>";
           }else{
               echo "<a href='form/login.php'>login</a>";
           }
           ?>
        </div>
    </div>
    <div class="container">
        <div class="balance">
            <div class="name">
                <?php
                if(!empty($_SESSION['user_id'])){
                    echo "<H1>".$_SESSION['username']."</H1>";
                }else echo "<h1>Welcome</h1>";
                ?>
            </div>
            <div class="wallet">
                <?php
                    if(!empty($_SESSION['user_id'])){
                        $id = $_SESSION['user_id'];
                        $wallet = new Wallet($conn, $id);
                        echo "<h1>" . $wallet->getBalance() . "</h1>";
                    }
                ?>
            </div>
            <?php
                if(!empty($_SESSION['user_id'])){
                    echo "<a href='action/getIframe.php?id=1'>ฝากเงิน</a><a href='action/getIframe.php?id=2'>ถอนเงิน</a>";
                }
            ?>
        </div>
        <div class="quick">
            <div class="name">
            <?php
                if(!empty($_SESSION['nameIframe'])){
                    echo "<h1>".$_SESSION['nameIframe']."</h1>";
                }else echo "";
            ?>
            </div>
            <iframe src="<?php if(empty($_SESSION['page'])){echo "";}else {echo $_SESSION['page'];}?>" frameborder="0"></iframe>
        </div>
        <div class="transac"></div>
    </div>
</body>
</html>
