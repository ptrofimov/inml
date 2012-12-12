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
