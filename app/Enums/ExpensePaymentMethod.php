<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 *  @method static static Cash()
 *  @method static static DebitCard()
 *  @method static static CreditCard()
 *  @method static static Pix()
 *  @method static static Other()
 */
final class ExpensePaymentMethod extends Enum
{
    const Cash = 0;
    const DebitCard = 1;
    const CreditCard = 2;
    const Pix = 3;
    const Other = 4;
}
