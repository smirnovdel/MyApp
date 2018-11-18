<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases

$db['dsn'] = 'pgsql:host=pgsql;dbname=test';
$db['username'] = 'test';
$db['password'] = 'test';

return $db;
