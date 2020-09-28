vendor/bin/doctrine orm:generate-proxies

php > echo password_hash('123456', PASSWORD_ARGON2I);
vendor/bin/doctrine dbal:run-sql "INSERT INTO usuarios (email, senha) VALUES ('filipe1309@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$WG1ET3hqQlU5Yjh3UHdkOA$cHTRBxDVNBYwwrNREYNVBpujxsVLCY+0gtJSmTUed2E')"