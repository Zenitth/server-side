<?php

namespace zenitth\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use zenitth\ApiBundle\Entity\Defi;
use zenitth\ApiBundle\Entity\Notification;
use Zenitth\UserBundle\Entity\User;

class ApiController extends Controller
{

	/**
	 * Get pack of 10 ramdons questions
	 *
	 */
	public function getQuizzAction()
	{
		$tabQuestions = array('questions' => array(), 'user' => array());
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
			array_push($tabQuestions['questions'],$questions[$id]);
		}
		array_push($tabQuestions['user'],$user);

		return $tabQuestions;
	}


	/**
     * Update user Score
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="score", requirements="\d+", nullable=false, strict=true, description="Score")
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
		$db = $this->getDoctrine();
		$score = $user->getScore();
		$userBrand = $user->getUserBrand();
		$fans = count($userBrand->getBrandUser());
		$notifications = $db->getRepository('zenitthApiBundle:Notification')->getMine($user->getId());
		$scoreUsers = $db->getRepository('ZenitthUserBundle:User')->findByScore($userBrand->getId());
		$countScore=count($scoreUsers);
		$equality = false;

		for ($i=0; $i < $countScore ; $i++) { 
			if ($scoreUsers[$i]->getScore() === $score) {
				if( $equality!= $scoreUsers[$i]->getScore() ){
      				$equality =$scoreUsers[$i]->getScore();
					$userRank = $i+1;
				}
			}
		}

		$response = array(
						'me' 			=> $user,
						'score' 		=> $score,
						'fan'			=> $fans,
						'notifications' => $notifications
					);

		return $response;
	}

	/**
	 * Get unread user's notifications
	 *
	 */
	public function getNotificationsAction()
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$db = $this->getDoctrine();
		$notifications = $db->getRepository('zenitthApiBundle:Notification')->getMine($user->getId());

		return $notifications;
	}


	/**
	 * Get 4 question to defi an other user
	 *
	 */
	public function getDefiQuestionAction()
	{
		$userFrom = $this->container->get('security.context')->getToken()->getUser();
		$ennemyBrand = $userFrom->getUserBrand()->getEnemy();
		$questions = $ennemyBrand->getBrandQuestions();
		$users = $ennemyBrand->getBrandUser();
		$rand = rand(0, (count($users) - 1));
		$userTo = $users[$rand];

		$arrayId= array();
		for($i=0;$i<4;$i++){
			$randQuestion=rand(0,count($questions));

			if (!in_array($randQuestion, $arrayId )) {
				array_push($arrayId, $randQuestion);
			}
		}

		$tabQuestions = [];
		foreach ($arrayId as $id => $question) {
			array_push($tabQuestions,$questions[$id]);
		}

		return array('userTo' => $userTo, 'questions' => $tabQuestions);

	}

	/**
     * Create defi from user to user
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="userTo", requirements="\d+", nullable=false, strict=true, description="User To")
     * @RequestParam(name="question", requirements="\d+", nullable=false, strict=true, description="Question")
     *
     */
	public function postDefiValidateAction(ParamFetcher $paramFetcher)
	{
		$userFrom = $this->container->get('security.context')->getToken()->getUser();
		$userRepo = $this->getDoctrine()->getRepository('ZenitthUserBundle:User');
		$questionRepo = $this->getDoctrine()->getRepository('zenitthApiBundle:Questions');
		
		$questionTo = $paramFetcher->get('question');
		$questionTo = $questionRepo->find($questionTo);
		$userTo = $paramFetcher->get('userTo');
		$userTo = $userRepo->find($userTo);

		$defi = new Defi();
		$defi->setUserFrom($userFrom);
		$defi->setUserTo($userTo);
		$defi->setQuestion($questionTo);


		$notification = new Notification();
		$notification->setUserFrom($userFrom);
		$notification->setUserTo($userTo);
		$text = "vous défie";
		$notification->setDefi($defi);
		$notification->setText($text);

		$em = $this->getDoctrine()->getEntityManager();
		$em->persist($notification);
		$em->persist($defi);
    	$em->flush();

		return true;
	}

	/**
	 * Get Defi ID
	 *
	 */
	public function getDefiAction($id)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$defi = $this->getDoctrine()->getRepository('zenitthApiBundle:Defi')->find($id);

		return $defi;
	}

	/**
     * Defi response
     *
     * @param ParamFetcher $paramFetcher Paramfetcher
     *
     * @RequestParam(name="pts", nullable=false, strict=true, description="Points")
     * @RequestParam(name="defi", requirements="\d+", nullable=false, strict=true, description="Defi")
     * @RequestParam(name="response", requirements="\d+", nullable=false, strict=true, description="Response")
     *
     */
	public function postResponseDefiAction(ParamFetcher $paramFetcher)
	{
		$user = $this->container->get('security.context')->getToken()->getUser();
		$pts = $paramFetcher->get('pts');
		$defiId = $paramFetcher->get('defi');
		$responseId = $paramFetcher->get('response');

		$defiRepo = $this->getDoctrine()->getRepository('zenitthApiBundle:Defi');
		$defi = $defiRepo->find($defiId);
		$userFrom = $defi->getUserFrom();
		$userTo = $defi->getUserTo();
		
		$em = $this->getDoctrine()->getEntityManager();

		$defi->setPts($pts);
		$defi->setIsAnswered(true);

		if ($pts == 15) {
			$scoreFrom = $userFrom->getScore() - 15;
			$scoreTo = $userTo->getScore() + 15;
			$userFrom->setScore($scoreFrom);
			$userTo->setScore($scoreTo);
		} else {
			$scoreFrom = $userFrom->getScore() + 15;
			$scoreTo = $userTo->getScore() - 15;
			$userFrom->setScore($scoreFrom);
			$userTo->setScore($scoreTo);
		}
		
		$notification = new Notification();
		$notification->setUserFrom($user);
		$notification->setUserTo($defi->getUserFrom());
		$text = ($pts == 15) ? "a remporté votre défi" : "a échoué à votre défi";
		$notification->setDefi($defi);
		$notification->setText($text);

		$em->persist($defi);
		$em->persist($notification);
		$em->persist($userFrom);
		$em->persist($userTo);
    	$em->flush();

    	return true;

	}
}