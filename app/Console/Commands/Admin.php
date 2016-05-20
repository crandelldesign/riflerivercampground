<?php

namespace riflerivercampground\Console\Commands;

use Illuminate\Console\Command;
use riflerivercampground\User;
use Hash;

class Admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add admin users';

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
        set_time_limit(30*60); // 30 Mins
        ini_set('memory_limit', '1024M');
        $this->info("Begin Adding Admins");

        $counter = 0;
        $user_count = $this->ask('How many admins to add?');
        for ($i=1; $i <= $user_count; $i++) {
            // Call function to add the admins
            $counter = $counter + $this->addAdmin();
        }

        $this->info("Added $counter Admins\n");
    }

    protected function addAdmin()
    {
        $email = $this->ask('What is the email?');
        $user = User::where('email','=',$email)->first();
        if(empty($user)) {
            // If the email is not found, ask questions to get information to add
            $password = $this->secret('What is the password? (Text entered will not be displayed)');
            $name = $this->ask('What is the full name?');
            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->is_admin = 1;
            $user->save();
            $this->info("Loaded $name\n");
            return 1;
        } else {
            $this->error("Email already exists.");
            // If the email is already in the system, ask to run again
            if ($this->confirm('Do you wish to try again for this admin? [y|N]')) {
                $this->addAdmin();
            }
        }
    }
}
