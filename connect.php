<?php
   $pdo=new PDO('mysql:host=localhost;dbname=insert_db;charset=utf8', 'ginzo', 'Wert3333-');
   // 静的プレースホルダを指定
   $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
   // エラー発生時に例外を投げる(これがないとchatchへ行かない)
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
