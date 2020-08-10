<?php

    session_start();

    try
    {
        $db=new PDO("mysql:host=sql113.epizy.com;dbname=epiz_26471226_sport_equip","epiz_26471226","mpAawPtAqMmY");
        $db->exec("set names utf8");
    } 
    catch (PDOException $ex) 
    {
        echo "db Connection problem".$ex->GetMessage();
        exit;
    }

