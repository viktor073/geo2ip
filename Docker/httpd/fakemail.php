#!/usr/bin/env php

<?php

$is_windows = stristr(PHP_OS, 'WIN');
$options = getopt("", ['open', 'prepend', 'file:', 'dir:']);
$is_open = isset($options['open']);
$is_prepend = isset($options['prepend']);
$is_onefile = isset($options['file']);
$mail_dir = isset($options['dir']) ? $options['dir'] : sys_get_temp_dir().'/mail';
$file_name = isset($options['file']) ? $options['file'] : mkname();
$file_path = $mail_dir.'/'.$file_name;

if( !is_dir( $mail_dir ) ) {
    mkdir( $mail_dir, 0777, TRUE );
    if( !is_dir( $mail_dir ) ) {
        die('Mail folder ['.$mail_dir.'] not created');
    }
}

$stream = $is_onefile ? PHP_EOL . str_repeat("-=", 10) . date('Y-m-d H:i:s') . str_repeat("-=", 10) . PHP_EOL : '';
while (false !== ($line = fgets(STDIN))) {
    $stream .= ($is_windows ? str_replace("\n", PHP_EOL, $line) : $line);
}

if($is_prepend && file_exists($file_path)) {
    $file_contents = file_get_contents($file_path);
    $stream .= $file_contents;
}

file_put_contents($file_path, $stream, $is_prepend ? 0 : FILE_APPEND);

if ($is_open && $is_windows){
    pclose(popen("start /B notepad ". $file_path, "r"));
}

function mkname($i=0) {
    global $mail_dir;
    $fn = 'mail_'.date('Y-m-d_H-i-s_').$i.'.txt';
    return file_exists($mail_dir.'/'.$fn) ? mkname(++$i) : $fn;
}