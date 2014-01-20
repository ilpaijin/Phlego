<?php

namespace Phlego\Views;

use Phlego\Views\AbstractView;
use Phlego\Exceptions\PhlegoException;

/**
* Partial class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Partial extends AbstractView
{
    protected $template;
    protected $path = "views/partials";

    public function addView(AbstractView $view)
    {
        throw new PhlegoException("A partial cannot add another view");
    }

    public function removeView(AbstractView $view)
    {
        throw new PhlegoException("A partial cannot remove another view");
    }
}