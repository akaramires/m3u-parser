<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Enum;

use Akaramires\M3uParser\Contracts\TagContract;
use Akaramires\M3uParser\Tags\ChannelAttributeTag;
use Akaramires\M3uParser\Tags\ExtInfTag;
use Akaramires\M3uParser\Tags\ExtM3uTag;
use Akaramires\M3uParser\Tags\PlaylistAttributeWithoutValueTag;
use Akaramires\M3uParser\Tags\PlaylistAttributeTag;

enum TagNameEnum: string
{
    case EXTM3U = '#EXTM3U';

    case EXTENC = '#EXTENC';
    case PLAYLIST = '#PLAYLIST';
    case EXTXPLAYLISTTYPE = '#EXT-X-PLAYLIST-TYPE';
    case EXTXTARGETDURATION = '#EXT-X-TARGETDURATION';
    case EXTXVERSION = '#EXT-X-VERSION';
    case EXTXMEDIASEQUENCE = '#EXT-X-MEDIA-SEQUENCE';
    case EXTXALLOWCACHE = '#EXT-X-ALLOWCACHE';
    case EXTXMAP = '#EXT-X-MAP';
    case EXTXSTART = '#EXT-X-START';

    case EXTXENDLIST = '#EXT-X-ENDLIST';

    case EXTINF = '#EXTINF';
    case EXTXPROGRAMDATETIME = '#EXT-X-PROGRAM-DATE-TIME';
    case EXTGRP = '#EXTGRP';
    case EXTLOGO = '#EXTLOGO';
    case EXTVLCOPT = '#EXTVLCOPT';
    case EXTXDISCONTINUITY = '#EXT-X-DISCONTINUITY';
    case EXTXBYTERANGE = '#EXT-X-BYTERANGE';

    public function getTag(): TagContract
    {
        return match ($this) {
            self::EXTM3U => new ExtM3uTag($this),
            self::EXTINF => new ExtInfTag($this),

            self::EXTENC,
            self::PLAYLIST,
            self::EXTXPLAYLISTTYPE,
            self::EXTXTARGETDURATION,
            self::EXTXVERSION,
            self::EXTXMAP,
            self::EXTXALLOWCACHE,
            self::EXTXSTART,
            self::EXTXMEDIASEQUENCE => new PlaylistAttributeTag($this),

            self::EXTXENDLIST => new PlaylistAttributeWithoutValueTag($this),

            self::EXTXPROGRAMDATETIME,
            self::EXTLOGO,
            self::EXTVLCOPT,
            self::EXTXDISCONTINUITY,
            self::EXTXBYTERANGE,
            self::EXTGRP => new ChannelAttributeTag($this),
        };
    }
}
