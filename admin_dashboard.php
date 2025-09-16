<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>座位管理</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form id="form" novalidate="novalidate" method="post">
        <nav class="navbar">
            <div class="navbar-container">
                <a href="admin_dashboard.php" id="dashboard">座位管理</a>
                <a href="date_management.php" id="management">日期設定</a>
                <a href="logout.php" id="logout">登出</a>
            </div>
        </nav>
    </form>

    <div class="seat-management-container">
        <h2>座位管理</h2>

        <div id="seatInfoContainer">
            <?php
            // 載入資料庫連線設定
            require_once(__DIR__ . '/dbconfig.php');

            // 啟動 Session
            session_start();

            // 檢查使用者是否已登入
            if(!isset($_SESSION["loggedin"])){
                header("location: ./login.php");
                exit;
            }

            // 構建 SQL 查詢
            $sql = "SELECT DISTINCT date FROM seat ORDER BY date";
            // 執行查詢
            $result = $conn->query($sql);

            // 檢查是否有結果
            if ($result->num_rows > 0) {
                // 遍歷日期
                while($row = $result->fetch_assoc()) {
                    $date = $row["date"];
                    // 顯示日期
                    echo "<h3>日期: $date</h3>";

                    // 構建子查詢
                    $sub_sql = "SELECT * FROM seat WHERE date = '$date'";
                    $sub_result = $conn->query($sub_sql);

                    // 檢查子查詢結果
                    if ($sub_result->num_rows > 0) {
                        // 顯示座位資訊
                        echo '<div class="table-container">';
                        echo '<table>';
                        echo '<tr><th>座位編號</th><th>插座狀態</th><th>狀態</th></tr>';
                        while($sub_row = $sub_result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $sub_row["seat_num"] . '</td>';
                            echo '<td><select class="socket-status-select" data-seat-id="' . $sub_row["seat_id"] . '">
                            <option value="1" ' . ($sub_row["socket"] ? "selected" : "") . '>可用</option>
                            <option value="0" ' . (!$sub_row["socket"] ? "selected" : "") . '>不可用</option>
                        </select></td>';
                            echo '<td><select class="seat-status-select" data-seat-id="' . $sub_row["seat_id"] . '">
                            <option value="1" ' . ($sub_row["status"] ? "selected" : "") . '>可借用</option>
                            <option value="0" ' . (!$sub_row["status"] ? "selected" : "") . '>使用中</option>
                        </select></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '</div>';
                    } else {
                        // 如果沒有座位資訊，輸出相應消息
                        echo '<p class="no-seats-info">目前無座位資訊</p>';
                    }
                }
            } else {
                // 如果沒有結果，輸出相應消息
                echo '<p class="no-seats-info">目前無座位資訊</p>';
            }

            // 關閉資料庫連線
            $conn->close();
            ?>
        </div>
        
        <!-- 更新按鈕放在這裡 -->
        <button id="updateDataButton">更新資料</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="admin_dashboard.js"></script>

</body>
</html>
