//----------------------------------------------------Search Script----------------------------------------------------
function builds_Table(my_data,mypersonaldata) {
  let tbl = document.createElement("table");
  let tblBody = document.createElement("tbody");
  // creating all trs
  for (let i = 0; i < 2; i++) {
    // creates a table row
    let row = document.createElement("tr");
    // creates a table head
    //let head = document.createElement("th");
    let data_values = Object.values(my_data); //values(data.data_personal)
    let data_keys = Object.keys(my_data); // keys(data.data_personal)
    console.log(my_data)
    
    for (let j = 0; j < mypersonaldata.length; j++) {
      // Create a <td> element and a text node, make the text
      // node the contents of the <td>, and put the <td> at
      // the end of the table row
      if (i == 0) {
        let th = document.createElement("th");
        let cellText = document.createTextNode(mypersonaldata[j]);
        th.appendChild(cellText);
        th.setAttribute("style","width:10%;text-align:center");
        row.appendChild(th);
      } 
    }
    if(i == 1){
      //console.log(data_values[1].length)
      for (let t = 0; t < data_keys.length; t++) {
        let row_new = tbl.insertRow(0);
        for (let k = 0; k < data_values[t].length; k++) {
          //console.log(data_values[t][j])
          if(k==0){

          }else if(k==1) {
            
            let td = document.createElement("td");
            let cellText = document.createTextNode(t+1);
            td.appendChild(cellText);
            td.setAttribute("style","width:10%;text-align:center");
            row_new.appendChild(td);
          }else{
            let td = document.createElement("td");
            let cellText = document.createTextNode(data_values[t][k]);
            td.appendChild(cellText);
            td.setAttribute("style","width:10%;text-align:center");
            row_new.appendChild(td);
          }
        }
        //row_new.deleteCell(1);
        tblBody.appendChild(row_new);
      }
    }
    //row.deleteCell(-1);
    // add the row to the end of the table body
    tblBody.appendChild(row);
    //console.log(data_values[0].length)
  }
  // put the <tbody> in the <table>
  
  tbl.appendChild(tblBody);
  br= document.createElement("br");
  tbl.appendChild(br);
  tbl.setAttribute("style", "display:none;width:70%");
  // appends <table> into <body>
  //document.body.appendChild(tbl);
  // sets the border attribute of tbl to '2'
  //tbl.setAttribute("border", "10");
  //tbl.setAttribute("name", "table_data");
  //tbl.setAttribute("id", id_for_table); 

  //tbl.setAttribute("id", "main_table");
  return tbl;
}
//-----------------------------------------------------FIRST PAGE------------------------------------------------
$(document).ready(function () {
  // Button For Back In First Page
  /*let button = document.createElement("button");
  button.innerText = 'Back To Search';
  document.body.appendChild(button);
  button.setAttribute("id", "back_table");
  document.getElementById("back_table").style.display = "none";
  button.setAttribute("type", "button");
  // Button For New Appointment
  let button_appntm = document.createElement("button");
  button_appntm.innerText = 'New Appointment';
  document.body.appendChild(button_appntm);
  button_appntm.setAttribute("id", "new_appntm");
  document.getElementById("new_appntm").style.display = "none";
  button_appntm.setAttribute("type", "button");*/

  $("#submit_temp").on('click', function () {  //-----------------------------SUBMIT TEMPORARY-------------------------------
    let fname = $("#fname_temp").val();
    let lname = $("#lname_temp").val();
    let phone = $("#phone_temp").val();
    let appntm_date = $("#appt_temp").val();
    let appntm_time = $("#appt_time").val();
    console.log(appntm_time);
    //let letter = /^[A-Za-z]+$/;
    if (phone == "" ){
      alert('Κενές Τιμές Στοιχείων.')
    }else if(appntm_date==""){
      alert('Κενή Τιμή Ημερομηνίας.')
    }else if(appntm_time==""){
      alert('Κενή Τιμή Ώρας.')
    }else{
      console.log('Όνομα-Επίθετο Ισχύουν')
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          ajax_fname: fname,
          ajax_lname: lname,
          ajax_phone: phone,
          ajax_appntm_date: appntm_date,
          ajax_appntm_time: appntm_time,
          temporary_appntm: 1
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data)
          if (data.response=="Insert Completed") {
            alert("Έγινε η προσωρινή εγγραφή πελάτη.");
            //window.location.href = "New_First_Page.php";
            window.location.reload();
            /*
            // creates a <table> element and a <tbody> element
            const final_table = document.createElement("table1");
            //uuid = self.crypto.randomUUID();
            personal_data = builds_Table(data.data_personal)
            customer_habits = builds_Table(data.data_habits)
            //br= document.createElement("br");

            const para = document.createElement("p");
            para.innerText = "Personal Data";
            final_table.appendChild(para);
            final_table.appendChild(personal_data);
            //final_table.appendChild(br);

            const para1 = document.createElement("p");
            para1.innerText = "Customer Habits";
            final_table.appendChild(para1);
            final_table.appendChild(customer_habits);
            //final_table.appendChild(br);

            if(data.data_body!= null){
              const para_body = document.createElement("p");
              para_body.innerText = "Customer Body";
              final_table.appendChild(para_body);
              //console.log(Object.keys(data.data_body).length)
              for (let i = 0; i < Object.keys(data.data_body).length; i++) { 
                customer_body = builds_Table(data.data_body[i])
                console.log(data.data_body[i])
                final_table.appendChild(customer_body);
              }
              
              //final_table.appendChild(br);
            }
            if(data.data_breast!= null){
              const para_breast = document.createElement("p");
              para_breast.innerText = "Customer Breast";
              final_table.appendChild(para_breast);
              for (let i = 0; i < Object.keys(data.data_breast).length; i++) { 
                customer_breast = builds_Table(data.data_breast[i])
                console.log(data.data_breast[i])
                final_table.appendChild(customer_breast);
              }
              //final_table.appendChild(br);
            }
            if(data.data_face!= null){
              const para_face = document.createElement("p");
              para_face.innerText = "Customer Face";
              final_table.appendChild(para_face);
              for (let i = 0; i < Object.keys(data.data_face).length; i++) { 
                customer_face = builds_Table(data.data_face[i])
                console.log(data.data_face[i])
                final_table.appendChild(customer_face);
              }
              //customer_face = builds_Table(data.data_face)
              //final_table.appendChild(customer_face);
              //final_table.appendChild(br);
            }

            document.body.appendChild(final_table);
            final_table.setAttribute("border", "10");
            final_table.setAttribute("name", "table_data");
            final_table.setAttribute("id", "table"); */
          }else if (data.response == "Something Went Wrong in DB") {
            alert("Κάτι Πήγε Λάθος.");

          }else if (data.response == "Client Doesnt Exist.Make Insert") {
            alert('O πελάτης δεν υπάρχει. Nα γίνει εγγραφή');

          }else if (data.response == "Customer Exists") {
            alert("Βρέθηκε Υπάρχων Πελάτης.");
            window.location.href = "New_Second_Page.php";

          }else if (data.response == "Client Temporary Exists.Make Insert") {
            alert("Βρέθηκε Πελάτης. Δεν Έχει Γίνει Εγγραφή.");
          
          }else if (data.response == "Customer not found") {
            alert("O πελάτης υπάρχει ήδη.");

          }else if (data.response == "Appointment Time is Covered") {
            alert("Η Ώρα είναι Καλυμένη.");
          }
          
        },
      })
    }
  })
  $("#submit_formal").on('click', function () {//-----------------------------SUBMIT FORMAL-------------------------------
    let fname = $("#fname_temp").val();
    let lname = $("#lname_temp").val();
    let phone = $("#phone_temp").val();
    let appntm_date = $("#appt_temp").val();
    console.log(appntm_date);
    //let appntm_time = $("#appt_time").val();
    let name_beautician = $("#name_beautician").val();
    let email = $("#email_formal").val();
    let birth = $("#dof2").val();
    let afm = $("#afm_formal").val();
    let comments = document.getElementById("Textarea_formal").value;
    let chbox = new Array();
    $("input[name='part']:checked").each(function () {
      //alert("Im in");
      if ($("#chest").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#face").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#body").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#all").is(":checked")) {
        chbox.push($(this).val());
      } else {
        alert('Checkbox not checked!');
      }
    });
    console.log(chbox) 
    //let letter = /^[A-Za-z]+$/;
    if ((fname == "" || lname == "") || email == "") {
      alert("Empty Values in Firstname Lastname or Email");
    } else if(chbox == "") {
      alert("You havent checked the body part");
    }else{
      console.log('accepted first and lastname')
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          formal_sign_in:2,
          ajax_fname: fname,
          ajax_lname: lname,
          ajax_phone: phone,
          ajax_appntm_date: appntm_date,
          //ajax_appntm_time: appntm_time,
          ajax_name_beautician:name_beautician,
          ajax_email:email,
          ajax_birth:birth,
          ajax_afm:afm,
          ajax_comments:comments,
          ajax_checkboxes_value:chbox.toString()
        },
        success: function (response) {
          data = JSON.parse(response)
          if (data.response == "User Exists") {
            alert("Ο χρήστης υπάρχει ήδη")

          } else if (data.response == "Registration Complete"){
            alert("Η εγγραφή του πελάτη πραγματοποιήθηκε.")
            body_part = data.body_part
            console.log(body_part)
            window.location.href = "New_Second_Page.php"

          } else if (data.response == "Duplicate Entry"){
            alert("Υπάρχων Χρήστης στο Σύστημα.")
            //Διαγράφηκαν και οι δύο. Πατήστε ξανά το κουμπί της εγγραφής.

          } else if (data.response == "Wrong Type of Email"){
            alert("Λάθος τύπος Email")

          }else if (data.response == "Problem With Query in DB"){
            alert("Σφάλμα.Πιθανόν να υπάρχουν παραπανω απο δυο ίδιοι πελάτες")
          }
        },
      })
    }

  })
  $("#go_to_reg").click(function () {
    $("#form_formal").toggle();
  });
  $("#new_appntm").click(function () {
    $("#form_for_appntm_third_page").show();
  });
  $("#third_page_button").click(function () {
    let afm = $("#afm").val();
    let phone = $("#phone").val();
    $.ajax({
      url: 'server_spa.php',
      method: 'POST',
      data: {
        ajax_afm: afm,
        ajax_phone: phone,
        checker_session_update_data:1.2 
      },
      success: function (response) {
        data = JSON.parse(response)
        console.log(data)
        if(data.response=="Client Exist.Go to Page"){
          alert("Υπάρχων Πελάτης.Πήγαινε Στην Επόμενη Σελίδα");
          window.location.href = "New_Third_Page.php";
          
        }else if(data.response=="Client Doesnt Exist.Dont Go to Page"){
          alert("Μη υπάρχων Πελάτης.Μη Πας Στην Επόμενη Σελίδα");
        }
      }
    })
  });
  $("#update_page_button").click(function () {
    let afm = $("#afm").val();
    let phone = $("#phone").val();
    $.ajax({
      url: 'server_spa.php',
      method: 'POST',
      data: {
        ajax_afm: afm,
        ajax_phone: phone,
        checker_session_update_data:1.2 
      },
      success: function (response) {
        data = JSON.parse(response)
        console.log(data)
        if(data.response=="Client Exist.Go to Page"){
          alert("Υπάρχων Πελάτης.Πήγαινε Στην Επόμενη Σελίδα");
          window.location.href = "New_Update_Page.php";
          
        }else if(data.response=="Client Doesnt Exist.Dont Go to Page"){
          alert("Μη υπάρχων Πελάτης.Μη Πας Στην Επόμενη Σελίδα");
        }
      }
    })
    
  });
  $("#back_table").click(function () {
    $("#table").remove();
    $("#form1").show();
    $("#back_table").hide();
    $("#new_appntm").hide();
  });
})
//---------------------------------------------------------------------------------------------SECOND PAGE BUTTON-------------------------------------
$(document).ready(function () {
  $("#back_to_first").click(function () {
    window.location.href = "New_First_Page.php";
  }); 
  $("#submit_health").on('click', function () {//--------------------------------------------------CUSTOMER HEALTH-------------------------------
    let height = $("#height").val();
    let weight = $("#weight").val();
    let health = $("#health").val();
    let health_text = document.getElementById("Textarea_health").value;
    let sleep = $("#sleep").val();
    let sleep_text = document.getElementById("Textarea_sleep").value;
    let appetite = $("#appetite").val();
    let appetite_text = document.getElementById("Textarea_appetite").value;
    let diseases_text = document.getElementById("Textarea_diseases").value;
    let meds_text = document.getElementById("Textarea_meds").value;
    let surgery_text = document.getElementById("Textarea_surgery").value;
    if ((height == "" || weight == "")) {
      alert("Κενές Τιμές στο Βάρος και στο Ύψος");
    } else {
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_client_health: 3,
          ajax_height: height,
          ajax_weight: weight,
          ajax_health: health,
          ajax_health_text: health_text,
          ajax_sleep: sleep,
          ajax_sleep_text: sleep_text,
          ajax_appetite: appetite,
          ajax_appetite_text: appetite_text,
          ajax_diseases_text: diseases_text,
          ajax_meds_text: meds_text,
          ajax_surgery_text: surgery_text
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert of Customer Health Completed") {
            alert("Επιτυχημένη Εγγραφή Στοιχείων")

          }else if(data.response=="Data Updated"){
            alert("Τα στοιχεία ανανεώθηκαν επιτυχώς.");

          }else if(data.response=="More than one user with the same health issues"){
            alert("Υπάρχουν παραπάνω από ένας πίνακας με αυτά τα στοιχεία.");

          }else if (data.response == "Problem Occuried. Problem With Customer Email.") {
            alert("Προέκυψε Πρόβλημα με το E-mail του Χρήστη.Επαναλάβατε την εγγραφή");
            window.location.href = "New_First_Page.php"
          }
        },
      })
    }
  })
  $("#next_health").click(function () {
    $("#form_health").hide();
    $("#form_habits").show();
  });
  $("#back_body").click(function () {
    $("#form_habits").show();
    $("#body").hide();
  });
  $("#back_health_body").click(function () {
    $("#body").show();
    $("#form_health").hide();
  });
  $("#submit_habits").on('click', function () {//--------------------------------------------------CUSTOMER HABITS-------------------------------
    let dairy = document.getElementById("dairy");
    let dairy_text= dairy.options[dairy.selectedIndex].text;
    let smoke = document.getElementById("smoke");
    let smoke_text= smoke.options[smoke.selectedIndex].text;
    let drink = document.getElementById("drink");
    let drink_text= drink.options[drink.selectedIndex].text;
    let exercise = document.getElementById("exercise");
    let exercise_text= exercise.options[exercise.selectedIndex].text;
    let salt = document.getElementById("salt");
    let salt_text= salt.options[salt.selectedIndex].text;
    let water = document.getElementById("water");
    let water_text= water.options[water.selectedIndex].text;
    let sugar = document.getElementById("sugar");
    let sugar_text= sugar.options[sugar.selectedIndex].text;
    let digestive_tract_text = document.getElementById("Textarea_digestive_tract").value;
    let pregnacy = document.getElementById("pregnacy");
    let pregnacy_text= pregnacy.options[pregnacy.selectedIndex].text;
    let pregnacy_month = $("#pregnacy_month").val();
    let dermatosis_text = document.getElementById("Textarea_dermatosis").value;
    let children_text = $("#children").val();
    let age_text = $("#age").val();
    let breast_feeding = document.getElementById("breast_feeding");
    let breast_feeding_text= breast_feeding.options[breast_feeding.selectedIndex].text;
    let menstruation = document.getElementById("menstruation");
    let menstruation_text= menstruation.options[menstruation.selectedIndex].text;
    let menstruation_time_text = document.getElementById("Textarea_menstruation_time").value;
    let menstruation_frequency_text = document.getElementById("Textarea_menstruation_frequency").value;
    let menopause = document.getElementById("menopause");
    let menopause_text= menopause.options[menopause.selectedIndex].text;
    let sex_life = document.getElementById("sex_life");
    let sex_life_text= sex_life.options[sex_life.selectedIndex].text;
    let birth_control = document.getElementById("menopause");
    let birth_control_text= birth_control.options[birth_control.selectedIndex].text;
    let birth_control_2_text = $("#birth_control_2").val();
    console.log(pregnacy_month)
    if(dairy_text==""){
      alert("Δεν δεχόμαστε κενές τιμές")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_client_habits: 4,
          ajax_smoking: smoke_text,
          ajax_dairy: dairy_text,
          ajax_drink: drink_text,
          ajax_exercise: exercise_text,
          ajax_salt: salt_text,
          ajax_water: water_text,
          ajax_sugar: sugar_text,
          ajax_digestive_tract: digestive_tract_text,
          ajax_pregnacy_text: pregnacy_text,
          ajax_pregnacy_month: pregnacy_month,
          ajax_dermatosis_text: dermatosis_text,
          ajax_children_text: children_text,
          ajax_age_text: age_text,
          ajax_breast_feeding_text: breast_feeding_text,
          ajax_menstruation_text: menstruation_text,
          ajax_menstruation_time_text: menstruation_time_text,
          ajax_menstruation_frequency_text: menstruation_frequency_text,
          ajax_menopause_text: menopause_text,
          ajax_sex_life_text: sex_life_text,
          ajax_birth_control_text: birth_control_text,
          ajax_birth_control_2_text: birth_control_2_text,
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert Habits Completed") {
            alert("Εγγραφη Διατροφικών Συνηθειών Επιτυχής.")
          } else if (data.response == "False During Insert") {
            alert("Υπάρχουν ήδη Διατροφικές Συνήθειες Για Αυτον το Πελάτη.")
          } else if (data.response == "Insert Habits Update") {
            alert("Ολοκληρώθηκε το Update Διατροφικών Συνηθειών.")
          }else if (data.response == "Customer Does Not Exist") {
            alert("Δεν Υπάρχει ο Πελάτης Που Γίνεται Η Εγγραφή.")
          }
        },
      })
    }
  })
  $("#next_habits").click(function () {
    $("#form_habits").hide();
    $("#body").show();
  });
  $("#back_habits").click(function () {
    $("#form_habits").hide();
    $("#form_health").show();
  });
  $("#submit_face").on('click', function () {//----------------------------------------------------CUSTOMER FACE---------------------------------
    let face_type = document.getElementById("type_of_face");
    let face_type_text= face_type.options[face_type.selectedIndex].text;
    let skin_description_text = document.getElementById("Textarea_description").value;
    let facial_text = document.getElementById("Textarea_facial").value;
    let facial_past_text = document.getElementById("Textarea_facial_past").value;
    let surgery_text = document.getElementById("Textarea_surgery_face").value;
    let date_face = $("#date_face_1").val();
    let products_face = $("#products_face_1").val();
    let face_results_text = document.getElementById("Textarea_face_results").value;
    let face_therapy_text = document.getElementById("Textarea_face_therapy").value;
    let face_nutrution_text = document.getElementById("Textarea_face_nutrition").value;
    let face_comms_text = document.getElementById("Textarea_face_comms").value;
    if(face_type_text == ""){
      alert("Επιλέξτε Τύπο Προσώπου.");
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_client_face: 5,
          ajax_face_type_text : face_type_text,
          ajax_skin_description_text : skin_description_text,
          ajax_facial_text : facial_text,
          ajax_facial_past_text : facial_past_text,
          ajax_surgery_text : surgery_text ,
          ajax_date_face: date_face,
          ajax_products_face: products_face,
          ajax_face_results_text : face_results_text,
          ajax_face_therapy_text : face_therapy_text,
          ajax_face_nutrution_text :face_nutrution_text,
          ajax_face_comms_text : face_comms_text
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert Face Data Completed") {
            alert("Ολοκληρώθηκε η Καταχώρηση Δεδομένων Προσώπου.")
          } else if (data.response == "Problem During Insert.Entry Deleted") {
            alert("Πρόβλημα Κατα τη Διάρκεια της Εγγραφής. Έγινε διαγραφή της Εγγραφής.Προσπάθησε Ξανά.")
          }else if (data.response == "Update Face Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Προσώπου.")
          }
        },
      })
    }
  })
  $("#next_habits_face").click(function () {
    $("#form_face").show();
    $("#form_habits").hide();
  });
  $("#next_face").click(function () {
    $("#form_health").show();
    $("#form_face").hide();
  });
  $("#submit_breast").on('click', function () {//--------------------------------------------------CUSTOMER BREAST--------------------------------

    let breast_type = document.getElementById("breast_type");
    let breast_type_text= breast_type.options[breast_type.selectedIndex].text;
    let breast_data_text = document.getElementById("Textarea_breast_data").value;
    let breast_care_text = document.getElementById("Textarea_breast_care").value;
    let breast_care_past_text = document.getElementById("Textarea_breast_care_past").value;
    let surgery_breast_text = document.getElementById("Textarea_surgery_breast").value;
    let distance_niple_other = $("#dis_niple_to_other").val();
    let distance_rniple_navel = $("#dis_right_niple_to_navel").val();
    let distance_lniple_navel = $("#dis_left_niple_to_navel").val();
    let breast_contour = $("#breast_contour").val();
    let date_breast_1 = $("#date_breast_1").val();
    let date_products_1 = $("#date_products_1").val();
    let distance_niple_other_after = $("#dis_niple_to_other_after").val();
    let distance_rniple_navel_after = $("#dis_right_niple_to_navel_after").val();
    let distance_lniple_navel_after = $("#dis_left_niple_to_navel_after").val();
    let breast_contour_after = $("#breast_contour_after").val();
    let breast_products= document.getElementById("Textarea_breast_products").value;
    let breast_nutrition= document.getElementById("Textarea_breast_nutrition").value;
    let breast_comms= document.getElementById("Textarea_breast_comms").value;
    //console.log(typeof(breast_type_text));
    if(breast_type_text== ""){
      alert("Δεν έχετε επιλέξει τύπο Στήθους")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_client_breast: 6,
          ajax_breast_type_text: breast_type_text,
          ajax_breast_data_text: breast_data_text,
          ajax_breast_care_text: breast_care_text,
          ajax_breast_care_past_text: breast_care_past_text,
          ajax_surgery_breast_text: surgery_breast_text,
          ajax_distance_niple_other: distance_niple_other,
          ajax_distance_rniple_navel: distance_rniple_navel ,
          ajax_distance_lniple_navel: distance_lniple_navel ,
          ajax_breast_contour: breast_contour ,
          ajax_date_breast_1: date_breast_1,
          ajax_date_products_1: date_products_1,
          ajax_distance_niple_other_after: distance_niple_other_after,
          ajax_distance_rniple_navel_after : distance_rniple_navel_after  ,
          ajax_distance_lniple_navel_after: distance_lniple_navel_after ,
          ajax_breast_contour_after: breast_contour_after,
          ajax_breast_products: breast_products ,
          ajax_breast_nutrition: breast_nutrition ,
          ajax_breast_comms: breast_comms ,
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert Breast Data Completed") {
            alert("Ολοκληρώθηκε η Καταχώρηση Δεδομένων Στήθους.")
          } else if (data.response == "Problem During Insert.Entry Deleted") {
            alert("Πρόβλημα Κατα τη Διάρκεια της Εγγραφής. Έγινε διαγραφή της Εγγραφής.Προσπάθησε Ξανά.")
          }else if (data.response == "Update Breast Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Στήθους.")
          }
        },
      })
    }
  })
  $("#next_habits_breast").click(function () {
    $("#form_breast").show();
    $("#form_habits").hide();
  });
  $("#next_body").click(function () {
    $("#form_health").show();
    $("#form_breast").hide();
  });
  $("#submit_body").on('click', function () {//----------------------------------------------------CUSTOMER BODY-----------------------------------
    let body_type = document.getElementById("natural_type");
    let body_type_text= body_type.options[body_type.selectedIndex].text;
    let body_type_comms = document.getElementById("Textarea_body_type").value;
    let body_care_text = document.getElementById("Textarea_body_care").value;
    let body_care_past_text = document.getElementById("Textarea_body_care_past").value;
    let body_surgery_text = document.getElementById("Textarea_surgery_body").value;
    let body_middle = $("#body_middle").val();
    let body_hip = $("#body_hip").val();
    let body_right_thigh = $("#body_right_thigh").val();
    let body_left_thigh = $("#body_left_thigh").val();
    let body_right_knee = $("#body_right_knee").val();
    let body_left_knee = $("#body_left_knee").val();
    let body_right_ankle = $("#body_right_ankle").val();
    let body_left_ankle = $("#body_left_ankle").val();
    let body_date = $("#date_body_1").val();
    let body_products = $("#date_body_products_1").val();
    let body_middle_after = $("#body_middle_after").val();
    let body_hip_after = $("#body_hip_after").val();
    let body_right_thigh_after = $("#body_right_thigh_after").val();
    let body_left_thigh_after = $("#body_left_thigh_after").val();
    let body_right_knee_after= $("#body_right_knee_after").val();
    let body_left_knee_after = $("#body_left_knee_after").val();
    let body_right_ankle_after = $("#body_right_ankle_after").val();
    let body_left_ankle_after = $("#body_left_ankle_after").val();
    let body_comments = document.getElementById("Textarea_body_comms").value;
    let chbox = new Array();
    $("input[name='part']:checked").each(function () {
      if ($("#middle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#hip").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_thigh").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_thigh").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_knee").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_knee").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_ankle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_ankle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#all").is(":checked")) {
        chbox.push($(this).val());
      } else {
        alert('Checkbox not checked!');
      }
    });
    console.log(chbox)
    console.log(body_type_text)
    if(body_type_text==""){
      alert("Δεν έχετε επιλέξει τύπο προβλήματος σώματος")
      //console.log(chbox)
    }else if(chbox==""){
      alert("Δεν έχετε επιλέξει τύπου σώματος")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_client_body: 7,
          ajax_body_type_text: body_type_text,
          ajax_body_type_comms:body_type_comms ,
          ajax_body_care_text: body_care_text,
          ajax_body_care_past_text: body_care_past_text,
          ajax_body_surgery_text: body_surgery_text,
          ajax_body_middle: body_middle,
          ajax_body_hip:  body_hip,
          ajax_body_right_thigh: body_right_thigh,
          ajax_body_left_thigh: body_left_thigh ,
          ajax_body_right_knee: body_right_knee,
          ajax_body_left_knee: body_left_knee,
          ajax_body_right_ankle: body_right_ankle,
          ajax_body_left_ankle: body_left_ankle,
          ajax_body_middle_after: body_middle_after,
          ajax_body_hip_after: body_hip_after,
          ajax_body_right_thigh_after: body_right_thigh_after,
          ajax_body_left_thigh_after: body_left_thigh_after,
          ajax_body_right_knee_after: body_right_knee_after,
          ajax_body_left_knee_after: body_left_knee_after,
          ajax_body_right_ankle_after: body_right_ankle_after,
          ajax_body_left_ankle_after: body_left_ankle_after,
          ajax_body_date: body_date,
          ajax_body_products: body_products,
          ajax_body_comments: body_comments,
          ajax_checkboxes_value: chbox.toString()
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert Breast Data Completed") {
            alert("Ολοκληρώθηκε η Καταχώρηση Δεδομένων Στήθους.")
          } else if (data.response == "Problem During Insert.Entry Deleted") {
            alert("Πρόβλημα Κατα τη Διάρκεια της Εγγραφής. Έγινε διαγραφή της Εγγραφής.Προσπάθησε Ξανά.")
          }else if (data.response == "Update Breast Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Στήθους.")
          }
        },
      })
    }
  })
  $("#next_habits_body").click(function () {
    $("#body").show();
    $("#form_habits").hide();
  });
  $("#back_habits_body").click(function () {
    $("#body").hide();
    $("#form_habits").show();
  });
  $("#next_body").click(function () {
    $("#body").hide();
    $("#form_health").show();
  });
  //----------------------------------------------------------------------------------------------WHEN ALL BUTTON--------------------------------------------
  $("#next_habits_all").click(function () {
    $("#body").show();
    $("#form_habits").hide();
  });
  $("#next_body_all").click(function () {//BODY
    $("#form_breast").show();
    $("#body").hide();
  });
  $("#back_body_all").click(function () {//BACK BODY
    $("#form_habits").show();
    $("#body").hide();
  });
  $("#next_breast_all").click(function () {//NEXT BREAST
    $("#form_face").show();
    $("#form_breast").hide();
  });
  $("#back_breast_all").click(function () {//BACK BREAST
    $("#body").show();
    $("#form_breast").hide();
  });
  $("#next_face_all").click(function () {//FACE
    $("#form_health").show();
    $("#form_face").hide();
  });
  $("#back_face_all").click(function () {//BACK FACE
    $("#form_breast").show();
    $("#form_face").hide();
  });
  $("#back_health_all").click(function () {//BACK HEALTH
    $("#form_face").show();
    $("#form_health").hide();
  });
  //--------------------------------------------WHEN BODY-BREAST--------------------------------------------
  $("#next_habits_body_breast").click(function () {
    $("#body").show();
    $("#form_habits").hide();
  });
  $("#back_body_breast").click(function () {
    $("#form_habits").show();
    $("#body").hide();
  });
  $("#next_body_breast").click(function () {
    $("#form_breast").show();
    $("#body").hide();
  });
  $("#back_breast_body").click(function () {
    $("#body").show();
    $("#form_breast").hide();
  });
  $("#next_breast_health").click(function () {
    $("#form_health").show();
    $("#form_breast").hide();
  });
  //--------------------------------------------WHEN BODY-FACE--------------------------------------------
  $("#next_habits_body_face").click(function () {
    $("#body").show();
    $("#form_habits").hide();
  });
  $("#back_body_face").click(function () {
    $("#form_habits").show();
    $("#body").hide();
  });
  $("#next_body_face").click(function () {
    $("#form_face").show();
    $("#body").hide();
  });
  $("#back_face_body").click(function () {
    $("#body").show();
    $("#form_face").hide();
  });
  $("#next_face_health").click(function () {
    $("#form_health").show();
    $("#form_face").hide();
  });
  //--------------------------------------------WHEN BREAST-FACE--------------------------------------------
  $("#next_habits_breast_face").click(function () {
    $("#form_breast").show();
    $("#form_habits").hide();
  });
  $("#back_breast_habits").click(function () {
    $("#form_habits").show();
    $("#form_breast").hide();
  });
  $("#next_breast_face").click(function () {
    $("#form_face").show();
    $("#form_breast").hide();
  });
  $("#back_face_breast").click(function () {
    $("#form_breast").show();
    $("#form_face").hide();
  });
  $("#next_face_health").click(function () {
    $("#form_health").show();
    $("#form_face").hide();
  });
})

