@extends('layouts.admin_auth')

@section('title', 'Login Admin')

@section('content')

{{-- ====================================================
     Full-page container dengan batik background pattern
     ==================================================== --}}
<div class="min-h-screen flex flex-col justify-center items-center px-4 py-12
            bg-base-200 bg-batik-kawung relative overflow-hidden">

    {{-- Decorative gradient orbs (batik accent) --}}
    <div class="absolute top-0 left-0 w-96 h-96 rounded-full
                bg-primary/10 blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full
                bg-accent/10 blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/4 w-64 h-64 rounded-full
                bg-secondary/8 blur-2xl pointer-events-none"></div>

    {{-- Main card --}}
    <div class="relative z-10 w-full max-w-md">

        {{-- ── Brand header ── --}}
        <div class="flex flex-col items-center mb-8">

            {{-- Logo: Gerabah icon dalam lingkaran bermotif --}}
            <div class="relative mb-5">
                {{-- Outer decorative ring (batik motif) --}}
                <div class="w-24 h-24 rounded-full
                            bg-gradient-to-br from-primary via-primary/80 to-accent/70
                            flex items-center justify-center
                            shadow-lg shadow-primary/30
                            ring-4 ring-accent/30 ring-offset-2 ring-offset-base-200">
                    {{-- Gerabah / pottery wheel SVG --}}
                    <svg class="w-12 h-12 text-primary-content" viewBox="0 0 48 48" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        {{-- Pottery wheel base --}}
                        <ellipse cx="24" cy="36" rx="14" ry="4" fill="currentColor" opacity="0.3"/>
                        {{-- Pot body --}}
                        <path d="M14 28 C10 20 10 12 24 8 C38 12 38 20 34 28 C32 32 28 35 24 35 C20 35 16 32 14 28Z"
                              fill="currentColor" opacity="0.9"/>
                        {{-- Pot neck --}}
                        <path d="M19 8 Q24 5 29 8" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" fill="none" opacity="0.7"/>
                        {{-- Pot highlight --}}
                        <path d="M16 18 Q18 14 20 16" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" fill="none" opacity="0.4"/>
                        {{-- Wheel spokes --}}
                        <line x1="24" y1="36" x2="14" y2="39" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" opacity="0.5"/>
                        <line x1="24" y1="36" x2="34" y2="39" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" opacity="0.5"/>
                        <circle cx="24" cy="36" r="2" fill="currentColor" opacity="0.6"/>
                    </svg>
                </div>
                {{-- Batik ornament dots --}}
                <span class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-accent opacity-80 shadow"></span>
                <span class="absolute -bottom-1 -left-1 w-3 h-3 rounded-full bg-secondary opacity-60 shadow"></span>
            </div>

            {{-- Title --}}
            <h1 class="font-serif text-3xl font-bold text-center text-base-content leading-tight">
                Museum Sitiwinangun
            </h1>
            <p class="mt-1.5 text-sm text-base-content/60 italic font-serif tracking-wide">
                "Dari Tanah Menjadi Warisan"
            </p>

            {{-- Ornamental divider --}}
            <div class="flex items-center gap-3 mt-4">
                <span class="h-px w-12 bg-gradient-to-r from-transparent to-primary/40"></span>
                <svg class="w-4 h-4 text-accent" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M8 0L9.5 6H16L10.8 9.7L12.9 16L8 12.3L3.1 16L5.2 9.7L0 6H6.5Z"/>
                </svg>
                <span class="h-px w-12 bg-gradient-to-l from-transparent to-primary/40"></span>
            </div>
        </div>

        {{-- ── Login Card ── --}}
        <div class="card bg-base-100 shadow-2xl border border-base-300">
            <div class="card-body gap-5 p-8">

                {{-- Card subtitle --}}
                <div class="text-center -mt-2 mb-1">
                    <h2 class="text-base font-semibold text-base-content/70 uppercase tracking-widest text-xs">
                        Panel Administrasi
                    </h2>
                </div>

                {{-- ── Flash alerts ── --}}
                @if (session('success'))
                    <div role="alert" class="alert alert-success">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div role="alert" class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div role="alert" class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <ul class="list-disc list-inside text-sm space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ── Form ── --}}
                <form action="{{ route('admin.login') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    {{-- Email --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-xs uppercase tracking-wider text-base-content/60 font-semibold">
                            Alamat Email
                        </legend>
                        <label class="input input-bordered flex items-center gap-2 w-full
                                      @error('email') input-error @enderror">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/40 shrink-0"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <input id="email" name="email" type="email" autocomplete="email"
                                   required value="{{ old('email') }}"
                                   placeholder="admin@sitiwinangun.id"
                                   class="grow bg-transparent text-sm outline-none placeholder:text-base-content/30"/>
                        </label>
                    </fieldset>

                    {{-- Password --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend text-xs uppercase tracking-wider text-base-content/60 font-semibold">
                            Kata Sandi
                        </legend>
                        <label class="input input-bordered flex items-center gap-2 w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-base-content/40 shrink-0"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input id="password" name="password" type="password"
                                   autocomplete="current-password" required
                                   placeholder="••••••••"
                                   class="grow bg-transparent text-sm outline-none placeholder:text-base-content/30"/>
                        </label>
                    </fieldset>

                    {{-- Remember me --}}
                    <div class="flex items-center gap-2.5">
                        <input id="remember" name="remember" type="checkbox"
                               class="checkbox checkbox-primary checkbox-sm"/>
                        <label for="remember" class="text-sm text-base-content/70 select-none cursor-pointer">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    {{-- Submit button --}}
                    <div class="card-actions mt-2">
                        <button id="btn-login" type="submit" class="btn btn-primary btn-block text-sm font-semibold tracking-wide">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Masuk ke Dashboard
                        </button>
                    </div>
                </form>

                {{-- Back to public site --}}
                <div class="text-center mt-1">
                    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm gap-1.5 text-base-content/50 hover:text-primary" id="btn-back-home">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>

            </div>{{-- /card-body --}}
        </div>{{-- /card --}}

        {{-- Footer note --}}
        <p class="text-center text-xs text-base-content/40 mt-6">
            {{ config('app.name', 'Desa Sitiwinangun') }} &copy; {{ date('Y') }}
            &mdash; Sistem Informasi Digital Kriya
        </p>

    </div>{{-- /max-w-md --}}
</div>

@endsection
