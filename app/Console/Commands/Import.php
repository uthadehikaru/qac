<?php

namespace App\Console\Commands;

use App\Imports\ImportAlumni;
use Illuminate\Console\Command;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:alumni';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Alumni QAC';

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
     * @return int
     */
    public function handle()
    {
        $this->output->title('Starting import');
        (new ImportAlumni)->withOutput($this->output)->import(storage_path('app/import.xlsx'));
        $this->output->success('Import successful');
    }
}
