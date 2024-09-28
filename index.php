<?php

use common\Transaction;
use common\User;

include("connect.inc.php");
include "common/Transaction.php";
require_once "common/User.php";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>Small Bank</title>
</head>

<body>
    <div class="container">
        <div class="nav">
            <?php
            if (!isset($_SESSION['user_id'])) {
                echo "<a href='form/login.php'>SIGN UP / LOG IN</a>";
            } else {
                $user = new User($conn, $_SESSION['user_id']);
                echo "<div class='dropdown'>";
                echo "<a href='#' class='dropbtn'>Profile</a>";
                echo "<div class='dropdown-content'>";
                echo "<a href='form/setting.php'>Setting</a>";
                echo "<a href='action/logout.php'>Logout</a>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
        <div class="frame"></div>
        <div class="containerLR">
            <div class="left">
                <div class="profile">
                    <div class="profile-image" style="background-image: url('<?php echo $user->getProfile(); ?>');"></div>
                </div>
                <div class="balance">
                    <div class="name">
                        <div class="current">
                            <h3>Balance</h3>
                            <p>Avalible</p>
                        </div>
                        <div class="username">
                            <?php
                            if (!empty($_SESSION['user_id'])) {
                                echo "<h3>" . $_SESSION['username'] . "</h3>";
                            } else
                                echo "";
                            ?>
                        </div>
                    </div>
                    <span class="line"></span>
                    <div class="wallet">
                        <?php
                        if (!empty($_SESSION['user_id'])) {
                            $id = $_SESSION['user_id'];
                            $user = new User($conn, $id);
                            echo "<h1>฿ " . $user->getWalletBalance() . "</h1>";
                        }
                        ?>
                        <span class="line"></span><br>
                        <h1>P:0</h1>
                    </div>
                </div>
                <div class="option">
                    <button onclick="window.location.href='form/deposit.php';">ฝากเงิน</button>
                    <button onclick="window.location.href='form/withdraw.php';">ถอน</button>
                    <button onclick="window.location.href='form/transfer.php';">โอนเงิน</button>
                </div>
            </div>
            <div class="right">
                <div class="transaction">
                    <?php
                    if (!empty($_SESSION['user_id'])) {
                        $transaction = new Transaction($conn, $_SESSION['user_id']);
                        $transactionData = $transaction->getTransactionByUserId($_SESSION['user_id']);
                        // ตรวจสอบว่ามีธุรกรรมหรือไม่
                        if (!empty($transactionData)) {
                            echo "<table border='1'>";
                            echo "<tr>
                        <th>Transaction ID</th>
                        <th>User ID</th>
                        <th>Transaction Type ID</th>
                        <th>Amount</th>
                        <th>Fee</th>
                        <th>Recipient User ID</th>
                        <th>Created At</th>
                      </tr>";

                            // ใช้ foreach เพื่อแสดงข้อมูลธุรกรรม
                            foreach ($transactionData as $transaction) {
                                echo "<tr>
                            <td>{$transaction['transaction_id']}</td>
                            <td>{$transaction['user_id']}</td>
                            <td>{$transaction['transaction_type_id']}</td>
                            <td>{$transaction['amount']}</td>
                            <td>{$transaction['fee']}</td>
                            <td>{$transaction['recipient_user_id']}</td>
                            <td>{$transaction['created_at']}</td>
                          </tr>";

                            }

                            echo "</table>";
                        } else {
                            echo "ไม่มีข้อมูลธุรกรรม";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>