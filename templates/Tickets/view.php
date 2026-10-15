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
            <?= $this->Html->link(__('Edit Ticket'), ['action' => 'edit', $ticket->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Ticket'), ['action' => 'delete', $ticket->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ticket->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tickets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Ticket'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tickets view content">
            <h3><?= h($ticket->subject) ?></h3>
            <table>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($ticket->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Name') ?></th>
                    <td><?= h($ticket->customer_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Email') ?></th>
                    <td><?= h($ticket->customer_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Priority') ?></th>
                    <td><?= h($ticket->priority) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($ticket->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Attachment') ?></th>
                    <td><?= h($ticket->attachment) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($ticket->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($ticket->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($ticket->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($ticket->message)); ?>
                </blockquote>
            </div>


            <div class="related">
                <h4>Notes</h4>

                <?php if (!empty($ticket->notes)) : ?>

                    <table>
                        <tr>
                            <th>Note</th>
                            <th>Created</th>
                        </tr>

                        <?php foreach ($ticket->notes as $note) : ?>
                            <tr>
                                <td><?= h($note->note) ?></td>
                                <td><?= h($note->created) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                <?php else : ?>

                    <p>No notes yet.</p>

                <?php endif; ?>
            </div>



        </div>
    </div>
</div>