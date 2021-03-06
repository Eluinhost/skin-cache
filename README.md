SkinCache
============

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/bd938e72-b546-451c-ba20-0bc616e63791/small.png)](https://insight.sensiolabs.com/projects/bd938e72-b546-451c-ba20-0bc616e63791)

Cache Minecraft skins/icons and serve them locally.

Dependencies
------------

All dependencies are handled by composer. Installing cURL is recommended and will be used if installed but it isn't required.

Usage
-----

There is a class `PublicUHC\SkinCache\SimpleSkinFetcher` that uses some default classes and can be used like this:

    $fetcher = new SimpleSkinFetcher('https://minotar.net', 10, './cache', 3600);

To change the classes used or for better tweaking use the class `PublicUHC\SkinCache\SkinFetcher`.

It requires a Downloader, a Formatter, a PoolInterface and a ErrorImagePainter. It also requires a 'ttl', either null to store forever, an integer as the number of seconds until expiry or a DateTime for when the fetched skins should expire.

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

NOTE: Only the raw images are cached, any formatting is applied to the raw images

There are 3 implementations of the formatter available:

`PublicUHC\SkinCache\Formatters\HttpResponseFormatter`

It formats the images in a Symfony HttpResponse format from the [Symfony Http Foundation project](https://github.com/symfony/HttpFoundation)

`PublicUHC\SkinCache\Formatters\RawImageFormatter`

Returns the image as the raw image string

`PublicUHC\SkinCache\Formatters\GreyscaleFormatter`

Returns the image as a greyscale version of itself

Formatters can be chained to make multiple formatting passes:

    $formatter = (new GreyscaleFormatter())->then(new HttpResponseFormatter());
    
This will first make it greyscale and then make it a Http Foundation response.

### PoolInterface

Expects a PoolInterface from the [Stash PHP Project](https://github.com/tedious/Stash).

Example - throws away objects, no cache:

    $pool = new Pool(new BlackHole());
    
Example - using the default Ephemeral driver:

    $pool = new Pool();
    
### ErrorImagePainter

There is only 1 implementation of the error image painter available:

`PublicUHC\SkinCache\Painters\TransparentImagePainter`

It will return a transparent image of the same dimensions for error images
    
### Full Example

The following example uses the MinotarLikeDownloader to fetch skins from the official minotar site, formats them in Http Foundation Response style and uses the default Ephemeral cache driver and then fetches the helm for the 'ghowden' account 16x16

    $downloader = new MinotarLikeDownloader(new Client(['base_url'=>'https://minotar.net/']));
    $fetcher = new SkinFetcher($downloader, new HttpResponseFormatter(), new Pool(), new TransparentImagePainter());
    
    $fetcher->fetchHelm('ghowden', 16);