<?php

namespace zenitth\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ApiController extends Controller
{

	public function getTestAction()
	{
		return array('id' => 1, 'name' => 'Arnaud');
	}

}
