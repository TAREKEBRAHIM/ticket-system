```php
<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Ticket> $tickets
 */
?>

<div class="container-fluid">

    <!-- Page Title -->
    <div class="row mb-3 align-items-center">
        <div class="col-sm-6">
            <h3 class="mb-0">Tickets</h3>
        </div>

        <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
            <?= $this->Html->link(
                '<i class="bi bi-plus-circle me-1"></i> New Ticket',
                ['action' => 'add'],
                [
                    'class' => 'btn btn-primary',
                    'escape' => false
                ]
            ) ?>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card card-primary card-outline mb-4">

        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-funnel me-1"></i>
                Search & Filters
            </h3>
        </div>

        <div class="card-body">

            <?= $this->Form->create(null, [
                'type' => 'get',
                'url' => ['action' => 'index']
            ]) ?>

            <div class="row g-3 align-items-end">

                <div class="col-12 col-md-6 col-lg-4">
                    <?= $this->Form->control('search', [
                        'label' => 'Search',
                        'placeholder' => 'Subject or customer name',
                        'value' => $search ?? '',
                        'class' => 'form-control',
                        'required' => false
                    ]) ?>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <?= $this->Form->control('status', [
                        'label' => 'Status',
                        'options' => [
                            'Open' => 'Open',
                            'In Progress' => 'In Progress',
                            'Closed' => 'Closed'
                        ],
                        'empty' => 'All Statuses',
                        'value' => $status ?? '',
                        'class' => 'form-select'
                    ]) ?>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <?= $this->Form->control('priority', [
                        'label' => 'Priority',
                        'options' => [
                            'Low' => 'Low',
                            'Medium' => 'Medium',
                            'High' => 'High'
                        ],
                        'empty' => 'All Priorities',
                        'value' => $priority ?? '',
                        'class' => 'form-select'
                    ]) ?>
                </div>

                <div class="col-12 col-md-6 col-lg-2">
                    <div class="d-flex gap-2">
                        <?= $this->Form->button(
                            '<i class="bi bi-search me-1"></i> Filter',
                            [
                                'type' => 'submit',
                                'class' => 'btn btn-primary',
                                'escapeTitle' => false
                            ]
                        ) ?>

                        <?= $this->Html->link(
                            'Reset',
                            ['action' => 'index'],
                            ['class' => 'btn btn-outline-secondary']
                        ) ?>
                    </div>
                </div>

            </div>

            <?= $this->Form->end() ?>

        </div>
    </div>

    <!-- Tickets Table -->
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-ticket-detailed me-1"></i>
                All Tickets
            </h3>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover table-striped align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('subject', 'Subject') ?></th>
                            <th><?= $this->Paginator->sort('customer_name', 'Customer') ?></th>
                            <th><?= $this->Paginator->sort('customer_email', 'Email') ?></th>
                            <th><?= $this->Paginator->sort('priority', 'Priority') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th><?= $this->Paginator->sort('attachment', 'Attachment') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td><?= $this->Number->format($ticket->id) ?></td>

                                <td>
                                    <strong><?= h($ticket->subject) ?></strong>
                                </td>

                                <td><?= h($ticket->customer_name) ?></td>

                                <td><?= h($ticket->customer_email) ?></td>

                                <td>
                                    <?php
                                    $priorityClass = match ($ticket->priority) {
                                        'High' => 'text-bg-danger',
                                        'Medium' => 'text-bg-warning',
                                        'Low' => 'text-bg-success',
                                        default => 'text-bg-secondary'
                                    };
                                    ?>

                                    <span class="badge <?= $priorityClass ?>">
                                        <?= h($ticket->priority) ?>
                                    </span>
                                </td>

                                <td>
                                    <?php
                                    $statusClass = match ($ticket->status) {
                                        'Open' => 'text-bg-primary',
                                        'In Progress' => 'text-bg-warning',
                                        'Closed' => 'text-bg-success',
                                        default => 'text-bg-secondary'
                                    };
                                    ?>

                                    <span class="badge <?= $statusClass ?>">
                                        <?= h($ticket->status) ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if (!empty($ticket->attachment)): ?>
                                        <?= h($ticket->attachment) ?>
                                    <?php else: ?>
                                        <span class="text-muted">No attachment</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?= $ticket->created
                                        ? h($ticket->created->format('Y-m-d H:i'))
                                        : '-' ?>
                                </td>

                                <td>
                                    <?= $ticket->modified
                                        ? h($ticket->modified->format('Y-m-d H:i'))
                                        : '-' ?>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">

                                        <?= $this->Html->link(
                                            '<i class="bi bi-eye"></i>',
                                            ['action' => 'view', $ticket->id],
                                            [
                                                'class' => 'btn btn-sm btn-info',
                                                'title' => 'View',
                                                'escape' => false
                                            ]
                                        ) ?>

                                        <?= $this->Html->link(
                                            '<i class="bi bi-pencil"></i>',
                                            ['action' => 'edit', $ticket->id],
                                            [
                                                'class' => 'btn btn-sm btn-warning',
                                                'title' => 'Edit',
                                                'escape' => false
                                            ]
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            '<i class="bi bi-trash"></i>',
                                            ['action' => 'delete', $ticket->id],
                                            [
                                                'class' => 'btn btn-sm btn-danger',
                                                'title' => 'Delete',
                                                'escape' => false,
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete ticket #{0}?', $ticket->id)
                                            ]
                                        ) ?>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($tickets->toArray())): ?>
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No tickets found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>
        </div>

        <!-- Pagination -->
        <div class="card-footer clearfix">

            <div class="float-start text-muted small">
                <?= $this->Paginator->counter(
                    'Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total'
                ) ?>
            </div>

            <ul class="pagination pagination-sm m-0 float-end">

                <?= $this->Paginator->first(
                    'First',
                    ['class' => 'page-link']
                ) ?>

                <?= $this->Paginator->prev(
                    'Previous',
                    ['class' => 'page-link']
                ) ?>

                <?= $this->Paginator->numbers([
                    'class' => 'page-link'
                ]) ?>

                <?= $this->Paginator->next(
                    'Next',
                    ['class' => 'page-link']
                ) ?>

                <?= $this->Paginator->last(
                    'Last',
                    ['class' => 'page-link']
                ) ?>

            </ul>

        </div>

    </div>

</div>
```