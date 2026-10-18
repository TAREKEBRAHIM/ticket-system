
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
                __('Edit Ticket'),
                ['action' => 'edit', $ticket->id],
                ['class' => 'side-nav-item']
            ) ?>

            <?= $this->Form->postLink(
                __('Delete Ticket'),
                ['action' => 'delete', $ticket->id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $ticket->id),
                    'class' => 'side-nav-item'
                ]
            ) ?>

            <?= $this->Html->link(
                __('List Tickets'),
                ['action' => 'index'],
                ['class' => 'side-nav-item']
            ) ?>

            <?= $this->Html->link(
                __('New Ticket'),
                ['action' => 'add'],
                ['class' => 'side-nav-item']
            ) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="tickets view content">

            <h3><?= h($ticket->subject) ?></h3>

            <!-- Ticket Details -->
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

            <!-- Ticket Message -->
            <div class="text">
                <strong><?= __('Message') ?></strong>

                <blockquote>
                    <?= $this->Text->autoParagraph(h($ticket->message)); ?>
                </blockquote>
            </div>

            <!-- Notes Section -->
            <div class="related">
                <h4>Notes</h4>

                <p id="no-notes" <?= !empty($ticket->notes) ? 'hidden' : '' ?>>
                    No notes yet.
                </p>

                <table>
                    <thead>
                        <tr>
                            <th>Note</th>
                            <th>Created</th>
                        </tr>
                    </thead>

                    <tbody id="notes-list">
                        <?php foreach ($ticket->notes ?? [] as $note) : ?>
                            <tr>
                                <td><?= h($note->note) ?></td>
                                <td><?= h($note->created) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Add New Note Form -->
                <h4>Add New Note</h4>

                <?= $this->Form->create(null, [
                    'id' => 'add-note-form',
                    'url' => [
                        'controller' => 'Tickets',
                        'action' => 'addNote',
                        $ticket->id
                    ]
                ]) ?>

                <?= $this->Form->control('note', [
                    'type' => 'textarea',
                    'label' => 'Note',
                    'id' => 'new-note',
                    'required' => true
                ]) ?>

                <?= $this->Form->button('Add Note', [
                    'id' => 'add-note-button'
                ]) ?>

                <?= $this->Form->end() ?>

                <p id="note-message" role="status"></p>
            </div>

        </div>
    </div>
</div>

<!-- jQuery Library (remove if already loaded in layout) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- AJAX Script -->
<script>
$(document).ready(function () {

    $('#add-note-form').on('submit', function (event) {

        // Prevent normal form submission / page refresh
        event.preventDefault();

        let form = $(this);
        let button = $('#add-note-button');

        // Prevent duplicate submissions
        button.prop('disabled', true);

        $('#note-message').text('');

        $.ajax({

            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',

            success: function (response) {

                if (response.success) {

                    // Create a new table row
                    let row = $('<tr>');

                    $('<td>')
                        .text(response.note.note)
                        .appendTo(row);

                    $('<td>')
                        .text(response.note.created)
                        .appendTo(row);

                    // Add the row without refreshing
                    $('#notes-list').append(row);

                    // Hide the "No notes yet" message
                    $('#no-notes').hide();

                    // Clear the textarea
                    form[0].reset();

                    // Show success message
                    $('#note-message')
                        .text('Note added successfully!')
                        .css('color', 'green');

                } else {

                    $('#note-message')
                        .text(response.message || 'Failed to add note.')
                        .css('color', 'red');
                }
            },

            error: function (xhr) {

                let message = xhr.responseJSON?.message ||
                    'Something went wrong. Please try again.';

                $('#note-message')
                    .text(message)
                    .css('color', 'red');
            },

            complete: function () {
                button.prop('disabled', false);
            }

        });

    });

});
</script>
