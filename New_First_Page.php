?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
   <title>Εγγραφή Πελάτη</title>
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
        <h1 style="color:MediumSeaGreen;">Beauty Centre Maria Pappa</h1>
    </header>
    <form id="form_temp" class="input-group" method="post" style="float:left">
        <label for="fname">Όνομα:</label><br>
        <input type="text" id="fname_temp" class="input-field" value='' autocomplete='off' required minlength="0" maxlength="20"><br><br>
        <label for="lname">Επίθετο:</label><br>
        <input type="text" id="lname_temp" class="input-field" value='' autocomplete='off' required minlength="0" maxlength="15"> <br><br>
        <label for="phone">Κινητό Τηλέφωνο:</label><br>
        <input type="text" id="phone_temp" class="input-field" value='' autocomplete='off' minlength="0" maxlength="10"  required><br><br>
        <label for="appt">Διάλεξε Ώρα και Ημερομηνία Για Το Ραντεβού:</label><br>
            <input type="time" id="appt_time"  min="08:00" max="22:00" required>
            <input type="date" id="appt_temp" class="input-field" value='' autocomplete='off'><br>
            <p>Ώρες Γραφείου 08:00am-10:00pm</p><br><br>
        <input class="submit-btn" type="button" value="Προσωρινή Εγγραφή-Εύρεση Πελάτη" id="submit_temp">
        <input type="button" value='Reset Στοιχείων' onclick="form_temp.reset();"><br><br>
        <input class="submit-btn" type="button" value="Φόρμα Εγγραφής Πελάτη" id="go_to_reg"><br><br>
       
        <!--<input class="submit-btn" type="button" value="New Appointment" id="new_appointment1"> -->
    </form>
    <form id="form_formal" class="input-group" method="post" style="display:none;float:left">
        <label for="name_beautician">Όνομα Αισθητικού:</label><br>
        <input type="text" id="name_beautician" class="input-field" value='' autocomplete='off'><br><br>
        <label for="email_temp">Email:</label><br>
        <input type="text" id="email_formal" class="input-field" value='' autocomplete='off'><br><br>
        <label for="dof2">Ημερομηνία Γέννησης:</label><br>
        <input type="date" id="dof2" class="input-field" value='' autocomplete='off'><br><br>
        <label for="afm_formal">ΑΦΜ:</label><br>
        <input type="text" id="afm_formal" class="input-field" value='' autocomplete='off' maxlength=""><br><br>
        <div id="list1" class="dropdown-check-list" tabindex="100">
            <span class="anchor">Επιλογή Μέρος Σώματος Θεραπείας:</span>
            <ul class="items">
                    <li><input type="checkbox" value="face" name="part" id="face"/>Πρόσωπο</li>
                    <li><input type="checkbox" value="breast" name="part" id="breast"/>Στήθος</li>
                    <li><input type="checkbox" value="body" name="part" id="body"/>Σώμα</li>
                    <li><input type="checkbox" value="all" name="part" id="all"/>Όλα τα παραπάνω</li>
            </ul>
            </div><br><br>
        <label for="Comments">Σχόλια Θεραπείας:</label><br>
        <textarea name="message" id="Textarea_formal" rows="10" cols="30">Γράψτε Εδώ</textarea><br><br>
        <input class="submit-btn" type="button" value="Επίσημη Εγγραφή Πελάτη" id="submit_formal"> <br><br>
    </form> 
    <form id="form_for_appntm_third_page" method="post" class="input-group" style="float:left">
      <label for="ΑΦΜ">ΑΦΜ:</label><br>
      <input type="text" name="afm" id="afm"/><br><br>
      <label for="Phone">Τηλέφωνο:</label><br>
      <input type="text" name="part" id="phone"/><br><br>
      <button id="update_page_button" name="update_button_page" type="button" >Σελίδα Ανανέωσης Στοιχείων</button>   
     <button id="third_page_button" name="next_button_third_page" type="button" >Σελίδα Στοιχείων Πελάτη</button>
      
    </form>
    <!--<button id="back_table" type="button">Back</button> -->
    
    <br><br>        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
  </body>
</html>