# TheDutchJewel RSS Feeds

Custom RSS feed solution for TheDutchJewel's Favorites.

This project automatically retrieves RSS feeds from several software-related websites, converts them to JSON, and publishes them through GitHub Pages.

Created as a replacement for the FeedEk RSS service after feed.jquery-plugins.net became unavailable.

## Sources

- ComputerBase Downloads
- Ninite Updates
- Portable Freeware Collection
- PortableApps.com

## Features

- Automatic RSS updates via GitHub Actions
- JSON output for easy integration
- GitHub Pages hosting
- No dependency on external RSS parsing services

## Hosting

### Primary (GitHub)

- RSS Viewer: [GitHub Pages](https://thedutchjewel.github.io/rss-feeds/rss.html)

### Backup (GitLab)

- RSS Viewer: [GitLab Pages](https://thedutchjewel.gitlab.io/rss-feeds/)

Both platforms automatically generate and publish the same feeds and viewer page.

## Files

    .github/workflows/update-rss.yml
    update-feeds.js
    rss.html
    package.json

    feeds/
    ├── computerbase.json
    ├── ninite.json
    ├── pfc.json
    └── portableapps.json

### Generated JSON feeds

- `feeds/computerbase.json`
- `feeds/ninite.json`
- `feeds/pfc.json`
- `feeds/portableapps.json`

## GitHub Pages

The generated feeds and RSS page are published through GitHub Pages.

## Purpose

This repository was created to replace the discontinued FeedEk RSS service and provide a reliable, self-maintained RSS solution.

## License

For personal use.
