<?php

namespace view;

class Renderer {
    public function render(
        string $view,
        string $title = "Application",
        bool   $renderLayout = true
    ): string
    {
        ob_start();
        $result = file_get_contents("./../view/$view");

        if ($renderLayout) {
            $layout = file_get_contents("./../view/layouts/layout.phtml");
            $result = str_replace("{{{content}}}", $result, $layout);
            $result = str_replace("{{{title}}}", $title, $result);
        }

        $path = "./../view/generated/$view";
        file_put_contents($path, $result);
        ob_flush();

        return $path;
    }
}