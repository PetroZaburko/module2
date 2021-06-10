<?php

namespace App\models;

class UsersModel extends Model
{
    public function getAllUsersPaging($page)
    {
        return $this->qb->allJoinPaging('users', $page, ['left', 'users_info', 'users.id = users_info.user_id']);
    }

    public function getAllUsers()
    {
        return $this->qb->allJoin('users', ['left', 'users_info', 'users.id = users_info.user_id']);
    }

    public function getOneUser($id)
    {
        return $this->qb->oneJoin($id, 'users', ['left', 'users_info', 'users.id = users_info.user_id']);
    }

    public function addUserInfo($values)
    {
        return $this->qb->insert($values, 'users_info');
    }

    public function updateUser($values)
    {
        return $this->qb->update($values['id'], $values, 'users');
    }

    public function updateUserInfo($values)
    {
        return $this->qb->update($values['user_id'], $values, 'users_info', 'user_id');
    }

    public function getAllUserStatuses()
    {
        return $this->qb->all('users_statuses');
    }

    public function updateUserStatus($values)
    {
        return $this->qb->update($values['id'], $values, 'users');
    }

    public function updateUserImage($id, $image)
    {
        return $this->qb->update($id,['image' => $image], 'users_info', 'user_id');
    }

    public function deleteUserInfo($id)
    {
        return $this->qb->delete($id, 'users_info', 'user_id');
    }
}