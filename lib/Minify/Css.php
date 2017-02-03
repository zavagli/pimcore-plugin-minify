<?php

namespace Minify;

class Css extends Core
{
    protected function getDebug()
    {
        $ts = time();
        $out = "\n<!-- Minify-Css BEGIN [DEBUG] -->\n";
        foreach ($this->filenames as $filename) {
            $out .= 
                '  <link href="'.$filename.'?ts='.$ts.'" rel="stylesheet">' . "\n";
        }
        $out .= "<!-- Minify-Css END [DEBUG] -->\n";
        return $out;
    }

    protected function getMinified()
    {
        
        if (!$this->existsMinifiedFile()) {
            
            $cssCode = '';
    
            $options = [];
            $options['docRoot'] = PIMCORE_DOCUMENT_ROOT;
    
            foreach ($this->filenames as $filename) {
                $cssCodeRaw = file_get_contents(PIMCORE_DOCUMENT_ROOT . $filename);
                $options['currentDir'] = dirname(PIMCORE_DOCUMENT_ROOT . $filename);
                $cssCode .=  \Minify_CSS::minify($cssCodeRaw, $options)."\n";
            }
    
            $this->writeMinifiedFile($cssCode);
        }

        $out = "\n<!-- Minify-Css BEGIN -->\n";
        $out .= 
            '  <link href="'.$this->getMinifiedUrl().'" rel="stylesheet">' . "\n";
        $out .= "<!-- Minify-Css END -->\n";
        return $out;
    }
}
