```php
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 */

use Cake\Core\Configure;

$siteKey = Configure::read('Recaptcha.siteKey');
?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="row mb-3 align-items-center">
        <div class="col-sm-6">
            <h3 class="mb-0">Add Ticket</h3>
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

    <!-- Add Ticket Form -->
    <div class="row">
        <div class="col-12 col-xl-10">

            <div class="card card-primary card-outline">

                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-ticket-perforated me-1"></i>
                        Ticket Information
                    </h3>
                </div>

                <div class="card-body">

                    <?= $this->Form->create($ticket, [
                        'id' => 'add-ticket-form',
                        'type' => 'file'
                    ]) ?>

                    <div class="row g-3">

                        <!-- Project -->
                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('project_id', [
                                'label' => 'Project',
                                'options' => $projects,
                                'empty' => '-- Select Project --',
                                'class' => 'form-select'
                            ]) ?>
                        </div>

                        <!-- Subject -->
                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('subject', [
                                'label' => 'Subject',
                                'class' => 'form-control',
                                'placeholder' => 'Enter ticket subject'
                            ]) ?>
                        </div>

                        <!-- Customer Name -->
                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('customer_name', [
                                'label' => 'Customer Name',
                                'class' => 'form-control',
                                'placeholder' => 'Enter customer name'
                            ]) ?>
                        </div>

                        <!-- Customer Email -->
                        <div class="col-12 col-md-6">
                            <?= $this->Form->control('customer_email', [
                                'label' => 'Customer Email',
                                'class' => 'form-control',
                                'placeholder' => 'Enter customer email'
                            ]) ?>
                        </div>

                        <!-- Message -->
                        <div class="col-12">
                            <?= $this->Form->control('message', [
                                'label' => 'Message',
                                'type' => 'textarea',
                                'class' => 'form-control',
                                'rows' => 5,
                                'placeholder' => 'Describe the issue'
                            ]) ?>
                        </div>

                        <!-- Priority -->
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

                        <!-- Status -->
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

                        <!-- Attachment -->
                        <div class="col-12">
                            <?= $this->Form->control('attachment', [
                                'type' => 'file',
                                'label' => 'Attachment',
                                'accept' => '.jpg,.png,.pdf,.doc,.docx',
                                'class' => 'form-control'
                            ]) ?>

                            <div class="form-text">
                                Allowed file types: JPG, PNG, PDF, DOC and DOCX.
                            </div>
                        </div>

                    </div>

                    <!-- reCAPTCHA Token -->
                    <?= $this->Form->hidden('recaptcha_token', [
                        'id' => 'recaptcha-token',
                        'value' => ''
                    ]) ?>

                    <div class="border-top mt-4 pt-3">
                        <div class="d-flex flex-wrap gap-2">

                            <?= $this->Form->button(
                                '<i class="bi bi-check-circle me-1"></i> Submit Ticket',
                                [
                                    'id' => 'submit-ticket',
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary',
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

            </div>

        </div>
    </div>

</div>

<!-- Google reCAPTCHA v3 -->
<script src="https://www.google.com/recaptcha/api.js?render=<?= h($siteKey) ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('add-ticket-form');
        const tokenInput = document.getElementById('recaptcha-token');
        const submitButton = document.getElementById('submit-ticket');

        if (!form || !tokenInput || !submitButton) {
            return;
        }

        form.addEventListener('submit', function(event) {

            event.preventDefault();

            if (submitButton.disabled) {
                return;
            }

            submitButton.disabled = true;

            if (typeof grecaptcha === 'undefined') {
                alert('reCAPTCHA could not load. Please refresh.');
                submitButton.disabled = false;
                return;
            }

            grecaptcha.ready(function() {

                grecaptcha.execute(
                    <?= json_encode($siteKey) ?>,
                    {
                        action: 'add_ticket'
                    }
                )
                .then(function(token) {

                    // Store token in hidden field
                    tokenInput.value = token;

                    // Submit form to CakePHP controller
                    HTMLFormElement.prototype.submit.call(form);

                })
                .catch(function(error) {

                    console.error('reCAPTCHA error:', error);

                    alert('CAPTCHA verification failed. Please try again.');

                    submitButton.disabled = false;
                });

            });

        });

    });
</script>
```