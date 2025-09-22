# Space Reservation

一個基於 PHP 與 MySQL 的座位預約系統，提供使用者方便查詢與管理座位使用狀況。

## 操作方式
- 進入登入頁面，輸入帳號密碼。

<img src="https://github.com/wenyu8020/SpaceReservation/blob/main/img/login.png">

- 我的預約：可以查看當日是否有預約。

<img src="https://github.com/wenyu8020/SpaceReservation/blob/main/img/myReservation.png">

- 座位查詢：選定日期後，可以查看座位的資訊，包含座位編號、插座狀態、座位狀態等，並進行預約。

<img src="https://github.com/wenyu8020/SpaceReservation/blob/main/img/Search.png">

點選想要預約的座位後，選定時段並確定預約。

<img src="https://github.com/wenyu8020/SpaceReservation/blob/main/img/chooseTime.png">

如有預約成功，則會跳出成功預約的訊息，並收到系統傳送的信件。

<img src="https://github.com/wenyu8020/SpaceReservation/blob/main/img/success.png">

- 預約紀錄：查看已預約的紀錄。

<img src="https://github.com/wenyu8020/SpaceReservation/blob/main/img/record.png">

取消預約成功會跳出訊息，並收到系統傳送的信件。

<img src="https://github.com/wenyu8020/SpaceReservation/blob/main/img/cancel.png">

## System Requirements

- XAMPP（含 Apache + MySQL + PHP）
- PHP 7.4+
- MySQL 5.7+
- 瀏覽器：Chrome / Edge / Firefox

## Installation

1. 安裝 [XAMPP](https://www.apachefriends.org/index.html)。  
2. 將本專案下載或複製至 `htdocs` 資料夾：  
   ```bash
   C:\xampp\htdocs\SpaceReservation
3. 啟動 Apache 與 MySQL。
4. 在 phpMyAdmin 匯入 database.sql 建立資料庫與資料表。
5. 瀏覽器輸入：
    ```
    http://localhost/SpaceReservation
