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

namespace MauticPlugin\HttpCronBundle\Model;

use Mautic\CoreBundle\Model\CommonModel;

/**
 * Class HttpCronModel
 */
class HttpCronModel extends CommonModel
{

    /**
     * Return the array of available commands
     *
     * @return array
     */
    public function getCommands()
    {
        return array(
            'mautic:leadlists:update'       => array('title' => 'Update lists', 'description' => 'Updates the leads in the lists. This command is required for basic Mautic functions.'),
            'mautic:campaigns:update'       => array('title' => 'Update campaigns', 'description' => 'Adds/removes leads from campaigns. This command is required for basic Mautic functions.'),
            'mautic:campaigns:trigger'      => array('title' => 'Trigger campaigns', 'description' => 'Triggers the campaign events. This command is required for basic Mautic functions.'),
            'mautic:email:process'          => array('title' => 'Process emails', 'description' => 'Processes the emails in the queue. This command is needed if you configure the emails to be processed in a queue.'),
            'mautic:fetch:email'            => array('title' => 'Fetch emails', 'description' => 'Reads emails from a inbox defined in the Monitored Inbox setting.'),
            'mautic:iplookup:download'      => array('title' => 'Update geoIP', 'description' => 'Downloads/updates the MaxMind GeoIp2 City database. This command is needed only if you use the "MaxMind - GeoIp2 City Download" IP lookup service.')
        );
    }

    /**
     * Return the array of available commands
     *
     * @return array
     */
    public function getCommandsUrls($commands, $baseUrl)
    {
        $commandsWithUrls = array();
        $config = $this->factory->getParameter('httpcron');
        $secretKey = '';

        if (isset($config['secret_key'])) {
            $secretKey = '?secret_key=' . $config['secret_key'];
        }

        foreach ($commands as $command => $desc) {
            $commandsWithUrls[] = array(
                'url' => $baseUrl . 'httpcron/' . urlencode($command) . $secretKey,
                'title' => $desc['title'],
                'description' => $desc['description']
            );    
        }

        return $commandsWithUrls;
    }
}
