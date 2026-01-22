@extends('layouts.dashboard-layout')

@section('title', 'Manage Account')

@section('page-title', 'Manage Account')

@section('sidebar-menu')
<a href="{{ route('patient.dashboard') }}">Dashboard</a>
<a href="{{ route('patient.profile') }}">Edit Profile</a>
<a href="{{ route('patient.schedule') }}">My Schedule</a>
<a href="{{ route('patient.manage') }}" class="active">Manage Account</a>
@endsection

@section('content')
<div class="content-box text-center">
    <div class="info-row">
        <strong>Full Name:</strong> &nbsp; {{ $user->name ?? 'Nash Dsouza' }}
    </div>

    <div class="info-row">
        <strong>Associated Email Address:</strong> &nbsp; {{ $user->email ?? 'nds@gmail.com' }}
    </div>

    <div class="info-row">
        <strong>Patient Status:</strong> &nbsp; {{ $patient->status ?? 'Discharged' }}
    </div>

    <br>

    <form action="{{ route('patient.request-deletion') }}" method="POST">
        @csrf
        <button type="submit" class="btn" style="background-color: red; color: white; padding: 8px 20px; border-radius: 5px; font-size: 14px; border: none;">
            Request Account Deletion
        </button>
    </form>
</div>
@endsection