<?php

return [
    "datawarehouse" => env("SC_DATAWAREHOUSE", 'google'),

    "google" => [
        "credentials" => env("SC_DATAWAREHOUSE_GOOGLE_APPLICATION_CREDENTIALS", null),
        "project_id" => env("SC_DATAWAREHOUSE_GOOGLE_QUERY_PROJECT_ID", null),
        "dataset_id" => env("SC_DATAWAREHOUSE_GOOGLE_BIG_QUERY_DATASET_ID", null),
    ]
];
