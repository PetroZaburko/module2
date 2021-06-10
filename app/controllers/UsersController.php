<?php

namespace App\controllers;

use App\Helpers;
use JasonGrimes\Paginator;
use SimpleMail;

class UsersController extends MainController
{
    public function all($value)
    {
        $users = $this->user->getAllUsersPaging($value['page']);
        $statuses = $this->user->getAllUserStatuses();

        $totalUsers = count($this->user->getAllUsers());
        $usersPerPage = Helpers::const('view.paging');
        $paginator = new Paginator($totalUsers, $usersPerPage, $value['page'], Helpers::const('url.path').'users/(:num)');

        echo $this->templates->render('users/view_all', [
            'users' => $users,
            'statuses' => $statuses,
            'title' => 'All users',
            'paginator' => $paginator
        ]);
    }

    public function one()
    {
        $user = $this->user->getOneUser($_GET['id']);
        echo $this->templates->render('users/view_one', [
            'user' => $user,
            'title' => "Info about user " . $user['username']
        ]);
    }

    public function create()
    {
        $statuses = $this->user->getAllUserStatuses();
        echo $this->templates->render('users/view_create', [
            'statuses' => $statuses,
            'title' => 'Adding new user'
        ]);
    }

    public function store()
    {
        try {
            $userId = $this->auth->admin()->createUser($_POST['email'], $_POST['password'], $_POST['username']);
            $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::USER);
            $values = [
                'user_id' => $userId,
                'telephone' => $_POST['telephone'],
                'address' => $_POST['address'],
                'vk' => $_POST['vk'],
                'telegram' => $_POST['telegram'],
                'instagram' => $_POST['instagram']
            ];
            $this->user->addUserInfo($values);
            $this->user->updateUserStatus(['id' => $userId, 'status' => $_POST['status']]);
            if ($avatar = Helpers::uploadImage($_FILES['image'], Helpers::const('url.img'))) {
                $this->user->updateUserImage($userId, $avatar);
            }
            flash()->success($_POST['username'] . ' created successful');
            Helpers::redirectTo(Helpers::const('url.path') . 'users');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            flash()->error('User already exists');
        }
        Helpers::redirectTo(Helpers::const('url.path') . 'users');
    }


    public function editInfo()
    {
        $user = $this->user->getOneUser($_GET['id']);
        echo $this->templates->render('users/view_info', [
            'user' => $user,
            'title' => 'Changing info about user '. $user['username']
        ]);
    }

    public function updateInfo()
    {
        $values = [
            'id' => $_POST['user_id'],
            'username' => $_POST['username']
        ];
        $this->user->updateUser($values);
        $values = $_POST;
        unset($values['username']);
        $this->user->updateUserInfo($values);
        flash()->success('Profile successful updated');
        Helpers::redirectTo(Helpers::const('url.path') . 'users');
    }

    public function editEmail()
    {
        $user = $this->user->getOneUser($_GET['id']);
        echo $this->templates->render('users/view_email', [
            'user' => $user,
            'title' => 'Changing email for user '. $user['username']
        ]);
    }

    public function updateEmail()
    {
        try {
            if ($this->auth->reconfirmPassword($_POST['password'])) {
                $this->auth->changeEmail($_POST['email'], function ($selector, $token) {
                    $link = Helpers::const('url.path'). 'verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                    $message = 'If you really going to change email on our site, please follow this <a href="'. $link .'">link</a>';
                    SimpleMail::make()
                        ->setTo($_POST['email'], $_POST['username'])
                        ->setFrom(Helpers::const('email.sender'), 'Admin')
                        ->setSubject('Changing email')
                        ->setMessage($message)
                        ->setHtml()
                        ->send();
                });
                flash()->success('The change will take effect as soon as the new email address has been confirmed');
                $this->auth->logOut();
            } else {
                flash()->error('You enter wrong own password, please try again');
            }
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error('Invalid email address');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            flash()->error('Email address already exists');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error('Account not verified');
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            flash()->error('Not logged in');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
        }
        Helpers::redirectTo(Helpers::const('url.path') . 'user/email?id=' . $_POST['id'] );
    }

    public function editPassword()
    {
        $user = $this->user->getOneUser($_GET['id']);
        echo $this->templates->render('users/view_password', [
            'user' => $user,
            'title' => 'Changing password user '. $user['username']
        ]);
    }

    public function updatePassword()
    {
        if ($_POST['password'] == $_POST['confirm_password']) {
            try {
                $this->auth->admin()->changePasswordForUserById($_POST['id'], $_POST['password']);
                flash()->success('Your password successful changed');
                Helpers::redirectTo(Helpers::const('url.path') . 'users');
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                flash()->error('Unknown ID');
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                flash()->error('Invalid password');
            }
        } else {
            flash()->error('Your confirm password doesn\'t match');
        }
        Helpers::redirectTo(Helpers::const('url.path') . 'user/password?id=' . $_POST['id']);
    }

    public function editStatus()
    {
        $user = $this->user->getOneUser($_GET['id']);
        $statuses = $this->user->getAllUserStatuses();
        echo $this->templates->render('users/view_status', [
            'user' => $user,
            'statuses' => $statuses,
            'title' => 'Changing status for user '. $user['username']
        ]);
    }

    public function updateStatus()
    {
        $this->user->updateUserStatus($_POST);
        flash()->success('Status successful updated');
        Helpers::redirectTo(Helpers::const('url.path') . 'users');
    }

    public function editMedia()
    {
        $user = $this->user->getOneUser($_GET['id']);
        echo $this->templates->render('users/view_media', [
            'user' => $user,
            'title' => 'Changing avatar for user '. $user['username']
        ]);
    }

    public function updateMedia()
    {
        $user = $this->user->getOneUser($_POST['id']);
        if ($avatar = Helpers::uploadImage($_FILES['image'], Helpers::const('url.img'))) {
            Helpers::deleteImage( $user['image'], Helpers::const('url.img'));
            $this->user->updateUserImage($_POST['id'], $avatar);
        }
        flash()->success($user['username'] . ' avatar successful updated');
        Helpers::redirectTo(Helpers::const('url.path') . 'users');
    }

    public function delete()
    {
        $user = $this->user->getOneUser($_GET['id']);
        try {
            $this->auth->admin()->deleteUserById($value['id']);
            $this->user->deleteUserInfo($value['id']);
            Helpers::deleteImage($user['image'], Helpers::const('url.img'));
            flash()->success($user['username'] . ' , and all his data was successful deleted');
        }
        catch (\Delight\Auth\UnknownIdException $e) {
            flash()->error('Unknown user ID');
        }
        if ($this->auth->getUserId() == $value['id']) {
            $this->auth->logOut();
            Helpers::redirectTo(Helpers::const('url.path') . 'login');
        }
        Helpers::redirectTo(Helpers::const('url.path') . 'users');
    }
}