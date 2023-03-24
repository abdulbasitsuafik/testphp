<?php

class Zip{    
    public function __construct() {}
        
    public function zip($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/')+1), array('.', '..'))) {
                    continue;
                }               

                $file = realpath($file);

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                } elseif (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        } elseif (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    public function extractDir($zipfile, $path) {
      if (file_exists($zipfile)) {
        $files = array();
        $zip = new ZipArchive;
        if ($zip->open($zipfile) === TRUE) {
          for($i = 0; $i < $zip->numFiles; $i++) {
            $entry = $zip->getNameIndex($i);
            //Use strpos() to check if the entry name contains the directory we want to extract
              //Add the entry to our array if it in in our desired directory
              $files[] = $entry;
          }
          //Feed $files array to extractTo() to get only the files we want
          if ($zip->extractTo($path, $files) === TRUE) {
            return TRUE;
          } else {
            return FALSE;
          }
          $zip->close();
        } else {
          return FALSE;
        }
      } else {
        return FALSE;
      }
    }
}