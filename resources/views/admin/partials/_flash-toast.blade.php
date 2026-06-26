@if (session('success') || session('error'))
<div x-data="{ 
        showSuccess: {{ session('success') ? 'true' : 'false' }},
        showError: {{ session('error') ? 'true' : 'false' }}
     }"
     x-init="
        if (showSuccess) { setTimeout(() => showSuccess = false, 4000) }
        if (showError) { setTimeout(() => showError = false, 6000) }
     "
     class="toast toast-top toast-end z-50">
    
    @if (session('success'))
    <div x-show="showSuccess" x-transition class="alert alert-success shadow-lg text-white font-medium flex gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div x-show="showError" x-transition class="alert alert-error shadow-lg text-white font-medium flex gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif
</div>
@endif
