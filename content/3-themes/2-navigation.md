title: Navigation
----
# Theme Navigation

Baun takes the hassle out of creating your own navigation by generating it for you. To output the navigation
you must use the `{{ baun_nav() }}` function in your template. The navigation HTML will look like:

    <ul class="baun-nav">
        <li class="baun-nav-item item-0 baun-nav-active"><a href="/">Home</a></li>
        <li class="baun-nav-item item-1"><a href="/example">Example</a></li>
        <li class="baun-nav-item baun-nav-has-children">Setup
            <ul>
                <li class="baun-nav-item item-0"><a href="/setup/installing">Installing</a></li>
                <li class="baun-nav-item item-1"><a href="/setup/configuration">Configuration</a></li>
                <li class="baun-nav-item item-2"><a href="/setup/updating">Updating</a></li>
            </ul>
        </li>
        <li class="baun-nav-item baun-nav-has-children">Content
            <ul>
                <li class="baun-nav-item item-0"><a href="/content/adding-content">Adding Content</a></li>
                <li class="baun-nav-item item-1"><a href="/content/markdown-formatting">Markdown Formatting</a></li>
            </ul>
        </li>
        ...
    </ul>

You can exclude a page from the navigation by adding `exclude_from_nav: true` to the page attributes.