const Parser = require('rss-parser');
const fs = require('fs');

const parser = new Parser();

const feeds = [
  {
    name: 'computerbase',
    url: 'https://www.computerbase.de/rss/downloads.xml'
  },
  {
    name: 'ninite',
    url: 'https://ninite.com/news.rss'
  },
  {
    name: 'pfc',
    url: 'https://feeds.feedburner.com/pfc'
  },
  {
    name: 'portableapps',
    url: 'https://feeds.feedburner.com/PortableAppscom'
  }
];

async function updateFeeds() {

  for (const feed of feeds) {

    try {

      const rss = await parser.parseURL(feed.url);

      const items = rss.items.map(item => ({
        title: item.title || '',
        link: item.link || '',
        pubDate: item.pubDate || ''
      }));

      fs.writeFileSync(
        `feeds/${feed.name}.json`,
        JSON.stringify(items, null, 2)
      );

      console.log(`Updated ${feed.name}`);

    } catch (err) {

      console.error(`Error updating ${feed.name}`);
      console.error(err);

    }

  }

}

updateFeeds();
