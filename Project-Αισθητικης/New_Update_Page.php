<!DOCTYPE html>
<html>
<?php
// Start the session
session_start();
$db = mysqli_connect('localhost','root','','spa') or die("could not connect to database");
//echo $_SESSION['phone'];
if(isset($_SESSION['afm']) != FALSE ):
    //echo "Body_Part: ".$_SESSION['body_part']."  Email:".$_SESSION['email'];
    //isset($_SESSION['firstname']) && isset($_SESSION['lastname']) && isset($_SESSION['email']) && isset($_SESSION['phone'])
    
?>
  <head>
   <title>Ανανέωση Στοιχείων</title>
   <link rel="stylesheet" type="text/css" media="screen"/> 
   </head>
  <body>
    <header>
        <h1 style="color:MediumSeaGreen;"> <a href="First_Page.php">Welcome Spa Thivas</a></h1>
        <h2 id="header2" style="color:MediumSeaGreen;">ΑΦΜ Πελάτη:<?php echo $_SESSION['afm']; ?><h2>
        <form method="post">
            <button id="back_to_first" name="unset" type="submit">Αρχική Σελίδα</button><br><br>
            <?php
            //echo "im in"; 
            if(isset($_POST["unset"])){
                session_unset(); 
                header("location: New_First_Page.php");} 
            ?>
        </form>
    </header>
        <?php if((isset($_SESSION['afm']) != FALSE )): ?>
            <button id="show_health" type="button" style="float:left">Φόρμα Αλλαγής Υγείας</button>
            <button id="show_habits" type="button" style="float:left">Φόρμα Αλλαγής Συνηθειών</button>
            <button id="show_data" type="button" style="float:left">Φόρμα Αλλαγής Στοιχείων</button><br><br>
            <form id="form_health" class="input-group" style="float:left"> <!--style="display:none;" -->
                         <p style="font-size:20px;">Στοιχεία Πελάτη</p>
                        <label for="height">Ύψος:</label>
                        <input type="number" id="height" placeholder="cm"  class="input-field" value='' autocomplete='off'><br><br>
                        <label for="weight">Βάρος:</label>
                        <input type="number" id="weight" placeholder="Kilos" class="input-field" value='' autocomplete='off'><br><br>
                        <label for="health">Υγεία:</label>
                        <select name="health" id="health">
                          <option value="good">Καλή</option>
                          <option value="medium">Μέτρια</option>
                          <option value="bad">Κακή</option>
                        </select><br>
                        <textarea name="message" id="Textarea_health" rows="3" cols="15">Γράψτε Εδώ</textarea><br><br>
                        <label for="sleep">Ύπνος:</label>
                        <select name="Sleep" id="sleep">
                          <option value="normal">Φυσιολογικός</option>
                          <option value="disrupted">Με Διαταραχές</option>
                        </select><br>
                        <textarea name="message" id="Textarea_sleep" rows="3" cols="15">Γράψτε Εδώ</textarea><br><br>
                        <label for="appetite">Όρεξη:</label>
                        <select name="Appetite" id="appetite">
                          <option value="normal">Φυσιολογική</option>
                          <option value="disrupted">Κομμένη</option>
                          <option value="disrupted">Με Εναλλαγές</option>
                        </select><br>
                        <textarea name="message" id="Textarea_appetite" rows="3" cols="15">Γράψτε Εδώ</textarea><br><br>
                        <label for="Comments">Ασθένειες:</label><br>
                        <textarea name="message" id="Textarea_diseases" rows="3" cols="15">Γράψτε Εδώ.</textarea><br><br>
                        <label for="Comments">Φάρμακα:</label><br>
                        <textarea name="message" id="Textarea_meds" rows="3" cols="15">Γράψτε Εδώ</textarea><br><br>
                        <label for="Comments">Επεμβάσεις:</label><br>
                        <textarea name="message" id="Textarea_surgery" rows="3" cols="15">Γράψτε Εδώ</textarea><br><br>
                        <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_update_health"><br><br>   
            </form> 
            <form id="form_habits" class="input-group" style="margin-left:100px;float:left"> 
                    <p style="font-size:20px;">Διατροφικές-Ατομικές Συνήθειες</p>
                    <label for="Dairy">Γαλακτοκομικά:</label>
                    <select name="Dairy" id="dairy">
                        <option value="None"></option>
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <option value="Occasionally">Περιστασιακά</option>
                    </select><br><br>
                    <label for="smoking">Κάπνισμα:</label>
                    <select name="smoking" id="smoke">
                        <option value="None"></option>
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <option value="Occasionally">Περιστασιακά</option>
                    </select><br><br>
                    <label for="Drinking">Κατανάλωση Αλκοόλ:</label>
                    <select name="drinking" id="drink">
                        <option value="None"></option>
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <option value="Occasionally">Περιστασιακά</option>
                    </select><br><br>
                    <label for="Exercising">Άθληση:</label>
                    <select name="Exercising" id="exercise">
                        <option value="None"></option>   
                        <option value="Yes">Ναι</option>
                        <option value="No">Όχι</option>
                        <option value="Occasionally">Περιστασιακά</option>
                    </select><br><br>
                    <label for="Salt">Αλάτι:</label>
                    <select name="Salt" id="salt">
                        <option value="None"></option>   
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <option value="Occasionally">Περιστασιακά</option>
                    </select><br><br>
                    <label for="Water">Νερό:</label>
                    <select name="Water" id="water">
                        <option value="None"></option>   
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <option value="Occasionally">Περιστασιακά</option>
                    </select><br><br>
                    <label for="Sugar">Ζάχαρι:</label>
                    <select name="Sugar" id="sugar">
                        <option value="None"></option>   
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <option value="Occasionally">Περιστασιακά</option>
                    </select><br><br>
                    <label for="Digestive Tract">Πεπτικό Σύστημα:</label><br>
                    <textarea name="message" id="Textarea_digestive_tract" rows="3" cols="15">Γράψτε Εδώ</textarea><br><br>
                    <label for="Pregnacy">Εγκυμοσύνη:</label>
                    <select name="Pregnacy" id="pregnacy">
                        <option value="None"></option>
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <input type="number" id="pregnacy_month" class="input-field" placeholder="Μήνας Εγκυμοσύνης" value='' autocomplete='off'>
                    </select><br><br>
                    <label for="Dermatosis">Δερματοπάθειες:</label><br>
                    <textarea name="message" id="Textarea_dermatosis" rows="3" cols="15">Γράψτε Εδώ</textarea><br><br>
                    <label for="Children">Παιδιά:</label><br>
                    <input type="number" id="children" placeholder="children" class="input-field" value='' autocomplete='off'><br><br>
                    <label for="Age">Ηλικία:</label><br>
                    <input type="age" id="age" placeholder="age" class="input-field" value='' autocomplete='off'><br><br>
                    <label for="Βreast Feeding">Θηλασμός:</label>
                    <select name="Βreast Feeding" id="breast_feeding">
                        <option value="None"></option>
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                        <option value="Future">Στο μέλλον</option>
                    </select><br><br>
                    <label for="Menstruation">Εμμηνόρροια:</label> <!--menstruation=περιοδος -->
                    <select name="Menstruation" id="menstruation">
                        <option value="None"></option>
                        <option value="Normal">Κανονικη</option>
                        <option value="Αbnormal">Ασυνήθιστη</option>
                        <option value="Αbsence">Απουσία</option>
                        <option value="Αbsence">Οδυνηρή</option>
                    </select>
                    <textarea name="message" id="Textarea_menstruation_time" rows="3" cols="15">Διάρκεια</textarea>
                    <textarea name="message" id="Textarea_menstruation_frequency" rows="3" cols="15">Συχνότητα</textarea><br><br>
                    <label for="Μenopause">Εμμηνόπαυση:</label>
                    <select name="Μenopause" id="menopause">
                        <option value="None"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select><br><br>
                    <label for="Sex_Life">Σεξουαλική Ζωή:</label>
                    <select name="Sex Life" id="sex_life">
                        <option value="None"></option>
                        <option value="Yes">Κανονική</option>
                        <option value="No">Σποραδική</option>
                    </select><br><br>
                    <label for="Βirth control">Χάπια Αντισύλληψης:</label>
                    <select name="Βirth control " id="birth_control">
                        <option value="None"></option>
                        <option value="Yes">Ναι</option>
                        <option value="No">Οχι</option>
                    </select>
                    <input type="text" id="birth_control_2" placeholder="Άλλοι Τύποι Αντισύλληψης" class="input-field" value='' autocomplete='off'><br><br>
                    <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_update_habits"><br><br>
            </form>
            <form id="form_data" class="input-group" style="margin-left:20px;float:left">
                <p style="font-size:20px;">Προσωπικά Δεδομένα Χρήστη</p>
                <label for="fname">Όνομα:</label><br>
                <input type="text" id="fname_temp" class="input-field" value='' autocomplete='off' required minlength="0" maxlength="20"><br><br>
                <label for="lname">Επίθετο:</label><br>
                <input type="text" id="lname_temp" class="input-field" value='' autocomplete='off' required minlength="0" maxlength="15"> <br><br>
                <label for="phone">Κινητό Τηλέφωνο:</label><br>
                <input type="text" id="phone_temp" class="input-field" value='' autocomplete='off' minlength="0" maxlength="10"  required><br><br>
                <label for="name_beautician">Όνομα Αισθητικού:</label><br>
                <input type="text" id="name_beautician" class="input-field" value='' autocomplete='off'><br><br>
                <label for="email_temp">Email:</label><br>
                <input type="text" id="email_formal" class="input-field" value='' autocomplete='off'><br><br>
                <label for="dof2">Ημερομηνία Γέννησης:</label><br>
                <input type="date" id="dof2" class="input-field" value='' autocomplete='off'><br><br>
                <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_update_personal_data"> <br><br>
                <br><br>
                </form> 
        <?php endif ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
<?php else: header("location: New_First_Page.php"); ?>
  </body>
</html>
<?php endif ?>