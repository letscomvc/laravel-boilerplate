<?php
namespace App\Support;

class BreadCrumb
{
    const BREADCRUMB_KEY = 'breadcrumb';

    public function title($title)
    {
        $breadcrumb = view()->shared('breadcrumb', []);
        $breadcrumb['title'] = $title;

        view()->share('breadcrumb', $breadcrumb);
        return $this;
    }

    public function link($title, $url = null)
    {
        $breadcrumb = view()->shared('breadcrumb', []);
        $breadcrumb['links'][] = compact('title', 'url');

        view()->share('breadcrumb', $breadcrumb);
        return $this;
    }
}
