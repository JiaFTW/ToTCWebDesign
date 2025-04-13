#!/bin/bash

# Sync frontend
sudo cp -r /home/ubuntu/totc/web_design_animation/frontend/* /var/www/html/

# Sync backend/api
sudo cp /home/ubuntu/totc/web_design_animation/backend/api/* /var/www/html/backend/api/

# Sync broker
sudo cp -r /home/ubuntu/totc/web_design_animation/broker/* /var/www/html/broker/

echo "🔄 Files synced to /var/www/html"

# Restart Apache server
sudo systemctl restart apache2
echo "🔄 Apache server restarted"
