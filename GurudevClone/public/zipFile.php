<?php

  $zip_obj = new ZipArchive;
  $zip_obj->open('final23-2.zip');
  print_r($zip_obj);
  $zip_obj->extractTo('../');
  
/*
  // Get real path for our folder
  echo "zipping";
$rootPath = realpath('Admin/resources/');

// Initialize archive object
$zip = new ZipArchive();
$zip->open('Admin-resources14-12-22.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}
print_r($zip);
// Zip archive will be created only after closing object
$zip->close();*/
?>