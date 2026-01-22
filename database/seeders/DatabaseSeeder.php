<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\PatientDoctorAssignment;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\PatientStatusLog;
use App\Models\AccountRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Rajesh Kumar',
            'email' => 'admin@mediplus.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create 10 Doctors
        $doctors = [];

        $doctorData = [
            ['name' => 'Dr. Priya Sharma', 'email' => 'priya.sharma@mediplus.com', 'spec' => 'Cardiology', 'dept' => 'Cardiovascular Medicine', 'license' => 'MCI-2015-45678', 'qual' => 'MBBS, MD (Cardiology), FACC', 'exp' => 12, 'hours' => 'Mon-Fri: 9:00 AM - 5:00 PM'],
            ['name' => 'Dr. Arjun Menon', 'email' => 'arjun.menon@mediplus.com', 'spec' => 'Neurology', 'dept' => 'Neurosciences', 'license' => 'MCI-2018-89012', 'qual' => 'MBBS, MD (Neurology), DM', 'exp' => 8, 'hours' => 'Mon-Sat: 10:00 AM - 4:00 PM'],
            ['name' => 'Dr. Kavita Reddy', 'email' => 'kavita.reddy@mediplus.com', 'spec' => 'Orthopedics', 'dept' => 'Orthopedic Surgery', 'license' => 'MCI-2016-67890', 'qual' => 'MBBS, MS (Orthopedics)', 'exp' => 10, 'hours' => 'Mon-Fri: 8:00 AM - 3:00 PM'],
            ['name' => 'Dr. Sanjay Gupta', 'email' => 'sanjay.gupta@mediplus.com', 'spec' => 'Pediatrics', 'dept' => 'Child Health', 'license' => 'MCI-2019-12345', 'qual' => 'MBBS, MD (Pediatrics)', 'exp' => 6, 'hours' => 'Mon-Sat: 9:00 AM - 6:00 PM'],
            ['name' => 'Dr. Meera Patel', 'email' => 'meera.patel@mediplus.com', 'spec' => 'Dermatology', 'dept' => 'Skin & Cosmetology', 'license' => 'MCI-2017-54321', 'qual' => 'MBBS, MD (Dermatology)', 'exp' => 9, 'hours' => 'Tue-Sat: 10:00 AM - 5:00 PM'],
            ['name' => 'Dr. Vikram Singh', 'email' => 'vikram.singh@mediplus.com', 'spec' => 'General Surgery', 'dept' => 'Surgical Services', 'license' => 'MCI-2014-98765', 'qual' => 'MBBS, MS (Surgery), FRCS', 'exp' => 15, 'hours' => 'Mon-Fri: 7:00 AM - 4:00 PM'],
            ['name' => 'Dr. Anjali Nair', 'email' => 'anjali.nair@mediplus.com', 'spec' => 'Gynecology', 'dept' => 'Women\'s Health', 'license' => 'MCI-2018-24680', 'qual' => 'MBBS, MD (OB/GYN)', 'exp' => 7, 'hours' => 'Mon-Sat: 9:00 AM - 5:00 PM'],
            ['name' => 'Dr. Rahul Verma', 'email' => 'rahul.verma@mediplus.com', 'spec' => 'Radiology', 'dept' => 'Diagnostic Imaging', 'license' => 'MCI-2016-13579', 'qual' => 'MBBS, MD (Radiology)', 'exp' => 11, 'hours' => 'Mon-Fri: 8:00 AM - 6:00 PM'],
            ['name' => 'Dr. Deepa Iyer', 'email' => 'deepa.iyer@mediplus.com', 'spec' => 'Ophthalmology', 'dept' => 'Eye Care', 'license' => 'MCI-2019-86420', 'qual' => 'MBBS, MS (Ophthalmology)', 'exp' => 5, 'hours' => 'Tue-Sat: 10:00 AM - 6:00 PM'],
            ['name' => 'Dr. Amit Khanna', 'email' => 'amit.khanna@mediplus.com', 'spec' => 'ENT', 'dept' => 'Ear, Nose & Throat', 'license' => 'MCI-2017-11223', 'qual' => 'MBBS, MS (ENT)', 'exp' => 8, 'hours' => 'Mon-Fri: 9:00 AM - 4:00 PM'],
        ];

        foreach ($doctorData as $data) {
            $doctorUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'doctor',
            ]);

            $doctors[] = Doctor::create([
                'user_id' => $doctorUser->id,
                'specialization' => $data['spec'],
                'department' => $data['dept'],
                'license_number' => $data['license'],
                'qualification' => $data['qual'],
                'years_of_experience' => $data['exp'],
                'consultation_hours' => $data['hours'],
            ]);
        }

        // Create 12 Patients
        $patients = [];

        $patientData = [
            ['name' => 'Nash Dsouza', 'email' => 'nash.dsouza@gmail.com', 'mobile' => '9876543210', 'blood' => 'O+', 'dob' => '2003-12-31', 'gender' => 'male', 'address' => 'Flat 204, Sunset Apartments, Bandra West, Mumbai - 400050', 'status' => 'Discharged', 'admission' => '2025-12-15 08:30:00', 'last_visit' => '2026-01-15', 'ec_name' => 'Maria Dsouza', 'ec_number' => '9876543211'],
            ['name' => 'Ananya Iyer', 'email' => 'ananya.iyer@gmail.com', 'mobile' => '9123456789', 'blood' => 'A+', 'dob' => '1998-05-22', 'gender' => 'female', 'address' => 'C-45, Green Valley Society, Koramangala, Bangalore - 560034', 'status' => 'Admitted', 'admission' => '2026-01-10 14:00:00', 'last_visit' => '2026-01-20', 'ec_name' => 'Lakshmi Iyer', 'ec_number' => '9123456788'],
            ['name' => 'Kabir Singh', 'email' => 'kabir.singh@gmail.com', 'mobile' => '9988776655', 'blood' => 'B+', 'dob' => '1985-08-14', 'gender' => 'male', 'address' => '12/A, Model Town Extension, Civil Lines, Delhi - 110054', 'status' => 'Surgery', 'admission' => '2026-01-18 11:00:00', 'last_visit' => '2026-01-21', 'ec_name' => 'Simran Kaur', 'ec_number' => '9988776656'],
            ['name' => 'Shreya Nambiar', 'email' => 'shreya.nambiar@gmail.com', 'mobile' => '9445566778', 'blood' => 'AB+', 'dob' => '1992-03-18', 'gender' => 'female', 'address' => '78, MG Road, Kochi, Kerala - 682016', 'status' => 'Admitted', 'admission' => '2026-01-12 09:00:00', 'last_visit' => '2026-01-19', 'ec_name' => 'Ramesh Nambiar', 'ec_number' => '9445566779'],
            ['name' => 'Rohan Malhotra', 'email' => 'rohan.malhotra@gmail.com', 'mobile' => '9112233445', 'blood' => 'O-', 'dob' => '2000-11-05', 'gender' => 'male', 'address' => 'B-102, Palm Heights, Andheri East, Mumbai - 400069', 'status' => 'Discharged', 'admission' => '2025-12-20 15:00:00', 'last_visit' => '2026-01-08', 'ec_name' => 'Kavita Malhotra', 'ec_number' => '9112233446'],
            ['name' => 'Priya Chatterjee', 'email' => 'priya.chatterjee@gmail.com', 'mobile' => '9334455667', 'blood' => 'A-', 'dob' => '1995-07-12', 'gender' => 'female', 'address' => '34/2, Salt Lake, Sector V, Kolkata - 700091', 'status' => 'Admitted', 'admission' => '2026-01-15 10:30:00', 'last_visit' => '2026-01-21', 'ec_name' => 'Amit Chatterjee', 'ec_number' => '9334455668'],
            ['name' => 'Aditya Rao', 'email' => 'aditya.rao@gmail.com', 'mobile' => '9556677889', 'blood' => 'B-', 'dob' => '1988-02-28', 'gender' => 'male', 'address' => '15, Richmond Road, Bangalore - 560025', 'status' => 'Discharged', 'admission' => '2025-11-20 08:00:00', 'last_visit' => '2025-12-15', 'ec_name' => 'Sunita Rao', 'ec_number' => '9556677890'],
            ['name' => 'Neha Kapoor', 'email' => 'neha.kapoor@gmail.com', 'mobile' => '9778899001', 'blood' => 'AB-', 'dob' => '1997-09-30', 'gender' => 'female', 'address' => '23, Connaught Place, New Delhi - 110001', 'status' => 'Surgery', 'admission' => '2026-01-17 13:00:00', 'last_visit' => '2026-01-20', 'ec_name' => 'Rajesh Kapoor', 'ec_number' => '9778899002'],
            ['name' => 'Arjun Pillai', 'email' => 'arjun.pillai@gmail.com', 'mobile' => '9990011223', 'blood' => 'O+', 'dob' => '1990-06-15', 'gender' => 'male', 'address' => '56, Panjim Market, Goa - 403001', 'status' => 'Admitted', 'admission' => '2026-01-14 11:00:00', 'last_visit' => '2026-01-21', 'ec_name' => 'Maya Pillai', 'ec_number' => '9990011224'],
            ['name' => 'Divya Reddy', 'email' => 'divya.reddy@gmail.com', 'mobile' => '9001122334', 'blood' => 'A+', 'dob' => '1993-04-20', 'gender' => 'female', 'address' => '12, Jubilee Hills, Hyderabad - 500033', 'status' => 'Discharged', 'admission' => '2025-12-05 14:00:00', 'last_visit' => '2025-12-25', 'ec_name' => 'Venkat Reddy', 'ec_number' => '9001122335'],
            ['name' => 'Vikram Desai', 'email' => 'vikram.desai@gmail.com', 'mobile' => '9223344556', 'blood' => 'B+', 'dob' => '1987-01-10', 'gender' => 'male', 'address' => '89, Law Garden, Ahmedabad - 380009', 'status' => 'Admitted', 'admission' => '2026-01-16 09:30:00', 'last_visit' => '2026-01-21', 'ec_name' => 'Nisha Desai', 'ec_number' => '9223344557'],
            ['name' => 'Sanya Malhotra', 'email' => 'sanya.malhotra@gmail.com', 'mobile' => '9445566778', 'blood' => 'O-', 'dob' => '1999-12-01', 'gender' => 'female', 'address' => '45, Sector 18, Noida - 201301', 'status' => 'Discharged', 'admission' => '2025-12-28 10:00:00', 'last_visit' => '2026-01-12', 'ec_name' => 'Suresh Malhotra', 'ec_number' => '9445566779'],
        ];

        foreach ($patientData as $data) {
            $patientUser = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'patient',
            ]);

            $patients[] = Patient::create([
                'user_id' => $patientUser->id,
                'mobile_number' => $data['mobile'],
                'blood_group' => $data['blood'],
                'dob' => $data['dob'],
                'gender' => $data['gender'],
                'address' => $data['address'],
                'admission_date' => $data['admission'],
                'status' => $data['status'],
                'last_visited_date' => $data['last_visit'],
                'emergency_contact_name' => $data['ec_name'],
                'emergency_contact_number' => $data['ec_number'],
            ]);
        }

        // Create 12 Patient-Doctor Assignments (each patient gets at least 1 doctor)
        foreach ($patients as $index => $patient) {
            $doctor = $doctors[$index % count($doctors)]; // Distribute patients evenly
            PatientDoctorAssignment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'assigned_date' => Carbon::now()->subDays(rand(5, 30)),
                'is_active' => true,
                'assigned_by' => $admin->id,
                'notes' => 'Initial assignment for treatment',
            ]);
        }

        // Create 15 Medical Records
        $symptoms = [
            'Chest pain, shortness of breath',
            'Persistent headache, dizziness',
            'Abdominal pain, nausea',
            'Joint pain in knees',
            'High fever, cough',
            'Back pain, muscle stiffness',
            'Skin rash, itching',
            'Vision problems, eye strain',
            'Ear pain, hearing difficulty',
            'Sore throat, difficulty swallowing',
        ];

        for ($i = 0; $i < 15; $i++) {
            $patient = $patients[$i % count($patients)];
            $doctor = $doctors[$i % count($doctors)];

            MedicalRecord::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'visit_date' => Carbon::now()->subDays(rand(1, 60))->format('Y-m-d H:i:s'),
                'symptoms' => $symptoms[$i % count($symptoms)],
                'diagnosis' => 'Diagnosis for case ' . ($i + 1),
                'treatment' => 'Prescribed medication and rest. Follow-up in 2 weeks.',
                'notes' => 'Patient responded well to initial treatment.',
                'created_by' => $doctor->user_id,
            ]);
        }

        // Create 18 Appointments
        $appointmentTypes = ['checkup', 'followup', 'emergency'];
        $statuses = ['scheduled', 'completed', 'cancelled'];

        for ($i = 0; $i < 18; $i++) {
            $patient = $patients[$i % count($patients)];
            $doctor = $doctors[$i % count($doctors)];

            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'appointment_date' => Carbon::now()->addDays(rand(-10, 30))->format('Y-m-d H:i:s'),
                'appointment_type' => $appointmentTypes[$i % count($appointmentTypes)],
                'status' => $statuses[$i % count($statuses)],
                'reason' => 'Appointment for follow-up and checkup',
                'notes' => $i % 2 == 0 ? 'Bring previous reports' : null,
                'created_by' => $doctor->user_id,
            ]);
        }

        // Create 10 Patient Status Logs
        for ($i = 0; $i < 10; $i++) {
            $patient = $patients[$i];
            $doctor = $doctors[$i % count($doctors)];

            $oldStatus = ['Admitted', 'Surgery'][$i % 2];
            $newStatus = ['Surgery', 'Discharged'][$i % 2];

            PatientStatusLog::create([
                'patient_id' => $patient->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'changed_by' => $doctor->user_id,
                'changed_at' => Carbon::now()->subDays(rand(1, 20)),
                'reason' => 'Status updated based on patient condition',
            ]);
        }

        // Create 12 Account Requests
        $accountRequestData = [
            ['name' => 'Ravi Kumar', 'email' => 'ravi.kumar@gmail.com', 'mobile' => '9111222333', 'message' => 'Need consultation for diabetes', 'status' => 'pending'],
            ['name' => 'Sneha Gupta', 'email' => 'sneha.gupta@gmail.com', 'mobile' => '9444555666', 'message' => 'Request for cardiac check-up', 'status' => 'approved'],
            ['name' => 'Manish Sharma', 'email' => 'manish.sharma@gmail.com', 'mobile' => '9777888999', 'message' => 'Orthopedic consultation needed', 'status' => 'rejected'],
            ['name' => 'Pooja Singh', 'email' => 'pooja.singh@gmail.com', 'mobile' => '9222333444', 'message' => 'Dermatology appointment request', 'status' => 'pending'],
            ['name' => 'Rahul Verma', 'email' => 'rahul.v@gmail.com', 'mobile' => '9555666777', 'message' => 'Eye check-up needed urgently', 'status' => 'approved'],
            ['name' => 'Nisha Patel', 'email' => 'nisha.patel@gmail.com', 'mobile' => '9888999000', 'message' => 'Gynecology consultation', 'status' => 'pending'],
            ['name' => 'Amit Jain', 'email' => 'amit.jain@gmail.com', 'mobile' => '9333444555', 'message' => 'General check-up', 'status' => 'rejected'],
            ['name' => 'Kavita Nair', 'email' => 'kavita.nair@gmail.com', 'mobile' => '9666777888', 'message' => 'Pediatric consultation for child', 'status' => 'approved'],
            ['name' => 'Suresh Reddy', 'email' => 'suresh.reddy@gmail.com', 'mobile' => '9999000111', 'message' => 'ENT specialist needed', 'status' => 'pending'],
            ['name' => 'Deepika Roy', 'email' => 'deepika.roy@gmail.com', 'mobile' => '9000111222', 'message' => 'Neurology consultation', 'status' => 'pending'],
            ['name' => 'Vikas Menon', 'email' => 'vikas.menon@gmail.com', 'mobile' => '9111000999', 'message' => 'Surgery consultation required', 'status' => 'approved'],
            ['name' => 'Anjali Kapoor', 'email' => 'anjali.kapoor@gmail.com', 'mobile' => '9222111000', 'message' => 'Radiology scan request', 'status' => 'rejected'],
        ];

        foreach ($accountRequestData as $data) {
            $reviewedBy = null;
            $reviewedAt = null;
            $rejectionReason = null;

            if ($data['status'] === 'approved') {
                $reviewedBy = $admin->id;
                $reviewedAt = Carbon::now()->subDays(rand(1, 5));
            } elseif ($data['status'] === 'rejected') {
                $reviewedBy = $admin->id;
                $reviewedAt = Carbon::now()->subDays(rand(1, 3));
                $rejectionReason = 'Incomplete information provided';
            }

            AccountRequest::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile_number' => $data['mobile'],
                'message' => $data['message'],
                'status' => $data['status'],
                'requested_role' => 'patient',
                'reviewed_by' => $reviewedBy,
                'reviewed_at' => $reviewedAt,
                'rejection_reason' => $rejectionReason,
            ]);
        }
    }
}
