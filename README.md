# SimpleController

## URL Mapping

Requests are mapped to PHP controllers or static HTML by translating URLs to file paths.

To generate the filename, the request URL is transformed in the following way.

- Converts URL to lower case
- Strips all characters except for letters, numbers, dashes and forward slashes
- Replaces forward slashes with underscores

### Controller Example

URL

    /example/page-name?something=else

Resolved Path

    controller/example_page-name.php

### Static HTML Example

Example URL

    /example/page-name?something=else

Resolved Path

    static/example_page-name.html

