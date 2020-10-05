<?php
session_start();
include('./includes/navbar.php');

require('model.php');
$req = checkPseudo();

require('./views/subscribeView.php');
