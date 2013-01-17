=== iProject Web ===
Contributors: wppal
Donate link: http://wp-pal.com/
Tags: project management, task management, risk management, risks, projects, tasks, plugin
Requires at least: 3.3
Tested up to: 3.3.1
Stable tag: 1.0.8.11

Project management and task management software.

== Description ==

<p>
iProject Web is a feature rich and easy to use project management and task management software. It helps to organize effective project team communication.
</p>

Features:
<ol>
<li>
Task status tracking</li>
<li>
User and role management.</li>
<li>
Task history tracking</li>
<li>
Risk management.</li>
<li>
Email notifications.</li>
<li>
Mailing lists.</li>
<li>
Advanced file management</li>
<li>
Different styles for admin and front-end parts of the site.</li>
<li>
Lightweight ajax design</li>
<li>
Knowledge base.</li>
<li>
Custom fields.</li>
<li>
Online help system.</li>
<li>
Advanced GUI.</li>
<li>
Advanced data filtering.</li>
<li>
Advance data navigating.</li>
<li>
Suggestion lists and information windows.
</li>
</ol>



== Installation ==

<ol>
<li>
Put the iprojectweb folder to the /wp-content/plugings directory.</li>
<li>
Activate the plugin in the Plugins menu. It may take several seconds.</li>
<li>
After the program is installed, you will find the iProject Web menu in the Admin Panel.
</li>
</ol>

<ul>
<li>
The application will connect to your admin account, and you will be provided with superadmin credentials.</li>
<li>
Play with the sample data as long as you can and then delete it.
</li>
</ul>



== Frequently Asked Questions ==

= 1. How to run irpojectweb from the site front end? =

Place the <?php iprojectweb_tag();?> tag in your template files in the appropriate place. Make sure to call wp_enqueue_script('jquery'); before get_header();.

= 2. Is it possible to run iProject Web not changing my template files? =

Yes, this is possible. To do that just add a new page and add a single string [iprojectweb_frontend]. When setting the page attributes we suggest using a one-column page template if your template supports this feature. 

== Screenshots ==

1. Task management
2. Mailing lists
3. File management

== Changelog ==

= 1.0.8.7 =
* File download function is fixed.
* Direct menu call support.

= 1.0.8.11 =
* Help is added
* The link to the site user profile is fixed
* Application settings are extended
* Several bugs fixed

== Upgrade Notice ==

Help is added. 
Site user profile link is fixed.
