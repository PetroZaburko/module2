<?php

namespace App\controllers;

use App\Helpers;
use SimpleMail;

class AuthController extends MainController
{
    public function loginForm()
    {
        echo $this->templates->render('auth/view_login', [
            'title' => 'Login form'
        ]);
    }

    public function login()
    {
        $rememberDuration = null;
        if ($_POST['rememberme'] == "on") {
            $rememberDuration = Helpers::const('cookie.cookie_expiry');
        }
        try {
            $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);
            Helpers::redirectTo(Helpers::const('url.path') . 'users');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            flash()->error('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            flash()->error('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            flash()->error('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
        }
        Helpers::redirectTo(Helpers::const('url.path') . 'login');
    }

    public function logout()
    {
        $this->auth->logOut();
        flash()->info('You have been logged out');
        $this->loginForm();
    }

    public function registerForm()
    {
        echo $this->templates->render('auth/view_register', [
        'title' => 'Register form'
        ]);
    }

    public function register()
    {
        try {
            $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
                $link = Helpers::const('url.path'). 'verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
                $message = 'To complete the registration on our site, please follow this <a href="'. $link .'">link</a>';
                SimpleMail::make()
                    ->setTo($_POST['email'], $_POST['username'])
                    ->setFrom(Helpers::const('email.sender'), 'Admin')
                    ->setSubject('Confirm you registration')
                    ->setMessage($message)
                    ->setHtml()
                    ->send();
            });
            $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::USER);
            $this->user->addUserInfo(['user_id' => $userId]);
            flash()->success("We have signed up a new user. To complete the registration, follow the link in the email, we just sent you");
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
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
        }
        Helpers::redirectTo(Helpers::const('url.path') . 'register');
    }

    public function verifyEmail()
    {
        try {
            $this->auth->confirmEmailAndSignIn($_GET['selector'], $_GET['token']);
            flash()->success('Email address has been verified');
            Helpers::redirectTo(Helpers::const('url.path') . 'users');
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            flash()->error('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            flash()->error('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            flash()->error('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            flash()->error('Too many requests');
        }
        Helpers::redirectTo(Helpers::const('url.path') . 'login');
    }
}