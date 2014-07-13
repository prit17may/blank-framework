<?php

function get_tables($database, $all_info = FALSE) {
   $tables = array();
   $query = 'SHOW TABLE STATUS';
   $get_tables = $database->query($query)->fetchAll(PDO::FETCH_ASSOC);
   if ($all_info == TRUE) {
      return $get_tables;
   }
   foreach ($get_tables as $table) {
      $tables[] = $table['Name'];
   }
   return $tables;
}

function get_cols($database, $table_name, $skip_pk = FALSE, $all_info = FALSE) {
   $fields = array();
   $query = "SHOW COLUMNS FROM `" . $table_name . "`";
   $get = $database->query($query)->fetchAll(PDO::FETCH_ASSOC);
   foreach ($get as $data) {
      if ($skip_pk === TRUE) {
         if (!is_pk($database, $table_name, $data['Field'])) {
            if ($all_info === TRUE) {
               $fields[$data['Field']] = $data;
            } else {
               $fields[] = $data['Field'];
            }
         }
      } else {
         if ($all_info === TRUE) {
            $fields[$data['Field']] = $data;
         } else {
            $fields[] = $data['Field'];
         }
      }
   }
   return $fields;
}

function get_pk($database, $table_name, $only_check_AI = FALSE) {
   $query = "SHOW FIELDS FROM `" . $table_name . "` WHERE `Key` = 'PRI'";
   $get = $database->query($query)->fetchAll(PDO::FETCH_ASSOC);
   if (isset($get[0]) && is_array($get[0])) {
      if ($only_check_AI === TRUE) {
         return $get[0]['Extra'] === 'auto_increment' ? TRUE : FALSE;
      }
      return $get[0]['Field'];
   }
   return;
}
