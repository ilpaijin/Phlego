<?php

namespace Phlego\Views;

/**
* SimpleView class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
class Template extends AbstractView
{
    protected $template = "default";
    protected $path = "views/templates";

    private $views = array();

    public static function factory($view, array $data = array())
    {
        return new self($view, $data);
    }

    public function addView(AbstractView $view)
    {
        if(!in_array($view, $this->views))
        {
            $this->views[] = $view;
        }
    }

    public function removeView(AbstractView $view)
    {
        if(in_array($view, $this->views))
        {
            $views = array();

            foreach ($this->views as $v) 
            {
                if($v !== $view)
                {
                    $views[] = $v;
                }
            }

            $this->views = $views;
        }

        return $this;
    }

    public function render()
    {
        $innerView = '';

        if(!empty($this->views))
        {   
            foreach($this->views as $view)
            {
                $innerView .= $view->render();
            }

            $this->properties = $innerView;
        }

        $compositeView = parent::render();

        return !empty($compositeView) ? $compositeView : $innerView ;
    }
}