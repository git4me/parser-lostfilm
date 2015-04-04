<?php

namespace PTSeries\Parser\Lostfilm;

use SleepingOwl\Apist\Apist;

class LostfilmApi extends Apist
{
    public function getBaseUrl()
    {
        return 'http://www.lostfilm.tv/';
    }

    public function getSeries()
    {
        return $this->get('/serials.php', [
            'series' => Apist::filter('#MainDiv .mid .bb .bb_a')->each([
                'name' => Apist::current()->html()->call(function ($name) {
                    return substr($name, 0, strpos($name, '<br>'));
                }),
                'original_name' => Apist::current()->filter('span')->trim('()'),
                'local_id' => Apist::current()->attr('href')->call(function ($href) {
                    return (int) str_replace('/browse.php?cat=', '', $href);
                })
            ])
        ]);
    }
}