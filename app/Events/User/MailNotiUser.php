<?php

namespace App\Events\User;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class MailNotiUser
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;


    /**
     * @var array
     */
    public $param;

    /**
     * MailNotiUser constructor.
     * @param User $user
     */
    public function __construct(User $user, $param)
    {
        $this->user = $user;
        $this->param = $param;
    }
}
