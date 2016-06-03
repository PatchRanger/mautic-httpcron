<?php
/**
 * @package     HttpCron Mautic Bundle
 * @author      Dmitry Danilson
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
/**
 * Based on & inspired by Cronfig Mautic Bundle.
 * @package     HttpCron Mautic Bundle
 * @copyright   2016 Cronfig.io. All rights reserved
 * @author      Jan Linhart
 * @link        http://cronfig.io
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return array(
    'name'        => 'HttpCron',
    'description' => 'Takes care of the cron jobs - makes your Mautic alive.',
    'version'     => '1.0',
    'author'      => 'Dmitry Danilson, Jan Linhart',

    'routes'      => array(
        'main' => array(
            'httpcron'         => array(
                'path'       => '/httpcron',
                'controller' => 'HttpCronBundle:HttpCron:index'
            )
        ),
        'public' => array(
            'httpcron_public' => array(
                'path' => '/httpcron/{command}',
                'controller' => 'HttpCronBundle:Public:trigger',
                'defaults' => array(
                    'command' => ''
                )
            )
        )
    ),

    'menu'     => array(
        'admin' => array(
            'items'    => array(
                'httpcron.title' => array(
                    'id'        => 'httpcron',
                    'route'     => 'httpcron',
                    'iconClass' => 'fa-clock-o',
                    // 'access'    => 'plugin:httpcron:httpcron:view',
                )
            )
        )
    ),

    'services' => array(
        'forms' => array(
            'mautic.form.type.httpcron.httpcron' => array(
                'class' => 'MauticPlugin\HttpCronBundle\Form\Type\HttpCronType',
                'arguments' => 'mautic.factory',
                'alias' => 'httpcron'
            ),
        ),
    ),
);