//---------------------------------------------------------------------------------------------UPDATE PAGEEEEEE---------------------------------------------------------------------
$(document).ready(function () {
  $("#submit_update_personal_data").on('click', function () {
    let fname = $("#fname_temp").val();
    let lname = $("#lname_temp").val();
    let phone = $("#phone_temp").val();
    let name_beautician = $("#name_beautician").val();
    let email = $("#email_formal").val();
    let birth = $("#dof2").val();
    //let letter = /^[A-Za-z]+$/;
    console.log(fname)
    console.log(lname)
    if ((fname == "" || lname == "") || phone == "") {
      alert("Κενές Τιμές στο Όνομα, Επώνυμο και Email.");
    }else {
      console.log('accepted first and lastname')
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_update_data: 2.1,
          ajax_fname: fname,
          ajax_lname: lname,
          ajax_phone: phone,
          ajax_name_beautician : name_beautician,
          ajax_email: email,
          ajax_birth: birth,
        },
        success: function (response) {
          data = JSON.parse(response)
          if (data.response == "Data Update") {
            alert("Ανανεώθηκαν Τα Δεδομένα του Χρήστη.")
            window.location.href = "New_Update_Page.php";

          } else if (data.response == "Problem Occured During Update") {
            alert("Προέκυψε Πρόβλημα με την Ενημέρωση")

          } else if (data.response == "No Original Data For Customer Data") {
            alert("Δεν Υπάρχουν Τα Δεδομένα του Χρήστης Στο Σύστημα");

          }else if (data.response == "Client Data Doesnt Exist") {
            alert("Δεν Υπάρχει Ο Χρήστης Στο Σύστημα");
            
          }
        },
      })
    }
  });
  $("#submit_update_health").on('click', function () {//--------------------------------------------------CUSTOMER HEALTH-------------------------------
    let height = $("#height").val();
    let weight = $("#weight").val();
    let health= document.getElementById("health");
    let health_choice= health.options[health.selectedIndex].text;
    let health_text = document.getElementById("Textarea_health").value;
    let sleep= document.getElementById("sleep");
    let sleep_choice= sleep.options[sleep.selectedIndex].text;
    let sleep_text = document.getElementById("Textarea_sleep").value;
    let appetite= document.getElementById("appetite");
    let appetite_choice= appetite.options[appetite.selectedIndex].text;
    let appetite_text = document.getElementById("Textarea_appetite").value;
    let diseases_text = document.getElementById("Textarea_diseases").value;
    let meds_text = document.getElementById("Textarea_meds").value;
    let surgery_text = document.getElementById("Textarea_surgery").value;
    if ((height == "" || weight == "")) {
      alert("Κενές Τιμές στο Βάρος και στο Ύψος");
    } else {
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_client_update_health: 3.1,
          ajax_height: height,
          ajax_weight: weight,
          ajax_health_choice: health_choice,
          ajax_health_text: health_text,
          ajax_sleep_choice: sleep_choice,
          ajax_sleep_text: sleep_text,
          ajax_appetite_choice: appetite_choice,
          ajax_appetite_text: appetite_text,
          ajax_diseases_text: diseases_text,
          ajax_meds_text: meds_text,
          ajax_surgery_text: surgery_text
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if(data.response=="Data Updated"){
            alert("Τα στοιχεία ανανεώθηκαν επιτυχώς.");
         
          }else  if (data.response == "No Entry For Current AFM") {
            alert("Μη Επιτυχημένη Εγγραφή Στοιχείων. Δεν Υπάρχει η Εγγραφή με το Συγκεκριμένο ΑΦΜ.")

          }else  if (data.response == "No Update") {
            alert("Μη Επιτυχημένη Εγγραφή Στοιχείων. Ελέγξτε τα Στοιχεία.")

          }else if(data.response=="More than one user with the same health issues"){
            alert("Υπάρχουν παραπάνω από ένας πίνακας με αυτά τα στοιχεία.");

          }else if (data.response == "Problem Occuried. Problem With Customer Email.") {
            alert("Προέκυψε Πρόβλημα με το E-mail του Χρήστη.Επαναλάβατε την εγγραφή");
            window.location.href = "New_First_Page.php"
          }
        },
      })
    }
  })
  $("#submit_update_habits").on('click', function () {//--------------------------------------------------CUSTOMER HABITS-------------------------------
    let dairy = document.getElementById("dairy");
    let dairy_text= dairy.options[dairy.selectedIndex].text;
    let smoke = document.getElementById("smoke");
    let smoke_text= smoke.options[smoke.selectedIndex].text;
    let drink = document.getElementById("drink");
    let drink_text= drink.options[drink.selectedIndex].text;
    let exercise = document.getElementById("exercise");
    let exercise_text= exercise.options[exercise.selectedIndex].text;
    let salt = document.getElementById("salt");
    let salt_text= salt.options[salt.selectedIndex].text;
    let water = document.getElementById("water");
    let water_text= water.options[water.selectedIndex].text;
    let sugar = document.getElementById("sugar");
    let sugar_text= sugar.options[sugar.selectedIndex].text;
    let digestive_tract_text = document.getElementById("Textarea_digestive_tract").value;
    let pregnacy = document.getElementById("pregnacy");
    let pregnacy_text= pregnacy.options[pregnacy.selectedIndex].text;
    let pregnacy_month = $("#pregnacy_month").val();
    let dermatosis_text = document.getElementById("Textarea_dermatosis").value;
    let children_text = $("#children").val();
    let age_text = $("#age").val();
    let breast_feeding = document.getElementById("breast_feeding");
    let breast_feeding_text= breast_feeding.options[breast_feeding.selectedIndex].text;
    let menstruation = document.getElementById("menstruation");
    let menstruation_text= menstruation.options[menstruation.selectedIndex].text;
    let menstruation_time_text = document.getElementById("Textarea_menstruation_time").value;
    let menstruation_frequency_text = document.getElementById("Textarea_menstruation_frequency").value;
    let menopause = document.getElementById("menopause");
    let menopause_text= menopause.options[menopause.selectedIndex].text;
    let sex_life = document.getElementById("sex_life");
    let sex_life_text= sex_life.options[sex_life.selectedIndex].text;
    let birth_control = document.getElementById("menopause");
    let birth_control_text= birth_control.options[birth_control.selectedIndex].text;
    let birth_control_2_text = $("#birth_control_2").val();
    console.log(pregnacy_month)
    if(dairy_text==""){
      alert("Δεν δεχόμαστε κενές τιμές")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_client_update_habits: 4.1,
          ajax_smoking: smoke_text,
          ajax_dairy: dairy_text,
          ajax_drink: drink_text,
          ajax_exercise: exercise_text,
          ajax_salt: salt_text,
          ajax_water: water_text,
          ajax_sugar: sugar_text,
          ajax_digestive_tract: digestive_tract_text,
          ajax_pregnacy_text: pregnacy_text,
          ajax_pregnacy_month: pregnacy_month,
          ajax_dermatosis_text: dermatosis_text,
          ajax_children_text: children_text,
          ajax_age_text: age_text,
          ajax_breast_feeding_text: breast_feeding_text,
          ajax_menstruation_text: menstruation_text,
          ajax_menstruation_time_text: menstruation_time_text,
          ajax_menstruation_frequency_text: menstruation_frequency_text,
          ajax_menopause_text: menopause_text,
          ajax_sex_life_text: sex_life_text,
          ajax_birth_control_text: birth_control_text,
          ajax_birth_control_2_text: birth_control_2_text,
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if(data.response=="Data Updated"){
            alert("Τα στοιχεία ανανεώθηκαν επιτυχώς.");
         
          }else  if (data.response == "No Entry For Current AFM") {
            alert("Μη Επιτυχημένη Εγγραφή Στοιχείων. Δεν Υπάρχει η Εγγραφή με το Συγκεκριμένο ΑΦΜ.")

          }else  if (data.response == "No Update") {
            alert("Μη Επιτυχημένη Εγγραφή Στοιχείων. Ελέγξτε τα Στοιχεία.")

          }else if(data.response=="More than one user with the same habits issues"){
            alert("Υπάρχουν παραπάνω από ένας πίνακας με αυτά τα στοιχεία.");

          }else if (data.response == "Problem Occuried. Problem With Customer Email.") {
            alert("Προέκυψε Πρόβλημα με το E-mail του Χρήστη.Επαναλάβατε την εγγραφή");
            window.location.href = "New_First_Page.php"
          }
        },
      })
    }
  })
  
  $("#show_health").click(function () {
    $("#form_health").show();
    $("#form_habits").hide();
    $("#form_data").hide();
  });
  $("#show_habits").click(function () {
    $("#form_habits").show();
    $("#form_health").hide();
    $("#form_data").hide();
  });
  $("#show_data").click(function () {
    $("#form_data").show();
    $("#form_habits").hide();
    $("#form_health").hide();
  });
})
//---------------------------------------------------------------------------------------------THIRD PAGEEEEEE---------------------------------------------------------------------------------------------
$(document).ready(function () {
  $("#afm_search").on('click', function () {//-------------------------------------------------AFM SEARCH---------------------------------------------------------------------------------------------

    let afm = $("#afm").val();
    if(afm=="" ){
      alert("Δεν επέλεξες ΑΦΜ.")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_show_data_face_breast_body: 9,
          ajax_afm: afm,
        },
        success: function (response) {
          data = JSON.parse(response)
          //console.log(data.response)
          if (data.response_face != "Wrong Face Query"){
            let mypersonaldata_face= ["Ραντεβού","ΑΦΜ" ,"Ημερομηνία Ραντεβού", "Τύπος Επιδερμίδας", "Περιγραφή Επιδερμίδας", "Περιποιήση Προσώπου",
            "Περιποιήση Προσώπου(Παρελθόν)","Επεμβάσεις", "Προίοντα Θεραπείας Καμπίνας","face_text","Αποτελέσματα", "Προίοντα Θεραπείας Για το Σπίτι", 
            "Συμβουλή Διατροφής", "Σχόλια"]
            face_table = builds_Table(data.response_face,mypersonaldata_face)
            //console.log(face_table)
            // appends <table> into <body>
            document.body.appendChild(face_table);
            // sets the border attribute of tbl to '2'
            face_table.setAttribute("border", "10");
            face_table.setAttribute("name", "table_data");
            face_table.setAttribute("id", "face_table"); 
          }else{
            alert("Δεν Έχει Δεδομένα Για το Πρόσωπο.")
          }
          
          if (data.response_breast != "Wrong Breast Query"){
            let mypersonaldata_breast= [ "ΑΦΜ" ,"Ημερομηνία Ραντεβού", "Τύπος Προσώπου", "Περιγραφή Στήθους", "Περιγραφή Συνηθισμένης Περιποιήσης Στήθους", "Περιγραφή Περιποιήσης Στήθους(Παρελθόν)", 
            "Επεμβάσεις","Απόσταση Θήλης στην Άλλη","Απόσταση Δεξιάς Θήλης Στον Αφαλό","Απόσταση Αριστερής Θήλης Στον Αφαλό","Περίγραμμα Στήθους", "Προίοντα Θεραπείας Καμπίνας",
            "Απόσταση Θήλης στην Άλλη","Απόσταση Δεξιάς Θήλης Στον Αφαλό","Απόσταση Αριστερής Θήλης Στον Αφαλό","Περίγραμμα Στήθους","Προτεινόμενα Προίοντα(Σπίτι)",
            "Συμβουλή Διατροφής","Σχόλια"]
            breast_table = builds_Table(data.response_breast,mypersonaldata_breast)
            //console.log(face_table)
            // appends <table> into <body>
            document.body.appendChild(breast_table);
            // sets the border attribute of tbl to '2'
            breast_table.setAttribute("border", "10");
            breast_table.setAttribute("name", "table_data");
            breast_table.setAttribute("id", "breast_table"); 
          }else{
            alert("Δεν Έχει Δεδομένα Για το Στήθος.")
          }
          

          if (data.response_body != "Wrong Body Query"){
            let mypersonaldata_body= [ "ΑΦΜ" ,"Ημερομηνία Ραντεβού", "Σώμα", "Σχόλια Τύπου Σώματος", "Συνηθισμένη Περιποιήση Σώματος", "Συνηθισμένη Περιποιήση Σώματος(Παρελθόν)", 
            "Επεμβάσεις","Μέση(Πριν)", "Ισχίο(Πριν)", "Δεξιός μηρός(Πριν)", "Αριστερός μηρός(Πριν)", "Δεξί Γόνατο(Πριν)","Αριστερό Γόνατο(Πριν)", "Δεξιός Αστράγαλος(Πριν)", "Αριστερός αστράγαλος(Πριν)", 
            "Μέση(Μετά)", "Ισχίο(Μετά)", "Δεξιός μηρός(Μετά)", "Αριστερός μηρός(Μετά)", "Δεξί Γόνατο(Μετά)","Αριστερό Γόνατο(Μετά)", "Δεξιός Αστράγαλος(Μετά)", "Αριστερός αστράγαλος(Μετά)", "Προίοντα Θεραπείας Καμπίνας", "Σχόλια", "Επιλογή Μέρος Σώματος"]
            body_table = builds_Table(data.response_body,mypersonaldata_body)
            //console.log(face_table)
            // appends <table> into <body>
            document.body.appendChild(body_table);
            // sets the border attribute of tbl to '2'
            body_table.setAttribute("border", "10");
            body_table.setAttribute("name", "table_data");
            body_table.setAttribute("id", "body_table"); 
          }else{
            alert("Δεν Έχει Δεδομένα Για το Σώμα.")
          }
        },
      })
    }
  })
  $("#submit_face_insert").on('click', function () {
    let face_type = document.getElementById("type_of_face");
    let face_type_text= face_type.options[face_type.selectedIndex].text;
    let skin_description_text = document.getElementById("Textarea_description").value;
    let facial_text = document.getElementById("Textarea_facial").value;
    let facial_past_text = document.getElementById("Textarea_facial_past").value;
    let surgery_text = document.getElementById("Textarea_surgery_face").value;
    let date_face = $("#date_face_1").val();
    let products_face = $("#products_face_1").val();
    let face_results_text = document.getElementById("Textarea_face_results").value;
    let face_therapy_text = document.getElementById("Textarea_face_therapy").value;
    let face_nutrution_text = document.getElementById("Textarea_face_nutrition").value;
    let face_comms_text = document.getElementById("Textarea_face_comms").value;
    if(face_type_text == ""){
      alert("Επιλέξτε Τύπο Προσώπου.");
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_insert_face: 5.1,
          ajax_face_type_text : face_type_text,
          ajax_skin_description_text : skin_description_text,
          ajax_facial_text : facial_text,
          ajax_facial_past_text : facial_past_text,
          ajax_surgery_text : surgery_text ,
          ajax_date_face: date_face,
          ajax_products_face: products_face,
          ajax_face_results_text : face_results_text,
          ajax_face_therapy_text : face_therapy_text,
          ajax_face_nutrution_text :face_nutrution_text,
          ajax_face_comms_text : face_comms_text
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert Face Data Completed") {
            alert("Ολοκληρώθηκε η Καταχώρηση Δεδομένων Προσώπου.")
          } else if (data.response == "Problem During Insert.Entry Deleted") {
            alert("Πρόβλημα Κατα τη Διάρκεια της Εγγραφής. Έγινε διαγραφή της Εγγραφής.Προσπάθησε Ξανά.")
          }else if (data.response == "Update Face Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Προσώπου.")
          }
        },
      })
    }
    
  });
  $("#submit_face_update").on('click', function () {
    let face_type = document.getElementById("type_of_face");
    let face_type_text= face_type.options[face_type.selectedIndex].text;
    let skin_description_text = document.getElementById("Textarea_description").value;
    let facial_text = document.getElementById("Textarea_facial").value;
    let facial_past_text = document.getElementById("Textarea_facial_past").value;
    let surgery_text = document.getElementById("Textarea_surgery_face").value;
    let date_face = $("#date_face_1").val();
    let products_face = $("#products_face_1").val();
    let face_results_text = document.getElementById("Textarea_face_results").value;
    let face_therapy_text = document.getElementById("Textarea_face_therapy").value;
    let face_nutrution_text = document.getElementById("Textarea_face_nutrition").value;
    let face_comms_text = document.getElementById("Textarea_face_comms").value;
    if(face_type_text == ""){
      alert("Επιλέξτε Τύπο Προσώπου.");
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_update_face: 5.2,
          ajax_face_type_text : face_type_text,
          ajax_skin_description_text : skin_description_text,
          ajax_facial_text : facial_text,
          ajax_facial_past_text : facial_past_text,
          ajax_surgery_text : surgery_text ,
          ajax_date_face: date_face,
          ajax_products_face: products_face,
          ajax_face_results_text : face_results_text,
          ajax_face_therapy_text : face_therapy_text,
          ajax_face_nutrution_text :face_nutrution_text,
          ajax_face_comms_text : face_comms_text
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Update Face Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Προσώπου.")
          
          }else if (data.response == "Problem During Update.Entry Deleted") {
            alert("Πρόβλημα Κατα τη Διάρκεια της Ανανέωσης Εγγραφής. Έγινε διαγραφή της Εγγραφής.Προσπάθησε Ξανά Κάνοντας Καταχώρηση Εξαρχής.")

          }else if (data.response == "No available data for face") {
            alert("Δεν Έχει Ξαναγίνει Εγγραφή Δεδομένων Προσώπου.")
          } 
        },
      })
    }
   
  });

  $("#submit_breast_insert").on('click', function () {
    let breast_type = document.getElementById("breast_type");
    let breast_type_text= breast_type.options[breast_type.selectedIndex].text;
    let breast_data_text = document.getElementById("Textarea_breast_data").value;
    let breast_care_text = document.getElementById("Textarea_breast_care").value;
    let breast_care_past_text = document.getElementById("Textarea_breast_care_past").value;
    let surgery_breast_text = document.getElementById("Textarea_surgery_breast").value;
    let distance_niple_other = $("#dis_niple_to_other").val();
    let distance_rniple_navel = $("#dis_right_niple_to_navel").val();
    let distance_lniple_navel = $("#dis_left_niple_to_navel").val();
    let breast_contour = $("#breast_contour").val();
    let date_breast_1 = $("#date_breast_1").val();
    let date_products_1 = $("#date_products_1").val();
    let distance_niple_other_after = $("#dis_niple_to_other_after").val();
    let distance_rniple_navel_after = $("#dis_right_niple_to_navel_after").val();
    let distance_lniple_navel_after = $("#dis_left_niple_to_navel_after").val();
    let breast_contour_after = $("#breast_contour_after").val();
    let breast_products= document.getElementById("Textarea_breast_products").value;
    let breast_nutrition= document.getElementById("Textarea_breast_nutrition").value;
    let breast_comms= document.getElementById("Textarea_breast_comms").value;
    //console.log(breast_type_text);
    if(breast_type_text == ""){
      alert("Δεν έχετε επιλέξει τύπο Στήθους")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_insert_breast: 6.1,
          ajax_breast_type_text: breast_type_text,
          ajax_breast_data_text: breast_data_text,
          ajax_breast_care_text: breast_care_text,
          ajax_breast_care_past_text: breast_care_past_text,
          ajax_surgery_breast_text: surgery_breast_text,
          ajax_distance_niple_other: distance_niple_other,
          ajax_distance_rniple_navel: distance_rniple_navel ,
          ajax_distance_lniple_navel: distance_lniple_navel ,
          ajax_breast_contour: breast_contour ,
          ajax_date_breast_1: date_breast_1,
          ajax_date_products_1: date_products_1,
          ajax_distance_niple_other_after: distance_niple_other_after,
          ajax_distance_rniple_navel_after : distance_rniple_navel_after  ,
          ajax_distance_lniple_navel_after: distance_lniple_navel_after ,
          ajax_breast_contour_after: breast_contour_after,
          ajax_breast_products: breast_products ,
          ajax_breast_nutrition: breast_nutrition ,
          ajax_breast_comms: breast_comms ,
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert Breast Data Completed") {
            alert("Ολοκληρώθηκε η Καταχώρηση Δεδομένων Στήθους.")
          } else if (data.response == "Problem During Insert.Entry Deleted") {
            alert("Πρόβλημα Κατα τη Διάρκεια της Εγγραφής. Έγινε διαγραφή της Εγγραφής.Προσπάθησε Ξανά.")
          }else if (data.response == "Update Breast Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Στήθους.")
          }
        },
      })
    }
  })
  $("#submit_breast_update").click(function () {
    let breast_type = document.getElementById("breast_type");
    let breast_type_text= breast_type.options[breast_type.selectedIndex].text;
    let breast_data_text = document.getElementById("Textarea_breast_data").value;
    let breast_care_text = document.getElementById("Textarea_breast_care").value;
    let breast_care_past_text = document.getElementById("Textarea_breast_care_past").value;
    let surgery_breast_text = document.getElementById("Textarea_surgery_breast").value;
    let distance_niple_other = $("#dis_niple_to_other").val();
    let distance_rniple_navel = $("#dis_right_niple_to_navel").val();
    let distance_lniple_navel = $("#dis_left_niple_to_navel").val();
    let breast_contour = $("#breast_contour").val();
    let date_breast_1 = $("#date_breast_1").val();
    let date_products_1 = $("#date_products_1").val();
    let distance_niple_other_after = $("#dis_niple_to_other_after").val();
    let distance_rniple_navel_after = $("#dis_right_niple_to_navel_after").val();
    let distance_lniple_navel_after = $("#dis_left_niple_to_navel_after").val();
    let breast_contour_after = $("#breast_contour_after").val();
    let breast_products= document.getElementById("Textarea_breast_products").value;
    let breast_nutrition= document.getElementById("Textarea_breast_nutrition").value;
    let breast_comms= document.getElementById("Textarea_breast_comms").value;
    console.log(breast_type_text);
    if(breast_type_text== ""){
      alert("Δεν έχετε επιλέξει τύπο Στήθους")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_update_breast: 6.2,
          ajax_breast_type_text: breast_type_text,
          ajax_breast_data_text: breast_data_text,
          ajax_breast_care_text: breast_care_text,
          ajax_breast_care_past_text: breast_care_past_text,
          ajax_surgery_breast_text: surgery_breast_text,
          ajax_distance_niple_other: distance_niple_other,
          ajax_distance_rniple_navel: distance_rniple_navel ,
          ajax_distance_lniple_navel: distance_lniple_navel ,
          ajax_breast_contour: breast_contour ,
          ajax_date_breast_1: date_breast_1,
          ajax_date_products_1: date_products_1,
          ajax_distance_niple_other_after: distance_niple_other_after,
          ajax_distance_rniple_navel_after : distance_rniple_navel_after  ,
          ajax_distance_lniple_navel_after: distance_lniple_navel_after ,
          ajax_breast_contour_after: breast_contour_after,
          ajax_breast_products: breast_products ,
          ajax_breast_nutrition: breast_nutrition ,
          ajax_breast_comms: breast_comms ,
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Update Breast Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Στήθους.")
          } else if (data.response == "No available data for breast") {
            alert("Δεν Έχει Ξαναγίνει Εγγραφή Δεδομένων Στήθους.")
          }
        },
      })
    }
  });
  
  $("#submit_body_insert").on('click', function () {
    let body_type = document.getElementById("natural_type");
    let body_type_text= body_type.options[body_type.selectedIndex].text;
    let body_type_comms = document.getElementById("Textarea_body_type").value;
    let body_care_text = document.getElementById("Textarea_body_care").value;
    let body_care_past_text = document.getElementById("Textarea_body_care_past").value;
    let body_surgery_text = document.getElementById("Textarea_surgery_body").value;
    let body_middle = $("#body_middle").val();
    let body_hip = $("#body_hip").val();
    let body_right_thigh = $("#body_right_thigh").val();
    let body_left_thigh = $("#body_left_thigh").val();
    let body_right_knee = $("#body_right_knee").val();
    let body_left_knee = $("#body_left_knee").val();
    let body_right_ankle = $("#body_right_ankle").val();
    let body_left_ankle = $("#body_left_ankle").val();
    let body_date = $("#date_body_1").val();
    let body_products = $("#date_body_products_1").val();
    let body_middle_after = $("#body_middle_after").val();
    let body_hip_after = $("#body_hip_after").val();
    let body_right_thigh_after = $("#body_right_thigh_after").val();
    let body_left_thigh_after = $("#body_left_thigh_after").val();
    let body_right_knee_after= $("#body_right_knee_after").val();
    let body_left_knee_after = $("#body_left_knee_after").val();
    let body_right_ankle_after = $("#body_right_ankle_after").val();
    let body_left_ankle_after = $("#body_left_ankle_after").val();
    let body_comments = document.getElementById("Textarea_body_comms").value;
    let chbox = new Array();
    $("input[name='part']:checked").each(function () {
      if ($("#middle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#hip").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_thigh").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_thigh").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_knee").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_knee").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_ankle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_ankle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#all").is(":checked")) {
        chbox.push($(this).val());
      } else {
        alert('Checkbox not checked!');
      }
    });
    console.log(chbox)
    console.log(body_type_text)
    if(body_type_text==""){
      alert("Δεν έχετε επιλέξει τύπο προβλήματος σώματος")
      //console.log(chbox)
    }else if(chbox==""){
      alert("Δεν έχετε επιλέξει τύπου σώματος")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_insert_body: 7.1,
          ajax_body_type_text: body_type_text,
          ajax_body_type_comms:body_type_comms ,
          ajax_body_care_text: body_care_text,
          ajax_body_care_past_text: body_care_past_text,
          ajax_body_surgery_text: body_surgery_text,
          ajax_body_middle: body_middle,
          ajax_body_hip:  body_hip,
          ajax_body_right_thigh: body_right_thigh,
          ajax_body_left_thigh: body_left_thigh ,
          ajax_body_right_knee: body_right_knee,
          ajax_body_left_knee: body_left_knee,
          ajax_body_right_ankle: body_right_ankle,
          ajax_body_left_ankle: body_left_ankle,
          ajax_body_middle_after: body_middle_after,
          ajax_body_hip_after: body_hip_after,
          ajax_body_right_thigh_after: body_right_thigh_after,
          ajax_body_left_thigh_after: body_left_thigh_after,
          ajax_body_right_knee_after: body_right_knee_after,
          ajax_body_left_knee_after: body_left_knee_after,
          ajax_body_right_ankle_after: body_right_ankle_after,
          ajax_body_left_ankle_after: body_left_ankle_after,
          ajax_body_date: body_date,
          ajax_body_products: body_products,
          ajax_body_comments: body_comments,
          ajax_checkboxes_value: chbox.toString()
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
          if (data.response == "Insert Breast Data Completed") {
            alert("Ολοκληρώθηκε η Καταχώρηση Δεδομένων Στήθους.")
          } else if (data.response == "Problem During Insert.Entry Deleted") {
            alert("Πρόβλημα Κατα τη Διάρκεια της Εγγραφής. Έγινε διαγραφή της Εγγραφής.Προσπάθησε Ξανά.")
          }else if (data.response == "Update Breast Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Στήθους.")
          }
        },
      })
    }
  })
  $("#submit_body_update").on('click', function () {
    let body_type = document.getElementById("natural_type");
    let body_type_text= body_type.options[body_type.selectedIndex].text;
    let body_type_comms = document.getElementById("Textarea_body_type").value;
    let body_care_text = document.getElementById("Textarea_body_care").value;
    let body_care_past_text = document.getElementById("Textarea_body_care_past").value;
    let body_surgery_text = document.getElementById("Textarea_surgery_body").value;
    let body_middle = $("#body_middle").val();
    let body_hip = $("#body_hip").val();
    let body_right_thigh = $("#body_right_thigh").val();
    let body_left_thigh = $("#body_left_thigh").val();
    let body_right_knee = $("#body_right_knee").val();
    let body_left_knee = $("#body_left_knee").val();
    let body_right_ankle = $("#body_right_ankle").val();
    let body_left_ankle = $("#body_left_ankle").val();
    let body_date = $("#date_body_1").val();
    let body_products = $("#date_body_products_1").val();
    let body_middle_after = $("#body_middle_after").val();
    let body_hip_after = $("#body_hip_after").val();
    let body_right_thigh_after = $("#body_right_thigh_after").val();
    let body_left_thigh_after = $("#body_left_thigh_after").val();
    let body_right_knee_after= $("#body_right_knee_after").val();
    let body_left_knee_after = $("#body_left_knee_after").val();
    let body_right_ankle_after = $("#body_right_ankle_after").val();
    let body_left_ankle_after = $("#body_left_ankle_after").val();
    let body_comments = document.getElementById("Textarea_body_comms").value;
    let chbox = new Array();
    $("input[name='part']:checked").each(function () {
      if ($("#middle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#hip").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_thigh").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_thigh").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_knee").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_knee").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#right_ankle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#left_ankle").is(":checked")) {
        chbox.push($(this).val());
      } else if ($("#all").is(":checked")) {
        chbox.push($(this).val());
      } else {
        alert('Checkbox not checked!');
      }
    });
    console.log(chbox)
    console.log(body_type_text)
    if(body_type_text==""){
      alert("Δεν έχετε επιλέξει τύπο προβλήματος σώματος")
      //console.log(chbox)
    }else if(chbox==""){
      alert("Δεν έχετε επιλέξει τύπου σώματος")
    }else{
      $.ajax({
        url: 'server_spa.php',
        method: 'POST',
        data: {
          checker_update_body: 7.2,
          ajax_body_type_text: body_type_text,
          ajax_body_type_comms:body_type_comms ,
          ajax_body_care_text: body_care_text,
          ajax_body_care_past_text: body_care_past_text,
          ajax_body_surgery_text: body_surgery_text,
          ajax_body_middle: body_middle,
          ajax_body_hip:  body_hip,
          ajax_body_right_thigh: body_right_thigh,
          ajax_body_left_thigh: body_left_thigh ,
          ajax_body_right_knee: body_right_knee,
          ajax_body_left_knee: body_left_knee,
          ajax_body_right_ankle: body_right_ankle,
          ajax_body_left_ankle: body_left_ankle,
          ajax_body_middle_after: body_middle_after,
          ajax_body_hip_after: body_hip_after,
          ajax_body_right_thigh_after: body_right_thigh_after,
          ajax_body_left_thigh_after: body_left_thigh_after,
          ajax_body_right_knee_after: body_right_knee_after,
          ajax_body_left_knee_after: body_left_knee_after,
          ajax_body_right_ankle_after: body_right_ankle_after,
          ajax_body_left_ankle_after: body_left_ankle_after,
          ajax_body_date: body_date,
          ajax_body_products: body_products,
          ajax_body_comments: body_comments,
          ajax_checkboxes_value: chbox.toString()
        },
        success: function (response) {
          data = JSON.parse(response)
          console.log(data.response)
         if (data.response == "Update Body Data Completed") {
            alert("Ολοκληρώθηκε Η Ανανέωση Δεδομένων Στήθους.")
          } else if (data.response == "No available data for body") {
            alert("Δεν Έχει Ξαναγίνει Εγγραφή Δεδομένων Προσώπου.")
          }
        },
      })
    }
  })
  $("#show_face").click(function () {
    $("#form_face").toggle();
    $("#face_table").toggle();
    $("#form_breast").hide();
    $("#form_body").hide();
  });
  $("#show_breast").click(function () {
    $("#form_breast").toggle();
    $("#breast_table").toggle();
    $("#form_body").hide();
    $("#form_face").hide();
  });
  $("#show_body").click(function () {
    $("#form_body").toggle();
    $("#body_table").toggle();
    $("#form_breast").hide();
    $("#form_face").hide();
  });
  $("#show_data").click(function () {
    $("#face_table").toggle();
    $("#breast_table").toggle();
    $("#body_table").toggle();
  });
})
/* for (let i = 0; i < 2; i++) {
                // creates a table row
                let row = document.createElement("tr");
                // creates a table head
                let head = document.createElement("th");
for (let values in data) {
                  // Create a <td> element and a text node, make the text
                  // node the contents of the <td>, and put the <td> at
                  // the end of the table row
                  console.log(values);
                  if (i == 0){
                    let th =document.createElement("th");
                    let cellText = document.createTextNode(values);
                    th.appendChild(cellText);
                    
                    row.appendChild(th);
                    
                  }else{
                    let td = document.createElement("td");
                    let cellText = document.createTextNode(data[values]);
                    td.appendChild(cellText);
                    
                    row.appendChild(td);
                    
                  }
                }
                row.deleteCell(-1);
                // add the row to the end of the table body
                tblBody.appendChild(row);
              }
              // put the <tbody> in the <table>
              tbl.appendChild(tblBody);
              // appends <table> into <body>
              document.body.appendChild(tbl);
              // sets the border attribute of tbl to '2'
              tbl.setAttribute("border", "10");
              tbl.setAttribute("id", "main_table");} */