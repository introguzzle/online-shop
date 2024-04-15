<?php

namespace view;

class Renderer {
    public function render(
        string $view,
        string $title = "Application",
        bool   $renderLayout = true
    ): string
    {
        return $this->renderContent(
            "./../view/layouts/layout.phtml",
            $view,
            ["{{{title}}}" => $title],
            $renderLayout
        );
    }

    public function renderContent(
        string $layout,
        string $view,
        array  $replace,
        bool   $renderLayout = true
    ): string
    {
        ob_start();

        $path = "./../view/$view";
        $result = file_get_contents($path);

        if ($renderLayout) {
            $layoutContents = file_get_contents($layout);
            $result = str_replace("{{{content}}}", $result, $layoutContents);

            foreach ($replace as $key => $value) {
                $result = str_replace($key, $value, $result);
            }
        }

        $generatedPath = "./../view/generated/$view";
        file_put_contents($generatedPath, $result);
        ob_flush();

        return $generatedPath;
    }
}