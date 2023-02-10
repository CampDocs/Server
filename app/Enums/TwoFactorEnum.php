<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TwoFactorEnum extends Enum
{
    public const NONE = 'none';

    public const APP = 'app';

    public const SMS = 'sms';

    public const EMAIL = 'email';
}
