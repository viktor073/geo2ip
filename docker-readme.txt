ВАЖНО:
добавить символическую ссылку на корень сайта
ln -s . html


так же необходмо добавить в .gitignore следующие записи

.env
/html
/Docker/sql/*
/Docker/httpd/mail/*
/Docker/mariadb/*
/Docker/elasticsearch/data/*
!/Docker/mariadb/readme.txt
!/Docker/elasticsearch/data/readme.txt
!/Docker/httpd/mail/readme.txt
!/Docker/sql/readme.txt


