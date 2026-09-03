<x-guest-layout>

    <div class="auth-heading">
        <p class="auth-eyebrow">Mulai perjalanan kopi</p>

        <h1 class="auth-title">
            Buat akun baru
        </h1>

        <p class="auth-subtitle">
            Daftar sekali, lalu pesan lebih cepat dan pantau semua pesananmu.
        </p>
    </div>

    <form method="POST"
          action="{{ route('register') }}"
          class="auth-form">

        @csrf

        {{-- Nama --}}
        <div class="field">
            <label for="name" class="field-label">
                Nama lengkap
            </label>

            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                
            >

            @error('name')
                <div class="auth-error">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="field">
            <label for="email" class="field-label">
                Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="nama@email.com"
            >

            @error('email')
                <div class="auth-error">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="field">
            <label for="password" class="field-label">
                Password
            </label>

            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
                placeholder="Minimal 8 karakter"
            >

            @error('password')
                <div class="auth-error">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="field">
            <label for="password_confirmation" class="field-label">
                Konfirmasi password
            </label>

            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Ulangi password"
            >

            @error('password_confirmation')
                <div class="auth-error">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="auth-button">
            Buat Akun SenjaKopi
        </button>

    </form>

    <div class="auth-divider">
        akun sudah ada?
    </div>

    <p class="auth-footer">
        <a href="{{ route('login') }}">
            Masuk ke SenjaKopi
        </a>
    </p>

</x-guest-layout>