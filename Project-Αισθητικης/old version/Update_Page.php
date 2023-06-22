<!DOCTYPE html>
<html>
<?php
// Start the session
session_start();
if(isset($_SESSION['firstname']) && isset($_SESSION['lastname']) && isset($_SESSION['email']) && isset($_SESSION['phone'])):
    //echo "Body_Part: ".$_SESSION['body_part']."  Email:".$_SESSION['email'];
?>
  <head>
   <title>Ανανέωση Στοιχείων</title>
   <link rel="stylesheet" type="text/css" media="screen"/> 
   </head>
  <body>
    <header>
        <h1 style="color:MediumSeaGreen;"> <a href="First_Page.php">Welcome Spa Thivas</a></h1>
        <h2 id="header2" style="color:MediumSeaGreen;">Current Customer:<?php echo $_SESSION['email']; ?><h2>
        <form method="post">
            <button id="back_to_first" name="unset" type="submit">First Page</button><br><br>
            <?php
            //echo "im in"; 
            if(isset($_POST["unset"])){
                session_unset(); 
                header("location: First_Page.php");} 
            ?>
        </form>
    </header>
        <?php if((isset($_SESSION['email']) != FALSE )): ?>
            <button id="show_health" type="button" style="float:left">Show Health Form</button>
            <button id="show_habits" type="button" style="float:left">Show Habits Form</button>
            <button id="show_data" type="button" style="float:left">Show Data Form</button><br><br>
                <form id="form_health" class="input-group" style="display:none;float:left"> 
                    <p style="font-size:20px;">Στοιχεία Πελάτη</p>
                    <label for="height">Height:</label><br>
                                    <input type="number" id="height" placeholder="cm"  class="input-field" value='' autocomplete='off'><br><br>
                                    <label for="weight">Weight:</label><br> 
                                    <input type="number" id="weight" placeholder="Kilos" class="input-field" value='' autocomplete='off'><br><br>
                                    <label for="sleep">Sleep:</label>
                                    <select name="Sleep" id="sleep">
                                    <option value="normal">Normal</option>
                                    <option value="disrupted">Disrupted</option>
                                    </select><br><br>
                                    <label for="health">Health:</label>
                                    <select name="health" id="health">
                                    <option value="good">Good</option>
                                    <option value="medium">Medium</option>
                                    <option value="bad">Bad</option>
                                    </select><br>
                                    <textarea name="message" id="Textarea_health" rows="3" cols="25">Type the therapy of the patient.</textarea><br><br>
                                    </div>
                                    <label for="Comments">Diseases:</label><br>
                                    <textarea name="message" id="Textarea_diseases" rows="3" cols="25">Types of diseases of the patient.</textarea><br><br>
                                    <label for="Comments">Meds:</label><br>
                                    <textarea name="message" id="Textarea_meds" rows="3" cols="25">Types of meds of the patient.</textarea><br><br>
                                    <label for="Comments">Surgery:</label><br>
                                    <textarea name="message" id="Textarea_surgery" rows="3" cols="25">Type surgery of the patient.</textarea><br><br>
                                    <input class="submit-btn" type="button" value="Submit" id="submit_update_page"><br><br>   
                                    
                </form> 
                <form id="form_habits" class="input-group" style="display:none;margin-left:20px;float:left"> 
                    <p style="font-size:20px;">Διατροφικές-Ατομικές Συνήθειες</p>
                    <label for="sleep">Smoking:</label>
                    <select name="smoking" id="smoke">
                        <option value="None"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Occasionally">Occasionally</option>
                    </select><br><br>
                    <label for="Drinking">Drinking:</label>
                    <select name="drinking" id="drink">
                        <option value="None"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Occasionally">Occasionally</option>
                    </select><br><br>
                    <label for="Exercising">Exercising:</label>
                    <select name="Exercising" id="exercise">
                        <option value="None"></option>   
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Occasionally">Occasionally</option>
                    </select><br><br>
                    <label for="Pregnacy">Pregnacy:</label>
                    <select name="Pregnacy" id="pregnacy">
                        <option value="None"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select><br><br>
                    <label for="Βreast Feeding">Βreast Feeding:</label>
                    <select name="Βreast Feeding" id="breast_feeding">
                        <option value="None"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Future">In the future</option>
                    </select><br><br>
                    <label for="Μenopause">Μenopause:</label>
                    <select name="Μenopaus" id="menopause">
                        <option value="None"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select><br><br>
                    <label for="Menstruation">Menstruation:</label> <!--menstruation=περιοδος -->
                    <select name="Menstruation" id="menstruation">
                        <option value="None"></option>
                        <option value="Normal">Normal</option>
                        <option value="Αbnormal">Αbnormal</option>
                        <option value="Αbsence">Αbsence </option>
                    </select><br><br>
                    <label for="Βirth control">Βirth control:</label>
                    <select name="Βirth control " id="birth_control">
                        <option value="None"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select><br><br>
                    <input class="submit-btn" type="button" value="Submit" id="submit_habits_update"><br><br>
                </form>
                <form id="form2" class="input-group" style="display:none;margin-left:20px;float:left">
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
                    <label for="Comments">Comments for Therapy:</label><br>
                    <textarea name="message" id="Textarea" rows="10" cols="30">Type the therapy of the patient.</textarea><br><br>
                    <input class="submit-btn" type="button" value="Submit" id="submit_update_2"> <br><br>
                    <br><br>
                </form> 
        <?php endif ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
<?php else: header("location: First_Page.php"); ?>
  </body>
</html>
<?php endif ?>