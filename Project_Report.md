# MEDI+ PATIENT MANAGEMENT SYSTEM

## **DATABASE DESIGN REPORT \- CA-2**

**Submitted by:** Delroy Pires & Nash Dsouza

**Roll No:** 20, 04

**Class:** FY MSC IT

**Subject:** Advanced Database Management Systems

**Date:** January 31, 2026

---

# **CERTIFICATE OF DECLARATION**

We, **Delroy Pires** and **Nash Dsouza**, declare that this project on **"Medi+ Patient Management System \- Database Design"** is our original work completed for CA-2 evaluation. All sources have been acknowledged.

**Signature:** \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_

**Date:** January 31, 2026

---

# **INDEX**

| Section                                    | Page |
| :----------------------------------------- | :--- |
| 1\. Requirement Gathering                  |      |
| 2\. Conceptual Design (E-R Diagram)        |      |
| 3\. Logical Design (Schemas & Constraints) |      |
| 4\. Schema Refinement (Normalization)      |      |
| 5\. Conclusion                             |      |
| 6\. Future Scope                           |      |
| 7\. Bibliography                           |      |

---

# **1\. REQUIREMENT GATHERING**

## **1.1 Problem Statement**

Healthcare facilities face challenges with:

- Manual patient record management causing data inconsistency
- Security risks from open registration systems
- Inefficient doctor-patient assignment tracking
- No audit trail for status changes (Admitted → Surgery → Discharged)
- Poor visibility for patients (assigned doctors, appointments, medical history)

## **1.2 Proposed Solution**

**Medi+ Patient Management System** provides:

- Centralized MySQL database with Laravel 12.0 framework
- IT-controlled account approval (no public signup for doctors)
- Role-based dashboards (Admin, Doctor, Patient)
- Real-time status updates reflected on both patient and doctor dashboards
- Complete audit trail for compliance

## **1.3 User Roles**

### **Patient:**

- **Registration:** Apply via contact form → IT approval → Email credentials → Login
- **Dashboard Access:** View personal details, assigned doctor, upcoming appointments, medical history, current status
- **Permissions:** Can edit mobile number and address only; Cannot edit name, DOB, gender, blood group (from verified documents)

### **Doctor:**

- **Account:** Pre-created by IT (employees only)
- **Dashboard Access:** View assigned patients, update patient status, create medical records, view schedule
- **Permissions:** Update status (Admitted/Surgery/Discharged), create medical records for assigned patients only

### **IT Admin:**

- **Dashboard Access:** Approve/reject account requests, create user accounts, assign doctors to patients
- **Permissions:** Full user management, cannot modify medical records (separation of duties)

## **1.4 System Workflow**

Patient Journey:

Landing Page → Click "Apply Now" → Fill Form (name, email, mobile, message) → IT Admin Approves → User \+ Patient Records Created → Email Sent with Credentials → Login → Dashboard

Doctor-Patient Interaction:

IT Admin Assigns Doctor to Patient → Both See Assignment → Doctor Updates Status → Patient Dashboard Reflects Change → Doctor Creates Medical Record → Patient Views in History

## **1.5 Data Requirements**

| Entity                     | Purpose              | Key Attributes                                             |
| :------------------------- | :------------------- | :--------------------------------------------------------- |
| Users                      | Login credentials    | id, name, email, password, role (admin/doctor/patient)     |
| Patients                   | Medical profile      | user_id, mobile, blood_group, dob, gender, address, status |
| Doctors                    | Professional details | user_id, specialization, department, license_number        |
| Account Requests           | Track applications   | name, email, mobile, status (pending/approved/rejected)    |
| Patient-Doctor Assignments | M:N relationship     | patient_id, doctor_id, assigned_date, is_active            |
| Medical Records            | Visit history        | patient_id, doctor_id, visit_date, diagnosis, treatment    |
| Appointments               | Scheduling           | patient_id, doctor_id, appointment_date, type, status      |
| Patient Status Logs        | Audit trail          | patient_id, old_status, new_status, changed_by, changed_at |

