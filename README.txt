=== Form Validation Action Addon for Elementor ===
Contributors: andresitorresm
Donate link: https://aitorres.com/
Tags: elementor, elementor-forms, validation
Requires at least: 3.0.1
Tested up to: 6.7
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a custom validation action for Forms to your Elementor installation to run server-side validation for your form fields.

== Description ==

**Validation Action Add-on for Elementor Forms** is a custom add-on that allows you to add server-side validation actions to your Elementor
Forms. These validations can run before any other action is processed (e.g. sending an email, collecting submissions)
to easily ensure the user input matches validation logic chosen by you.

You can specify one or multiple validation actions for each one of your form fields based on their ID. Each validation
will run independently from others, and if any action does not succeed, the user will get visual feedback.

Supported actions include:

- Maximum length for a field
- Minimum length for a field
- Maximum amount of words in a field
- Minimum amount of words in a field
- Field must start with a given value
- Field must end with a given value
- Field must contain a given value
- Content of a field must match content of another field (e.g. "Password" and "Confirm password")
- Content of a field must be before / after a given date
- Content of a field must be before / after another field

Validations set for optional fields will only run if the field is not empty.


== Installation ==

**Elementor** and **Elementor Pro** are required in order to install and use this plugin.

You can install the plugin from your WordPress admin dashboard by either looking it up on the
plugin directory, or manually uploading the ZIP file to your site.

Once the plugin is done, you can select the "*AIT Validation Action*" option when selecting
actions on your Elementor Forms. Once you select the action, a new settings block will appear
to let you setup each field's validations.

It is recommended to set the "*AIT Validation Action*" to run _before_ any other actions, in
order to block further processing if the fields don't validate as expected.

== Frequently Asked Questions ==

= Can I setup multiple validations for a field? =

Yes! You can set up as many validations as you want. Keep in mind that the plugin will *not*
verify whether the validations you setup contradict each other (e.g. minimum length of 6 but
maximum length of 4).

= Can I setup validations for an optional field? =

Yes! The validation will only run if the field is not empty. Otherwise it will be skipped.

= Do I have to setup validations for all my fields? =

No! You can specify validation actions for just one field, or as many as you'd like.

== Screenshots ==

1. Screenshot of the plugin in action, with custom validations either passing or failing on each field.

== Changelog ==

= 1.2.0 =
* Introduce two new pairs of validation actions:
  1. Before / After a date
  2. Before / After a date (given by another field)
* Tested against WordPress 6.7 and the latest Elementor version.

= 1.1.0 =
* Introduce two new possible validation actions:
  1. Minimum words
  2. Maximum words
* Code refactors.

= 1.0.0 =
* Initial release.
