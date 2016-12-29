<?php

//If this file is run from the command line, clean up the submodules
if (PHP_SAPI == 'cli') {
    cleanUpSubmodules();
}

function cleanUpSubmodules() {

    //Indicate here the location of all of our submodules and the files in them that we want to keep
    $submoduleArray = array(
        "js/StackBlur" => array("dist/stackblur.min.js"),
        "js/Hermite-resize" => array("hermite.js", "hermite-worker.js"),
        "includes/PHPMailer" => array("class.phpmailer.php", "class.pop3.php", "class.smtp.php")
    );

    //Save us a lot of typing when making the array by creating the full filename for us
    //Also make the file string work regardless of platform directory separator 
    $submoduleArray = modifySubmoduleArray($submoduleArray);

    //Delete any files that we aren't using (as defined above)
    removeSubmoduleFiles($submoduleArray);

    //Delete directories that are now empty
    removeEmptyDirectories($submoduleArray);
}

function modifySubmoduleArray($original) {
    $modifiedArray = array();
    foreach ($original as $key => $value) {
        $filenameArray = array();
        $key = str_replace("/", DIRECTORY_SEPARATOR, $_SERVER["DOCUMENT_ROOT"] .  $key);
        foreach ($value as $filename) {
            $filename = str_replace("/", DIRECTORY_SEPARATOR, $filename);
            $filenameArray[] = $key . DIRECTORY_SEPARATOR . $filename;
        }
        $modifiedArray[$key] = $filenameArray;
    }
    return $modifiedArray;
}

function removeEmptyDirectories($submoduleArray) {
    foreach ($submoduleArray as $submoduleKey => $submoduleValue) {
        $dir = new RecursiveDirectoryIterator($submoduleKey, FilesystemIterator::SKIP_DOTS);
        foreach (new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            if ($file->isDir()) {
                if (count(array_diff(scandir($file), array(".", ".."))) == 0){
                    rmdir($file);
                }
            }
        }
    }
}

function removeSubmoduleFiles($submoduleArray) {
    //Indicate here any special files we don't want deleted in any repo
    $specialFiles = array(".gitignore", ".git");

    foreach ($submoduleArray as $submoduleKey => $submoduleValue) {
        $dir = new RecursiveDirectoryIterator($submoduleKey, FilesystemIterator::SKIP_DOTS);
        foreach (new RecursiveIteratorIterator($dir) as $file) {
            if (!in_array($file, $submoduleValue) && !in_array($file->getFilename(), $specialFiles)) {
                unlink($file);
            }
        }
    }
}

?>
