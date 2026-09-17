<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>RD-10 CRM Login</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>

<body class="login">

    <div class="login-card">

        <div class="login-logo">
            RD
        </div>

        <div class="eyebrow">
            PRODUCTION CONTROL
        </div>

        <h1>
            Welcome back
        </h1>

        <p>
            Sign in to the RD-10 inventory workspace.
        </p>

        <?php if ($m = session()->getFlashdata('error')): ?>

            <div class="error">
                <?= esc($m) ?>
            </div>

        <?php endif; ?>

        <form method="post" action="<?= base_url('login') ?>">

            <?= csrf_field() ?>

            <label>
                Email

                <input
                    type="email"
                    name="email"
                    value="<?= esc(old('email')) ?>"
                    required
                >
            </label>

            <label>
                Password

                <input
                    type="password"
                    name="password"
                    required
                >
            </label>

            <button class="primary" type="submit">
                Sign in
            </button>

        </form>

        <div class="hint">
            Admin: admin@rd10.local / Admin@123<br>
            User: user@rd10.local / User@123
        </div>

    </div>

</body>

</html>