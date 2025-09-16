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

// 假設 $conn 是你的資料庫連線物件

// 檢查是否收到所需的 POST 資訊
if(isset($_POST['user_name']) && isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['period']) && isset($_POST['seat_num']) && isset($_POST['date'])) {
    // 接收 POST 資訊
    $userName = $_POST['user_name'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $period = $_POST['period'];
    $seatNum = $_POST['seat_num'];
    $date = $_POST['date'];

    // 在此處將資訊插入到資料庫中
    // 執行一個 INSERT INTO 語句來將訂位資訊插入到 reservation 表中

    // 根據 seat_num 查詢對應的 seat_id
    $sql = "SELECT seat_id FROM seat WHERE seat_num = '$seatNum' AND date = '$date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // 如果找到對應的 seat_id，則取得該值
        $row = $result->fetch_assoc();
        $seatId = $row['seat_id'];

        // 將資訊插入到 reservation 表中
        $conn->query("INSERT INTO reservation (username, seat_id, date, start_time, end_time, period) VALUES ('$userName', $seatId, '$date', '$startTime', '$endTime', '$period')");

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
        $email_subject      = "Study Room Appointment Notice";
        $email_body         = "已成功預約自習室！<br/><br/>來自 自習室預約系統";

        $msg = '';
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $status_email = sendemail_sample($email_sender_email, $email_sender_name, $email_recipient_email, $email_recipient_name, $email_subject, $email_body);
            $msg = '<h2>Email寄送狀態：</h2><p>'.$status_email.'</p>';
        }


        // 如果成功插入資料，回傳成功訊息
        echo "預約成功";
    } else {
        // 如果找不到對應的 seat_id，返回錯誤訊息
        echo "無法找到相應的座位";
    }
} else {
    // 如果缺少資訊，返回錯誤訊息
    echo "缺少必要資訊";
}

// 最後，關閉資料庫連線
$conn->close();
?>
