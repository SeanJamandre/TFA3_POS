<?= $this->extend('accounts/layout') ?>
<?= $this->section('content') ?>
<h1><?= $id ? 'Edit' : 'New' ?> <?= $kind==='users' ? 'User' : 'Customer' ?></h1>
<?php if ($errors=session()->getFlashdata('errors')): ?><ul class="errors" role="alert"><?php foreach ($errors as $error): ?><li><?= esc($error) ?></li><?php endforeach ?></ul><?php endif ?>
<form method="post" enctype="multipart/form-data" action="<?= site_url($kind.($id ? '/'.$id : '')) ?>">
<?= csrf_field() ?>
<?php if ($kind==='users'): ?><label>Username<input name="username" required maxlength="60" value="<?= old('username',$row['username'] ?? '') ?>"></label><?php endif ?>
<label>Full Name<input name="full_name" required maxlength="150" value="<?= old('full_name',$row['full_name'] ?? '') ?>"></label>
<?php if ($kind==='customers'): ?><label>Email<input type="email" name="email" required maxlength="254" value="<?= old('email',$row['email'] ?? '') ?>"></label><?php endif ?>
<?php if ($kind==='users' && $id): ?>
<img width="80" height="80" alt="Current avatar" src="<?= base_url(!empty($row['avatar']) ? 'uploads/avatars/'.rawurlencode($row['avatar']) : 'images/placeholder.svg') ?>">
<label>Profile Picture<input type="file" name="avatar" accept="image/jpeg,image/png"></label><p>Optional JPG or PNG, up to 2 MB and 4096 × 4096 pixels. Saved as a 256 × 256 thumbnail. After an error, select the file again.</p>
<?php endif ?><button type="submit">Save</button> <a href="<?= site_url($kind) ?>">Cancel</a></form>
<?= $this->endSection() ?>
