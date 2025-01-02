<a href="https://newfold.com/" target="_blank">
    <img src="https://newfold.com/content/experience-fragments/newfold/site-header/master/_jcr_content/root/header/logo.coreimg.svg/1621395071423/newfold-digital.svg" alt="Newfold Logo" title="Newfold Digital" align="right" 
height="42" />
</a>

# Secure Passwords WordPress Module

This module requires users to use more secure passwords by preventing the use of any passwords exposed in data breaches.

To determine if a password is insecure, the module interacts with the Have I Been Pwned API, which contains a list of
passwords previously exposed in data breaches. When this module was created, this API contained more than half a billion
passwords. New data breaches are added as they occur.

## Installation

### 1. Add the Newfold Satis to your `composer.json`.

 ```bash
 composer config repositories.newfold composer https://newfold-labs.github.io/satis/
 ```

### 2. Require the `newfold-labs/wp-module-secure-passwords` package.

 ```bash
 composer require newfold-labs/wp-module-secure-passwords
 ```

## Usage

## More on NewFold WordPress Modules

[More on NewFold WordPress Modules](https://github.com/newfold-labs/wp-module-loader)