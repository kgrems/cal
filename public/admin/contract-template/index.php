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

    <title>Faculty Contract Templates</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">

</head>

<body>

<main role="main" class="container">

    <div class="starter-template">
        <h1>Contract Calendar Templates</h1>
        <p class="lead">Select Template To View/Modify</p>

        <p class="align-left"><a href="../dashboard.php">Back to Dashboard</a></p>
        <p class="align-left"><a href="new.php">New Contract Template</a></p>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>Date Start</th>
                <th>Date End</th>
                <th>Contracts Using</th>
                <th>Required Days</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php while ($contract_template = mysqli_fetch_assoc($contract_template_set)) { ?>
                <tr>
                    <td>
                        <?php echo h(date_fmt($contract_template['date_start'])); ?>
                    </td>
                    <td>
                        <?php echo h(date_fmt($contract_template['date_end'])); ?>
                    </td>
                    <td>
                        <?php
                        $contracts_using = 0;
                        $contracts_using = mysqli_num_rows(find_contracts_by_contract_template_id($contract_template['contract_template_id']));
                        echo $contracts_using;
                        ?>
                    </td>
                    <td>
                        <?php
                        $required_days = 0;
                        $required_days = mysqli_num_rows(find_contract_template_days_by_contract_template_id($contract_template['contract_template_id'], $REQUIRED));
                        echo $required_days;
                        ?>
                    </td>
                    <td>
                        <a href="view.php?contract_template_id=<?php echo h(u($contract_template['contract_template_id'])); ?>" class="btn btn-primary btn-lg crud-button">View</a>
                        <a data-toggle="collapse" href="#delete-collapse<?php echo h(u($contract_template['contract_template_id'])); ?>" class="btn btn-danger btn-lg crud-button">Delete</a>

                    </td>
                </tr>
                <tr class="collapse" id="delete-collapse<?php echo h(u($contract_template['contract_template_id'])); ?>">
                    <td colspan="5" >
                        <div class="mark" >
                            <div class="mark card card-body delete-warning">
                                <p>Are you sure you want to delete template number: <?php echo h(u($contract_template['contract_template_id'])); ?>?  <br>This will also remove:
                                </p>
                                <ul>
                                    <li>All contracts based on this template.</li>
                                    <li>All contract days based on this template.</li>
                                    <li>All contract template days based on this template.</li>
                                </ul>
                                <br>
                                <a href="delete.php?contract_template_id=<?php echo h(u($contract_template['contract_template_id'])); ?>" class="btn btn-danger btn-lg ">DELETE</a>
                            </div>
                        </div>
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

