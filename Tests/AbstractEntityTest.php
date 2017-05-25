<?php

namespace Lernpad\TestBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractEntityTest extends KernelTestCase {

    public function setUp()
    {
        static::bootKernel();
    }

    /**
     * Get manager
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getManager()
    {
        return static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * Validate object
     *
     * @param object $entity
     * @param array $validators
     */
    protected function validate($entity, $groups = [])
    {
        $errors = static::$kernel->getContainer()->get('validator')->validate($entity, null, $groups);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo $error->getMessage() . ' for \'' . $error->getPropertyPath() . '\' in ' . get_class($entity) . "\n";
            }
        }
        $this->assertEquals(0, count($errors), "Validation Fail");
    }
}