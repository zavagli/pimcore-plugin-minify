<?php

namespace Minify;

class Js extends Core
{

    protected function getDebug()
    {
        $ts = time();
        $out = "\n<!-- Minify-Js BEGIN [DEBUG] -->\n";
        foreach ($this->filenames as $filename) {
            $out .= 
                '  <script src="'.$filename.'?ts='.$ts.'"></script>' . "\n";
        }
        $out .= "<!-- Minify-Js END [DEBUG] -->\n";
        return $out;
    }

    protected function getMinified()
    {
        if (!$this->existsMinifiedFile()) {

            $jsCode = '';
            foreach ($this->filenames as $filename) {
                $jsCode .= file_get_contents(PIMCORE_DOCUMENT_ROOT . $filename)."\n";
            }
    
            $jsCode = \JSMin::minify($jsCode);
            $this->writeMinifiedFile($jsCode);
        }

        $out = "\n<!-- Minify-Js BEGIN -->\n";
        $out .= 
            '  <script src="'.$this->getMinifiedUrl().'" type="text/javascript"></script>' . "\n";
        $out .= "<!-- Minify-Js END -->\n";
        return $out;
    }
}
