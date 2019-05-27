<?php require_once('../../../private/initialize.php'); ?>
<?php

if ( is_post_request() ) {

    // Handle form values sent by new.php
    $contract_template = [];
    $contract_template[ 'date_start' ] = $_POST[ 'date_start' ] ?? '';
    $contract_template[ 'date_end' ] = $_POST[ 'date_end' ] ?? '';

    $result = insert_contract_template( $contract_template );
    if ( $result === true ) {
        $new_id = mysqli_insert_id( $db );
        redirect_to( url_for( 'admin/contract-template/index.php' ) );
    } else {
        $errors = $result;
    }
} else {
    $contract_template = [];
    $contract_template[ 'date_start' ] = '';
    $contract_template[ 'date_end' ] = '';
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>New Contract Template</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="../../pickadate/themes/default.css" id="theme_base">
    <link rel="stylesheet" href="../../pickadate/themes/default.date.css" id="theme_date">
    <link rel="stylesheet" href="../../pickadate/themes/default.time.css" id="theme_time">


</head>

<body>

<main role="main" class="container">

    <div class="starter-template">
        <h1>New Contract Calendar Template</h1>
        <p class="lead">Select contract to view.</p>

        <p class="align-left"><a href="index.php">Back to Contract Calendar Templates</a></p>
        <form action="new.php" method="post" class="form-horizontal my-5">
            <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['date_range'])){ display_error($errors['date_range']); } ?></p></div>
            <div class="form-group">
                <label for="date_start" style="max-width: none;" class="align-left col-sm-2 control-label">Date Start</label>
                <div class="col-sm-10"><input name="date_start" type="text" id="date_start" value="<?php echo h($contract_template['date_start']); ?>" class="form-control datepicker"></div>
                <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['date_start'])){ display_error($errors['date_start']); } ?></p></div>
            </div>
            <div class="form-group">
                <label for="date_end" style="max-width: none;" class="align-left col-sm-2 control-label">Date End</label>
                <div class="col-sm-10"><input name="date_end" type="text" id="date_end" value="<?php echo h($contract_template['date_end']); ?>" class="form-control datepicker"></div>
                <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['date_end'])){ display_error($errors['date_end']); } ?></p></div>
            </div>

            <div class="col-sm-10"><input type="submit" value="Create" class="btn btn-lg btn-success"> <input type="button" value="Cancel" class="btn btn-lg btn-danger" onclick="location.href='index.php';"></div>

        </form>

    </div>

</main><!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../../js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../js/jquery-slim.min.js"><\/script>')</script>
<script src="../../js/popper.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../pickadate/picker.js"></script>
<script src="../../pickadate/picker.date.js"></script>
<script src="../../pickadate/picker.time.js"></script>
<script src="../../pickadate/legacy.js"></script>
<script>
    $('.datepicker').pickadate({
        format: 'dddd, mmm dd, yyyy',
        formatSubmit: 'yyyy-mm-dd',
        hiddenName: true
    });
</script>
</body>
</html>