<?php
date_default_timezone_set('UTC'); // for consistent timestamps

function checkAndRestart($service, $label) {
    $status = trim(shell_exec("systemctl is-active $service"));

    if ($status !== 'active') {
        // Restart it
        shell_exec("sudo systemctl restart $service");
        sleep(1);
        $recheck = trim(shell_exec("systemctl is-active $service"));

        if ($recheck === 'active') {
            echo "<div style='background-color: #ddffdd; padding: 10px; border: 1px solid green; color: green;'>
                    ✅ <strong>$label</strong> was down and has been restarted.
                  </div>";
        } else {
            echo "<div style='background-color: #ffdddd; padding: 10px; border: 1px solid red; color: red;'>
                    ❌ <strong>$label</strong> is still down. Please try again later.
                  </div>";
            exit;
        }
    }
}

// Apache will already be running if this page loads, but checking anyway
checkAndRestart('apache2', 'Apache Web Server');
checkAndRestart('mysql', 'MySQL Database');
checkAndRestart('rabbitmq-server', 'RabbitMQ Message Broker');
