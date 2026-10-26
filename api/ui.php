<?php
// Server-Driven UI endpoint: the server decides which components and data the client renders.
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
    $stmt = $pdo->query("SELECT p.id, p.specialization, p.title, p.description, p.consultation_price, u.full_name FROM provider_profiles p JOIN users u ON u.id = p.user_id WHERE u.status = 'active' ORDER BY p.id DESC");
    $providers = $stmt->fetchAll();

    $providerCards = [];
    foreach ($providers as $provider) {
        $providerCards[] = [
            'type' => 'provider_card',
            'id' => (int)$provider['id'],
            'specialization' => (string)$provider['specialization'],
            'title' => (string)$provider['title'],
            'name' => (string)$provider['full_name'],
            'description' => (string)$provider['description'],
            'price' => number_format((float)$provider['consultation_price'], 2),
            'action' => ['label' => 'عرض المواعيد', 'href' => 'provider.php?id=' . (int)$provider['id']]
        ];
    }

    $isLoggedIn = user() !== null;
    $schema = [
        'version' => 1,
        'page' => 'home',
        'language' => 'ar',
        'direction' => 'rtl',
        'components' => [
            [
                'type' => 'hero',
                'tag' => 'حجوزات أسهل • وقت أقل',
                'title' => 'احجزي استشارتك بكل سهولة',
                'text' => 'COSULTA منصة لتنظيم المواعيد والاستشارات، تتيح لك البحث عن مقدمي الخدمات واستعراض الأسعار والمواعيد المتاحة وحجز موعدك إلكترونياً.',
                'action' => ['label' => 'ابدئي الآن', 'href' => $isLoggedIn ? 'providers.php' : 'register.php']
            ],
            ['type' => 'heading', 'text' => 'مقدمو الخدمات'],
            count($providerCards) > 0
                ? ['type' => 'provider_grid', 'items' => $providerCards]
                : ['type' => 'empty_state', 'title' => 'أهلاً بك في COSULTA', 'text' => 'لا توجد ملفات لمقدمي الخدمة بعد. سجلي حساباً واختاري نوع الحساب «مقدم خدمة» لإضافة ملفك.']
        ]
    ];
    echo json_encode(['success' => true, 'ui' => $schema], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'تعذر تحميل الواجهة حالياً. تأكدي من اتصال قاعدة البيانات.'], JSON_UNESCAPED_UNICODE);
}
