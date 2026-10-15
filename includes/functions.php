<?php
require_once __DIR__ . '/../config/database.php';

function e($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string {
    $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    $base = ($scriptDir === '/' || $scriptDir === '\\') ? '' : rtrim(str_replace('\\', '/', $scriptDir), '/');

    $base = preg_replace('#/(includes|templates|config)$#', '', $base);

    $cleanPath = ltrim($path, '/');
    if ($cleanPath === '') {
        return $base !== '' ? $base : '/';
    }

    return ($base !== '' ? $base . '/' : '/') . $cleanPath;
}

function course_url(string $slug): string {
    $encodedSlug = rawurlencode($slug);
    if (defined('ENABLE_CLEAN_URLS') && ENABLE_CLEAN_URLS) {
        return base_url('courses/' . $encodedSlug);
    }
    return base_url('course-details.php?slug=' . $encodedSlug);
}

function format_price($price, bool $asHtml = true): string {
    $numeric = (float)($price ?? 0);
    if ($numeric <= 0.001) {
        return $asHtml 
            ? '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Free</span>'
            : 'Free';
    }
    $formatted = CURRENCY_SYMBOL . number_format($numeric, 2);
    return $asHtml ? '<span class="fw-bold text-primary">' . e($formatted) . '</span>' : $formatted;
}

function truncate_text(string $text, int $limit = 120): string {
    $stripped = strip_tags($text);
    if (mb_strlen($stripped) <= $limit) {
        return $stripped;
    }
    $cut = mb_substr($stripped, 0, $limit);
    $lastSpace = mb_strrpos($cut, ' ');
    if ($lastSpace !== false) {
        $cut = mb_substr($cut, 0, $lastSpace);
    }
    return $cut . '...';
}

function get_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function set_flash(string $type, string $message): void {
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }
    $_SESSION['flash'][$type] = $message;
}

function get_flash(string $type): ?string {
    if (isset($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $msg;
    }
    return null;
}

function get_all_categories(): array {
    $db = get_db_connection();
    $sql = "SELECT c.id, c.name, c.slug, c.description, c.icon,
                   COUNT(CASE WHEN co.status = 'published' THEN 1 END) AS course_count
            FROM categories c
            LEFT JOIN courses co ON c.id = co.category_id
            WHERE c.status = 'active'
            GROUP BY c.id, c.name, c.slug, c.description, c.icon
            ORDER BY c.name ASC";
    $stmt = $db->query($sql);
    return $stmt->fetchAll();
}

function get_category_by_slug(string $slug): ?array {
    $db = get_db_connection();
    $stmt = $db->prepare("SELECT * FROM categories WHERE slug = :slug AND status = 'active' LIMIT 1");
    $stmt->execute([':slug' => $slug]);
    $cat = $stmt->fetch();
    return $cat ?: null;
}

function get_featured_courses(int $limit = 4): array {
    $db = get_db_connection();
    $sql = "SELECT co.*, c.name AS category_name, c.slug AS category_slug
            FROM courses co
            LEFT JOIN categories c ON co.category_id = c.id
            WHERE co.status = 'published' AND co.is_featured = 1
            ORDER BY co.id ASC
            LIMIT :limit";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_published_courses(?int $categoryId = null): array {
    $db = get_db_connection();
    $params = [];
    $sql = "SELECT co.*, c.name AS category_name, c.slug AS category_slug
            FROM courses co
            LEFT JOIN categories c ON co.category_id = c.id
            WHERE co.status = 'published'";

    if ($categoryId !== null && $categoryId > 0) {
        $sql .= " AND co.category_id = :cat_id";
        $params[':cat_id'] = $categoryId;
    }

    $sql .= " ORDER BY co.created_at DESC, co.id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_course_by_slug(string $slug): ?array {
    $db = get_db_connection();
    $sql = "SELECT co.*, c.name AS category_name, c.slug AS category_slug
            FROM courses co
            LEFT JOIN categories c ON co.category_id = c.id
            WHERE co.slug = :slug AND co.status = 'published'
            LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->execute([':slug' => $slug]);
    $course = $stmt->fetch();
    return $course ?: null;
}

function get_related_courses(int $categoryId, int $currentCourseId, int $limit = 3): array {
    $db = get_db_connection();
    $sql = "SELECT co.*, c.name AS category_name, c.slug AS category_slug
            FROM courses co
            LEFT JOIN categories c ON co.category_id = c.id
            WHERE co.category_id = :category_id 
              AND co.id != :current_id 
              AND co.status = 'published'
            ORDER BY RAND()
            LIMIT :limit";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
    $stmt->bindValue(':current_id', $currentCourseId, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function save_contact_message(array $data): bool {
    $db = get_db_connection();
    $sql = "INSERT INTO contact_messages (name, email, subject, message, ip_address)
            VALUES (:name, :email, :subject, :message, :ip)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([
        ':name'    => mb_substr(trim($data['name'] ?? ''), 0, 120),
        ':email'   => mb_substr(trim($data['email'] ?? ''), 0, 190),
        ':subject' => mb_substr(trim($data['subject'] ?? ''), 0, 200),
        ':message' => trim($data['message'] ?? ''),
        ':ip'      => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
    ]);
}
