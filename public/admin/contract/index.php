<?php require_once('../../../private/initialize.php'); ?>
<?php
$contract_template_set = find_all_contract_templates();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>Faculty Contract Dashboard</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">

</head>

<body>

<main role="main" class="container">

    <div class="starter-template">
        <h1>Contracts</h1>
        <p class="lead">Select a contract to view faculty using it.</p>

        <p class="align-left"><a href="../dashboard.php">Back to Dashboard</a></p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th># Using</th>
                <th># Unfinished</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php while ($contract_template = mysqli_fetch_assoc($contract_template_set)) {
                ?>
                <tr>
                    <td>
                        <?php echo h($contract_template['date_start']); ?>
                    </td>
                    <td>
                        <?php echo h($contract_template['date_end']); ?>
                    </td>
                    <td>
                        <?php echo h($user['email']); ?>
                    </td>
                    <td>
                        <a href="view.php?contract_id=<?php echo h(u($contract_template['contract_template_id'])); ?>" class="btn btn-primary btn-lg">View</a>
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

