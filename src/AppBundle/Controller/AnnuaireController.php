<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mairie;
use AppBundle\Entity\Message;
use AppBundle\Entity\MessageModel;
use AppBundle\Entity\User;
use AppBundle\Form\MessageModelType;
use AppBundle\Form\MessageType;
use AppBundle\Service\AnnuaireMailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/app/annuaire")
 */
class AnnuaireController extends Controller
{
    /**
     * @Route("/", name="annuaire_index")
     */
    public function annuaireAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('AppBundle:Message')
                        ->findAll();
        
        $models = $em->getRepository('AppBundle:MessageModel')
                        ->findBy([], ['name' => 'ASC']);

        return $this->render('annuaire/annuaire.html.twig', [
            'messages' => $messages,
            'models' => $models,
        ]);
    }
    /**
     * @Route("/secteurs", name="annuaire_secteur")
     */
    public function secteurAction(Request $request)
    {   
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('AppBundle:Message')
                        ->findAll();

        return $this->render('annuaire/secteur.html.twig', [
            'messages' => $messages,
        ]);
    }
    
    /**
     * @Route("/mairie/search", name="mairie_search", options={ "expose": true })
     * @Security("has_role('ROLE_VIEW')")
     */
    public function communesAction(Request $request)
    {
        $response = new JsonResponse();

        $term = $request->query->get('term', null);

        $results = [];

        if (!empty($term)) {
            $em = $this->getDoctrine()->getManager();
            $results = $em->getRepository('AppBundle:Mairie')->searchTerm($term);
        }

        $response->setData($results);
        return $response;
    }
    
    /**
     * @Route("/mairie/{insee}/contact", name="annuaire_mairie", options={"expose": true})
     * @ParamConverter("mairie", options={"mapping": {"insee": "insee"}})
     * @Method({"GET", "POST"})
     */
    public function mairieAction(Request $request, Mairie $mairie, UserInterface $user, Swift_Mailer $mailer)
    {
        /* @var $user User */
        
        $message = new Message();
        $from = $this->getParameter('mailer_from');
        $message->setFrom($from);
        $message->setReplyTo($user->getEmail());
        $message->setMairie($mairie);
        
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        
        $em = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $annuaireMailer = new AnnuaireMailer($mailer);
            
            $errors = [];
            if ($annuaireMailer->handleMessage($message, $errors)) {
                $em->persist($message);
                $em->flush();
                $this->addFlash('success', 'Mail envoyé.');
                return $this->redirectToRoute('annuaire_mairie', ['insee' => $mairie->getInsee()]);
            
            } else {
                $this->addFlash('error', 'Erreur');
            }
        }
        
        $models = $em->getRepository('AppBundle:MessageModel')
                        ->findBy([], ['name' => 'ASC']);
        $commune = $em->getRepository('AppBundle:Commune')->findOneBy(['insee' => $mairie->getInsee()]);

        return $this->render('annuaire/mairie.html.twig', [
            'form' => $form->createView(),
            'models' => $models,
            'mairie' => $mairie,
            'commune' => $commune,
        ]);
    }
    
    /**
     * @Route("/modele/nouveau", name="model_new")
     * @Method({"GET", "POST"})
     */
    public function newModelAction(Request $request)
    {
        $model = new MessageModel();
        
        $form = $this->createForm(MessageModelType::class, $model);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($model);
            $em->flush();
            
            $this->addFlash('success', 'Modèle créé.');
            return $this->redirectToRoute('annuaire_index');
        }

        return $this->render('annuaire/model_new.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/modele/{id}/modifier", name="model_edit")
     * @Method({"GET", "POST"})
     */
    public function editModelAction(Request $request, MessageModel $model)
    {
        $form = $this->createForm(MessageModelType::class, $model);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $this->addFlash('success', 'Modèle modifié.');
            return $this->redirectToRoute('annuaire_index');
        }

        return $this->render('annuaire/model_edit.html.twig', [
            'model' => $model,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/modele/{id}/supprimer", name="model_delete", options={ "expose": true })
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MessageModel $model)
    {
        $id = $request->request->get('id', 0);
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($model);
        $em->flush();
        $this->addFlash('success', 'Modèle supprimé.');

        return $response;
    }
    
    /**
     * @Route("/message/{id}/modifier", name="message_edit", options={ "expose": true })
     * @Method({"POST"})
     * @Security("has_role('ROLE_EDIT')")
     */
    public function editMessageAction(Request $request, Message $message)
    {
        $result = $request->request->get('result', '?');
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        if(in_array($result, ['?', '-', '+'])) {
            $em = $this->getDoctrine()->getManager();

            $message->setResult($result);
            $em->persist($message);
            $em->flush();

            $this->addFlash('success', 'Le résultat du message « ' . $message->getObject() . ' » a été modifié.');
            $response->setData(['success' => 1]);
        }
        return $response;
    }
}
