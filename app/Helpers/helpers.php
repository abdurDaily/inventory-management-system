<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('generateBreadcrumbs')) {
    function generateBreadcrumbs()
    {
        $segments = Request::segments(); // Get URL segments
        $url = '';
        $breadcrumbHtml = '<nav><a href="' . url('/') . '">Home</a>';

        foreach ($segments as $key => $segment) {
            $url .= '/' . $segment;
            $segmentName = ucfirst(str_replace('-', ' ', $segment)); // Format segment name

            if ($key == count($segments) - 1) {
                $breadcrumbHtml .= ' > <span>' . $segmentName . '</span>';
            } else {
                $breadcrumbHtml .= ' > <a href="' . url($url) . '">' . $segmentName . '</a>';
            }
        }

        $breadcrumbHtml .= '</nav>';
        return $breadcrumbHtml;
    }
}
