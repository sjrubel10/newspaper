<?php
// connect and login to FTP server

/*
 FTP Username: easy-appick@eeasy-soft.com
 FTP server: ftp.eeasy-soft.com
 FTP & explicit FTPS port:  21
*/
$ftpUsername = 'easy-appick@eeasy-soft.com';
$ftpPassword = 'easy-appick';
$ftpServer = "ftp.eeasy-soft.com";
$localFilePath = "upload/tttttreviewtestgoogle.xml";
$serverFilePath = "binarytestagain121.xml";

function ftpUploadFile( $ftpUsername, $ftpPassword, $ftpServer, $localFilePath, $serverFilePath )
{
    $conn_id = ftp_connect($ftpServer);
    if (!$conn_id) {
        throw new Exception("Failed to connect to the FTP server");
    }
    $login = ftp_login($conn_id, $ftpUsername, $ftpPassword);
    if (!$login) {
        throw new Exception("FTP login failed");
    }
    ftp_pasv($conn_id, true);

    if (!file_exists($localFilePath)) {
        throw new Exception("Local file not found: $localFilePath");
    }
    $content = file_get_contents($localFilePath);
    $tmp = fopen(tempnam(sys_get_temp_dir(), $localFilePath), "w+");
    fwrite($tmp, $content);
    rewind($tmp);
    $upload = ftp_fput($conn_id, $serverFilePath, $tmp, FTP_BINARY);
    ftp_close($conn_id);

    return $upload ;
}

$result = ftpUploadFile( $ftpUsername, $ftpPassword, $ftpServer, $localFilePath, $serverFilePath );
echo $result;

