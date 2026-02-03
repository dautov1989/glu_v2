<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user by email address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Пользователь с email {$email} не найден!");
            return Command::FAILURE;
        }

        if (!$this->confirm("Вы уверены, что хотите НАВСЕГДА удалить пользователя {$user->name} ({$email})?")) {
            $this->info('Удаление отменено.');
            return Command::SUCCESS;
        }

        $user->delete();

        $this->info("Пользователь {$email} был успешно удален.");
        return Command::SUCCESS;
    }
}
