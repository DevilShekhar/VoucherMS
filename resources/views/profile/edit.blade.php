@extends('layouts.app')

@section('page-title', 'Profile')

@section('content')
    <section class="section premium-dashboard">
    <div class="premium-header">
        <div class="premium-header-overlay"></div>
        <div class="premium-header-left">
            <div class="premium-header-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="premium-header-content">
                <span class="premium-tag">ACCOUNT MANAGEMENT</span>
                <h2 class="text-white">Profile</h2>
                <p>Manage your account settings and preferences</p>
            </div>
        </div>
        <!-- Optional: Add action buttons here if needed -->
        <div class="premium-header-right">
        </div>
        <!-- Decorative Shapes -->
        <div class="shape circle-1"></div>
        <div class="shape circle-2"></div>
        <div class="shape circle-3"></div>
        <div class="dots"></div>
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
