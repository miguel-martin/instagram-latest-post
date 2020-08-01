# instagram-latest-post
Get Instagram feed posts using instagram basic display API (using PHP).\

## Requeriments
- PHP Hosting (with `cURL` and `fopen()` support) [[Guide]](#php-hosting)
- Facebook Developer App [[Guide]](#facebook-developer-app)
- Instagram Basic Display API [[Guide]](#instagram-basic-display-api)

## Configuration
- Edit `config.sample.php`:
  - Set your Instagram Basic Display API long-lived access token (`$token`)
  - Set your site URL (`$site`).
- Save file as `config.php`.


## About
- Functions defined in `functions.php`: 
  - `request($url)`: cURL requests and return data.
  - `refreshToken()`:  The Instagram long-lived access token token expires in 60 days, but it can be refreshed every 24 hours to restart the expiration time. This function refreshes the token when 24 hours or more have passed since the last update date located at `update.json` file. If 24 hours have been passed, it overwrites the update date in the `update.json` file.
  - `instagramFeed()`: This function calls the Instagram API with your long-lived access token and returns an array with the data of your last 25 posts. The information returned by this function is given by the `fields` GET parameter in `https://graph.instagram.com/me/media?fields=...&access_token=$token`. Refer to official docs for further info.
  - `getLastImage()`: This returns the image url, post permalink and post caption of the last uploaded image.
  - `renderLastImage($styles)`: Renders last image (the image and the caption linked to the original post). CSS can be set for the img.
- `update.json` this file will contains the date when your Instagram long-lived access token was refreshed.
- `test.php`: This is a sample script, it calls `refreshToken()` to update the token if needed, and then calls `renderLastImage()` to display the last uploaded image post.

## Requeriments Guide

- ### PHP Hosting
  You can use any PHP Hosting unless it doesn't support `cURL` or `fopen()`.

- ### Facebook Developer App
  In order to use the instagram API, we must first create a Facebook App. Follow the steps below to create a Facebook App.
1. Go to [Facebook for Developers site](https://developers.facebook.com/), login and click Create App.
2. Create your App ID.
3. In the products tab, add Instagram to use the Instagram API
4. In the Instagram menu, click **Basic Display**, then click **Settings** to update your App settings.
5. Fill these required fields.
    - Privacy Policy URL (Must be a valid url, even if not a privacy policy url)
    - App Icon
    - Business Use
    - Category
6. Scroll down and click Add Platform button.
7. Enter your site URL and save changes.

- ### Instagram Basic Display API
  Now you must authorize your instagram account.
1. Products > Instagram > Basic Display. Create new App.
2. Fill OAuth Redirect, Deauthorize Callback and Data Deletion Request URL with your site URL. Save changes.
3. Add Instagram testers.
4. Enter your Instagram username and select it.
5. Go to your Instagram account settings page > App and Websites > Tester invites, accept the invite.
6. Back to Products > Instagram > Basic Display > User Token Generator, you Instagram account should appear, then click Generate Token button for authorize and generate long-lived access token for instagram.
7. Login to IG and authorize the App.
8. Copy the generated Token.
9. Update `$token` variable at `config.php` with the generated Token.