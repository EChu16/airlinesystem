<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top">
    <?php include('public-navbar.php'); ?>
      <div class="full-height body-center sunset-bg">
        <div class="form-wrapper">
          <div class="login-form">
            <form id="loginForm" action="" method="post">
              <input type="hidden" value="login" name="action"/>
              <div id="email-field" class="vertical-center">
                <span class="label"> Email: </span>
                <span class="form-field"><input type="text" name="email"/></span>
              </div>
              <div id="user-field" class="vertical-center">
                <span class="label"> Username: </span>
                <span class="form-field"><input type="text" name="username"/></span>
              </div>
              <div id="password-field" class="vertical-center field-padding">
                <span class="label">Password: </span>
                <span class="form-field"><input type="password" name="password"/></span>
              </div>
              <div class="vertical-center field-padding">
                <div class="radio-padding">
                  <input type="radio" name="account_type" value="customer" checked><span class="white-text">Customer</span>
                </div>
                <div class="radio-padding">
                  <input type="radio" name="account_type" value="booking_agent"><span class="white-text">Booking Agent</span>
                </div>
                <div class="radio-padding">
                  <input type="radio" name="account_type" value="airline_staff"><span class="white-text">Airline Staff</span>
                </div>
              </div>
              <div id="error-msg" class="field-padding"></div>
              <div id="submit-btn" class="btn btn-primary">
                Login
              </div>
            </form>
          </div>
        </div>
      </div>
    <?php include('footer.php'); ?>
    <script type="text/javascript">
      function changeForm() {
        $account_type = $('input[name=account_type]:checked').val();
        if($account_type == "customer" || $account_type == "booking_agent") {
          $('#user-field').hide();
          $('#email-field').show();
        } else if($account_type == "airline_staff"){
          $('#user-field').show();
          $('#email-field').hide();
        }
      }

      $(document).ready(function() {
        $('input[name=account_type]').change(function (){
          changeForm();
        });

        $('#submit-btn').click(function() {
          var sendRequest = true;
          var error = $('#error-msg');
          $account_type = $('input[name=account_type]:checked').val();
          if($account_type == "customer" || $account_type == "booking_agent") {
            var trimmed_email = $.trim($('input[name=email]').val());
            if(trimmed_email == "") {
              $(error).html('Email can\'t be blank');
              sendRequest = false;
            }
          } else if($account_type == "airline_staff"){
            var trimmed_username = $.trim($('input[name=username]').val());
            if(trimmed_username == "") {
              $(error).html('Username can\'t be blank');
              sendRequest = false;
            }
          }
          var trimmed_pw = $.trim($('input[name=password]').val());
          if(trimmed_pw == "") {
            $(error).html('Password can\'t be blank');
            sendRequest = false;
          }
          if (sendRequest) {
            var url = "authentication.php";
            $.ajax({
              type: "POST",
              url: url,
              data: $("#loginForm").serialize(),
            }).done(function(data, textStatus, xhr) {
              window.location.replace("home.php");
            }).fail(function(xhr, status, error) {
              $('#error-msg').html(xhr.responseText);
            });
          }
        });

        changeForm();
      });
    </script>
  </body>
</html>