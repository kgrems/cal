<?php require_once('../../../private/initialize.php'); ?>
<?php

$user_id = $_GET[ 'user_id' ] ?? '1'; // PHP > 7.0

$user = find_user_by_id( $user_id );

$contract_set = find_contracts_by_user($user_id);
$contract_count = 0;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>User Contracts</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">

</head>

<body>

<main role="main" class="container">

    <div class="starter-template">
        <h1><?php echo $user['first_name'] . " " . $user['last_name']; ?></h1>
        <p class="lead">Select contract to view.</p>

        <p class="align-left"><a href="index.php">Back to Faculty</a></p>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Contract Type</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php while ($contract = mysqli_fetch_assoc($contract_set)) { ?>
                <tr>
                    <td>
                        <?php echo h($contract['date_start']); ?>
                    </td>
                    <td>
                        <?php echo h($contract['date_end']); ?>
                    </td>
                    <td>
                        <?php echo h($contract['type']); ?>
                    </td>
                    <td>
                        <a href="../contract/view.php?user_id=<?php echo h(u($user_id)); ?>&contract_id=<?php echo h(u($contract['contract_id'])); ?>" class="btn btn-primary btn-lg">View</a>
                    </td>
                </tr>

            <?php } ?>
            </tbody>
        </table>
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