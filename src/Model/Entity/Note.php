<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Note extends Entity
{
    protected array $_accessible = [
        'ticket_id' => true,
        'note' => true,
        'created' => true,
        'modified' => true,
        'ticket' => true,
    ];
}