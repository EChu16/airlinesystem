<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top">
    <?php include('navbar.php'); ?>
      <div class="body-center sunset-bg">
        <div class="form-wrapper">
          <div class="signup-form">
            <form id="signupForm" action="" method="post">
              <input type="hidden" value="signup" name="action"/>
              <div id="firstname-field" class="vertical-center">
                <span class="label"> First Name: </span>
                <span class="form-field"><input type="text" name="firstname"/></span>
              </div>
              <div id="lastname-field" class="vertical-center field-padding">
                <span class="label"> Last Name: </span>
                <span class="form-field"><input type="text" name="lastname"/></span>
              </div>
              <div id="email-field" class="vertical-center field-padding">
                <span class="label"> Email: </span>
                <span class="form-field"><input type="text" name="email"/></span>
              </div>
              <div id="user-field" class="vertical-center field-padding">
                <span class="label"> Username: </span>
                <span class="form-field"><input type="text" name="username"/></span>
              </div>
              <div id="password-field" class="vertical-center field-padding">
                <span class="label">Password: </span>
                <span class="form-field"><input type="password" name="password"/></span>
              </div>
              <div id="buildingnum-field" class="vertical-center field-padding">
                <span class="label"> Building Number: </span>
                <span class="form-field"><input type="text" name="buildingnum"/></span>
              </div>
              <div id="street-field" class="vertical-center field-padding">
                <span class="label"> Street: </span>
                <span class="form-field"><input type="text" name="street"/></span>
              </div>
              <div id="city-field" class="vertical-center field-padding">
                <span class="label"> City: </span>
                <span class="form-field"><input type="text" name="city"/></span>
              </div>
              <div id="state-field" class="vertical-center field-padding">
                <span class="label"> State: </span>
                <span class="form-field"><input type="text" name="state"/></span>
              </div>
              <div id="phonenum-field" class="vertical-center field-padding">
                <span class="label"> Phone Number: </span>
                <span class="form-field"><input type="text" name="phonenum"/></span>
              </div>
              <div id="passportnum-field" class="vertical-center field-padding">
                <span class="label"> Passport Number: </span>
                <span class="form-field"><input type="text" name="passportnum"/></span>
              </div>
              <div id="passportexp-field" class="vertical-center field-padding">
                <span class="label"> Passport Expiration: </span>
                <span class="form-field"><input type="text" name="passportexp"/></span>
              </div>
              <div id="passport_country-field" class="vertical-center field-padding">
                <span class="label"> Passport Country: </span>
                <span class="form-field"><input type="text" name="passport_country"/></span>
              </div>
              <div id="dob-field" class="vertical-center field-padding">
                <span class="label"> Date of Birth: </span>
                <span class="form-field"><input type="text" name="dob"/></span>
              </div>
              <div id="airlinename-field" class="vertical-center field-padding">
                <span class="label"> Airline Name: </span>
                <span class="form-field"><input type="text" name="airlinename"/></span>
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
                Register
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

      function validateEmail(email) {
        var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return $.trim(email).match(pattern) ? true : false;
      }

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
        var trimmed_fname = $.trim($('input[name=firstname]').val());
        if(trimmed_fname == "") {
          $(error).html('Name can\'t be blank');
          sendRequest = false;
        }

        var trimmed_pw = $.trim($('input[name=password]').val());
        if(trimmed_pw == "") {
          $(error).html('Password can\'t be blank');
          sendRequest = false;
        }

        // Validate email
        if(!validateEmail($('input[name=email]').val())) {
          $(error).html('Please enter a valid email');
          sendRequest = false;
        }

        if (sendRequest) {
          var url = "initial_processing.php";
          $.ajax({
            type: "POST",
            url: url,
            data: $("#signupForm").serialize(),
            success: function(data) {
              window.location('home.php');
            }
          });
        }
      });

      changeForm();
    </script>
  </body>
</html>