# simpleOembed 

* [Website](http://timothyreynolds.co.uk)
* Version: 1.0

## Description

A collection of pyroCMS plugins that utlise the oEmbed format to embed media within your pyroCMS website. 

Included in the set is;
    Image
    Video
    oEmbed

Each plugin supports additional undefined attributes that will be passed on the html request to the oEmbed provider.

### Video
The video pyroCMS plug supports the following providers;
youtube
vimeo
bambuser
screenr
ustream
qik
revision3
hulu

### Image 
The image pyroCMS plug supports the following providers;
flickr
smugmug
deviantART
skitch
yfrog

## Usage 

{pyro:image:flickr image_id="luxagraf/137254255/"}

{pyro:video:youtube video_id="4uLSW_hrG9k" maxheight="300" maxwidth="400"}
