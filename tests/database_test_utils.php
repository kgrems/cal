<?php
require_once('../private/initialize.php');

function get_num_records_from_query($sql){
    global $db;

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return mysqli_num_rows($result);
}