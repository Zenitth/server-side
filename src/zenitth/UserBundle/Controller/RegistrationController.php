<?php

namespace zenitth\UserBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Session\Session;

use zenitth\VigneronBundle\Entity\Domain;
 
class RegistrationController extends BaseController {
 
    public function registerAction(Request $request) {

        if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            $session = new Session();
            $session->getFlashBag()->add('confirm', 'Merci de votre inscription, vous pouvez maintenant utiliser pleinement Flashwine');
            return new RedirectResponse($this->container->get('router')->generate('vigneron_index'));
        }
        
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');
 
        $user = $userManager->createUser();
        $user->setEnabled(true);
 
        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);
 
        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }
 
        $form = $formFactory->createForm();
        $form->setData($user);
 
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
 
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
 
                /*****************************************************
                *                       Custom                       *
                *****************************************************/

                
                

                if (null === $response = $event->getResponse()) {
                    $url = $this->container->get('router')->generate('fos_user_registration_register');
                    $response = new RedirectResponse($url);
                }
 
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
                
                return $response;
            }
        }
 
        return $this->container->get('templating')->renderResponse('FwUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
        /** End custom **/
    }
 
}