<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class HashidSalt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hashid:generate';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the hashid salt in .env';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $key = $this->generateRandomKey();
        $this->setKeyInEnvironmentFile($key);
        $this->laravel['config']['hashids.connections.main.salt'] = $key;
        $this->info("JWT key [$key] set successfully.");
    }

    /**
     * Set the application key in the environment file.
     *
     * @param string $key
     *
     * @return void
     */
    protected function setKeyInEnvironmentFile($key)
    {
        file_put_contents($this->laravel->environmentFilePath(), str_replace(
            'HASHID_SALT='.$this->laravel['config']['hashids.connections.main.salt'],
            'HASHID_SALT='.$key,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    /**
     * Generate a random key for the application.
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return str_random(10);
    }
}
