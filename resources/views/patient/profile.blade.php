@extends('layouts.dashboard-layout')

@section('title', 'Edit Profile')

@section('page-title', 'Edit Profile')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}">Dashboard</a>
<a href="{{ route('patient.profile') }}" class="active">Edit Profile</a>
<a href="{{ route('patient.schedule') }}">My Schedule</a>
<a href="{{ route('patient.manage') }}">Manage Account</a>
@endsection

@section('content')
<div class="content-box">
    <form action="{{ route('patient.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="info-row">
            <strong>Full Name:</strong> &nbsp;
            <input type="text" value="{{ $user->name ?? 'Nash Dsouza' }}" readonly style="background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
        </div>

        <div class="info-row">
            <strong>DOB:</strong> &nbsp;
            <input type="text" value="{{ $patient->dob ?? '31/12/2003' }}" readonly style="background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
        </div>

        <div class="info-row">
            <strong>Sex:</strong> &nbsp;
            <input type="text" value="{{ ucfirst($patient->gender ?? 'Male') }}" readonly style="background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
        </div>

        <div class="info-row">
            <strong>Age:</strong> &nbsp;
            <input type="text" value="{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->age : 23 }}" readonly style="background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
        </div>

        <div class="info-row">
            <strong>Recent Surgery?:</strong> &nbsp;
            <input type="text" value="{{ $patient->last_visited_date ?? '31/12/2003' }}" readonly style="background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
        </div>

        <div class="info-row">
            <strong>Status:</strong> &nbsp;
            <input type="text" value="{{ $patient->status ?? 'Discharged' }}" readonly style="background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
        </div>

        <div class="info-row">
            <strong>Email Address:</strong> &nbsp;
            <input type="text" value="{{ $user->email ?? 'nds@gmail.com' }}" readonly style="background: white; border: 1px solid #ddd; padding: 5px 10px; border-radius: 4px;">
        </div>

        <!-- Note: In future, make mobile_number and address editable -->
        <!-- <button type="submit" class="btn btn-primary mt-3">Save Changes</button> -->
    </form>
</div>
@endsection