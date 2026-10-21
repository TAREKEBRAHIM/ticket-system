<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 */

use Cake\Core\Configure;

$siteKey = Configure::read('Recaptcha.siteKey');
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

            <?= $this->Form->create($ticket, [
                'id' => 'add-ticket-form',
                'type' => 'file'
            ]) ?>

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

                echo $this->Form->control('attachment', [
                    'type' => 'file',
                    'accept' => '.jpg,.png,.pdf,.doc,.docx',
                
                ]);

                echo $this->Form->hidden('recaptcha_token', [
                    'id' => 'recaptcha-token',
                    'value' => ''
                ]);

                ?>
            </fieldset>

            <?= $this->Form->button(__('Submit'), [
                'id' => 'submit-ticket',
                'type' => 'submit'
            ]) ?>

            <?= $this->Form->end() ?>

        </div>
    </div>
</div>


<script
    src="https://www.google.com/recaptcha/api.js?render=<?= h($siteKey) ?>">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('add-ticket-form');
        const tokenInput = document.getElementById('recaptcha-token');
        const submitButton = document.getElementById('submit-ticket');

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
                        <?= json_encode($siteKey) ?>, {
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