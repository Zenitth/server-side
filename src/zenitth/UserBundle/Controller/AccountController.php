<?php

namespace zenitth\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AccountController extends Controller
{

	public function getAccountAction()
	{

		// $userManager = $this->get('fos_user.user_manager');
	 	// if (!$userManager->findUserByEmail($data['email'])) {

		return array('status' => true);
	}

}
