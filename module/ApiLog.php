<?php

  define("MOD_APILOG_CODENAME", "ApiLog");
  spl_autoload_register(array('CMS_module_ApiLog','autoload'));

  class CMS_module_ApiLog {

      public static function autoload($className) {
          $className = ltrim($className, '\\');
          $fileName   = '';
          $namespace = '';
          if ($lastNsPos = strrpos($className, '\\')) {

              $namespace = substr($className, 0, $lastNsPos);
              $className = substr($className, $lastNsPos + 1);
              $fileName   = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;

              $fileName = str_replace(MOD_APILOG_CODENAME . DIRECTORY_SEPARATOR, '', $fileName);
          }
          $fileName = 'module/'.MOD_APILOG_CODENAME. DIRECTORY_SEPARATOR.$fileName.str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

          if(file_exists($fileName)) {
              require_once $fileName;
          }
      }

  }

?>
