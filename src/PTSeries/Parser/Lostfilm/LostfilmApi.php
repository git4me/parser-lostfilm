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

    public function getEpisodes($id)
    {
        return $this->get('/browse.php',
            [
                'name' => Apist::filter('#MainDiv .mid h1:first')->text(),
                'description' => Apist::filter('#MainDiv .mid div.content + span:first')->text(),
                'episodes' => Apist::filter('#MainDiv .mid div.t_row')->each([
                    'season' => Apist::current()
                        ->filter('table td nobr div a.a_discuss')
                        ->attr('href')->call(function ($href) {
                            parse_str(parse_url($href, PHP_URL_QUERY), $params);
                            return (int) $params['s'];
                        }),
                    'episode' => Apist::current()
                        ->filter('table td nobr div a.a_discuss')
                        ->attr('href')->call(function ($href) {
                            parse_str(parse_url($href, PHP_URL_QUERY), $params);
                            return (int) $params['e'];
                        }),
                    'name' => Apist::current()->filter('td.t_episode_title div div nobr span')->text()->trim(),
                    'original_name' => Apist::current()
                        ->filter('td.t_episode_title div div nobr')
                        ->html()->call(function ($name) {
                            return substr($name, strpos($name, '<br>') + 4);
                        })->trim('()')
                ])
            ],
            [
                'query' => [
                    'cat' => $id
                ]
            ]
        );
    }

    public function getTorrents($seriesId, $season, $episode)
    {
        return $this->get('/nrdr.php', Apist::filter('div div div[style="margin-left:-65px"]')->each(
            [
                'type' => Apist::current()
                    ->filter('td[style="width:55px;"] img')
                    ->attr('src')->ltrim('img/search')->ltrim("_")->rtrim('.png'),
                'link' => Apist::current()->filter('div nobr a')->attr('href')
            ]
        ),
            [
                'query' => [
                    'c' => $seriesId,
                    's' => $season,
                    'e' => $episode
                ],
                'headers' => [
                    'Cookie' => 'uid=xxx; pass=xxx'
                ]
            ]
        );
    }
}