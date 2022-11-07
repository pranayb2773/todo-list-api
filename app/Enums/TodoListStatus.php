<?php

namespace App\Enums;

enum TodoListStatus: int
{
    case Completed = 1;
    case Cancelled = 2;
    case Pending = 3;
}
