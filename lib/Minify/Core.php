<?php

namespace Minify;

abstract class Core 
{

    const FORCE_REFRESH = 'MINIFY_REFRESH'; 

    protected $filenames = [];
    protected $errors = [];
    
    private $suffix = null;

    public function add($filename)
    {
        if ($this->suffix === null) {
            $this->suffix = pathinfo($filename, PATHINFO_EXTENSION);
        }
        
        if (file_exists(PIMCORE_DOCUMENT_ROOT . $filename)) {
            $this->filenames[] = $filename;
        } else {
            $this->errors[$filename] = "File does not exist.";
        }
        return $this;
    }

    public function get()
    {
        if (\Pimcore::inDebugMode()) {
            return $this->getDebug();
        }
        return $this->getMinified();
    }

    abstract protected function getMinified();
    abstract protected function getDebug();

    /**
     * determine the cache key based on the filenames
     */
    protected function getCacheKey()
    {
         return md5(implode($this->filenames));
    }

    protected function getFilename()
    {
        return "plugin_minify_" . $this->getCacheKey() . "." . $this->suffix;
    }

    protected function getMinifiedPath()
    {
        return PIMCORE_TEMPORARY_DIRECTORY . '/' . $this->getFilename();
    }

    protected function getMinifiedUrl()
    {
        return PIMCORE_TEMPORARY_DIRECTORY . $this->getFilename();
    }

    /**
     * determine the cache key based on the filenames
     */
    protected function existsMinifiedFile()
    {
        // regenerate always, if we get the force parameter ..
        if (array_key_exists(self::FORCE_REFRESH, $_REQUEST)) {
            return false;
        }
        return (file_exists($this->getMinifiedPath()));
    }

    protected function writeMinifiedFile($fileContent)
    {
        file_put_contents($this->getMinifiedPath(), $fileContent);
    }
}
