<?php

namespace App\Enums;

enum OtpPurpose: string
{
    case REGISTRATION = 'registration';

    case LOGIN = 'login';

    case FORGOT_PASSWORD = 'forgot_password';

    case CHANGE_EMAIL = 'change_email';

    case TWO_FACTOR = 'two_factor';
}