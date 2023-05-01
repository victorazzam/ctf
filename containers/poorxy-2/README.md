# Poorxy 2

## Description

Devs fixed the previous bug and moved to a new code base with a <em>bizarre version control system.</em>

## Solution

<details>
		<summary>Click to reveal!</summary>

1. Bizarre refers to a DVCS by Canonical called Bazaar, so leak source from /.bzr

2. Discover CVE-2021-28918 via the netmask npm package.

3. Get private IP from the /ip endpoint, it should be enough to guess and deduce the internal server's IP as well.

4. Exploit by requesting the internal server's private IP in octal form, with port 1337.

5. Bypass extension checks with ?.jpg and traverse memes to win.

Payload: `http://0177.0.0.1:1337/memes/so/many/memes/notameme/noreallyitsnotameme/flag.txt?.jpg`
</details>

## Notes

https://johnjhacking.com/blog/cve-2020-28360

https://sick.codes/universal-netmask-npm-package

https://github.com/rs/node-netmask/blob/master/README.md
