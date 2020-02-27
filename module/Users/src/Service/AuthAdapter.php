<?php

namespace Users\Service;

use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\Bcrypt;
use Users\Entity\Users;

class AuthAdapter implements AdapterInterface
{
    private $entityManager;
    private $username;
    private $password;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * Performs an authentication attempt
     *
     * @return \Laminas\Authentication\Result
     * @throws \Laminas\Authentication\Adapter\Exception\ExceptionInterface
     *     If authentication cannot be performed
     */
    public function authenticate()
    {
        $user = $this->entityManager->getRepository(Users::class)
            ->findOneBy(['ten_dang_nhap' => $this->username]);
        if (!$user) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Tên đăng nhập không tồn tại'],
            );
        } else {
            $bcrypt = new Bcrypt();

            $userPassword = $this->password;
            $passwordHash = $user->getMatKhau();

            if ($bcrypt->verify($userPassword, $passwordHash)) {
                return new Result(
                    Result::SUCCESS,
                    $this->username,
                    ['Xác thực thành công']
                );
            } else {
                return new Result(
                    Result::FAILURE_CREDENTIAL_INVALID,
                    null,
                    ['Sai thông tin đăng nhập. Mật khẩu không chính xác']
                );
            }
        }
    }
}
