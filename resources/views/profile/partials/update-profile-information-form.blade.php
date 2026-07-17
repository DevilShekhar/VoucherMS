<section>
    <header>
        <h2 style="font-family: 'Fraunces', serif; font-size: 20px; font-weight: 600; color: var(--ink); margin: 0 0 6px 0;">
            {{ __('Profile Information') }}
        </h2>
        <p style="color: var(--ink-soft); font-size: 14px; margin: 0 0 20px 0;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" style="width: 100%;">
        @csrf
        @method('patch')

        <div style="margin-bottom: 16px;">
            <label for="name" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                {{ __('Name') }}
            </label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control"
                value="{{ old('name', Auth::user()->name) }}"
                required
                autofocus
                autocomplete="name"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
            />
            @error('name')
                <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="email" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                {{ __('Email') }}
            </label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control"
                value="{{ old('email', Auth::user()->email) }}"
                required
                autocomplete="username"
                style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
            />
            @error('email')
                <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--line); display: flex; gap: 12px; flex-wrap: wrap;">
            <button type="submit" class="btn btn-create">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span style="color: var(--sage); font-size: 13px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-check-circle"></i> {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
