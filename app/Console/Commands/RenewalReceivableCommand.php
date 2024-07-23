<?php

namespace App\Console\Commands;

use App\Models\CustomerService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RenewalReceivableCommand extends Command
{
    const GIA_HAN = 1;
    const CNGH = 1;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receivable:renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command performs a daily receivable renewal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $recevables = CustomerService::select(
            'customer_service.id',
            'customer_service.customer_id',
            'customer_service.service_id',
            'customer_service.time',
            'customer_service.started_at',
            'customer_service.ended_at',
            'customer_service.note'
        )
        ->leftjoin('services', 'services.id', 'customer_service.service_id')
        ->where('services.type', self::GIA_HAN)
        ->whereDate('ended_at', $now)
        ->get();

        if(!empty($recevables)){
            foreach($recevables as $recevable){
                $endDate = Carbon::now()->addMonths($recevable->time);
                $params = [
                    'signed_date' => $recevable->signed_date,
                    'contract_value' => '0',
                    'amount_owed' => '0',
                    'customer_id' => $recevable->customer_id,
                    'type' => self::CNGH,
                ];
            }
        }
    }
}
