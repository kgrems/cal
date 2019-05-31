<?php 
  require_once("../private/initialize.php");
  
  if(isset($_GET["month"])){
    $month = $_GET["month"];  
  }else{
    $month = date("m");  
  }
  
  if(isset($_GET["year"])){
    $year = $_GET["year"];    
  }else{
    $year = date("Y");  
  }
  
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
  
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>ILCC Faculty Contract Calendar</title>
    <link rel="icon" href="images/favicon.png" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/png" />


    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css'>

    <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  <div class="container-fluid">
  <header>
    <h4 class="display-4 mb-4 text-center">
        <a href="calendar.php?month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>" class="btn btn-primary btn-lg" role="button" aria-disabled="true">&lt;-</a>
        <?php echo date("F", mktime(0,0,0, $month, 1, $year)); ?> <?php echo $year; ?>
        <a href="calendar.php?month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>" class="btn btn-primary btn-lg" role="button" aria-disabled="true">-&gt;</a>
    </h4>
    <div class="row d-none d-sm-flex p-1 bg-dark text-white">
      <h5 class="col-sm p-1 text-center">Sunday</h5>
      <h5 class="col-sm p-1 text-center">Monday</h5>
      <h5 class="col-sm p-1 text-center">Tuesday</h5>
      <h5 class="col-sm p-1 text-center">Wednesday</h5>
      <h5 class="col-sm p-1 text-center">Thursday</h5>
      <h5 class="col-sm p-1 text-center">Friday</h5>
      <h5 class="col-sm p-1 text-center">Saturday</h5>
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
  while($j <= $days_in_month){
  ?>
<div class="day active-day col-sm p-2 border border-left-0 border-top-0 text-truncate ">
      <h5 class="row align-items-center">
        <span class="date col-1"><?php echo $j; ?></span>
        <small class="col d-sm-none text-center text-muted">Wednesday</small>
        <span class="col-1"></span>
      </h5>
      <p class="d-sm-none">No events</p>
    </div>
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
  
</div>
  
  

</body>

</html>
