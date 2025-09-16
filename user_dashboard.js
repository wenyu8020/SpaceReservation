function toggleNavbar() {
    var x = document.getElementsByClassName("navbar-container")[0];
    if (x.className === "navbar-container") {
        x.className += " responsive";
    } else {
        x.className = "navbar-container";
    }
}

// 當 DOM 加載完畢時執行
$(document).ready(function() {
    // 選擇器按鈕點擊事件處理函式
    $("#searchButton").click(function() {
        // 獲取日期選擇器的值
        var selectedDate = $("#datePicker").val();

        // 使用 localStorage 將 selectedDate 的值保存起來
        localStorage.setItem('selectedDate', selectedDate);

        // 將選擇的日期作為參數添加到 URL 中並重新導向到新 URL
        window.location.href = "seat_info.php?date=" + selectedDate;
    });

    // 預約按鈕點擊事件處理函式
    $(".reserveButton").click(function() {
        // 顯示模態框
        $("#myModal").css("display", "block");
    });

    // 監聽取消按鈕的點擊事件
    $('.cancelButton').click(function() {
        // 獲取取消按鈕上的預約 ID
        var reservationId = $(this).data('reservation-id');
        var username = document.querySelector('.username').textContent;

        // 確認用戶是否確定取消預約
        var confirmCancel = confirm('確定要取消這筆預約嗎？');

        if (confirmCancel) {
            // 發送 AJAX 請求到後端刪除預約記錄
            $.ajax({
                url: 'reservation_records.php', // 請修改為實際的後端處理腳本路徑
                type: 'POST',
                data: { 
                    reservationId: reservationId,
                    user_name: username
                 },
                success: function(response) {
                    // 處理伺服器回應，可能是成功或錯誤訊息
                    location.reload();
                }
            });
        }
    });

    // 當用戶點擊模態框上的關閉按鈕時
    $(".close").click(function() {
        // 隱藏模態框
        $("#myModal").css("display", "none");
    });

    // 當用戶點擊模態框以外的地方時
    $(window).click(function(event) {
        if (event.target == $("#myModal")[0]) {
            // 隱藏模態框
            $("#myModal").css("display", "none");
        }
    });

    const el = document.getElementById('timeSlotsForm');
    if (el) {
        el.addEventListener('submit', function(event) {
            var startTime = document.getElementById('startTimeSelect').value;
            var endTime = document.getElementById('endTimeSelect').value;
    
            if (endTime <= startTime) {
                alert('結束時間不能早於或等於開始時間！');
                event.preventDefault(); // 阻止表單提交
            }
        });
        }

    // var reserveTime = []

    // // 檢查所選的時間段是否與已預約的時間段重疊
    // function checkOverlap(selectedStartTime, selectedEndTime) {
    //     for (var i = 0; i < reserveTime.length; i++) {
    //         var reservedStartTime = reserveTime[i][0];
    //         var reservedEndTime = reserveTime[i][1];

    //         // 檢查是否有重疊
    //         if (!(selectedStartTime >= reservedEndTime || selectedEndTime <= reservedStartTime)) {
    //             // 如果時間段重疊，彈出警告訊息並停止表單的預設提交行為
    //             alert("請選擇未被預約的時段！");
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    // 表單提交事件處理函式
    $("#timeSlotsForm").submit(function(event) {
        // 阻止表單的預設提交行為
        event.preventDefault();

        var username = document.querySelector('.username').textContent;
        
        // 獲取所選的時間段
        var selectedStartTime = $("#startTimeSelect").val();
        var selectedEndTime = $("#endTimeSelect").val();

        // 將時間轉換為 JavaScript Date 對象以便計算
        var startDate = new Date('1970-01-01T' + selectedStartTime + ':00');
        var endDate = new Date('1970-01-01T' + selectedEndTime + ':00');

        // 計算時間差值（以毫秒為單位）
        var timeDiff = endDate - startDate;

        // 將時間差值轉換為小時
        var hours = timeDiff / (1000 * 60 * 60);

        // 將小時數取整
        hours = Math.round(hours);

        // 在控制台中輸出時間差值，以確認是否成功計算
        // console.log('開始時間：', selectedStartTime);
        // console.log('結束時間：', selectedEndTime);
        // console.log('時間差值（小時）：', hours);

        // 獲取所選座位的 ID
        var selectedSeatNum = $(".reserveButton").attr("data-seat-id");
        
        // 獲取日期
        // 從 localStorage 中讀取 selectedDate 的值
        var selectedDate = localStorage.getItem('selectedDate');
        // var selectedDate = $("#datePicker").val();
        console.log(selectedDate);
        
        // 使用 AJAX 發送 POST 請求
        $.ajax({
            type: "POST",
            url: "process_reservation.php", // 指向處理訂位的 PHP 腳本
            data: {
                user_name: username,
                start_time: selectedStartTime,
                end_time: selectedEndTime,
                period: hours,
                seat_num: selectedSeatNum,
                date: selectedDate
            },
            success: function(response) {
                // 處理伺服器回應，可能是成功或錯誤訊息
                alert(response); // 在此您可以根據伺服器回傳的資訊來做出相應的處理
            }
        });
        
        // 檢查所選的時間段是否與已預約的時間段重疊
        // var overlap = checkOverlap(selectedStartTime, selectedEndTime);
        // if (!overlap) {
        //     // 如果時間段重疊，則阻止表單的預設提交行為
        //     event.preventDefault();
        // }
        // else {
        //     reserveTime.push([selectedStartTime, selectedEndTime]);
            

        // }

    });

});

