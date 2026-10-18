<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class NotesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('notes');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tickets', [
            'foreignKey' => 'ticket_id',
        ]);


        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('note', 'Note is required');

        return $validator;
    }
}