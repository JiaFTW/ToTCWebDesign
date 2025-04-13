<?php
$services = ['apache2', 'rabbitmq-server', 'mysql']; // Add more services as needed

foreach ($services as $service) {
    $status = shell_exec("systemctl is-active $service");
    if (trim($status) !== 'active') {
        echo "🔧 Restarting $service ...\n";
        shell_exec("sudo systemctl start $service");
    } else {
        echo "✅ $service is running.\n";
    }
}
?>