---

# **2\. CONCEPTUAL DESIGN**

## **2.1 Entity-Relationship Diagram**

**\[Insert E-R Diagram here using Draw.io/Lucidchart\]**

**Entities:** 8 entities (Users, Patients, Doctors, Account Requests, Patient-Doctor Assignments, Medical Records, Appointments, Patient Status Logs)

**Relationships:**

- User **HAS** Patient (1:1) \- via patients.user_id UNIQUE FK
- User **HAS** Doctor (1:1) \- via doctors.user_id UNIQUE FK
- Patient **ASSIGNED_TO** Doctor (M:N) \- via patient_doctor_assignments junction table
- Patient **HAS** Medical Records (1:N) \- via medical_records.patient_id FK
- Doctor **CREATES** Medical Records (1:N) \- via medical_records.doctor_id FK
- Patient **HAS** Appointments (1:N) \- via appointments.patient_id FK
- Doctor **HAS** Appointments (1:N) \- via appointments.doctor_id FK
- Patient **HAS** Status Logs (1:N) \- via patient_status_logs.patient_id FK

**Key Attributes:**

- Primary Keys: id (auto-increment) in all tables
- Foreign Keys: Arrow notation (→) showing references
- Unique Constraints: email, license_number, user_id in patients/doctors

---

# **3\. LOGICAL DESIGN**

## **3.1 Relational Schemas**

### **USERS**

Plaintext

USERS(id, name, email UNIQUE, password, role, created_at, updated_at)

Constraints:  
\- PRIMARY KEY (id)  
\- UNIQUE (email)  
\- CHECK (role IN ('admin', 'doctor', 'patient'))  
\- NOT NULL (name, email, password, role)

### **PATIENTS**

Plaintext

PATIENTS(id, user_id UNIQUE → USERS(id), mobile_number, blood_group,  
 dob, gender, address, status, admission_date, last_visited_date,  
 emergency_contact_name, emergency_contact_number, created_at, updated_at)

Constraints:  
\- PRIMARY KEY (id)  
\- FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE  
\- UNIQUE (user_id)  
\- CHECK (blood_group IN ('A+','A-','B+','B-','AB+','AB-','O+','O-'))  
\- CHECK (LENGTH(mobile_number) \= 10\)  
\- CHECK (dob \< CURRENT_DATE)  
\- NOT NULL (user_id, mobile_number, blood_group, dob, gender, status)

### **DOCTORS**

Plaintext

DOCTORS(id, user_id UNIQUE → USERS(id), specialization, department,  
 license_number UNIQUE, qualification, years_of_experience,  
 consultation_hours, created_at, updated_at)

Constraints:  
\- PRIMARY KEY (id)  
\- FOREIGN KEY (user_id) REFERENCES USERS(id) ON DELETE CASCADE  
\- UNIQUE (user_id, license_number)  
\- CHECK (years_of_experience \>= 0\)

### **ACCOUNT_REQUESTS**

Plaintext

ACCOUNT_REQUESTS(id, name, email, mobile_number, message, status,  
 requested_role, reviewed_by → USERS(id), reviewed_at,  
 rejection_reason, created_at, updated_at)

Constraints:  
\- PRIMARY KEY (id)  
\- FOREIGN KEY (reviewed_by) REFERENCES USERS(id) ON DELETE SET NULL  
\- CHECK (status IN ('pending','approved','rejected'))  
\- CHECK (LENGTH(mobile_number) \= 10\)

### **PATIENT_DOCTOR_ASSIGNMENTS**

Plaintext

PATIENT_DOCTOR_ASSIGNMENTS(id, patient_id → PATIENTS(id),  
 doctor_id → DOCTORS(id), assigned_date,  
 unassigned_date, is_active, assigned_by → USERS(id),  
 notes, created_at, updated_at)

