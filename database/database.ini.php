<?php

require 'ConnectionDB.php';

use ConexaoPostgres\ConnectionDB as Connection;

$pdo = Connection::get()->connect();