<?php
/**
 * Configuration for database connection
 *
 */
$host       = "localhost";
$username   = "phpmyadmin";
$password   = "_S{6tSO2]s";
$dbname     = "MRT_3216_Attendance";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );