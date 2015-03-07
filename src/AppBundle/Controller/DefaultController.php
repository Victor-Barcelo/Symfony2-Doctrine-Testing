<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public $em;

    /**
     * @Route("/app", name="homepage")
     */
    public function indexAction()
    {

        $this->em = $this->getDoctrine()->getManager();

        $this->em->getRepository('AppBundle:Service')->TruncateTable('Service');
        $this->em->getRepository('AppBundle:Service')->TruncateTable('Category');

        $categoryId = $this->em->getRepository('AppBundle:Service')->CreateCategory('Tabaco');

        $serviceId = $this->em->getRepository('AppBundle:Service')->CreateService('Marlboro Pocket');
        $this->em->getRepository('AppBundle:Service')->AssignCategoryToService($serviceId, $categoryId);
        $serviceId = $this->em->getRepository('AppBundle:Service')->CreateService('Fortuna');
        $this->em->getRepository('AppBundle:Service')->AssignCategoryToService($serviceId, $categoryId);
        $serviceId = $this->em->getRepository('AppBundle:Service')->CreateService('LM');
        $this->em->getRepository('AppBundle:Service')->AssignCategoryToService($serviceId, $categoryId);

        $cat = $this->em->getRepository('AppBundle:Category')->find(1); //->getCategory()->getServices();
        $services = $cat->getServices();
        foreach ($services as $service)
        {
            echo $service->getName();
        }

        return $this->render('default/index.html.twig');
    }
}
