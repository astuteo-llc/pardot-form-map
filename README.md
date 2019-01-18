# Pardot Map plugin
Intended for Astuteo client's use. A simple helper for client forms to push data to Pardot.

## Installation
1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require astuteollc/pardot-map

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Pardot Map.

## Overview
A plugin that works alongside our Freeform forms to push data to Pardot form handlers instead of relying on embedded iFrames.

## Configuring
By default the plugin will process and send the data to Pardot. To log the data that would be pushed without sending create a config file named `pardot-map.php` in the config folder
similar to the example below:
```    
<?php
return [
    '*' => [
        "enableSendToPardot" => true,
    ],
    'dev' => [
        "enableSendToPardot" => false,
    ],
];
```

## Using
In Freeform, create two hidden fields. One with the handle `pardotURL` and another with `mapPardot`.

Add the fields to the form and set the default value of the `pardotURL` to the URL found in Pardot. 

For the `mapPardot` field, add the fields to be mapped to Pardot using `|` as the deliminator. You should use the handle of the field from Freeform and the External Field Name from Pardot. If the handle and the External Field Name are different, you can map them using `<external field name>`:`<freeform handle>`.

An example with matching names may look like this:

`firstName|lastName|email`

An example with names which do not match may look like this:

`pardotFirstName:freeformFirstNameHandle|pardotEmail:freeformEmailHandle`

This can be mixed as needed:

`firstName|lastName|pardotEmail:freeformEmailHandle`