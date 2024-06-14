<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ApprenticeController;

class SendEmailsCommand extends Command
{
    protected $signature = 'send:email';
    protected $description = 'Send reminder emails to apprentices';

    protected $apprenticeController;

    public function __construct(ApprenticeController $apprenticeController)
    {
        parent::__construct();
        $this->apprenticeController = $apprenticeController;
    }

    public function handle()
    {
        $this->apprenticeController->sendEmails();
        $this->info('Reminder emails sent successfully!');
    }
}
