<?php

namespace App\Model;

enum StarshipStatusEnum: string
{
    case WAITING = 'waiting';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

}
