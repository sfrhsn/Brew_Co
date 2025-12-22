<?php
session_start();
require_once '../config/db.php';
require_once 'controllers/AdminController.php';

$controller = new AdminController();
$controller->handleRequest();