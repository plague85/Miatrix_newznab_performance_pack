<?php
ini_set("memory_limit","999M");

require("config.php");
require_once(WWW_DIR."/lib/releases.php");
require_once(WWW_DIR."/lib/sphinx.php");


if (isset($argv[1]))
	$groupName = $argv[1];
else
	$groupName = '';
	
$releases = new Releases;
$sphinx = new Sphinx();
$releases->processReleases($groupName);
$sphinx->update();

?>
