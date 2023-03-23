# "Table of contents" generator Laravel package

This package provides clickable Table Of Contents for your posts, news, articles etc based on h2-h6 html tags from input text.

[![Build Status](https://travis-ci.org/NikolayOskin/contents.svg?branch=master)](https://travis-ci.org/NikolayOskin/contents)
[![laravel version](https://img.shields.io/badge/Laravel%20version-≧5.5-red.svg)](https://github.com/NikolayOskin/contents)

## Usage

Let's say you have some posts (from WYSIWYG editor or something) stored in your database which looks like this:

    <h2>First h2 header</h2>
    <p>Some text</p>    
    <h3>First h3 header</h3>
    <p>Some text</p>    
    <h3>2nd h3 header</h3>
    <p>Some text</p>    
    <h4>First h4 header</h4>
    <p>Some text</p>
    <h4>2nd h4</h4>
    <p>Some text</p>
    <h2>Latest header</h2>

And you have some PostController with show() method which sends your Post model object data to your view.
```php
public function show ($id)
{
    $post = Post::find($id);
    $header = $post->title;
    $body = $post->body;
    return view('post', compact('header', 'body');
}
```

Your 'post.blade.php' view looks stupid simple like this:
```html
<div>
    <h1>{{$header}}</h1>
    {!! $body !!}
</div>
```

This is how you can use this package to generate "Table of contents" in controller:

```php
public function show ($id)
{
    $post = Post::find($id);
    $header = $post->title;

    $toc = new \NikolayOskin\Contents\Contents();
    $body = $toc->fromText($post->body)->getHandledText();
    $contents = $toc->getContentsArray();

    return view('post', compact('header', 'body', 'contents');
}
```

Now you passed "contents" array where your header tags are stored. Also, as you can see you passed "handledText", which has id attributes inside header html tags.

Your view:

```html
<div>
    <h1>{{$header}}</h1>
    @if(!empty($contents))
        @include('nikolay-oskin.contents.table', $contents)
    @endif
    {!! $post !!}
</div>
```

table.blade.php is the view with ul-li tags where you can add your css styles or make any other customization.


## Options
By default contents created for h2-h6 tags. You can set headers tags which have been included in 'Table of contents'.

Example:
```php
public function show ($id)
{
    $post = Post::find($id);

    $toc = new \NikolayOskin\Contents\Contents();
    $toc->fromText($post->body)->setTags(['h2', 'h3']);
    $body = $toc->getHandledText();
    $contents = $toc->getContentsArray(); 

    return view('post', compact('body', 'contents');
    
    // Only h2 and h3 headers will be added to table of contents
}    
```

You can also set text min-length number so if the text length is below this number then $contents array will be empty and $contents->getHandledText() returns original text.

Example:
```php
public function show ($id)
{
    $post = Post::find($id);

    $toc = new \NikolayOskin\Contents\Contents();
    $toc->fromText($post->body)->setTags(['h2', 'h3'])->setMinLength(5000);
    $body = $toc->getHandledText();
    $contents = $toc->getContentsArray();

    return view('post', compact('body', 'contents');
    
    // Table of contents will not be shown for texts length less than 5000 chars.
}    
```

## Install

For Laravel 5.5+

Add to composer.json file:
```json
"repositories": [
    {
      "type": "git",
      "url": "https://github.com/marwan2/tableofcontents.git"
    }
],
```

```json
"require": {
    "marwan2/tableofcontents": "*.*"
},
```

To copy views to your resource/views directory:

```sh
php artisan vendor:publish --provider="NikolayOskin\Contents\ContentsServiceProvider"
```

## License

MIT