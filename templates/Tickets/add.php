<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 */
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>

            <?= $this->Html->link(
                __('List Tickets'),
                ['action' => 'index'],
                ['class' => 'side-nav-item']
            ) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="tickets form content">

            <?= $this->Form->create($ticket) ?>

            <fieldset>
                <legend><?= __('Add Ticket') ?></legend>

                <?php

                echo $this->Form->control('project_id', [
                    'options' => $projects,
                    'empty' => '-- Select Project --'
                ]);

                echo $this->Form->control('subject');

                echo $this->Form->control('customer_name');

                echo $this->Form->control('customer_email');

                echo $this->Form->control('message');

                echo $this->Form->control('priority', [
                    'options' => [
                        'Low' => 'Low',
                        'Medium' => 'Medium',
                        'High' => 'High'
                    ]
                ]);

                echo $this->Form->control('status', [
                    'options' => [
                        'Open' => 'Open',
                        'In Progress' => 'In Progress',
                        'Closed' => 'Closed'
                    ]
                ]);

                echo $this->Form->control('attachment');

                ?>
            </fieldset>

            <?= $this->Form->button(__('Submit')) ?>

            <?= $this->Form->end() ?>

        </div>
    </div>
</div>