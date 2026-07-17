<section>
    <header>
        <h2 style="font-family: 'Fraunces', serif; font-size: 20px; font-weight: 600; color: var(--ink); margin: 0 0 6px 0;">
            {{ __('Update Password') }}
        </h2>
        <p style="color: var(--ink-soft); font-size: 14px; margin: 0 0 20px 0;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="width: 100%;">
        @csrf
        @method('put')

        <div style="margin-bottom: 16px;">
            <label for="update_password_current_password" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                {{ __('Current Password') }}
            </label>
            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="form-control"
                autocomplete="current-password"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
            />
            @error('current_password')
                <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="update_password_password" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                {{ __('New Password') }}
            </label>
            <input
                id="update_password_password"
                name="password"
                type="password"
                class="form-control"
                autocomplete="new-password"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
            />
            @error('password')
                <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="update_password_password_confirmation" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                {{ __('Confirm Password') }}
            </label>
            <input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control"
                autocomplete="new-password"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
            />
            @error('password_confirmation')
                <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--line); display: flex; gap: 12px; flex-wrap: wrap;">
            <button type="submit" class="btn btn-create">
                {{ __('Save Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <span style="color: var(--sage); font-size: 13px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-check-circle"></i> {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
