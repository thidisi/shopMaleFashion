<?php

/**
 *
 * Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url.
 *
 * @access    public
 * @param    string
 * @return    string
 */
if (!function_exists('currency_format')) {
    function currency_format($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
}

if (!function_exists('getWebURL')) {
    /**
     * Build web url with query params
     *
     * @param string $segment
     * @param array $queryParams
     * @return string
     */
    function getWebURL(string $segment, array $queryParams = [])
    {
        $queryString = http_build_query($queryParams);
        return config('app.url') . $segment . ($queryString ? '?' . http_build_query($queryParams) : '');
    }
}

if (!function_exists('checkPermissionToRedirect')) {
    function checkPermissionToRedirect($permission = 'staff')
    {
        if (auth()->user()->level != 'admin') {
            if ($permission == 'manager' && auth()->user()->level == 'manager') {
                return true;
            }
            return false;
        }
        return true;
    }
}
