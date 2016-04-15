Admin Subdomain
===============
 
Use a subdomain to access the administration panel of your Thelia

How to install
--------------

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/admin-subdomain-module:~0.2.0
```

#### Manually

-   Download the zip archive and extract it
-   Copy the module into `<path-to-thelia>/local/modules/` directory and be sure that the name of the module is `BackOfficePath`

### Activation

-   Go to the modules's list of your Thelia administration panel (with the default URL)
-   Find the *AdminSubdomain* module
-   Activate it.

Usage
----- 

-   For the moment, no configuration interface exists.
-   To configure the module, you have to go through the database.
-   In the table `module_config`, you can change the value `sub_domain` and `strict_mode`
-   The value `sub_domain` contains your subdomain
-   The value `strict_mode` is by defaults to 0, if you change this value to 1, the administration panel will only be accessible from the subdomain

Todo
-----

-   Add a configuration interface