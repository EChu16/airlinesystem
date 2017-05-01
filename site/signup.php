<!DOCTYPE html>
<html lang="en">
  <?php include('header.php'); ?>
  <body id="page-top">
    <?php include('public-navbar.php'); ?>
      <div id="signup-form-wrapper" class="body-center sunset-bg">
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
              <div id="ba_id-field" class="vertical-center field-padding">
                <span class="label"> ID: </span>
                <span class="form-field"><input type="text" name="ba_id"/></span>
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
                <span class="form-field"><input type="text" name="passportexp" placeholder="mm/dd/yyyy" /></span>
              </div>
              <div id="passport_country-field" class="vertical-center field-padding">
                <span class="label"> Passport Country: </span>
                <span class="form-field"><input type="text" name="passport_country"/></span>
              </div>
              <div id="dob-field" class="vertical-center field-padding">
                <span class="label"> Date of Birth: </span>
                <span class="form-field"><input type="text" name="dob" placeholder="mm/dd/yyyy" /></span>
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
        if($account_type == "customer") {
          $('#signup-form-wrapper').removeClass("full-height");
          $('#user-field').hide();
          $('#email-field').show();
          $('#firstname-field').show();
          $('#lastname-field').show();
          $('#password-field').show();
          $('#buildingnum-field').show();
          $('#street-field').show();
          $('#city-field').show();
          $('#state-field').show();
          $('#phonenum-field').show();
          $('#passportnum-field').show();
          $('#passportexp-field').show();
          $('#passport_country-field').show();
          $('#dob-field').show();
          $('#airlinename-field').hide();
          $('#ba_id-field').hide();
        } else if($account_type == "airline_staff") {
          $('#signup-form-wrapper').addClass("full-height");
          $('#user-field').show();
          $('#email-field').hide();
          $('#firstname-field').show();
          $('#lastname-field').show();
          $('#password-field').show();
          $('#buildingnum-field').hide();
          $('#street-field').hide();
          $('#city-field').hide();
          $('#state-field').hide();
          $('#phonenum-field').hide();
          $('#passportnum-field').hide();
          $('#passportexp-field').hide();
          $('#passport_country-field').hide();
          $('#dob-field').show();
          $('#airlinename-field').show();
          $('#ba_id-field').hide();
        } else if($account_type == "booking_agent") {
          $('#signup-form-wrapper').addClass("full-height");
          $('#user-field').hide();
          $('#email-field').show();
          $('#firstname-field').show();
          $('#lastname-field').show();
          $('#password-field').show();
          $('#buildingnum-field').hide();
          $('#street-field').hide();
          $('#city-field').hide();
          $('#state-field').hide();
          $('#phonenum-field').hide();
          $('#passportnum-field').hide();
          $('#passportexp-field').hide();
          $('#passport_country-field').hide();
          $('#dob-field').hide();
          $('#airlinename-field').hide();
          $('#ba_id-field').show();
        }
      }

      function validateEmail(email) {
        var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return $.trim(email).match(pattern) ? true : false;
      }

      function validateDate(date) {
        var dateRegEx = /^(0[1-9]|1[012]|[1-9])[- /.](0[1-9]|[12][0-9]|3[01]|[1-9])[- /.](19|20)\d\d$/
        return (date.match(dateRegEx) !== null);
      }

      function isNumber(value) {
        return /^\d+$/.test(value);
      }


      $('input[name=account_type]').change(function (){
        changeForm();
      });

      $('#submit-btn').click(function() {
        var sendRequest = true;
        var error = $('#error-msg');
        $account_type = $('input[name=account_type]:checked').val();

        if($account_type == "customer" || $account_type == "booking_agent" || $account_type == "airline_staff") {
          var trimmed_fname = $.trim($('input[name=firstname]').val());
          if(trimmed_fname == "") {
            $(error).html('First name can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_lname = $.trim($('input[name=lastname').val());
          if(trimmed_lname == "") {
            $(error).html('Last name can\'t be blank.');
          }
          var trimmed_pw = $.trim($('input[name=password]').val());
          if(trimmed_pw == "") {
            $(error).html('Password can\'t be blank.');
            sendRequest = false;
          }
        }

        else if ($account_type == "customer" || $account_type == "booking_agent") {
          var trimmed_email = $.trim($('input[name=email]').val());
          if(trimmed_email == "") {
            $(error).html('Email can\'t be blank.');
            sendRequest = false;
          }
        }

        else if($account_type == "customer" || $account_type == "airline_staff") {
          var trimmed_dob = $.trim($('input[name=dob]').val());
          if(trimmed_dob == "") {
            $(error).html('Date of birth can\'t be blank.');
          }
        }

        else if($account_type == "customer") {
          var trimmed_buildingnum = $.trim($('input[name=buildingnum]').val());
          if(trimmed_buildingnum == "") {
            $(error).html('Building number can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_street = $.trim($('input[name=street]').val());
          if(trimmed_street == "") {
            $(error).html('Street can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_city = $.trim($('input[name=city]').val());
          if(trimmed_city == "") {
            $(error).html('City can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_state = $.trim($('input[name=state]').val());
          if(trimmed_state == "") {
            $(error).html('State can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_phonenum = $.trim($('input[name=phonenum]').val());
          if(trimmed_phonenum == "" && !$('input[name=phonenum]').is(":visible")) {
            $(error).html('Phone number can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_passportnum = $.trim($('input[name=passportnum]').val());
          if(trimmed_passportnum == "") {
            $(error).html('Passport number can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_passportexp = $.trim($('input[name=passportexp]').val());
          if(trimmed_passportexp == "") {
            $(error).html('Passport expiration can\'t be blank.');
            sendRequest = false;
          }
          var trimmed_passportcountry = $.trim($('input[name=passport_country]').val());
          if(trimmed_passportcountry == "") {
            $(error).html('Passport country can\'t be blank.');
            sendRequest = false;
          }
        } 

        else if($account_type == "airline_staff"){
          var trimmed_airlinename = $.trim($('input[name=airlinename]').val());
          if(trimmed_airlinename == "") {
            $(error).html('Airline name can\'t be blank.');
            sendRequest = false;
          }
        }
        else if($account_type == "booking_agent") {
          var trimmed_id = $.trim($('input[name=ba_id]').val());
          if(trimmed_id == "") {
            $(error).html("Booking agent ID can\'t be blank.");
          }
        }

        //Validate email
        if($('input[name=email]').is(":visible")) {
          if(!validateEmail($('input[name=email]').val())) {
            $(error).html('Please enter a valid email.');
            sendRequest = false;
          }
        }

        //Validate date of birth
        if($('input[name=dob]').is(":visible")) {
          if(!validateDate($('input[name=dob]').val())) {
            $(error).html('Invalid date of birth format. mm/dd/yyyy');
            sendRequest = false;
          }
        }

        //Validate passport expiration
        if($('input[name=passportexp').is(":visible")) {
          if(!validateDate($('input[name=passportexp]').val())) {
            $(error).html('Invalid passport expiration format. mm/dd/yyyy');
            sendRequest = false;
          }
        }

        //Validate phone number
        if((5 > $('input[name=phonenum]').val().length || $('input[name=phonenum]').val().length > 11) && $('input[name=phonenum]').is(":visible") && isNumber($('input[name=phonenum]').val())) {
          $(error).html('Phone number must be 5-11 digits.');
          sendRequest = false;
        }

        if (sendRequest) {
          var url = "authentication.php";
          $.ajax({
            type: "POST",
            url: url,
            data: $("#signupForm").serialize(),
          }).done(function(data) {
            var identifier = "";
            var account_type = $('input[name=account_type]:checked').val();
            if(account_type == "customer" || account_type == "booking_agent") {
              identifier = $('input[name=email]').val();
            } else if(account_type == "airline_staff"){
              identifier = $('input[name=username]').val();
            }
            window.location.replace("home.php?identifier=" + identifier + "&type=" + account_type);
          }).fail(function(xhr, status, error) {
            $('#error-msg').html(xhr.responseText);
          });
        }
      });

      changeForm();
    </script>
  </body>
</html>