Constraints:  
\- PRIMARY KEY (id)  
\- FOREIGN KEY (patient_id) REFERENCES PATIENTS(id) ON DELETE CASCADE  
\- FOREIGN KEY (doctor_id) REFERENCES DOCTORS(id) ON DELETE CASCADE  
\- UNIQUE (patient_id, doctor_id, is_active) WHERE is_active \= TRUE

### **MEDICAL_RECORDS**

Plaintext

MEDICAL_RECORDS(id, patient_id → PATIENTS(id), doctor_id → DOCTORS(id),  
 visit_date, symptoms, diagnosis, treatment, notes,  
 created_by → USERS(id), created_at, updated_at)

Constraints:  
\- PRIMARY KEY (id)  
\- FOREIGN KEY (patient_id) REFERENCES PATIENTS(id) ON DELETE RESTRICT  
\- FOREIGN KEY (doctor_id) REFERENCES DOCTORS(id) ON DELETE RESTRICT  
\- CHECK (visit_date \<= CURRENT_TIMESTAMP)

### **APPOINTMENTS**

Plaintext

APPOINTMENTS(id, patient_id → PATIENTS(id), doctor_id → DOCTORS(id),  
 appointment_date, appointment_type, status, reason, notes,  
 created_by → USERS(id), created_at, updated_at)

Constraints:  
\- PRIMARY KEY (id)  
\- FOREIGN KEY (patient_id) REFERENCES PATIENTS(id) ON DELETE CASCADE  
\- FOREIGN KEY (doctor_id) REFERENCES DOCTORS(id) ON DELETE RESTRICT  
\- CHECK (appointment_type IN ('checkup','followup','emergency'))  
\- UNIQUE (doctor_id, appointment_date) WHERE status \= 'scheduled'

### **PATIENT_STATUS_LOGS**

Plaintext

PATIENT_STATUS_LOGS(id, patient_id → PATIENTS(id), old_status,  
 new_status, changed_by → USERS(id), changed_at,  
 reason, created_at)

Constraints:  
\- PRIMARY KEY (id)  
\- FOREIGN KEY (patient_id) REFERENCES PATIENTS(id) ON DELETE CASCADE  
\- CHECK (old_status \!= new_status)

## **3.2 Integrity Constraints Summary**

**Referential Integrity:**

- **CASCADE:** Users → Patients/Doctors (deleting user deletes profile)
- **RESTRICT:** Patients/Doctors → Medical Records (cannot delete if records exist \- legal retention)
- **SET NULL:** Users → Account Requests (if admin deleted, reviewed_by becomes NULL)

**Domain Constraints:**

- Email format validation (application layer)
- Mobile number exactly 10 digits
- Blood group from valid set
- DOB must be past date
- Appointment date must be future date

**Business Rules:**

- No duplicate active assignments (same patient \+ doctor \+ is_active=TRUE)
- No double-booking (same doctor \+ appointment_date for scheduled appointments)
- Patient can edit mobile/address only
- Doctor can update status for assigned patients only

---

# **4\. SCHEMA REFINEMENT (NORMALIZATION)**

## **4.1 First Normal Form (1NF)**

**Definition:** All attributes atomic, no repeating groups

**PATIENTS Table \- 1NF Violation (Original Design):**

Plaintext

❌ PATIENTS(id, user_id, mobile, blood_group, dob, address,  
 medical_history, status)

Problem: medical_history \= "2024-01-15: Diabetes diagnosed by Dr. Smith.  
2024-03-10: Follow-up checkup..."  
\- Non-atomic (contains multiple visit records)  
\- Cannot query by visit date or doctor

**1NF Normalization:**

Plaintext

✅ PATIENTS(id, user_id, mobile, blood_group, dob, address, status)  
✅ MEDICAL_RECORDS(id, patient_id, doctor_id, visit_date, diagnosis, treatment)

Each medical visit \= separate row (atomic)

