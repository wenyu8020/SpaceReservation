<?php
    // 載入資料庫連線設定
    require_once(__DIR__ . '/dbconfig.php');
    // SMTP Configs and Functions
    require_once(__DIR__.'/func_sendemail_sample.php');

    // 啟動 Session
    session_start();

    // 檢查使用者是否已登入
    if(!isset($_SESSION["loggedin"])){
        header("location: ./login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>預約紀錄</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form id="form" novalidate="novalidate" method="post">
        <nav class="navbar">
            <div class="navbar-container">
                <a href="user_dashboard.php" id="dashboard">我的預約</a>
                <a href="seat_info.php" id="seat">座位查詢</a>
                <a href="reservation_records.php" id="records">預約紀錄</a>
                <a href="logout.php" id="logout">登出</a>
            </div>
        </nav>
    </form>
    <div class="username" style="display: none;"><?php echo $_SESSION["memberId"]; ?></div>
    <?php
    // 擷取所有預約紀錄
    $sql = "SELECT r.resv_id, s.seat_num, r.date, r.start_time, r.end_time 
    FROM reservation r
    INNER JOIN seat s ON r.seat_id = s.seat_id
    ORDER BY r.date DESC"; // 按日期降序排列

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="reservation-records-container">';
        echo '<h2>預約紀錄</h2>';
        echo '<table>';
        echo '<tr><th>預約編號</th><th>座位編號</th><th>預約日期</th><th>起始時間</th><th>結束時間</th><th>取消預約</th></tr>';
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["resv_id"] . '</td>';
            echo '<td>' . $row["seat_num"] . '</td>';
            echo '<td>' . $row["date"] . '</td>';
            echo '<td>' . $row["start_time"] . '</td>';
            echo '<td>' . $row["end_time"] . '</td>';
            echo '<td><button class="cancelButton" data-reservation-id="' . $row["resv_id"] . '">取消</button></td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p class="no-records-message">目前無預約紀錄</p>';
    }

    // 如果收到有效的 POST 請求
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 檢查是否收到預約 ID
        if (isset($_POST["reservationId"]) && isset($_POST["user_name"])) {
            // 獲取預約 ID
            $reservationId = $_POST["reservationId"];
            $userName = $_POST['user_name'];
            echo '<script>console.log("'.$reservationId.'");</script>';

            $sql1 = "SELECT name, email FROM user WHERE username = '$userName'";
            $result1 = $conn->query($sql1);
            
            $row1 = $result1->fetch_assoc();
            $email = $row1['email'];
            $name = $row1['name'];
    
            // Email Configs
            $email_sender_email    = "sandy3809@gmail.com";
            $email_sender_name     = "admin";
            $email_recipient_email = $email;
            $email_recipient_name  = $name;
            $email_subject      = "Study Room Reservation Cancellation Notice";
            $email_body         = "已成功取消自習室預約！<br/><br/>來自 自習室預約系統";
    
            $msg = '';
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $status_email = sendemail_sample($email_sender_email, $email_sender_name, $email_recipient_email, $email_recipient_name, $email_subject, $email_body);
                $msg = '<h2>Email寄送狀態：</h2><p>'.$status_email.'</p>';
            }    

            // 構建 SQL 查詢來刪除預約記錄
            $sql_delete = "DELETE FROM reservation WHERE resv_id = ?";
            $stmt = $conn->prepare($sql_delete);
            $stmt->bind_param("i", $reservationId);


            if ($stmt->execute()) {
                // 如果成功刪除預約記錄，返回成功消息
                echo "<script>alert('預約已成功取消！');</script>";
            } else {
                // 如果刪除失敗，返回錯誤消息
                echo "<script>alert('取消預約失敗，請稍後再試。');</script>";
            }

            // 關閉預備語句
            $stmt->close();
        }
    }

    // 關閉資料庫連線
    $conn->close();
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="user_dashboard.js"></script>

</body>
</html>
