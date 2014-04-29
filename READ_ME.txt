IEKŠ ABIEM PHP.ini VAJAG ENABLE

;extension=php_fileinfo.dll  -> extension=php_fileinfo.dll



VAJAG RUN 
 composer update
!!!!!!

pectam arī php artisan migrate reset utt


php artisan migrate:make --table="vacancies" CreateVacanciesTable


php artisan migrate:make --table="seekers" CreateSeekersTable

php artisan migrate:make --table="applications" CreateApplicationsTable

php artisan migrate:make --table="recommendations" CreateRecommendationsTable

jauztaisa file delete pie profila dzesanas
VISUR, KUR JĀATTĒLO TEXTAREA AR LINE BREAKIEM - cssā->  white-space:pre-line;    !!!!!!!!!!!!!!!!!!!!!!!!

jauztaisa lai admins var mainit usergroupas uz ADMIN UTT!
NEVAR ZINĀT KAS NOTIEK, KAD SAMAINA GRUPU uz ZEMĀKU/CITU!!

->withInput(Input::all()) strādā!