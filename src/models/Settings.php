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

/**
 * PardotMap Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    astuteo
 * @package   PardotMap
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $someAttribute = 'Some Default';

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['someAttribute', 'string'],
            ['someAttribute', 'default', 'value' => 'Some Default'],
        ];
    }
}
