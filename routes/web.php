<?php

collect(glob(__DIR__ . '/*/*.php'))->each(fn($file) => require $file);
