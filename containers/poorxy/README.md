# Poorxy 1

## Description

We leaked the code of an image proxy website. The owner claims nothing is compromised, but we beg to differ.

Show them who's boss by reading /flag.txt on their internal server bound to 127.0.0.1:1337

[index.php]

[Launch instance]

## Solution

<details>
        <summary>Click to reveal!</summary>

Every request is doubled: get mimetype, get content.

Curl is only used to accommodate for redirects.

Host a webserver that supplies an image, then immediately follows up with an HTTP 301 redirect to localhost.

That way the mimetype is `image/whatever` but by the time curl requests that same URL it points to the location of the flag.

Browsers won't play nice, so use curl :P
</details>
