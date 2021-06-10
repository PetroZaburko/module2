<?php

session_start();
if( !session_id() ) @session_start();

require_once '../vendor/autoload.php';
require_once '../config.php';
require_once '../route.php';