<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Prompt for user details
        $name = $this->ask('What is the user\'s name?');
        $email = $this->ask('What is the user\'s email?');
        $password = $this->secret('What is the user\'s password?'); // Use secret to hide input

        // Confirm the details
        $this->info('You entered the following details:');
        $this->line('Name: ' . $name);
        $this->line('Email: ' . $email);
        $this->line('Password: ' . str_repeat('*', strlen($password)));

        if ($this->confirm('Do you wish to create this user?')) {
            // Create the user
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->info('User created successfully!');
        } else {
            $this->warn('User creation canceled.');
        }
    }
}
