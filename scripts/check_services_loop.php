<?php
date_default_timezone_set('UTC'); // optional: for consistent timestamps
$logFile = '/var/log/service_monitor_loop.log';

function logMessage($message, $logFile) {
    $timestamp = date("Y-m-d H:i:s");
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

function checkService($name, $logFile) {
    $status = trim(shell_exec("systemctl is-active $name"));

    if ($status !== 'active') {
        logMessage("❌ $name is down. Attempting restart...", $logFile);

        // Try to restart
        $restartOutput = shell_exec("sudo systemctl restart $name 2>&1");
        sleep(1); // give time to restart
        $newStatus = trim(shell_exec("systemctl is-active $name"));

        if ($newStatus === 'active') {
            logMessage("✅ $name restarted successfully.", $logFile);
        } else {
            logMessage("❌ Failed to restart $name. Output: $restartOutput", $logFile);
        }
    } else {
        logMessage("✅ $name is running.", $logFile);
    }
}

// Run loop
while (true) {
    checkService('apache2', $logFile);
    checkService('rabbitmq-server', $logFile);
    checkService('mysql', $logFile);
    echo "Sleeping for 60 seconds...\n";

    sleep(60); // check every 60 seconds
}


// This script checks the status of the specified services and restarts them if they are not running.
// It runs indefinitely, checking the services every 60 seconds.
// Make sure to run this script with appropriate permissions to restart services.
// You can stop the script using Ctrl+C in the terminal.
// Also, ensure that the script has the necessary permissions to execute system commands.
// You can run this script in the background using:
// nohup php check-services-loop.php > output.log 2>&1 &
// This will redirect the output to output.log and run the script in the background.
// To check the status of the script, you can use:
// ps aux | grep check-services-loop.php
// To stop the script, you can find its process ID (PID) using:
// ps aux | grep check-services-loop.php
// and then kill it using:
// kill <PID>
// Make sure to replace <PID> with the actual process ID of the script.

