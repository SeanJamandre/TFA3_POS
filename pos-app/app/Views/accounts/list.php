<?= $this->extend('accounts/layout') ?>
<?= $this->section('content') ?>
<h1><?= $kind==='users' ? 'User Accounts' : 'Customers' ?></h1>
<p><a href="<?= site_url($kind.'/new') ?>">Add New <?= $kind==='users' ? 'User' : 'Customer' ?></a></p>
<table><thead><tr><?php if ($kind==='users'): ?><th>Avatar</th><th>Username</th><?php endif ?><th>Full Name</th><?php if ($kind==='customers'): ?><th>Email</th><?php endif ?><th>Action</th></tr></thead><tbody>
<?php foreach ($rows as $row): ?><tr>
<?php if ($kind==='users'): ?>
<td><img width="56" height="56" alt="Profile picture" src="<?= base_url(!empty($row['avatar']) ? 'uploads/avatars/'.rawurlencode($row['avatar']) : 'images/placeholder.svg') ?>"></td><td><?= esc($row['username']) ?></td>
<?php endif ?><td><?= esc($row['full_name']) ?></td>
<?php if ($kind==='customers'): ?><td><?= esc($row['email']) ?></td><?php endif ?>
<td><a href="<?= site_url($kind.'/'.$row['id'].'/edit') ?>">Edit</a></td></tr><?php endforeach ?>
<?php if (!$rows): ?><tr><td colspan="5">No records yet.</td></tr><?php endif ?>
</tbody></table><?= $this->endSection() ?>
