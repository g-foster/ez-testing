<?php

/**
 * File containing the SessionDeleted class.
 *
 * @copyright Copyright (C) 1999-2014 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 */
namespace eZ\Publish\Core\REST\Server\Values;

use eZ\Publish\Core\REST\Common\Value as RestValue;
use Symfony\Component\HttpFoundation\Response;

class DeletedUserSession extends RestValue
{
    /**
     * Response generated by RestAuthenticator.
     *
     * @see eZ\Publish\Core\MVC\Symfony\Security\Authentication\AuthenticatorInterface::logout()
     *
     * @var \Symfony\Component\HttpFoundation\Response
     */
    public $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}
