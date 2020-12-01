<?php
/**
 * Pardot Map plugin for Craft CMS 3.x
 *
 * Intended for Astuteo client's use. A simple helper for client forms to push data to Pardot.
 *
 * @link      https://www.astuteo.com
 * @copyright Copyright (c) 2019 astuteo
 */

namespace astuteo\pardotmap;

use astuteo\pardotmap\services\PardotMapService as PardotMapServiceService;
use astuteo\pardotmap\models\Settings;

use Craft;
use craft\base\Plugin;
use Solspace\Freeform\Services\SubmissionsService;
use Solspace\Freeform\Events\Submissions\SubmitEvent;

use yii\base\Event;

/**
 *
 * @author    astuteo
 * @package   PardotMap
 * @since     1.0.0
 *
 * @property  PardotMapServiceService $pardotMapService
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class PardotMap extends Plugin
{
    // Static Properties
    // =========================================================================

    public static $plugin;
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            SubmissionsService::class,
            SubmissionsService::EVENT_AFTER_SUBMIT,
            function (SubmitEvent $event) {
                Craft::info('Event Fired', 'astuteoPardotMapPlugin');
                PardotMap::$plugin->pardotMapService->mapToPardot($event);
            }
        );

        Craft::info(
            Craft::t(
                'pardot-map',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }
}
