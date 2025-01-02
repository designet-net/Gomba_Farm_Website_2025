<a href="https://newfold.com/" target="_blank">
    <img src="https://newfold.com/content/experience-fragments/newfold/site-header/master/_jcr_content/root/header/logo.coreimg.svg/1621395071423/newfold-digital.svg" alt="Newfold Logo" title="Newfold Digital" align="right" 
height="42" />
</a>

# WordPress Marketplace Module

A module for rendering product data and interacting with the Hiive marketplace API.

## Installation

### 1. Add the Newfold Satis to your `composer.json`.

 ```bash
 composer config repositories.newfold composer https://newfold.github.io/satis
 ```

### 2. Require the `newfold-labs/wp-module-marketplace` package.

 ```bash
 composer require newfold-labs/wp-module-marketplace
 ```

[More on NewFold WordPress Modules](https://github.com/newfold-labs/wp-module-loader)

## Features

### PHP API proxy

This module creates a wp-json API endpoint in the site that proxies an open endpoint on the hiive to get related products based on brand (amid other criteria). The endpoint results are saved as a transient for 24 hours to minimize repeated external requests, but still fetch current marketplace items frequently.
### Javascript Components

The module also contains some javascript components that are used together within a brand plugin to load the products. There are 3 components:

1. Marketplace - the main component, this one gets loaded into the plugin app with some props and loads the rest.
2. MarketplaceList - this loads the contents of the TabPanel, basically a collection of marketplace items.
3. MarketplaceItem - This is used to render each item in the list.
4. MarketplaceLite - this is a simpler main component, it displays a single category/vendor of products and removes tab navigation.

The main Marketplace component expects 3 props with others nested within. This is so the module can be very light and not have complex dependencies. The plugin app, will have these components and methods in place and must pass them to the component as follows:
```javascript
// Components to pass to module
const moduleComponents = {
    Button,
    Card,
    CardBody,
    CardFooter,
    CardHeader,
    CardMedia,
    TabPanel,
    Spinner,
};
// methods to pass to module
const moduleMethods = {
    apiFetch,
    classnames,
    useState,
    useEffect,
    useNavigate,
    useLocation
};
// constants to pass to module
const moduleConstants = {
    'resturl': window.resturl,
    'eventendpoint': '/newfold-data/v1/events/',
    'perPage': 12,
    'supportsCTB': false,
}

return (
    <NewfoldMarketplace 
        Components={moduleComponents}
        methods={moduleMethods}
        constants={moduleConstants}
    />
);
```
The module expects these components, methods to be passed as props. The constants are any settings specific to implementation in the plugin. For example the resturl is for the current site and is determined on page render, written via php to the javascript window object in an inline script. The event endpoint is so that the marketplace clicks and interactions can send events to the data module.

The only other interactions is the module expects a container from the module loader to include a plugin value with an id. This is how the default brand is selected for products to be returned from the hiive endpoint. This may be overriden by setting brand and optionally a region property in the same container. This would be in case the brand value does not match the plugin id value or to load region specific products.

Marketplace will load "Featured" products in the first tab, followed by the remaining categories in alphabetical order.

The Products are each rendered via the MarketplaceItem component. This will pull in the Title, description, formatted_price (localized with proper currency and term detail), thumbnail image (should be 1180x660px or a matching aspect ratio at least), and CTA buttons. The primary button will load as well as an optioonal secondary button. If a CTB id exists (and the component level constant supportCTB allows it) the primary button will tranform into a CTB button which will open the click to buy modal.

### Premium Plugins
This module adds plugin marketplace products to a "Premium Plugins" tab and subnavigation link in the WordPress plugin section. To disable this feature use the `nfd_enable_plugins_marketplace` filter and return `false` in the plugin like so:
```
add_filter( 'nfd_enable_plugins_marketplace', '__return_false' );
```

## Changelog

See the releases for the changelog and version details. 

https://github.com/newfold-labs/wp-module-marketplace/releases