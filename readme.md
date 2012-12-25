# inML - intuitive markup language

*inML is concise and intuitive markup language. This repository contains description of inML markup language
and PHP-written library and example script in order to render inML-formatted text into HTML and Text formats.*

* [Basic inML -> HTML transformation rules](https://github.com/ptrofimov/inml/edit/master/readme.md#basic-inml---html-transformation-rules)
* [Example with screenshots](https://github.com/ptrofimov/inml/edit/master/readme.md#example-with-screenshots)
* [Installation and usage](https://github.com/ptrofimov/inml/edit/master/readme.md#installation-and-usage)

## Basic inML -> HTML transformation rules

* 1. Transforms paragraphs with style into HTML paragraphs with class:

```html
.style            <p class="style">
Paragraph.   =>       Paragraph.
                  </p>
```

* 2. Transforms lines with style into HTML spans with class:

```html
.style Line        <span class="style">
OR            =>       Line
Line .style        </span>
```

* 3. Transforms words with style into HTML spans with class:

```html
                  <span class="style">
word.style   =>       word
                  </span>
```

* 4. If parser finds styles equal HTML5 tags,
it transforms them to corresponding tags (not classes):

```html
.div.style        <div class="style">
Paragraph.   =>       Paragraph.
                  </div>
```

* 5. You can define your own styles right in the document. Parser will automatically recognise type of style. For example, you can make a hyperlink by defining your own style with url:

```html
inML.link is intuitive markup language.        
                                          =>   <a href="https://github.com/ptrofimov/inml">inML</a>
#link https://github.com/ptrofimov/inml            is intuitive markup language.
```

## Example with screenshots

inML-formatted text:

```text
.h1 inML - inline markup language

.i
inML.b is simple and compact markup
that could be easily transformed into HTML.b

.b Key points:

.ul
.li Easy text formatting
.li Traditional embedded HTML.b styles
.li Ability to add user styles
```

transforms into HTML:

```html
<p>
    <h1>inML - inline markup language</h1>
</p>
<i>
    <b>inML</b> is simple and compact markup
        that could be easily transformed into <b>HTML</b>
</i>
<p>
    <b>Key points:</b>
</p>
<ul>
    <li>Easy text formatting</li>
    <li>Traditional embedded <b>HTML</b> styles</li>
    <li>Ability to add user styles</li>
</ul>
```

and looks like this (with predefined CSS styles):

![Example inML to HTML transformation](https://raw.github.com/ptrofimov/inml/master/examples/example.jpg)

## Installation and usage

* 1. Install [composer](http://getcomposer.org/download/) if need.
* 2. Create composer.json or add dependency:

```json
{
   "require":{
       "ptrofimov/inml":"*"
   }
}
```

* 3. Install package:
 
```sh
composer install
```

* 4. Usage example:
 
```php
use \Inml\Text;
use \Inml\Render\Html;

$html = (new Html)->render(new Text($inml));
```

* 5. Enjoy!
