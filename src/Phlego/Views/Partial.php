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
    /**
     * [$template description]
     * @var [type]
     */
    protected $template;
    
    /**
     * [$path description]
     * @var string
     */
    protected $path = "views/partials";

    /**
     * [addView description]
     * @param AbstractView $view [description]
     */
    public function addView(AbstractView $view)
    {
        parent::addView($view);
    }

    /**
     * [removeView description]
     * @param  AbstractView $view [description]
     * @return [type]             [description]
     */
    public function removeView(AbstractView $view)
    {
        throw new PhlegoException("A partial cannot remove another view");
    }
}