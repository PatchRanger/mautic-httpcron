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

use Mautic\CoreBundle\Controller\AjaxController as CommonAjaxController;
use Mautic\CoreBundle\Helper\InputHelper;
use Symfony\Component\HttpFoundation\Request;
use Mautic\CoreBundle\Helper\EncryptionHelper;

/**
 * Class AjaxController
 *
 * @package MauticPlugin\HttpCronBundle\Controller
 */
class AjaxController extends CommonAjaxController
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function saveApiKeyAction(Request $request)
    {
        $apiKey    = InputHelper::clean($request->request->get('apiKey'));
        $dataArray = array('success' => 0);

        /** @var \Mautic\InstallBundle\Configurator\Configurator $configurator */
        $configurator = $this->get('mautic.configurator');

        if ($configurator->isFileWritable()) {
            try {
                $httpcronConfig = array('api_key' => $apiKey);

                // Ensure the config has a secret key
                $params = $configurator->getParameters();

                if (!isset($params['httpcron']) || empty($params['httpcron']['secret_key'])) {
                    $httpcronConfig['secret_key'] = EncryptionHelper::generateKey();
                    $dataArray['secret_key'] = $httpcronConfig['secret_key'];
                }

                // Save the API key only if it doesn't exist or has changed
                if (!(isset($params['httpcron']['api_key']) && $params['httpcron']['api_key'] == $apiKey)) {
                    $configurator->mergeParameters(array('httpcron' => $httpcronConfig));
                    $configurator->write();

                    $dataArray['success']  = 1;

                    // We must clear the application cache for the updated values to take effect
                    /** @var \Mautic\CoreBundle\Helper\CacheHelper $cacheHelper */
                    $cacheHelper = $this->factory->getHelper('cache');
                    $cacheHelper->clearContainerFile();
                }
            } catch (\RuntimeException $exception) {
                $this->addFlash('mautic.config.config.error.not.updated', array('%exception%' => $exception->getMessage()), 'error');
            }
        } else {
            $form->addError(new FormError(
                $this->factory->getTranslator()->trans('mautic.config.notwritable')
            ));
        }

        return $this->sendJsonResponse($dataArray);
    }
}
