<?php


namespace App\controllers;

class UsersController extends MainController
{
    public function all()
    {
        $users = $this->db->all('users');

        echo $this->templates->render('users/view_all', [
            'users' => $users,
            'title' => 'All users'
        ]);
    }

    public function one($value)
    {
        $user = $this->db->one($value['id'],'users');

        echo $this->templates->render('users/view_one', [
            'user' => $user,
            'title' => "Info about user " . $user['name']
        ]);
    }

    public function add($values)
    {
        $this->db->insert($values, 'users');
    }

    public function update($values)
    {
        $this->db->update($values['id'], $values, 'users');
    }

    public function delete($value)
    {
        $this->db->delete($value['id'], 'users');
    }

}