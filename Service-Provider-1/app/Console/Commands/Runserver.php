<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;


class Runserver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $this->info('Starting server at http://serviceprovider1.local:8000');

        // $process = Process::fromShellCommandline('php artisan serve --host=serviceprovider1.local --port=8000');
        // $process->setTty(true); // allows interactive output
        // $process->run();

        $this->call('serve', [
        '--host' => 'serviceprovider1.local',
        '--port' => '8000',
        ]);
    }
}
