# Laravel Flock Notification Channel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vrajroham/laravel-flock-notification.svg?style=flat-square)](https://packagist.org/packages/vrajroham/laravel-flock-notification)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/vrajroham/laravel-flock-notification/master.svg?style=flat-square)](https://travis-ci.org/vrajroham/laravel-flock-notification)
[![StyleCI](https://styleci.io/repos/127184015/shield)](https://styleci.io/repos/127184015)
[![Quality Score](https://img.shields.io/scrutinizer/g/vrajroham/laravel-flock-notification.svg?style=flat-square)](https://scrutinizer-ci.com/g/vrajroham/laravel-flock-notification)
[![Total Downloads](https://img.shields.io/packagist/dt/vrajroham/laravel-flock-notification.svg?style=flat-square)](https://packagist.org/packages/vrajroham/laravel-flock-notification)

This package makes it easy to send notifications using [Flock](https://flock.com/) with Laravel 5.3+.

```php
return FlockMessage::create()
    ->content('Laravel Flock Notification Channel')
    ->attachment(function ($attachment) {
                $attachment->title('Button Widget')
                    ->description('Description')
                    ->color('#fff000');
            });
```
                
## Contents

- [Installation](#installation)
    - [Setting up the Flock service](#setting-up-the-flock-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Examples](#examples)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

Install this package with Composer:

    composer require vrajroham/laravel-flock-notification
    
Register the ServiceProvider in your config/app.php (If you are using Laravel < 5.5):

    Vrajroham\LaravelFlockNotification\FlockServiceProvider::class,


## Setting up the flock service

Create incoming webhook by going to [https://admin/flock.com](https://admin.flock.com) or by choosing **Manage your team** in Flock desktop app.

For more information see the [flock documentation](https://docs.flock.com/display/flockos/Create+An+Incoming+Webhook) to create incoming webhook.


## Usage

You can now send messages in Flock Group by creating a FlockMessage:

- Add `routeNotificationForFlock()` to `App\User` model

```php
public function routeNotificationForFlock()
{
    return $this->flock_webhook_url;
}
```

```php
<?php

use Vrajroham\LaravelFlockNotification\FlockChannel;
use Vrajroham\LaravelFlockNotification\FlockMessage;
use Illuminate\Notifications\Notification;

class OderCreated extends Notification
{
    public function via($notifiable)
    {
        return [FlockChannel::class];
    }

    public function toFlock($notifiable)
    {
        return FlockMessage::create()
            ->content('Order created')
            ->attachments(function ($attachment) {
                $attachment->title('View order')
                    ->description('Order description')
                    ->color('#fff000');
            });
    }
}
```

### Available Message methods

Complete message and attachment schema can be found at [Flock Message Object](https://docs.flock.com/display/flockos/Message) and [Flock Attachment Object](https://docs.flock.com/display/flockos/Attachment)

- content(`$string`)  
- flockml(`$string`)  _//[FlockML](https://docs.flock.com/display/flockos/FlockML) as attachment_
- notification(`$string`)  
- sendAs(`$senderName`, `$profileImageUrl`)  
- attachments(`callback`)
    + title(`$string`) 
    + description(`$string`)  
    + color(`$string`) 
    + url(`$url`) 
    + id(`$string`) 
    + forward(`$boolean`) 
    + views(`callback`)
        * widget(`$source`, `$height`, `$width`) 
        * html(`$inlineHtmlString`, `$height`, `$width`) 
        * flockml(`$flockMLString`)
        * image(`callback`)
            - original(`$url`, `$height`, `$width`) 
            - thumbnail(`$url`, `$height`, `$width`) 
            - filename(`$filename`) 
    + downloads(`array`) 
    
        ```php
        // Only 'src' field is mandatory.
        [
            [
                'src' => 'https://vrajroham.me/dl/vrajroham_cv.pdf', 
                'mime' => 'application/pdf', 
                'filename' => 'CV.pdf', 
                'size' => 2000 //bytes
            ],
            ...        
        ]
        ```
    - buttons(`array`) 
        ```php
        [
            [
                'name' => 'Button Name',
                'icon' => 'https://avatars1.githubusercontent.com/u/12662173?s=460&v=4',
                'action' => [
                        'type' => 'openBrowser',
                        'url' => 'https://laravel.com',
                        'desktopType' => 'sidebar',
                    ],
                'id' => 'btn1'
            ],
            ...
        ]
        ```


## Examples

#### Text as contents

![Imgur](https://i.imgur.com/VmCK2Nf.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->content('This is text notification.');
}
```

#### Change sender name and image

![Imgur](https://i.imgur.com/aWtVutw.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->content('This is text notification.')
        ->sendAs("Vaibhavraj", 'https://avatars1.githubusercontent.com/u/12662173?s=460&v=4');
}
```

#### Change message color

![Imgur](https://i.imgur.com/P3OdnmO.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->attachments(function ($attachment){
                $attachment->title('This is error message.')
                ->color('#FF0000'); //Red
            });
}
```

#### Change notification text for mobile application

![Imgur](https://i.imgur.com/LIpd1Zo.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->notification('You have important message')
        ->content('This is text notification.');
}
```

####  Website as widget

![Imgur](https://i.imgur.com/XlTVGfK.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->attachments(function ($attachment){
                $attachment->title('Website as widget')
                ->views(function ($view){
                        $view->widget('https://vrajroham.me', 400, 400);
                    });
            });
}
```


#### Buttons

![Imgur](https://i.imgur.com/95Ss9eF.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->attachments(function ($attachment){
                $attachment->title('This are the buttons')
                ->buttons([
                    [
                        'name' => 'Button 1',
                        'icon' => 'https://avatars1.githubusercontent.com/u/12662173?s=460&v=4',
                        'action' => [
                                'type' => 'openBrowser',
                                'url' => 'https://github.com/vrajroham',
                            ],
                        'id' => 'btn1'
                    ],
                    [
                        'name' => 'Button 2',
                        'icon' => 'https://laravel.com/favicon.png',
                        'action' => [
                                'type' => 'openBrowser',
                                'url' => 'https://laravel.com',
                            ],
                        'id' => 'btn2'
                    ]
                ]);
        });
}
```

#### Image as attachment

![Imgur](https://i.imgur.com/IIyN5Ns.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->attachments(function ($attachment) {
             $attachment->title('Image as attachment')
             ->views(function ($view) {
                 $view->image(function ($image)
                 {
                     $image->original('https://avatars1.githubusercontent.com/u/12662173?s=460&v=4',400,400)
                     ->thumbnail('https://avatars1.githubusercontent.com/u/12662173?s=460&v=4',100,100)
                     ->filename('vaibhavraj.png');
                 });
             });
         });
}
```

#### Download Link

![Imgur](https://i.imgur.com/42Wbnsz.png)

```php
public function toFlock($notifiable)
{
    return FlockMessage::create()
        ->attachments(function ($attachment) {
             $attachment->title('Download link')
             ->downloads([
                [
                    'src' => 'https://vrajroham.me/dl/vrajroham_cv.pdf',
                    'mime' => 'application/pdf',
                    'filename' => 'file-1.pdf',
                    'size' => 1500
                ],
             ]);
         });
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email vaibhavraj.developer@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for more information about contributors.

## Credits

- [Vaibhavraj Roham](https://github.com/vrajroham)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
