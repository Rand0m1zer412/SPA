<?php
// Start the session
session_start();
$db = mysqli_connect('localhost','root','','spa') or die("could not connect to database");
if((isset($_SESSION['phone']) == FALSE )){
    header('location: New_First_Page.php');
  }
?>
<!DOCTYPE html>
<html>
<style>
table, th, td {
  border:1px solid black;
}
</style>
  <head>
   <title>Στοιχεία Υγείας</title>
   <link rel="stylesheet" type="text/css"  media="screen"/> 
   </head>
  <body>
    <header>
        <h1 style="color:MediumSeaGreen;"> <a href="First_Page.php">Welcome Spa Thivas</a></h1>
        <h2 id="header2" style="color:MediumSeaGreen;">Current Customer:
            <?php 
            $local_phone = $_SESSION['phone'];
            //echo $local_phone;
            $my_query="SELECT email,body_part_treatment FROM personal_data WHERE phone= $local_phone";
            $result_query = mysqli_query($db, $my_query);
            if($result_query!=FALSE){

                $final = mysqli_fetch_assoc($result_query);
                echo json_encode($final['email']);
                
                $_SESSION['body_part_treatment'] = $final['body_part_treatment'];
                echo $_SESSION['body_part_treatment'];
            }
            ?>
            <br>
            <form action="" method="post">
                <button id="back_to_first" name="return_button_first_page" type="submit">Αρχική</button>
                <?php if(isset($_POST["return_button_first_page"])){
                    session_unset();
                    header("location: New_First_Page.php");} ?>
            </form>
            </h2>
    </header>
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
                        <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_health"><br><br>   

                        <?php if($_SESSION['body_part_treatment']=='body'): ?>
                            <button id="back_health_body" type="button" >Πίσω Φόρμα</button>
                        <?php endif; ?>   
                        <?php if($_SESSION['body_part_treatment']=='breast'): ?>
                            <button id="back_health_all" type="button" >Πίσω Φόρμα</button>
                        <?php endif; ?>   
                        <?php if($_SESSION['body_part_treatment']=='face'): ?>
                            <button id="back_health_all" type="button" >Πίσω Φόρμα</button>
                        <?php endif; ?>           
                        <?php if($_SESSION['body_part_treatment']=='all'): ?>
                            <button id="back_health_all" type="button" >Πίσω Φόρμα</button>
                        <?php endif; ?>  
                        <button id="next_health" type="button">Επόμενη Φόρμα</button> 
    </form> 
    <form id="form_habits" class="input-group" style="display:none;margin-left:20px;float:left"> 
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
        <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_habits"><br><br>
        <button id="back_habits" type="button" >Πίσω Φόρμα</button>
        <?php if($_SESSION['body_part_treatment']=='face'): ?>
            <button id="next_habits_face" type="button" >Επόμενη Φόρμα</button>
        <?php elseif($_SESSION['body_part_treatment']=='breast'): ?>
            <button id="next_habits_breast" type="button" >Επόμενη Φόρμα</button>
        <?php elseif($_SESSION['body_part_treatment']=='body'): ?>
            <button id="next_habits_body" type="button" >Επόμενη Φόρμα</button>
        <?php elseif($_SESSION['body_part_treatment']=='all'): ?>
            <button id="next_habits_all" type="button" >Επόμενη Φόρμα</button>
        <?php endif; ?>
        <?php if(($_SESSION['body_part_treatment']=='breast,body') OR( $_SESSION['body_part_treatment']=='body,breast')): ?>
            <button id="next_habits_body_breast" type="button" >Επόμενη Φόρμα</button>
        <?php endif; ?>
        <?php if(($_SESSION['body_part_treatment']=='body,face')OR( $_SESSION['body_part_treatment']=='face,body')): ?>
            <button id="next_habits_body_face" type="button" >Επόμενη Φόρμα</button>
        <?php endif; ?>
        <?php if(($_SESSION['body_part_treatment']=='breast,face')OR( $_SESSION['body_part_treatment']=='breast,face')): ?>
            <button id="next_habits_breast_face" type="button" >Επόμενη Φόρμα</button>
        <?php endif; ?>  
    </form>
    <form id="form_face" class="input-group" style="display:none;margin-left:20px;float:left"> 
        <?php if($_SESSION['body_part_treatment']=='face' or $_SESSION['body_part_treatment']=='all' 
        OR $_SESSION['body_part_treatment']=='body,face'  OR $_SESSION['body_part_treatment']=='chest,face'): ?>
            <p style="font-size:20px;">Πρόσωπο</p>
            <select name="Face" id="type_of_face">
                <option value="None"></option>
                <option value="Normal">Κανονική Επιδερμίδα</option>
                <option value="Oily">Λιπαρή Επιδερμίδα</option>
                <option value="Dry">Ξηροδερμία</option>
                <option value="Mixed">Ανάμεικτη Επιδερμίδα</option>
            </select><br><br>
        <label for="Skin Type">Περιγραφή Επιδερμίδας:</label><br>
        <textarea name="message" id="Textarea_description" rows="3" cols="25">Περιγραφή</textarea><br><br>
        <label for="Skin Type">Περιποιήση Προσώπου:</label><br>
        <textarea name="message" id="Textarea_facial" rows="3" cols="25">Περιγραφή</textarea><br><br>
        <label for="Skin Type">Περιποιήση Προσώπου(Παρελθόν):</label><br>
        <textarea name="message" id="Textarea_facial_past" rows="3" cols="25">Περιγραφή</textarea><br><br>
        <label for="Skin Type">Επεμβάσεις:</label><br>  
        <textarea name="message" id="Textarea_surgery_face" rows="3" cols="25">Περιγραφή</textarea><br><br>
        <table>
            <tr>
                <th>Θεραπεία Καμπίνας</th>
                <th>Ημερομηνία</th>
                <th>Προίοντα</th>
            </tr>
            <tr>
                <td>1η Θεραπεία</td>
                <td><input  type="date" id="date_face_1" class="input-field" value='' autocomplete='off'></td>
                <td><input type="text" id="products_face_1" class="input-field" value='' autocomplete='off'></td>
            </tr>
        </table>
        <label for="Comments">Αποτελέσματα:</label><br>
        <textarea name="message" id="Textarea_face_results" rows="3" cols="25"></textarea><br><br>
        <label for="Comments">Προίοντα Θεραπείας Για το Σπίτι:</label><br>
        <textarea name="message" id="Textarea_face_therapy" rows="3" cols="25"></textarea><br><br>
        <label for="Comments">Συμβουλή Διατροφής:</label><br>
        <textarea name="message" id="Textarea_face_nutrition" rows="3" cols="25"></textarea><br><br>
        <label for="Comments">Σχόλια:</label><br>
        <textarea name="message" id="Textarea_face_comms" rows="3" cols="25"></textarea><br><br> 
        <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_face"><br><br> 
            <?php if($_SESSION['body_part_treatment']=='face'): ?>
                <button id="back_face" type="button" >Προηγούμενη Φόρμα</button>
                <button id="next_face" type="button" >Επόμενη Φόρμα</button>
            <?php endif; ?>  
            <?php if($_SESSION['body_part_treatment']=='all'): ?>
                <button id="back_face_all" type="button" >Προηγούμενη Φόρμα</button>
                <button id="next_face_all" type="button" >Επόμενη Φόρμα</button>
            <?php endif; ?>  
            <?php if($_SESSION['body_part_treatment']=='body,face' OR $_SESSION['body_part_treatment']=='face,body'): ?>
                        <button id="back_face_body" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_face_health" type="button" >Επόμενη Φόρμα</button>
            <?php endif; ?>      
            <?php if($_SESSION['body_part_treatment']=='breast,face'): ?>
                        <button id="back_face_breast" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_face_health" type="button" >Επόμενη Φόρμα</button>
            <?php endif; ?>      
        <?php endif; ?>       
    </form>
    <form id="body" class="input-group" style="display:none;margin-left:50px;float:left"> 
            <?php if($_SESSION['body_part_treatment']=='body' or $_SESSION['body_part_treatment']=='all' or $_SESSION['body_part_treatment']=='body,breast' or $_SESSION['body_part_treatment']=='breast,body' OR $_SESSION['body_part_treatment']=='body,face'): ?>
                <p style="font-size:20px;">Σώμα</p>
                <select name="Natural Type" id="natural_type">
                    <option value="None"></option>
                    <option value="Intensity">Ένταση</option>
                    <option value="Perfusion">Αιμάτωση</option>
                    <option value="Spider veins">Ευρυαγγείες</option>
                    <option value="Cellulite">Κυταρίτιδα</option>
                    <option value="body fat">Λίπος</option>
                    <option value="Asymmetrical ">Παγάδες</option>
                    <option value="Scars">Ουλές</option>
                    <option value="Acne">Ακμή</option>
                    <option value="Other">Άλλο</option>
                </select><br><br>
                <textarea name="message" id="Textarea_body_type" rows="3" cols="25">Σχόλια Τύπου Σώματος</textarea><br><br>

                <label for="Comments_Breast_Care_Past">Συνηθισμένη Περιποιήση Σώματος:</label><br>
                <textarea name="message" id="Textarea_body_care" rows="3" cols="25"></textarea><br><br>
                
                <label for="Comments_Breast_Care_Past">Συνηθισμένη Περιποιήση Σώματος(Παρελθόν):</label><br>
                <textarea name="message" id="Textarea_body_care_past" rows="3" cols="25"></textarea><br><br>

                <label for="Skin Type">Επεμβάσεις:</label><br>  
                <textarea name="message" id="Textarea_surgery_body" rows="3" cols="25"></textarea><br><br> 

                <div id="list1" class="dropdown-check-list" tabindex="100" style="float:left">
                            <span class="anchor">Επιλογή Μέρος Σώματος:</span>
                            <ul class="items">
                                <li><input type="checkbox" value="middle" name="part" id="middle"/>Μέση</li>
                                <li><input type="checkbox" value="hip" name="part" id="hip"/>Ισχίο</li>
                                <li><input type="checkbox" value="right thigh" name="part" id="right_thigh"/>Δεξιός μηρός</li>
                                <li><input type="checkbox" value="left thigh" name="part" id="left_thigh"/>Αριστερός μηρός</li>
                                <li><input type="checkbox" value="right knee" name="part" id="right_knee"/>Δεξί Γόνατο</li>
                                <li><input type="checkbox" value="left knee" name="part" id="left_knee"/>Αριστερό Γόνατο</li>
                                <li><input type="checkbox" value="right ankle" name="part" id="right_ankle"/>Δεξιός Αστράγαλος</li>
                                <li><input type="checkbox" value="left ankle" name="part" id="left ankle"/>Αριστερός αστράγαλος</li>
                                <li><input type="checkbox" value="all" name="part" id="all"/>Όλα τα Παραπάνω</li>
                            </ul><br><br>
                </div><br><br>
                    <table name='Μετρήσεις Πριν τη Θεραπεία'>
                        <tr>
                            <th>Μετρήσεις Πριν Τη Θεραπεία</th>
                            <th>1η Θεραπεία</th>                      
                        </tr>
                        <tr>
                            <td>Μέση</td>
                            <td><input type="text" id="body_middle" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Ισχίο</td>
                            <td><input type="text" id="body_hip" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Δεξιός μηρός</td>
                            <td><input type="text" id="body_right_thigh" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Αριστερός μηρός</td>
                            <td><input type="text" id="body_left_thigh" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Δεξί Γόνατο</td>
                            <td><input type="text" id="body_right_knee" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Αριστερό Γόνατο</td>
                            <td><input type="text" id="body_left_knee" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Δεξιός Αστράγαλος</td>
                            <td><input type="text" id="body_right_ankle" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Αριστερός αστράγαλος</td>
                            <td><input type="text" id="body_left_ankle" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                    </table><br><br>
                    <table name='Θεραπεία Καμπίνας'>
                        <tr>
                            <th>Θεραπεία Καμπίνας</th>
                            <th>Ημερομηνία</th>
                            <th>Προίοντα</th>
                        </tr>
                        <tr>
                            <td>1η Θεραπεία</td>
                            <td><input  type="date" id="date_body_1" class="input-field" value='' autocomplete='off'></td>
                            <td><input  type="text" id="date_body_products_1" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                    </table><br><br>
                    <table name='Μετρήσεις Μετά τη Θεραπεία'>
                        <tr>
                            <th>Μετρήσεις Μετά τη Θεραπεία</th>
                            <th>1η Θεραπεία</th>                      
                        </tr>
                        <tr>
                            <td>Μέση</td>
                            <td><input type="text" id="body_middle_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Ισχίο</td>
                            <td><input type="text" id="body_hip_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Δεξιός μηρός</td>
                            <td><input type="text" id="body_right_thigh_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Αριστερός μηρός</td>
                            <td><input type="text" id="body_left_thigh_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Δεξί Γόνατο</td>
                            <td><input type="text" id="body_right_knee_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Αριστερό Γόνατο</td>
                            <td><input type="text" id="body_left_knee_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Δεξιός Αστράγαλος</td>
                            <td><input type="text" id="body_right_ankle_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                        <tr>
                            <td>Αριστερός αστράγαλος</td>
                            <td><input type="text" id="body_left_ankle_after" class="input-field" value='' autocomplete='off'></td>
                        </tr>
                    </table><br><br>
                    <label for="Comments">Σχόλια:</label><br>
                    <textarea name="message" id="Textarea_body_comms" rows="3" cols="25"></textarea><br><br>
                    <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_body"><br><br> 
                    <?php if($_SESSION['body_part_treatment']=='body'): ?>
                        <button id="back_body" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_body" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
                    <?php if($_SESSION['body_part_treatment']=='all'): ?>
                        <button id="back_body_all" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_body_all" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
                    <?php if($_SESSION['body_part_treatment']=='body,breast' OR $_SESSION['body_part_treatment']=='breast,body'): ?>
                        <button id="back_body_breast" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_body_breast" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
                    <?php if($_SESSION['body_part_treatment']=='body,face' OR $_SESSION['body_part_treatment']=='face,body'): ?>
                        <button id="back_body_face" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_body_face" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
                    
            <?php endif; ?>   
    </form>
    <form id="form_breast" class="input-group" style="display:none;margin-left:20px;float:left"> 
        <?php if($_SESSION['body_part_treatment']=='breast' or $_SESSION['body_part_treatment']=='all' or $_SESSION['body_part_treatment']=='body,breast' or $_SESSION['body_part_treatment']=='breast,body'
        OR $_SESSION['body_part']=='body,face' OR $_SESSION['body_part']=='breast,face'): ?>
            <p style="font-size:20px;">Στήθος</p>
            <select name="Breast Type" id="breast_type">
                <option value="None"></option>
                <option value="Round">Στρογγυλό</option>
                <option value="East west">Ανατολικό-δυτικό</option>
                <option value="Side set">Πλαϊνό Σετ</option>
                <option value="Close set">Κλειστό Σετ</option>
                <option value="Teardrop">Σχήμα Σταγόνας</option>
                <option value="Narrow">Στενό</option>
                <option value="Asymmetrical ">Ασύμμετρο</option>
                <option value="Bell shape">Σχήμα καμπάνας</option>
                <option value="Athletic">Αθλήτικό</option>
                <option value="Conical">Κωνικό</option>
            </select><br><br>
            <label for="Comments_Breast">Περιγραφή Στήθους:</label><br>
            <textarea name="message" id="Textarea_breast_data" rows="3" cols="25"></textarea><br><br>
            <label for="Comments_Breast_Care">Περιγραφή Συνηθισμένης Περιποιήσης Στήθους:</label><br>
            <textarea name="message" id="Textarea_breast_care" rows="3" cols="25"></textarea><br><br>
            <label for="Comments_Breast_Care_Past">Περιγραφή Περιποιήσης Στήθους(Παρελθόν):</label><br>
            <textarea name="message" id="Textarea_breast_care_past" rows="3" cols="25"></textarea><br><br>
            <label for="Skin Type">Επεμβάσεις:</label><br>  
            <textarea name="message" id="Textarea_surgery_breast" rows="3" cols="25"></textarea><br><br>  
                <table name='Μετρήσεις Πριν τη Θεραπεία'>
                    <tr>
                        <th>Μετρήσεις Πριν τη Θεραπεία</th>
                        <th>1η Θεραπεία</th>                      
                    </tr>
                    <tr>
                        <td>Απόσταση Θήλης στην Άλλη</td>
                        <td><input type="text" id="dis_niple_to_other" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                    <tr>
                        <td>Απόσταση Δεξιάς Θήλης Στον Αφαλό</td>
                        <td><input type="text" id="dis_right_niple_to_navel" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                    <tr>
                        <td>Απόσταση Αριστερής Θήλης Στον Αφαλό</td>
                        <td><input type="text" id="dis_left_niple_to_navel" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                    <tr>
                        <td>Περίγραμμα Στήθους</td>
                        <td><input type="text" id="breast_contour" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                </table><br><br>
                <table name='Θεραπεία Καμπίνας'>
                    <tr>
                        <th>Θεραπεία Καμπίνας</th>
                        <th>Ημερομηνία</th>
                        <th>Προίοντα</th>
                    </tr>
                    <tr>
                        <td>1η Θεραπεία</td>
                        <td><input  type="date" id="date_breast_1" class="input-field" value='' autocomplete='off'></td>
                        <td><input  type="text" id="date_products_1" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                </table><br><br>
                <table name= 'Μετρήσεις Μετά Τη Θεραπεία'>
                    <tr>
                        <th>Μετρήσεις Μετά τη Θεραπεία</th>
                        <th>1η Θεραπεία</th>                      
                    </tr>
                    <tr>
                        <td>Απόσταση Θήλης στην Άλλη</td>
                        <td><input type="text" id="dis_niple_to_other_after" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                    <tr>
                        <td>Απόσταση Δεξιάς Θήλης Στον Αφαλό</td>
                        <td><input type="text" id="dis_right_niple_to_navel_after" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                    <tr>
                        <td>Απόσταση Αριστερής Θήλης Στον Αφαλό</td>
                        <td><input type="text" id="dis_left_niple_to_navel_after" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                    <tr>
                        <td>Περίγραμμα Στήθους</td>
                        <td><input type="text" id="breast_contour_after" class="input-field" value='' autocomplete='off'></td>
                    </tr>
                </table><br><br>
                <label for="Comments">Προτεινόμενα Προίοντα(Σπίτι):</label><br>
                <textarea name="message" id="Textarea_breast_products" rows="3" cols="25"></textarea><br><br>
                <label for="Comments">Συμβουλή Διατροφής:</label><br>
                <textarea name="message" id="Textarea_breast_nutrition" rows="3" cols="25"></textarea><br><br>
                <label for="Comments">Σχόλια:</label><br>
                <textarea name="message" id="Textarea_breast_comms" rows="3" cols="25"></textarea><br><br> 
                <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_breast"><br><br> 
                    <?php if($_SESSION['body_part_treatment']=='breast'): ?>
                        <button id="back_body" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_body" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
                    <?php if($_SESSION['body_part_treatment']=='all'): ?>
                        <button id="back_breast_all" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_breast_all" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
                    <?php if($_SESSION['body_part_treatment']=='body,breast' OR $_SESSION['body_part_treatment']=='breast,body'): ?>
                        <button id="back_breast_body" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_breast_health" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
                    <?php if($_SESSION['body_part_treatment']=='face,breast' OR $_SESSION['body_part_treatment']=='breast,face'): ?>
                        <button id="back_breast_habits" type="button" >Προηγούμενη Φόρμα</button>
                        <button id="next_breast_face" type="button" >Επόμενη Φόρμα</button>
                    <?php endif; ?>  
            <?php endif; ?>       
    </form>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
  </body>
</html>