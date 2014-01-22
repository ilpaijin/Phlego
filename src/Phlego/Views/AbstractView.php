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
    /**
     * [$properties description]
     * @var array
     */
    protected $properties = array();

    /**
     * [$commands description]
     * @var [type]
     */
    private $commands;

    /**
     * [$prefix description]
     * @var string
     */
    protected $prefix = ".phlego.php";

    /**
     * [addView description]
     * @param AbstractView $view [description]
     */
    abstract public function addView(AbstractView $view);

    /**
     * [removeView description]
     * @param  AbstractView $view [description]
     * @return [type]             [description]
     */
    abstract public function removeView(AbstractView $view);

    /**
     * [__construct description]
     * @param [type] $template [description]
     * @param array  $data     [description]
     */
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

    /**
     * [setTemplate description]
     * @param [type] $template [description]
     */
    public function setTemplate($template)
    {
        $template = $this->path.DS.$template.$this->prefix;

        if(!is_file($template) || !is_readable($template))
        {
            throw new PhlegoException("The template file doesn't exists!");
        }

        $this->template = $template;
    }

    /**
     * [getTemplate description]
     * @return [type] [description]
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * [parseTemplate description]
     * @param  [type] $template [description]
     * @return [type]           [description]
     */
    protected function parseTemplate($template)
    {
        $pattern = "/{{(.*?)\s(.*?)}}/";

        $repl = preg_replace_callback($pattern, array($this, 'parseCommands'), $template);

        return !empty($repl) ? $repl : false;
    }

    /**
     * [parseCommands description]
     * @param  [type] $matches [description]
     * @return [type]          [description]
     */
    public function parseCommands($matches)
    {
        
        array_shift($matches);

        $result = '';

        if($matches[0] == "partial")
        {
            $p = file_get_contents('views/partials/'.DS.$matches[1].$this->prefix);
            var_dump($p);
            var_dump($this->parseTemplate($p));
        }
        
        
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

    /**
     * [render description]
     * @return [type] [description]
     */
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