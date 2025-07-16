<?php
/**
 * Helper Class - Các hàm tiện ích
 * Chứa các hàm helper được sử dụng trong toàn bộ ứng dụng
 */

class Helper {
    
    /**
     * Tạo URL từ string
     * @param string $url
     * @return string
     */
    public static function url($url = '') {
        return BASE_URL . ltrim($url, '/');
    }
    public static function redirect($path = '') {
        header('Location: ' . self::url($path));
        exit;
    }
    /**
     * Tạo URL cho asset
     * @param string $path
     * @return string
     */
    public static function asset($path) {
        return BASE_URL . 'assets/' . ltrim($path, '/');
    }
    
    /**
     * Tạo URL cho upload
     * @param string $path
     * @return string
     */
    public static function upload($path) {
        return UPLOAD_URL . ltrim($path, '/');
    }
    
    /**
     * Escape HTML
     * @param string $string
     * @return string
     */
    public static function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Tạo slug từ string
     * @param string $string
     * @return string
     */
    public static function slug($string) {
        // Chuyển về chữ thường
        $string = strtolower($string);
        
        // Chuyển đổi ký tự có dấu
        $string = self::removeAccents($string);
        
        // Thay thế ký tự không phải chữ cái, số bằng dấu gạch ngang
        $string = preg_replace('/[^a-z0-9]+/', '-', $string);
        
        // Xóa dấu gạch ngang ở đầu và cuối
        $string = trim($string, '-');
        
        return $string;
    }
    
    /**
     * Xóa dấu tiếng Việt
     * @param string $string
     * @return string
     */
    public static function removeAccents($string) {
        $accents = [
            'à', 'á', 'ạ', 'ả', 'ã', 'â', 'ầ', 'ấ', 'ậ', 'ẩ', 'ẫ', 'ă', 'ằ', 'ắ', 'ặ', 'ẳ', 'ẵ',
            'è', 'é', 'ẹ', 'ẻ', 'ẽ', 'ê', 'ề', 'ế', 'ệ', 'ể', 'ễ',
            'ì', 'í', 'ị', 'ỉ', 'ĩ',
            'ò', 'ó', 'ọ', 'ỏ', 'õ', 'ô', 'ồ', 'ố', 'ộ', 'ổ', 'ỗ', 'ơ', 'ờ', 'ớ', 'ợ', 'ở', 'ỡ',
            'ù', 'ú', 'ụ', 'ủ', 'ũ', 'ư', 'ừ', 'ứ', 'ự', 'ử', 'ữ',
            'ỳ', 'ý', 'ỵ', 'ỷ', 'ỹ',
            'đ'
        ];
        
        $noAccents = [
            'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'd'
        ];
        
        return str_replace($accents, $noAccents, $string);
    }
    
    /**
     * Format tiền tệ
     * @param float $amount
     * @param string $currency
     * @return string
     */
    public static function formatMoney($amount, $currency = 'VND') {
        if ($currency === 'VND') {
            return number_format($amount, 0, ',', '.') . ' ₫';
        }
        
        return number_format($amount, 2, '.', ',') . ' ' . $currency;
    }
    
    /**
     * Format ngày tháng
     * @param string $date
     * @param string $format
     * @return string
     */
    public static function formatDate($date, $format = 'd/m/Y H:i') {
        return date($format, strtotime($date));
    }
    
    /**
     * Cắt chuỗi
     * @param string $string
     * @param int $length
     * @param string $suffix
     * @return string
     */
    public static function truncate($string, $length = 100, $suffix = '...') {
        if (strlen($string) <= $length) {
            return $string;
        }
        
        return substr($string, 0, $length) . $suffix;
    }
    
    /**
     * Tạo breadcrumb
     * @param array $items
     * @return string
     */
    public static function breadcrumb($items) {
        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        
        $count = count($items);
        $i = 1;
        
        foreach ($items as $title => $url) {
            if ($i === $count) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . self::e($title) . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item"><a href="' . self::url($url) . '">' . self::e($title) . '</a></li>';
            }
            $i++;
        }
        
        $html .= '</ol></nav>';
        return $html;
    }
    
    /**
     * Tạo pagination
     * @param array $pagination
     * @param string $baseUrl
     * @return string
     */
    public static function pagination($pagination, $baseUrl) {
        if ($pagination['last_page'] <= 1) {
            return '';
        }
        
        $html = '<nav aria-label="Pagination"><ul class="pagination justify-content-center">';
        
        // Previous button
        if ($pagination['current_page'] > 1) {
            $prevPage = $pagination['current_page'] - 1;
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . $prevPage . '">Trước</a></li>';
        }
        
        // Page numbers
        $start = max(1, $pagination['current_page'] - 2);
        $end = min($pagination['last_page'], $pagination['current_page'] + 2);
        
        for ($i = $start; $i <= $end; $i++) {
            $active = ($i === $pagination['current_page']) ? ' active' : '';
            $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a></li>';
        }
        
        // Next button
        if ($pagination['current_page'] < $pagination['last_page']) {
            $nextPage = $pagination['current_page'] + 1;
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . $nextPage . '">Sau</a></li>';
        }
        
        $html .= '</ul></nav>';
        return $html;
    }
    
    /**
     * Debug - dump and die
     * @param mixed $data
     */
    public static function dd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
    
    /**
     * Tạo CSRF token
     * @return string
     */
    public static function generateCsrfToken() {
        $token = bin2hex(random_bytes(32));
        Session::set('csrf_token', $token);
        return $token;
    }
    
    /**
     * Kiểm tra CSRF token
     * @param string $token
     * @return bool
     */
    public static function verifyCsrfToken($token) {
        $sessionToken = Session::get('csrf_token');
        return $sessionToken && hash_equals($sessionToken, $token);
    }
    
    /**
     * Tạo random string
     * @param int $length
     * @return string
     */
    public static function randomString($length = 10) {
        return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }
}
?>
