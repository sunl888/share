#!/bin/bash

mysql -u${DB_USERNAME} -p${DB_PASSWORD} <<EOF
use share  <<EOF
source /var/www/docker-entrypoint-initdb.d/share.sql
EOF