<?php
echo '<pre>';
echo 'upload_max_filesize : ' . ini_get('upload_max_filesize') . "\n";
echo 'post_max_size       : ' . ini_get('post_max_size') . "\n";
echo 'file_uploads        : ' . ini_get('file_uploads') . "\n";
echo 'max_file_uploads    : ' . ini_get('max_file_uploads') . "\n";
echo 'FCPATH              : ' . (defined('FCPATH') ? FCPATH : dirname(__FILE__).DIRECTORY_SEPARATOR) . "\n";
echo 'uploads/surat writable: ' . (is_writable(dirname(__FILE__).'/uploads/surat/') ? 'YES' : 'NO') . "\n";
echo 'uploads/foto  writable: ' . (is_writable(dirname(__FILE__).'/uploads/foto/')  ? 'YES' : 'NO') . "\n";
echo '</pre>';
