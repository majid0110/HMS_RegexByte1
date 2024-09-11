<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\Email\Email;

class ForgotPasswordController extends Controller
{
    public function forgot_password()
    {
        return view('forgot_password');
    }

    public function sendResetLink()
    {
        $request = \Config\Services::request();
        $email = trim($request->getVar('email'));

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(50));

            $userModel->update($user['ID'], ['reset_token' => $token]);

            $emailService = \Config\Services::email();
            $emailService->setFrom('rbyte.bot@gmail.com', 'RegexByte');
            $emailService->setTo($email);
            $emailService->setSubject('Password Reset Request');
            $emailService->setMessage("Please click the link to reset your password: " . base_url('reset-password/' . $token));

            if ($emailService->send()) {
                return redirect()->to(base_url('forgot-password'))->with('success', 'A reset link has been sent to your email.');
            } else {
                return redirect()->to(base_url('forgot-password'))->with('error', 'Failed to send reset email.');
            }
        } else {
            return redirect()->to(base_url('forgot-password'))->with('error', 'Email address not found.');
        }
    }

    public function resetPassword($token)
    {
        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if ($user) {
            return view('reset_password', ['token' => $token]);
        } else {
            return redirect()->to(base_url('forgot-password'))->with('error', 'Invalid token.');
        }
    }

    public function updatePassword()
    {
        $request = \Config\Services::request();
        $token = $request->getVar('token');
        $password = $request->getVar('password');

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)->first();

        if ($user) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $userModel->update($user['ID'], ['password' => $hashedPassword, 'reset_token' => null]);

            return redirect()->to(base_url('login'))->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to reset password.');
        }
    }
}
