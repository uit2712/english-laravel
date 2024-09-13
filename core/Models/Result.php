<?php

namespace Core\Models;

class Result
{
    public $success = false;
    public $message = '';
    public $data = null;

    /**
     * @param Result $source Source.
     */
    public function copyWithoutData($source)
    {
        if (null == $source) {
            return;
        }

        $this->success = $source->success;
        $this->message = $source->message;
    }
}
