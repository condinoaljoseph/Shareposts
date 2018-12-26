<?php require_once APP_ROOT.'/views/includes/header.php';?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Users</h2>
                <ul>
                    <?php foreach($data['user'] as $user): ?>
                        <li><?php echo $user->name; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php require_once APP_ROOT.'/views/includes/footer.php';?>