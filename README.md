Welcome! Infinitesimal is a simple blog engine powered by Dropbox, GoodSync, Markdown, and static files.

## Why another blog engine?

I know, I know. Every programmer wants to  build their own blog engine. Me too.

I built Infinitesimal because I wanted to blog without any hassles. First, I wanted to write blog posts locally and have them synced immediately upon saving. Also, I wanted the site to be super fast, so I saved the content in static files instead of a database.

## How do I set it up?

1. Download the package from Github.
2. Unzip the zip.
3. Create a folder locally. You can place it wherever and name it whatever you want.
4. In that folder, create 3 folders named Drafts, Media, Posts, respectively.
5. Upload the unzipped folder to your server and name it something like blog or something.
6. Download GoodSync from URL_HERE.
7. Set up one job to sync the Posts folder and one job to sync the Media folder.
8. Change the settings to activate analysis and sync upon saving.
9. You are ready to go!

## How does it work?

In a nutshell, Infinitesimal can allow you:
1. write blog posts locally in Markdown format
2. sync them to a server in real-time
3. convert the Markdown files into static HTML files
4. serve each static file to readers quickly

Start by creating a blank .markdown file and save it in the Drafts folder with the title as the filename.

Then start writing! Use the appropriate Markdown syntax to format your post.

Once you are done writing and editing your post, hit Save, and move the .markdown file from Drafts to Posts. GoodSync should automatically detect the change and upload the file to the Posts folder on the server.

Next, run the updater at BLOG_URL/update.php and the engine will check for any file differences and make sure all the cache files are created/edited/removed. The homepage will also be automatically changed.

## Cautions

I made Infinitesimal for myself on my server with my blog posts. I released it because I thought it might help out some folks. Unfortunately my time is limited, so I can't provide individual support. But feel free to send me feedback, suggestions, and bug reports to me@stephenou.com.