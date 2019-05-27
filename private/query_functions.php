<?php
function find_all_non_admin_users() {
    global $db;

    $sql = "SELECT * FROM user ";
    $sql .= "WHERE is_admin = 0 ";
    $sql .= "ORDER BY last_name ASC";
    //echo $sql;
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    return $result;
}

function find_all_contract_templates(){
    global $db;
    $sql = "SELECT * FROM contract_template ";
    $sql .= "ORDER BY date_end DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function find_contract_by_id( $contract_id ) {
    global $db;

    $sql = "SELECT * FROM contract ";
    $sql .= "WHERE contract_id='" . db_escape( $db, $contract_id ) . "'";
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    $contract = mysqli_fetch_assoc( $result );
    mysqli_free_result( $result );
    return $contract; // returns an assoc. array
}

function find_contract_template_by_id($contract_template_id){
    global $db;

    $sql = "SELECT * FROM contract_template ";
    $sql .= "WHERE contract_template_id='" . db_escape( $db, $contract_template_id ) . "'";
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    $contract_template = mysqli_fetch_assoc( $result );
    mysqli_free_result( $result );
    return $contract_template; // returns an assoc. array
}

function find_contracts_by_contract_template_id($contract_template_id){
    global $db;

    $sql = "SELECT * FROM contract ";
    $sql .= "WHERE contract_template_id = '" . db_escape( $db, $contract_template_id ) . "' ";
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    return $result;
}

function find_contract_days_by_contract_id($contract_id){
    global $db;

    $sql = "SELECT * FROM contract_day ";
    $sql .= "WHERE contract_id = '" . db_escape( $db, $contract_id ) . "' ";
    $sql .= "ORDER BY contract_day_date ASC";
    //echo $sql;
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    return $result;
}

function find_contract_template_days_by_contract_template_id($contract_template_id, $CONTRACT_TEMPLATE_DAY_TYPE_ID=0){
    //0 - no filter
    //1 - REQUIRED
    //2 - UNAVAILABLE
    global $db;

    $sql = "SELECT * FROM contract_template_day ";
    $sql .= "WHERE contract_template_id = '" . db_escape( $db, $contract_template_id ) . "' ";
    if($CONTRACT_TEMPLATE_DAY_TYPE_ID != 0){
        $sql .= "AND contract_template_day_type_id = '" . db_escape($db, $CONTRACT_TEMPLATE_DAY_TYPE_ID) . "' ";
    }
    $sql .= "ORDER BY contract_template_day_date ASC";
    //echo $sql;
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    return $result;
}

function find_contracts_by_user($user_id){
    global $db;
    $sql = "SELECT * FROM contract, contract_type, contract_template ";
    $sql .= "WHERE user_id='" . db_escape( $db, $user_id ) . "' ";
    $sql .= "AND contract.contract_template_id = contract_template.contract_template_id ";
    $sql .= "AND contract.contract_type_id = contract_type.contract_type_id ";
    $sql .= "ORDER BY contract_template.date_end DESC ";

    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );

    return $result; // returns an assoc. array
}

function find_user_by_id( $user_id ) {
    global $db;

    $sql = "SELECT * FROM user ";
    $sql .= "WHERE user_id='" . db_escape( $db, $user_id ) . "'";
    $result = mysqli_query( $db, $sql );
    confirm_result_set( $result );
    $user = mysqli_fetch_assoc( $result );
    mysqli_free_result( $result );
    return $user; // returns an assoc. array
}

function validate_contract_template( $contract_template ) {
    $errors = [];

    // date_start
    if ( is_blank( $contract_template[ 'date_start' ] ) ) {
        $errors[ 'date_start' ] = "Start Date cannot be blank.";
    }elseif(is_date_default( $contract_template[ 'date_start' ] ) ) {
        $errors[ 'date_start' ] = "Please enter a valid Start Date.";
    }

    // date_end
    if ( is_blank( $contract_template[ 'date_end' ] ) ) {
        $errors[ 'date_end' ] = "End Date cannot be blank.";
    }elseif(is_date_default( $contract_template[ 'date_end' ] ) ) {
        $errors[ 'date_end' ] = "Please enter a valid End Date.";
    }

    // check date range
    if( !is_valid_date_range($contract_template[ 'date_start' ], $contract_template[ 'date_end' ])){
        $errors['date_range'] = "Date End must be after or equal to Date Start.";
    }

    return $errors;
}

function insert_contract_template( $contract_template ) {
    global $db;


    $errors = validate_contract_template( $contract_template );
    if ( !empty( $errors ) ) {
        return $errors;
    }

    $sql = "INSERT INTO contract_template ";
    $sql .= "(date_start, date_end) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape( $db, $contract_template[ 'date_start' ] ) . "',";
    $sql .= "'" . db_escape( $db, $contract_template[ 'date_end' ] ) . "'";
    $sql .= ")";
    $result = mysqli_query( $db, $sql );

    if ( $result ) {
        return true;
    } else {
        // INSERT failed
        echo mysqli_error( $db );
        db_disconnect( $db );
        exit;
    }
}