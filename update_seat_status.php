<?php
// 在 update_seat_status.php 中

// 載入資料庫連線設定

require_once(__DIR__ . '/dbconfig.php');

// 檢查是否有 POST 請求
if(isset($_POST['seatUpdates'])) {
    // 解析 POST 數據
    $seatUpdates = json_decode($_POST['seatUpdates'], true);

    // 遍歷座位更新數組
    foreach ($seatUpdates as $update) {
        $seatId = $update['seatId'];
        $socketStatus = $update['socketStatus'];
        $seatStatus = $update['seatStatus'];

        // 執行更新操作（這裡是一個示例，你需要根據你的應用程序邏輯進行更新）
        $sql = "UPDATE seat SET socket = '$socketStatus', status = '$seatStatus' WHERE seat_id = '$seatId'";
        if ($conn->query($sql) === TRUE) {
            // 如果更新成功，你可以返回一些成功的消息，如果不需要，可以省略
            echo "座位狀態更新成功";
        } else {
            // 如果更新失敗，返回錯誤消息
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    // 如果未提供足夠的參數，返回錯誤消息
    echo '請提供座位更新數據';
}

// 關閉資料庫連線
$conn->close();
?>
