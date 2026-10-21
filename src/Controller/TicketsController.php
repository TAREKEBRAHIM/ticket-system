<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\UploadedFileInterface;
use Cake\Core\Configure;
use Cake\Http\Client;


class TicketsController extends AppController
{
    // List all tickets with search and filters
    public function index()
    {
        $search = $this->request->getQuery('search');
        $status = $this->request->getQuery('status');
        $priority = $this->request->getQuery('priority');

        $query = $this->Tickets->find()
            ->contain(['Projects']);

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Tickets.subject LIKE' => '%' . $search . '%',
                    'Tickets.customer_name LIKE' => '%' . $search . '%',
                ]
            ]);
        }

        if (!empty($status)) {
            $query->where([
                'Tickets.status' => $status
            ]);
        }

        if (!empty($priority)) {
            $query->where([
                'Tickets.priority' => $priority
            ]);
        }

        $tickets = $this->paginate($query);

        $this->set(compact(
            'tickets',
            'search',
            'status',
            'priority'
        ));
    }

    // View ticket details and notes
    public function view($id = null)
    {
        $ticket = $this->Tickets->get(
            $id,
            contain: ['Notes']
        );

        $this->set(compact('ticket'));
    }

    // Add a note using jQuery AJAX
    public function addNote($id = null)
    {
        // Allow POST requests only
        $this->request->allowMethod(['post']);

        // Get Notes table
        $notesTable = $this->fetchTable('Notes');

        // Check if the ticket exists
        if (
            $id === null ||
            !$this->Tickets->exists(['id' => $id])
        ) {
            return $this->response
                ->withStatus(404)
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Ticket not found'
                ]));
        }

        // Receive note from AJAX
        $text = trim(
            (string)$this->request->getData('note', '')
        );

        // Validate note
        if ($text === '') {
            return $this->response
                ->withStatus(422)
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Note cannot be empty'
                ]));
        }

        // Create a new note
        $note = $notesTable->newEntity([
            'ticket_id' => $id,
            'note' => $text
        ]);

        // Save note to database
        if ($notesTable->save($note)) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => true,
                    'message' => 'Note added successfully',
                    'note' => [
                        'id' => $note->id,
                        'note' => $note->note,
                        'created' => $note->created
                            ? (string)$note->created
                            : ''
                    ]
                ]));
        }

        // Save failed
        return $this->response
            ->withStatus(422)
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Failed to save note'
            ]));
    }

    // Add new ticket

    // Add new ticket with Google reCAPTCHA v3
    public function add()
    {
        $ticket = $this->Tickets->newEmptyEntity();

        // Get projects for dropdown
        $projects = $this->Tickets->Projects
            ->find('list')
            ->all();

        if ($this->request->is('post')) {

            // 1. Get CAPTCHA token from form
            $token = $this->request->getData('recaptcha_token');

            $captchaValid = false;

            // 2. Make sure token exists
            if (is_string($token) && $token !== '') {

                $secretKey = Configure::read('Recaptcha.secretKey');
                $expectedHostname = Configure::read('Recaptcha.hostname');

                try {

                    // 3. Send CAPTCHA token to Google
                    $http = new Client([
                        'timeout' => 10
                    ]);

                    $response = $http->post(
                        'https://www.google.com/recaptcha/api/siteverify',
                        [
                            'secret' => $secretKey,
                            'response' => $token
                        ]
                    );

                    $result = $response->getJson();

                    // 4. Check Google's response
                    $captchaValid =
                        $response->isOk()
                        && is_array($result)
                        && ($result['success'] ?? false) === true
                        && ($result['action'] ?? '') === 'add_ticket'
                        && is_numeric($result['score'] ?? null)
                        && (float)$result['score'] >= 0.5
                        && ($result['hostname'] ?? '') === $expectedHostname
                        && empty($result['error-codes']);
                } catch (\Throwable $e) {

                    // Network error or Google service unavailable
                    $captchaValid = false;
                }
            }

            // 5. Reject ticket if CAPTCHA failed
            if (!$captchaValid) {

                $this->Flash->error(
                    __('CAPTCHA verification failed. Please try again.')
                );
            } else {


                $data = $this->request->getData();

                unset($data['recaptcha_token']);

                // Get uploaded file
                $file = $data['attachment'] ?? null;
                unset($data['attachment']);

                $filePath = null;

                if ($file && $file->getError() === UPLOAD_ERR_OK) {

                    $extension = strtolower(
                        pathinfo($file->getClientFilename(), PATHINFO_EXTENSION)
                    );

                    $allowed = ['jpg', 'png', 'pdf', 'doc', 'docx'];

                    // Validate file type
                    if (!in_array($extension, $allowed, true)) {
                        $this->Flash->error('Invalid file type.');
                        return;
                    }

                
                    if ($file->getSize() > 2 * 1024 * 1024) {
                        $this->Flash->error('Maximum file size is 2MB.');
                        return;
                    }

                    // Create upload folder
                    $folder = WWW_ROOT . 'uploads' . DS . 'tickets' . DS;

                    if (!is_dir($folder)) {
                        mkdir($folder, 0755, true);
                    }

                    // Generate unique file name
                    $fileName = bin2hex(random_bytes(16)) . '.' . $extension;

                    // Move file into uploads folder
                    $filePath = $folder . $fileName;
                    $file->moveTo($filePath);

                    // Save relative path in database
                    $data['attachment'] = 'uploads/tickets/' . $fileName;
                } elseif ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                    $this->Flash->error('File upload failed.');
                    return;
                }

                $ticket = $this->Tickets->patchEntity($ticket, $data);


                // 7. Save ticket ONLY after CAPTCHA verification
                if ($this->Tickets->save($ticket)) {

                    $this->Flash->success(
                        __('The ticket has been saved.')
                    );

                    return $this->redirect([
                        'action' => 'index'
                    ]);
                }

                $this->Flash->error(
                    __('The ticket could not be saved. Please, try again.')
                );
            }
        }

        $this->set(compact('ticket', 'projects'));
    }


    // Edit ticket
    public function edit($id = null)
    {
        $ticket = $this->Tickets->get($id);

        $projects = $this->Tickets->Projects
            ->find('list')
            ->all();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $ticket = $this->Tickets->patchEntity(
                $ticket,
                $this->request->getData()
            );

            if ($this->Tickets->save($ticket)) {
                $this->Flash->success(
                    __('The ticket has been saved.')
                );

                return $this->redirect([
                    'action' => 'index'
                ]);
            }

            $this->Flash->error(
                __('The ticket could not be saved.')
            );
        }

        $this->set(compact('ticket', 'projects'));
    }

    // Delete ticket
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $ticket = $this->Tickets->get($id);

        if ($this->Tickets->delete($ticket)) {
            $this->Flash->success(
                __('The ticket has been deleted.')
            );
        } else {
            $this->Flash->error(
                __('The ticket could not be deleted. Please, try again.')
            );
        }

        return $this->redirect([
            'action' => 'index'
        ]);
    }
}
