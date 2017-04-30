<?php
  if(isset($_SESSION)) { session_unset(); session_destroy(); }
?>
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <a href="index.php">
        <div class="nav navbar-nav navbar-left" style="margin-top:13px;"> Blackberry Airlines</div>
      </a>
      <ul class="nav navbar-nav navbar-right">
        <li>
        <a class="page-scroll" href="flights.php">Flights</a>
        </li>
        <li>
        <a class="page-scroll" href="login.php">Book Now</a>
        </li>
        <li>
        <a class="page-scroll" href="signup.php">Sign Up</a>
        </li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
<!-- /.container -->
</nav>