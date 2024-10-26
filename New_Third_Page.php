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
            <?php 
            $current_afm=$_SESSION['afm'];
            $query_face = "SELECT COUNT(afm) FROM customer_face WHERE afm=$current_afm";
            $result_face = mysqli_query($db,$query_face);
            $final_result_face = mysqli_fetch_all($result_face);
            //print_r($final_result_face[0][0]+1);?>
        </form>
    </header>
    <?php if((isset($_SESSION['afm']) != FALSE )): ?>   
        <label for="Afm">ΑΦΜ:
        <input type="text" id="afm" class="input-field" value='' autocomplete='off'>
        </label><br><br>
        <button id="afm_search" type="button" style="float:left">Αναζήτηση Βάση ΑΦΜ</button>
        <button id="show_data" type="button" style="float:left">Δεδομένα Θεραπείας Χρήστη</button><br><br><br><br>
        <button id="show_face" type="button" style="float:left">Καταχώρηση-Ανανέωση Στοιχείων Προσώπου</button>
        <button id="show_breast" type="button" style="float:left">Καταχώρηση-Ανανέωση Στοιχείων Στήθους</button>
        <button id="show_body" type="button" style="float:left">Καταχώρηση-Ανανέωση Στοιχείων Σώματος</button>

        <form id="form_face" class="input-group" style="display:none;margin-left:20px;float:left">
                <p style="font-size:30px;text-align:center">Πρόσωπο</p><br>
                <table style="width:95%;text-align:center">
                    <tbody>
                        <tr>
                        <th style="width:10%;text-align:center">Επιδερμίδα Προσώπου</th>
                        <th style="width:10%;text-align:center">Περιγραφή Επιδερμίδας</th>
                        <th style="width:10%;text-align:center">Περιποιήση Προσώπου</th>
                        <th style="width:10%;text-align:center">Περιποιήση Προσώπου(Παρελθόν)</th>
                        <th style="width:10%;text-align:center">Επεμβάσεις</th>
                        <th style="width:10%;text-align:center">Θεραπεία Καμπίνα</th>
                        <th style="width:10%;text-align:center">Ημερομηνία</th>
                        <th style="width:10%;text-align:center">Προίοντα</th>
                        <th style="width:10%;text-align:center">Αποτελέσματα</th>
                        <th style="width:10%;text-align:center">Προίοντα Θεραπείας Για το Σπίτι</th>
                        <th style="width:10%;text-align:center">Συμβουλή Διατροφής</th>
                        <th style="width:10%;text-align:center">Σχόλια</th>
                        </tr>
                        <tr>
                        <td style="width:10%;text-align:center"> 
                            <select name="Face" id="type_of_face">
                            <option value="None"></option>
                            <option value="Normal">Κανονική Επιδερμίδα</option>
                            <option value="Oily">Λιπαρή Επιδερμίδα</option>
                            <option value="Dry">Ξηροδερμία</option>
                            <option value="Mixed">Ανάμεικτη Επιδερμίδα</option>
                            </select>
                        </td>
                        <td style="width:10%;text-align:center" ><textarea name="message" id="Textarea_description" rows="1" cols="20">Περιγραφή</textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_facial" rows="1" cols="20">Περιγραφή</textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_facial_past" rows="1" cols="20">Περιγραφή</textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_surgery_face" rows="1" cols="20">Περιγραφή</textarea></td>
                        <td style="width:10%;text-align:center">
                        <?php 
                            $current_afm=$_SESSION['afm'];
                            $query_face = "SELECT COUNT(afm) FROM customer_face WHERE afm=$current_afm";
                            $result_face = mysqli_query($db,$query_face);
                            $final_result_face = mysqli_fetch_all($result_face);
                            print_r($final_result_face[0][0]+1);
                        ?>η Θεραπεία</td>
                        <td style="width:10%;text-align:center"><input  type="date" id="date_face_1" class="input-field" value='' autocomplete='off'></td>
                        <td style="width:10%;text-align:center"><input type="text" id="products_face_1" class="input-field" value='' autocomplete='off'></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_face_results" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_face_therapy" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_face_nutrition" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_face_comms" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center"> <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_face_insert"></td>
                        <td style="width:10%;text-align:center"> <input class="submit-btn" type="button" value="Ανανέωσε" id="submit_face_update"></td>
                        <td style="width:10%;text-align:center"> </td>
                        </tr>
                    </tbody>
                </table>
        </form>

       <form id="form_body" class="input-group" style="display:none;margin-left:20px;float:left">
        <p style="font-size:30px;text-align:center">Σώμα</p><br>
            <table style="width:110%;text-align:center">
                <tbody>
                <tr>
                    <th style="width:10%;text-align:center">Προβλήματα Σώματος</th>
                    <th style="width:10%;text-align:center">Σχόλια Τύπου Σώματο</th>
                    <th style="width:10%;text-align:center">Συνηθισμένη Περιποιήση Σώματος</th>
                    <th style="width:10%;text-align:center">Συνηθισμένη Περιποιήση Σώματος(Παρελθόν)</th>
                    <th style="width:10%;text-align:center">Επεμβάσεις</th>
                    <th style="width:10%;text-align:center">Επιλογή Μέρος Σώματος</th>
                    <th style="width:10%;text-align:center">Μετρήσεις Πριν Τη Θεραπεία</th>
                    <th style="width:10%;text-align:center">Θεραπεία Καμπίνας</th>
                    <th style="width:10%;text-align:center">Ημερομηνία</th>
                    <th style="width:10%;text-align:center">Προίοντα</th>
                    <th style="width:10%;text-align:center">Μετρήσεις Μετά τη Θεραπεία</th>
                    <th style="width:10%;text-align:center">Σχόλια</th>
                </tr>
                <tr>
                    <td name="Προβλήματα Σώματος" style="width:10%;text-align:center"> 
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
                        </select>
                    </td>
                    <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_body_type" rows="1" cols="20"></textarea></td>
                    <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_body_care" rows="1" cols="20"></textarea></td>
                    <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_body_care_past"  rows="1" cols="20"></textarea></td>
                    <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_surgery_body"  rows="1" cols="20"></textarea></td>
                    <td name="checkbox" style="width:10%;text-align:center">
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
                                </ul>
                    </td>
                    <td  style="width:10%;text-align:center">
                        <table name='Μετρήσεις Πριν τη Θεραπεία'>
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
                        </table>
                    </td>
                    <td style="width:10%;text-align:center">
                    <?php 
                            $current_afm=$_SESSION['afm'];
                            $query_body = "SELECT COUNT(afm) FROM customer_body WHERE afm=$current_afm";
                            $result_body = mysqli_query($db,$query_body);
                            $final_result_body = mysqli_fetch_all($result_body);
                            print_r($final_result_body[0][0]+1);
                        ?>η Θεραπεία</td>
                    <td style="width:10%;text-align:center"><input  type="date" id="date_body_1" class="input-field" value='' autocomplete='off'></td>
                    <td style="width:10%;text-align:center"><input  type="text" id="date_body_products_1" class="input-field" value='' autocomplete='off'></td>
                    <td  style="width:10%;text-align:center">
                        <table name='Μετρήσεις Μετά τη Θεραπεία'>
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
                        </table>
                    </td>
                    <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_body_comms"  rows="1" cols="20"></textarea></td>
                    <td style="width:10%;text-align:center"> <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_body_insert"></td>
                    <td style="width:10%;text-align:center"> <input class="submit-btn" type="button" value="Ανανέωσε" id="submit_body_update"></td>
                    
                </tr>
                </tbody>
            </table>
       </form>

       <form id="form_breast" class="input-group" style="display:none;margin-left:20px;float:left">
        <p style="font-size:30px;text-align:center">Στήθος</p><br>
            <table style="width:90%;text-align:center">
                <tbody>
                    <tr>
                        <th style="width:10%;text-align:center">Τύπος Στήθους</th>
                        <th style="width:10%;text-align:center">Περιγραφή Στήθους</th>
                        <th style="width:10%;text-align:center">Περιγραφή Συνηθισμένης Περιποιήσης Στήθους</th>
                        <th style="width:10%;text-align:center">Περιγραφή Περιποιήσης Στήθους(Παρελθόν)</th>
                        <th style="width:10%;text-align:center">Επεμβάσεις</th>
                        <th style="width:10%;text-align:center">Μετρήσεις Πριν τη Θεραπεία</th>
                        <th style="width:10%;text-align:center">Θεραπεία Καμπίνα</th>
                        <th style="width:10%;text-align:center">Ημερομηνία</th>
                        <th style="width:10%;text-align:center">Προίοντα</th>
                        <th style="width:10%;text-align:center">Αποτελέσματα</th>
                        <th style="width:10%;text-align:center">Προτεινόμενα Προίοντα(Σπίτι):</th>
                        <th style="width:10%;text-align:center">Συμβουλή Διατροφής</th>
                        <th style="width:10%;text-align:center">Σχόλια</th>
                    </tr>
                    <tr>
                        <td style="width:10%;text-align:center">
                            <select name="BreastType" id="breast_type">
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
                            </select>    
                        </td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_breast_data" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_breast_care" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_breast_care_past" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_surgery_breast" rows="1" cols="20"></textarea></td>
                        <td style="width:10%;text-align:center">
                            <table name='Μετρήσεις Πριν τη Θεραπεία'>
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
                            </table>
                        </td>
                        <td style="width:10%;text-align:center"><?php 
                            $current_afm=$_SESSION['afm'];
                            $query_breast = "SELECT COUNT(afm) FROM customer_breast WHERE afm=$current_afm";
                            $result_breast = mysqli_query($db,$query_breast);
                            $final_result_breast = mysqli_fetch_all($result_breast);
                            print_r($final_result_breast[0][0]+1);
                        ?>η Θεραπεία</td>
                        <td style="width:10%;text-align:center"><input  type="date" id="date_breast_1" class="input-field" value='' autocomplete='off'></td>
                        <td style="width:10%;text-align:center"><input  type="text" id="date_products_1" class="input-field" value='' autocomplete='off'></td>
                        <td style="width:10%;text-align:center">
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
                            </table>
                        </td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_breast_products" rows="1" cols="20"></textarea></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_breast_nutrition" rows="1" cols="20"></textarea></textarea></td>
                        <td style="width:10%;text-align:center"><textarea name="message" id="Textarea_breast_comms" rows="1" cols="20"></textarea></textarea></td>
                        <td style="width:10%;text-align:center"> <input class="submit-btn" type="button" value="Καταχώρησε" id="submit_breast_insert"></td>
                        <td style="width:10%;text-align:center"> <input class="submit-btn" type="button" value="Ανανέωσε" id="submit_breast_update"></td>
                    </tr>
                </tbody>
            </table>
            
       </form>
        
       <!-- 
       <button id="back_to_first" name="unset" type="submit">Τοποθέτησε Σειρά</button><br><br>
        <button id="show_face_insert" type="button" style="display:none;float:left">Εισαγωγή Στοιχείων Προσώπου</button>
        <button id="show_face_update" type="button" style="display:none;float:left">Ανανέωση Στοιχείων Προσώπου</button>
        <button id="show_body" type="button" style="float:left">Δεδομένα Σώματος</button>
        <button id="show_body_insert" type="button" style="display:none;float:left">Εισαγωγή Στοιχείων Σώματος</button>
        <button id="show_body_update" type="button" style="display:none;float:left">Ανανέωση Στοιχείων Σώματος</button>
        <button id="show_breast" type="button" style="float:left">Δεδομένα Στήθους</button>
        <button id="show_breast_insert" type="button" style="display:none;float:left">Εισαγωγή Στοιχείων Στήθους</button>
        <button id="show_breast_update" type="button" style="display:none;float:left">Ανανέωση Στοιχείων Στήθους</button>-->
    <?php endif ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
    <?php else: header("location: New_First_Page.php"); ?>

    </body>
</html>
<?php $j=0;if(isset($_POST["unset"])){ do{ ?><?php $j++;}while($j<=5);}?>
<?php endif ?>