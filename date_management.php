<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>日期設定</title>
    <!-- 引入 jQuery 庫 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <form id="form" novalidate="novalidate" method="post">
        <nav class="navbar">
            <div class="navbar-container">
                <a href="admin_dashboard.php" id="dashboard">座位管理</a>
                <a href="date_management.php" id="manage">日期設定</a>
                <a href="logout.php" id="logout">登出</a>
            </div>
        </nav>
    </form>

    <?php
    // 載入資料庫連線設定
    require_once(__DIR__ . '/dbconfig.php');

    // 啟動 Session
    session_start();

    // 檢查使用者是否已登入，如果不是管理員，將其導向登錄頁面
    if (!isset($_SESSION["loggedin"])) {
        header("location: ./login.php");
        exit;
    }

    // 檢查表單提交
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 獲取表單提交的不可借用日期
        $date = $_POST['date'];

        // 檢查日期是否已存在於資料庫中
        $sql = "SELECT * FROM uadate WHERE uadate = '$date'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<script>alert('日期 $date 已經存在於不可借用日期列表中。');</script>";
        } else {
            // 插入新的不可借用日期到資料庫
            $insert_sql = "INSERT INTO uadate (uadate) VALUES ('$date')";
            if ($conn->query($insert_sql) === TRUE) {
                echo "<script>alert('不可借用日期 $date 已成功添加。');</script>";
            } else {
                echo "Error: " . $insert_sql . "<br>" . $conn->error;
            }
        }
    }
    ?>


    <h2>設定不可借用日期</h2>
    <form method="post">
        <label for="date">選擇不可借用日期:</label>
        <input type="date" id="date" name="date" required>
        <button type="submit">新增</button>
    </form>

    <!-- 引入 JavaScript 文件 -->
    <script src="user_dashboard.js"></script>
</body>
</html>
