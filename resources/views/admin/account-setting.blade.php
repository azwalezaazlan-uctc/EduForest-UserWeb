@extends('layouts.admin-master')

@section('page-title', 'Account Setting')

@section('content')

    <div class="card-premium" id="account-setting-sec">
        <h2 class="card-title">Account Setting</h2>
        <p class="card-subtitle">Kemaskini kata laluan akaun admin anda.</p>

        <div class="grid-premium">
            <form action="{{ route('admin.account-setting.password') }}" method="POST" class="sub-card-form">
                @csrf
                @method('PUT')

                <h3 class="sub-card-title">Change Password</h3>

                <div class="form-group">
                    <label>Admin Email</label>
                    <input type="text" value="{{ $admin->email ?? session('admin_email') }}" disabled
                        style="background:#f1f5f9; color:#64748b; cursor:not-allowed;">
                </div>

                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" placeholder="Enter current password" required>
                    @error('current_password')
                        <span style="color:#dc2626; font-size:12px; font-weight:600;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" placeholder="Minimum 8 characters" required minlength="8">
                    @error('new_password')
                        <span style="color:#dc2626; font-size:12px; font-weight:600;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" placeholder="Retype new password" required minlength="8">
                </div>

                <div class="btn-flex-group">
                    <button type="submit" class="btn-premium btn-premium-emerald">Update Password</button>
                </div>
            </form>

            <div class="sub-card-form" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 class="sub-card-title">Account Info</h3>
                    <div class="condition-item booked">
                        <span>👤 <strong>{{ $admin->full_name ?? session('admin_name', 'Admin') }}</strong></span>
                    </div>
                    <div class="condition-item booked">
                        <span>✉️ {{ $admin->email ?? session('admin_email') }}</span>
                    </div>
                </div>

                <div class="ux-notice-box">
                    <span style="font-weight: 700; color: #1e293b;">💡 Nota:</span>
                    <span>• Pastikan kata laluan baharu sekurang-kurangnya 8 aksara.</span>
                    <span>• Anda perlu masukkan kata laluan semasa untuk pengesahan.</span>
                </div>
            </div>
        </div>
    </div>

@endsection