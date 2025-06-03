<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Initialization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run this command to set up everything automaticaly';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        try {
            $this->info('Setting up the program...');

            $installComposer = new Process(['composer', 'install']);
            $res = $installComposer->mustRun();
            $this->info($res->getOutput());

            $this->info('key app is being generated...');
            $this->call('key:generate');

            $this->info('running migrations...');
            $this->call('migrate');

            $this->info('running seeders...');
            $this->call('db:seed');

            $this->info('running server...');
            $this->call('serve');


        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
