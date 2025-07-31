<?php
// Загружаем все роуты из папки routes/product/
collect(glob(__DIR__ . '/product/*.php'))->each(fn($file) => require $file);
