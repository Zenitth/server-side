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
use Zenitth\ApiBundle\Entity\brands;

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
		$db = $this->getDoctrine();
		$score = $user->getScore();
		$userBrand = $user->getUserBrand();
		$fans = count($userBrand->getBrandUser());
		$notifications = $db->getRepository('zenitthApiBundle:Notification')->getMine($user->getId());
		$scoreUsers = $db->getRepository('ZenitthUserBundle:User')->findByScore($userBrand->getId());
		$rankingBrands = $db->getRepository('zenitthApiBundle:brands')->findByBrandScore();

		$currentBrandScore = $rankingBrands[$userBrand->getId()]->getScore();


		$countScore=count($scoreUsers);
		
		$equality = false;
		$brandScore = 0;

		$scoreBybrands = 0;
		$brandUserScore =0;
		$userByBrand=array();

		$countBrandScore=count($rankingBrands);
		$brandEquality = false;

		for ($i=0; $i < $countScore ; $i++) { 
			if ($scoreUsers[$i]->getScore() === $score) {
				if( $equality!= $scoreUsers[$i]->getScore() ){
      				$equality =$scoreUsers[$i]->getScore();
					$userRank = $i+1;
				}
			}

			$brandScore = $brandScore + $scoreUsers[$i]->getScore();

			$em = $this->getDoctrine()->getManager();
			$brand = $em->getRepository('zenitthApiBundle:brands')->find($userBrand);
			$brand->setScore($brandScore);
			$em->flush();

		}


		for ($i=0; $i < $countBrandScore ; $i++) { 

			if($rankingBrands[$i]->getScore() === $brandScore){
				if( $brandEquality!=  $brand->getScore() ){
      				$brandEquality =$brand->getScore();
					$brandRank = $i+1;
				}
			}
		}


		$response = array(
						'me' 			=> $user,
						'score' 		=> $score,
						'fan'			=> $fans,
						'notifications' => $notifications,
						'userRank'		=> $userRank,
						'brandScore'	=> $brandScore,
						'brandRank'		=> $brandRank
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
}