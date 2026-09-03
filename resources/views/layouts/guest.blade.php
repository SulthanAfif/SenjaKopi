<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $title ?? 'SenjaKopi' }}
    </title>

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background: #f7f1eb;
            color: #2b211b;
        }

        a {
            color: inherit;
        }

        /* =========================
           LAYOUT
        ========================= */

        .auth-shell {
            min-height: 100vh;

            display: grid;

            grid-template-columns:
                minmax(0, 1.05fr)
                minmax(420px, .95fr);
        }


        /* =========================
           LEFT BRAND
        ========================= */

        .auth-brand {
            position: relative;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            padding: 50px 7vw;

            color: white;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 15% 20%,
                    rgba(230, 174, 121, .25),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 85% 80%,
                    rgba(255,255,255,.08),
                    transparent 35%
                ),
                linear-gradient(
                    145deg,
                    #2b1b14,
                    #4a3023,
                    #70462f
                );
        }


        .auth-brand::before {
            content: "";

            position: absolute;

            width: 450px;
            height: 450px;

            right: -220px;
            top: 10%;

            border: 1px solid rgba(255,255,255,.1);

            border-radius: 50%;
        }


        .brand-logo {
            position: relative;

            color: white;

            text-decoration: none;

            font-size: 30px;
            font-weight: 900;

            letter-spacing: -1.5px;
        }


        .brand-logo span {
            color: #e4aa72;
        }


        .brand-content {
            position: relative;
            z-index: 2;

            max-width: 650px;
        }


        .brand-kicker {
            margin: 0 0 15px;

            color: #e2a76f;

            font-size: 12px;
            font-weight: 800;

            letter-spacing: 3px;

            text-transform: uppercase;
        }


        .brand-title {
            margin: 0;

            font-size: clamp(42px, 5vw, 72px);

            line-height: 1.02;

            letter-spacing: -4px;
        }


        .brand-description {
            margin-top: 25px;

            max-width: 540px;

            color: #eadfd7;

            font-size: 17px;

            line-height: 1.7;
        }


        .brand-pills {
            display: flex;

            flex-wrap: wrap;

            gap: 10px;

            margin-top: 28px;
        }


        .brand-pill {
            padding: 9px 14px;

            border-radius: 999px;

            background: rgba(255,255,255,.09);

            border:
                1px solid
                rgba(255,255,255,.12);

            color: #f7eee8;

            font-size: 13px;

            font-weight: 700;
        }


        .brand-footer {
            position: relative;

            color: #cbbcb3;

            font-size: 13px;
        }


        /* =========================
           RIGHT PANEL
        ========================= */

        .auth-panel {
            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 40px 30px;

            background:
                linear-gradient(
                    180deg,
                    #fffdfa,
                    #f8f3ee
                );
        }


        .auth-content {
            width: 100%;
            max-width: 470px;
        }


        .auth-card {
            padding: 38px;

            border:
                1px solid
                #e9dfd7;

            border-radius: 28px;

            background: white;

            box-shadow:
                0 25px 70px
                rgba(67,42,27,.10);
        }


        /* =========================
           FORM
        ========================= */

        .auth-eyebrow {
            margin: 0 0 10px;

            color: #a96f40;

            font-size: 12px;
            font-weight: 800;

            letter-spacing: 2px;

            text-transform: uppercase;
        }


        .auth-title {
            margin: 0;

            color: #211b17;

            font-size: 36px;

            line-height: 1.1;

            font-weight: 900;

            letter-spacing: -1.5px;
        }


        .auth-subtitle {
            margin-top: 12px;

            color: #78716c;

            font-size: 14px;

            line-height: 1.6;
        }


        .auth-form {
            margin-top: 28px;
        }


        .field {
            margin-top: 18px;
        }


        .field:first-child {
            margin-top: 0;
        }


        .field-label {
            display: block;

            margin-bottom: 8px;

            color: #3b332f;

            font-size: 13px;

            font-weight: 800;
        }


        .field input {
            display: block;

            width: 100%;

            height: 52px;

            padding:
                0 15px;

            border:
                1px solid
                #ded6cf;

            border-radius: 14px;

            background: white;

            color: #2b2623;

            font-family: inherit;

            font-size: 14px;

            outline: none;

            transition:
                .2s ease;
        }


        .field input::placeholder {
            color: #aaa09a;
        }


        .field input:focus {
            border-color: #c58a58;

            box-shadow:
                0 0 0 4px
                rgba(197,138,88,.14);
        }


        .auth-error {
            margin-top: 7px;

            color: #b42318;

            font-size: 12px;
        }


        .auth-button {
            width: 100%;

            min-height: 53px;

            margin-top: 24px;

            border: 0;

            border-radius: 15px;

            background:
                linear-gradient(
                    135deg,
                    #7a4b2d,
                    #5d3723
                );

            color: white;

            font-family: inherit;

            font-size: 14px;

            font-weight: 900;

            cursor: pointer;

            box-shadow:
                0 12px 25px
                rgba(93,55,35,.2);

            transition:
                .2s ease;
        }


        .auth-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 16px 30px
                rgba(93,55,35,.25);
        }


        .auth-divider {
            display: flex;

            align-items: center;

            gap: 12px;

            margin-top: 25px;

            color: #a39a94;

            font-size: 12px;

            text-align: center;
        }


        .auth-divider::before,
        .auth-divider::after {
            content: "";

            height: 1px;

            flex: 1;

            background: #eee8e3;
        }


        .auth-footer {
            margin-top: 20px;

            color: #7c746e;

            font-size: 13px;

            text-align: center;
        }


        .auth-footer a {
            color: #7a4b2d;

            font-weight: 900;

            text-decoration: none;
        }


        .auth-footer a:hover {
            text-decoration: underline;
        }


        .auth-back {
            display: block;

            margin-top: 18px;

            color: #7d756f;

            font-size: 12px;

            font-weight: 700;

            text-align: center;

            text-decoration: none;
        }


        /* =========================
           MOBILE
        ========================= */

        .mobile-brand {
            display: none;

            margin-bottom: 25px;

            text-align: center;
        }


        @media (max-width: 900px) {

            .auth-shell {
                grid-template-columns: 1fr;
            }


            .auth-brand {
                display: none;
            }


            .auth-panel {
                min-height: 100vh;

                padding:
                    25px 15px;
            }


            .mobile-brand {
                display: block;
            }


            .mobile-brand .brand-logo {
                color: #4a3023;
            }

        }


        @media (max-width: 520px) {

            .auth-panel {
                padding:
                    15px 10px 25px;
            }


            .auth-card {
                padding: 25px 20px;

                border-radius: 23px;
            }


            .auth-title {
                font-size: 30px;
            }


            .field input {
                height: 50px;
            }

        }

    </style>
