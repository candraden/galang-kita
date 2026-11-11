@if (session('status'))
    <div class="mb-4 flex items-center gap-2 rounded-input bg-primary-tint px-4 py-3 text-sm font-medium text-primary-dark" role="status">
        <span class="material-symbols-outlined !text-[20px]">check_circle</span>{{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-4 flex items-center gap-2 rounded-input bg-danger-tint px-4 py-3 text-sm font-medium text-danger" role="alert">
        <span class="material-symbols-outlined !text-[20px]">error</span>{{ session('error') }}
    </div>
@endif
