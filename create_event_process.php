<?php
    session_start();
    
    if(!isset($_POST["create"]) || !isset($_SESSION["userID"])) {
        header("location: index.php");
        exit();
    } else {

        require_once './include/login.inc.php';

        // GET REGISTRATION INPUT
        $evtName = $_POST['evt_name'];
        $evtUserID = $_SESSION['userID'];
        $evtText = $_POST['evt_text'];
        $evtStartDate = $_POST['evt_sdate'];
        $evtEndDate = $_POST['evt_Edate'];
        $evtStartTime = $_POST['evt_stime'];
        $evtEndTime = $_POST['evt_etime'];
        $evtAdress = $_POST['evt_adress'];
        $evtZip = $_POST['evt_zip'];
        $evtCity = $_POST['evt_city'];
        $evtPrice = $_POST['evt_price'];

        // PREPARE QUERY
        $db = new SQLite3("./db/db.db");

        $sql = "INSERT INTO events (event_userID, event_name, event_text, event_adress, event_zip, event_city, event_date, event_enddate, event_time, event_endtime, event_price)
                VALUES (:event_userID, :event_name, :event_text, :event_adress, :event_zip, :event_city, :event_date, :event_enddate, :event_time, :event_endtime, :event_price)";

        $stmt = $db->prepare($sql);

        // BIND PARAMETERS
        $stmt->bindParam(":event_userID", $evtUserID, SQLITE3_INTEGER);
        $stmt->bindParam(":event_name", $evtName, SQLITE3_TEXT);
        $stmt->bindParam(":event_text", $evtText, SQLITE3_TEXT);
        $stmt->bindParam(":event_adress", $evtAdress, SQLITE3_TEXT);
        $stmt->bindParam(":event_zip", $evtZip, SQLITE3_TEXT);
        $stmt->bindParam(":event_city", $evtCity, SQLITE3_TEXT);
        $stmt->bindParam(":event_date", $evtStartDate, SQLITE3_TEXT);
        $stmt->bindParam(":event_enddate", $evtEndDate, SQLITE3_TEXT);
        $stmt->bindParam(":event_time", $evtStartTime, SQLITE3_TEXT);
        $stmt->bindParam(":event_endtime", $evtEndTime, SQLITE3_TEXT);
        $stmt->bindParam(":event_price", $evtPrice, SQLITE3_INTEGER);

        // REGISTER USER
        if($stmt->execute()) {
            header("location: index.php?error=createsuccess");
            exit();
        } else {
            header("location: index.php?error=createfailed");
            exit();
        }
    }
?>