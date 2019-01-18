<?php
/**
 * Pardot Map plugin for Craft CMS 3.x
 *
 * Intended for Astuteo client's use. A simple helper for client forms to push data to Pardot.
 *
 * @link      https://www.astuteo.com
 * @copyright Copyright (c) 2019 astuteo
 */

namespace astuteo\pardotmap\models;

use astuteo\pardotmap\PardotMap;

use Craft;
use craft\base\Model;

class Settings extends Model
{
    public $enableSendToPardot = true;
}
