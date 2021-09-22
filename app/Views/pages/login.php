    <div class="form-container d-block justify-content-center align-items-center">
        <h2>Login</h2>

        <?php if(isset($validation)):?>
        <div class="alert alert-warning">
            <?= $validation->listErrors() ?>
        </div>
        <?php endif;?>

        <form action="<?php echo base_url('auth'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
                <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                <?php endif;?>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
