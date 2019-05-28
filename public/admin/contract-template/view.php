<?php require_once('../../../private/initialize.php'); ?>
<?php
$contract_template_id = $_GET[ 'contract_template_id' ] ?? '1';
$contract_template = find_contract_template_by_id($contract_template_id);

$contract_template_day_set = find_contract_template_days_by_contract_template_id($contract_template_id);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>View Contract Template</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">

</head>

<body>

<main role="main" class="container">

    <div class="starter-template">
        <h1>Contract Calendar Template</h1>
        <p class="lead"><strong><?php echo date_fmt($contract_template['date_start']); ?> - <?php echo date_fmt($contract_template['date_end']); ?></strong></p>

        <p class="align-left"><a href="index.php">Back to Dashboard</a></p>
        <p class="align-left"><a href="new.php">New Contract Template</a></p>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Template Date</th>
                <th>Template Day Type</th>
                <th>Notes</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php while ($contract_template_day = mysqli_fetch_assoc($contract_template_day_set)) { ?>
                <tr>
                    <td><?php echo date_fmt($contract_template_day['contract_template_day_date']); ?></td>
                    <td><?php echo $contract_template_day['contract_template_day_type_id']; ?></td>
                    <td><?php echo $contract_template_day['notes']; ?></td>
                    <td><a href="../contract-template-day/delete.php?contract_template_day_id=<?php echo h(u($contract_template_day['contract_template_day_id'])); ?>" class="btn btn-danger btn-lg crud-button">Delete</a></td>

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

