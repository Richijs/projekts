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
            
        ];
        foreach ($messages as $message)
        {
            Message::create($message);
        }
    }
}