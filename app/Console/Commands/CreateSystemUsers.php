<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use App\Models\User;
use App\Core\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

#[Signature('app:create-system-users {--default : Create users with default credentials}')]
#[Description('Create Admin, Moderator, and Developer accounts in the database')]
class CreateSystemUsers extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('--- System Users Creator Script ---');

        if ($this->option('default')) {
            $this->createDefaultUsers();
            return SymfonyCommand::SUCCESS;
        }

        $this->createInteractiveUsers();
        return SymfonyCommand::SUCCESS;
    }

    protected function createDefaultUsers()
    {
        $users = [
            [
                'role' => UserRole::ADMIN,
                'name' => 'System Administrator',
                'email' => 'admin@devnexus.io',
                'password' => 'password',
            ],
            [
                'role' => UserRole::MODERATOR,
                'name' => 'Sarah Jenkins',
                'email' => 'sarah.j@techcloud.com',
                'password' => 'password',
            ],
            [
                'role' => UserRole::DEVELOPER,
                'name' => 'Mike Ross',
                'email' => 'mike@ross.dev',
                'password' => 'password',
            ],
        ];

        foreach ($users as $userData) {
            $this->saveUser($userData);
        }

        $this->info('Default system users created successfully.');
    }

    protected function createInteractiveUsers()
    {
        $roles = [
            'Admin' => UserRole::ADMIN,
            'Moderator' => UserRole::MODERATOR,
            'Developer' => UserRole::DEVELOPER,
        ];

        foreach ($roles as $roleLabel => $roleEnum) {
            $this->info("\nCreating {$roleLabel} Account:");
            
            $name = $this->ask("Enter Name for {$roleLabel}", "{$roleLabel} User");
            
            $email = $this->ask("Enter Email for {$roleLabel}");
            while (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error('Please enter a valid email address.');
                $email = $this->ask("Enter Email for {$roleLabel}");
            }

            $password = $this->secret("Enter Password for {$roleLabel}");
            while (empty($password)) {
                $this->error('Password cannot be empty.');
                $password = $this->secret("Enter Password for {$roleLabel}");
            }

            $this->saveUser([
                'role' => $roleEnum,
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);
        }

        $this->info("\nAll system users created successfully.");
    }

    protected function saveUser(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        $isNew = !$user;

        if ($isNew) {
            $user = new User();
            $user->email = $data['email'];
        }

        $user->name = $data['name'];
        $user->password = Hash::make($data['password']);
        $user->role = $data['role'];
        $user->status = 'active';
        $user->save();

        $action = $isNew ? 'Created' : 'Updated';
        $this->line(" - [{$action}] Role: <comment>{$data['role']->value}</comment> | Name: <info>{$data['name']}</info> | Email: <info>{$data['email']}</info>");
    }
}
