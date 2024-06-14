<?php

namespace App\Console\Commands;

use App\Http\Controllers\TeacherController;
use Illuminate\Console\Command;

class TiempoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tiempo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    protected $teacherController;

    public function __construct(TeacherController $teacherController)
    {
        parent::__construct();
        $this->teacherController = $teacherController;
    }

    public function handle()
    {
        $this->teacherController->tiempo();
        $this->info('Reminder emails sent successfully!');
    }
}
