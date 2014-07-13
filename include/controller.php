<?php

require_once root . 'include/libs/medoo/medoo.php';

class Controller extends medoo {

   public $_db;
   public $_data = array();

   public function __construct($options) {
      $this->_db = new medoo($options);
   }

   function view() {
      $Path = $data = NULL;
      $autoload_elements = FALSE;

      if (func_num_args()) {
         $argv = func_get_args();
         $Path = $argv[0];
         array_shift($argv);
         foreach ($argv as $arg) {
            if (is_array($arg))
               $data = $arg;
            if (is_bool($arg))
               $autoload_elements = $arg;
         }
      }
      if (isset($Path) && $Path) {
         if (is_array($Path)) {
            if ($autoload_elements === TRUE)
               $this->view('elements/_header', $data);
            foreach ($Path as $path) {
               $this->view($path, $data);
            }
            if ($autoload_elements === TRUE)
               $this->view('elements/_footer', $data);
            return;
         }
         $Path = make_path($Path);
         if (file_exists(root . 'views/' . $Path)) {
            if (isset($data) && is_array($data) && !empty($data))
               extract($data);
            if (!empty($this->_data))
               extract($this->_data);
            if ($autoload_elements === TRUE)
               $this->view('elements/_header', $data);
            include root . 'views/' . $Path;
            if ($autoload_elements === TRUE)
               $this->view('elements/_footer', $data);
         } else
            $this->show_404(TRUE);
      } else
         $this->show_404();
   }

   function module() {
      $Path = $data = NULL;

      if (func_num_args()) {
         $argv = func_get_args();
         $Path = $argv[0];
         array_shift($argv);
         foreach ($argv as $arg) {
            if (is_array($arg))
               $data = $arg;
         }
      }
      if (isset($Path) && $Path) {
         $Path = make_path($Path, TRUE);
         if (file_exists(root . 'modules/' . $Path)) {
            if (!empty($this->_data))
               extract($this->_data);
            if (isset($data) && is_array($data) && !empty($data))
               extract($data);
            include root . 'modules/' . $Path;
         } else
            $this->show_404(TRUE);
      } else
         $this->show_404();
   }

   function show_403($hf = FALSE) {
      http_response_code(403);
      if ($hf === TRUE) {
         $this->view("elements/_header", array('title' => '403 Access Forbidden'));
         $this->view("elements/403");
         $this->view("elements/_footer");
         return;
      }
      $this->view("elements/403");
   }

   function show_404($hf = FALSE) {
      http_response_code(404);
      if ($hf === TRUE) {
         $this->view("elements/_header", array('title' => '404 Not Found'));
         $this->view("elements/404");
         $this->view("elements/_footer");
         return;
      }
      $this->view("elements/404");
   }

}
