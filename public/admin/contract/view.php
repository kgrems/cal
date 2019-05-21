<?php require_once('../../../private/initialize.php'); ?>
<?php
/*
 * need to get:
 *   the contract,
 *   contract days,
 *   contract template,
 *   and contract template days
 *
 * read-only from this view
*/
$contract_id = $_GET[ 'contract_id' ] ?? '1'; // PHP > 7.0
$user_id = $_GET[ 'user_id' ] ?? '1'; // PHP > 7.0

$contract = find_contract_by_id( $contract_id );
$user = find_user_by_id( $user_id );

$contract_template_id = $contract['contract_template_id'];
$contract_template = find_contract_template_by_id($contract_template_id);

$contract_template_date_start = date($default_date_format, strtotime($contract_template['date_start']));
$contract_template_date_end = date($default_date_format, strtotime($contract_template['date_end']));

// will need to merge these 2 result sets together, probably using the 'merge' algo. of merge sort
$contract_day_set = find_contract_days_by_contract_id($contract_id);
$contract_template_day_set = find_contract_template_days_by_contract_template_id($contract_template_id, $REQUIRED);
$day_set = [];

$i = 0;
$j = 0;

$contract_template_day_count = mysqli_num_rows($contract_template_day_set);
$contract_day_count = mysqli_num_rows($contract_day_set);

//while($i < $contract_day_set_size && $j < $contract_template_day_set_size){

//}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Starter Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: 5rem;
        }
        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .align-left{
            text-align: left;
        }
        ul{
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>

<main role="main" class="container">

    <div class="starter-template">
        <h1><?php echo $user['first_name'] . " " . $user['last_name']; ?></h1>

        <p class="lead">Contract Day List for <?php echo $contract_template_date_start . " - " . $contract_template_date_end; ?></p>

        <p><?php echo $contract_template_day_count; ?> <?php echo $contract_day_count; ?></p>

        <a href="../user/view.php?user_id=<?php echo h(u($user['user_id'])); ?>">Back to User</a>
        <ul>

        <?php while ($contract_template_day = mysqli_fetch_assoc($contract_template_day_set)) { ?>
        <li>
            <strong><?php echo  date($default_date_format, strtotime($contract_template_day['contract_template_day_date'])); ?></strong>
        </li>
        <?php } ?>
        <?php while ($contract_day = mysqli_fetch_assoc($contract_day_set)) { ?>
        <li>
            <?php echo  date($default_date_format, strtotime($contract_day['contract_day_date'])); ?>
        </li>
        <?php } ?>
        </ul>
    </div>

</main><!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../../js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../js/jquery-slim.min.js"><\/script>')</script>
<script src="../../js/popper.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
</body>
</html>