<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Allow login page without being logged in
        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            return $this->Authentication->redirectAfterLogin([
                'controller' => 'Tickets',
                'action' => 'index',
            ]);
        }

        if ($this->request->is('post')) {
            $this->Flash->error('Email or password is incorrect');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();

        return $this->redirect([
            'controller' => 'Users',
            'action' => 'login',
        ]);
    }
}