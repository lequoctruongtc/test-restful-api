<?php

namespace App\Console\Commands;

use App\Services\LoanService;
use Illuminate\Console\Command;

class ApproveLoans extends Command
{
    protected $loanService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loan:approve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve all loan for users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Start approve');
        $loans = $this->loanService->all();
        foreach ($loans as $loan) {
            $this->loanService->approve($loan->id);
        }
        $this->info('Approve successful');

        return Command::SUCCESS;
    }
}
