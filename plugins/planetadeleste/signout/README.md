## OctoberCMS SignOut plugin

Automatically logout authenticated front end user after configured timeout. Based on [Renatio.Logout](http://octobercms.com/plugin/renatio-logout) plugin, but for front end.

> This plugin requires [**RainLab.User**](http://octobercms.com/plugin/rainlab-user)

You can specify the user logged in time without performing any action. Them, a notification alert prompt to continue or close session. If user doesn't do any action, the session was closed.

In backend settings, you can specify session lifetime, use notify alert and lifetime of current alert.

### Installation {#plugin-installation}
From `Setting / System / Updates` panel, click on `Install plugins` button and write `PlanetaDelEste.SignOut`.

* * *

### Settings
From backend, you can config many option.

**Session lifetime**  
Specify in minutes, how long is the session.

**Display alert of session timeout**  
Through this switch, can alert users of session next to close.

**Alert lifetime**
Can set, in seconds, alert auto close timer.

**Alert text**  
Write the alert text that users was see after session timeout. There are two special keys that you can use.  
`{timeout}` - Replaced with a countdown with the remaining seconds after alert and session close.
`|`Separate the text block to **title** and **description** alert. The alert js script used is [SweetAlert](http://t4t5.github.io/sweetalert/). If use more that one character `|`, only was used the first two blocks.

**Text button to close**  
Set the text for the "close", "cancel" button

**Text button to continue**  
Set the text for the "continue" button

### Component
![Component settings](http://storage9.static.itmages.com/i/17/0525/h_1495709983_7906381_64ed299595.png)
Component have only one option, is to load SweetAlert javascript library. 

#### Notes!
The component add the javascript files using `{% put scripts %}`. Is important to attach the component in the page or layout with the markup `{% component 'SessionClose' %}`. This can be outside html tags.

    {% component 'SessionClose' %}
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>October CMS - {{ this.page.title }}</title>