</head>


<body>

    <div class="auth-shell">

        <aside class="auth-brand">

            <a
                href="{{ route('home') }}"
                class="brand-logo"
            >
                Senja<span>Kopi.</span>
            </a>


            <div class="brand-content">

                <p class="brand-kicker">
                    Coffee & comfort
                </p>

                <h2 class="brand-title">
                    Nikmati kopimu.
                    Biarkan SenjaKopi
                    urus sisanya.
                </h2>

                <p class="brand-description">
                    Pesan menu favorit,
                    simpan riwayat pesanan,
                    dan pantau nomor antrian
                    tanpa ribet.
                </p>

                <div class="brand-pills">

                    <span class="brand-pill">
                        ☕ Menu pilihan
                    </span>

                    <span class="brand-pill">
                        ⚡ Checkout cepat
                    </span>

                    <span class="brand-pill">
                        🎫 Pantau antrian
                    </span>

                </div>

            </div>


            <p class="brand-footer">
                SenjaKopi · dibuat untuk jeda yang lebih nikmat.
            </p>

        </aside>


        <main class="auth-panel">

            <div class="auth-content">

                <div class="mobile-brand">

                    <a
                        href="{{ route('home') }}"
                        class="brand-logo"
                    >
                        Senja<span>Kopi.</span>
                    </a>

                </div>


                <section class="auth-card">

                    {{ $slot }}

                </section>


                <a
                    href="{{ route('home') }}"
                    class="auth-back"
                >
                    ← Kembali ke menu
                </a>

            </div>

        </main>

    </div>

</body>

</html>