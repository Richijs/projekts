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
            
        ];
        foreach ($messages as $message)
        {
            Message::create($message);
        }
    }
}