<?php

namespace Modules\Client\Enums;

enum OrderStatus: string
{
    case PROGRESSING = "progressing";

    case COMPLETED = "completed";
}
