<?php

namespace App\Enums;

enum SubscriptionUserType: string
{
    case STUDENT = 'student';
    case PARENT = 'parent';
    case TEACHER = 'teacher';
    case PRIVATE_TUTOR = 'private tutor';
}
