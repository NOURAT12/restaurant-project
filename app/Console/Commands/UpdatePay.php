<?php

namespace App\Console\Commands;

use App\Models\MonthlyPay;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Status Of Pay';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pays=MonthlyPay::where('is_paid',true)->get();
        foreach ($pays as $pay ) {
            $date= $pay->end;
            $date = Carbon::parse($date);
            if ($date->isBefore(Carbon::today()) || $date->isSameDay(Carbon::today())) {
                $pay->is_paid=false;
                $pay->save();
            }
         }

    }
}
