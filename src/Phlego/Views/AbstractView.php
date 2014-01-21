<?php

namespace Phlego\Views;

use Phlego\Views\Commands;
use Phlego\Exceptions\PhlegoException;

/**
* AbstractView class
*
* @package default
* @author ilpaijin <ilpaijin@gmail.com>
*/
abstract class AbstractView 
{
    protected $properties = array();

    private $commands;

    abstract public function addView(AbstractView $view);

    abstract public function removeView(AbstractView $view);

    public function __construct($template = NULL,  array $data = array())
    {
        $this->setTemplate($template ?: $this->template);

        if(!empty($data))
        {
            foreach($data as $name => $value)
            {
                $this->properties[$name] = $value;
            }
        }    

        $this->commands = new Commands();   

    }

    public function setTemplate($template)
    {
        $template = $this->path.DS.$template.".phlego.php";

        if(!file_exists($template))
        {
            throw new PhlegoException("The template file doesn't exists!");
        }

        $this->template = $template;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    protected function parseTemplate($template)
    {
        $pattern = "/{{(.*?)\s(.*?)}}/";

        $repl = preg_replace_callback($pattern, array($this, 'parseCommands'), $template);

        return $repl;
    }

    public function parseCommands($matches)
    {
        
        array_shift($matches);

        $result = '';
        
        if(class_exists(__NAMESPACE__."\\".ucfirst($matches[0])))
        {
            $partial = __NAMESPACE__."\\".ucfirst($matches[0]);
            $this->addView(new $partial($matches[1]));
        }

        if(in_array($matches[0], array("=")))
        {
            $result = "<?php echo ". trim($matches[1]) . "; ?>";
            return $this->parseTemplate($result);
        }   
    }

    public function render()
    {
        if($this->template)
        {            
            extract($this->properties);
            $tpl = file_get_contents($this->template);

            return $this->parseTemplate($tpl);
            
        }
    }
}