<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>我的預約</title>
    <!-- 引入 jQuery 庫 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
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

    // 取得目前使用者的會員ID
    $memberId = $_SESSION["memberId"];

    // 準備查詢資料庫，取得使用者今天的預約資訊
    $sql = "SELECT * FROM reservation WHERE username = ? AND date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $memberId, $today);
    $stmt->execute();
    $result = $stmt->get_result();

    // 檢查是否有預約紀錄
    if ($result->num_rows > 0) {
        // 有預約紀錄，顯示預約資訊
        echo "<table>";
        echo "<tr><th>預約日期</th><th>預約時間</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["date"]. "</td>";
            echo "<td>" . $row["start_time"]. "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // 沒有預約紀錄，顯示訊息
        echo '<div class="no-records-message">今日無預約紀錄</div>';
    }

    // 釋放資料庫查詢結果及關閉連線
    $stmt->close();
    $conn->close();
    ?>

    <!-- 引入 JavaScript 文件 -->
    <script src="user_dashboard.js"></script>
</body>
</html>
