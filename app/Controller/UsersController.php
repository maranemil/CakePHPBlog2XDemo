<?php /** @noinspection PhpUndefinedFieldInspection */
/** @noinspection PhpUnused */
/** @noinspection PhpMultipleClassDeclarationsInspection */
// app/Controller/UsersController.php
App::uses('AppController', 'Controller');

class UsersController extends AppController
{

    /*public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }*/

    /**
     *
     */
    public function index()
    {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->findById($id));
    }

    /**
     * @return CakeResponse|null
     * @throws Exception
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        }
        return null;
    }

    /**
     * @param null $id
     *
     * @return CakeResponse|null
     * @throws Exception
     */
    public function edit($id = null)
    {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('The user could not be saved. Please, try again.')
            );
        } else {
            $this->request->data = $this->User->findById($id);
            unset($this->request->data['User']['password']);
        }
        return null;
    }

    /**
     * @param null $id
     *
     * @return CakeResponse|null
     */
    public function delete($id = null)
    {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('User deleted'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('User was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }

    // app/Controller/UsersController.php

    /**
     *
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('add', 'logout');
    }

    /**
     * @return CakeResponse|null
     */
    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
        return null;
    }

    /**
     * @return CakeResponse|null
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

}