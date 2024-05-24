<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Services\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class UpdateCustomerPasswordAndSendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $customer;
    /**
     * Create a new job instance.
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $password = rand(111111, 999999); // Rastgele şifre oluşturma
        $this->customer->password = Hash::make($password);
        $this->customer->save();
        $message = "Kuaför Savaş işletmesinin randevu sistemi https://hizlirandevu.com.tr/salon/kuafor-savas adresine taşınmıştır. Randevularınızı bu sistem üzerinden alabilirsiniz. Hızlı Randevu sistemine giriş yapmak için https://hizlirandevu.com.tr/customer/login bu linki kullanabilirsiniz. Giriş Yapmak için kullanıcı bilgileriniz ".$this->customer->phone." Şifreniz: ". $password;

        // Burada SMS gönderme kodunuzu ekleyin
        Sms::send($this->customer->phone, $message);
    }
}
