<?php

declare(strict_types=1);

namespace WellySongket\Core;

abstract class Controller
{
    protected Request $request;

    protected Response $response;

    protected View $view;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->view = new View();
    }

    protected function render(
        string $view,
        array $data = [],
        string $layout = 'front'
    ): never {
        $content = $this->view->render(
            $view,
            $data,
            $layout
        );

        $this->response->html($content);
    }

    protected function json(array $data): never
    {
        $this->response->json($data);
    }

    protected function redirect(string $url): never
    {
        $this->response->redirect($url);
    }

    protected function back(): never
    {
        $this->response->back();
    }
}