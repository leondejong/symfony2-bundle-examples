<?php

namespace Example\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ExampleUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}