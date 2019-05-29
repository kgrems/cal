<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['contract_template_day_id'])) {
    redirect_to(url_for('admin/contract-template/index.php'));
}
$contract_template_day_id = $_GET['contract_template_day_id'];

$contract_template_id = 0;
if(isset($_GET['contract_template_id'])){
    $contract_template_id = $_GET['contract_template_id'];
}

$view_as = "";
if(isset($_GET['view_as'])){
    $view_as = $_GET['view_as'];
}

$result = delete_contract_template_day($contract_template_day_id);
redirect_to(url_for('admin/contract-template/view.php?contract_template_id=' . $contract_template_id . "&view_as=" . $view_as));
