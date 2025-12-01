<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user-command {--name=} {--email=} {--password=} {--role=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user with option to assign roles.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');
        $roles = $this->option('role');

        if (! $name || ! $email || ! $password) {
            $this->error('Name, email, and password are required.');

            return self::FAILURE;
        }

        DB::transaction(function () use ($name, $email, $password, $roles) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);

            $this->info("User {$user->name} created successfully with ID {$user->id}.");

            if (filled($roles)) {
                $user->assignRole($roles);

                $this->info('Assigned roles: '.implode(', ', $roles));
            }

            return self::SUCCESS;
        });

        return self::FAILURE;
    }
}
