<?php
namespace Inml;

/**
 * Interface for render classes
 *
 * @author Petr Trofimov <petrofimov@yandex.ru>
 */
interface Render
{
    public function render(\Inml\Text $text);
}