<?php

namespace zenitth\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;

class AccountController extends Controller
{
	/**
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="username", requirements="[a-zA-Z1-9\ \-_\/]+", nullable=false, strict=true, description="Username")
     * @RequestParam(name="email", nullable=false, strict=true, description="Email")
     * @RequestParam(name="password", requirements="[a-zA-Z1-9\-_\/]+", nullable=false, strict=true, description="password")
     * @RequestParam(name="birthday", nullable=false, strict=true, description="Birthday")
     * @RequestParam(name="sex", nullable=false, strict=true, description="Sex")
     *
     */
	public function postRegisterAction(ParamFetcher $paramFetcher)
	{
		
		$username = $paramFetcher->get('username');
		$email = $paramFetcher->get('email');
		$password = $paramFetcher->get('password');
		$birthday = date_create_from_format('j/m/Y', $paramFetcher->get('birthday'));
		$sex = $paramFetcher->get('sex');

		$userManager = $this->get('fos_user.user_manager');

		$user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_APPLI'));

        $user->setBirthdate($birthday);
        $user->setSexe($sex);

		$apiKey = sha1($user->getSalt() . $user->getId());
        $user->setApiKey($apiKey);

        $userManager->updateUser($user);

		$clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array(''));
        $client->setAllowedGrantTypes(array('http://zenitth.com/grants/api_key', 'refresh_token'));
        $client->setUser($user);
        $clientManager->updateClient($client);

        $clientId = $client->getId() . "_" . $client->getRandomId();
        $secret = $client->getSecret();
        $key = $apiKey;

		return array(
				'clientId' 	=> $clientId,
				'secretId'	=> $secret,
				'key'		=> $key
			);
	}        

}
