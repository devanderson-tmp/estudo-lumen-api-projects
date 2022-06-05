<?php

namespace App\Console\Commands;

use Database\Seeders\UserSeeder;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * @var string
     */
    protected $signature = 'db:seed {email=devanderson.tech@gmail.com} {password=123}';

    /**
     * @var string
     */
    protected $description = 'Create a user account';

    public function handle(UserSeeder $userSeeder)
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $userSeeder->run($email, $password);
    }
}
