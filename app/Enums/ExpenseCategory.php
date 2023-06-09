<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 *  @method static static Food()
 *  @method static static Housing()
 *  @method static static Transportation()
 *  @method static static Entertainment()
 *  @method static static Healthcare()
 *  @method static static Utilities()
 *  @method static static Other()
 */
final class ExpenseCategory extends Enum
{
    const Food = 0;
    const Housing = 1;
    const Transportation = 2;
    const Entertainment = 3;
    const Healthcare = 4;
    const Utilities = 5;
    const Other = 6;

}
