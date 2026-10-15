<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tickets Model
 *
 * @property \App\Model\Table\NotesTable&\Cake\ORM\Association\HasMany $Notes
 *
 * @method \App\Model\Entity\Ticket newEmptyEntity()
 * @method \App\Model\Entity\Ticket newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Ticket> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ticket get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Ticket findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Ticket patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Ticket> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ticket|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Ticket saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Ticket>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Ticket>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Ticket>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Ticket> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Ticket>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Ticket>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Ticket>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Ticket> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TicketsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tickets');
        $this->setDisplayField('subject');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Notes', [
            'foreignKey' => 'ticket_id',
        ]);

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('subject')
            ->maxLength('subject', 255)
            ->requirePresence('subject', 'create')
            ->notEmptyString('subject');

        $validator
            ->scalar('customer_name')
            ->maxLength('customer_name', 255)
            ->requirePresence('customer_name', 'create')
            ->notEmptyString('customer_name');

        $validator

            ->scalar('customer_email')
            ->maxLength('customer_email', 255)
            ->requirePresence('customer_email', 'create')
            ->notEmptyString('customer_email')
            ->email('customer_email', false, 'Please enter a valid email address');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        $validator
            ->scalar('priority')
            ->maxLength('priority', 20)
            ->requirePresence('priority', 'create')
            ->notEmptyString('priority');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('attachment')
            ->maxLength('attachment', 255)
            ->allowEmptyFile('attachment');

        return $validator;
    }
}
