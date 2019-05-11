<?php

define('ROOT_DIR', '/home/YOUR-USERNAME');
define('SCAN_DIR', ROOT_DIR.'/scan');
define('TORRENT_DIR', ROOT_DIR.'/torrent');
define('JOB_DIR', ROOT_DIR.'/');
define('ANNOUNCE_URL', 'YOUR-TRACKER-ANNOUNCE-AND-PASSKEY-HERE');
define('PIECE_SIZE', '21');

function exist_check($file_full, $file) {
	$file = pathinfo($file_full, PATHINFO_BASENAME);
	$found = false;
	
	$lines = file(JOB_DIR.'/log.txt');
	foreach($lines as $line)
	{
        if(strpos($line, $file) !== false)
		{
	        $found = true;
        }
    }
    
	if(!$found)
	{
	    make_torrent($file_full, $file);
	}
}

function make_torrent($file_full, $file) {
	$file = pathinfo($file_full, PATHINFO_BASENAME);
	$move_file = SCAN_DIR.'/'.$file;
	$info = pathinfo($file);
	
	$watch = array("(", ")","{", "}", "'", ";", "?", "<", ">", ":");
	$info['basename'] = str_replace($watch, '.', $info['basename']);	
	
	$output = TORRENT_DIR.'/'.$info['basename'].'.torrent';
	if (file_exists($output)) unlink($output);
	$cmd = "mktorrent '$move_file' -o '$output' -l ".PIECE_SIZE." -a ".ANNOUNCE_URL;
	echo $cmd."\n";
	exec($cmd);
	
	$fh = fopen(JOB_DIR.'/log.txt', 'a') or die;
	$string_data = $file.PHP_EOL;
	fwrite($fh, $string_data);
	fclose($fh);
	
	if (file_exists($output)) return $output;
	else die('Cannot make torrent!');
}

function scan_folder() {
	$dir = SCAN_DIR;
	
	if (!is_dir($dir))
	{
		$ok = mkdir($dir);
		if (!$ok) die('Cannot create destination folder!');
	}
	
	$dh = opendir($dir);
	while ( $file = readdir($dh) )
	{
		if ($file == '.' || $file == '..') continue;
		$file_full = $dir.'/'.$file;
		if ($file_full == SCAN_DIR) continue;
		exist_check($file_full, $dir, $file);
	}
}

scan_folder();

?>
