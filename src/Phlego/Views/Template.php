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
    /**
     * [$template description]
     * @var string
     */
    protected $template = "default";
    
    /**
     * [$path description]
     * @var string
     */
    protected $path = "views/templates";
    
    /**
     * [$cachedPath description]
     * @var string
     */
    public $cachedPath = 'views/cached/';

    /**
     * [$views description]
     * @var array
     */
    private $views = array();

    /**
     * [addView description]
     * @param AbstractView $view [description]
     */
    public function addView(AbstractView $view)
    {
        if(!in_array($view, $this->views))
        {
            $this->views[] = $view;
        }
    }

    /**
     * [removeView description]
     * @param  AbstractView $view [description]
     * @return [type]             [description]
     */
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

    /**
     * [render description]
     * @return [type] [description]
     */
    public function render()
    {
        $cachedFile = $this->cachedPath.substr($this->template, strrpos($this->template, '/'));

        ob_start();

        extract($this->properties);

        // if(file_exists($cachedFile))
        // {
        //     include $cachedFile;

        //     return ob_get_clean();
        // }

        $comm = $this->parseTemplate(file_get_contents($this->template));

        $innerView = "";

        if(!empty($this->views))
        {   
            foreach($this->views as $view)
            {
                $innerView .= $view->render();
            }
        }

        

        file_put_contents($cachedFile, $innerView);

        include $cachedFile;

        return ob_get_clean();
    }
}