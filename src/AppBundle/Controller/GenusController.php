<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNotes;
use AppBundle\Entity\Logger;
use AppBundle\Service\MarkdownTransformer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\Mailer;

class GenusController extends Controller
{
    /**
     * @Route("/genus/new",)
     */
    public function NewAction()
    {
        $genus = new Genus();
        $genus->setName('Octopus'.rand(1, 100));
        $genus->setSubFamily('Octopodinae');
        $genus->setSpeciesCount(rand(100, 99999));
        $genus->setIsPublished(0);

        $em = $this->getDoctrine()->getManager();


        $note = new GenusNotes();
        $note->setUsername('AquaWeaver');
        $note->setUserAvatarFilename('ryan.jpeg');
        $note->setNote('I counted 8 legs... as they wrapped around me');
        $note->setCreatedAt(new \DateTime('-1 month'));
        $note->setGenus($genus);

        $em->persist($genus);
        $em->persist($note);
        $em->flush();

        return new Response('Genus created');
    }

    /**
     * @Route("/genus")
     */

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $genuses = $em->getRepository('AppBundle:Genus')->findAllPublishedOrderedBySize();

        return $this->render('genus/list.html.twig', ['genuses' => $genuses]);
    }

    /**
     * @Route("/genus/{genusName}",  name="genus_show")
     */
    public function showAction($genusName, Mailer $mailer, Request $request)
    {
//        $templating = $this->container->get('templating');
//        $html = $templating->render('genus/show.html.twig', [
//            'name' => $genusName
//        ]);
        $funFact = 'Octopuses can change the color of their body in just *three-tenths* of a second!';


        $em = $this->getDoctrine()->getManager();
        $genus = $em->getRepository('AppBundle:Genus')
            ->findOneBy(['name' => $genusName]);

        if(!$genus) {
            throw $this->createNotFoundException('Genus not found!');
        }
        $ip = $request->getClientIp();
        if($ip == 'unknown'){
            $ip = $_SERVER['REMOTE_ADDR'];
        }


        $logger = $this->get('app.logger');
        $log_data = $logger->log();
        $message = $mailer->notifyOfSiteUpdate($this->get('mailer'));


//        $markdownParser = new MarkdownTransformer($this->get('markdown.parser'));
        $markdownTransformer = $this->get('app.markdown_transformer');
        $funFact = $markdownTransformer->parse($genus->getFunFact());

        //Cache
//        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
//        $key = md5($funFact);
//        if ($cache->contains($key)) {
//            $funFact = $cache->fetch($key);
//        } else {
//            sleep(1); // fake how slow this could be
//            $funFact = $this->get('markdown.parser')
//                ->transform($funFact);
//            $cache->save($key, $funFact);
//        }

        return $this->render('genus/show.html.twig', [
            'funFact' => $funFact,
            'genus' => $genus
        ]);
//        return new Response('The genus: '.$genusName);
        //return new Response($html);
    }

    /**
     * @Route("/genus/{genusName}/notes", name="genus_show_notes")
     * @Method("GET")
     */
    public function getNotesAction()
    {
        $notes = [
            ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
            ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
            ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
        ];

        $data = [
            'notes' => $notes
        ];

//        return new Response(json_encode($data));
        return new JsonResponse($data);
    }

}