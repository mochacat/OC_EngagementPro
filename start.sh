#!/bin/bash

while ! timeout 1 bash -c 'cat < /dev/null > /dev/tcp/mysql/3306'; do sleep 0.1; done

apache2 -DFOREGROUND

if [ -d install ]; then
  echo "starting OpenCart install..."
  
  php install/cli_install.php install --db_hostname mysql \
  --db_username root \
  --db_password admin \
  --db_database opencart \
  --db_driver mysqli \
  --db_port 3306 \
  --http_server http://localhost:8080/ \
  --username admin \
  --password admin \
  --email youremail@example.com \
  && rm -r install
fi
