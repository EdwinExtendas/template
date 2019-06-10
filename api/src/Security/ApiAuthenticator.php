<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\CookieTokenExtractor;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class ApiAuthenticator.
 *
 * @author Edwin ten Brinke <edwin.ten.brinke@extendas.com>
 */
class ApiAuthenticator extends JWTTokenAuthenticator
{
    /**
     * @param JWTTokenManagerInterface $jwt_token_manager
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        JWTTokenManagerInterface $jwt_token_manager,
        EventDispatcherInterface $dispatcher
    ) {
        parent::__construct(
            $jwt_token_manager,
            $dispatcher,
            new CookieTokenExtractor('token')
        );
    }
}
