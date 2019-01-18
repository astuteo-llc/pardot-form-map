<?php
/**
 * Pardot Map plugin for Craft CMS 3.x
 *
 * Intended for Astuteo client's use. A simple helper for client forms to push data to Pardot.
 *
 * @link      https://www.astuteo.com
 * @copyright Copyright (c) 2019 astuteo
 */

namespace astuteo\pardotmap\services;

use astuteo\pardotmap\PardotMap;

use Craft;
use craft\base\Component;

/**
 * PardotMapService Service
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    astuteo
 * @package   PardotMap
 * @since     1.0.0
 */
class PardotMapService extends Component
{

    // Public Methods
    // =========================================================================
    /**
     * Watch Freeform then map the fields to the
     * form handler.
     */
    public function mapToPardot($submissionEvent) {
        $submission = $submissionEvent->getElement();

        // If this field has a hidden Pardot URL let's process it
        if(isset($submission->fieldMetadata['pardotURL']) && isset($submission->fieldMetadata['mapPardot'])) {
            $url            = $submission->fieldMetadata['pardotURL']->getValueAsString();
            $mapData        = $submission->fieldMetadata['mapPardot']->getValueAsString();
            $fieldsArray    = explode("|", $mapData);
            $mappingArray   = array();

            for($i=0; $i < count($fieldsArray ); $i++){
                $key_value = explode(':', $fieldsArray [$i]);
                if(isset($key_value [1])) {
                    $mappingArray[$key_value [0]] = $key_value [1];
                } else {
                    $mappingArray[$key_value [0]] = $key_value [0];
                }
            }
            Craft::info("Map: " . $mapData, 'astuteoPardotMapPlugin');
            $this->mapAndSend($submission, $mappingArray, $url);
        } elseif (isset($submission->fieldMetadata['pardotURL'])) {
            Craft::info("The Pardot URL is set for form with ID: " . $submission['formId'] . " but the mapPardot Field isn't set", 'astuteoPardotMapPlugin');
        } else {
            return;
        }
    }

    private function mapAndSend($submission, $fieldsArray, $pardotUrl) {
        $data = $this->formPardotData($submission, $fieldsArray, $pardotUrl); // forms the URL to push to Pardot
        $this->sendToPardot($data);
        return;
    }

    private function formPardotData($submission, $fieldsArray, $pardotUrl) {
        $urlString = $pardotUrl;
        $first = true;
        foreach ($fieldsArray as $key => $value) {
            if ($first) {
                $urlString = $urlString . '?' . $key . '=' . urlencode($submission->fieldMetadata[$value]->getValueAsString());
            } else {
                $urlString = $urlString . '&' . $key . '=' . urlencode($submission->fieldMetadata[$value]->getValueAsString());
            }
            $first = false;
        }
        return $urlString;
    }

    /**
     * Using cURL ping the URL with the URL parameters built out
     * and log the results.
     */
    private function sendToPardot($url, $send=true) {
        if (PardotMap::$plugin->getSettings()->enableSendToPardot) {
            $cSession = curl_init();
            curl_setopt($cSession,CURLOPT_URL,$url);
            curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($cSession,CURLOPT_HEADER, false);
            $result=curl_exec($cSession);
            curl_close($cSession);
            Craft::info("Sent to Pardot: " . $url, 'astuteoPardotMapPlugin');
        } else {
            Craft::info("Would send to Pardot if send is true: " . $url, 'astuteoPardotMapPlugin'); // Curl the URL to push data
        }
        return;
    }

}
