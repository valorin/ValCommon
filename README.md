ValCommon
=========

ZF2 Common Tools Module

## LESS CSS Compiler

Append the URL with '?compileCss=1' to initiate the LESS CSS compile process.
Configuration is done in the config 'valcommon' section:

    'valcommon' => Array(
        'css' => Array(
            'less' => __DIR__ . "/../../../public/css/styles.less",
            'css'  => __DIR__ . "/../../../public/css/styles.css",
        ),
    ),
