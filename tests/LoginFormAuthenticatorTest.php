<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class LoginFormAuthenticatorTest extends KernelTestCase
{
    public function testSupportsReturnsTrueForLoginRequest(): void
    {
        self::bootKernel(); //from KernelTestCase, ryn application kernel 

        $userRepository = $this->createMock(UserRepository::class);
        $router = $this->createMock(RouterInterface::class);

        $authenticator = new LoginFormAuthenticator($userRepository, $router);

        $request = Request::create('/login', 'POST');

        self::assertTrue($authenticator->supports($request));
    }

    public function testAuthenticate(): void
    {
        $userRepository = $this->createMock(UserRepository::class);
        $router = $this->createMock(RouterInterface::class);
        $authenticator = new LoginFormAuthenticator($userRepository, $router);

        $email = 'test@example.com';
        //$email = 'webstore1@example.com';
        $password = 'password';
        $csrfToken = 'csrf-token';

        $request = Request::create('/login', 'POST', [
            'email' => $email,
            'password' => $password,
            '_csrf_token' => $csrfToken
        ]);


        $userRepository->findOneBy(['email' => $email]);

        $passport = $authenticator->authenticate($request);

        self::assertInstanceOf(Passport::class, $passport);
    }
}


        //setting expected call 'findOneBy' to the UserRepo mock
        // $userRepository->expects($this->once())
        //     ->method('findOneBy')
        //     ->with(['email' => $email])
        //     ->willReturn(new User());

        // $userRepository->method('findOneBy')
        //     ->with(['email' => $email])
        //     ->willReturnCallback(function ($criteria) {
        //         if ($criteria['email'] === 'test@example.com') {
        //             return new User();
        //         } else {
        //             return null;
        //         }
        //     });