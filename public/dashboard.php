<?php require_once('../private/initialize.php'); ?>
<?php
    //todo - just hard-coded for now...
    $user = find_user_by_id("1");
    $contract_set = find_contracts_by_user($user['user_id']);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Select A Contract</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

<main role="main" class="container">

    <div class="starter-template">
        <h1>Welcome <?php echo $user['username']; ?></h1>
        <p class="lead">Select A Contract</p>

        <p class="align-left"><a href="../dashboard.php">Back to Dashboard</a></p>
        <p class="align-left"><a href="new.php">New Contract Template</a></p>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Date Start</th>
                <th>Date End</th>
                <th>Extra Days Req.</th>
                <th>Extra Days Rem.</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php while ($contract = mysqli_fetch_assoc($contract_set)) {
                $contract_day_set_count = mysqli_num_rows(find_contract_days_by_contract_id($contract['contract_id']));
                ?>
                <tr>
                    <td>
                        <?php echo h(date_fmt($contract['date_start'])); ?>
                    </td>
                    <td>
                        <?php echo h(date_fmt($contract['date_end'])); ?>
                    </td>
                    <td>
                        <?php echo $contract['extra_days']; ?>
                    </td>
                    <td>
                        <?php echo $contract['extra_days'] - $contract_day_set_count; ?>
                    </td>
                    <td>
                        <a href="view.php?contract_id=<?php echo h(u($contract['contract_id'])); ?>&view_as=calendar" class="btn btn-primary btn-lg crud-button">View</a>
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

