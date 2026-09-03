<x-guest-layout>

    <div>
        <p class="auth-eyebrow">
            Selamat datang kembali
        </p>

        <h1 class="auth-title">
            Masuk ke SenjaKopi
        </h1>

        <p class="auth-subtitle">
            Lanjutkan pesanan dan pantau nomor antrianmu
            dari satu tempat.
        </p>
    </div>


    <form
        method="POST"
        action="{{ route('login') }}"
        class="auth-form"
    >

        @csrf


        <div class="field">

            <label
                for="email"
                class="field-label"
            >
                Email
            </label>

            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                placeholder="nama@email.com"
            >

            @error('email')
                <div class="auth-error">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <div class="field">

            <div
                style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-bottom:8px;
                "
            >

                <label
                    for="password"
                    class="field-label"
                    style="margin:0"
                >
                    Password
                </label>


                @if(Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        style="
                            color:#7a4b2d;
                            font-size:12px;
                            font-weight:800;
                            text-decoration:none;
                        "
                    >
                        Lupa password?
                    </a>

                @endif

            </div>


            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Masukkan password"
            >

            @error('password')
                <div class="auth-error">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <label
            style="
                display:flex;
                align-items:center;
                gap:9px;
                margin-top:18px;
                color:#6f6762;
                font-size:13px;
            "
        >

            <input
                type="checkbox"
                name="remember"
                style="
                    width:16px;
                    height:16px;
                    accent-color:#7a4b2d;
                "
            >

            Ingat saya di perangkat ini

        </label>


        <button
            type="submit"
            class="auth-button"
        >
            Masuk ke Akun
        </button>

    </form>


    <div class="auth-divider">
        atau
    </div>


    <p class="auth-footer">

        Belum punya akun?

        <a href="{{ route('register') }}">
            Daftar sekarang
        </a>

    </p>

</x-guest-layout>