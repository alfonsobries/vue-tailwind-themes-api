<?php

namespace App\Console\Commands;

use App\Models\NewsletterAdmin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateNewsletterAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a newsletter admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->ask('What is your email?');

        $password = $this->secret('What is the password');

        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
        ], [
            'email' => ['required', 'email', 'unique:newsletter_admins,email'],
            'password' => ['required', 'min:6'],
        ]);

        if ($validator->fails()) {
            $this->error('Sorry, we couldn\'t create the newsletter admin, something went wrong while validating the data provided.');

            return false;
        }

        NewsletterAdmin::create([
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info('The newsletter admin was created successfully.');
    }
}
