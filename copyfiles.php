<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

function zipfiles($filename, $rootPath){

// Initialize archive object
$zip = new ZipArchive();
$zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::SELF_FIRST
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

// Zip archive will be created only after closing object
$zip->close();
}

function recurse_copy( $src, $dst, $is_dir ) {
    if ( $is_dir ) {
        // copy directory
        if ( is_dir( $src ) ) {
            $dir = opendir( $src );
            @mkdir( $dst );
            while ( false !== ( $file = readdir( $dir )) ) {
                if ( ( $file != '.' ) && ( $file != '..' ) ) {
                    if ( is_dir( $src . '/' . $file ) ) {
                        recurse_copy( $src . '/' . $file, $dst . '/' . $file , true);
                    } else {
                        copy( $src . '/' . $file, $dst . '/' . $file );
                    }
                }
            }
            closedir( $dir );
        } else {
            echo 'dir ' . $src . ' is not found!';
        }
    } else {
        // copy file
        copy( $src , $dst );
    }
}
  
// make file and directory array
function data_element( $src, $dst, $is_dir = false ) {
    $data = array();
    $data['src'] = $src;
    $data['dst'] = $dst;
    $data['isdir'] = $is_dir;
    return $data;
}

// make data

$data = array();

$src = '../modules/cardgate/';
$dst = 'cardgate/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgateafterpay/';
$dst = 'cardgateafterpay/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgatebanktransfer/';
$dst = 'cardgatebanktransfer/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgatebitcoin/';
$dst = 'cardgatebitcoin/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgatecreditcard/';
$dst = 'cardgatecreditcard/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgatedirectdebit/';
$dst = 'cardgatedirectdebit/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgatedirectebanking/';
$dst = 'cardgatedirectebanking/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgategiropay/';
$dst = 'cardgategiropay/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgateideal/';
$dst = 'cardgateideal/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgateklarna/';
$dst = 'cardgateklarna/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgatemc/';
$dst = 'cardgatemc/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgatepaypal/';
$dst = 'cardgatepaypal/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
$src = '../modules/cardgateprzelewy24/';
$dst = 'cardgateprzelewy24/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );

/*
$src = '../image/cgp/';
$dst = 'cardgate/image/cgp/';
$is_dir = true;
array_push( $data, data_element( $src, $dst, $is_dir ) );
*/
// copy files

foreach ( $data as $k => $v ) {
        recurse_copy( $v['src'], $v['dst'], $v['isdir'] );
}

// make the zip
echo 'files copied<br>';

// Get real path for our folder
$rootPath = '/home/richard/websites/prestashop16/htdocs/_plugin/cardgate';
$filename = 'cardgate.zip';

zipfiles($filename, $rootPath);
echo 'zipfile made<br>';
echo 'done!';
?>