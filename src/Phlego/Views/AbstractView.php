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

    public function __construct($template = NULL,  array $data = array())
    {
        $this->setTemplate($template ?: $this->template);

        if(!empty($data))
        {
            foreach($data as $name => $value)
            {
                $this->$name = $value;
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

    public function __set($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function __get($name)
    {
        if(!isset($this->properties[$name]))
        {
            throw new PhlegoException("Property not valid!");
        }

        return $this->properties[$name];
    }

    public function __unset($name)
    {
        if(isset($this->properties[$name]))
        {
            unset($this->properties[$name]);
        }
    }

    abstract public function addView(AbstractView $view);

    abstract public function removeView(AbstractView $view);

    private function parseTemplate($template)
    {
        // var_dump($template);

        $pattern = "/{{(.*?)\s(.*?)}}/";

        $repl = preg_replace_callback($pattern, array($this, 'parseCommands'), $template);

        return $repl;
    }

    public function parseCommands($matches)
    {
        
        array_shift($matches);

        // var_dump($matches);

        $result = '';
        
        if(class_exists(__NAMESPACE__."\\".ucfirst($matches[0])))
        {
            $partial = __NAMESPACE__."\\".ucfirst($matches[0]);
            $this->addView(new $partial($matches[1]));
        }

        if(in_array($matches[0], array("=")))
        {
            $result = "<?php echo ". $matches[1] . "; ?>";
            return $this->parseTemplate($result);
        }   
    }

    public function render()
    {
        if($this->template)
        {
            extract($this->properties);
            ob_start();
            $tpl = file_get_contents($this->template);
            var_dump($this->parseTemplate($tpl));
            echo $this->parseTemplate($tpl);
            return ob_get_clean();
        }
    }
}