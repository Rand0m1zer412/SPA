<?php 
session_start();
//connect to the db

$db = mysqli_connect('localhost','root','','spa') or die("could not connect to database");

//Check if the e-mail has the correct form 
function checkEmail($email){ 
    //Checks Email
    $mail='';
    if(isset($email)){
        if(preg_match("/^\w+([.-]?\w+)@\w+([.-]?\w+)(.\w{3,3})+$/",$email)){
            $mail='True';
        }else{
            $mail='False';
        }
    }
    return $mail;
}   

function checkQuery($myvalue,$email,$db){
    
    if($myvalue=="habits"){ // query search for habits
        $query_check = "SELECT * FROM customer_habits WHERE customer_email='$email'";
       
    }elseif($myvalue=="body"){ // query search for customer body
        $query_check = "SELECT * FROM customer_body WHERE customer_email='$email'";

    }elseif($myvalue=="breast"){ // query search for customer breast
        $query_check = "SELECT * FROM customer_breast WHERE customer_email='$email'";
        //echo json_encode(mysqli_fetch_all(mysqli_query($db,$query_check)))."----------";
    }
    elseif($myvalue=="face"){ // query search for customer face 
        $query_check = "SELECT * FROM customer_face WHERE customer_email='$email'";

    }else{
        return  '{"message": "No Data"}';
        exit();
    }
    //echo mysqli_query($db, $query_check);
    //echo mysqli_error($db);
    $result_check = mysqli_query($db,$query_check);
    if((mysqli_num_rows($result_check) >= 1)){ 
        $final_result = mysqli_fetch_all($result_check);
        $response_func = $final_result;
        return $response_func;
    }
    
}

