<?php

namespace zenitth\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;

class ApiController extends Controller
{

	/**
	 * Get pack of 10 ramdons questions
	 *
	 */
	public function getQuizzAction()
	{
		$tabQuestions = [];
		$user = $this->container->get('security.context')->getToken()->getUser();
		$brand = $user->getUserBrand();
		$questions = $brand->getBrandQuestions();
		
		$arrayId= array();
		for($i=0;$i<10;$i++){
			$randQuestion=rand(0,count($questions));

			if (!in_array($randQuestion, $arrayId )) {
				array_push($arrayId, $randQuestion);
			}
		}

		foreach ($arrayId as $id => $question) {
			array_push($tabQuestions,$questions[$id]);
		}
		return $tabQuestions;
	}


	/**
     * Update user Score
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="score", requirements="\d+", nullable=false, strict=true, description="Username")
     *
     */
	public function postScoreAction(ParamFetcher $paramFetcher)
	{
		$userManager = $this->get('fos_user.user_manager');
		$score = $paramFetcher->get('score');
		$user = $this->container->get('security.context')->getToken()->getUser();
		$score = $user->getScore() + $score;
		$user->setScore($score);
		$userManager->updateUser($user);

		return true;
	}


	/**
	 * Get all informations to make view dashboard
	 *
	 */
	public function getDashboardAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$score = $user->getScore();
		$userBrand = $user->getUserBrand();
		$fans = count($userBrand->getBrandUser());

		$response = array(
						'me' 	=> $user,
						'score' => $score,
						'fan'	=> $fans
					);

		return $response;
	}
}
