<?php

collect(glob(__DIR__ . '/web/*.php'))->each(fn($file) => require $file);