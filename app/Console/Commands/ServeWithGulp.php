<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeWithGulp extends Command
{
  protected $signature = 'serve:dev';
  protected $description = 'Serve the application with gulp watch';

  public function handle()
  {
    $this->info('Starting Laravel development server and gulp watch...');

    // Start Laravel server in background
    $serve = new Process(['php', 'artisan', 'serve', '--host=127.0.0.1', '--port=8000']);
    $serve->setTty(true);
    $serve->start();

    // Give Laravel a moment to start
    sleep(2);

    // Start gulp with dev task
    $gulp = new Process(['gulp', 'dev']);
    $gulp->setTty(true);
    $gulp->start();

    // Keep the command running and handle process output
    while ($serve->isRunning() && $gulp->isRunning()) {
      usleep(500000);
    }

    // Cleanup processes
    $serve->stop();
    $gulp->stop();
  }
}
