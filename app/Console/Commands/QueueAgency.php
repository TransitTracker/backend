<?php

namespace App\Console\Commands;

use App\Agency;
use App\Jobs\DispatchAgencies;
use Illuminate\Console\Command;

class QueueAgency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agency:refresh {agency}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will refresh the specified agency vehicles';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        DispatchAgencies::dispatch(Agency::where('slug', $this->argument('agency'))->get())->onQueue('vehicles');
    }
}