**Result:** All tables now in 1NF (atomic values, no repeating groups)

## **4.2 Second Normal Form (2NF)**

**Definition:** In 1NF \+ no partial dependencies (all non-key attributes depend on entire primary key)

Analysis:

All tables use single-column primary key (id), so automatically in 2NF (no composite keys \= no partial dependencies possible)

**Example if we used composite key:**

Plaintext

❌ PATIENT_DOCTOR_ASSIGNMENTS(patient_id, doctor_id, assigned_date,  
 patient_name, doctor_specialization)

Partial Dependencies:  
\- patient_name depends only on patient_id (not on doctor_id or date)  
\- doctor_specialization depends only on doctor_id

✅ Solution: Store patient_name in PATIENTS, doctor_specialization in DOCTORS

**Result:** All tables in 2NF

## **4.3 Third Normal Form (3NF)**

**Definition:** In 2NF \+ no transitive dependencies (no non-key attribute determines another non-key attribute)

**PATIENTS Table \- 3NF Check:**

Plaintext

Functional Dependencies:  
\- id → user_id, mobile, blood_group, dob, gender, address, status

Transitive Dependency Check:  
\- Does user_id → name, email? YES, but stored in USERS table (proper design)  
\- Does status → discharge_date? NO (status doesn't determine specific date)  
\- Does blood_group → blood_type_description? Could, but not stored

No transitive dependencies within PATIENTS table ✅

**Example of 3NF Violation (Avoided):**

Plaintext

❌ DOCTORS(id, specialization, department, dept_head_name)

Transitive: department → dept_head_name  
(department determines head, not doctor_id)

✅ Normalize:  
DOCTORS(id, specialization, department_id → DEPARTMENTS)  
DEPARTMENTS(id, name, head_name)

**Result:** All tables in 3NF

## **4.4 Boyce-Codd Normal Form (BCNF)**

**Definition:** In 3NF \+ for every dependency X → Y, X must be superkey

Analysis:

All tables have single candidate key (id), so all dependencies are of form:

- id → all other attributes

Since id is a superkey, **all tables automatically in BCNF** ✅

**USERS Table:**

- Candidate keys: id, email (both unique)
- id → name, email, password, role ✅ (id is superkey)
- email → id, name, password, role ✅ (email is candidate key, hence superkey)

**Result:** All tables in BCNF

## **4.5 Normalization Summary Table**

| Table                      | 1NF | 2NF | 3NF | BCNF | Key Change                                   |
| :------------------------- | :-- | :-- | :-- | :--- | :------------------------------------------- |
| USERS                      | ✅  | ✅  | ✅  | ✅   | Atomic attributes, email unique              |
| PATIENTS                   | ✅  | ✅  | ✅  | ✅   | Extracted medical_history to MEDICAL_RECORDS |
| DOCTORS                    | ✅  | ✅  | ✅  | ✅   | Specialization & department independent      |
| ACCOUNT_REQUESTS           | ✅  | ✅  | ✅  | ✅   | Each request atomic                          |
| PATIENT_DOCTOR_ASSIGNMENTS | ✅  | ✅  | ✅  | ✅   | Junction table, proper M:N                   |
| MEDICAL_RECORDS            | ✅  | ✅  | ✅  | ✅   | Resolves patients.medical_history issue      |
| APPOINTMENTS               | ✅  | ✅  | ✅  | ✅   | Patient/doctor info via FK                   |
| PATIENT_STATUS_LOGS        | ✅  | ✅  | ✅  | ✅   | Audit log, immutable                         |

**Conclusion:** All tables achieve **3NF and BCNF**, ensuring data integrity and minimal redundancy.

---

# **5\. CONCLUSION**

The Medi+ Patient Management System database design successfully addresses healthcare facility challenges through:

**Achievements:**

- ✅ **Comprehensive Design:** 8 normalized tables supporting patient-doctor workflows
- ✅ **Security:** IT-controlled registration, role-based access, password hashing
- ✅ **Data Integrity:** CHECK constraints, foreign keys with appropriate cascades, UNIQUE constraints
- ✅ **Normalization:** All tables in 3NF/BCNF (eliminated redundancy, update anomalies)
- ✅ **Auditability:** PATIENT_STATUS_LOGS for compliance, timestamps on all tables
- ✅ **Scalability:** Indexed foreign keys, efficient JOINs through proper normalization

**Business Value:**

- Patients: Secure medical history access, appointment visibility
- Doctors: Centralized patient management, status updates
- Admins: Streamlined approval workflow, system-wide control
- Facility: Reduced errors, GDPR compliance, audit trails

**Technical Highlights:**

- Laravel 12.0 \+ MySQL with custom responsive UI
- Critical 1NF fix: medical_history text blob → MEDICAL_RECORDS table
- M:N patient-doctor relationship via junction table
- Bidirectional visibility (status updates reflect on both dashboards)

**Implementation Status:**

- ✅ **Authentication:** Role-based login system (Admin, Doctor, Patient portals)
- ✅ **CRUD Operations:** Functional forms for status updates, medical records, doctor management
- ✅ **Audit Trail:** PATIENT_STATUS_LOGS captures all status changes with timestamps
- ✅ **Account Workflow:** Contact form → Admin approval/rejection → Account creation
- ✅ **Data Deletion:** Patients can request account deletion (GDPR compliance)

The system is fully functional with complete GUI implementation.

---

# **6\. FUTURE SCOPE**

**Database Enhancements:**

1. **Triggers:**
    - Auto-notification on status change (email/SMS alerts)
    - Update last_visited_date on medical record insert
    - Deactivate assignments on patient discharge
2. **Views:**
    - active_patients_view \- Admitted/Surgery patients with assigned doctors
    - doctor_workload_view \- Patient count, upcoming appointments per doctor
    - pending_approvals_view \- Account requests waiting for IT review
3. **Stored Procedures:**
    - discharge_patient(patient_id, discharge_notes) \- Complete discharge process
    - generate_monthly_report(month, year) \- Statistics aggregation

**Feature Additions:**

- Prescription management module with medication tracking
- Lab results integration (blood tests, X-rays)
- Billing and insurance claims
- Mobile app with push notifications for appointment reminders
- Telemedicine video consultation integration
- Patient appointment booking (self-service)

**Security Enhancements:**

- Two-factor authentication (2FA)
- Encrypted medical records at rest
- Session timeout and activity logging
- Password reset via email verification

---

# **7\. BIBLIOGRAPHY**

1. **Laravel Documentation (v12.x)** \- Database Migrations & Eloquent ORM  
   [https://laravel.com/docs/12.x/migrations](https://laravel.com/docs/12.x/migrations)
2. **Elmasri & Navathe** \- "Fundamentals of Database Systems" (7th Edition)  
   Chapter 7: Relational Database Design, Chapter 14: Normalization
3. **Silberschatz, Korth, Sudarshan** \- "Database System Concepts" (7th Edition)  
   Chapter 8: ER Model, Chapter 9: Normalization
4. **Bootstrap Documentation (v5.3.8)** \- Forms, Tables, Cards  
   [https://getbootstrap.com/docs/5.3/](https://getbootstrap.com/docs/5.3/)
5. **MySQL 8.0 Reference Manual** \- Data Types, Constraints, Indexes  
   [https://dev.mysql.com/doc/refman/8.0/en/](https://dev.mysql.com/doc/refman/8.0/en/)
6. **PHP.net** \- PDO & MySQLi for database connectivity  
   [https://www.php.net/manual/en/book.pdo.php](https://www.php.net/manual/en/book.pdo.php)
7. **W3Schools** \- SQL Normalization Tutorial  
   [https://www.w3schools.com/sql/sql_normalization.asp](https://www.w3schools.com/sql/sql_normalization.asp)

---

**END OF REPORT**

---
