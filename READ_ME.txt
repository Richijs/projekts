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

jauztaisa file delete pie profila dzesanas,editoshanas, vakancēm n stuff
VISUR, KUR JĀATTĒLO TEXTAREA AR LINE BREAKIEM - cssā->  white-space:pre-line;    !!!!!!!!!!!!!!!!!!!!!!!!

jauztaisa lai admins var mainit usergroupas uz ADMIN UTT!
NEVAR ZINĀT KAS NOTIEK, KAD SAMAINA GRUPU uz ZEMĀKU/CITU!! (izdzēš viņa ierakstus!)

->withInput(Input::all()) strādā!

neImplementē ban!

kautkas jāizdara ar file upload lai būtu correct. moš noņemt liekos formātus.

varbūt uztaisīt mainīgu content no datubāzes, ko var editot admins.

jāuztaisa normāls redirect no ->apply vacancie (ja nav seeker data) -> add seeker data -> apply vacancie back uz to pašu
(tas laikam jāpaglabā sesijā)

varētu pielikt slaiderus sākumlapā, kā arī default bildes useriem/vakancēm bez bildēm !!!

varētu pie get pieprasijuma kontrolierī visu salikt kompaktāk   data[smth] uz data[ smth=>smth, smth=>smth ]

varbūt salikt belongs to, has many iekš eloquent Modeļiem??
http://scotch.io/tutorials/php/a-guide-to-using-eloquent-orm-in-laravel

jāsaliek normāli latvian language translation validation attributes, lai nerāda "phone lauks ir nepieciešams",bet
"telefona lauks ir nepieciešams"

Skatos jāsaliek default bildes Useriem bez bildēm (ghost face) un vakancēm (ghost vacancie) !!

File delete strādā. Gitā to grūti pamanīt (nerādās deleted, ja tikko pievienots jauns fails)
(editojot kko/dzēšot nesen pievienotos failus utt)

garajiem sarakstiem nice būtu nested media no BOOTSTRAP!

btn bootstrap stilu var likt iekšā pa taisno <a> tagos !!
jāpārveido visi linku buttoni tā!!

Tulkojumos ir nice lieta - Attributes. Jāsavada priekš LV validācijas messagiem !!

Back / atgriezties uz profilu / utt progas būtu labi !!

view all vajag orderBy created_at , lai jaunākie rādītos pirmajās lapās !!

jāimprovizē globālais search. Piem , meklējot kko, atgriež
"Result returned 5 users , 3 vacancies and 7 job seeker data" !!!

Jāsalabo visi skati!!!

Newline text ņem vērā arī visus iekš-koda newline, uzreiz aiz <div class="newlineText">

messaging?

all-users - nepareizas tiesības

recommend employer pie view profile

jāsalabo viewRecs poga