#!/bin/sh

exec mysql -v -u $DB_USER -h $DB_HOST -p$DB_PASS $DB_NAME < /init.sql
