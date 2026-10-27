
<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="container-fluid d-flex justify-content-center align-items-center"
     style="min-height: 75vh;">

    <div class="card card-primary card-outline shadow-sm"
         style="width: 100%; max-width: 420px;">

        <div class="card-header text-center py-4">
            <i class="bi bi-person-circle fs-1 text-primary"></i>

            <h3 class="mt-2 mb-1">Ticket System</h3>

            <p class="text-muted mb-0">
                Sign in to your account
            </p>
        </div>

        <div class="card-body p-4">

            <?= $this->Form->create() ?>

            <div class="mb-3">
                <?= $this->Form->control('email', [
                    'label' => 'Email Address',
                    'type' => 'email',
                    'placeholder' => 'Enter your email',
                    'class' => 'form-control',
                    'required' => true
                ]) ?>
            </div>

            <div class="mb-4">
                <?= $this->Form->control('password', [
                    'label' => 'Password',
                    'placeholder' => 'Enter your password',
                    'class' => 'form-control',
                    'required' => true
                ]) ?>
            </div>

            <div class="d-grid">
                <?= $this->Form->button(
                    '<i class="bi bi-box-arrow-in-right me-2"></i> Login',
                    [
                        'type' => 'submit',
                        'class' => 'btn btn-primary btn-lg',
                        'escapeTitle' => false
                    ]
                ) ?>
            </div>

            <?= $this->Form->end() ?>

        </div>

        <div class="card-footer text-center text-muted py-3">
            <small>Ticket Management System</small>
        </div>

    </div>

</div>
```