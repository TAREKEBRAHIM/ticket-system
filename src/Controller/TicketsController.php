<?php

declare(strict_types=1);

namespace App\Controller;

class TicketsController extends AppController
{
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

    public function view($id = null)
    {
        $ticket = $this->Tickets->get($id, contain: ['Notes']);

        $this->set(compact('ticket'));
    }

    public function add()
    {
        $ticket = $this->Tickets->newEmptyEntity();

        $projects = $this->Tickets->Projects->find('list')->all();

        if ($this->request->is('post')) {
            $ticket = $this->Tickets->patchEntity(
                $ticket,
                $this->request->getData()
            );

            if ($this->Tickets->save($ticket)) {
                $this->Flash->success(__('The ticket has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(
                __('The ticket could not be saved. Please, try again.')
            );
        }

        $this->set(compact('ticket', 'projects'));
    }

    public function edit($id = null)
    {
        $ticket = $this->Tickets->get($id);

        $projects = $this->Tickets->Projects->find('list')->all();

        if ($this->request->is(['patch', 'post', 'put'])) {

            $ticket = $this->Tickets->patchEntity(
                $ticket,
                $this->request->getData()
            );

            if ($this->Tickets->save($ticket)) {
                $this->Flash->success(__('The ticket has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(
                __('The ticket could not be saved.')
            );
        }

        $this->set(compact('ticket', 'projects'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $ticket = $this->Tickets->get($id);

        if ($this->Tickets->delete($ticket)) {
            $this->Flash->success(__('The ticket has been deleted.'));
        } else {
            $this->Flash->error(
                __('The ticket could not be deleted. Please, try again.')
            );
        }

        return $this->redirect(['action' => 'index']);
    }
}