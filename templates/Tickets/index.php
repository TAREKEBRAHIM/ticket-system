<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Ticket> $tickets
 */
?>

<div class="tickets index content">
    <?= $this->Html->link(__('New Ticket'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tickets') ?></h3>
    <div class="table-responsive">

    
        <?= $this->Form->create(null, [
            'type' => 'get',
            'url' => ['action' => 'index']
        ]) ?>

        <?= $this->Form->control('search', [
            'label' => 'Search',
            'placeholder' => 'Subject or customer name',
            'value' => $search ?? ''
        ]) ?>

        <?= $this->Form->control('status', [
            'options' => [
                'Open' => 'Open',
                'In Progress' => 'In Progress',
                'Closed' => 'Closed'
            ],
            'empty' => 'All Statuses',
            'value' => $status ?? ''
        ]) ?>

        <?= $this->Form->control('priority', [
            'options' => [
                'Low' => 'Low',
                'Medium' => 'Medium',
                'High' => 'High'
            ],
            'empty' => 'All Priorities',
            'value' => $priority ?? ''
        ]) ?>

        <?= $this->Form->button('Filter') ?>

        <?= $this->Html->link(
            'Reset',
            ['action' => 'index'],
            ['class' => 'button']
        ) ?>

        <?= $this->Form->end() ?>

        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('customer_name') ?></th>
                    <th><?= $this->Paginator->sort('customer_email') ?></th>
                    <th><?= $this->Paginator->sort('priority') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('attachment') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $ticket): ?>
                    <tr>
                        <td><?= $this->Number->format($ticket->id) ?></td>
                        <td><?= h($ticket->subject) ?></td>
                        <td><?= h($ticket->customer_name) ?></td>
                        <td><?= h($ticket->customer_email) ?></td>
                        <td><?= h($ticket->priority) ?></td>
                        <td><?= h($ticket->status) ?></td>
                        <td><?= h($ticket->attachment) ?></td>
                        <td><?= h($ticket->created) ?></td>
                        <td><?= h($ticket->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $ticket->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ticket->id]) ?>
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $ticket->id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $ticket->id),
                                ]
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>