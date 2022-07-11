# Creed Interactive Challenge

**Creed Interactive Challenge** It is a project made up of a WordPress theme and a WordPress plugin that work together. The purpose of the project is to demonstrate knowledge in the development of plugins and themes for wordpress.

The "Podcast by Genre" plugin fetches podcast records from a json file and saves them to a custom post type , named "Podcast", created by the plugin. Allows editing of them.

The Theme "Creed Code Challenge" is a wordpress theme that styles the above plugin to meet the design guidelines requested by Creed.

** Theme Creed Code Challenge
The theme is based on the "Creed Code Challenge" theme that was handed out as part of the challenge instructions.

Added the following files:

*** /wp-content/themes/challenge-theme/page-challenge.php
It is the template of the page used to display the plugin

*** /wp-content/themes/challenge-theme/library/css/podcast-style.css
It is the style created for the page that the plugin displays.

*** /wp-content/themes/challenge-theme/library/scss/podcast-style.scss
It is the sass file on which the style is created.


** Plugin Podcast by Genre.
The plugin configuration is accessed from the Wordpress desktop menu through the item "Podcast by Genre".

From it, the .json file from which the podcast records will be imported is selected.

Presumption: file contains valid podcast information

*** Short Code
The plugin is used through the shortcode [show_podcast] which must be used in a wordpress page that uses the "Custom Page for Challenge" template.

The short code only gets styling from the theme if it is used through a wordpress page with the "Custom Page for Challenge" page template.


** Improvements that can be made
*** Validation of the structure of the json file.
*** CSRF Protection to protect plugin import form submit
*** Creation of file uninstall.php: To clean the database of podcasts created or not when the plugin is removed or uninstalled.
