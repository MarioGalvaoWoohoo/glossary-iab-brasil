<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 *  @method static static Pending()
 *  @method static static Paid()
 *  @method static static Late()
 *  @method static static Unpaid()
 */
final class ExpensePaymentStatus extends Enum
{
    const Pending = 0;
    const Paid = 1;
    const Late = 2;
    const Unpaid = 3;
}
