<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>座位查詢</title>
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
    <div class="date-picker-container">
        <input type="date" id="datePicker">
        <button id="searchButton">查詢</button>
    </div>

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

            // 檢索座位資訊
            $date = date("Y-m-d"); // 預設日期為今天
            if (isset($_GET['date'])) {
                $date = $_GET['date'];
            }

            // 取得所選日期
            $selectedDate = $date;

            // 計算30天後的日期
            $thirtyDaysLater = date("Y-m-d", strtotime("+30 days"));

            // 檢查所選日期是否在30天內
            if (strtotime($selectedDate) > strtotime($thirtyDaysLater)) {
                // 如果所選日期在30天後，則顯示錯誤訊息並停止處理
                echo '<script>alert("所選日期必須在30天內！");</script>';
                exit;
            }
            else if (strtotime($selectedDate) <= strtotime($thirtyDaysLater)) {
                // 檢查所選日期是否為不可借用日期
                $sql1 = "SELECT * FROM uadate WHERE uadate = '$date'";
                $result1 = $conn->query($sql1);

                if ($result1->num_rows > 0) {
                    // 如果所選日期在不可借用日期列表中，則顯示錯誤訊息並停止處理
                    echo '<script>alert("所選日期不可借用！");</script>';
                    exit;
                }
                else {
                    $sql = "SELECT * FROM seat WHERE date = '$date'";
                    $result = $conn->query($sql);                
    
                    if ($result->num_rows > 0) {
                        echo '<div class="table-container">';
                        echo '<table>';
                        echo '<tr><th>座位編號</th><th>插座狀態</th><th>狀態</th><th>預約</th></tr>';
                        while($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["seat_num"] . '</td>';
                            echo '<td>' . ($row["socket"] ? "可用" : "不可用") . '</td>';
                            echo '<td>' . ($row["status"] ? "可借用" : "使用中") . '</td>';
                            echo '<td>';
                            // 檢查座位是否可預約，如果不可預約，則添加 disabled 屬性
                            if ($row["status"]) {
                                echo '<button class="reserveButton" data-seat-id="' . $row["seat_num"] . '">預約</button>';
                            } else {
                                echo '<button class="reserveButton" data-seat-id="' . $row["seat_num"] . '" disabled>不可預約</button>';
                            }
                            echo '</td>';
                            echo '</tr>';                    
                        }
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo '<p class="no-seats-info">目前無座位資訊</p>';
                    }
                }
    
            }

        ?>    
    </div>

    <!-- 自定義模態框 -->
    <div id="myModal" class="modal">
        <!-- 模態框內容 -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>請選擇預約的時段：</p>
            <!-- 預約時段的下拉式選單 -->
            <form id="timeSlotsForm">
                <div class="select-container">
                    <!-- 起始時間下拉框 -->
                    <select id="startTimeSelect" name="startTime">
                        <?php
                            // 查詢已預約的時段
                            $sql_reserved = "SELECT start_time, end_time FROM reservation WHERE date = '$selectedDate'";
                            $result_reserved = $conn->query($sql_reserved);

                            $reservedSlots = array();

                            if ($result_reserved->num_rows > 0) {
                                // 如果有已預約的時段，將其加入到 $reservedSlots 陣列中
                                while($row = $result_reserved->fetch_assoc()) {
                                    $reservedSlots[] = array(strtotime($row['start_time']), strtotime($row['end_time']));
                                }
                            }

                            $dayOfWeek = date("w", strtotime($selectedDate)); // 取得星期幾

                            // 設置起始時間和結束時間
                            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // 平日
                                $startTime = strtotime("08:00");
                                $endTime = strtotime("23:00");
                            } else { // 假日
                                $startTime = strtotime("09:00");
                                $endTime = strtotime("17:00");
                            }

                            $interval = 60 * 60;

                            // 生成起始時間選項
                            for ($i = $startTime; $i < $endTime; $i += $interval) {
                                $timeStr = date("H:i", $i);
                                $disableOption = false;
                                if (sizeof($reservedSlots)) {
                                    for ($j = 0; $j < sizeof($reservedSlots); $j += 1){
                                        if ($reservedSlots[$j][0] <= $i && $reservedSlots[$j][1] > $i) {
                                            $disableOption = true;
                                            break;
                                        }
                                    }
                                }
                                if ($disableOption) {
                                    echo '<option value="' . $timeStr . '" disabled>' . $timeStr . '</option>';
                                } else {
                                    echo '<option value="' . $timeStr . '">' . $timeStr . '</option>';
                                }
                            }
                        ?>
                    </select>
                    <!-- 結束時間下拉框 -->
                    <select id="endTimeSelect" name="endTime">
                        <?php
                            // 生成結束時間選項，確保不早於起始時間
                            for ($i = $startTime + $interval; $i <= $endTime; $i += $interval) {
                                $timeStr = date("H:i", $i);
                                $disableOption = false;
                                if (sizeof($reservedSlots)) {
                                    for ($j = 0; $j < sizeof($reservedSlots); $j += 1){
                                        if ($reservedSlots[$j][0] < $i && $reservedSlots[$j][1] >= $i) {
                                            $disableOption = true;
                                            break;
                                        }
                                    }
                                }
                                if ($disableOption) {
                                    echo '<option value="' . $timeStr . '" disabled>' . $timeStr . '</option>';
                                } else {
                                    echo '<option value="' . $timeStr . '">' . $timeStr . '</option>';
                                }
                            }
                            $conn->close();
                        ?>
                    </select>
                </div>
                <div class="username" style="display: none;"><?php echo $_SESSION["memberId"]; ?></div>
                <br>
                <input type="submit" value="確定預約">
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="user_dashboard.js"></script>

</body>
</html>
