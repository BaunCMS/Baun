title: Adding Content
----
# Adding Content

Baun has no database. You simply create `.md` files in the `/content` folder and that becomes a page.

## Site Structure

Every page of your site is represented by a `.md` file in the `/content` folder. You can add as many pages and subfolders
as you like and even nest them as deep as you want. The folder and file names build the URL structure for your site.
Here are some examples:

File                              | URL
--------------------------------- | ---------------------------------
/content/index.md                 | yoursite.com
/content/about.md                 | yoursite.com/about
/content/work.md                  | yoursite.com/work
/content/work/project-1.md        | yoursite.com/work/project-1
/content/nested/folder/project.md | yoursite.com/nested/folder/project
/content/1-example/1-ordering.md  | yoursite.com/example/ordering

If a file can't be found the 404 template will be shown.

### Ordering

By default folders and pages will be ordered alphabetically, however you can order them manually by prefixing the
folder/file name with a number:

    /content/1-setup/1-installing.md
    /content/1-setup/2-configuration.md
    /content/1-setup/3-updating.md
    /content/2-content/1-adding-content.md
    /content/2-content/2-markdown-formatting.md

The number prefixes will not appear in the URL structure of the site.

## File Structure

The structure of the `.md` file is split into two sections, a YAML list of page attributes and the markdown content of
the page. These two sections are split by a `----` separator. For example:

    title: Home
    description: A description for search engines goes here
    ----
    # Home
    This is come example **Markdown** content

You can put any attributes in the info section that you want (which can be used in [custom templates](/themes/custom-templates))
but a list of default attributes are as follows:

Attribute | Description
---- | -----------
`title` (required) | The page title
`description` | A description for search engines used in the `meta` tag
`exclude_from_nav` | Exclude this page from the navigation
`template` | Define a custom template to use

Attributes can be added or removed at any time and there's no limitation how many attributes you have per page. All
attributes are instantly available in Baun's templates.

Each page can contain its very own set of attributes. Together with the flexible folder structure you get a NoSQL-like
data store with literally unlimited possibilities.