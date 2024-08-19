<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateDeliveryStatus extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delivery:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update delivery isonline status to 0 every day after 12 AM';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // تحديث حالة isonline لكل عمليات التسليم إلى 0
        User::where('is_online', 1)->update(['is_online' => 0]);

        $this->info('Delivery status updated successfully.');
    }
}
