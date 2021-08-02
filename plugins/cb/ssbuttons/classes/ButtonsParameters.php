<?php

    namespace Cb\SSButtons\Classes;

    use Lang;

    class ButtonsParameters {

        public static function getParameters($title, $url) {

            $parameters = [

                'twitter' => [
                    'href'  => 'https://twitter.com/share?url=' . urlencode($url) . '&text=' . urlencode($title),
                    'title' => 'Share on Twitter',
                    'class' => ['ssbuttons' => 'btn btn-twitter', 'ssbuttonsnb' => 'share-btn twitter'],
                    'icon'  => 'mdi mdi-twitter',
                    'label' => 'Twitter',
                    'image' => 'twitter',
                    'color' => '#1dcaff',
                ],

                'facebook' => [
                    'href'  => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url),
                    'title' => 'Share on Facebook',
                    'class' => ['ssbuttons' => 'btn btn-facebook', 'ssbuttonsnb' => 'share-btn facebook'],
                    'icon'  => 'mdi mdi-facebook-box',
                    'label' => 'Facebook',
                    'image' => 'facebook',
                    'color' => '#3b5998',
                ],

                'google+' => [
                    'href'  => 'https://plus.google.com/share?url=' . urlencode($url),
                    'title' => 'Share on Google+',
                    'class' => ['ssbuttons' => 'btn btn-googleplus', 'ssbuttonsnb' => 'share-btn google-plus'],
                    'icon'  => 'mdi mdi-google',
                    'label' => 'Google+',
                    'image' => 'googleplus',
                    'color' => '#bebebe',
                ],

                'stumbleupon' => [
                    'href'  => 'http://www.stumbleupon.com/submit?url=' . urlencode($url) . '&title=' . urlencode($title),
                    'title' => 'Share on StumbleUpon',
                    'class' => ['ssbuttons' => 'btn btn-stumbleupon', 'ssbuttonsnb' => 'share-btn stumbleupon'],
                    'icon'  => 'mdi mdi-stumbleupon',
                    'label' => 'Stumbleupon',
                    'image' => '',
                    'color' => '#bebebe',
                ],

                'linkedin' => [
                    'href'  => 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($url) . '&title=' . urlencode($title),
                    'title' => 'Share on LinkedIn',
                    'class' => ['ssbuttons' => 'btn btn-linkedin', 'ssbuttonsnb' => 'share-btn linkedin'],
                    'icon'  => 'mdi mdi-linkedin',
                    'label' => 'LinkedIn',
                    'image' => 'linkedin',
                    'color' => '#bebebe',
                ],

                'tumblr' => [
                    'href'  => 'https://www.tumblr.com/share?v=3&u=' . urlencode($url) . '&t=' . urlencode($title) . '&s=',
                    'title' => 'Post to Tumblr',
                    'class' => '',
                    'icon'  => '',
                    'label' => 'Tumblr',
                    'image' => 'tumblr',
                    'color' => '#bebebe',
                ],

                'pinterest' => [
                    'href'  => 'https://pinterest.com/pin/create/button/?url=' . urlencode($url) . '&description=' . urlencode($title),
                    'title' => 'Pin it',
                    'class' => '',
                    'icon'  => '',
                    'label' => 'Pinterest',
                    'image' => 'pinterest',
                    'color' => '#bebebe',
                ],

                'pocket' => [
                    'href'  => 'https://getpocket.com/save?url=' . urlencode($url) . '&title=' . urlencode($title),
                    'title' => 'Add to Pocket',
                    'class' => '',
                    'icon'  => '',
                    'label' => 'Pocket',
                    'image' => 'pocket',
                    'color' => '#bebebe',
                ],

                'reddit' => [
                    'href'  => 'https://www.reddit.com/submit?url=' . urlencode($url) . '&title=' . urlencode($title),
                    'title' => 'Submit to Reddit',
                    'class' => '',
                    'icon'  => '',
                    'label' => 'Reddit',
                    'image' => 'reddit',
                    'color' => '#bebebe',
                ],

                'wordpress' => [
                    'href'  => 'https://wordpress.com/press-this.php?u=' . urlencode($url) . '&t=' . urlencode($title) . '&s=' . urlencode($title),
                    'title' => 'Publish on WordPress',
                    'class' => '',
                    'icon'  => '',
                    'label' => 'WordPress',
                    'image' => 'wordpress',
                    'color' => '#bebebe',
                ],

                'pinboard' => [
                    'href'  => 'https://pinboard.in/popup_login/?url=' . urlencode($url) . '&title=' . urlencode($title) . '&description=' . urlencode($title),
                    'title' => 'Save to Pinboard',
                    'class' => '',
                    'icon'  => '',
                    'label' => 'Pinboard',
                    'image' => 'pinboard',
                    'color' => '#bebebe',
                ],

                'email' => [
                    'href'  => 'mailto:?subject=' . urlencode($title) . '&body=' . urlencode($title) . ':%20' . urlencode($url),
                    'title' => 'Email',
                    'class' => '',
                    'icon'  => '',
                    'label' => 'Email',
                    'image' => 'email',
                    'color' => '#bebebe',
                ],

            ];

            return $parameters;

        }

    }

?>