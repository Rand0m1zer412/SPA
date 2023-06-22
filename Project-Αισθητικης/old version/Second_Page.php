<?php
// Start the session
session_start();
if((isset($_SESSION['email']) == FALSE )){
    header('location: First_Page.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
   <title>Στοιχεία Υγείας</title>
   <link rel="stylesheet" type="text/css"  media="screen"/> 
   </head>
  <body>
    <header>
        <h1 style="color:MediumSeaGreen;"> <a href="First_Page.php">Welcome Spa Thivas</a></h1>
        <h2 id="header2" style="color:MediumSeaGreen;">Current Customer:
            <?php if ($_SESSION['email'] != ''){
                echo $_SESSION['email'];
                //echo $_SESSION['id'];
                //echo $_SESSION['body_part'];
                //echo gettype($_SESSION['body_part']);
                //echo gettype($_SESSION['body_part']);
            }?>
            <br>
            <form action="" method="post">
                <button id="back_to_first" name="return_button_first_page" type="submit">First Page</button>
                <?php 
                if(isset($_POST["return_button_first_page"])){ //echo "im in"; 
                    session_unset();
                    header("location: First_Page.php");} ?>
            </form>
            </h2>
    </header>
    <form id="form_health" class="input-group" style="float:left"> <!--style="display:none;" -->
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
                        <input class="submit-btn" type="button" value="Submit" id="submit3"><br><br>   
                        <button id="next_health" type="button">Next Form</button>    
                        <?php if($_SESSION['body_part']=='body'): ?>
                            <button id="back_health_body" type="button" >Back</button>
                        <?php endif; ?>   
                        <?php if($_SESSION['body_part']=='breast'): ?>
                            <button id="back_health_all" type="button" >Back</button>
                        <?php endif; ?>   
                        <?php if($_SESSION['body_part']=='face'): ?>
                            <button id="back_health_all" type="button" >Back</button>
                        <?php endif; ?>           
                        <?php if($_SESSION['body_part']=='all'): ?>
                            <button id="back_health_all" type="button" >Back</button>
                        <?php endif; ?>  
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
        <input class="submit-btn" type="button" value="Submit" id="submit_habits"><br><br>
        <button id="back_habits" type="button" >Back</button>
        <?php if($_SESSION['body_part']=='body'): ?>
            <button id="next_habits_body" type="button" >Next Form</button>
        <?php elseif($_SESSION['body_part']=='chest'): ?>
            <button id="next_habits_breast" type="button" >Next Form</button>
        <?php elseif($_SESSION['body_part']=='face'): ?>
            <button id="next_habits_face" type="button" >Next Form</button>
        <?php elseif($_SESSION['body_part']=='all'): ?>
            <button id="next_habits_all" type="button" >Next Form</button>
        <?php endif; ?>
        <?php if($_SESSION['body_part']=='body,chest'): ?>
            <button id="next_habits_body_breast" type="button" >Next Form</button>
        <?php endif; ?>
        <?php if($_SESSION['body_part']=='body,face'): ?>
            <button id="next_habits_body_face" type="button" >Next Form</button>
        <?php endif; ?>
        <?php if($_SESSION['body_part']=='chest,face'): ?>
            <button id="next_habits_breast_face" type="button" >Next Form</button>
        <?php endif; ?>  
    </form>
    <form id="body" class="input-group" style="display:none;margin-left:50px;float:left"> 
            <?php if($_SESSION['body_part']=='body' or $_SESSION['body_part']=='all' or $_SESSION['body_part']=='body,chest' OR $_SESSION['body_part']=='body,face'): ?>
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
                    <input class="submit-btn" type="button" value="Submit" id="submit_body">
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
                    
            <?php endif; ?>   
    </form>
    <form id="form_breast" class="input-group" style="display:none;margin-left:20px;float:left"> 
        <?php if($_SESSION['body_part']=='chest' or $_SESSION['body_part']=='all' or $_SESSION['body_part']=='body,chest' 
        OR $_SESSION['body_part']=='body,face' OR $_SESSION['body_part']=='chest,face'): ?>
            <p style="font-size:20px;">Στήθος</p>
            <select name="Breast Type" id="breast_type">
                <option value="None"></option>
                <option value="Round">Round</option>
                <option value="East west">East west</option>
                <option value="Side set">Side set (widely set)</option>
                <option value="Teardrop">Teardrop</option>
                <option value="Narrow">Narrow</option>
                <option value="Asymmetrical ">Asymmetrical </option>
                <option value="Bell shape">Bell shape</option>
            </select><br><br>
            <table>
                    <tr>
                        <th>Θεραπεία Καμπίνας</th>
                        <th>Ημερομηνία</th>
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
                <input class="submit-btn" type="button" value="Submit" id="submit_breast">
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
            <?php endif; ?>       
    </form>
    <form id="form_face" class="input-group" style="display:none;margin-left:20px;float:left"> 
        <?php if($_SESSION['body_part']=='face' or $_SESSION['body_part']=='all' 
        OR $_SESSION['body_part']=='body,face'  OR $_SESSION['body_part']=='chest,face'): ?>
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
            <input class="submit-btn" type="button" value="Submit" id="submit_face">
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
        <?php endif; ?>       
    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="Fpage.js"></script>
  </body>
</html>