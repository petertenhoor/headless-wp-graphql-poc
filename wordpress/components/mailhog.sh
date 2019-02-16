#!/usr/bin/env bash

# Get state (1 or 0) if file exists
fileExists() {
    local return_=0
    if [ -f "$1" ]; then local return_=1; fi;
    echo "$return_";
}

# Get state (1 or 0) if binary exists
binaryExists() {
    local return_=1
    type $1 > /dev/null 2>&1 || { local return_=0; }
    echo "$return_";
}

echo " ==> Prepare installing mailhog...";

# get binary exists
mailhogInstalled=$(binaryExists "mailhog");
mhsendmailInstalled=$(binaryExists "mhsendmail");

# get file exists
hasConfigfile=$(fileExists "/etc/init/mailhog.conf");
hasPhpMod=$(fileExists "/etc/php/7.1/mods-available/mhsendmail.ini");

# vagrant guest box ip address
vagrantPrivateIp=$(hostname -I | cut -d ' ' -f2 | xargs echo -n);

# 1. Install mailhog when is not installed
if [ $mailhogInstalled -eq 0 ]; then
    echo " ==> Installing mailhog binary...";
    if [ ! -f \"MailHog_linux_amd64\" ]; then wget https://github.com/mailhog/MailHog/releases/download/v0.1.8/MailHog_linux_amd64; fi;
    chmod +x MailHog_linux_amd64;
    mv MailHog_linux_amd64 /usr/local/bin/mailhog;
else 
    echo " ==> mailhog binary is already installed";
fi

# 2. Install mhsendmail, a replacement for sendmail that sends mail to the mailhog smtp server 
if [ $mhsendmailInstalled -eq 0 ]; then
    echo " ==> Installing mhsendmail binary..."
    if [ ! -f \"mhsendmail_linux_amd64\" ]; then wget https://github.com/mailhog/mhsendmail/releases/download/v0.1.9/mhsendmail_linux_amd64; fi;
    chmod +x mhsendmail_linux_amd64;
    mv mhsendmail_linux_amd64 /usr/local/bin/mhsendmail;
else
    echo " ==> mhsendmail binary is already installed";
fi

# 3. Create configuration file `init` to start mailhog
if [ $hasConfigfile -eq 0 ]; then
    echo " ==> Add mailhog to startup scripts..."
    cat > /etc/init/mailhog.conf << EOL
description \"Mailhog\"
start on runlevel [2345]
stop on runlevel [!2345]
respawn
pre-start script
    exec su - vagrant -c "/usr/bin/env /usr/local/bin/mailhog > /dev/null 2>&1 &"
end script
EOL
else
    echo " ==> Mailhog is already added to startup scripts"; 
fi

# 4. Configure php init `sendmail_path`
if [ $hasPhpMod -eq 0 ]; then
    echo " ==> Changing the sendmail_path in php.ini...";
    cat > /etc/php/7.1/mods-available/mhsendmail.ini << EOL
sendmail_path = /usr/local/bin/mhsendmail test@test.com
EOL
else
    echo " ==> sendmail_path in php.ini is already been set";
fi

# 5. Enable phpmod
phpenmod mhsendmail

# 6. Start mailhog smtp server
if [ $mailhogInstalled -eq 0 ]; then
    echo " ==> Start mailhog smtp server";
    service mailhog start
fi

# 6. Output message for running SMTP Mailhog server
echo " ==> Mailhog SMTP server running on: $vagrantPrivateIp:8025";