if(isset($_POST['temporary_appntm'])==1){ 
    $firstname = mysqli_real_escape_string($db, $_POST['ajax_fname']);
    $lastname = mysqli_real_escape_string($db, $_POST['ajax_lname']);
    $phone = mysqli_real_escape_string($db, $_POST['ajax_phone']);
    $appntm_date = mysqli_real_escape_string($db, $_POST['ajax_appntm_date']);
    $appntm_time = mysqli_real_escape_string($db, $_POST['ajax_appntm_time']);
    $_SESSION['phone'] = $phone;
    $query_check_appntm = "SELECT appt_time,phone FROM appointments WHERE appt_date='$appntm_date' ";// ΕΛΕΓΧΕΙΣ ΕΑΝ ΥΠΑΡΧΕΙ Η ΩΡΑ ΚΑΙ ΗΜΕΡΟΜΗΝΙΑ ΤΟΥ ΡΑΝΤΕΒΟΥ ΠΕΛΑΤΗ ΜΕ ΒΑΣΗ ΤΟ ΤΗΛΕΦΩΝΟ
    $result_check_appntm = mysqli_query($db,$query_check_appntm);
    $appt_checker = FALSE;
    if((mysqli_num_rows($result_check_appntm)==0)){
        $query_insert_appt = "INSERT INTO appointments (appt_date, appt_time, phone) VALUES ('$appntm_date','$appntm_time',$phone)";
        $result_insert_appt = mysqli_query($db,$query_insert_appt);
    }elseif((mysqli_num_rows($result_check_appntm)>=1)){
        $result_appntm= mysqli_fetch_all($result_check_appntm);
        for($i=0; $i<count($result_appntm);$i++){
            if($result_appntm[$i][0]==$appntm_time ){
                $appt_checker = TRUE;
                if($result_appntm[$i][1]==$phone){
                    $appt_checker = FALSE;
                }
            }
        }
        if($appt_checker==FALSE){
            $query_insert_appt = "INSERT INTO appointments (appt_date, appt_time, phone) VALUES ('$appntm_date','$appntm_time',$phone)";
            $result_insert_appt = mysqli_query($db,$query_insert_appt);
        }
    }
    if($appt_checker == FALSE){//ΕΑΝ Ο ΤΣΕΚΕΡ ΕΙΝΑΙ FALSE ΔΗΛΩΝΕΙ ΟΤΙ ΥΠΑΡΧΕΙ ΔΙΑΘΕΣΙΜΗ Η ΩΡΑ ΓΙΑ ΝΑ ΚΛΕΙΣΤΕΙ ΡΑΝΤΕΒΟΥ
        $query_check_temp = "SELECT * FROM personal_data_temp WHERE phone='$phone'";// ΕΛΕΓΧΕΙΣ ΕΑΝ ΥΠΑΡΧΕΙ Ο ΠΕΛΑΤΗΣ ΜΕ ΒΑΣΗ ΤΟ ΤΗΛΕΦΩΝΟ
        $result_check_temp = mysqli_query($db,$query_check_temp);
        if((mysqli_num_rows($result_check_temp)==0)){// ΔΕΝ ΥΠΑΡΧΕΙ ΑΡΑ ΚΑΝΕΙΣ INSERT
            if($firstname!='' AND $lastname!='' AND $appntm_date!='' ){ //AND $appntm_time!=''
                //$query_appnt = "SELECT appointments.appt_date, appointments.appt_time 
                //FROM appointments 
                //INNER JOIN personal_data_temp ON personal_data_temp.phone = appointments.phone";
                //$result_query_appnt = mysqli_query($db, $query_appnt);
                //if(mysqli_num_rows($result_query_appnt)==0){// ΓΙΑ ΤΗΝ ΠΡΩΤΗ ΕΓΓΡΑΦΗ ΤΟΥ ΠΕΛΑΤΗ
                    $query_insert_temp = "INSERT INTO personal_data_temp (firstname, lastname, phone, next_appointment) 
                    VALUES ('$firstname','$lastname',$phone, '$appntm_date')";
                    //$query_insert_appt = "INSERT INTO appointments (appt_date, appt_time, phone) 
                    //VALUES ('$appntm_date',' $appntm_time','$phone')";
                    $result_insert_temp = mysqli_query($db,$query_insert_temp);
                    //$result_insert_appt = mysqli_query($db,$query_insert_appt);
                    if(($result_insert_temp!= FALSE)){ //AND ($result_insert_appt!= FALSE )
                        echo '{"response": "Insert Completed"}'.mysqli_error($db);
                    }else{
                        echo '{"response": "Something Went Wrong in DB"}'.mysqli_error($db);
                    }
            }else{
                echo '{"response": "Client Doesnt Exist.Make Insert"}'.mysqli_error($db);
            }   
        }elseif((mysqli_num_rows($result_check_temp)>=1)){// ΥΠΑΡΧΕΙ ΑΡΑ ΚΑΝΕΙΣ INSERT 

            $result_check= mysqli_fetch_all($result_check_temp);
            //$next_appntm = $result_check['next_appointment'];
            $query_check_formal = "SELECT * FROM personal_data WHERE firstname='$firstname' and lastname='$lastname' and phone='$phone' ";
            $result_check_formal = mysqli_query($db,$query_check_formal);
            //var_dump($next_appntm,$appntm_date);
            if((mysqli_num_rows($result_check_formal)==1)){
                $result_fetch_formal = mysqli_fetch_assoc($result_check_formal);
                $customer_afm = json_encode($result_fetch_formal['afm']);
                $customer_appnt_day = json_encode($result_fetch_formal['next_appointment']);
                $customer_email = json_encode($result_fetch_formal['email']);
                $_SESSION['email'] =$customer_email;
                $_SESSION['afm'] = $customer_afm;
                //echo json_encode($result_fetch_formal).mysqli_error($db);
                echo '{"response": "Customer Exists", "data_formal": '.json_encode($result_fetch_formal).'}';
            }else{
                echo '{"response": "Client Temporary Exists.Make Insert"}'.mysqli_error($db);
            }
        }
    }else{
        echo '{"response": "Appointment Time is Covered"}'.mysqli_error($db);
    }
    

//SESSION BODY PART AND EMAIL
}elseif(isset($_POST['checker_session_update_data'])==1.2){
    $afm = mysqli_real_escape_string($db, $_POST['ajax_afm']);
    $phone = mysqli_real_escape_string($db, $_POST['ajax_phone']);
    $query_checkdata = "SELECT * FROM personal_data WHERE phone='$phone' and afm=$afm";// ΕΛΕΓΧΕΙΣ ΕΑΝ ΥΠΑΡΧΕΙ Ο ΠΕΛΑΤΗΣ ΜΕ ΒΑΣΗ ΤΟ ΤΗΛΕΦΩΝΟ
    $result_checkdata = mysqli_query($db,$query_checkdata);
    if((mysqli_num_rows($result_checkdata)==1)){
        $_SESSION['afm']= $afm;
        $_SESSION['phone']= $phone;
        echo '{"response": "Client Exist.Go to Page","AFM": '.json_encode($_SESSION['afm']).',"PHONE": '.json_encode($_SESSION['phone']).'}';

    }elseif((mysqli_num_rows($result_check_temp)==0)){
        echo '{"response": "Client Doesnt Exist.Dont Go to Page"}';
    }    
//REGISTRATION
}elseif(isset($_POST['formal_sign_in'])==2){
    $firstname = mysqli_real_escape_string($db, $_POST['ajax_fname']);
    $lastname = mysqli_real_escape_string($db, $_POST['ajax_lname']);
    $phone = mysqli_real_escape_string($db, $_POST['ajax_phone']);
    $appntm_date = mysqli_real_escape_string($db, $_POST['ajax_appntm_date']);
    $name_beautician = mysqli_real_escape_string($db, $_POST['ajax_name_beautician']);
    $email = mysqli_real_escape_string($db, $_POST['ajax_email']);
    $birth = mysqli_real_escape_string($db, $_POST['ajax_birth']);
    $afm = mysqli_real_escape_string($db, $_POST['ajax_afm']);
    $comments = mysqli_real_escape_string($db, $_POST['ajax_comments']);
    $checkbox = mysqli_real_escape_string($db, $_POST['ajax_checkboxes_value']);
    $email_check = checkEmail($email);
    $query_checker_formal = "SELECT * FROM personal_data_temp WHERE phone='$phone'";
    $result_query_formal = mysqli_query($db, $query_checker_formal);
    echo mysqli_error($db);
    if($result_query_formal != FALSE){
        if($email_check !='False'){
            $birth_1=strtotime($birth);
            $new_birth = date('Y-m-d',$birth_1);
            $final_result_query_formal = mysqli_fetch_assoc($result_query_formal);
            $temp_id = json_encode($final_result_query_formal['temp_id']);
            //echo $temp_id;
            $query_insert_formal = "INSERT INTO personal_data (afm, temp_id, firstname, lastname, phone, next_appointment, name_beautician, email, birthday,  Comments, body_part_treatment) 
            VALUES ('$afm', $temp_id,'$firstname', '$lastname', '$phone','$appntm_date', '$name_beautician',  '$email',  '$new_birth', '$comments',  '$checkbox' )";
            $result_query_insert_formal =mysqli_query($db, $query_insert_formal);
            if($result_query_insert_formal!= FALSE){
                $query_get_id = "SELECT * FROM personal_data WHERE afm='$afm' and phone='$phone'";
                $result=mysqli_query($db, $query_get_id);
                if(mysqli_num_rows($result)==1){
                    $customer_id=mysqli_fetch_array($result);
                    $_SESSION['email'] = $email;
                    $_SESSION['afm'] = json_encode($customer_id['afm']);
                    $_SESSION['phone'] = json_encode($customer_id['phone']);
                    $_SESSION['body_part']= $checkbox;
                    //$_SESSION['phone']= $phone;
                    //$_SESSION['afm']= $afm;
                    $query_apptmnt_formal = "UPDATE appointments SET afm=$afm  WHERE phone='$phone' AND appt_date='$appntm_date'";
                    $result_query_apptnm_formal =mysqli_query($db, $query_apptmnt_formal);
                    echo '{"response": "Registration Complete", "email":'.json_encode($email).', "body_part":'.json_encode($checkbox).'}'.mysqli_error($db);
                }else{
                    //echo '{"response": "Duplicate Entry"}';
                }
            }else{
                //$query_delete_formal = "DELETE FROM personal_data WHERE temp_id=$temp_id";
                //$query_delete =mysqli_query($db,$query_delete_formal);
                echo '{"response": "Duplicate Entry"}';
            }
        }else{
            echo '{"response": "Wrong Type of Email"}';
        } 
    }elseif($result_query_formal == FALSE){
        echo '{"response": "User Exists"}';
    }else{
        echo '{"response": "Problem With Query in DB"}'.mysqli_error($db);
    }
//CUSTOMER HEALTH
}elseif(isset($_POST['checker_client_health'])==3){
    $height = mysqli_real_escape_string($db, $_POST['ajax_height']);
    $weight = mysqli_real_escape_string($db, $_POST['ajax_weight']);
    $health = mysqli_real_escape_string($db, $_POST['ajax_health']);
    $health_text = mysqli_real_escape_string($db, $_POST['ajax_health_text']);
    $sleep = mysqli_real_escape_string($db, $_POST['ajax_sleep']);
    $sleep_text = mysqli_real_escape_string($db, $_POST['ajax_sleep_text']);
    $appetite = mysqli_real_escape_string($db, $_POST['ajax_appetite']);
    $appetite_text = mysqli_real_escape_string($db, $_POST['ajax_appetite_text']);
    $diseases_text = mysqli_real_escape_string($db, $_POST['ajax_diseases_text']);
    $meds_text = mysqli_real_escape_string($db, $_POST['ajax_meds_text']);
    $surgery_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_text']);
    $email_health = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    if($_SESSION['email'] != ""){
        $query_health_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
        $result_check_health = mysqli_query($db,$query_health_take_id);
        echo mysqli_error($db);
        if((mysqli_num_rows($result_check_health) == 1)){
            $final_result_health = mysqli_fetch_assoc($result_check_health);
            $customer_afm = json_encode($final_result_health['afm']);
            $customer_id = json_encode($final_result_health['id']);
            $query_checker_health = "SELECT * FROM customer_health WHERE afm=$customer_afm and customer_email='$email_health'";
            $result_check_health = mysqli_query($db, $query_checker_health);
            if((mysqli_num_rows($result_check_health) == 0)){
                $query_insert_health = "INSERT INTO customer_health (users_id, afm, height, weight1, health, health_text, sleep, sleep_text, appetite, appetite_text, diseases_text, meds_text, surgery_text)
                VALUES ($customer_id, $customer_afm, '$height','$weight','$health', '$health_text', '$sleep', '$sleep_text', '$appetite', '$appetite_text', '$diseases_text', '$meds_text','$surgery_text')";
                if(mysqli_query($db, $query_insert_health)!= FALSE){
                    echo '{"response": "Insert of Customer Health Completed"}';
                }
            }else{
                //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
                //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
                mysqli_query($db, "UPDATE customer_health SET height='$height',weight1='$weight', health='$health', health_text='$health_text', sleep='$sleep',sleep_text='$sleep_text',
                 appetite='$appetite', appetite_text='$appetite_text', diseases_text='$diseases_text', meds_text='$meds_text', surgery_text='$surgery_text' WHERE users_id=$customer_id");
                echo '{"response": "Data Updated"}';
            }
        }else{
            echo '{"response": "More than one user with the same health issues"}';
        }
            /*
                    $query_insert_2 = "INSERT INTO customer_health (users_id, customer_email,  height, weight1, sleep, health, health_text, diseases_text, meds_text, surgery_text)
                    VALUES ($customer_id,'$email_health', '$height','$weight', '$sleep', '$health', '$health_text', '$diseases_text', '$meds_text','$surgery_text')";
                    if(mysqli_query($db, $query_insert_2)){
                    // echo $query_insert_2;
                        echo '{"message": "Successfull Sign In"}';
                    }else{
                        //mysqli_close($db);
                        $query_delete_reg = "DELETE * FROM customer_health WHERE users_id = $customer_id " ;
                        echo '{"response": "False Query", "message": "Didnt pass through"}'.mysqli_error($db);
            }*/
    }else{
        echo '{"response": "Problem Occuried. Problem With Customer Email."}';
    }
    
// CUSTOMER HABITS 
}elseif(isset($_POST['checker_client_habits'])==4){
    $smoking = mysqli_real_escape_string($db, $_POST['ajax_smoking']);
    $dairy = mysqli_real_escape_string($db, $_POST['ajax_dairy']);
    $drink = mysqli_real_escape_string($db, $_POST['ajax_drink']);
    $exercise = mysqli_real_escape_string($db, $_POST['ajax_exercise']);
    $salt = mysqli_real_escape_string($db, $_POST['ajax_salt']);
    $water = mysqli_real_escape_string($db, $_POST['ajax_water']);
    $sugar = mysqli_real_escape_string($db, $_POST['ajax_sugar']);
    $digestive_tract = mysqli_real_escape_string($db, $_POST['ajax_digestive_tract']);
    $pregnacy_text = mysqli_real_escape_string($db, $_POST['ajax_pregnacy_text']);
    $pregnacy_month = mysqli_real_escape_string($db, $_POST['ajax_pregnacy_month']);
    $dermatosis_text = mysqli_real_escape_string($db, $_POST['ajax_dermatosis_text']);
    $children_text = mysqli_real_escape_string($db, $_POST['ajax_children_text']);
    $age_text = mysqli_real_escape_string($db, $_POST['ajax_age_text']);
    $breast_feeding_text = mysqli_real_escape_string($db, $_POST['ajax_breast_feeding_text']);
    $menstruation_text = mysqli_real_escape_string($db, $_POST['ajax_menstruation_text']);
    $menstruation_time_text = mysqli_real_escape_string($db, $_POST['ajax_menstruation_time_text']);
    $menstruation_frequency_text = mysqli_real_escape_string($db, $_POST['ajax_menstruation_frequency_text']);
    $menopause_text = mysqli_real_escape_string($db, $_POST['ajax_menopause_text']);
    $sex_life_text = mysqli_real_escape_string($db, $_POST['ajax_sex_life_text']);
    $birth_control_text = mysqli_real_escape_string($db, $_POST['ajax_birth_control_text']);
    $birth_control_2_text= mysqli_real_escape_string($db, $_POST['ajax_birth_control_2_text']);
    $email_habit = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    //echo $_SESSION['email'];
    $query_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_data = mysqli_query($db,$query_take_id);// ΤΟ ΣΤΕΛΝΩ ΣΤΗ ΒΑΣΗ
    //echo mysqli_num_rows($result_check_data);
    if((mysqli_num_rows($result_check_data) == 1)){// ΕΑΝ ΥΠΑΡΧΕΙ ΕΓΓΡΑΦΗ ΠΕΛΑΤΗ ΜΕ ΤΟ ΣΥΓΚΕΚΡΙΜΕΝΟ ΜΕΙΛ
        $final_result = mysqli_fetch_assoc($result_check_data);
        $customer_afm = json_encode($final_result['afm']);
        $customer_appnt_day = json_encode($final_result['next_appointment']);
        $customer_id = json_encode($final_result['id']);
        //echo $customer_appnt_day;
        $query_checker_habits = "SELECT * FROM customer_habits WHERE afm= $customer_afm or appointment=$customer_appnt_day";
        $result_check_habits = mysqli_query($db, $query_checker_habits);
        //echo mysqli_num_rows($result_check_habits);
        echo mysqli_error($db);
        if((mysqli_num_rows($result_check_habits)==0)){// ΕΑΝ ΔΕΝ ΥΠΑΡΧΕΙ ΤΟ HABITS ΤΟΥ ΠΕΛΑΤΗ ΔΗΜΙΟΥΡΓΗΣΕ
            $query_insert_habits = "INSERT INTO 
            customer_habits (users_id, afm, appointment, smoking, dairy, drink, exercise, salt, water, sugar, digestive_tract, pregnacy_text, pregnacy_month, dermatosis_text, children_text,
            age_text, breast_feeding_text, menstruation_text, menstruation_time_text, menstruation_frequency_text, menopause_text, sex_life_text, birth_control_text,birth_control_2_text) 
            VALUES 
            ($customer_id, $customer_afm, $customer_appnt_day,'$smoking', '$dairy','$drink', '$exercise', '$salt', '$water', '$sugar', '$digestive_tract', '$pregnacy_text', 
            '$pregnacy_month ', '$dermatosis_text', '$children_text', '$age_text', '$breast_feeding_text', '$menstruation_text', '$menstruation_time_text',
            '$menstruation_frequency_text', '$menopause_text', '$sex_life_text', '$birth_control_text', '$birth_control_2_text')";
            if(mysqli_query($db, $query_insert_habits)!= FALSE){
                echo '{"response": "Insert Habits Completed"}'.mysqli_error($db);
            }else{
                //mysqli_close($db);
                $query_delete_reg = "DELETE * FROM customer_habits WHERE afm = $customer_afm and appointment_day=$customer_appnt_day " ;
                echo '{"response": "False During Insert"}'.mysqli_error($db);
            }
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_habits SET afm=$customer_afm, appointment_day=$customer_appnt_day, smoking='$smoking', dairy='$dairy',drink='$drink',
            exercise='$exercise', salt='$salt', water='$water', sugar='$sugar', digestive_tract='$digestive_tract', pregnacy_text='$pregnacy_text', dermatosis_text='$dermatosis_text', 
            children_text='$children_text', age_text='$age_text', breast_feeding_text='$breast_feeding_text',menstruation_text='$menstruation_text', sex_life_text='$sex_life_text',
            menstruation_time_text='$menstruation_time_text', menstruation_frequency_text = '$menstruation_frequency_text', menopause_text='$menopause_text',
            birth_control_text='$birth_control_text',birth_control_2_text='$birth_control_2_text' WHERE afm =$customer_afm");
            echo '{"response": "Insert Habits Update"}';
        }
    }
    else{
        echo '{"response": "Customer Does Not Exist"}';
    }

// CUSTOMER FACE
}elseif(isset($_POST['checker_client_face'])==5){
    $face_type_text = mysqli_real_escape_string($db, $_POST['ajax_face_type_text']);
    $skin_description_text = mysqli_real_escape_string($db, $_POST['ajax_skin_description_text']);
    $facial_text = mysqli_real_escape_string($db, $_POST['ajax_facial_text']);
    $facial_past_text = mysqli_real_escape_string($db, $_POST['ajax_facial_past_text']);
    $surgery_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_text']);
    $date_face = mysqli_real_escape_string($db, $_POST['ajax_date_face']);
    $products_face = mysqli_real_escape_string($db, $_POST['ajax_products_face']);
    $face_results_text = mysqli_real_escape_string($db, $_POST['ajax_face_results_text']);
    $face_therapy_text = mysqli_real_escape_string($db, $_POST['ajax_face_therapy_text']);
    $face_nutrution_text = mysqli_real_escape_string($db, $_POST['ajax_face_nutrution_text']);
    $face_comms_text = mysqli_real_escape_string($db, $_POST['ajax_face_comms_text']);
    $email_face = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    //$customer_id = $_SESSION['id'];
    $query_face_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_face = mysqli_query($db,$query_face_take_id);
    if((mysqli_num_rows($result_check_face) == 1)){ //ΕΑΝ ΥΠΑΡΧΕΙ Ο ΠΕΛΑΤΗΣ ΤΟΤΕ
        $final_result_face = mysqli_fetch_assoc($result_check_face);
        $customer_afm = json_encode($final_result_face['afm']);
        $customer_id = json_encode($final_result_face['id']);
        $customer_appnt_day = $final_result_face['next_appointment'];
        //var_dump($date_face,$customer_appnt_day);
        //echo var_dump($customer_appnt_day,$date_face);
        $query_checker_face = "SELECT * FROM customer_face WHERE afm=$current_afm "; //and appointment=$customer_appnt_day
        $result_check_face = mysqli_query($db, $query_checker_face);
        if((mysqli_num_rows($result_check_face) == 0)){
            $query_insert_face = 
            "INSERT INTO customer_face 
            (users_id,afm ,appointment, face_type_text, skin_description_text, facial_text, facial_past_text, surgery_text, face_products,
            face_results_text, face_therapy_text, face_nutrution_text, face_comms_text) 

            VALUES ($customer_id,$customer_afm, '$date_face' , '$face_type_text', '$skin_description_text', '$facial_text', '$facial_past_text',
            '$surgery_text', '$products_face', '$face_results_text', '$face_therapy_text', '$face_nutrution_text', '$face_comms_text')";

            $result_insert_face = mysqli_query($db, $query_insert_face);
            if($result_insert_face!= FALSE){
                echo '{"response": "Insert Face Data Completed"}';
            }else{
                //mysqli_close($db);
                $query_delete_reg = "DELETE * FROM customer_face WHERE afm = $customer_afm and appointment_day=$customer_appnt_day" ;

                echo '{"response": "Problem During Insert.Entry Deleted"}'.mysqli_error($db);
            }
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_face SET appointment = '$date_face' ,
            face_type_text='$face_type_text', skin_description_text='$skin_description_text', facial_text = '$facial_text',
            facial_past_text ='$facial_past_text', face_products= '$products_face' , surgery_text = '$surgery_text',  face_results_text= '$face_results_text', 
            face_therapy_text = '$face_therapy_text', face_nutrution_text='$face_nutrution_text', face_comms_text='$face_comms_text' WHERE afm = $customer_afm ");

            echo '{"response": "Update Face Data Completed"}'.mysqli_error($db);
        }
    }
        //echo mysqli_query($db, $query_insert_face);
        //echo mysqli_error($db);
        //if(mysqli_query($db, $query_insert_face) != false){
            //echo '{"response": "True Query","message": "Successfull"}';
        //}else{
        //$response_face = '{"response": "False Query", "message": "Didnt pass through"}';
            //echo $response_face;
        //}
// CUSTOMER BREAST
}elseif(isset($_POST['checker_client_breast'])==6){
    $breast_type_text = mysqli_real_escape_string($db, $_POST['ajax_breast_type_text']);
    $breast_data_text = mysqli_real_escape_string($db, $_POST['ajax_breast_data_text']);
    $breast_care_text = mysqli_real_escape_string($db, $_POST['ajax_breast_care_text']);
    $breast_care_past_text = mysqli_real_escape_string($db, $_POST['ajax_breast_care_past_text']);
    $surgery_breast_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_breast_text']);
    $distance_niple_other = mysqli_real_escape_string($db, $_POST['ajax_distance_niple_other']);
    $distance_rniple_navel = mysqli_real_escape_string($db, $_POST['ajax_distance_rniple_navel']);
    $distance_lniple_navel = mysqli_real_escape_string($db, $_POST['ajax_distance_lniple_navel']);
    $breast_contour = mysqli_real_escape_string($db, $_POST['ajax_breast_contour']);
    $date_breast_1 = mysqli_real_escape_string($db, $_POST['ajax_date_breast_1']);
    $date_products_1 = mysqli_real_escape_string($db, $_POST['ajax_date_products_1']);
    $distance_niple_other_after = mysqli_real_escape_string($db, $_POST['ajax_distance_niple_other_after']);
    $distance_rniple_navel_after = mysqli_real_escape_string($db, $_POST['ajax_distance_rniple_navel_after']);
    $distance_lniple_navel_after = mysqli_real_escape_string($db, $_POST['ajax_distance_lniple_navel_after']);
    $breast_contour_after = mysqli_real_escape_string($db, $_POST['ajax_breast_contour_after']);
    $breast_products = mysqli_real_escape_string($db, $_POST['ajax_breast_products']);
    $breast_nutrition = mysqli_real_escape_string($db, $_POST['ajax_breast_nutrition']);
    $breast_comms = mysqli_real_escape_string($db, $_POST['ajax_breast_comms']);
    $email_breast = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    //echo $current_afm;
    $query_breast_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_breast = mysqli_query($db,$query_breast_take_id);
    if((mysqli_num_rows($result_check_breast) == 1)){
        $final_result_breast = mysqli_fetch_assoc($result_check_breast);
        $customer_afm = json_encode($final_result_breast['afm']);
        $customer_id = json_encode($final_result_breast['id']);
        $query_checker_breast = "SELECT * FROM customer_breast WHERE afm=$current_afm ";
        $result_insert_breast = mysqli_query($db, $query_checker_breast);
         //echo json_encode($result_check_breast);
        //echo $email_breast.'--'.$customer_id;
        if((mysqli_num_rows($result_insert_breast) == 0)){
            $query_insert_breast = "INSERT INTO customer_breast 
            (users_id,afm ,appointment, breast_type_text, breast_data_text, breast_care_text, breast_care_past_text, surgery_breast_text,
            distance_niple_other,distance_rniple_navel,distance_lniple_navel,breast_contour, date_products_1,
            distance_niple_other_after,distance_rniple_navel_after,distance_lniple_navel_after,breast_contour_after,breast_products,
            breast_nutrition,breast_comms) 

            VALUES 
            ($customer_id, $customer_afm, '$date_breast_1','$breast_type_text', '$breast_data_text', '$breast_care_text', '$breast_care_past_text','$surgery_breast_text',
            '$distance_niple_other','$distance_rniple_navel','$distance_lniple_navel','$breast_contour','$date_products_1','$distance_niple_other_after',
            '$distance_rniple_navel_after','$distance_lniple_navel_after','$breast_contour_after','$breast_products','$breast_nutrition','$breast_comms')";

            if(mysqli_query($db, $query_insert_breast)!= FALSE){
                echo '{"response": "Insert Breast Data Completed"}'.mysqli_error($db);
            }else{
                //mysqli_close($db);
                $query_delete_reg = "DELETE * FROM customer_health WHERE afm=$current_afm " ;
                echo '{"response": "Problem During Insert.Entry Deleted"}'.mysqli_error($db);
            }
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_breast 
            SET appointment='$date_breast_1', breast_type_text = '$breast_type_text', breast_data_text='$breast_data_text', breast_care_text= '$breast_care_text',
            breast_care_past_text = '$breast_care_past_text', surgery_breast_text = '$surgery_breast_text', distance_niple_other = '$distance_niple_other',
            distance_rniple_navel = '$distance_rniple_navel' ,distance_lniple_navel = '$distance_lniple_navel' ,breast_contour='$breast_contour',
            date_products_1='$date_products_1',distance_niple_other_after='$distance_niple_other_after' ,distance_rniple_navel_after='$distance_rniple_navel_after',
            distance_lniple_navel_after = '$distance_lniple_navel_after', breast_contour_after='$breast_contour_after', breast_products ='$breast_products' ,
            breast_nutrition ='$breast_nutrition', breast_comms='$breast_comms' 
            WHERE afm = $customer_afm ");
            
            echo '{"response": "Update Breast Data Completed"}'.mysqli_error($db);
        }
    }
// CUSTOMER BODY
}elseif(isset($_POST['checker_client_body'])==7){
    $body_type_text = mysqli_real_escape_string($db, $_POST['ajax_body_type_text']);
    $body_type_comms = mysqli_real_escape_string($db, $_POST['ajax_body_type_comms']);
    $body_care_text = mysqli_real_escape_string($db, $_POST['ajax_body_care_text']);
    $body_care_past_text = mysqli_real_escape_string($db, $_POST['ajax_body_care_past_text']);
    $body_surgery_text = mysqli_real_escape_string($db, $_POST['ajax_body_surgery_text']);
    $body_middle = mysqli_real_escape_string($db, $_POST['ajax_body_middle']);
    $body_hip = mysqli_real_escape_string($db, $_POST['ajax_body_hip']);
    $body_right_thigh = mysqli_real_escape_string($db, $_POST['ajax_body_right_thigh']);
    $body_left_thigh = mysqli_real_escape_string($db, $_POST['ajax_body_left_thigh']);
    $body_right_knee = mysqli_real_escape_string($db, $_POST['ajax_body_right_knee']);
    $body_left_knee = mysqli_real_escape_string($db, $_POST['ajax_body_left_knee']);
    $body_right_ankle = mysqli_real_escape_string($db, $_POST['ajax_body_right_ankle']);
    $body_left_ankle = mysqli_real_escape_string($db, $_POST['ajax_body_left_ankle']);
    $body_middle_after = mysqli_real_escape_string($db, $_POST['ajax_body_middle_after']);
    $body_hip_after = mysqli_real_escape_string($db, $_POST['ajax_body_hip_after']);
    $body_right_thigh_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_thigh_after']);
    $body_left_thigh_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_thigh_after']);
    $body_right_knee_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_knee_after']);
    $body_left_knee_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_knee_after']);
    $body_right_ankle_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_ankle_after']);
    $body_left_ankle_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_ankle_after']);
    $body_date = mysqli_real_escape_string($db, $_POST['ajax_body_date']);
    $body_products = mysqli_real_escape_string($db, $_POST['ajax_body_products']);
    $body_comments = mysqli_real_escape_string($db, $_POST['ajax_body_comments']);
    $checkboxes_value = mysqli_real_escape_string($db, $_POST['ajax_checkboxes_value']);
    $email_body = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    $query_body_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_body = mysqli_query($db,$query_body_take_id);
    if((mysqli_num_rows($result_check_body) == 1)){// Ελεγχει εαν υπαρχει μια γραμμη του query απο πανω και εαν true βρισκουμε το users_id της γραμμης.
        $final_result_body = mysqli_fetch_assoc($result_check_body);
        $customer_afm = json_encode($final_result_body['afm']);
        $customer_id = json_encode($final_result_body['id']);
        $query_checker_body = "SELECT * FROM customer_body WHERE afm=$current_afm";
        $result_check_body = mysqli_query($db, $query_checker_body);
        if((mysqli_num_rows($result_check_body)==0)){
            $query_insert_body = "INSERT INTO customer_body 
            (users_id, afm, appointment, body_type_text, body_type_comms, body_care_text, body_care_past_text, body_surgery_text, body_middle, body_hip, body_right_thigh, body_left_thigh, body_right_knee,
            body_left_knee, body_right_ankle, body_left_ankle, body_middle_after, body_hip_after, body_right_thigh_after, body_left_thigh_after, body_right_knee_after,
            body_left_knee_after, body_right_ankle_after, body_left_ankle_after, body_products, body_comments, checkboxes_value ) 
            VALUES 
            ($customer_id, $customer_afm, '$body_date', '$body_type_text', '$body_type_comms', '$body_care_text','$body_care_past_text','$body_surgery_text', '$body_middle', '$body_hip','$body_right_thigh','$body_left_thigh',
            '$body_right_knee','$body_left_knee', '$body_right_ankle','$body_left_ankle','$body_middle_after','$body_hip_after','$body_right_thigh_after','$body_left_thigh_after','$body_right_knee_after',
            '$body_left_knee_after','$body_right_ankle_after', '$body_left_ankle_after','$body_products','$body_comments','$checkboxes_value')";
            //echo mysqli_query($db, $query_insert_face);
            //echo mysqli_error($db);
            if(mysqli_query($db, $query_insert_body)!= FALSE){
                echo '{"response": "Insert Body Data Completed"}'.mysqli_error($db);
            }else{
                //mysqli_close($db);
                $query_delete_reg = "DELETE * FROM customer_body WHERE afm=$current_afm " ;
                echo '{"response": "Problem During Insert.Entry Deleted"}'.mysqli_error($db);
            }
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_body 
            SET appointment='$body_date',body_type_text='$body_type_text',body_type_comms='$body_type_comms',body_care_text='$body_care_text',body_care_past_text='$body_care_past_text',
            body_surgery_text='$body_surgery_text',body_middle='$body_middle',body_hip='$body_hip',body_right_thigh='$body_right_thigh',
            body_left_thigh='$body_left_thigh',body_right_knee='$body_right_knee',body_left_knee='$body_left_knee', body_right_ankle='$body_right_ankle', body_left_ankle='$body_left_ankle', 
            body_middle_after='$body_middle_after',body_hip_after='$body_hip_after', body_right_thigh_after='$body_right_thigh_after',
            body_left_thigh_after='$body_left_thigh_after', body_right_knee_after='$body_right_knee_after', body_left_knee_after='$body_left_knee_after', body_right_ankle_after='$body_right_ankle_after', 
            body_left_ankle_after ='$body_left_ankle_after', body_products='$body_products', body_comments='$body_comments', checkboxes_value='$checkboxes_value'
            WHERE afm=$current_afm");

            echo '{"response": "Update Body Data Completed"}';
        }
    }
//UPDATE  
}elseif(isset($_POST['checker_update_data'])==2.1){
    $firstname = mysqli_real_escape_string($db, $_POST['ajax_fname']);
    $lastname = mysqli_real_escape_string($db, $_POST['ajax_lname']);
    $email = mysqli_real_escape_string($db, $_POST['ajax_email']);
    $phone = mysqli_real_escape_string($db, $_POST['ajax_phone']);
    $birth = mysqli_real_escape_string($db, $_POST['ajax_birth']);
    $name_beautician = mysqli_real_escape_string($db, $_POST['ajax_name_beautician']);
    $afm= intval($_SESSION['afm']);
    //$comments = mysqli_real_escape_string($db, $_POST['ajax_comments']);
    $query_take_id = "SELECT * FROM personal_data WHERE afm = $afm ";
    $result_check_update_data = mysqli_query($db,$query_take_id);
    echo mysqli_error($db);
    if((mysqli_num_rows($result_check_update_data) == 1)){
        $final_result = mysqli_fetch_assoc($result_check_update_data);
        //$customer_afm = $final_result['afm'];
        $customer_phone = intval($final_result['phone']);
        //echo gettype($afm);
        $query_checker_data = "SELECT * FROM personal_data WHERE afm=$afm";
        $result_check = mysqli_query($db, $query_checker_data);
        echo mysqli_error($db);
        if((mysqli_num_rows($result_check)!=0)){
            $data_update = mysqli_query($db, 
            "UPDATE personal_data 
            SET firstname='$firstname', lastname='$lastname', phone='$phone', name_beautician='$name_beautician', email='$email', birthday='$birth' WHERE phone=$customer_phone and afm=$afm "); 
            if($data_update !=FALSE ){
                //$_SESSION['email'] = $email;
               // mysqli_query($db, "UPDATE customer_health,customer_habits,customer_face,customer_breast,customer_body
                 //SET customer_email=".$_SESSION['email']." WHERE users_id=$customer_id");
                echo '{"response": "Data Update"}'.mysqli_error($db);
            }else{
                echo '{"response": "Problem Occured During Update"}'.mysqli_error($db);
            }
        }else{
            echo '{"response": "No Original Data For Customer Data"}';
        }
    }else{
        echo '{"response": "Client Data Doesnt Exist"}';
    }

}elseif(isset($_POST['checker_client_update_health'])==3.1){
    $height = mysqli_real_escape_string($db, $_POST['ajax_height']);
    $weight = mysqli_real_escape_string($db, $_POST['ajax_weight']);
    $health = mysqli_real_escape_string($db, $_POST['ajax_health_choice']);
    $health_text = mysqli_real_escape_string($db, $_POST['ajax_health_text']);
    $sleep = mysqli_real_escape_string($db, $_POST['ajax_sleep_choice']);
    $sleep_text = mysqli_real_escape_string($db, $_POST['ajax_sleep_text']);
    $appetite = mysqli_real_escape_string($db, $_POST['ajax_appetite_choice']);
    $appetite_text = mysqli_real_escape_string($db, $_POST['ajax_appetite_text']);
    $diseases_text = mysqli_real_escape_string($db, $_POST['ajax_diseases_text']);
    $meds_text = mysqli_real_escape_string($db, $_POST['ajax_meds_text']);
    $surgery_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_text']);
    $current_afm = intval($_SESSION['afm']);
    $query_health_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_health = mysqli_query($db,$query_health_take_id);
    echo mysqli_error($db);
    if((mysqli_num_rows($result_check_health) == 1)){
        $final_result_health = mysqli_fetch_assoc($result_check_health);
        $customer_id = json_encode($final_result_health['id']);
        $query_checker_health = "SELECT * FROM customer_health WHERE afm=$current_afm";
        $result_check_health = mysqli_query($db, $query_checker_health);
        if((mysqli_num_rows($result_check_health) != 0)){
            mysqli_query($db, "UPDATE customer_health SET height='$height',weight1='$weight', health='$health', health_text='$health_text', sleep='$sleep',sleep_text='$sleep_text',
            appetite='$appetite', appetite_text='$appetite_text', diseases_text='$diseases_text', meds_text='$meds_text', surgery_text='$surgery_text'WHERE afm=$current_afm");
           echo '{"response": "Data Updated"}'.mysqli_error($db);
        }elseif((mysqli_num_rows($result_check_health) != 0)){
            echo '{"response": "No Entry For Current AFM"}'.mysqli_error($db);
        }else{
            echo '{"response": "No Update"}'.mysqli_error($db);
        }   
    }else{
        echo '{"response": "More than one user with the same health issues"}'.mysqli_error($db);
    }
}elseif(isset($_POST['checker_client_update_habits'])==4.1){
    $smoking = mysqli_real_escape_string($db, $_POST['ajax_smoking']);
    $dairy = mysqli_real_escape_string($db, $_POST['ajax_dairy']);
    $drink = mysqli_real_escape_string($db, $_POST['ajax_drink']);
    $exercise = mysqli_real_escape_string($db, $_POST['ajax_exercise']);
    $salt = mysqli_real_escape_string($db, $_POST['ajax_salt']);
    $water = mysqli_real_escape_string($db, $_POST['ajax_water']);
    $sugar = mysqli_real_escape_string($db, $_POST['ajax_sugar']);
    $digestive_tract = mysqli_real_escape_string($db, $_POST['ajax_digestive_tract']);
    $pregnacy_text = mysqli_real_escape_string($db, $_POST['ajax_pregnacy_text']);
    $pregnacy_month = mysqli_real_escape_string($db, $_POST['ajax_pregnacy_month']);
    $dermatosis_text = mysqli_real_escape_string($db, $_POST['ajax_dermatosis_text']);
    $children_text = mysqli_real_escape_string($db, $_POST['ajax_children_text']);
    $age_text = mysqli_real_escape_string($db, $_POST['ajax_age_text']);
    $breast_feeding_text = mysqli_real_escape_string($db, $_POST['ajax_breast_feeding_text']);
    $menstruation_text = mysqli_real_escape_string($db, $_POST['ajax_menstruation_text']);
    $menstruation_time_text = mysqli_real_escape_string($db, $_POST['ajax_menstruation_time_text']);
    $menstruation_frequency_text = mysqli_real_escape_string($db, $_POST['ajax_menstruation_frequency_text']);
    $menopause_text = mysqli_real_escape_string($db, $_POST['ajax_menopause_text']);
    $sex_life_text = mysqli_real_escape_string($db, $_POST['ajax_sex_life_text']);
    $birth_control_text = mysqli_real_escape_string($db, $_POST['ajax_birth_control_text']);
    $birth_control_2_text= mysqli_real_escape_string($db, $_POST['ajax_birth_control_2_text']);
    $current_afm = intval($_SESSION['afm']);
    $query_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_habits = mysqli_query($db,$query_take_id);
    if((mysqli_num_rows($result_check_habits) == 1)){
        $final_result = mysqli_fetch_assoc($result_check_habits);
        $customer_id = json_encode($final_result['id']);
        $query_checker_habits = "SELECT * FROM customer_habits WHERE afm=$current_afm";
        $result_check_habits = mysqli_query($db, $query_checker_habits);
        if((mysqli_num_rows($result_check_habits) != 0)){
            mysqli_query($db, "UPDATE customer_habits SET smoking='$smoking', dairy='$dairy',drink='$drink',
            exercise='$exercise', salt='$salt', water='$water', sugar='$sugar', digestive_tract='$digestive_tract', pregnacy_text='$pregnacy_text', dermatosis_text='$dermatosis_text', 
            children_text='$children_text', age_text='$age_text', breast_feeding_text='$breast_feeding_text',menstruation_text='$menstruation_text', sex_life_text='$sex_life_text',
            menstruation_time_text='$menstruation_time_text', menstruation_frequency_text = '$menstruation_frequency_text', menopause_text='$menopause_text',
            birth_control_text='$birth_control_text',birth_control_2_text='$birth_control_2_text' WHERE afm =$current_afm");
            echo '{"response": "Data Updated"}';
        }elseif((mysqli_num_rows($result_check_habits) != 0)){
            echo '{"response": "No Entry For Current AFM"}'.mysqli_error($db);
        }else{
            echo '{"response": "No Update"}'.mysqli_error($db);
        }   
    }else{
        echo '{"response": "More than one user with the same habits issues"}';
    }
}elseif(isset($_POST['checker_show_data_face_breast_body'])==9){
    $afm = mysqli_real_escape_string($db, $_POST['ajax_afm']);
    $_SESSION['afm'] = $afm;
    $query_take_afm = "SELECT * FROM personal_data WHERE afm=$afm";
    $result_check_personal_data = mysqli_query($db,$query_take_afm);
    if((mysqli_num_rows($result_check_personal_data) == 1)){
        //---------------------------------------------------------------------------------------------------------FACE----------------------------------------------------------------
        $query_face_afm = "SELECT * FROM customer_face WHERE afm=$afm ORDER BY appointment";
        $result_face = mysqli_query($db,$query_face_afm);
        if((mysqli_num_rows($result_face) >= 1)){
            $result_query_face = mysqli_fetch_all($result_face);
            $final_response_face = $result_query_face ;
            //echo '{"response": '.json_encode($result_query_face).'}';
        }else{
            
            $final_response_face="Wrong Face Query";
        }
        //---------------------------------------------------------------------------------------------------------BODY----------------------------------------------------------------
        $query_body_afm = "SELECT * FROM customer_body WHERE afm=$afm ORDER BY appointment";
        $result_body = mysqli_query($db,$query_body_afm);
        if((mysqli_num_rows($result_body) >= 1)){
            $result_query_body = mysqli_fetch_all($result_body);
            $final_response_body = $result_query_body ;
        }else{
            $final_response_body = "Wrong Body Query";
        }
        //---------------------------------------------------------------------------------------------------------BREAST----------------------------------------------------------------
        $query_breast_afm = "SELECT * FROM customer_breast WHERE afm=$afm ORDER BY appointment";
        $result_breast = mysqli_query($db,$query_breast_afm);
        if((mysqli_num_rows($result_breast) >= 1)){
            $result_query_breast = mysqli_fetch_all($result_breast);
            $final_response_breast = $result_query_breast;
            //echo '{"response": '.json_encode($result_query_breast).'}';
        }else{
            $final_response_breast = "Wrong Breast Query" ;
        }
        echo '{"response_face": '.json_encode($final_response_face).',"response_body": '.json_encode($final_response_body).',"response_breast": '.json_encode($final_response_breast).'}';
    }else{
        echo '{"response": "No Data For Face"}';
    }
//INSERT-UPDATE FOR THIRD PAGE 
}elseif(isset($_POST['checker_insert_face'])==5.1){
    $face_type_text = mysqli_real_escape_string($db, $_POST['ajax_face_type_text']);
    $skin_description_text = mysqli_real_escape_string($db, $_POST['ajax_skin_description_text']);
    $facial_text = mysqli_real_escape_string($db, $_POST['ajax_facial_text']);
    $facial_past_text = mysqli_real_escape_string($db, $_POST['ajax_facial_past_text']);
    $surgery_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_text']);
    $date_face = mysqli_real_escape_string($db, $_POST['ajax_date_face']);
    $products_face = mysqli_real_escape_string($db, $_POST['ajax_products_face']);
    $face_results_text = mysqli_real_escape_string($db, $_POST['ajax_face_results_text']);
    $face_therapy_text = mysqli_real_escape_string($db, $_POST['ajax_face_therapy_text']);
    $face_nutrution_text = mysqli_real_escape_string($db, $_POST['ajax_face_nutrution_text']);
    $face_comms_text = mysqli_real_escape_string($db, $_POST['ajax_face_comms_text']);
    //$email_face = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    //$customer_id = $_SESSION['id'];
    $query_face_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_face = mysqli_query($db,$query_face_take_id);
    if((mysqli_num_rows($result_check_face) == 1)){ //ΕΑΝ ΥΠΑΡΧΕΙ Ο ΠΕΛΑΤΗΣ ΤΟΤΕ
        $final_result_face = mysqli_fetch_assoc($result_check_face);
        $customer_afm = json_encode($final_result_face['afm']);
        $customer_id = json_encode($final_result_face['id']);
        $customer_appnt_day = $final_result_face['next_appointment'];
        //var_dump($date_face,$customer_appnt_day);
        //echo var_dump($customer_appnt_day,$date_face);
        $query_checker_face = "SELECT * FROM customer_face WHERE afm=$current_afm "; //and appointment=$customer_appnt_day
        $result_check_face = mysqli_query($db, $query_checker_face);
        if((mysqli_num_rows($result_check_face) >= 0)){
            $query_insert_face = 
            "INSERT INTO customer_face 
            (users_id,afm ,appointment, face_type_text, skin_description_text, facial_text, facial_past_text, surgery_text, face_products,
            face_results_text, face_therapy_text, face_nutrution_text, face_comms_text) 

            VALUES ($customer_id,$customer_afm, '$date_face' , '$face_type_text', '$skin_description_text', '$facial_text', '$facial_past_text',
            '$surgery_text', '$products_face', '$face_results_text', '$face_therapy_text', '$face_nutrution_text', '$face_comms_text')";

            $result_insert_face = mysqli_query($db, $query_insert_face);
            if($result_insert_face!= FALSE){
                echo '{"response": "Insert Face Data Completed"}'.mysqli_error($db);
            }else{
                //mysqli_close($db);
                $query_delete_reg = "DELETE * FROM customer_face WHERE afm = $customer_afm and appointment='$date_face'" ;

                echo '{"response": "Problem During Insert.Entry Deleted"}'.mysqli_error($db);
            }
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_face SET appointment = '$date_face' ,
            face_type_text='$face_type_text', skin_description_text='$skin_description_text', facial_text = '$facial_text',
            facial_past_text ='$facial_past_text', face_products= '$products_face' , surgery_text = '$surgery_text',  face_results_text= '$face_results_text', 
            face_therapy_text = '$face_therapy_text', face_nutrution_text='$face_nutrution_text', face_comms_text='$face_comms_text' WHERE afm = $customer_afm ");

            echo '{"response": "Update Face Data Completed"}'.mysqli_error($db);
        }
    }
}elseif(isset($_POST['checker_update_face'])==5.2){
    $face_type_text = mysqli_real_escape_string($db, $_POST['ajax_face_type_text']);
    $skin_description_text = mysqli_real_escape_string($db, $_POST['ajax_skin_description_text']);
    $facial_text = mysqli_real_escape_string($db, $_POST['ajax_facial_text']);
    $facial_past_text = mysqli_real_escape_string($db, $_POST['ajax_facial_past_text']);
    $surgery_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_text']);
    $date_face = mysqli_real_escape_string($db, $_POST['ajax_date_face']);
    $products_face = mysqli_real_escape_string($db, $_POST['ajax_products_face']);
    $face_results_text = mysqli_real_escape_string($db, $_POST['ajax_face_results_text']);
    $face_therapy_text = mysqli_real_escape_string($db, $_POST['ajax_face_therapy_text']);
    $face_nutrution_text = mysqli_real_escape_string($db, $_POST['ajax_face_nutrution_text']);
    $face_comms_text = mysqli_real_escape_string($db, $_POST['ajax_face_comms_text']);

    $current_afm = $_SESSION['afm'];
    $query_face_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_face = mysqli_query($db,$query_face_take_id);
    //echo "im in";
    if((mysqli_num_rows($result_check_face) == 1)){ //ΕΑΝ ΥΠΑΡΧΕΙ Ο ΠΕΛΑΤΗΣ ΤΟΤΕ
        $final_result_face = mysqli_fetch_assoc($result_check_face);
        $customer_afm = json_encode($final_result_face['afm']);
        $customer_id = json_encode($final_result_face['id']);
        //$customer_appnt_day = $final_result_face['next_appointment'];
        //var_dump($date_face,$customer_appnt_day);
        //echo var_dump($customer_appnt_day,$date_face);
        $query_checker_face = "SELECT * FROM customer_face WHERE afm=$current_afm "; //and appointment=$customer_appnt_day
        $result_check_face = mysqli_query($db, $query_checker_face);
        if((mysqli_num_rows($result_check_face) >= 1)){
            
            mysqli_query($db, "UPDATE customer_face SET appointment = '$date_face' ,
            face_type_text='$face_type_text', skin_description_text='$skin_description_text', facial_text = '$facial_text',
            facial_past_text ='$facial_past_text', face_products= '$products_face' , surgery_text = '$surgery_text',  face_results_text= '$face_results_text', 
            face_therapy_text = '$face_therapy_text', face_nutrution_text='$face_nutrution_text', face_comms_text='$face_comms_text' 
            WHERE afm = $current_afm and appointment='$date_face'");

             echo '{"response": "Update Face Data Completed"}'.mysqli_error($db);
    
        }else{
            echo '{"response": "No available data for face"}'.mysqli_error($db);
        }
    }

}elseif(isset($_POST['checker_insert_breast'])==6.1){
    $breast_type_text = mysqli_real_escape_string($db, $_POST['ajax_breast_type_text']);
    $breast_data_text = mysqli_real_escape_string($db, $_POST['ajax_breast_data_text']);
    $breast_care_text = mysqli_real_escape_string($db, $_POST['ajax_breast_care_text']);
    $breast_care_past_text = mysqli_real_escape_string($db, $_POST['ajax_breast_care_past_text']);
    $surgery_breast_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_breast_text']);
    $distance_niple_other = mysqli_real_escape_string($db, $_POST['ajax_distance_niple_other']);
    $distance_rniple_navel = mysqli_real_escape_string($db, $_POST['ajax_distance_rniple_navel']);
    $distance_lniple_navel = mysqli_real_escape_string($db, $_POST['ajax_distance_lniple_navel']);
    $breast_contour = mysqli_real_escape_string($db, $_POST['ajax_breast_contour']);
    $date_breast_1 = mysqli_real_escape_string($db, $_POST['ajax_date_breast_1']);
    $date_products_1 = mysqli_real_escape_string($db, $_POST['ajax_date_products_1']);
    $distance_niple_other_after = mysqli_real_escape_string($db, $_POST['ajax_distance_niple_other_after']);
    $distance_rniple_navel_after = mysqli_real_escape_string($db, $_POST['ajax_distance_rniple_navel_after']);
    $distance_lniple_navel_after = mysqli_real_escape_string($db, $_POST['ajax_distance_lniple_navel_after']);
    $breast_contour_after = mysqli_real_escape_string($db, $_POST['ajax_breast_contour_after']);
    $breast_products = mysqli_real_escape_string($db, $_POST['ajax_breast_products']);
    $breast_nutrition = mysqli_real_escape_string($db, $_POST['ajax_breast_nutrition']);
    $breast_comms = mysqli_real_escape_string($db, $_POST['ajax_breast_comms']);
    //$email_breast = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    //echo $current_afm;
    $query_breast_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_breast = mysqli_query($db,$query_breast_take_id);
    if((mysqli_num_rows($result_check_breast) == 1)){
        $final_result_breast = mysqli_fetch_assoc($result_check_breast);
        $customer_afm = json_encode($final_result_breast['afm']);
        $customer_id = json_encode($final_result_breast['id']);
        $query_checker_breast = "SELECT * FROM customer_breast WHERE afm=$current_afm ";
        $result_insert_breast = mysqli_query($db, $query_checker_breast);
         //echo json_encode($result_check_breast);
        //echo $email_breast.'--'.$customer_id;
        if((mysqli_num_rows($result_insert_breast) >= 0)){
            $query_insert_breast = "INSERT INTO customer_breast 
            (users_id,afm ,appointment, breast_type_text, breast_data_text, breast_care_text, breast_care_past_text, surgery_breast_text,
            distance_niple_other,distance_rniple_navel,distance_lniple_navel,breast_contour, date_products_1,
            distance_niple_other_after,distance_rniple_navel_after,distance_lniple_navel_after,breast_contour_after,breast_products,
            breast_nutrition,breast_comms) 

            VALUES 
            ($customer_id, $customer_afm, '$date_breast_1','$breast_type_text', '$breast_data_text', '$breast_care_text', '$breast_care_past_text','$surgery_breast_text',
            '$distance_niple_other','$distance_rniple_navel','$distance_lniple_navel','$breast_contour','$date_products_1','$distance_niple_other_after',
            '$distance_rniple_navel_after','$distance_lniple_navel_after','$breast_contour_after','$breast_products','$breast_nutrition','$breast_comms')";

            if(mysqli_query($db, $query_insert_breast)!= FALSE){
                echo '{"response": "Insert Breast Data Completed"}'.mysqli_error($db);
            }else{
                //mysqli_close($db);
                $query_delete_reg = "DELETE * FROM customer_health WHERE afm=$current_afm " ;
                echo '{"response": "Problem During Insert.Entry Deleted"}'.mysqli_error($db);
            }
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_breast 
            SET appointment='$date_breast_1', breast_type_text = '$breast_type_text', breast_data_text='$breast_data_text', breast_care_text= '$breast_care_text',
            breast_care_past_text = '$breast_care_past_text', surgery_breast_text = '$surgery_breast_text', distance_niple_other = '$distance_niple_other',
            distance_rniple_navel = '$distance_rniple_navel' ,distance_lniple_navel = '$distance_lniple_navel' ,breast_contour='$breast_contour',
            date_products_1='$date_products_1',distance_niple_other_after='$distance_niple_other_after' ,distance_rniple_navel_after='$distance_rniple_navel_after',
            distance_lniple_navel_after = '$distance_lniple_navel_after', breast_contour_after='$breast_contour_after', breast_products ='$breast_products' ,
            breast_nutrition ='$breast_nutrition', breast_comms='$breast_comms' 
            WHERE afm = $customer_afm ");
            
            echo '{"response": "Update Breast Data Completed"}'.mysqli_error($db);
        }
    }
}elseif(isset($_POST['checker_update_breast'])==6.2){
    $breast_type_text = mysqli_real_escape_string($db, $_POST['ajax_breast_type_text']);
    $breast_data_text = mysqli_real_escape_string($db, $_POST['ajax_breast_data_text']);
    $breast_care_text = mysqli_real_escape_string($db, $_POST['ajax_breast_care_text']);
    $breast_care_past_text = mysqli_real_escape_string($db, $_POST['ajax_breast_care_past_text']);
    $surgery_breast_text = mysqli_real_escape_string($db, $_POST['ajax_surgery_breast_text']);
    $distance_niple_other = mysqli_real_escape_string($db, $_POST['ajax_distance_niple_other']);
    $distance_rniple_navel = mysqli_real_escape_string($db, $_POST['ajax_distance_rniple_navel']);
    $distance_lniple_navel = mysqli_real_escape_string($db, $_POST['ajax_distance_lniple_navel']);
    $breast_contour = mysqli_real_escape_string($db, $_POST['ajax_breast_contour']);
    $date_breast_1 = mysqli_real_escape_string($db, $_POST['ajax_date_breast_1']);
    $date_products_1 = mysqli_real_escape_string($db, $_POST['ajax_date_products_1']);
    $distance_niple_other_after = mysqli_real_escape_string($db, $_POST['ajax_distance_niple_other_after']);
    $distance_rniple_navel_after = mysqli_real_escape_string($db, $_POST['ajax_distance_rniple_navel_after']);
    $distance_lniple_navel_after = mysqli_real_escape_string($db, $_POST['ajax_distance_lniple_navel_after']);
    $breast_contour_after = mysqli_real_escape_string($db, $_POST['ajax_breast_contour_after']);
    $breast_products = mysqli_real_escape_string($db, $_POST['ajax_breast_products']);
    $breast_nutrition = mysqli_real_escape_string($db, $_POST['ajax_breast_nutrition']);
    $breast_comms = mysqli_real_escape_string($db, $_POST['ajax_breast_comms']);
    //$email_breast = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    //echo $current_afm;
    $query_breast_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_breast = mysqli_query($db,$query_breast_take_id);
    if((mysqli_num_rows($result_check_breast) == 1)){
        $final_result_breast = mysqli_fetch_assoc($result_check_breast);
        $customer_afm = json_encode($final_result_breast['afm']);
        $customer_id = json_encode($final_result_breast['id']);
        $query_checker_breast = "SELECT * FROM customer_breast WHERE afm=$current_afm ";
        $result_insert_breast = mysqli_query($db, $query_checker_breast);
         //echo json_encode($result_check_breast);
        //echo $email_breast.'--'.$customer_id;
        if((mysqli_num_rows($result_insert_breast) >= 0)){
            mysqli_query($db, "UPDATE customer_breast 
            SET appointment='$date_breast_1', breast_type_text = '$breast_type_text', breast_data_text='$breast_data_text', breast_care_text= '$breast_care_text',
            breast_care_past_text = '$breast_care_past_text', surgery_breast_text = '$surgery_breast_text', distance_niple_other = '$distance_niple_other',
            distance_rniple_navel = '$distance_rniple_navel' ,distance_lniple_navel = '$distance_lniple_navel' ,breast_contour='$breast_contour',
            date_products_1='$date_products_1',distance_niple_other_after='$distance_niple_other_after' ,distance_rniple_navel_after='$distance_rniple_navel_after',
            distance_lniple_navel_after = '$distance_lniple_navel_after', breast_contour_after='$breast_contour_after', breast_products ='$breast_products' ,
            breast_nutrition ='$breast_nutrition', breast_comms='$breast_comms' 
            WHERE afm = $customer_afm and appointment='$date_breast_1'");
            
            echo '{"response": "Update Breast Data Completed"}'.mysqli_error($db);

        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            echo '{"response": "No available data for face"}'.mysqli_error($db);
        }
    }
}elseif(isset($_POST['checker_insert_body'])==7.1){
    $body_type_text = mysqli_real_escape_string($db, $_POST['ajax_body_type_text']);
    $body_type_comms = mysqli_real_escape_string($db, $_POST['ajax_body_type_comms']);
    $body_care_text = mysqli_real_escape_string($db, $_POST['ajax_body_care_text']);
    $body_care_past_text = mysqli_real_escape_string($db, $_POST['ajax_body_care_past_text']);
    $body_surgery_text = mysqli_real_escape_string($db, $_POST['ajax_body_surgery_text']);
    $body_middle = mysqli_real_escape_string($db, $_POST['ajax_body_middle']);
    $body_hip = mysqli_real_escape_string($db, $_POST['ajax_body_hip']);
    $body_right_thigh = mysqli_real_escape_string($db, $_POST['ajax_body_right_thigh']);
    $body_left_thigh = mysqli_real_escape_string($db, $_POST['ajax_body_left_thigh']);
    $body_right_knee = mysqli_real_escape_string($db, $_POST['ajax_body_right_knee']);
    $body_left_knee = mysqli_real_escape_string($db, $_POST['ajax_body_left_knee']);
    $body_right_ankle = mysqli_real_escape_string($db, $_POST['ajax_body_right_ankle']);
    $body_left_ankle = mysqli_real_escape_string($db, $_POST['ajax_body_left_ankle']);
    $body_middle_after = mysqli_real_escape_string($db, $_POST['ajax_body_middle_after']);
    $body_hip_after = mysqli_real_escape_string($db, $_POST['ajax_body_hip_after']);
    $body_right_thigh_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_thigh_after']);
    $body_left_thigh_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_thigh_after']);
    $body_right_knee_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_knee_after']);
    $body_left_knee_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_knee_after']);
    $body_right_ankle_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_ankle_after']);
    $body_left_ankle_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_ankle_after']);
    $body_date = mysqli_real_escape_string($db, $_POST['ajax_body_date']);
    $body_products = mysqli_real_escape_string($db, $_POST['ajax_body_products']);
    $body_comments = mysqli_real_escape_string($db, $_POST['ajax_body_comments']);
    $checkboxes_value = mysqli_real_escape_string($db, $_POST['ajax_checkboxes_value']);
    //$email_body = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    $query_body_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_body = mysqli_query($db,$query_body_take_id);
    if((mysqli_num_rows($result_check_body) == 1)){// Ελεγχει εαν υπαρχει μια γραμμη του query απο πανω και εαν true βρισκουμε το users_id της γραμμης.
        $final_result_body = mysqli_fetch_assoc($result_check_body);
        $customer_afm = json_encode($final_result_body['afm']);
        $customer_id = json_encode($final_result_body['id']);
        $query_checker_body = "SELECT * FROM customer_body WHERE afm=$current_afm";
        $result_check_body = mysqli_query($db, $query_checker_body);
        if((mysqli_num_rows($result_check_body)>=0)){
            $query_insert_body = "INSERT INTO customer_body 
            (users_id, afm, appointment, body_type_text, body_type_comms, body_care_text, body_care_past_text, body_surgery_text, body_middle, body_hip, body_right_thigh, body_left_thigh, body_right_knee,
            body_left_knee, body_right_ankle, body_left_ankle, body_middle_after, body_hip_after, body_right_thigh_after, body_left_thigh_after, body_right_knee_after,
            body_left_knee_after, body_right_ankle_after, body_left_ankle_after, body_products, body_comments, checkboxes_value ) 
            VALUES 
            ($customer_id, $customer_afm, '$body_date', '$body_type_text', '$body_type_comms', '$body_care_text','$body_care_past_text','$body_surgery_text', '$body_middle', '$body_hip','$body_right_thigh','$body_left_thigh',
            '$body_right_knee','$body_left_knee', '$body_right_ankle','$body_left_ankle','$body_middle_after','$body_hip_after','$body_right_thigh_after','$body_left_thigh_after','$body_right_knee_after',
            '$body_left_knee_after','$body_right_ankle_after', '$body_left_ankle_after','$body_products','$body_comments','$checkboxes_value')";
            //echo mysqli_query($db, $query_insert_face);
            //echo mysqli_error($db);
            if(mysqli_query($db, $query_insert_body)!= FALSE){
                echo '{"response": "Insert Body Data Completed"}'.mysqli_error($db);
            }else{
                //mysqli_close($db);
                $query_delete_reg = "DELETE * FROM customer_body WHERE afm=$current_afm " ;
                echo '{"response": "Problem During Insert.Entry Deleted"}'.mysqli_error($db);
            }
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_body 
            SET appointment='$body_date',body_type_text='$body_type_text',body_type_comms='$body_type_comms',body_care_text='$body_care_text',body_care_past_text='$body_care_past_text',
            body_surgery_text='$body_surgery_text',body_middle='$body_middle',body_hip='$body_hip',body_right_thigh='$body_right_thigh',
            body_left_thigh='$body_left_thigh',body_right_knee='$body_right_knee',body_left_knee='$body_left_knee', body_right_ankle='$body_right_ankle', body_left_ankle='$body_left_ankle', 
            body_middle_after='$body_middle_after',body_hip_after='$body_hip_after', body_right_thigh_after='$body_right_thigh_after',
            body_left_thigh_after='$body_left_thigh_after', body_right_knee_after='$body_right_knee_after', body_left_knee_after='$body_left_knee_after', body_right_ankle_after='$body_right_ankle_after', 
            body_left_ankle_after ='$body_left_ankle_after', body_products='$body_products', body_comments='$body_comments', checkboxes_value='$checkboxes_value'
            WHERE afm=$current_afm and appointment='$body_date'");

            echo '{"response": "Update Body Data Completed"}';
        }
    }
}elseif(isset($_POST['checker_update_body'])==7.2){
    $body_type_text = mysqli_real_escape_string($db, $_POST['ajax_body_type_text']);
    $body_type_comms = mysqli_real_escape_string($db, $_POST['ajax_body_type_comms']);
    $body_care_text = mysqli_real_escape_string($db, $_POST['ajax_body_care_text']);
    $body_care_past_text = mysqli_real_escape_string($db, $_POST['ajax_body_care_past_text']);
    $body_surgery_text = mysqli_real_escape_string($db, $_POST['ajax_body_surgery_text']);
    $body_middle = mysqli_real_escape_string($db, $_POST['ajax_body_middle']);
    $body_hip = mysqli_real_escape_string($db, $_POST['ajax_body_hip']);
    $body_right_thigh = mysqli_real_escape_string($db, $_POST['ajax_body_right_thigh']);
    $body_left_thigh = mysqli_real_escape_string($db, $_POST['ajax_body_left_thigh']);
    $body_right_knee = mysqli_real_escape_string($db, $_POST['ajax_body_right_knee']);
    $body_left_knee = mysqli_real_escape_string($db, $_POST['ajax_body_left_knee']);
    $body_right_ankle = mysqli_real_escape_string($db, $_POST['ajax_body_right_ankle']);
    $body_left_ankle = mysqli_real_escape_string($db, $_POST['ajax_body_left_ankle']);
    $body_middle_after = mysqli_real_escape_string($db, $_POST['ajax_body_middle_after']);
    $body_hip_after = mysqli_real_escape_string($db, $_POST['ajax_body_hip_after']);
    $body_right_thigh_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_thigh_after']);
    $body_left_thigh_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_thigh_after']);
    $body_right_knee_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_knee_after']);
    $body_left_knee_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_knee_after']);
    $body_right_ankle_after = mysqli_real_escape_string($db, $_POST['ajax_body_right_ankle_after']);
    $body_left_ankle_after = mysqli_real_escape_string($db, $_POST['ajax_body_left_ankle_after']);
    $body_date = mysqli_real_escape_string($db, $_POST['ajax_body_date']);
    $body_products = mysqli_real_escape_string($db, $_POST['ajax_body_products']);
    $body_comments = mysqli_real_escape_string($db, $_POST['ajax_body_comments']);
    $checkboxes_value = mysqli_real_escape_string($db, $_POST['ajax_checkboxes_value']);
    //$email_body = $_SESSION['email'];
    $current_afm = $_SESSION['afm'];
    $query_body_take_id = "SELECT * FROM personal_data WHERE afm=$current_afm";
    $result_check_body = mysqli_query($db,$query_body_take_id);
    if((mysqli_num_rows($result_check_body) == 1)){// Ελεγχει εαν υπαρχει μια γραμμη του query απο πανω και εαν true βρισκουμε το users_id της γραμμης.
        $final_result_body = mysqli_fetch_assoc($result_check_body);
        $customer_afm = json_encode($final_result_body['afm']);
        $customer_id = json_encode($final_result_body['id']);
        $query_checker_body = "SELECT * FROM customer_body WHERE afm=$current_afm";
        $result_check_body = mysqli_query($db, $query_checker_body);
        if((mysqli_num_rows($result_check_body)>=0)){
            mysqli_query($db, "UPDATE customer_body 
            SET appointment='$body_date',body_type_text='$body_type_text',body_type_comms='$body_type_comms',body_care_text='$body_care_text',body_care_past_text='$body_care_past_text',
            body_surgery_text='$body_surgery_text',body_middle='$body_middle',body_hip='$body_hip',body_right_thigh='$body_right_thigh',
            body_left_thigh='$body_left_thigh',body_right_knee='$body_right_knee',body_left_knee='$body_left_knee', body_right_ankle='$body_right_ankle', body_left_ankle='$body_left_ankle', 
            body_middle_after='$body_middle_after',body_hip_after='$body_hip_after', body_right_thigh_after='$body_right_thigh_after',
            body_left_thigh_after='$body_left_thigh_after', body_right_knee_after='$body_right_knee_after', body_left_knee_after='$body_left_knee_after', body_right_ankle_after='$body_right_ankle_after', 
            body_left_ankle_after ='$body_left_ankle_after', body_products='$body_products', body_comments='$body_comments', checkboxes_value='$checkboxes_value'
            WHERE afm=$current_afm and appointment='$body_date'");

            echo '{"response": "Update Body Data Completed"}';
            
        }else{
            //$query_update_breast ="UPDATE customer_breast SET breast_type='$breast_type',breast_date='$breast_date',
            //breast_products='$breast_products', breast_surgery='$surgery', breast_comments='$breast_comments' WHERE users_id=$customer_id";
            mysqli_query($db, "UPDATE customer_body 
            SET appointment='$body_date',body_type_text='$body_type_text',body_type_comms='$body_type_comms',body_care_text='$body_care_text',body_care_past_text='$body_care_past_text',
            body_surgery_text='$body_surgery_text',body_middle='$body_middle',body_hip='$body_hip',body_right_thigh='$body_right_thigh',
            body_left_thigh='$body_left_thigh',body_right_knee='$body_right_knee',body_left_knee='$body_left_knee', body_right_ankle='$body_right_ankle', body_left_ankle='$body_left_ankle', 
            body_middle_after='$body_middle_after',body_hip_after='$body_hip_after', body_right_thigh_after='$body_right_thigh_after',
            body_left_thigh_after='$body_left_thigh_after', body_right_knee_after='$body_right_knee_after', body_left_knee_after='$body_left_knee_after', body_right_ankle_after='$body_right_ankle_after', 
            body_left_ankle_after ='$body_left_ankle_after', body_products='$body_products', body_comments='$body_comments', checkboxes_value='$checkboxes_value'
            WHERE afm=$current_afm and appointment='$body_date'");

        echo '{"response": "No available data for body"}'.mysqli_error($db);
        }
    }
}elseif(isset($_POST['checker_insert_face2'])==5.4){
    //date_default_timezone_set('Europe/Athens');
    //$current_date = date('Y-m-d');
    $face_type = mysqli_real_escape_string($db, $_POST['ajax_type_of_face']);
    $face_date = mysqli_real_escape_string($db, $_POST['ajax_date_face']);
    $new_face_date = mysqli_real_escape_string($db, $_POST['ajax_new_date_face']);
    $face_products = mysqli_real_escape_string($db, $_POST['ajax_products_face']);
    $face_text = mysqli_real_escape_string($db, $_POST['ajax_face_text']);
    $checker = mysqli_real_escape_string($db, $_POST['ajax_checker']);
    $email_face = $_SESSION['email'];
    //$customer_id = $_SESSION['id'];
    $query_face_take_id = "SELECT * FROM personal_data WHERE email=$email_face";
    $result_check_face = mysqli_query($db,$query_face_take_id);
    if((mysqli_num_rows($result_check_face) == 1)){
        $final_result_face = mysqli_fetch_assoc($result_check_face);
        $customer_id = json_encode($final_result_face['id']);
        if($checker=='0'){
            $query_checker_face = "SELECT id,face_date FROM customer_face WHERE users_id=$customer_id and customer_email=$email_face and face_date>='$current_date'";
        }elseif($checker=='1'){
            $query_checker_face = "SELECT id,face_date FROM customer_face WHERE users_id=$customer_id and customer_email=$email_face and face_date='$face_date'";
            $query_check = mysqli_query($db,"SELECT id,face_date FROM customer_face WHERE users_id=$customer_id and customer_email=$email_face and face_date='$new_face_date'");
            if((mysqli_num_rows($query_check) == 1)){
                $date_take = TRUE;
            }else{
                $date_take = FALSE;
            }
        }
        $face_query = mysqli_query($db,$query_checker_face);
        echo mysqli_error($db);
        $result_query = mysqli_fetch_all($face_query);
        $date_available = TRUE;
        for($i=0; $i<count($result_query);$i++){
            //echo $result_query[$i][0];
            //echo $breast_date."HAHA".$result_query[$i][1];
            //var_dump($result_query[$i][1]==$breast_date);
            $current_id = json_encode($result_query[$i][0]);
            //echo $current_id;
            if($face_date==$result_query[$i][1]){
                $date_available = FALSE;
            }
        }
        if($checker == '0'){ // 0 = INSERT
            if($date_available == TRUE){
                $query_insert_face =  "INSERT INTO customer_face (users_id,customer_email, face_type, face_date, face_products, face_text) 
                VALUES ($customer_id,$email_face,'$face_type','$face_date', '$face_products','$face_text')";
                if(mysqli_query($db, $query_insert_face)!= FALSE){
                    echo '{"response": "Insert Complete","message": "Insert Complete"}'.mysqli_error($db);
                }else{
                    echo '{"response": "You havent picked a date","message": "Insert Not Complete"}'.mysqli_error($db);
                }
            }elseif($date_available==FALSE){
                echo '{"response": "You have a Appointment","message": "Insert Not Complete"}'.mysqli_error($db);
            }
        }elseif($checker=='1'){ // 1 = UPDATE
            if((mysqli_num_rows($face_query) >= 1)AND  $date_take == FALSE){
                $query_update_face = 
                "UPDATE customer_face 
                SET users_id=$customer_id,customer_email=$email_face,face_type='$face_type',
                face_date='$new_face_date', face_products='$face_products',face_text='$face_text'
                WHERE users_id=$customer_id AND face_date='$face_date'";
            if(mysqli_query($db, $query_update_face)!= FALSE){
                echo '{"response": "Update Complete","message": "Update Complete"}'.mysqli_error($db);
            }else{
                echo '{"response": "Update didnt happened","message": "Update didnt got Completed"}'.mysqli_error($db);
            }
            }else{
                echo '{"response": "Wrong Date","message": "Insert Not Complete"}'.mysqli_error($db);
            }
            
        }
    }else{
        echo '{"response": "No Data For Breast","message": "No Data For Breast"}';
    }
}elseif(isset($_POST['checker_update_breast'])==6.3){
    date_default_timezone_set('Europe/Athens');
    $current_date = date('Y-m-d');
    $breast_type = mysqli_real_escape_string($db, $_POST['ajax_breast_type']);
    $breast_date = mysqli_real_escape_string($db, $_POST['ajax_date_breast']); 
    $new_breast_date = mysqli_real_escape_string($db, $_POST['ajax_date_breast_2']);
    $breast_products = mysqli_real_escape_string($db, $_POST['ajax_products_breast']);
    $breast_comments = mysqli_real_escape_string($db, $_POST['ajax_breast_comments']);
    $surgery = mysqli_real_escape_string($db, $_POST['ajax_surgery']);
    $checker = mysqli_real_escape_string($db, $_POST['ajax_checker']);// 0=INSERT 1=UPDATE
    $email_breast = $_SESSION['email'];
    $query_take_id = "SELECT * FROM personal_data WHERE email=".$_SESSION['email']."";
    $result_check_breast = mysqli_query($db,$query_take_id);
    //echo gettype($checker)."hhhhh";
    //echo json_encode($result_check_habits);
    if((mysqli_num_rows($result_check_breast) >= 1)){
        $final_result = mysqli_fetch_assoc($result_check_breast);
        $customer_id = json_encode($final_result['id']);
        if($checker=='0'){
            $query_checker_breast = "SELECT id,breast_date FROM customer_breast WHERE users_id=$customer_id and customer_email=$email_breast and breast_date>='$current_date'";
        }elseif($checker=='1'){
            $query_checker_breast = "SELECT id,breast_date FROM customer_breast WHERE users_id=$customer_id and customer_email=$email_breast and breast_date='$breast_date'";
            $check_query = mysqli_query($db,"SELECT id,breast_date FROM customer_breast WHERE users_id=$customer_id and customer_email=$email_breast and breast_date='$new_breast_date'");
            if((mysqli_num_rows( $check_query) == 1)){
                $date_take = TRUE;
                //echo "first";
            }else{
                $date_take = FALSE;
                //echo "second";
            }
        }
        $breast_query = mysqli_query($db,$query_checker_breast);
        echo mysqli_error($db);
        $result_query = mysqli_fetch_all($breast_query);
        $for_update=json_encode($result_query);
        //echo $for_update;
        $date_available = TRUE;
        //echo $date_available;
        for($i=0; $i<count($result_query);$i++){
            //echo $result_query[$i][0];
            //echo $breast_date."HAHA".$result_query[$i][1];
            //var_dump($result_query[$i][1]==$breast_date);
            $current_id = json_encode($result_query[$i][0]);
            if($breast_date==$result_query[$i][1]){
                $date_available = FALSE;
            }
        }
        if($checker == '0'){ // 0 = INSERT
            if($date_available==TRUE AND $breast_date!=""){
                $query_insert_breast =  "INSERT INTO customer_breast (users_id,customer_email, breast_type, breast_date, breast_products, breast_surgery, breast_comments) 
                VALUES ($customer_id,$email_breast,'$breast_type','$breast_date', '$breast_products', '$surgery','$breast_comments')";
                if(mysqli_query($db, $query_insert_breast)!= FALSE){
                    echo '{"response": "Insert Complete","message": "Insert Complete"}'.mysqli_error($db);
                }else{
                    echo '{"response": "You havent picked a date","message": "Insert Not Complete"}'.mysqli_error($db);
                }
            }elseif($date_available==FALSE){
                echo '{"response": "You have a Appointment","message": "Insert Not Complete"}'.mysqli_error($db);
            }
        }elseif($checker=='1'){ // 1 = UPDATE
            if((mysqli_num_rows($breast_query) >= 1) AND $date_take == FALSE){
                //echo "hi";
                $query_update_breast = 
                "UPDATE customer_breast 
                SET users_id=$customer_id,customer_email=$email_breast,breast_type='$breast_type',
                breast_date='$new_breast_date', breast_products='$breast_products',breast_surgery='$surgery',breast_comments='$breast_comments'
                WHERE users_id=$customer_id AND breast_date='$breast_date'";
                if(mysqli_query($db, $query_update_breast)!= FALSE){
                    echo '{"response": "Update Complete","message": "Update Complete"}'.mysqli_error($db);
                }else{
                    echo "UPDATE DIDNT HAPPENED".mysqli_error($db);
                }
            }elseif($date_take == TRUE){
                echo '{"response": "You have an appointment the old day","message": "Insert Not Complete"}'.mysqli_error($db);
            }else{
                echo '{"response": "Wrong Date","message": "Insert Not Complete"}'.mysqli_error($db);
            }
                
            
        }
    }else{
        echo '{"response": "No Data For Breast","message": "No Data For Breast"}';
    }
}elseif(isset($_POST['checker_update_body'])==7.3){
    date_default_timezone_set('Europe/Athens');
    $current_date = date('Y-m-d');
    $body_type = mysqli_real_escape_string($db, $_POST['ajax_natural_type']);
    $body_date = mysqli_real_escape_string($db, $_POST['ajax_body_date']);
    $new_body_date = mysqli_real_escape_string($db, $_POST['ajax_body_date_2']);
    $body_products = mysqli_real_escape_string($db, $_POST['ajax_body_products']);
    $body_text = mysqli_real_escape_string($db, $_POST['ajax_body_comments']);
    $checkbox= mysqli_real_escape_string($db, $_POST['ajax_checkboxes_value']);
    $checker = mysqli_real_escape_string($db, $_POST['ajax_checker']);// 0=INSERT 1=UPDATE
    $email_body = $_SESSION['email'];
    $query_take_id = "SELECT * FROM personal_data WHERE email=".$_SESSION['email']."";
    $result_check_body = mysqli_query($db,$query_take_id);
    //echo json_encode($result_check_habits);
    //echo "im out";
    if((mysqli_num_rows($result_check_body) >= 1)){
        $final_result = mysqli_fetch_assoc($result_check_body);
        $customer_id = json_encode($final_result['id']);
        if($checker==0){// INSERT
            $query_checker_body = "SELECT id,body_date FROM customer_body WHERE users_id=$customer_id and customer_email=$email_body and body_date>='$current_date'";
        }elseif($checker==1){// UPDATE
            $query_checker_body = "SELECT id,body_date FROM customer_body WHERE users_id=$customer_id and customer_email=$email_body and body_date='$body_date'";
            $query_check = mysqli_query($db,"SELECT id,body_date FROM customer_body WHERE users_id=$customer_id and customer_email=$email_body and body_date='$new_body_date'");
            if((mysqli_num_rows($query_check) == 1)){
                $date_take = TRUE;
            }else{
                $date_take = FALSE;
            }
        }
        $body_query = mysqli_query($db,$query_checker_body);
        echo mysqli_error($db);
        $result_query = mysqli_fetch_all($body_query);
        $date_available = TRUE;
        for($i=0; $i<count($result_query);$i++){
            //echo $result_query[$i][0];
            //echo $breast_date."HAHA".$result_query[$i][1];
            //var_dump($result_query[$i][1]==$breast_date);
            $current_id = json_encode($result_query[$i][0]);
            //echo $current_id;
            if($body_date==$result_query[$i][1]){
                $date_available = FALSE;
            }
        }
        //echo $date_available;
        if($checker == '0'){ // 0 = INSERT
            if($date_available==TRUE AND $body_date!=""){
                $query_insert_body =  "INSERT INTO customer_body (users_id,customer_email, body_type, body_part, body_date, body_products, body_text) 
                VALUES ($customer_id,$email_body,'$body_type','$checkbox', '$body_date', '$body_products','$body_text')";
                if(mysqli_query($db, $query_insert_body)!= FALSE){
                    echo '{"response": "Insert Complete","message": "Insert Complete"}'.mysqli_error($db);
                }else{
                    echo 'INSERT DIDNT HAPPENED'.mysqli_error($db);
                }
            }elseif($date_available==FALSE){
                echo '{"response": "You have a Appointment","message": "Insert Not Complete"}'.mysqli_error($db);
            }else{
                echo '{"response": "You havent picked a date","message": "Insert Not Complete"}'.mysqli_error($db);
            }
        }elseif($checker=='1'){ // 1 = UPDATE
            if((mysqli_num_rows($body_query) >= 1) AND $date_take == FALSE){
                $query_update_body = 
                "UPDATE customer_body
                SET users_id=$customer_id,customer_email=$email_body,body_type='$body_type',
                body_date='$new_body_date', body_products='$body_products',body_part='$checkbox',body_text='$body_text'
                WHERE users_id=$customer_id AND body_date=' $body_date'";
                if(mysqli_query($db, $query_update_body)!= FALSE){
                    echo '{"response": "Update Complete","message": "Update Complete"}'.mysqli_error($db);
                }else{
                    echo "UPDATE DIDNT HAPPENED".mysqli_error($db);
                }
            }else{
                echo '{"response": "Wrong Date","message": "Insert Not Complete"}'.mysqli_error($db);
            }
        }
    }else{
        echo '{"response": "You couldnt find customer","message": "No Data For Body"}';
    }

}elseif(isset($_POST['checker_datetime_appntm'])==8){
    $customer_rendezvous_exists = TRUE;
    $appt_exists=TRUE;
    $time_for_appnmt = mysqli_real_escape_string($db, $_POST['ajax_time_for_appnmt']);
    $date_appntm = mysqli_real_escape_string($db, $_POST['ajax_date_appntm']);
    $email_appt = $_SESSION['email'];
    $query_appt_take_id = "SELECT * FROM personal_data WHERE email=$email_appt";
    $result_check_appt = mysqli_query($db,$query_appt_take_id);
    $final_result_appt = mysqli_fetch_assoc($result_check_appt);
    $customer_id = json_encode($final_result_appt['id']);

    $today_date = date("m.d.y");
    $everything_appt = "SELECT appo_time_slot,customer_email FROM appointments WHERE appo_date='$date_appntm'";
    $query_for_dates = mysqli_query($db, $everything_appt);
    $result_appt =  mysqli_fetch_all($query_for_dates);
    //
    $final_result_appt = json_encode($result_appt);
    //echo json_encode($result_appt)."---";
    //echo $result_appt[1][0];
    $email_appt = str_replace('"','',$_SESSION['email']);
    for($i=0; $i<count($result_appt);$i++){
        //echo $final_result_appt."--";
        if($result_appt[$i][0]===$time_for_appnmt){
            $appt_exists=FALSE;//GINETAI FALSE OTAN YPARXEI RANTEVOU EKEINH THN WRA ANEKSARTITA APO PELATH
            //echo "--";
        }
        
        //echo 'SQL='.strval($result_appt[$i][1]);
        //echo 'SESSION='.strval($email_appt);
        //var_dump($result_appt[$i][1]==$email_appt);
        if($result_appt[$i][1]==$email_appt){
            $customer_rendezvous_exists = FALSE; // GIA THN ALLAGI WRAS
            //echo "im in";
        }
    }
    //echo '$appt_exists'.$appt_exists.'----';
    //echo 'customer_rendezvous_exists'.$customer_rendezvous_exists.'-';
    if((mysqli_num_rows($query_for_dates)==0)OR($appt_exists==TRUE)){//ΟΤΑΝ Η ΜΕΡΑ ΕΙΝΑΙ ΚΕΝΗ
        if($customer_rendezvous_exists == FALSE){ //GIA THN ALLAGI WRAS STO RANTEVOY TOY PELATH
            $query_update_appt = "UPDATE appointments SET appo_time_slot='$time_for_appnmt' WHERE appo_date='$date_appntm' AND customer_email='$email_appt'";
            echo "hii";
            if(mysqli_query($db, $query_update_appt)!= FALSE){
                echo '{"response": "Update Successfull","message": "Update Successfull"}'.mysqli_error($db);
            }
            echo mysqli_error($db);
        }else{
            $query_insert_appt = "INSERT INTO appointments (appo_date, appo_time_slot, customer_email, users_id) 
            VALUES ('$date_appntm','$time_for_appnmt',$email_appt,$customer_id)";
                if(mysqli_query($db, $query_insert_appt)!= FALSE){
                echo '{"response": "Search Successfull","message": "Search Successfull"}'.mysqli_error($db);
            }
        }
        //$query_insert_appt = "INSERT INTO appointments (appo_date, appo_time_slot, customer_email, users_id) 
            //VALUES ('$date_appntm','$time_for_appnmt',$email_appt,$customer_id)";
                //if(mysqli_query($db, $query_insert_appt)!= FALSE){
                //echo '{"response": "Search Successfull","message": "Search Successfull"}'.mysqli_error($db);
        //}
    }elseif((mysqli_num_rows($query_for_dates)>=1)){
        echo '{"response": "Search Unsuccessfull","message": "Search Unsuccessfull"}'.mysqli_error($db);
          
    }else{
        echo "nothing".mysqli_error($db);
    }
    
    //echo json_encode(mysqli_fetch_assoc($result_check_appt));
    /*
        if((mysqli_num_rows($result_check_appt)==1)){ // YPARXEI XRHSTHS ME EMAIL KAI ID
        $final_result_appt = mysqli_fetch_assoc($result_check_appt);
        $customer_id = json_encode($final_result_appt['id']);
        /*$result_appt = mysqli_fetch_assoc($query_for_dates);
        //$appt_date = json_encode($result_appt['appo_date']);
        $appt_time =  json_encode($result_appt['appo_time_slot']);
        if((mysqli_num_rows($response_query)==0)){ // ΕΛΕΓΧΟΣ ΓΙΑ ΤΗΝ ΥΠΑΡΞΗ ΚΡΑΤΗΣΗΣ
            $result_query = mysqli_fetch_assoc($response_query);
            foreach($result_appt as $result){
                //echo $result;
                if($time_for_appnmt==$result){
                    $rendezvous = FALSE;
                }
            }
            if($rendezvous == TRUE){
                $query_insert_appt = "INSERT INTO appointments (appo_date, appo_time_slot, customer_email, users_id) 
                VALUES ('$date_appntm','$time_for_appnmt',$email_appt,$customer_id)";
                if(mysqli_query($db, $query_insert_appt)!= FALSE){
                        echo '{"response": "Search Successfull","message": "Search Successfull"}'.mysqli_error($db);
                }
            }else{
                echo '{"response": "Search Unsuccessfull","message": "Search Unsuccessfull"}'.mysqli_error($db);
            }
            
        }elseif((mysqli_num_rows($response_query)>=1)){// ΥΠΑΡΧΕΙ ΓΕΝΙΚΑ ΚΡΑΤΗΣΗ
            foreach($result_appt as $result){
                echo $result."yeah";
            }
            //echo $appt_date.'-----'.$appt_time;
            //echo '{"response": "Appointment Exists","message": "Unsuccessfull"}'.mysqli_error($db);
        }
        }else{
        echo "gamietai".mysqli_error($db);
        }*/
}
//-------------------------Insert Data into DB---------------------------
 /*
 JOIN customer_health ON personal_data.id=customer_health.users_id 
            SET personal_data.firstname='$firstname',personal_data.lastname='$lastname',personal_data.email='$email', 
            personal_data.phone='$phone', personal_data.date_of_birth='$birth', personal_data.Comments='$comments',customer_health.customer_email='$email'
            WHERE personal_data.id=$customer_id AND customer_health.users_id=$customer_id;

            $habits_update =mysqli_query($db,"UPDATE customer_habits
            JOIN personal_data ON customer_habits.users_id=personal_data.id
            SET customer_habits.customer_email ='$email'
            WHERE personal_data.id=$customer_id AND customer_habits.users_id=$customer_id;");

            $face_update =mysqli_query($db,"UPDATE customer_face
            JOIN personal_data ON personal_data.id=customer_face.users_id
            SET customer_face.customer_email ='$email'
            WHERE personal_data.id=$customer_id AND customer_face.users_id=$customer_id;");

            $breast_update =mysqli_query($db,"UPDATE customer_breast
            JOIN personal_data ON personal_data.id=customer_breast.users_id
            SET customer_breast.customer_email ='$email'
            WHERE personal_data.id=$customer_id AND customer_breast.users_id=$customer_id;");

            $body_update =mysqli_query($db,"UPDATE customer_body
            JOIN personal_data ON personal_data.id=customer_body.users_id
            SET customer_body.customer_email ='$email'
            WHERE personal_data.id=$customer_id AND customer_body.users_id=$customer_id;");
 
 
 $string_for_data = array("habits","body","breast","face");
            $final_result = mysqli_fetch_assoc($result_check);
            $response_data = $final_result;
            foreach($string_for_data as $value_in_func){
                $response_func = checkQuery($value_in_func,$email,$db);
                if($value_in_func=="habits"){
                    $response_habits = checkQuery($value_in_func,$email,$db);
                }elseif($value_in_func=="body"){
                    $response_body = checkQuery($value_in_func,$email,$db);
                }elseif($value_in_func=="breast"){
                    $response_breast = checkQuery($value_in_func,$email,$db);
                }elseif($value_in_func=="face"){
                    $response_face = checkQuery($value_in_func,$email,$db);
                }
            }
            //echo "---------".print_r($response_body)."eeeeeeeeeee";
            $_SESSION['firstname'] =  json_encode($response_data['firstname']);
            $_SESSION['lastname'] =  json_encode($response_data['lastname']);
            $_SESSION['phone'] =  json_encode($response_data['phone']);
            $_SESSION['email'] =  json_encode($response_data['email']);
            //echo gettype(json_encode($response_breast));
            $final_response = '{"data_personal": '.json_encode($response_data).',
                 "data_habits": '.json_encode($response_habits).',
                 "data_body": '.json_encode($response_body).',
                 "data_breast": '.json_encode($response_breast).',
                 "data_face": '.json_encode($response_face).',
                 "session": '.$_SESSION['email'].',
                 "message": "Customer found"}';
            echo $final_response;*/
?>