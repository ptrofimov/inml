# InML - inline markup language

*PHP-written script in order to tranform inML-formatted text into HTML.*

## Basic inML transformation rules

-1. Transforms paragraphs:

```text
Paragraph1.

Paragraph2.
```

into HTML paragraphs:

```html
<p>Paragraph1.</p><p>Paragraph2</p>
```

-2. Transforms paragraph with style:

```text
.style
Paragraph.
```

into HTML paragraphs with class:

```html
<p class="style">Paragraph.</p>
```

-3. Transforms lines with style:

```text
.style Line
OR
Line .style
```

into HTML spans with class:

```html
<span class="style">Line</span>
```

-4. Transforms words with style:

```text
word.style
```

into HTML spans with class:

```html
<span class="style">word</span>
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
