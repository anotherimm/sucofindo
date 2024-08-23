<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getVar('username');
        $password = ($this->request->getVar('password'));

        $user = $model->where('username', $username)
            ->where('password', $password)
            ->first();

        if ($user) {
            $session->set([
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'isLoggedIn' => true
            ]);

            if ($user['role'] == 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/user/dashboard');
            }
        } else {
            $session->setFlashdata('msg', 'Username atau Password salah');
            return redirect()->to('/auth/login');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {
        $model = new UserModel();

        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $password = ($this->request->getVar('password'));

        $existingUser = $model->where('email', $email)->orWhere('username', $username)->first();
        if ($existingUser) {
            session()->setFlashdata('msg_error', 'Email atau username sudah terdaftar. Silakan gunakan email atau username lain.');
            return redirect()->to('/auth/register');
        }
        
        $data = [
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'role' => 'user'
        ];
        
        $model->insert($data);
        session()->setFlashdata('msg_success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
        return redirect()->to('/auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }



    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function sendResetLink()
{
    $email = $this->request->getPost('email');
    $userModel = new UserModel();

    $user = $userModel->where('email', $email)->first();

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_expires' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);

        $resetLink = base_url('auth/reset_password/' . $token);
        $message = "
            <p>Silakan klik tautan berikut untuk mereset kata sandi Anda:</p>
            <p><a href=\"$resetLink\">$resetLink</a></p>
            <p>Jika Anda tidak meminta reset kata sandi ini, mohon abaikan email ini.</p>
        ";

        // Mengirim email
        $emailService = \Config\Services::email();

        // Set konfigurasi SMTP
        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => 'stelle.kawaiihost.net',
            'SMTPPort' => 465,
            'SMTPUser' => 'admin@monitoringtor.my.id',
            'SMTPPass' => 'miskoen16',  // Password aplikasi
            'SMTPCrypto' => 'ssl',
            'mailType'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'crlf'      => "\r\n",
            'SMTPOptions' => [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ],
        ];

        $emailService->initialize($config);
        $emailService->setFrom('admin@monitoringtor.my.id', 'Monitoring TOR'); // Menambahkan From header
        $emailService->setTo($email);
        $emailService->setSubject('Reset Password');
        $emailService->setMessage($message);

        // Debugging email
        log_message('debug', 'SMTP User: ' . $emailService->SMTPUser);
        log_message('debug', 'SMTP Host: ' . $emailService->SMTPHost);

        if ($emailService->send()) {
            log_message('debug', 'Email sent successfully');
            return redirect()->to('/auth/forgot_password')->with('success', 'Reset link has been sent to your email.');
        } else {
            log_message('debug', 'Failed to send email: ' . $emailService->printDebugger(['headers', 'subject', 'body']));
            return redirect()->to('/auth/forgot_password')->with('error', 'Failed to send reset link. Please try again.');
        }
    } else {
        return redirect()->to('/auth/forgot_password')->with('error', 'Email not found.');
    }
}




    



    public function resetPassword($token)
    {
        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)
                          ->where('reset_expires >', date('Y-m-d H:i:s'))
                          ->first();

        if ($user) {
            return view('auth/reset_password', ['token' => $token]);
        } else {
            return redirect()->to('/auth/forgot_password')->with('msg', 'Invalid or expired reset link.');
        }
    }

    public function updatePassword()
    {
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        if (empty($token) || empty($password)) {
            return redirect()->to('/auth/reset_password/' . $token)->with('error', 'Token or password cannot be empty.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)
                        ->where('reset_expires >', date('Y-m-d H:i:s'))
                        ->first();

        // Debug output
        log_message('debug', 'User found: ' . print_r($user, true));

        if ($user) {
            // Update data
            $updateData = [
                'password' => $password,  // Tidak di-hash
                'reset_token' => null,
                'reset_expires' => null,
            ];

            log_message('debug', 'Update data: ' . print_r($updateData, true));

            // Update the user record
            $userModel->update($user['id'], $updateData);

            // Confirm update success
            return redirect()->to('/auth/login')->with('success', 'Password successfully updated.');
        } else {
            return redirect()->to('/auth/reset_password/' . $token)->with('error', 'Invalid or expired reset link.');
        }
    }


}