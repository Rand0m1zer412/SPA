CREATE TABLE personal_data_temp(
                            temp_id BIGINT(255) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            firstname VARCHAR(255) NOT NULL, 
                            lastname VARCHAR(255) NOT NULL, 
                            phone INT(10), 
                            next_appointment DATE
                            );

CREATE TABLE personal_data(id BIGINT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            afm BIGINT(100) NOT NULL,
                            temp_id BIGINT(255) NOT NULL ,
                            firstname VARCHAR(255) NOT NULL, 
                            lastname VARCHAR(255) NOT NULL, 
                            phone INT(10), 
                            next_appointment DATE, 
                            name_beautician VARCHAR(255) NOT NULL,
                            email VARCHAR(255) NOT NULL UNIQUE,
                            birthday DATE, 
                            Comments TEXT, 
                            body_part_treatment TEXT,
                            CONSTRAINT userid_ibfk_personal_data
                             FOREIGN KEY (temp_id) REFERENCES personal_data_temp(temp_id) ON DELETE CASCADE ON UPDATE CASCADE);


CREATE TABLE appointments(  appt_date DATE NOT NULL,
                            appt_time VARCHAR(255) NOT NULL,
                            phone INT(10) NOT NULL,
                            afm BIGINT(100) NOT NULL
                            CONSTRAINT userid_ibfk_appntms
                             FOREIGN KEY (phone) REFERENCES personal_data(phone) ON DELETE CASCADE ON UPDATE CASCADE);
ALTER TABLE appointments ADD PRIMARY KEY (appt_date,appt_time);

CREATE TABLE customer_health(id BIGINT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            users_id BIGINT(100) NOT NULL,
                            afm BIGINT(100) NOT NULL,
                            customer_email VARCHAR(255) NOT NULL,
                            height VARCHAR(255) NOT NULL, 
                            weight1 VARCHAR(255) NOT NULL, 
                            health VARCHAR(255) NOT NULL, 
                            health_text TEXT, 
                            sleep VARCHAR(255) NOT NULL, 
                            sleep_text TEXT,
                            appetite VARCHAR(255) NOT NULL, 
                            appetite_text TEXT,
                            diseases_text TEXT, 
                            meds_text TEXT , 
                            surgery_text TEXT,
                             CONSTRAINT userid_ibfk_health
                             FOREIGN KEY (users_id) REFERENCES personal_data(id) ON DELETE CASCADE ON UPDATE CASCADE
                            );

CREATE TABLE customer_habits(id BIGINT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            users_id BIGINT(100) NOT NULL,
                            afm BIGINT(100) NOT NULL,
                            appointment DATE NOT NULL,
                             smoking VARCHAR(255), 
                             dairy VARCHAR(255), 
                             drink VARCHAR(255), 
                             exercise VARCHAR(255), 
                             salt VARCHAR(255), 
                             water VARCHAR(255), 
                             sugar VARCHAR(255), 
                             digestive_tract VARCHAR(255), 
                             pregnacy_text VARCHAR(255), 
                             pregnacy_month VARCHAR(255), 
                             dermatosis_text VARCHAR(255), 
                             children_text VARCHAR(255), 
                             age_text VARCHAR(255), 
                             breast_feeding_text VARCHAR(255), 
                             menstruation_text VARCHAR(255), 
                             menstruation_time_text VARCHAR(255), 
                             menstruation_frequency_text VARCHAR(255), 
                             menopause_text VARCHAR(255), 
                             sex_life_text VARCHAR(255), 
                             birth_control_text VARCHAR(255), 
                             birth_control_2_text VARCHAR(255), 
                             CONSTRAINT userid_ibfk_habits
                             FOREIGN KEY (users_id) REFERENCES personal_data(id) ON DELETE CASCADE ON UPDATE CASCADE
                            );  

