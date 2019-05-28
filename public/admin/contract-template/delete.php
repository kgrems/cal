<?php
require_once('../../../private/initialize.php');

if(!isset($_GET['contract_template_id'])) {
    redirect_to(url_for('index.php'));
}
$contract_template_id = $_GET['contract_template_id'];

$result = delete_contract_template($contract_template_id);
redirect_to(url_for('admin/contract-template/index.php'));
