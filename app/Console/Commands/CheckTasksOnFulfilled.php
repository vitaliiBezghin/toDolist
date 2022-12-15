<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Carbon\Carbon;
class CheckTasksOnFulfilled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkTasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        return Command::SUCCESS;
        $tasks = Task::chunk(200, function ($task) {
            
        });
    }
}
