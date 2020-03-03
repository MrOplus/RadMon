#Preconfig
* rename config.php.example to config.php  
* set your credentials in config.php
* run `composer install` to install Radius plugin 

#CONSTANTS
CONSTANT    | VALUE
----------- | ------------
BOT_TOKEN   | Telegram Bot Token
CHAT_ID     | ChannelID or CHAT ID of notification center
SSH_HOST    | SSH Host to perform reboot command
SSH_USERNAME    | SSH Username
SSH_PASSWORD    | SSH Password
FATAL_COUNT | FATAL failure number (perform ssh command)
RADIUS_SERVER | Target Radius Server
RADIUS_SECRET | Target Radius Secret
ACCOUNTING_USERNAME | Username (basic access request)
ACCOUNTING_PASSWORD | Password (basic access request)

#Cron
`5 * * * * /usr/bin/php /home/username/RadMon/main.php >/dev/null 2>&1`
 