<?php

namespace Payerurl\Events;

class PaymentNotifySuccess
{
    /**
     * @var array<string, mixed>
     */
    public $payload;

    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }
}
