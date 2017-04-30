<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top">
    <?php include('public-navbar.php'); ?>
    <!-- Section Intro Slider
    ================================================== -->
    <div id="carousel-example-generic" class="carousel intro slide">
      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <!-- First slide -->
        <div class="item active" style="background-image:url(https://www.quickenloans.com/blog/wp-content/uploads/2012/07/Airplane-sunset.jpg)">
          <div class="carousel-caption">
            <h2 data-animation="animated bounceInDown">
            Blackberry Airlines  </h2>
            <a href="login.php" class="btn btn-ghost btn-lg" data-animation="animated fadeInLeft">Log In</a>
            <a href="signup.php" class="btn btn-ghost btn-lg" data-animation="animated fadeInRight">Sign Up</a>
          </div>
        </div>
      <!-- /.carousel-inner -->
      <!-- Controls (currently displayed none from style.css)-->
      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
      </a>
    </div>
    <!-- /.carousel -->

    <!-- Section Contact
    ================================================== -->
    <section id="contact">
    <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2 text-center">
        <h2 class="section-heading">CONTACT <b>US</b></h2>
        <hr class="primary">
        <p>
           Ready to book your flight with us? Send us an email or give us a call!
        </p>
        <div class="regularform">
          <div class="done">
            <div class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              Message sent. Thank you!
            </div>
          </div>
          <form method="post" action="contact.php" id="contactform" class="text-left">
            <input name="name" type="text" class="col-md-6 norightborder" placeholder="Your Name *">
            <input name="email" type="email" class="col-md-6" placeholder="E-mail address *">
            <textarea name="comment" class="col-md-12" placeholder="Message *"></textarea>
            <input type="submit" id="submit" class="contact submit btn btn-primary btn-xl" value="Send message">
          </form>
        </div>
      </div>
    </div>
    </div>
    </section>

    <?php include('footer.php'); ?>
  </body>
</html>