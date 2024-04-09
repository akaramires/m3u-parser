# Парсер M3U плейлистов

[![Latest Version on Packagist](https://img.shields.io/packagist/v/akaramires/m3u-parser.svg?style=flat-square)](https://packagist.org/packages/akaramires/m3u-parser)
[![Total Downloads](https://img.shields.io/packagist/dt/akaramires/m3u-parser.svg?style=flat-square)](https://packagist.org/packages/akaramires/m3u-parser)
[![License](https://img.shields.io/packagist/l/akaramires/m3u-parser)](https://packagist.org/packages/akaramires/m3u-parser)

Теги, поддерживаемые парсером:

- #EXTM3U
- #EXTENC
- #PLAYLIST
- #EXT-X-PLAYLIST-TYPE
- #EXT-X-TARGETDURATION
- #EXT-X-VERSION
- #EXT-X-MEDIA-SEQUENCE
- #EXT-X-ALLOWCACHE
- #EXT-X-MAP
- #EXT-X-START
- #EXT-X-ENDLIST
- #EXTINF
- #EXT-X-PROGRAM-DATE-TIME
- #EXTGRP
- #EXTLOGO
- #EXTVLCOPT
- #EXT-X-DISCONTINUITY
- #EXT-X-BYTERANGE

Пример использования:

```php
use Akaramires\M3uParser\Processors\PlaylistProcessor;
use Akaramires\M3uParser\Sources\FileSource;

...

$source = new FileSource(__DIR__ . '/../Data/playlist.m3u');

/** @var PlaylistProcessor $processor */
$processor = app(PlaylistProcessor::class);

$processor->load($source);
$processor->parse();

$playlist = $processor->getPlaylist();
```

Пример ответа:

```php
[
  "inlineAttributes" => [
    [
      "key" => "cache",
      "value" => "500",
    ],
    [
      "key" => "playlist",
      "value" => "1",
    ],
  ],
  "attributes" => [],
  "attributesWithoutValue" => [],
  "channels" => [
    [
      "title" => "TVMatic Comedy",
      "duration" => "0",
      "url" => "https://iptv.com/channel.m3u8",
      "inlineAttributes" => [
        [
          "key" => "tvg-country",
          "value" => "es",
        ],
        [
          "key" => "group-title",
          "value" => "Spain",
        ],
      ],
      "attributes" => [],
    ]
    [
      "title" => "TVMatic Comedy 2",
      "duration" => "0",
      "url" => "https://iptv.com/channel.m3u8",
      "inlineAttributes" => [],
      "attributes" => [],
    ],
  ],
```