CREATE TABLE customer_body(
                            id BIGINT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            users_id BIGINT(100) NOT NULL,
                            afm BIGINT(100) NOT NULL,
                            appointment DATE NOT NULL,
                            body_type_text VARCHAR(255) NOT NULL,
                            body_type_comms TEXT,
                            body_care_text TEXT,
                            body_care_past_text TEXT,
                            body_surgery_text TEXT,
                            body_middle TEXT,
                            body_hip TEXT,
                            body_right_thigh TEXT,
                            body_left_thigh TEXT,
                            body_right_knee TEXT,
                            body_left_knee TEXT,
                            body_right_ankle TEXT,
                            body_left_ankle TEXT,
                            body_middle_after TEXT,
                            body_hip_after TEXT,
                            body_right_thigh_after TEXT,
                            body_left_thigh_after TEXT,
                            body_right_knee_after TEXT,
                            body_left_knee_after TEXT,
                            body_right_ankle_after TEXT,
                            body_left_ankle_after TEXT,
                            body_products TEXT,
                            body_comments TEXT,
                            checkboxes_value VARCHAR(255) NOT NULL,
                            CONSTRAINT userid_ibfk_body
                             FOREIGN KEY (users_id) REFERENCES personal_data(id) ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE customer_breast(id BIGINT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            users_id BIGINT(100) NOT NULL,
                            afm BIGINT(100) NOT NULL,
                            appointment DATE NOT NULL,
                            breast_type_text VARCHAR(255) NOT NULL, 
                            breast_data_text TEXT, 
                            breast_care_text TEXT,
                            breast_care_past_text TEXT,
                            surgery_breast_text TEXT,
                            distance_niple_other VARCHAR(255) NOT NULL,
                            distance_rniple_navel VARCHAR(255) NOT NULL,
                            distance_lniple_navel VARCHAR(255) NOT NULL,
                            breast_contour VARCHAR(255) NOT NULL,
                            date_breast_1 DATE,
                            date_products_1 VARCHAR(255) NOT NULL,
                            distance_niple_other_after VARCHAR(255) NOT NULL,
                            distance_rniple_navel_after VARCHAR(255) NOT NULL,
                            distance_lniple_navel_after VARCHAR(255) NOT NULL,
                            breast_contour_after VARCHAR(255) NOT NULL,
                            breast_products TEXT, 
                            breast_nutrition TEXT,
                            breast_comms TEXT ,
                            CONSTRAINT userid_ibfk_breast
                            FOREIGN KEY (users_id) REFERENCES personal_data(id) ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE customer_face(
                        id BIGINT(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        users_id BIGINT(100) NOT NULL,
                        afm BIGINT(100) NOT NULL,
                            appointment DATE NOT NULL,
                            face_type VARCHAR(255) NOT NULL,
                            face_type_text TEXT,
                            skin_description_text TEXT,
                            facial_text TEXT,
                            facial_past_text TEXT,
                            surgery_text TEXT, 
                            face_products TEXT , 
                            face_text TEXT ,
                            face_results_text TEXT,
                            face_therapy_text TEXT,
                            face_nutrution_text TEXT,
                            face_comms_text TEXT,
                            CONSTRAINT userid_ibfk_face
                             FOREIGN KEY (users_id) REFERENCES personal_data(id) ON DELETE CASCADE ON UPDATE CASCADE);


UPDATE personal_data 
JOIN customer_health ON personal_data.id=customer_health.users_id 
SET personal_data.firstname='kostaass',personal_data.lastname='ccccharemis',personal_data.email='ccccharemis@gmail.com', personal_data.phone='6975563221', personal_data.date_of_birth="04/09/1996", personal_data.Comments="TA PANTA OLA TA PINW OLA",customer_health.customer_email='ccccharemis@gmail.com'
WHERE personal_data.id=3 AND customer_health.users_id=3;
UPDATE customer_habits
JOIN personal_data ON personal_data.id=customer_habits.users_id
SET customer_habits.customer_email ='ccccharemis@gmail.com'
WHERE personal_data.id=3 AND customer_habits.users_id=3;
UPDATE customer_face
JOIN personal_data ON personal_data.id=customer_face.users_id
SET customer_face.customer_email ='ccccharemis@gmail.com'
WHERE personal_data.id=3 AND customer_face.users_id=3;
UPDATE customer_breast
JOIN personal_data ON personal_data.id=customer_breast.users_id
SET customer_breast.customer_email ='ccccharemis@gmail.com'
WHERE personal_data.id=3 AND customer_breast.users_id=3;
UPDATE customer_body
JOIN personal_data ON personal_data.id=customer_body.users_id
SET customer_body.customer_email ='ccccharemis@gmail.com'
WHERE personal_data.id=3 AND customer_body.users_id=3;