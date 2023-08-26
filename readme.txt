=== WPGraphQL BeBuilder ===
Contributors: nordcom, filiphsandstrom
Donate link: https://github.com/sponsors/filiphsps
Tags: Headless WordPress, BeBuilder, WPGraphQL, GraphQL, Betheme
Requires at least: 6.0
Tested up to: 6.3
Requires PHP: 8.0
Stable tag: 0.1.0
License: MIT
License URI: https://github.com/NordcomInc/wp-graphql-bebuilder/blob/main/LICENSE

A WordPress plugin to expose BeBuilder page objects through WPGraphQL.

== Description ==

Access BeBuilder page components though the WordPress GraphQL API.
The components are exposed as JSON strings as the field `mfnItems`
on the Page object.

== NOTE ==

For this plugin to do anything at all you're required to have a theme that
provides the page builder "BeBuilder". This won't magically give that you.

== Changelog ==

= 0.1.0 =
* Initial release!
* Access the json objects through the `mfnItems` field on the `Page` object.
