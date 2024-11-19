<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteUnpaidTransactions extends Command
{
    protected $signature = 'app:delete-unpaid-transactions';

    protected $description = 'This command is to delete the unpaid transactions after 1 hour';

    public function handle()
    {
        $transactions = Transaction::where('created_at', '<', Carbon::now()->subHour())
            ->unpaid()->get();

        foreach ($transactions as $transaction) {
            $transaction->delete();
        }

        $this->info('The unpaid transactions has been deleted');
    }
}
