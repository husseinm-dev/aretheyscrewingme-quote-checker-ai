<?php
require_once __DIR__ . '/../config/bootstrap.php';
$auth->logout();
set_flash('success', 'Logged out.');
redirect('/index');
