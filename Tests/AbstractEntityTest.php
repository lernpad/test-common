<?php

namespace Lernpad\TestBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractEntityTest extends KernelTestCase
{
    public function setUp()
    {
        static::bootKernel();
    }

    /**
     * Get manager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function getManager()
    {
        return static::$kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * Validate object.
     *
     * @param object $entity
     * @param bool   $result expected result of validation check
     * @param array  $groups validation groups
     */
    protected function validate($entity, $result, $groups = [])
    {
        $errors = static::$kernel->getContainer()->get('validator')->validate($entity, null, $groups);

        $valid = (count($errors) <= 0);

        if ($result !== $valid) {
            foreach ($errors as $error) {
                echo $error->getMessage().' for \''.$error->getPropertyPath().'\' in '.get_class($entity)."\n";
            }
        }
        $this->assertSame($result, $valid, 'Validation Test Fail');
    }

    /**
     * Validate object for one type.
     *
     * @param object $entity
     * @param bool   $result expected result of validation check
     * @param array  $groups validation groups
     */
    protected function validateOne($entity, $result, $groups = [])
    {
        $errors = static::$kernel->getContainer()->get('validator')->validate($entity, null, $groups);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo $error->getMessage().' for \''.$error->getPropertyPath().'\' in '.get_class($entity)."\n";
            }
        }
        $this->assertSame((int) !$result, count($errors), 'Validation Fail');
    }
}
