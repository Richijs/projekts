IEKŠ ABIEM PHP.ini VAJAG ENABLE

;extension=php_fileinfo.dll  -> extension=php_fileinfo.dll



VAJAG RUN 
 composer update
!!!!!!

pectam arī php artisan migrate reset utt


php artisan migrate:make --table="vacancies" CreateVacanciesTable