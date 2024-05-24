<?php

namespace App\Console\Commands;

use App\Jobs\UpdateCustomerPasswordAndSendSms;
use App\Models\Customer;
use Illuminate\Console\Command;

class UpdatePasswordsAndSendSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-passwords-and-send-sms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $customers = Customer::whereStatus(1)->skip(330)->get();

        foreach ($customers as $customer) {
            UpdateCustomerPasswordAndSendSms::dispatch($customer);
        }

        $this->info('Şifreler güncellendi ve SMS gönderimi başlatıldı.');
    }
}
