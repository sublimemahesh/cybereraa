<?php

use Verot\Upload\Upload;

function store($data, $path, $name, $config = NULL, $options = [])
{
    $options = array_merge(["update" => FALSE, "full_path" => false, "clean" => true], $options);
    if (!$options['full_path']) {
        $path = "$path/";
    }
    $handle = new Upload($data);
    if ($handle->uploaded) {
        $handle->file_new_name_body = $name;
        $handle->dir_auto_create = TRUE;
        $handle->mime_check = TRUE;
        $handle->file_overwrite = TRUE;
        $handle->file_new_name_ext = !$options['update'] ? array_search($handle->file_src_mime, $handle->mime_types) : FALSE;
        if ($config && is_array($config)) {
            foreach ($config as $key => $value) {
                $handle->{$key} = $value;
            }
        }
        $return_content = $handle->process();
        if ($handle->processed) {
            Storage::put($path . $handle->file_dst_name, $return_content);
            if ($options['clean']) {
                $handle->clean();
            }
            return $handle->file_dst_name;
        }

        throw new Error("Error Processing Request", $handle->error);
    }
}