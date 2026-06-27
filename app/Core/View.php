<?php

declare(strict_types=1);

namespace WellySongket\Core;

use RuntimeException;

final class View
{
    public function render(
        string $view,
        array $data = [],
        string $layout = 'front'
    ): string {

        $viewFile = BASE_PATH
            . '/app/Views/'
            . $view
            . '.php';

        if (!is_file($viewFile)) {
            throw new RuntimeException(
                "View [$view] not found."
            );
        }

        // Extract data but protect internal variable name
        extract($data, EXTR_SKIP);

        ob_start();

        require $viewFile;

        // Use a non-conflicting name for the rendered view HTML
        $__viewContent__ = ob_get_clean();

        $layoutFile = BASE_PATH
            . '/app/Views/layouts/'
            . $layout
            . '.php';

        if (!is_file($layoutFile)) {
            return (string) $__viewContent__;
        }

        // Make it available as $content inside the layout
        $content = $__viewContent__;

        ob_start();

        require $layoutFile;

        return (string) ob_get_clean();
    }
}
