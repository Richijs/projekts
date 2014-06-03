<?php
class MessageSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $messages = [
            [
                "sender_id" => 3,
                "receiver_id" => 1,
                "subject" => 'Jautājums',
                "message" => 'Vai vietnē ir iespējams dzēsties no tās?',
            ],
            [
                "sender_id" => 2,
                "receiver_id" => 3,
                "subject" => 'Paldies par iesniegumu',
                "message" => 'Mēs to izskatīsim\r\nun dosim jums ziņu...',
            ],
            [
                "sender_id" => 1,
                "receiver_id" => 2,
                "subject" => 'Hello ,blake',
                "message" => 'How YOU doin?',
            ],
            [
                "sender_id" => 4,
                "receiver_id" => 5,
                "subject" => 'Hey',
                "message" => 'veselīgs spams :) čau',
            ],
            [
                "sender_id" => 4,
                "receiver_id" => 6,
                "subject" => 'Hey',
                "message" => 'veselīgs spams :) čau\r\np.s. ļoti interesanta profila bilde',
            ],
            
        ];
        foreach ($messages as $message)
        {
            Message::create($message);
        }
    }
}