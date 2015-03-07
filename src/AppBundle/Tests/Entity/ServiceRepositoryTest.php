<?php
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\Collections\ArrayCollection;


class ServiceRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $serviceRepo;

    public static function setUpBeforeClass()
    {
        self::truncateTables();
    }

    public function setUp()
    {
        self::bootKernel();
        $this->em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->serviceRepo = $this->em->getRepository('AppBundle:Service');
    }

    public static function truncateTables()
    {
        $tables = ['Service', 'Category'];
        self::bootKernel();
        $em = static::$kernel->getContainer()->get('doctrine')->getManager();
        $repo = $em->getRepository('AppBundle:Service');
        foreach ($tables as $table) {
            $repo->TruncateTable($table);
        }
    }

    public function testCategoryCreation()
    {
        $id = $this->serviceRepo->CreateCategory('Tabaco');
        $this->assertInternalType("int", $id);
        return $id;
    }

    /**
     * @depends testCategoryCreation
     */
    public function testServiceCreation($categoryId)
    {
        $repo = $this->serviceRepo;

        $serviceNames = ['Marlboro Pocket','Fortuna','LM'];

        foreach($serviceNames as $serviceName)
        {
            $serviceId = $repo->CreateService($serviceName);
            $repo->AssignCategoryToService($serviceId, $categoryId);
        }

        $services = $this->em->getRepository('AppBundle:Category')->find($categoryId)->getServices();
        $this->assertCount(3, $services);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }

}
