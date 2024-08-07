<?php
/**
 * Alertly Email Template
 *
 * This template is used to format the email content sent to users
 * when a new post is published.
 *
 * Variables available:
 * - {featured_image}: The URL of the post's featured image.
 * - {post_title}: The title of the post.
 * - {post_content}: The content of the post.
 * - {author_name}: The name of the author.
 * - {publish_date}: The date the post was published.
 * - {post_link}: The permalink of the post.
 * - {year}: The current year.
 *
 * @package Alertly
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Post Published</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .header img {
            width: 100%;
            height: auto;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333333;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #555555;
            margin-bottom: 20px;
        }
        .content .author, .content .published {
            font-style: italic;
            color: #666666;
        }
        .button {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 10px;
            text-align: center;
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{featured_image}" alt="{post_title}">
        </div>
        <div class="content">
            <h1>{post_title}</h1>
            <p>{post_content}</p>
            <p class="author">Author: {author_name}</p>
            <p class="published">Published: {publish_date}</p>
            <a href="{post_link}" class="button">Learn More</a>
        </div>
        <div class="footer">
            <p>&copy; {year} Alertly. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
