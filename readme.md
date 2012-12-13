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

## Example

inML-formatted text:

```text
.h1 inML - inline markup language

.i inML.b is simple and compact markup that could be easily transformed into HTML.b

.b Key points:

.ul
.li Easy text formatting
.li Traditional embedded HTML.b styles
.li Ability to add user styles
```

transforms into HTML:

```html
<p>
    <span class="h1">inML - inline markup language</span>
</p>
<p>
    <span class="i"><span class="b">inML</span> is simple and compact markup that could be easily transformed into <span class="b">HTML</span></span>
</p>
<p>
    <span class="b">Key points:</span>
</p>
<p class="ul">
    <span class="li">Easy text formatting</span>
    <span class="li">Traditional predefined <span class="b">HTML</span> styles</span>
    <span class="li">Ability to add user styles</span>
</p>
```

and looks like this (with predefined CSS styles):

![Example inML to HTML transformation](https://raw.github.com/ptrofimov/inml/master/examples/example.png)
