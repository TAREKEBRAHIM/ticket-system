```php
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 */
?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="row mb-3 align-items-center">
        <div class="col-sm-6">
            <h3 class="mb-0">Edit Ticket #<?= h($ticket->id) ?></h3>
        </div>

        <div class="col-sm-6 text-sm-end mt-2 mt-sm-0">
            <?= $this->Html->link(
                '<i class="bi bi-arrow-left me-1"></i> List Tickets',
                ['action' => 'index'],
                [
                    'class' => 'btn btn-outline-secondary',
                    'escape' => false
                ]
            ) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-10">

            <div class="card card-warning card-outline">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-pencil-square me-1"></i>
                        Update Ticket Information
                    </h3>
                </div>

                <div class="card-body">

                    <?= $this->Form->create($ticket) ?>

                    <div class="row g-3">

                        <div class="col-12">
                            <?= $this->Form->control('subject', [
                                'label' => 'Subject',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('customer_name', [
                                'label' => 'Customer Name',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('customer_email', [
                                'label' => 'Customer Email',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->control('message', [
                                'label' => 'Message',
                                'type' => 'textarea',
                                'rows' => 5,
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('priority', [
                                'label' => 'Priority',
                                'options' => [
                                    'Low' => 'Low',
                                    'Medium' => 'Medium',
                                    'High' => 'High'
                                ],
                                'class' => 'form-select'
                            ]) ?>
                        </div>

                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('status', [
                                'label' => 'Status',
                                'options' => [
                                    'Open' => 'Open',
                                    'In Progress' => 'In Progress',
                                    'Closed' => 'Closed'
                                ],
                                'class' => 'form-select'
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->control('attachment', [
                                'label' => 'Attachment',
                                'class' => 'form-control'
                            ]) ?>
                        </div>

                    </div>

                    <div class="border-top mt-4 pt-3">
                        <div class="d-flex flex-wrap gap-2">

                            <?= $this->Form->button(
                                '<i class="bi bi-check-circle me-1"></i> Save Changes',
                                [
                                    'type' => 'submit',
                                    'class' => 'btn btn-warning',
                                    'escapeTitle' => false
                                ]
                            ) ?>

                            <?= $this->Html->link(
                                'Cancel',
                                ['action' => 'index'],
                                ['class' => 'btn btn-outline-secondary']
                            ) ?>

                        </div>
                    </div>

                    <?= $this->Form->end() ?>

                </div>

                <div class="card-footer">
                    <?= $this->Form->postLink(
                        '<i class="bi bi-trash me-1"></i> Delete This Ticket',
                        ['action' => 'delete', $ticket->id],
                        [
                            'class' => 'btn btn-danger btn-sm',
                            'escape' => false,
                            'confirm' => __('Are you sure you want to delete ticket #{0}?', $ticket->id)
                        ]
                    ) ?>
                </div>

            </div>

        </div>
    </div>

</div>
```