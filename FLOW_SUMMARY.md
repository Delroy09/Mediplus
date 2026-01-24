# Medi+ Patient Management System - Complete Flow

## Database Structure (3NF - Simple & Manageable)

### Core Tables (8):

1. **users** - Authentication (admin, doctor, patient)
2. **patients** - Patient details (1:1 with users)
3. **doctors** - Doctor details (1:1 with users)
4. **account_requests** - Contact form submissions
5. **patient_doctor_assignments** - M:N relationship (patient ↔ doctor)
6. **appointments** - Patient appointments with doctors
7. **medical_records** - Patient medical history
8. **patient_status_logs** - Audit trail for status changes

### System Tables (auto-managed by Laravel):

- migrations, cache, cache_locks, sessions, password_reset_tokens

---

## Complete User Flow

### 1. **Public User → Account Request**

**Route:** `/contact` (GET + POST)

- User fills contact form (name, email, mobile, message)
- Form validates and saves to `account_requests` table
- Status = 'pending', requested_role = 'patient'
- Success message: "Request submitted, wait for email"

**Files:**

- View: `resources/views/contact.blade.php`
- Controller: `app/Http/Controllers/ContactController.php`
- Model: `app/Models/AccountRequest.php`

---

### 2. **Admin → Review Requests**

**Route:** `/admin/dashboard` (GET)

- Admin views pending account_requests
- Two actions: **Approve** or **Reject**

#### **Approve Flow:**

**Route:** `/admin/approve/{id}` (POST)

1. Create User in `users` table (email, password='password', role='patient')
2. Create Patient in `patients` table (user_id, mobile, defaults for blood_group/dob/address)
3. Update request: status='approved', reviewed_by=admin_id, reviewed_at=now()
4. Transaction ensures all-or-nothing

#### **Reject Flow:**

**Route:** `/admin/reject/{id}` (POST)

1. Modal asks for rejection_reason
2. Update request: status='rejected', reviewed_by=admin_id, reviewed_at=now(), rejection_reason

**Files:**

- View: `resources/views/admin/dashboard.blade.php`
- Controller: `app/Http/Controllers/AdminController.php`

---

### 3. **Patient → Login & Dashboard**

**Route:** `/patient/dashboard` (GET)

- Patient logs in (TODO: implement auth)
- Views own info: name, DOB, gender, blood group, status
- Views appointments with doctors
- Can update profile, manage account

**Files:**

- Views: `resources/views/patient/*.blade.php`
- Controller: `app/Http/Controllers/PatientController.php`
- Model: `app/Models/Patient.php`

---

### 4. **Doctor → Dashboard**

**Route:** `/doctor/dashboard` (GET)

- Doctor views assigned patients
- Stats: active patients, appointments today, total records
- Can view patient details, update status, create medical records
- Schedule view shows all appointments

**Files:**

- Views: `resources/views/doctor/*.blade.php`
- Controller: `app/Http/Controllers/DoctorController.php`
- Model: `app/Models/Doctor.php`

---

## Normalization: **3NF (Recommended)**

### Why 3NF (not BCNF)?

✅ **Current structure already in 3NF:**

- No transitive dependencies
- All non-key attributes depend only on primary key

❌ **BCNF would require:**

- Splitting `emergency_contact_name` + `emergency_contact_number` into separate table
- Possibly extracting `status` into separate table (but `patient_status_logs` already exists)
- More joins = slower queries for small dataset (12 patients)

### 3NF is Perfect Because:

1. **Simple** - Easy to understand and implement
2. **Performant** - Fewer joins for dashboards
3. **Manageable** - Academic project scope (not production scale)
4. **Professor-approved** - CA-2 report accepted this design

---

## Test Accounts (password: "password")

### Admin:

- **Email:** admin@mediplus.com
- **Access:** `/admin/dashboard`

### Doctors (10):

- priya.sharma@mediplus.com (Cardiology)
- arjun.menon@mediplus.com (Neurology)
- kavita.reddy@mediplus.com (Orthopedics)
- ... (7 more)

### Patients (12):

- nash.dsouza@gmail.com (Discharged)
- ananya.iyer@gmail.com (Admitted)
- kabir.singh@gmail.com (Surgery)
- ... (9 more)

---

## Quick Commands

### Setup (New System):

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

### Testing Flow:

1. Visit `http://localhost:8000/contact` → Submit request
2. Visit `http://localhost:8000/admin/dashboard` → Approve/Reject
3. Visit `http://localhost:8000/patient/dashboard` → View patient info
4. Visit `http://localhost:8000/doctor/dashboard` → View doctor dashboard

---

## Next Steps (Optional Enhancements):

### High Priority:

- [ ] Implement authentication (Laravel Breeze)
- [ ] Make CRUD forms functional (update profile, create records)
- [ ] Add role-based middleware

### Medium Priority:

- [ ] Email notifications on approval/rejection
- [ ] Patient can book appointments
- [ ] Doctor can update patient status (with status_log entry)

### Low Priority:

- [ ] Admin can manage users directly
- [ ] Dashboard charts/graphs
- [ ] Export patient data as PDF

---

## Database Seeder Data:

- 1 admin
- 10 doctors (varied specializations)
- 12 patients (diverse demographics)
- 12 patient-doctor assignments
- 15 medical records
- 18 appointments (past & future)
- 10 status logs
- 12 account requests (pending/approved/rejected mix)

---

**Current Status:** ✅ Core flow complete, database seeded, dashboards functional
**Normalization:** ✅ 3NF achieved, simple & manageable
**Ready for:** PA-3 submission (Feb 15, 2026)
