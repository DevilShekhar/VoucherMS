@extends('layouts.app')

@section('page-title', 'Profile')

@section('content')
    <section class="section premium-dashboard">
        <div class="premium-floating-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div>
                        <span class="header-badge">
                            Account Management
                        </span>
                        <h2>Profile</h2>
                        <p>Manage your account settings and preferences</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <div class="row" style="display: flex; flex-wrap: wrap; gap: 24px; margin: 0;">
            {{-- Update Profile Information --}}
            <div class="col-12" style="width: 100%;">
                <div class="card premium-block">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="col-12" style="width: 100%;">
                <div class="card premium-block">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="col-12" style="width: 100%;">
                <div class="card premium-block">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
