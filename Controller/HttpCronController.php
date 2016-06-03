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

namespace MauticPlugin\HttpCronBundle\Controller;

use Mautic\CoreBundle\Controller\CommonController;

/**
 * Class HttpCronController
 */

class HttpCronController extends CommonController
{
    /*
     * Display the HttpCron Login/Dashboard
     */
    public function indexAction()
    {
        $model              = $this->factory->getModel('plugin.httpcron.httpcron');
        $commands           = $model->getCommands();
        $baseUrl            = $this->generateUrl('mautic_base_index', array(), true);
        $commandsWithUrls   = $model->getCommandsUrls($commands, $baseUrl);
        $email              = $this->factory->getUser()->getEmail();
        $config             = $this->factory->getParameter('httpcron');
        $apiKey             = '';

        if (isset($config['api_key'])) {
            $apiKey = $config['api_key'];
        }

        return $this->delegateView(array(
            'viewParameters'    => array(
                'title'         => 'httpcron.title',
                'commands'      => $commandsWithUrls,
                'email'         => $email,
                'apiKey'        => $apiKey,
            ),
            'contentTemplate' => 'HttpCronBundle:HttpCron:index.html.php',
            'passthroughVars' => array(
                'activeLink'    => '#httpcron',
                'mauticContent' => 'httpcron',
                'route'         => $this->generateUrl('httpcron')
            )
        ));
    }
}
