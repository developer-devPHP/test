<?php
define('MY_CRON_JOB_START', true);
require_once '../index.php';
$sessions_list = glob(MY_SESSION_DIRECTORY . "/sess_*");
foreach ($sessions_list as $ses)
{
	chmod($ses, 0777);
	unlink($ses);
}