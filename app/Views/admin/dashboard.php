<div class="grid">

    <div class="card">

        <div class="card-label">
            TOTAL USERS
        </div>

        <div class="card-value">
            <?= esc($stats['users']) ?>
        </div>

    </div>


    <div class="card">

        <div class="card-label">
            ACTIVE USERS
        </div>

        <div class="card-value">
            <?= esc($stats['active_users']) ?>
        </div>

    </div>

</div>


<div class="card" style="margin-top:20px;">

    <h3>
        Admin Control Center
    </h3>

    <p>
        Welcome,
        <strong><?= esc($user['name']) ?></strong>
    </p>

    <p>
        Email:
        <strong><?= esc($user['email']) ?></strong>
    </p>

    <p>
        Role:
        <strong><?= esc(ucfirst($user['role'])) ?></strong>
    </p>

</div>