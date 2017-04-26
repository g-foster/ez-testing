<?php
namespace Clientname\SearchBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class SimpleSearch
{
    /**
     * @Assert\Length( min = 0, max = 2000, maxMessage = "search.simple.max_size.2000" )
     */
    public $searchText;
}
