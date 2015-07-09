<?php

namespace zenitth\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZenitthUserBundle extends Bundle
{

	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
