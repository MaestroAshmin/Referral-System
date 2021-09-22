<div class="form-container d-block justify-content-center align-items-center">
    <h1>Refer a Friend</h1>
        <?php $validation = \Config\Services::validation(); ?>
        <?php $session = \Config\Services::session();?>
    <form action="ReferAFriend/referSubmit" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
                <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                <?php endif;?>
     <input type="hidden" class="form-control" id="referrerId" name="referrerId" value ="<?php echo $session->get('user_id');?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
             <?php if($validation->getError('name')) {?>
                <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('name'); ?>
                </div>
            <?php }?>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
            <?php if($validation->getError('email')) {?>
                <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('email'); ?>
                </div>
            <?php }?>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phone" name="phone" aria-describedby="emailHelp">
            <?php if($validation->getError('phone')) {?>
                <div class='alert alert-danger mt-2'>
                <?= $error = $validation->getError('phone'); ?>
                </div>
            <?php }?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>