<?php
    // Connection strings to the database using PDO(PHP Data Objects)
    $db_user = 'dotman';
    $db_pass = 'timilehin';
    $db_name = 'documentmanagementsystem';

    $db = new PDO('mysql:host=localhost;dbname=' . $db_name . ';charset=utf8',$db_user,$db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    