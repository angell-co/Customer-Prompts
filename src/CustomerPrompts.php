<?php
/**
 * Customer Prompts plugin for Craft Commerce
 *
 * Prompt your customers to buy.
 *
 * @link      https://angell.io
 * @copyright Copyright (c) 2021 Angell & Co
 */

namespace angellco\customerprompts;

use craft\base\Plugin;
use craft\commerce\Plugin as Commerce;

/**
 * Class CustomerPrompts
 *
 * @author    Angell & Co
 * @package   CustomerPrompts
 * @since     1.0.0
 */
class CustomerPrompts extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var CustomerPrompts
     */
    public static $plugin;

    /**
     * @var Commerce
     */
    public static $commerce;


    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';


    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;
        self::$commerce = Commerce::getInstance();
    }
}
