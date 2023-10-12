<?php

namespace App\Events\Customer;

use App\Models\Customer;
use Illuminate\Queue\SerializesModels;

class ForgotPassword
{
    use SerializesModels;

    /**
     * @var Customer
     */
    public $customer;


    /**
     * @var array
     */
    public $param;

    /**
     * MailNotiUser constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer, $param)
    {
        $this->customer = $customer;
        $this->param = $param;
    }
}
