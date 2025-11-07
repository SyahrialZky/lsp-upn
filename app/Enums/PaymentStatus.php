<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Unpaid  = 'unpaid';
    case Waiting = 'waiting';
    case Paid    = 'paid';
    case Failed  = 'failed';
}
