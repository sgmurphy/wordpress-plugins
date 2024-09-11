# Changelog

All notable changes of krokedil/klarna-onsite-messaging are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

------------------
## [1.2.0] - 2024-09-11
### Added

* Preview images for the cart and product page placements.
* Added a new method for getting the V2 version of the settings used by Klarna Payments matching the new layout and structure for the Klarna Payments plugins settings pages. Changed the WooCommerce settings API section start and end to be of the types `kp_section_start` and `kp_section_end` respectively.
* Use the new `kp_get_client_id` function from Klarna Payments to get the client id based on the customers country and availability instead of having a separate setting for the package.
* Added changelog.md to the package.

### Fix

* Fixed some PHP 8.2 deprecation warnings.

## [1.1.0] - 2024-08-19
### Added

* Added support for Slovakia.
* Added support for Hungary.
* Added `kosm_hide_placement` filter hook for conditionally hiding the placement.

## [1.0.2] - 2024-05-13
### Fix

* Restore custom theme (previously known as "none").
* Resolved deprecation warning in PHP 8.2.
* Only display the banner if KOSM is enabled.
* The shortcode should now appear wherever used (even on non-shop pages).


## [1.0.1] - 2024-04-22
### Fix

* Check if we have an object before retrieving class.

## [1.0.0] - 2024-04-22
### Added

* Initial release of the package.
