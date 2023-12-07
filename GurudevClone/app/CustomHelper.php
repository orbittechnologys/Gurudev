<?php

    function uploads($file){
        return env('AZURE_STORAGE_URL').$file;
    }
