<?php
require("config.php");
require_once(WWW_DIR."/lib/groups.php");
#require_once(WWW_DIR."/lib/releases.php");
require_once(WWW_DIR.'/lib/powerprocess.php');

$groups = new Groups;
$groupList = $groups->getActive();
unset($groups);

$ps = new PowerProcess;
$ps->RegisterCallback('psUpdateComplete');
$ps->maxThreads = 10;
$ps->threadTimeLimit = 0;	// Disable child timeout

echo "Starting threaded update_release process\n";

while ($ps->RunControlCode()) 
{
	// Start the parent loop
	if (count($groupList)) 
	{
		// We still have groups to process
		if ($ps->SpawnReady()) 
		{
			// Spawn another thread
			$ps->threadData = array_pop($groupList);
			echo "[Thread-MASTER] Spawning new thread.  Still have " . count($groupList) ." group(s) to update after this\n";
			$ps->spawnThread();
		} 
		else 
		{
			// There are no more slots available to run
			//$ps->tick();
			//echo ".\n";
		}
	} 
	else 
	{
		// No more groups to process
		echo "No more groups to process - Initiating shutdown\n";
		$ps->Shutdown();
		echo "Shutdown complete\n";
	}
}

unset($groupList);

if ($ps->RunThreadCode()) 
{
	$group = $ps->threadData;
	
	$thread = sprintf("%05d",$ps->GetPID());
	
	echo "[Thread-{$thread}] Begining update_releases processing for group {$group['name']}\n";
	
	$param = $group['name'];
	
	$dir = dirname(__FILE__);
	$file = 'update_releases.php';
	
	$output = shell_exec("php {$dir}/{$file} {$param}");
	//$output = shell_exec("/usr/bin/php -c /etc/php5/cli/php.ini {$dir}/{$file} {$param}");
	
	echo "[Thread-{$thread}] Completed update for group {$group['name']}\n";
}

// Exit to call back to parent - Let know that child has completed
exit(0);

// Create callback function
function psUpdateComplete() 
{
	echo "[Thread-MASTER] Threaded update_releases process complete\n";
}


?>
