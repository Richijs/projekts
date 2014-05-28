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
        'no-access' => 'No access to this action',
        'not-authorized' => 'Not authorized to do this action',
        'non-existent-user' => 'Non existent User',
        'non-existent-vacancie' => 'Non existent Vacancie',
        'account-inactive' => 'This Account is Inactive!',
        'logout-first' => 'Must log out first!',
    
        
        //applications
	'before-applying-vacancie' => 'Before applying any Vacancie, first, You must add Your job seeker data',
        'applied-vacancie-successfully' => 'Applied this Vacancie successfully',
        'applying-vacancie-failed' => 'Applying Vacancie failed',
        'already-applied-vacancie' => 'Already applied this Vacancie',
        'non-existent-application' => 'Non existent Application',
        'application-deleted-successfully' => 'Application with id: :id deleted successfully',
        'wrong-couldnt-delete-application' => 'Something went wrong - could not delete Application',
        'couldnt-delete-application' => 'Could not delete Application',
        'edited-application-successfully' => 'Edited application successfully',
        'editing-application-failed' => 'Editing application was unsuccessful',
        'cant-apply-own-vacancie' => 'You can not apply Your own Vacancie',
    
        //lang
        'preflang-changed' => 'Preferred user language changed to :lang',
        'lang-changed' => 'Language changed to :lang',
        'lang-already-is' => 'Language already is set to :lang',
        'non-existent-lang' => 'Non existent Language - :lang',
    
        //messaging
        'email-sent-to-admin' => 'Email was sent to Administrator: :admin',
        'no-admins' => 'No Administrators found in the system',
        'email-notSent-to-admin' => 'Email was not sent to an Administrator',
        'message-sent' => 'Message Sent',
        'sending-message-failed' => 'Sending Message Failed',
        'non-existent-message' => 'Non existent Message',
        'message-deleted-successfully' => 'Message ":subject" deleted successfully',
        'could-not-delete-message' => 'Could not delete Message',
    
    
        //recommendations
        'cant-recommend-yourself' => 'Were You really trying to recommend Yourself?',
        'cant-recommend-non-employer' => ':user is not an Employer',
        'no-such-user' => 'No such user',
        'unrecommended' => 'Unrecommended :user',
        'couldnt-unrecommend' => 'Could not unrecommend :user',
        'recommended' => 'Recommended :user',
        'couldnt-recommend' => 'Could not recommend :user',
        'non-existent-employer' => 'No Employer with such ID',
        'not-an-employer' => 'This user is not an Employer',
            
        //seekers
        'jobseek-saved-now-apply' => 'Job Seeker data has been saved - now you can apply the vacancie you tried to apply',
        'jobseek-saved' => 'Job Seeker data has been saved',
        'jobseek-not-saved' => 'Could not save Job Seeker data',
        'jobseek-not-added' => 'Could not add Job Seeker data',
        'already-added-jobseek' => 'Already added Your Job Seeker data',
        'non-existent-jobseek' => 'No such Job Seek data with this ID',
        'couldnt-download-cv' => 'Could not download CV',
        'edited-your-job-seek' => 'Edited Your Job Seek data successfully',
        'edited-job-seek' => 'Edited Job Seek data (:seek) successfully',
        'couldnt-edit-job-seek' => 'Could not edit Job Seek data',
        'deleted-job-seek' => 'Deleted Job Seek data (:seek) successfully',
        'wrong-couldnt-delete-job-seek' => 'Something went wrong - could not delete Job Seek data',
        'couldnt-delete-job-seek' => 'Could not delete Job Seek data',
    
        //users
        'logged-in' => 'Successfully logged in',
        'not-activated-or-incorrect' => 'Could not log in - Account not activated and/or incorrect password',
        'wrong-user-pass' => 'Could not log in - Wrong username or password',
        'couldnt-login' => 'Could not log in',
        'email-sent-to' => 'Email was sent to :email',
        'not-activated-yet' => 'Account not activated yet - check your E-mail',
        'couldnt-send-email' => 'E-mail could not be sent',
        'password-changed' => 'Your password was changed successfully, :user',
        'not-your-email-or-not-activated' => 'Not Your e-mail address or account not activated Yet. Check Your e-mail address',
        'couldnt-change-pass-tryagain' => 'Could not change password. Try again.',
        'couldnt-change-pass' => 'Could not change password',
        'email-sent-to-complete-registration' => 'E-mail was sent to :email to complete registration process',
        'couldnt-register' => 'Could not register',
        'registered-now-login' => 'Registered successfully. You can now log in!',
        'invalid-link-or-activated' => 'The operation failed - invalid activisation link or user already activated',
        'edited-your-profile' => 'Edited Your profile successfully',
        'edited-profile' => 'Edited :user profile successfully',
        'couldnt-edit-userdata' => 'Could not edit User data',
        'password-changed-authuser' => 'Successfully changed Your password',
        'wrong-current-password' => 'Wrong current password',
        'not-logged-in' => 'You are not logged in',
        'logged-out' => 'Successfully logged out',
        'deleted-profile' => 'Successfully deleted profile :user',
        'wrong-password' => 'Wrong password',
        'couldnt-delete-profile' => 'Could not delete profile',
        'password-reset' => 'Password reset',
    
        //vacancies
        'vacancie-offer-saved' => 'Vacancie offer has been saved',
        'couldnt-add-vacancie' => 'Could not add Vacancie',
        'edited-your-vacancie' => 'Edited Your Vacancie successfully',
        'edited-vacancie' => 'Edited Vacancie (:vacancie) successfully',
        'couldnt-edit-vacancie' => 'Could not edit Vacancie',
        'deleted-vaccancie' => 'Deleted Vacancie (:vacancie) successfully',
        'wrong-couldnt-delete-vacancie' => 'Something went wrong - could not delete Vacancie',
        'couldnt-delete-vacancie' => 'Could not delete Vacancie',
    
    
);