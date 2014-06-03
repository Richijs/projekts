IEKŠ ABIEM PHP.ini ENABLE

;extension=php_fileinfo.dll  -> extension=php_fileinfo.dll



 RUN 
 composer update
!!!!!!

pectam arī php artisan migrate reset utt


php artisan migrate:make --table="vacancies" CreateVacanciesTable


php artisan migrate:make --table="seekers" CreateSeekersTable

php artisan migrate:make --table="applications" CreateApplicationsTable

php artisan migrate:make --table="recommendations" CreateRecommendationsTable

php artisan migrate:make --table="messages" CreateMessagesTable

