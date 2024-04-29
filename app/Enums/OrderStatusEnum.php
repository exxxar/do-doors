<?php

namespace App\Enums;

enum OrderStatusEnum:int
{
    const NewOrder = 0;
    const InProcess = 1;
    const Completed = 2;
}
