<!DOCTYPE html>
<html>
<?php
// Start the session
session_start();
if(isset($_SESSION['firstname']) && isset($_SESSION['lastname']) && isset($_SESSION['email']) && isset($_SESSION['phone'])):
    $db = mysqli_connect('localhost','root','','spa') or die("could not connect to database");
    $email = $_SESSION['email'];
    //echo $_SESSION['body_part'];
    //echo $_SESSION['email'];
?>
  <head>
   <title>Νέο Ραντεβού</title>
   <link rel="stylesheet" type="text/css"  media="screen"/> 
   </head>
  <body>
    <header>
        <h1 style="color:MediumSeaGreen;"> <a href="First_Page.php">Welcome Spa Thivas</a></h1>
        <h2 id="header2" style="color:MediumSeaGreen;">Current Customer: <?php echo $_SESSION['email']; ?><h2>
        <h3 id="header3" style="color:MediumSeaGreen;">Next Appointment Breast: 
            <?php 
                date_default_timezone_set('Europe/Athens');
                $current_date = date('Y-m-d');
                $query_checker_breast = "SELECT breast_date FROM customer_breast WHERE customer_email=$email";
                $breast_query = mysqli_query($db,$query_checker_breast);
                if(mysqli_num_rows($breast_query)!=0){
                    echo mysqli_error($db);
                    $result_query = mysqli_fetch_all($breast_query); 
                    echo json_encode($result_query[0][0]);
                }else{
                    echo "No Appointment For Breast";
                }
                
            ?>
        <h3>
        <h3 id="header4" style="color:MediumSeaGreen;">Next Appointment Body: 
            <?php 
                date_default_timezone_set('Europe/Athens');
                $current_date = date('Y-m-d');
                $query_checker_body = "SELECT body_date FROM customer_body WHERE customer_email=$email";
                $body_query = mysqli_query($db,$query_checker_body);
                if(mysqli_num_rows($body_query)!=0){
                    echo mysqli_error($db);
                    $result_query = mysqli_fetch_all($body_query); 
                    echo json_encode($result_query[0][0]);
                }else{
                    echo "No Appointment For Body";
                }
                
            ?>
        <h3>
        <h3 id="header5" style="color:MediumSeaGreen;">Next Appointment Face: 
            <?php 
                date_default_timezone_set('Europe/Athens');
                $current_date = date('Y-m-d');
                $query_checker_face = "SELECT face_date FROM customer_face WHERE customer_email=$email";
                $face_query = mysqli_query($db,$query_checker_face);
                if(mysqli_num_rows($face_query)!=0){
                    echo mysqli_error($db);
                    $result_query = mysqli_fetch_all($face_query); 
                    echo json_encode($result_query[0][0]);
                }else{
                    echo "No Appointment For Face";
                }
                
            ?>
        <h3>
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
            <label for="appt">Choose a time for your meeting:</label>
            <input type="time" id="appt" name="appt" min="09:00" max="18:00" required>
            <small>Office hours are 9am to 6pm</small><br>
            <label for="Next Appointment">Next Appointment:</label>
            <input  type="date" id="date_appntm" class="input-field" value='' autocomplete='off'><br><br>
            <button id="submit_appntm" type="button" style="float:left">Check For Appntm</button><br><br><br><br>
            <!--<form id= "form_for_email" class="input-group" style="float:left"> </form>-->

            <?php if(strpos($_SESSION['body_part'], 'chest') !== FALSE OR strpos($_SESSION['body_part'], 'all') !== FALSE): ?>
                <button id="show_breast" type="button" style="float:left">Show Breast Form</button>
                <button id="show_breast_insert" type="button" style="display:none;float:left">Insert Breast Form</button>
                <button id="show_breast_update" type="button" style="display:none;float:left">Update Breast Form</button>

                    <form id="form_breast_insert" class="input-group" style="display:none;margin-left:20px;float:left">
                        <p style="font-size:20px;">Στήθος</p>
                            <select name="Breast Type" id="breast_type">
                                <option value="Round">Round</option>
                                <option value="East west">East west</option>
                                <option value="Side set">Side set (widely set)</option>
                                <option value="Teardrop">Teardrop</option>
                                <option value="Narrow">Narrow</option>
                                <option value="Asymmetrical ">Asymmetrical </option>
                                <option value="Bell shape">Bell shape</option>
                            </select><br><br>
                                <table id="date_breast_3">
                                    <tr>
                                        <th>Θεραπεία Καμπίνας</th>
                                        <th>Ημερομηνία Ραντεβού</th>
                                        <th>Προίοντα</th>
                                    </tr>
                                    <tr>
                                        <td>1η Θεραπεία</td>
                                        <td><input  type="date" id="date_breast_1" class="input-field" value='' autocomplete='off'></td>
                                        <td><input type="text" id="products_breast_1" class="input-field" value='' autocomplete='off'><td>
                                    </tr>
                                </table><br><br>
                            <label for="Comments">Comments:</label><br>
                            <textarea name="message" id="Textarea_breast" rows="3" cols="25"></textarea><br><br>
                            <label for="Surgery">Surgery:</label><br>
                            <input type="text" id="surgery" class="input-field" value='' autocomplete='off'><br><br>
                            <input class="submit-btn" type="button" value="Insert" id="submit_breast_insert">
                            <?php if($_SESSION['body_part']=='chest'): ?>
                                    <button id="back_body" type="button" >Back</button>
                                    <button id="next_body" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='all'): ?>
                                    <button id="back_breast_all" type="button" >Back</button>
                                    <button id="next_breast_all" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='body,chest' OR $_SESSION['body_part']=='chest,body'): ?>
                                    <button id="back_breast_body" type="button" >Back</button>
                                    <button id="next_breast_health" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='face,chest' OR $_SESSION['body_part']=='chest,face'): ?>
                                    <button id="back_breast_habits" type="button" >Back</button>
                                    <button id="next_breast_face" type="button" >Next</button>
                                <?php endif; ?>  
                    </form>
                    <form id="form_breast_update" class="input-group" style="display:none;margin-left:20px;float:left">
                        <p style="font-size:20px;">Στήθος</p>
                            <select name="Breast Type" id="breast_type_2">
                                <option value="Round">Round</option>
                                <option value="East west">East west</option>
                                <option value="Side set">Side set (widely set)</option>
                                <option value="Teardrop">Teardrop</option>
                                <option value="Narrow">Narrow</option>
                                <option value="Asymmetrical ">Asymmetrical </option>
                                <option value="Bell shape">Bell shape</option>
                            </select><br><br>
                            <table >
                                <tr>
                                    <th>Θεραπεία Καμπίνας</th>
                                    <th>Ημερομηνία Παλιού Ραντεβού</th>
                                    <th>Ημερομηνία Νέου Ραντεβού</th>
                                    <th>Προίοντα</th>
                                </tr>
                                <tr>
                                    <td>1η Θεραπεία</td>
                                    <td><input  type="date" id="date_breast_21" class="input-field" value='' autocomplete='off'></td>
                                    <td><input  type="date" id="date_breast_2" class="input-field" value='' autocomplete='off'></td>
                                    <td><input type="text" id="products_breast_2" class="input-field" value='' autocomplete='off'><td>
                                </tr>
                            </table><br><br>
                            <label for="Comments">Comments:</label><br>
                            <textarea name="message" id="Textarea_breast_2" rows="3" cols="25"></textarea><br><br>
                            <label for="Surgery">Surgery:</label><br>
                            <input type="text" id="surgery_2" class="input-field" value='' autocomplete='off'><br><br>
                            <input class="submit-btn" type="button" value="Update" id="submit_breast_update">
                            <?php if($_SESSION['body_part']=='chest'): ?>
                                    <button id="back_body" type="button" >Back</button>
                                    <button id="next_body" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='all'): ?>
                                    <button id="back_breast_all" type="button" >Back</button>
                                    <button id="next_breast_all" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='body,chest' OR $_SESSION['body_part']=='chest,body'): ?>
                                    <button id="back_breast_body" type="button" >Back</button>
                                    <button id="next_breast_health" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='face,chest' OR $_SESSION['body_part']=='chest,face'): ?>
                                    <button id="back_breast_habits" type="button" >Back</button>
                                    <button id="next_breast_face" type="button" >Next</button>
                                <?php endif; ?>  
                        </form>
                                
                    </form>
            <?php endif ?>

            <?php if(strpos($_SESSION['body_part'], 'body') !== FALSE OR strpos($_SESSION['body_part'], 'all') !== FALSE): ?>
                <button id="show_body" type="button" style="float:left">Show Body Form</button>
                <button id="show_body_insert" type="button" style="display:none;float:left">Insert Body Form</button>
                <button id="show_body_update" type="button" style="display:none;float:left">Update Body Form</button>
                <form id="form_body_insert" class="input-group" style="display:none;margin-left:50px;float:left">
                    <p style="font-size:20px;">Σώμα</p>
                            <select name="Natural Type" id="natural_type">
                                <option value="None"></option>
                                <option value="Intensity">Intensity</option>
                                <option value="Perfusion">Perfusion</option>
                                <option value="Spider veins">Spider veins</option>
                                <option value="Cellulite">Cellulite</option>
                                <option value="body fat">Βody Fat</option>
                                <option value="Asymmetrical ">Pagades</option>
                                <option value="Scars">Scars</option>
                                <option value="Acne">Acne</option>
                                <option value="Other">Other</option>
                            </select><br><br>
                            <div id="list1" class="dropdown-check-list" tabindex="100" style="float:left">
                                        <span class="anchor">Select Body Part:</span>
                                        <ul class="items">
                                            <li><input type="checkbox" value="middle" name="part" id="middle"/>Middle</li>
                                            <li><input type="checkbox" value="hip" name="part" id="hip"/>Hip</li>
                                            <li><input type="checkbox" value="right thigh" name="part" id="right_thigh"/>Right Thigh</li>
                                            <li><input type="checkbox" value="left thigh" name="part" id="left_thigh"/>Left Thigh</li>
                                            <li><input type="checkbox" value="right knee" name="part" id="right_knee"/>Right Knee</li>
                                            <li><input type="checkbox" value="left knee" name="part" id="left_knee"/>Left Knee</li>
                                            <li><input type="checkbox" value="right ankle" name="part" id="right_ankle"/>Right Ankle</li>
                                            <li><input type="checkbox" value="left ankle" name="part" id="left ankle"/>Left Ankle</li>
                                            <li><input type="checkbox" value="all" name="part" id="all"/>All the above</li>
                                        </ul>
                                </div><br><br>
                                <table>
                                    <tr>
                                        <th>Θεραπεία Καμπίνας</th>
                                        <th>Ημερομηνία</th>
                                        <th>Προίοντα</th>
                                    </tr>
                                    <tr>
                                        <td>1η Θεραπεία</td>
                                        <td><input  type="date" id="date_body_1" class="input-field" value='' autocomplete='off'></td>
                                        <td><input type="text" id="products_body_1" class="input-field" value='' autocomplete='off'><td>
                                    </tr>
                                </table> <br><br>
                                <label for="Comments">Comments:</label><br>
                                <textarea name="message" id="Textarea_body" rows="3" cols="25"></textarea><br><br>
                                <input class="submit-btn" type="button" value="Insert" id="submit_body_insert">
                                <?php if($_SESSION['body_part']=='body'): ?>
                                    <button id="back_body" type="button" >Back</button>
                                    <button id="next_body" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='all'): ?>
                                    <button id="back_body_all" type="button" >Back</button>
                                    <button id="next_body_all" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='body,chest' OR $_SESSION['body_part']=='chest,body'): ?>
                                    <button id="back_body_breast" type="button" >Back</button>
                                    <button id="next_body_breast" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='body,face' OR $_SESSION['body_part']=='face,body'): ?>
                                    <button id="back_body_face" type="button" >Back</button>
                                    <button id="next_body_face" type="button" >Next</button>
                                <?php endif; ?>      
                </form>
                <form id="form_body_update" class="input-group" style="display:none;margin-left:50px;float:left">
                    <p style="font-size:20px;">Σώμα</p>
                            <select name="Natural Type" id="natural_type_2">
                                <option value="None"></option>
                                <option value="Intensity">Intensity</option>
                                <option value="Perfusion">Perfusion</option>
                                <option value="Spider veins">Spider veins</option>
                                <option value="Cellulite">Cellulite</option>
                                <option value="body fat">Βody Fat</option>
                                <option value="Asymmetrical ">Pagades</option>
                                <option value="Scars">Scars</option>
                                <option value="Acne">Acne</option>
                                <option value="Other">Other</option>
                            </select><br><br>
                            <div id="list1" class="dropdown-check-list" tabindex="100" style="float:left">
                                        <span class="anchor">Select Body Part:</span>
                                        <ul class="items">
                                            <li><label><input type="checkbox"  name="part" id="middle"/>Middle</label></li>
                                            <li><input type="checkbox"  name="part2" id="hip2"/>Hip</li>
                                            <li><input type="checkbox"  name="part2" id="right_thigh2"/>Right Thigh</li>
                                            <li><input type="checkbox"  name="part2" id="left_thigh2"/>Left Thigh</li>
                                            <li><input type="checkbox"  name="part2" id="right_knee2"/>Right Knee</li>
                                            <li><input type="checkbox"  name="part2" id="left_knee2"/>Left Knee</li>
                                            <li><input type="checkbox"  name="part2" id="right_ankle2"/>Right Ankle</li>
                                            <li><input type="checkbox"  name="part2" id="left ankle2"/>Left Ankle</li>
                                            <li><input type="checkbox"  name="part2" id="all"/>All the above</li>
                                        </ul>
                                </div><br><br>
                                <table>
                                    <tr>
                                        <th>Θεραπεία Καμπίνας</th>
                                        <th>Παλιά Ημερομηνία Ραντεβού</th>
                                        <th>Νεα Ημερομηνία Ραντεβού</th>
                                        <th>Προίοντα</th>
                                    </tr>
                                    <tr>
                                        <td>1η Θεραπεία</td>
                                        <td><input  type="date" id="date_body_21" class="input-field" value='' autocomplete='off'></td>
                                        <td><input  type="date" id="date_body_2" class="input-field" value='' autocomplete='off'></td>
                                        <td><input type="text" id="products_body_2" class="input-field" value='' autocomplete='off'><td>
                                    </tr>
                                </table> <br><br>
                                <label for="Comments">Comments:</label><br>
                                <textarea name="message" id="Textarea_body2" rows="3" cols="25"></textarea><br><br>
                                <input class="submit-btn" type="button" value="Update" id="submit_body_update">
                                <?php if($_SESSION['body_part']=='body'): ?>
                                    <button id="back_body" type="button" >Back</button>
                                    <button id="next_body" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='all'): ?>
                                    <button id="back_body_all" type="button" >Back</button>
                                    <button id="next_body_all" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='body,chest' OR $_SESSION['body_part']=='chest,body'): ?>
                                    <button id="back_body_breast" type="button" >Back</button>
                                    <button id="next_body_breast" type="button" >Next</button>
                                <?php endif; ?>  
                                <?php if($_SESSION['body_part']=='body,face' OR $_SESSION['body_part']=='face,body'): ?>
                                    <button id="back_body_face" type="button" >Back</button>
                                    <button id="next_body_face" type="button" >Next</button>
                                <?php endif; ?>      
                </form>
                   
            <?php endif ?>

            <?php if(strpos($_SESSION['body_part'], 'face') !== FALSE OR strpos($_SESSION['body_part'], 'all') !== FALSE): ?>
                <button id="show_face" type="button" style="float:left">Show Face Form</button>
                <button id="show_face_insert" type="button" style="display:none;float:left">Insert Face Form</button>
                <button id="show_face_update" type="button" style="display:none;float:left">Update Face Form</button>
                <form id="form_face_insert" class="input-group" style="display:none;margin-left:20px;float:left">
                    <p style="font-size:20px;">Πρόσωπο</p>
                        <select name="Face" id="type_of_faces">
                            <option value="None"></option>
                            <option value="Normal">Normal skin</option>
                            <option value="Oily">Oily skin</option>
                            <option value="Dry">Dry skin</option>
                            <option value="Mixed">Mixed skin</option>
                    </select><br><br>
                    <table>
                            <tr>
                                <th>Θεραπεία Καμπίνας</th>
                                <th>Ημερομηνία</th>
                                <th>Προίοντα</th>
                            </tr>
                            <tr>
                                <td>1η Θεραπεία</td>
                                <td><input  type="date" id="date_face_1" class="input-field" value='' autocomplete='off'></td>
                                <td><input type="text" id="products_face_1" class="input-field" value='' autocomplete='off'><td>
                            </tr>
                        </table><br><br>
                        <label for="Comments">Comments:</label><br>
                        <textarea name="message" id="Textarea_face" rows="3" cols="25"></textarea><br><br>
                        <input class="submit-btn" type="button" value="Insert" id="submit_face_insert">
                        <?php if($_SESSION['body_part']=='face'): ?>
                            <button id="back_face" type="button" >Back</button>
                            <button id="next_face" type="button" >Next Form</button>
                        <?php endif; ?>  
                        <?php if($_SESSION['body_part']=='all'): ?>
                            <button id="back_face_all" type="button" >Back</button>
                            <button id="next_face_all" type="button" >Next</button>
                        <?php endif; ?>  
                        <?php if($_SESSION['body_part']=='body,face' OR $_SESSION['body_part']=='face,body'): ?>
                                    <button id="back_face_body" type="button" >Back</button>
                                    <button id="next_face_health" type="button" >Next</button>
                        <?php endif; ?>      
                        <?php if($_SESSION['body_part']=='chest,face'): ?>
                                    <button id="back_face_breast" type="button" >Back</button>
                                    <button id="next_face_health" type="button" >Next</button>
                        <?php endif; ?>
                </form>
                <form id="form_face_update" class="input-group" style="display:none;margin-left:20px;float:left">
                    <p style="font-size:20px;">Πρόσωπο</p>
                        <select name="Face" id="type_of_faces_2">
                            <option value="None"></option>
                            <option value="Normal">Normal skin</option>
                            <option value="Oily">Oily skin</option>
                            <option value="Dry">Dry skin</option>
                            <option value="Mixed">Mixed skin</option>
                    </select><br><br>
                    <table>
                            <tr>
                                <th>Θεραπεία Καμπίνας</th>
                                <th>Παλιά Ημερομηνία Ραντεβού</th>
                                <th>Νεα Ημερομηνία Ραντεβού</th>
                                <th>Προίοντα</th>
                            </tr>
                            <tr>
                                <td>1η Θεραπεία</td>
                                <td><input  type="date" id="date_face_21" class="input-field" value='' autocomplete='off'></td>
                                <td><input  type="date" id="date_face_2" class="input-field" value='' autocomplete='off'></td>
                                <td><input type="text" id="products_face_1" class="input-field" value='' autocomplete='off'><td>
                            </tr>
                        </table><br><br>
                        <label for="Comments">Comments:</label><br>
                        <textarea name="message" id="Textarea_face_2" rows="3" cols="25"></textarea><br><br>
                        <input class="submit-btn" type="button" value="Update" id="submit_face_update">
                        <?php if($_SESSION['body_part']=='face'): ?>
                            <button id="back_face" type="button" >Back</button>
                            <button id="next_face" type="button" >Next Form</button>
                        <?php endif; ?>  
                        <?php if($_SESSION['body_part']=='all'): ?>
                            <button id="back_face_all" type="button" >Back</button>
                            <button id="next_face_all" type="button" >Next</button>
                        <?php endif; ?>  
                        <?php if($_SESSION['body_part']=='body,face' OR $_SESSION['body_part']=='face,body'): ?>
                                    <button id="back_face_body" type="button" >Back</button>
                                    <button id="next_face_health" type="button" >Next</button>
                        <?php endif; ?>      
                        <?php if($_SESSION['body_part']=='chest,face'): ?>
                                    <button id="back_face_breast" type="button" >Back</button>
                                    <button id="next_face_health" type="button" >Next</button>
                        <?php endif; ?>
                </form>
            <?php endif ?>
        <?php endif ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
    <?php else: header("location: First_Page.php"); ?>
  </body>
</html>
<?php endif ?>