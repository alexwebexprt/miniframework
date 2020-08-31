# test-php-ppp

requires:
php 7.*
extension=pdo_sqlite

RUN: public_html/server.cmd 

cd public_html
run: server.cmd
