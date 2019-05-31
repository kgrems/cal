<?php require_once('../../../private/initialize.php'); ?>
<?php
$contract_template_id = $_GET[ 'contract_template_id' ] ?? '1';
$contract_template = find_contract_template_by_id($contract_template_id);

$contract_template_day_set = find_contract_template_days_by_contract_template_id($contract_template_id);

$contract_template_day_type_set = find_all_contract_template_day_types();

$view_as = $_GET[ 'view_as' ] ?? 'calendar';

$min_date = $contract_template['date_start'];
$max_date = $contract_template['date_end'];

$min_year = explode("-", $min_date)[0];
$min_month = explode("-", $min_date)[1];
$min_day = explode("-", $min_date)[2];

$max_year = explode("-", $max_date)[0];
$max_month = explode("-", $max_date)[1];
$max_day = explode("-", $max_date)[2];

//todo need to prevent manually entering dates as parameters that are out of bounds
if(isset($_GET["month"])){
    $month = $_GET["month"];
}else{
    $month = $min_month;
}

if(isset($_GET["year"])){
    $year = $_GET["year"];
}else{
    $year = $min_year;
}

//deal with calendar view
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$first_day_of_month = mktime(0,0,0,$month,1,$year);
$first_day_of_first_week = date("w", $first_day_of_month);

$next_month = $month;
$next_year = $year;
$prev_month = $month;
$prev_year = $year;

//calc next month
if($month == 12){
    $next_month = 1;
    $next_year = $year + 1;
}else{
    $next_month++;
}

//calc prev month
if($month == 1){
    $prev_month = 12;
    $prev_year = $year - 1;
}else{
    $prev_month--;
}


