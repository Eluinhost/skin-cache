SkinCache
============

Cache Minecraft skins/icons and serve them locally.

DEV STATUS: IN PROGRESS / INCOMPLETE

Dependencies
------------

All dependencies are handled by composer. Installing cURL is recommended and will be used if installed but it isn't required.

Usage
-----

First you will need to get hold of a PublicUHC\SkinCache\SkinFetcher.

It requires a Downloader, a Formatter and a PoolInterface.

### Downloader

There is only 1 implementation of downloader available:

`PublicUHC\SkinCache\Downloaders\MinotarLikeDownloader`

It fetches from a base URL supplied in a minotar-like fashion. 

Skins are fetched from `<base_url>/skin/<username>`

Helms are fetched from `<base_url>/helm/<username>/<size>.png`

Heads are fetched from `<base_url>/avatar/<username>/<size>.png`

It expects a `GuzzleHttp\Client` object initialized for getting the data with. At minimum a base_url needs to be set.

    $client = new GuzzleHttp\Client(['base_url' => 'https://minotar.net/']);
    
For more information on the Client object visit [the Guzzle project on GitHub](https://github.com/guzzle/guzzle)

It also expects a timeout in seconds for the fetching.

Example for fetching from minotar.net with a 30 second timeout:

    $downloader = new MinotarLikeDownloader(new Client(['base_url' => 'https://minotar.net/']), 30);
    
    
### Formatter

There is only 1 implementation of the formatter available:

`PublicUHC\SkinCache\Formatters\HttpResponseFormatter`

It formats the images in a Symfony HttpResponse format from the [Symfony Http Foundation project](https://github.com/symfony/HttpFoundation)

### PoolInterface

Expects a PoolInterface from the [Stash PHP Project](https://github.com/tedious/Stash).

Example - throws away objects, no cache:

    $pool = new Pool(new BlackHole());
    
Example - using the default Ephemeral driver:

    $pool = new Pool();
    
### Full Example

The following example uses the MinotarLikeDownloader to fetch skins from the official minotar site, formats them in Http Foundation Response style and uses the default Ephemeral cache driver and then fetches the helm for the 'ghowden' account 16x16

    $downloader = new MinotarLikeDownloader(new Client(['base_url'=>'https://minotar.net/']));
    $fetcher = new SkinFetcher($downloader, new HttpResponseFormatter(), new Pool());
    
    $fetcher->fetchHelm('ghowden', 16);