<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Messages Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines are used by the flash messages displayed to
        | the User.
	|
	*/
    
        //global
        'no-access' => 'Nav pieeja šai darbībai',
        'not-authorized' => 'Neesat autorizēts lai veiktu šo darbību',
        'non-existent-user' => 'Neeksistējošs Lietotājs',
        'non-existent-vacancie' => 'Neeksistējoša Vakance',
        'account-inactive' => 'Šis profils ir neaktīvs!',
        'logout-first' => 'Vispirms jāatsakās no sistēmas!',
    
        
        //applications
	'before-applying-vacancie' => 'Pirms pieteikšanās jebkurai Vakancei, vispirms, jums ir jānorāda savi darba meklētāja dati',
        'applied-vacancie-successfully' => 'Veiksmīgi pieteicāties šai Vakancei',
        'applying-vacancie-failed' => 'Pieteikšanās vakancei neveiksmīga',
        'already-applied-vacancie' => 'Jau esat pieteicies šai Vakancei',
        'non-existent-application' => 'Neeksistējoša Vakance',
        'application-deleted-successfully' => 'Pieteikums ar id numuru: :id tika veiksmīgi izdzēsts',
        'wrong-couldnt-delete-application' => 'Kaut kas nogāja greizi - neizdevās dzēst pieteikumu',
        'couldnt-delete-application' => 'Neizdevās dzēst pieteikumu',
        'edited-application-successfully' => 'Pieteikums veiksmīgi rediģēts',
        'editing-application-failed' => 'Neizdevās rediģēt pieteikumu',
        'cant-apply-own-vacancie' => 'Nav iespējams pieteikties pats savai Vakancei',
    
        //lang
        'preflang-changed' => 'Vēlamā valoda nomainīta uz :lang',
        'lang-changed' => 'Valoda nomainīta uz :lang',
        'lang-already-is' => 'Valoda jau ir uzstādīta - :lang',
        'non-existent-lang' => 'Neeksistējoša valoda - :lang',
    
        //messaging
        'email-sent-to-admin' => 'E-pasts tika nosūtīts Administratoram: :admin',
        'no-admins' => 'Sistēmā netika atrasts neviens Administrators',
        'email-notSent-to-admin' => 'E-pasts Administratoram netika nosūtīts',
        'message-sent' => 'Ziņa nosūtīta',
        'sending-message-failed' => 'Neizdevās nosūtīt Ziņu',
        'non-existent-message' => 'Neeksistējoša Ziņa',
        'message-deleted-successfully' => 'Ziņa ":subject" veiksmīgi izdzēsta',
        'could-not-delete-message' => 'Neizdevās dzēst ziņu',
    
    
        //recommendations
        'cant-recommend-yourself' => 'Vai Jūs tiešām centāties rekomendēt pats sevi?',
        'cant-recommend-non-employer' => ':user nav darba devējs',
        'no-such-user' => 'Nav šāda Lietotāja',
        'unrecommended' => 'Atcelta :user rekomendācija',
        'couldnt-unrecommend' => 'Neizdevās atcelt :user rekomendāciju',
        'recommended' => ':user tika rekomendēts',
        'couldnt-recommend' => 'Neizdevās rekomendēt :user',
        'non-existent-employer' => 'Nav darba devēja ar šādu ID numuru',
        'not-an-employer' => 'Šis lietotājs nav darba devējs',
            
        //seekers
        'jobseek-saved-now-apply' => 'Darba meklētāja dati tika saglabāti - tagad jūs varat turpināt pieteikšanos vakancei',
        'jobseek-saved' => 'Darba meklētāja dati tika saglabāti',
        'jobseek-not-saved' => 'Neizdevās saglabāt darba meklētāja datus',
        'jobseek-not-added' => 'Neizdevās pievienot darba meklētāja datus',
        'already-added-jobseek' => 'Jūs jau esat pievienojis savus darba meklētāja datus',
        'non-existent-jobseek' => 'Nav darba meklētāja datu ar šādu ID numuru',
        'couldnt-download-cv' => 'Neizdevās lejupielādēt CV',
        'edited-your-job-seek' => 'Veiksmīgi rediģējāt savus darba meklētāja datus',
        'edited-job-seek' => 'Veiksmīgi rediģējāt darba meklētāja datus (:seek)',
        'couldnt-edit-job-seek' => 'Neizdevās rediģēt darba meklētāja datus',
        'deleted-job-seek' => 'Veiksmīgi izdzēsāt darba meklētāja datus (:seek)',
        'wrong-couldnt-delete-job-seek' => 'Kaut kas nogāja greizi - neizdevās dzēst darba meklētāja datus',
        'couldnt-delete-job-seek' => 'Neizdevās dzēst darba meklētāja datus',
    
        //users
        'logged-in' => 'Veiksmīgi pieteicāties sistēmā',
        'not-activated-or-incorrect' => 'Neizdevās pieteikties sistēmā - Profils nav aktivizēts un/vai nepareiza Parole',
        'wrong-user-pass' => 'Neizdevās pieteikties sistēmā - nepareizs Lietotājvārds vai Parole',
        'couldnt-login' => 'Neizdevās pieteikties sistēmā',
        'email-sent-to' => 'E-pasts tika nosūtīts uz :email',
        'not-activated-yet' => 'Profils vēl nav aktivizēts - pārbaudiet savu E-pastu',
        'couldnt-send-email' => 'Nevarēja nosūtīt E-pastu',
        'password-changed' => 'Jūsu parole tika veiksmīgi nomainīta, :user',
        'not-your-email-or-not-activated' => 'Šī nav Jūsu E-pasta adrese vai profils vēl nav aktivizēts - pārbaudiet savu E-pastu',
        'couldnt-change-pass-tryagain' => 'Neizdevās nomainīt Paroli. Mēģiniet vēlreiz.',
        'couldnt-change-pass' => 'Neizdevās nomainīt paroli',
        'email-sent-to-complete-registration' => 'E-pasts tika nosūtīts uz :email lai pabeigtu reģistrācijas procesu',
        'couldnt-register' => 'Neizdevās reģistrēties',
        'registered-now-login' => 'Veiksmīgi reģistrējāties. Tagad Jūs varat pieteikties sistēmā!',
        'invalid-link-or-activated' => 'Neveiksmīga operācija - nekorekta aktivizācijas saite vai Lietotājs jau ir aktivizēts',
        'edited-your-profile' => 'Veiksmīgi rediģējāt savu profilu',
        'edited-profile' => 'Veiksmīgi rediģējāt :user profilu',
        'couldnt-edit-userdata' => 'Neizdevās rediģēt lietotāja datus',
        'password-changed-authuser' => 'Jūsu parole tika veiksmīgi nomainīta',
        'wrong-current-password' => 'Nepareiza pašreizējā parole',
        'not-logged-in' => 'Jūs neesat pieteicies sistēmā',
        'logged-out' => 'Veiksmīgi atteicāties no sistēmas',
        'deleted-profile' => 'Profils :user tika veiksmīgi izdzēsts',
        'wrong-password' => 'Nepareiza parole',
        'couldnt-delete-profile' => 'Neizdevās dzēst profilu',
        'password-reset' => 'Paroles atiestatīšana',
    
        //vacancies
        'vacancie-offer-saved' => 'Vakances piedāvājums tika veiksmīgi saglabāts',
        'couldnt-add-vacancie' => 'Neizdevās pievienot Vakanci',
        'edited-your-vacancie' => 'Veiksmīgi rediģējāt Jūsu Vakanci',
        'edited-vacancie' => 'Veiksmīgi rediģējāt Vakanci (:vacancie)',
        'couldnt-edit-vacancie' => 'Neizdevās rediģēt Vakanci',
        'deleted-vaccancie' => 'Vakance (:vacancie) tika veiksmīgi izdzēsta',
        'wrong-couldnt-delete-vacancie' => 'Kaut kas nogāja greizi - Neizdevās izdzēst Vakanci',
        'couldnt-delete-vacancie' => 'Neizdevās izdzēst Vakanci',
    
    
);