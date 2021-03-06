<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Admin\Form\PostForm;
use Admin\Service\CategoriaService;
use Admin\Service\PostService;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Admin\Service\CategoriaService' => function ($em) {
                    return new CategoriaService($em->get('Doctrine\ORM\EntityManager'));
                },
                'Admin\Service\PostService' => function ($em) {
                    return new PostService($em->get('Doctrine\ORM\EntityManager'));
                },
                'Admin\Form\PostForm' => function ($em) {
                    return new PostForm($em->get('Doctrine\ORM\EntityManager'));
                }
            )
        );
    }
}
