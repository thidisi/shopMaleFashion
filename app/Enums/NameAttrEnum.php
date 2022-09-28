<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NameAttrEnum extends Enum
{
    public const SIZE = 1;
    public const COLOR = 2;
    public const SIZE_SET = 7;
    public const SIZE_SHOE = 5;
    public const SIZE_BAG = 6;
}