if ( is_post_request() ) {

    // Handle form values sent by new.php
    $contract_template_day = [];
    $contract_template_day[ 'contract_template_day_date' ] = $_POST[ 'contract_template_day_date' ] ?? '';
    $contract_template_day[ 'notes' ] = $_POST[ 'date_end' ] ?? '';
    $contract_template_day[ 'contract_template_id' ] = $_POST['contract_template_id'] ?? '';
    $contract_template_day[ 'contract_template_day_type_id' ] = $_POST['contract_template_day_type_id'] ?? '';
    $result = insert_contract_template_day( $contract_template_day );
    if ( $result === true ) {
        $new_id = mysqli_insert_id( $db );
        redirect_to( url_for( 'admin/contract-template/view.php?contract_template_id=' . $contract_template_id . "&view_as=" . $view_as ) );
    } else {
        $errors = $result;
    }
} else {
    $contract_template_day = [];
    $contract_template_day[ 'contract_template_day_date' ] = '';
    $contract_template_day[ 'notes' ] = '';
    $contract_template_day[ 'contract_template_id' ] = '';
    $contract_template_day[ 'contract_template_day_type_id' ] = '';
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

    <title>View Contract Template</title>

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
        <h1>Contract Calendar Template</h1>
        <p class="lead"><strong><?php echo date_fmt($contract_template['date_start']); ?> - <?php echo date_fmt($contract_template['date_end']); ?></strong></p>

        <p class="align-left"><a href="index.php">Back to Dashboard</a></p>
        <p class="align-left"><a data-toggle="collapse" href="#new_template_day">New Contract Template Day</a></p>
        <div class="collapse border" id="new_template_day">
            <form  action="view.php?contract_template_id=<?php echo $contract_template_id; ?>&view_as=<?php echo $view_as; ?>" method="post" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label for="contract_template_day_date" style="max-width: none;" class="align-left col-sm-2 control-label">Date</label>
                    <div class="col-sm-10"><input name="contract_template_day_date" type="text" id="contract_template_day_date" value="<?php echo h($contract_template_day['contract_template_day_date']); ?>" class="form-control datepicker"></div>
                    <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['contract_template_day_date'])){ display_error($errors['contract_template_day_date']); } ?></p></div>
                </div>
                <div class="form-group">
                    <label for="contract_template_day_type_id" style="max-width: none;" class="align-left col-sm-2 control-label">Type</label>
                    <div class="col-sm-10">
                        <select name="contract_template_day_type_id" id="contract_template_day_type_id" class="form-control">
                            <?php while ($contract_template_day_type = mysqli_fetch_assoc($contract_template_day_type_set)) {  ?>
                            <option value="<?php echo $contract_template_day_type['contract_template_day_type_id']; ?>"><?php echo $contract_template_day_type['type']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes" style="max-width: none;" class="align-left col-sm-2 control-label">Notes</label>
                    <div class="col-sm-10">
                        <textarea name="notes" id="notes" class="form-control"><?php echo h($contract_template_day['notes']); ?></textarea>
                    </div>
                    <div class="col-sm-10"><p class="help-block"><?php if(isset($errors['notes'])){ display_error($errors['notes']); } ?></p></div>
                </div>
                <input type="hidden" name="contract_template_id" id="contract_template_id" value="<?php echo $contract_template_id; ?>">
                <div class="col-sm-10 align-left"><input type="submit" value="Create" class="btn btn-lg btn-success"></div>
            </form>
        </div>
        <div class="align-left btn-group" style="display: block;" role="group" aria-label="Basic example">
            <a href="view.php?contract_template_id=<?php echo $contract_template_id; ?>&view_as=calendar" class="<?php if($view_as == 'calendar'){echo ' active ';} ?> btn btn-secondary align-left">Calendar View</a>
            <a href="view.php?contract_template_id=<?php echo $contract_template_id; ?>&view_as=list" class="<?php if($view_as == 'list'){echo ' active ';} ?> btn btn-secondary align-left">List View</a>
        </div>
        <?php if($view_as == 'list'){ ?>
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
                    <td><a href="../contract-template-day/delete.php?contract_template_day_id=<?php echo h(u($contract_template_day['contract_template_day_id'])); ?>&contract_template_id=<?php echo $contract_template_id; ?>&view_as=<?php echo $view_as; ?>" class="btn btn-danger btn-lg crud-button">Delete</a></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php }elseif($view_as == 'calendar'){ ?>
            <header>
                <h4 class="display-4 mb-4 text-center">
                    <!-- TODO need to account for years wrapping around -->
                    <?php if($prev_month < $min_month && $year == $min_year){ ?>
                        <button class="btn btn-primary btn-lg" role="button" aria-disabled="true">&lt;-</button>
                    <?php }else{ ?>
                        <a href="view.php?contract_template_id=<?php echo $contract_template_id ?>&view_as=calendar&month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>" class="btn btn-primary btn-lg" role="button" aria-disabled="true">&lt;-</a>
                    <?php } ?>

                    <?php echo date("F", mktime(0,0,0, $month, 1, $year)); ?> <?php echo $year; ?>

                    <?php if($next_month > $max_month && $year == $max_year){ ?>
                        <button class="btn btn-primary btn-lg" role="button" aria-disabled="true">-&gt;</button>
                    <?php }else{ ?>
                        <a href="view.php?contract_template_id=<?php echo $contract_template_id ?>&view_as=calendar&month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>" class="btn btn-primary btn-lg" role="button" aria-disabled="true">-&gt;</a>
                    <?php } ?>
                </h4>
                <div class="row d-none d-sm-flex p-1 bg-dark text-white">
                    <h5 class="col-sm p-1 text-center">Sun</h5>
                    <h5 class="col-sm p-1 text-center">Mon</h5>
                    <h5 class="col-sm p-1 text-center">Tue</h5>
                    <h5 class="col-sm p-1 text-center">Wed</h5>
                    <h5 class="col-sm p-1 text-center">Thu</h5>
                    <h5 class="col-sm p-1 text-center">Fri</h5>
                    <h5 class="col-sm p-1 text-center">Sat</h5>
                </div>
            </header>
            <!-- Build the calendar -->
            <div class="row border border-right-0 border-bottom-0">

                <!-- Insert filler days (if any) from previous month -->
                <?php
                $row_count = 1;
                $i = 1;
                while($i <= $first_day_of_first_week){
                    ?>
                    <div style="background-color: #ecedee !important;" class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block bg-light text-muted">
                        <h5 class="row align-items-center">
                            <span class="date col-1"></span>
                            <small class="col d-sm-none text-center text-muted">Sunday</small>
                            <span class="col-1"></span>
                        </h5>
                        <p class="d-sm-none">No events</p>
                    </div>
                    <?php
                    $i++;
                    $row_count++;
                }
                ?>

                <!-- Build current month -->
                <?php
                //$i = 1;
                $j = 1;
                while($j <= $days_in_month){ ?>

                    <?php if($j < $min_day && $year == $min_year && $month == $min_month){ ?>
                    <div style="background-color: #ecedee !important;" class="day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
                        <h5 class="row align-items-center">
                            <span class="date col-1"><?php echo $j; ?></span>
                            <small class="col d-sm-none text-center text-muted">Wednesday</small>
                            <span class="col-1"></span>
                        </h5>
                        <p class="d-sm-none">No events</p>
                    </div>
                    <?php }else{ ?>
                        <div class="day active-day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
                            <h5 class="row align-items-center">
                                <span class="date col-1"><?php echo $j; ?></span>
                                <small class="col d-sm-none text-center text-muted">Wednesday</small>
                                <span class="col-1"></span>
                            </h5>
                            <p class="d-sm-none">No events</p>
                        </div>
                    <?php } ?>
                    <?php if($i % 7 == 0){ echo '<div class="w-100"></div>'; } ?>
                    <?php
                    if($row_count >= 7){
                        $row_count = 1;
                    }else{
                        $row_count++;
                    }
                    $i++;
                    $j++;
                } ?>

                <!-- Pad extra spaces at end of month -->
                <?php
                while($row_count <= 7){
                    ?>
                    <div style="background-color: #ecedee !important;" class="day col-sm p-2 border border-left-0 border-top-0 text-truncate d-none d-sm-inline-block bg-light text-muted">
                        <h5 class="row align-items-center">
                            <span class="date col-1"></span>
                            <small class="col d-sm-none text-center text-muted">Sunday</small>
                            <span class="col-1"></span>
                        </h5>
                        <p class="d-sm-none">No events</p>
                    </div>
                    <?php
                    $row_count++;
                }
                ?>
            </div>
        <?php } ?>
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
<?php
//need to subtract 1 from month to deal with pickadate's 0-based indexing
$start_year = explode("-", $contract_template['date_start'])[0];
$start_month = explode("-", $contract_template['date_start'])[1] - 1;
$start_day = explode("-", $contract_template['date_start'])[2];

$end_year = explode("-", $contract_template['date_end'])[0];
$end_month = explode("-", $contract_template['date_end'])[1] - 1;
$end_day = explode("-", $contract_template['date_end'])[2];

?>
<script>
    $('.datepicker').pickadate({
        format: 'dddd, mmm dd, yyyy',
        formatSubmit: 'yyyy-mm-dd',
        min: [<?php echo $start_year . "," . $start_month . "," . $start_day; ?>],
        max: [<?php echo $end_year . "," . $end_month . "," . $end_day; ?>],
        hiddenName: true
    });
</script>
</body>
</html>

