<?php
/**
 * Response Utility
 * Handles API response formatting
 */

class Response
{
    /**
     * Send success response
     */
    public function success(array $data, int $code = 200): void
    {
        http_response_code($code);
        
        $response = [
            'code' => (string)$code,
            'message' => $this->getStatusMessage($code),
            'timestamp' => date('c')
        ];
        
        // Merge with provided data
        $response = array_merge($response, $data);
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    /**
     * Send error response
     */
    public function error(string $message, int $code = 400, ?string $error = null): void
    {
        http_response_code($code);
        
        $response = [
            'code' => (string)$code,
            'message' => $message,
            'timestamp' => date('c')
        ];
        
        if ($error) {
            $response['error'] = $error;
        }
        
        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    /**
     * Send JSON response
     */
    public function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }
    
    /**
     * Get status message by code
     */
    private function getStatusMessage(int $code): string
    {
        $messages = [
            200 => 'Data berhasil diambil',
            201 => 'Data berhasil dibuat',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Data tidak ditemukan',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable'
        ];
        
        return $messages[$code] ?? 'Unknown Status';
    }
    
    /**
     * Validate required parameters
     */
    public function validateRequired(array $data, array $required): bool
    {
        foreach ($required as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->error("Field '{$field}' is required", 422);
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Paginate data
     */
    public function paginate(array $data, int $page = 1, int $limit = 20): array
    {
        $total = count($data);
        $offset = ($page - 1) * $limit;
        $paginatedData = array_slice($data, $offset, $limit);
        
        return [
            'data' => $paginatedData,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $total,
                'total_pages' => ceil($total / $limit),
                'has_next' => $page < ceil($total / $limit),
                'has_prev' => $page > 1
            ]
        ];
    }
}

?>