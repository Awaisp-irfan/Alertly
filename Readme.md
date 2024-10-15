Alertly WordPress Plugin Documentation

Overview



Features

📨 Email Alerts: Sends email notifications to subscribers whenever a new post is published.

👥 Subscriber Management: Allows administrators to manage subscribers directly from the WordPress admin area.

📝 Logging: Logs details of sent emails, including successful and failed sends, to help administrators troubleshoot issues.

🛠️ Admin Interface: Provides a user-friendly interface for managing alerts, subscribers, and email logs.

Folder Structure

📁 alertly/
├── 📂 includes/
│   ├── 📂 classes/
│   │   ├── 📄 class-alertly-admin.php
│   │   ├── 📄 class-alertly-assets.php
│   │   ├── 📄 class-alertly-checks.php
│   │   ├── 📄 class-alertly-email-logger.php
│   │   ├── 📄 class-alertly-email.php
│   │   ├── 📄 class-alertly-subscriber.php
│   │   └── 📄 class-alertly.php
│   ├── 📂 helpers/
│   │   └── 📄 autoloader.php
│   └── 📂 traits/
│       └── 📄 trait-singleton.php
├── 📂 templates/
│   ├── 📄 alertly-admin-log-details-page.php
│   ├── 📄 alertly-admin-log-page.php
│   ├── 📄 alertly-admin-subscribers-page.php
│   ├── 📄 alertly-checks-page.php
│   └── 📄 alertly-email-template.php
└── 📄 alertly.php

Main Components

1. alertly.php

This is the main file of the plugin that initializes its core functionality. It includes metadata about the plugin, defines constants for paths, and includes an autoloader for loading necessary classes. The plugin is initialized using the main Alertly class, which serves as the central point for setting up other components.

2. Classes

class-alertly.php

This class is the core of the plugin, responsible for initializing all the other classes. It uses the Singleton design pattern to ensure there is only one instance of the Alertly class during the plugin's lifecycle.

class-alertly-admin.php

Manages the administrative aspects of the plugin, such as adding settings pages and subscriber management. It adds pages for managing email logs and subscribers, making it easier for administrators to configure the plugin and monitor its operations.

class-alertly-assets.php

Handles loading JavaScript and CSS assets for the plugin. It registers and enqueues these assets as needed to ensure that the plugin's interface is properly styled and functional.

class-alertly-checks.php

Performs various system checks to verify that the environment meets the plugin's requirements. This might include checking PHP versions, server configurations, or other dependencies necessary for the plugin to work correctly.

class-alertly-email-logger.php

Logs the details of all emails sent by the plugin, including successes and failures. This log is used to track email activities and provides transparency to administrators. Each email log entry records the recipients, the status of the email (sent or failed), and any associated error messages.

class-alertly-email.php

Handles the email-sending functionality of the plugin. It sends notifications when new posts are published and customizes email content using placeholders that are replaced with actual data (e.g., post title, author name). This class also logs the results of the email-sending process.

class-alertly-subscriber.php

Manages the subscribers who receive notifications. It allows administrators to add or remove subscribers, as well as manage their preferences. This ensures that the plugin can cater to users who wish to receive alerts.

3. Helpers

autoloader.php

Implements an autoloader for the plugin, which automatically includes PHP class files as needed. This reduces the need for manual includes and makes the plugin more modular and easier to maintain.

4. Traits

trait-singleton.php

Implements the Singleton design pattern, ensuring that classes using this trait can only have a single instance throughout the plugin's lifecycle. This is particularly useful for classes like Alertly, where having multiple instances would lead to issues in the plugin's workflow.

5. Templates

alertly-admin-log-details-page.php

Provides a detailed view of individual email log entries. Administrators can see which users received an email and any issues that occurred during the sending process.

alertly-admin-log-page.php

Displays an overview of all the emails sent by the plugin. It provides a list of email logs, making it easy for administrators to track sent notifications and address any delivery issues.

alertly-admin-subscribers-page.php

Allows administrators to view and manage subscribers directly from the WordPress admin area. They can add, remove, or update subscriber information through this page.

alertly-checks-page.php

Displays results of the various checks performed by the plugin to verify compatibility and proper configuration. It helps administrators address any issues that might prevent the plugin from functioning correctly.

alertly-email-template.php

Defines the HTML structure for the emails sent by the plugin. It includes placeholders like {post_title} and {author_name} that are replaced with actual content when an email is sent. This template helps maintain consistent branding and makes the emails visually appealing.

Installation and Usage

📥 Installation: Upload the plugin folder to your WordPress wp-content/plugins/ directory or install it via the WordPress plugin interface by uploading the zip file.

✅ Activation: Activate the plugin through the 'Plugins' menu in WordPress.

⚙️ Configuration: Use the settings pages added to the WordPress admin area to manage subscribers, view email logs, and configure the plugin's settings.

✉️ Email Notifications: When a new post is published, the plugin will automatically send an email to all subscribers.

Requirements

WordPress Version: 5.0 or higher

PHP Version: 7.0 or higher

Dependencies: Requires server configurations that support email sending, such as properly configured SMTP settings.

Summary

For questions or additional information, please refer to the official documentation or contact the plugin author.~