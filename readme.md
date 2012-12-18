# inML - inline markup language

*PHP-written script in order to transform inML-formatted text into HTML.*

## Basic inML transformation rules

* 1. Transforms paragraphs into HTML paragraphs:

```html
                   <p>
Paragraph1.            Paragraph1.
              =>   </p>
Paragraph2.        <p>
                       Paragraph2.
                   </p>
```

* 2. Transforms paragraph with style into HTML paragraphs with class:

```html
.style            <p class="style">
Paragraph.   =>       Paragraph.
                  </p>
```

* 3. Transforms lines with style into HTML spans with class:

```html
.style Line        <span class="style">
OR            =>       Line
Line .style        </span>
```

* 4. Transforms words with style into HTML spans with class:

```html
                  <span class="style">
word.style   =>       word
                  </span>
```

* 5. If parser finds styles equal HTML5 tags,
it transforms them to corresponding tags (not classes):

```html
.div.style        <div class="style">
Paragraph.   =>       Paragraph.
                  </div>
```


## Example

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

![Example inML to HTML transformation](https://raw.github.com/ptrofimov/inml/master/examples/example.png)
