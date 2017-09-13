<?php

return [
    'namespace'       => 'App',
    'base_class_name' => \Illuminate\Database\Eloquent\Model::class,
    'output_path'     => public_path(),
    'no_timestamps'   => null,
    'date_format'     => null,
    'connection'      => null,
	'db_types' => [
        'enum' => 'string',
    ],
];