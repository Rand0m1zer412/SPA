<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
   <title>Αρχική</title>
    <link rel="stylesheet" type="text/css"  media="screen"/> 
    <style>
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 30%;
      }

          td, th {
        border: 0.5px solid #dddddd;
        text-align: left;
      
      }

          tr:nth-child(even) {
        background-color: #dddddd;
        }
    </style>
  </head>
  <body>
    <header>
        <h1 style="color:MediumSeaGreen;">Welcome Spa Thivas</h1>
    </header>
    <form id="form1" class="input-group" method="post" style="float:left">
        <label for="fname">First name:</label><br>
        <input type="text" id="fname" class="input-field" value='' autocomplete='off' required minlength="2" maxlength="20"><br><br>
        <label for="lname">Last name:</label><br>
        <input type="text" id="lname" class="input-field" value='' autocomplete='off' required minlength="2" maxlength="15"> <br><br>
        <label for="email">E-mail:</label><br>
        <input type="text" id="email" class="input-field" name='email_third_page' value='' autocomplete='off'><br><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone1" class="input-field" value='' autocomplete='off'><br><br>
        <input class="submit-btn" type="button" value="Search Client Data" id="submit">
        
        <!--<input class="submit-btn" type="button" value="New Appointment" id="new_appointment1"> -->
        <input type="button" value='Reset Form' onclick="form1.reset();"><br><br>
        <input class="submit-btn" type="button" value="Register New Client" id="go_to_reg">
        
    </form>
    <form id="form_for_appntm_third_page" method="post" class="input-group" style="display:none;">
      <div id="list_third_page" class="dropdown-check-list" tabindex="100" >
                        <span class="anchor">Select Body Part:</span>
                        <ul class="items_third">
                            <li><input type="checkbox" value="body" name="part_third" id="body_third"/>Body</li>
                            <li><input type="checkbox" value="chest" name="part_third" id="breast_third"/>Chest</li>
                            <li><input type="checkbox" value="face" name="part_third" id="face_third"/>Face</li>
                            <li><input type="checkbox" value="all" name="part_third" id="all_third"/>All the above</li>
                        </ul>
     </div><br>
     <button id="update_page_button" name="update_button_page" type="button" >Go Update Page</button>   
     <button id="third_page_button" name="next_button_third_page" type="button" >Go Next Page</button>
      
    </form>
    <!--<button id="back_table" type="button">Back</button> -->
    <p id="message"></p>
    <form id="form2" class="input-group" style="display:none;">
                <label for="fname2">First name:</label><br>
                <input type="text" id="fname2" class="input-field" value='' autocomplete='off' required minlength="2" maxlength="20"><br><br>
                <label for="lname2">Last name:</label><br> 
                <input type="text" id="lname2" class="input-field" value='' autocomplete='off' required minlength="2" maxlength="15"><br><br>
                <label for="dof2">Date of Birth:</label><br>
                <input type="date" id="dof2" class="input-field" value='' autocomplete='off'><br><br>
                <label for="email2">Email:</label><br>
                <input type="text" id="email2" class="input-field" value='' autocomplete='off'><br><br>
                <label for="phone">Phone:</label><br>
                <input type="text" id="phone" class="input-field" value='' autocomplete='off'><br><br>
                <label for="Next Appointment">Next Appointment:</label><br>
                <input  type="date" id="appntm" class="input-field" value='' autocomplete='off'><br><br>
                <div id="list1" class="dropdown-check-list" tabindex="100">
                  <span class="anchor">Select Body Part:</span>
                  <ul class="items">
                    <li><input type="checkbox" value="body" name="part" id="body"/>Body</li>
                    <li><input type="checkbox" value="chest" name="part" id="chest"/>Chest</li>
                    <li><input type="checkbox" value="face" name="part" id="face"/>Face</li>
                    <li><input type="checkbox" value="all" name="part" id="all"/>All the above</li>
                  </ul>
                </div><br><br>
                <label for="Comments">Comments for Therapy:</label><br>
                <textarea name="message" id="Textarea" rows="10" cols="30">Type the therapy of the patient.</textarea><br><br>
                <input class="submit-btn" type="button" value="Submit" id="submit2"> <br><br>
                <button id="back" type="button" >Back</button>
                <button id="next" type="button" >Next</button>
                <br><br>
    </form> 
    <br><br>        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
  </body>
</html>
<!-- <form action="/action_page.php">
  <label for="appt">Select a time:</label>
  <input type="time" id="appt" name="appt">
  <input type="submit">
</form>-->