<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>POS Accounts</title>
<style>body{font:16px Arial,sans-serif;background:#f5f6f8;color:#202630;max-width:1000px;margin:40px auto;padding:0 20px}nav{display:flex;gap:24px;margin-bottom:30px}a{color:#194f91}main{background:white;padding:28px;border-radius:10px}table{width:100%;border-collapse:collapse}th,td{text-align:left;border-bottom:1px solid #ddd;padding:12px}label{display:block;margin:18px 0}input{display:block;padding:10px;box-sizing:border-box;max-width:100%;width:440px;margin-top:7px}button{background:#194f91;color:white;padding:12px 22px;border:0;border-radius:5px;cursor:pointer}.errors{color:#a40000}.success{color:#13642b}img{border-radius:50%;object-fit:cover}</style></head>
<body><nav><b>POS Accounts</b><a href="<?= site_url('customers') ?>">Customers</a><a href="<?= site_url('users') ?>">User Accounts</a></nav><main>
<?php if ($message=session()->getFlashdata('success')): ?><p class="success"><?= esc($message) ?></p><?php endif ?>
<?= $this->renderSection('content') ?></main></body></html>
