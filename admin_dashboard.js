// 在 admin_dashboard.js 中

$(document).ready(function() {
    // 監聽更新按鈕的點擊事件
    $('#updateDataButton').on('click', function() {
        // 創建一個空數組來存儲座位的新狀態
        var seatUpdates = [];

        // 遍歷每個座位
        $('.socket-status-select').each(function() {
            var seatId = $(this).data('seat-id');
            var socketStatus = $(this).val();
            var seatStatus = $(this).closest('tr').find('.seat-status-select').val();

            // 將每個座位的新狀態添加到數組中
            seatUpdates.push({
                seatId: seatId,
                socketStatus: socketStatus,
                seatStatus: seatStatus
            });
        });

        // 發送 AJAX 請求更新座位狀態
        $.ajax({
            url: 'update_seat_status.php',
            method: 'POST',
            data: { seatUpdates: JSON.stringify(seatUpdates) },
            success: function(response) {
                // 更新成功時的處理邏輯
                console.log(response); // 輸出服務器響應
            },
            error: function(xhr, status, error) {
                // 處理錯誤
                console.error(xhr.responseText);
            }
        });
    });
});
