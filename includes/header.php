<?php
require_once __DIR__ . '/functions.php';
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Brew & Co.</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php require_once __DIR__ . '/navbar.php'; ?>
