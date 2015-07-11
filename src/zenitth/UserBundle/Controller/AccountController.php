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
     * @RequestParam(name="username", nullable=false, strict=true, description="Username")
     * @RequestParam(name="email", nullable=false, strict=true, description="Email")
     * @RequestParam(name="password", nullable=false, strict=true, description="password")
     * @RequestParam(name="birthday", nullable=false, strict=true, description="Birthday")
     * @RequestParam(name="brand", nullable=false, strict=true, description="Brand")
     * @RequestParam(name="sex", nullable=false, strict=true, description="Sex")
     *
     */
	public function postRegisterAction(ParamFetcher $paramFetcher)
	{
		
		$username = $paramFetcher->get('username');
		$email = $paramFetcher->get('email');
		$password = $paramFetcher->get('password');
		$birthday = date_create_from_format('j/m/Y', $paramFetcher->get('birthday'));
		$brand = $paramFetcher->get('brand');
		$brand = $this->getDoctrine()->getRepository('zenitthApiBundle:brands')->find($brand);

		$sex = $paramFetcher->get('sex');

		$userManager = $this->get('fos_user.user_manager');

		$user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_APPLI'));

        $user->setBirthdate($birthday);
        $user->setUserBrand($brand);
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


	/**
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="email", nullable=false, strict=true, description="Email")
     * @RequestParam(name="password", nullable=false, strict=true, description="password")
     *
     */
	public function postLoginAction(ParamFetcher $paramFetcher)
	{
		$email = $paramFetcher->get('email');
		$password = $paramFetcher->get('password');

		$userManager = $this->get('fos_user.user_manager');
		$user = $userManager->findUserByEmail($email);
		$factory = $this->get('security.encoder_factory');
		$encoder = $factory->getEncoder($user);
		$isAuthorize = ($encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt())) ? true : false;

		if ($isAuthorize) {
			$em = $this->getDoctrine()->getEntityManager();
	    	$client = $em->getRepository('zenitthApiBundle:Client')->findOneByUser($user->getId());

	    	if ($client) {

		    	$apiKey = $user->getApiKey();
		    	$secretId = $client->getSecret();
		    	$clientId = $client->getId() . "_" . $client->getRandomId();

		    	return array(
		    		'key' 		=> $apiKey,
		    		'secretId' 	=> $secretId,
		    		'clientId'	=> $clientId
		    	);
		    }
		}

		throw new HttpException(404, "User not found");
	}


	/**
     *
     * Get Brands list
     *
     */
	public function getBrandsAction()
	{ 
		$repo = $this->getDoctrine()->getRepository('zenitthApiBundle:brands');
		$brands = $repo->findAll();

		return $brands;
	}

}
