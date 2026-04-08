<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {name?} {email?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user securelly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?: $this->ask('Enter admin name');
        $email = $this->argument('email') ?: $this->ask('Enter admin email');
        $password = $this->argument('password') ?: $this->secret('Enter admin password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("- $error");
            }
            return 1;
        }

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role = 'admin';
        $user->save();

        $this->info("Admin user '{$name}' created successfully!");
        return 0;
    }
}
