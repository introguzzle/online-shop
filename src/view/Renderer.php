<?php

namespace view;

class Renderer {
    public function render(string $view,
                           bool   $renderLayout = true): string {
        $result = file_get_contents("./../view/$view");

        if ($renderLayout) {
            $layout = file_get_contents("./../view/layouts/layout.html");
            $result = str_replace("{{content}}", $result, $layout);
        }

        $path = "./../view/generated/$view";
        file_put_contents($path, $result);

        return $path;
    }
}