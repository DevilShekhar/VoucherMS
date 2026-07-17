<section>
    <header>
        <h2 style="font-family: 'Fraunces', serif; font-size: 20px; font-weight: 600; color: var(--rust); margin: 0 0 6px 0;">
            {{ __('Delete Account') }}
        </h2>
        <p style="color: var(--ink-soft); font-size: 14px; margin: 0 0 20px 0;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        type="button"
        class="btn btn-danger"
        style="padding: 10px 24px; font-size: 14px;"
        onclick="confirmDelete()"
    >
        <i class="fas fa-trash"></i>
        {{ __('Delete Account') }}
    </button>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-family: 'Fraunces', serif; font-size: 18px; font-weight: 600;">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p style="color: var(--ink-soft); margin-bottom: 16px;">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                        @csrf
                        @method('delete')

                        <div style="margin-bottom: 12px;">
                            <label for="password" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                                {{ __('Password') }}
                            </label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control"
                                placeholder="{{ __('Enter your password') }}"
                                style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
                            />
                            @error('password')
                                <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>

                <div class="modal-footer" style="display: flex; gap: 8px; justify-content: flex-end;">
                    <button type="button" class="btn" style="background: var(--cloth); color: var(--ink); padding: 8px 20px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger" form="deleteAccountForm" style="padding: 8px 20px; border-radius: 8px; font-weight: 600; border: none; cursor: pointer;">
                        <i class="fas fa-trash"></i>
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function confirmDelete() {
        var modal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        modal.show();
    }
</script>
