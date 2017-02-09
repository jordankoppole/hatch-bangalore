#!/usr/bin/env bash

echo "CREATE DATABASE IF NOT EXISTS letscreate" | mysql -u root -pletscreatepass -h mysql
mysql -u root -pletscreatepass -h mysql letscreate < /home/dbschema/letscreate.sql