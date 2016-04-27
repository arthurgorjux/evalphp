<?php

define("MOD_AGSERVICES_CODENAME", "agservices");
spl_autoload_register (array('CMS_module_agservices','autoload'));

class CMS_module_agservices {

    public static function autoload($className) {
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        $baseFileName = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            $baseFileName = str_replace(MOD_AGSERVICES_CODENAME . DIRECTORY_SEPARATOR, '', $fileName);
        }

        $fileName = 'module/'.MOD_AGSERVICES_CODENAME. DIRECTORY_SEPARATOR.$fileName.str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        if(file_exists($fileName)) {
            require_once $fileName;
            return;
        }

        if($baseFileName) {
            /*
             * Allow namespaces of the type "agservices\xxx",
             */
            $fileName = 'module/'.MOD_AGSERVICES_CODENAME. DIRECTORY_SEPARATOR.$baseFileName.str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
            if(file_exists($fileName)) {
                require_once $fileName;
            }
        }
    }
}
