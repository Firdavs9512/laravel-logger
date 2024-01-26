<?php

namespace Firdavs9512\LaravelLogger\Commands;

use Firdavs9512\LaravelLogger\Models\Log;
use Illuminate\Console\Command;

class DeleteLogs extends Command
{
    protected $signature = 'logger:delete';

    protected $description = 'Delete all old logs';

    public function handle()
    {
        $this->info('Deleting old logs...');

        Log::where('created_at', '<', now())->delete();

        $this->info('All old logs deleted!');
    }
}
