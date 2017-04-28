<?php
namespace Clientname\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_prefs")
 */
class UserPrefs
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $username;

    /**
     * @ORM\Column(type="integer")
     */
    private $biograpy_hide;

    /**
     * @ORM\Column(type="integer")
     */
    private $fiction_hide;

    /**
     * @ORM\Column(type="integer")
     */
    private $science_hide;
}
